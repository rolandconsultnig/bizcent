<?php
/**
 * Rebuild missing tables/columns from migration SQL and application table names.
 * Safe to run repeatedly. Does not drop tables or columns.
 *
 * CLI: php install/schema_sync.php
 */

function rolanderp_schema_sync(mysqli $db, $root = null)
{
    mysqli_report(MYSQLI_REPORT_OFF);
    $root = $root ?: dirname(__DIR__);
    $report = array(
        'tables_created' => 0,
        'columns_added' => 0,
        'columns_renamed' => 0,
        'config_keys' => 0,
        'stubs' => 0,
        'errors' => array(),
    );

    $creates = array();
    $add_columns = array();
    $changes = array();
    $config_kv = array();

    $schema_file = $root . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . 'schema.sql';
    if (is_file($schema_file)) {
        rolanderp_parse_sql_blob(file_get_contents($schema_file), $creates, $add_columns, $changes, $config_kv);
    }

    $mig_dir = $root . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'migrations';
    $files = glob($mig_dir . DIRECTORY_SEPARATOR . '*.php') ?: array();
    natsort($files);
    foreach ($files as $file) {
        $src = file_get_contents($file);
        foreach (rolanderp_extract_query_sql($src) as $sql) {
            rolanderp_parse_sql_blob($sql, $creates, $add_columns, $changes, $config_kv);
        }
    }

    $existing = array();
    $res = $db->query('SHOW TABLES');
    if ($res) {
        while ($row = $res->fetch_row()) {
            $existing[strtolower($row[0])] = $row[0];
        }
        $res->free();
    }

    foreach ($creates as $table => $sql) {
        $key = strtolower($table);
        if (isset($existing[$key])) {
            continue;
        }
        if (!$db->query($sql)) {
            $report['errors'][] = 'CREATE ' . $table . ': ' . $db->error;
            continue;
        }
        $existing[$key] = $table;
        $report['tables_created']++;
    }

    $code_tables = rolanderp_scan_code_tables($root);
    foreach ($code_tables as $table) {
        $key = strtolower($table);
        if (isset($existing[$key])) {
            continue;
        }
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $db->real_escape_string($table) . '` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        if (!$db->query($sql)) {
            $report['errors'][] = 'STUB ' . $table . ': ' . $db->error;
            continue;
        }
        $existing[$key] = $table;
        $report['stubs']++;
        $report['tables_created']++;
    }

    foreach ($changes as $item) {
        $table = $item['table'];
        if (!isset($existing[strtolower($table)])) {
            continue;
        }
        $cols = rolanderp_table_columns($db, $table);
        $old = $item['old'];
        $new = $item['new'];
        $def = $item['def'];
        if (isset($cols[strtolower($new)])) {
            continue;
        }
        if (isset($cols[strtolower($old)])) {
            $sql = 'ALTER TABLE `' . $table . '` CHANGE `' . $old . '` `' . $new . '` ' . $def;
            if ($db->query($sql)) {
                $report['columns_renamed']++;
            } else {
                $report['errors'][] = 'CHANGE ' . $table . '.' . $old . ': ' . $db->error;
            }
        } else {
            $sql = 'ALTER TABLE `' . $table . '` ADD COLUMN IF NOT EXISTS `' . $new . '` ' . $def;
            if ($db->query($sql)) {
                $report['columns_added']++;
            } else {
                $report['errors'][] = 'ADD-FROM-CHANGE ' . $table . '.' . $new . ': ' . $db->error;
            }
        }
    }

    foreach ($add_columns as $table => $cols_to_add) {
        if (!isset($existing[strtolower($table)])) {
            continue;
        }
        $have = rolanderp_table_columns($db, $table);
        foreach ($cols_to_add as $col => $def) {
            if (isset($have[strtolower($col)])) {
                continue;
            }
            $sql = 'ALTER TABLE `' . $table . '` ADD COLUMN IF NOT EXISTS `' . $col . '` ' . $def;
            if ($db->query($sql)) {
                $have[strtolower($col)] = $col;
                $report['columns_added']++;
            } else {
                $fallback = 'ALTER TABLE `' . $table . '` ADD COLUMN IF NOT EXISTS `' . $col . '` TEXT NULL';
                if ($db->query($fallback)) {
                    $have[strtolower($col)] = $col;
                    $report['columns_added']++;
                } else {
                    $report['errors'][] = 'ADD ' . $table . '.' . $col . ': ' . $db->error;
                }
            }
        }
    }

    foreach ($config_kv as $key => $value) {
        $key_esc = $db->real_escape_string($key);
        $val_esc = $db->real_escape_string($value);
        $exists = $db->query("SELECT 1 FROM tbl_config WHERE config_key='$key_esc' LIMIT 1");
        if ($exists && $exists->num_rows > 0) {
            $exists->free();
            continue;
        }
        if ($exists) {
            $exists->free();
        }
        if ($db->query("INSERT INTO tbl_config (config_key, value) VALUES ('$key_esc', '$val_esc')")) {
            $report['config_keys']++;
        }
    }

    $brand = array(
        'copyright_name' => 'RolandERP',
        'copyright_url' => '#',
        'chat_interval_time' => '5',
    );
    foreach ($brand as $key => $value) {
        $key_esc = $db->real_escape_string($key);
        $val_esc = $db->real_escape_string($value);
        $db->query("INSERT INTO tbl_config (config_key, value) VALUES ('$key_esc', '$val_esc') ON DUPLICATE KEY UPDATE config_key=config_key");
    }
    $db->query("UPDATE tbl_config SET value='RolandERP' WHERE config_key IN ('company_name','company_legal_name','website_name','copyright_name')");
    $db->query("UPDATE tbl_config SET value='6.0.0' WHERE config_key='version'");
    $db->query("UPDATE tbl_migrations SET version=600");

    return $report;
}

function rolanderp_extract_query_sql($src)
{
    $out = array();
    if (preg_match_all('/\$this->db->query\s*\(\s*"((?:\\\\.|[^"\\\\])*)"/s', $src, $m)) {
        foreach ($m[1] as $s) {
            $out[] = stripcslashes($s);
        }
    }
    if (preg_match_all("/\\\$this->db->query\\s*\\(\\s*'((?:\\\\.|[^'\\\\])*)'/s", $src, $m)) {
        foreach ($m[1] as $s) {
            $out[] = strtr($s, array("\\'" => "'", '\\\\' => '\\'));
        }
    }
    return $out;
}

function rolanderp_parse_sql_blob($sql, &$creates, &$add_columns, &$changes, &$config_kv)
{
    $sql = trim($sql);
    if ($sql === '') {
        return;
    }
    $parts = preg_split('/;\s*(?=CREATE\s+TABLE|ALTER\s+TABLE|INSERT\s+INTO)/i', $sql);
    foreach ($parts as $stmt) {
        $stmt = trim($stmt, " \t\n\r\0\x0B;");
        if ($stmt === '') {
            continue;
        }
        if (preg_match('/^CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`?(\w+)`?/i', $stmt, $m)) {
            $table = $m[1];
            if (stripos($stmt, 'IF NOT EXISTS') === false) {
                $stmt = preg_replace('/^CREATE\s+TABLE/i', 'CREATE TABLE IF NOT EXISTS', $stmt, 1);
            }
            if (!preg_match('/ENGINE\s*=/i', $stmt)) {
                $stmt .= ' ENGINE=InnoDB DEFAULT CHARSET=utf8';
            }
            $creates[$table] = $stmt;
            continue;
        }
        if (preg_match('/^ALTER\s+TABLE\s+`?(\w+)`?\s+(.+)$/is', $stmt, $m)) {
            rolanderp_parse_alter($m[1], trim($m[2], " \t\n\r;"), $add_columns, $changes);
            continue;
        }
        if (preg_match("/INSERT\s+INTO\s+`?tbl_config`?\s*\(\s*`?config_key`?\s*,\s*`?value`?\s*\)\s*VALUES\s*\(\s*'([^']+)'\s*,\s*'((?:\\\\'|[^'])*)'\s*\)/i", $stmt, $m)) {
            $config_kv[$m[1]] = strtr($m[2], array("\\'" => "'"));
        }
        if (preg_match_all("/\(\s*'([^']+)'\s*,\s*'((?:\\\\'|[^'])*)'\s*\)/", $stmt, $mm, PREG_SET_ORDER) && stripos($stmt, 'tbl_config') !== false) {
            foreach ($mm as $row) {
                $config_kv[$row[1]] = strtr($row[2], array("\\'" => "'"));
            }
        }
    }
}

function rolanderp_parse_alter($table, $body, &$add_columns, &$changes)
{
    if (preg_match('/^CHANGE/i', $body)) {
        $chunks = preg_split('/,\s*CHANGE(?:\s+COLUMN)?\s+/i', $body);
        foreach ($chunks as $i => $chunk) {
            $chunk = trim($chunk);
            if ($i === 0) {
                $chunk = preg_replace('/^CHANGE(?:\s+COLUMN)?\s+/i', '', $chunk);
            }
            if (preg_match('/^`?(\w+)`?\s+`?(\w+)`?\s+(.+)$/s', $chunk, $c)) {
                $changes[] = array(
                    'table' => $table,
                    'old' => $c[1],
                    'new' => $c[2],
                    'def' => rolanderp_clean_col_def($c[3]),
                );
            }
        }
        return;
    }

    if (preg_match('/^ADD\s*\((.+)\)\s*$/is', $body, $m)) {
        foreach (rolanderp_split_col_list($m[1]) as $def) {
            rolanderp_register_add($table, $def, $add_columns);
        }
        return;
    }

    if (!preg_match('/^ADD(?:\s+COLUMN)?\s+/i', $body)) {
        return;
    }
    $rest = preg_replace('/^ADD(?:\s+COLUMN)?\s+/i', '', $body, 1);
    $chunks = preg_split('/,\s*ADD(?:\s+COLUMN)?\s+/i', $rest);
    foreach ($chunks as $chunk) {
        rolanderp_register_add($table, trim($chunk), $add_columns);
    }
}

function rolanderp_register_add($table, $def, &$add_columns)
{
    $def = trim($def);
    if ($def === '') {
        return;
    }
    if (preg_match('/^(INDEX|KEY|PRIMARY|UNIQUE|CONSTRAINT|FOREIGN|FULLTEXT|SPATIAL)\b/i', $def)) {
        return;
    }
    if (!preg_match('/^`?(\w+)`?\s+(.+)$/s', $def, $m)) {
        return;
    }
    $col = $m[1];
    $type = rolanderp_clean_col_def($m[2]);
    if ($type === '') {
        $type = 'TEXT NULL';
    }
    if (!isset($add_columns[$table])) {
        $add_columns[$table] = array();
    }
    $add_columns[$table][$col] = $type;
}

function rolanderp_clean_col_def($def)
{
    $def = trim($def);
    $def = preg_replace('/\s+(FIRST|AFTER\s+`?\w+`?)\s*$/i', '', $def);
    $def = rtrim($def, " \t\n\r;");
    return $def;
}

function rolanderp_split_col_list($list)
{
    $out = array();
    $buf = '';
    $depth = 0;
    $len = strlen($list);
    for ($i = 0; $i < $len; $i++) {
        $c = $list[$i];
        if ($c === '(') {
            $depth++;
        } elseif ($c === ')') {
            $depth--;
        }
        if ($c === ',' && $depth === 0) {
            $out[] = trim($buf);
            $buf = '';
            continue;
        }
        $buf .= $c;
    }
    if (trim($buf) !== '') {
        $out[] = trim($buf);
    }
    return $out;
}

function rolanderp_table_columns(mysqli $db, $table)
{
    $cols = array();
    $res = $db->query('SHOW COLUMNS FROM `' . $db->real_escape_string($table) . '`');
    if (!$res) {
        return $cols;
    }
    while ($row = $res->fetch_assoc()) {
        $cols[strtolower($row['Field'])] = $row['Field'];
    }
    $res->free();
    return $cols;
}

function rolanderp_scan_code_tables($root)
{
    $skip = array(
        'tbl_name' => true,
        'tbl_id' => true,
        'tbl_field' => true,
        'tbl_prefix' => true,
        'tbl_key' => true,
        'tbl_value' => true,
        'tbl_menu_id' => true,
    );
    $found = array();
    $dirs = array(
        $root . DIRECTORY_SEPARATOR . 'application',
        $root . DIRECTORY_SEPARATOR . 'install',
    );
    foreach ($dirs as $dir) {
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
        foreach ($it as $file) {
            if (strtolower($file->getExtension()) !== 'php') {
                continue;
            }
            $src = file_get_contents($file->getPathname());
            if ($src === false) {
                continue;
            }
            if (preg_match_all("/['\"](tbl_[a-z][a-z0-9_]*)['\"]/i", $src, $m)) {
                foreach ($m[1] as $table) {
                    $table = strtolower($table);
                    if (isset($skip[$table])) {
                        continue;
                    }
                    $found[$table] = $table;
                }
            }
        }
    }
    return array_values($found);
}

if (php_sapi_name() === 'cli' && isset($argv[0]) && basename($argv[0]) === 'schema_sync.php') {
    $root = dirname(__DIR__);
    $db_file = $root . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
    if (!is_file($db_file)) {
        fwrite(STDERR, "database.php not found\n");
        exit(1);
    }
    if (!defined('BASEPATH')) {
        define('BASEPATH', true);
        define('ENVIRONMENT', 'development');
    }
    include $db_file;
    $cfg = $db['default'];
    mysqli_report(MYSQLI_REPORT_OFF);
    $mysqli = @mysqli_connect($cfg['hostname'], $cfg['username'], $cfg['password'], $cfg['database']);
    if (!$mysqli) {
        fwrite(STDERR, 'DB connect failed: ' . mysqli_connect_error() . PHP_EOL);
        exit(1);
    }
    $mysqli->set_charset('utf8mb4');
    $report = rolanderp_schema_sync($mysqli, $root);
    echo "Tables created: {$report['tables_created']} (stubs: {$report['stubs']})\n";
    echo "Columns added: {$report['columns_added']}\n";
    echo "Columns renamed: {$report['columns_renamed']}\n";
    echo "Config keys added: {$report['config_keys']}\n";
    if (!empty($report['errors'])) {
        echo "Errors (" . count($report['errors']) . "):\n";
        foreach (array_slice($report['errors'], 0, 40) as $err) {
            echo "  - $err\n";
        }
        if (count($report['errors']) > 40) {
            echo "  ... " . (count($report['errors']) - 40) . " more\n";
        }
    }
    $mysqli->close();
}
