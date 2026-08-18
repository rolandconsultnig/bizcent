<?php
/**
 * Rewrites application/config/database.php to the PostgreSQL driver.
 * Usage: php install/switch_to_postgres.php <host> <port> <dbname> <user> <password>
 * Keeps a .mysql-bak copy of the previous config on first run.
 */

list(, $host, $port, $db, $user, $pass) = $argv + array_fill(0, 6, '');
$host = $host ?: '127.0.0.1';
$port = $port ?: 5432;
if ($db === '' || $user === '') {
    fwrite(STDERR, "usage: php switch_to_postgres.php <host> <port> <dbname> <user> <password>\n");
    exit(1);
}

$f = __DIR__ . '/../application/config/database.php';
$s = file_get_contents($f);
if (!file_exists($f . '.mysql-bak')) {
    copy($f, $f . '.mysql-bak');
}
$esc = function ($v) { return str_replace(array('\\', "'"), array('\\\\', "\\'"), $v); };
$map = array(
    "/'dsn' => '[^']*'/"      => "'dsn' => ''",
    "/'hostname' => '[^']*'/" => "'hostname' => '" . $esc($host) . "'",
    "/'username' => '[^']*'/" => "'username' => '" . $esc($user) . "'",
    "/'password' => '[^']*'/" => "'password' => '" . $esc($pass) . "'",
    "/'database' => '[^']*'/" => "'database' => '" . $esc($db) . "'",
    "/'dbdriver' => '[^']*'/" => "'dbdriver' => 'postgre'",
);
$s = preg_replace(array_keys($map), $map, $s);
if (strpos($s, "'port' =>") === false) {
    $s = str_replace("'dbdriver' => 'postgre',", "'dbdriver' => 'postgre',\n    'port' => " . (int)$port . ",", $s);
} else {
    $s = preg_replace("/'port' => \d+/", "'port' => " . (int)$port, $s);
}
file_put_contents($f, $s);
echo "database.php switched to PostgreSQL ($host:$port/$db)\n";
