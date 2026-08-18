<?php
/**
 * Convert install/schema.sql (MySQL DDL) to PostgreSQL DDL.
 * Usage: php convert_schema_to_pg.php [in] [out]
 * Warns on any column type it does not recognize so nothing silently passes through.
 */

$in   = $argv[1] ?? __DIR__ . '/schema.sql';
$out  = $argv[2] ?? __DIR__ . '/schema.postgres.sql';
$seedFile = null;
foreach (array_slice($argv, 3) as $arg) {
    if (strpos($arg, '--seeds=') === 0) { $seedFile = substr($arg, 8); }
}

$sql = file_get_contents($in);
// Statement-level split on ; at end of line (schema uses one statement per ; line-ending)
$stmts = array_filter(array_map('trim', preg_split('/;\s*\n/', $sql)));

$output = array("-- RolandERP schema for PostgreSQL (converted from schema.sql)\n");
$indexes = array();      // deferred CREATE INDEX statements
$touchTables = array();  // tables needing ON UPDATE CURRENT_TIMESTAMP trigger
$serials = array();      // [table, column] pairs for setval fix-ups
$warned = array();

$typeMap = array(
    'int\((\d+)\)\s+unsigned'  => 'integer',
    'bigint\((\d+)\)\s+unsigned' => 'bigint',
    'smallint\((\d+)\)\s+unsigned' => 'smallint',
    'int\((\d+)\)'             => 'integer',
    'bigint\((\d+)\)'          => 'bigint',
    'tinyint\((\d+)\)'         => 'smallint',
    'smallint\((\d+)\)'        => 'smallint',
    'mediumint\((\d+)\)'       => 'integer',
    '\bblob\b'                 => 'text',
    '\bdouble\b'               => 'double precision',
    '\bfloat\b'                => 'real',
    '\bdatetime\b'             => 'timestamp',
    '\bmediumtext\b'           => 'text',
    '\blongtext\b'             => 'text',
    '\btinytext\b'             => 'text',
    'enum\([^)]+\)(\s+CHARACTER SET \w+)?(\s+COLLATE \w+)?' => 'varchar(100)',
);

// PostgreSQL reserved words used as column names by this schema.
// Quoting keeps the lowercase name, so normal unqualified/qualified app references still work.
$reserved = array('user', 'order', 'language');

// Columns whose app usage is integer-epoch despite the MySQL timestamp type.
$colOverrides = array(
    'tbl_users.online_time' => 'bigint DEFAULT 0',
    // seeds from the base schema predate these migration-added columns
    'tbl_working_days.start_hours' => "varchar(20) NOT NULL DEFAULT '00:00:00'",
    'tbl_working_days.end_hours'   => "varchar(20) NOT NULL DEFAULT '00:00:00'",
);

function quote_cols($list, $reserved) {
    $out = array();
    foreach (explode(',', $list) as $c) {
        $c = strtolower(trim($c, " \t`"));
        $c = preg_replace('/\(\d+\)$/', '', $c); // strip index prefix lengths, invalid in pg
        $out[] = in_array($c, $reserved) ? '"' . $c . '"' : $c;
    }
    return implode(', ', $out);
}

foreach ($stmts as $stmt) {
    if ($stmt === '' || preg_match('/^SET\s+FOREIGN_KEY_CHECKS/i', $stmt)) { continue; }
    if (stripos($stmt, 'SET NAMES') === 0) {
        $output[] = "SET client_encoding = 'UTF8';";
        continue;
    }
    if (stripos($stmt, 'CREATE TABLE') === 0) {
        if (!preg_match('/CREATE TABLE (?:IF NOT EXISTS )?`?(\w+)`?\s*\((.*)\)\s*ENGINE=[^;]*$/is', $stmt, $m)) {
            $warned[] = "unparsed CREATE TABLE: " . substr($stmt, 0, 60);
            continue;
        }
        $table = strtolower($m[1]);
        $body = $m[2];
        // split columns on commas at top level (no functions with commas expected in DDL defs)
        $parts = array_map('trim', explode("\n", $body));
        $cols = array();
        $pk = '';
        foreach ($parts as $line) {
            $line = trim($line, " \t,");
            if ($line === '') continue;
            if (preg_match('/^PRIMARY KEY \(([^)]+)\)$/i', $line, $pm)) {
                $pk = 'PRIMARY KEY (' . quote_cols($pm[1], $reserved) . ')';
                continue;
            }
            if (preg_match('/^UNIQUE KEY `?(\w+)`? \(([^)]+)\)$/i', $line, $um)) {
                $indexes[] = sprintf('CREATE UNIQUE INDEX %s ON %s (%s);', $table . '_' . $um[1], $table, quote_cols($um[2], $reserved));
                continue;
            }
            if (preg_match('/^KEY `?(\w+)`? \(([^)]+)\)$/i', $line, $km)) {
                $indexes[] = sprintf('CREATE INDEX %s ON %s (%s);', $table . '_' . $km[1], $table, quote_cols($km[2], $reserved));
                continue;
            }
            if (preg_match('/^(CONSTRAINT|FOREIGN KEY|UNIQUE)\b/i', $line)) {
                // constraint definitions pass through (backtick-free); pg syntax matches
                $cols[] = strtolower(str_replace('`', '', $line));
                continue;
            }
            // regular column line
            $line = str_replace('`', '', $line);
            if (preg_match('/^(\w+)\s+(.*)$/', $line, $cm)) {
                $colName = strtolower($cm[1]);
                $def = $cm[2];
                foreach ($typeMap as $pat => $repl) {
                    $def = preg_replace('/^' . $pat . '/i', $repl, $def, 1, $count);
                }
                $def = preg_replace('/current_timestamp\(\)/i', 'CURRENT_TIMESTAMP', $def);
                $def = preg_replace('/\s+(CHARACTER SET \w+|COLLATE \w+)+/i', '', $def);
                $def = preg_replace("/\s+COMMENT '.*?'/i", '', $def);
                // MySQL zero-dates are invalid in pg; app always writes real values
                if (preg_match("/DEFAULT '(0000-00-00( 00:00:00)?)'/i", $def)) {
                    $def = preg_replace("/DEFAULT '(0000-00-00( 00:00:00)?)'/i", 'DEFAULT NULL', $def);
                    $def = str_ireplace(' NOT NULL', '', $def);
                }
                if (isset($colOverrides["$table.$colName"])) {
                    $def = $colOverrides["$table.$colName"];
                }
                if (stripos($def, 'AUTO_INCREMENT') !== false) {
                    $def = preg_replace('/(integer|bigint)\s+NOT NULL AUTO_INCREMENT/i', 'serial', $def);
                    $serials[] = array($table, $colName);
                }
                if (stripos($def, 'ON UPDATE CURRENT_TIMESTAMP') !== false) {
                    $def = str_ireplace(' ON UPDATE CURRENT_TIMESTAMP', '', $def);
                    $touchTables[] = $table;
                }
                $known = 'serial|integer|bigint|smallint|varchar|text|date|datetime|timestamp|time|double precision|real|numeric|decimal|char|boolean';
                if (!preg_match('/^(' . $known . ')\b/i', $def)) {
                    $warned[] = "$table.$colName unmapped type: $def";
                }
                $cols[] = (in_array($colName, $reserved) ? '"' . $colName . '"' : $colName) . " $def";
            } else {
                $warned[] = "$table: unparsed line: $line";
            }
        }
        $cols[] = $pk;
        $output[] = "CREATE TABLE IF NOT EXISTS $table (\n  " . implode(",\n  ", array_filter($cols)) . "\n);";
        continue;
    }
    if (stripos($stmt, 'INSERT INTO') === 0) {
        $output[] = str_replace('`', '', $stmt) . ';';
        continue;
    }
    // everything else passes through minus backticks
    $output[] = str_replace('`', '', $stmt) . ';';
}

// Columns referenced by app code but absent from the MySQL source schema
// (schema drift — these pages 500 on MySQL too).
$addColumnPatches = "
ALTER TABLE tbl_warehouse     ADD COLUMN IF NOT EXISTS status varchar(20) DEFAULT 'published';
ALTER TABLE tbl_client        ADD COLUMN IF NOT EXISTS language varchar(50) DEFAULT NULL;
ALTER TABLE tbl_client        ADD COLUMN IF NOT EXISTS date_added timestamp DEFAULT NULL;
ALTER TABLE tbl_inbox         ADD COLUMN IF NOT EXISTS inbox_id integer DEFAULT NULL;
ALTER TABLE tbl_job_circular  ADD COLUMN IF NOT EXISTS status varchar(20) DEFAULT 'published';
ALTER TABLE tbl_job_circular  ADD COLUMN IF NOT EXISTS posted_date timestamp DEFAULT NULL;
";

// seed data (INSERTs only) from the base schema — runs after DDL so setval covers seeded ids
if ($seedFile && is_file($seedFile)) {
    $seedStmts = array_filter(array_map('trim', preg_split('/;\s*\n/', file_get_contents($seedFile))));
    foreach ($seedStmts as $st) {
        if (stripos($st, 'INSERT INTO') === 0) {
            $output[] = str_replace('`', '', $st) . ';';
        }
    }
}

$output[] = "\n-- app-referenced columns missing from the MySQL source\n" . trim($addColumnPatches);

// keep sequences past explicitly-seeded ids
foreach ($serials as $sc) {
    list($t, $c) = $sc;
    $output[] = "SELECT setval(pg_get_serial_sequence('$t','$c'), COALESCE((SELECT MAX($c) FROM $t), 0) + 1, false);";
}

if (!empty($touchTables)) {
    $output[] = "\nCREATE OR REPLACE FUNCTION touch_modified() RETURNS trigger AS \$\$\nBEGIN NEW.modified = CURRENT_TIMESTAMP; RETURN NEW; END;\n\$\$ LANGUAGE plpgsql;";
    foreach (array_unique($touchTables) as $t) {
        $output[] = "CREATE TRIGGER trg_{$t}_modified BEFORE UPDATE ON $t FOR EACH ROW EXECUTE FUNCTION touch_modified();";
    }
}

$output[] = "\n-- deferred indexes\n" . implode("\n", $indexes);

// The app compares tinyint-mapped columns with PHP booleans (e.g. 'read' => FALSE).
// MySQL coerces those silently; provide matching cross-type operators instead of
// editing framework/app code. Covers smallint/integer on either side.
$output[] = '
CREATE OR REPLACE FUNCTION rerp_int_bool_eq(int, boolean) RETURNS boolean AS $$ SELECT $1 = (CASE WHEN $2 THEN 1 ELSE 0 END) $$ LANGUAGE sql IMMUTABLE;
CREATE OPERATOR = (PROCEDURE = rerp_int_bool_eq, LEFTARG = int, RIGHTARG = boolean, COMMUTATOR = =);
CREATE OR REPLACE FUNCTION rerp_int_bool_ne(int, boolean) RETURNS boolean AS $$ SELECT $1 <> (CASE WHEN $2 THEN 1 ELSE 0 END) $$ LANGUAGE sql IMMUTABLE;
CREATE OPERATOR <> (PROCEDURE = rerp_int_bool_ne, LEFTARG = int, RIGHTARG = boolean, NEGATOR = =);
';

file_put_contents($out, implode("\n\n", $output) . "\n");
echo "wrote $out\n" . count($serials) . " serial columns, " . count($indexes) . " deferred indexes, " . count($touchTables) . " ON UPDATE trigger(s)\n";
if ($warned) { echo "WARNINGS:\n" . implode("\n", $warned) . "\n"; } else { echo "no warnings\n"; }
