<?php
/**
 * Export the authoritative DDL (all tables, fully migrated) from the local
 * MariaDB/MySQL reference database for conversion to PostgreSQL.
 * Usage: php export_mysql_schema.php [out]
 */

$out = $argv[1] ?? __DIR__ . '/mysql_full_schema.sql';
$db = @mysqli_connect('127.0.0.1', 'root', 'root', 'db_saas_module');
if (!$db) {
    fwrite(STDERR, 'connect failed: ' . mysqli_connect_error() . PHP_EOL);
    exit(1);
}

$res = mysqli_query($db, 'SHOW TABLES');
$tables = array();
while ($row = mysqli_fetch_array($res)) {
    $tables[] = $row[0];
}

$ddl = array();
foreach ($tables as $t) {
    $r = mysqli_query($db, "SHOW CREATE TABLE `" . mysqli_real_escape_string($db, $t) . "`");
    $row = mysqli_fetch_assoc($r);
    $ddl[] = $row['Create Table'] . ';';
}

// current migration marker so Auto_update does not replay MySQL migrations on Postgres
$mv = mysqli_query($db, 'SELECT version FROM tbl_migrations ORDER BY version DESC LIMIT 1');
$mrow = $mv ? mysqli_fetch_assoc($mv) : null;
$ddl[] = $mrow ? "INSERT INTO tbl_migrations (version) VALUES (" . (int)$mrow['version'] . ");" : '';

file_put_contents($out, implode("\n\n", $ddl) . "\n");
echo 'exported ' . count($tables) . ' tables' . ($mrow ? ', migration version ' . $mrow['version'] : '') . PHP_EOL;
