<?php error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb');
define('UPDATE_URL', 'https://update.uniquecoder.com/');
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
ini_set('max_execution_time', 30000000);
mysqli_report(MYSQLI_REPORT_OFF);

class Install
{
    public function go()
    {
        $debug = '';
        $bug_error = '';
        $step = 1;
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST['permissions_success'])) {
                $step = 2;
            } elseif (isset($_POST['step']) && $_POST['step'] == 2) {
                $step = 2;
                $p = array();
                if ($_POST['hostname'] == '') {
                    $bug_error = 'Hostname is required';
                } elseif ($_POST['database'] == '') {
                    $bug_error = 'Enter database name';
                } elseif ($_POST['db_password'] == '' && !$this->is_localhost()) {
                    $bug_error = 'Enter database password';
                } elseif ($_POST['db_username'] == '') {
                    $bug_error = 'Enter database username';
                }
                if ($bug_error === '') {
                    $conn = $this->db_connect($_POST['hostname'], $_POST['db_username'], $_POST['db_password'], $_POST['database'], true);
                    if (empty($conn['link'])) {
                        $bug_error = $conn['error'];
                        if (stripos($bug_error, 'Access denied') !== false) {
                            $bug_error .= ' Use password root (exactly). A browser-saved password often overwrites the field.';
                        }
                    } else {
                        $link = $conn['link'];
                        $debug .= "Success: A proper connection to MySQL was made! The " . $_POST['database'] . " database is great." . PHP_EOL;
                        $debug .= "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
                        $step = 3;
                        mysqli_close($link);
                    }
                }
            } elseif (isset($_POST['step']) && $_POST['step'] == 3) {
                if ($_POST['admin_email'] == '') {
                    $bug_error = 'Enter admin email address';
                } elseif (filter_var($_POST['admin_email'], FILTER_VALIDATE_EMAIL) === false) {
                    $bug_error = 'Enter valid email address';
                } elseif ($_POST['admin_password'] == '') {
                    $bug_error = 'Enter admin password';
                } elseif ($_POST['admin_password'] != $_POST['confirm_password']) {
                    $bug_error = 'Your password not match';
                }
                $step = 3;
            }
            if ($bug_error === '' && isset($_POST['step']) && $_POST['step'] == 3) {
                $schema = $this->load_local_schema();
                if ($schema === false) {
                    $bug_error = 'Local database schema is missing (install/schema.sql).';
                } else {
                    $success = $this->install_db($_POST, $schema);
                    if (!empty($success)) {
                        $conn = $this->db_connect($_POST['hostname'], $_POST['db_username'], $_POST['db_password'], $_POST['database']);
                        if (empty($conn['link'])) {
                            $bug_error = $conn['error'];
                        } else {
                        $link = $conn['link'];
                        mysqli_set_charset($link, 'utf8mb4');
                        $this->write_app_config();
                        $this->clean_up_db_query($link);

                        $fullname = mysqli_real_escape_string($link, $_POST['admin_fullname']);
                        $username = mysqli_real_escape_string($link, $_POST['admin_username']);
                        $password = mysqli_real_escape_string($link, $this->hash($_POST['admin_password']));
                        $user_email = mysqli_real_escape_string($link, $_POST['admin_email']);
                        $company_name = mysqli_real_escape_string($link, $_POST['company_name']);
                        $company_email = mysqli_real_escape_string($link, $_POST['company_email']);
                        $timezone = mysqli_real_escape_string($link, $_POST['timezone']);
                        $created = date('Y-m-d H:i:s');

                        $sql = "INSERT INTO tbl_users(username,email,password,role_id,activated,banned,created) VALUES ('$username','$user_email','$password',1,1,0,'$created')";
                        mysqli_query($link, $sql);
                        $last_id = mysqli_insert_id($link);
                        if (empty($last_id) || $last_id == 0) {
                            $last_id = 1;
                        }
                        $sql = "INSERT INTO tbl_account_details (fullname,user_id,language,direction) VALUES('$fullname','$last_id','english','ltr')";
                        mysqli_query($link, $sql);

                        mysqli_query($link, "UPDATE tbl_config SET value='$company_name' WHERE config_key='company_name'");
                        mysqli_query($link, "UPDATE tbl_config SET value='$company_name' WHERE config_key='company_legal_name'");
                        mysqli_query($link, "UPDATE tbl_config SET value='$company_name' WHERE config_key='website_name'");
                        mysqli_query($link, "UPDATE tbl_config SET value='$company_name' WHERE config_key='contact_person'");
                        mysqli_query($link, "UPDATE tbl_config SET value='$username' WHERE config_key='mail_username'");
                        mysqli_query($link, "UPDATE tbl_config SET value='$company_email' WHERE config_key='company_email'");
                        mysqli_query($link, "UPDATE tbl_config SET value='$timezone' WHERE config_key='timezone'");

                        $step = 4;
                        }
                    } else {
                        $bug_error = 'Could not import the local database schema. Check your MySQL user permissions.';
                    }
                }
            }
        }
        $this->already_installed();
        require_once('html.php');
    }

    public function hash($string)
    {
        $encryption_key = 'I6PnEPbQNLslYMj7ChKxDJ2yenuHLkXn';
        return hash('sha512', $string . $encryption_key);
    }

    public function load_local_schema()
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'schema.sql';
        if (!is_file($path)) {
            return false;
        }
        $sql = file_get_contents($path);
        return ($sql !== false && trim($sql) !== '') ? $sql : false;
    }

    public function db_connect($host, $user, $pass, $database = '', $create_db = false)
    {
        $hosts = array($host);
        if (strtolower((string) $host) === 'localhost') {
            array_unshift($hosts, '127.0.0.1');
        }

        $last_error = 'Unable to connect to MySQL.';
        foreach ($hosts as $try_host) {
            try {
                $link = @mysqli_connect($try_host, $user, $pass, '', 3306);
            } catch (Throwable $e) {
                $last_error = $e->getMessage();
                $link = false;
            }

            if (!$link) {
                $err = mysqli_connect_error();
                if ($err) {
                    $last_error = $err;
                }
                if (stripos($last_error, 'auth_gssapi') !== false) {
                    $last_error = 'MariaDB is using Windows/GSSAPI authentication, which PHP cannot use. '
                        . 'Use host 127.0.0.1 and a MySQL user with a normal password (mysql_native_password), '
                        . 'not Windows authentication.';
                }
                continue;
            }

            mysqli_set_charset($link, 'utf8mb4');
            if ($database !== '') {
                $db = mysqli_real_escape_string($link, $database);
                if ($create_db) {
                    mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                }
                if (!mysqli_select_db($link, $database)) {
                    $select_error = mysqli_error($link);
                    mysqli_close($link);
                    return array(
                        'link' => null,
                        'error' => $select_error ?: ("Could not select database `$database`. Create it first, then retry.")
                    );
                }
            }
            return array('link' => $link, 'error' => '');
        }

        return array('link' => null, 'error' => $last_error);
    }

    public function install_db($POST, $sql_file)
    {
        $conn = $this->db_connect($POST['hostname'], $POST['db_username'], $POST['db_password'], $POST['database']);
        if (empty($conn['link'])) {
            return false;
        }
        $mysqli = $conn['link'];
        $statements = array_filter(array_map('trim', explode(';', $sql_file)));
        foreach ($statements as $statement) {
            if ($statement === '' || strpos($statement, '--') === 0) {
                continue;
            }
            if (!$mysqli->query($statement)) {
                $mysqli->close();
                return false;
            }
        }
        $mysqli->close();

        $sync_file = __DIR__ . DIRECTORY_SEPARATOR . 'schema_sync.php';
        if (is_file($sync_file)) {
            require_once $sync_file;
            $sync_conn = $this->db_connect($POST['hostname'], $POST['db_username'], $POST['db_password'], $POST['database']);
            if (!empty($sync_conn['link'])) {
                rolanderp_schema_sync($sync_conn['link'], dirname(__DIR__));
                $sync_conn['link']->close();
            }
        }

        return true;
    }

    public function remote_get_contents($post, $getDB = null)
    {
        if (function_exists('curl_init')) {
            return self::curl_get_contents($post, $getDB);
        } else {
            return 'Please enable the curl function';
        }
    }

    public function curl_get_contents($post, $getDB = null)
    {
        if (!empty($getDB)) {
            $url = UPDATE_URL . 'api/getDB';
        } else {
            $url = UPDATE_URL . 'api/check';
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        $path = substr(realpath(dirname(__FILE__)), 0, -8);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
            'envato_username' => $post['envato_username'],
            'support_email' => $post['support_email'],
            'purchase_code' => $post['purchase_code'],
            'item_id' => '16292398',
            'ip_address' => isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER["HTTP_HOST"],
            'url' => $this->base_url(), // please do not change the URL this is mandatory to setup the software
            'path' => $path,
        ));
        $output = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $output;
    }

    public function is_localhost()
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );
        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return true;
        }

        return false;
    }

    private function clean_up_db_query($link)
    {
        while (mysqli_more_results($link) && mysqli_next_result($link)) {
            $dummyResult = mysqli_use_result($link);

            if ($dummyResult instanceof mysqli_result) {
                mysqli_free_result($link);
            }
        }
    }

    public function already_installed()
    {
        $output_path = '../application/config/install.php';
        if (!file_exists($output_path)) {
            header('location:../login');
        }
    }

    private function write_app_config()
    {

        $template_path = 'config/database.php';
        $output_path = '../application/config/database.php';
        $install = '../application/config/install.php';

        $database_file = file_get_contents($template_path);

        $new = str_replace("%HOSTNAME%", $_POST['hostname'], $database_file);
        $new = str_replace("%USERNAME%", $_POST['db_username'], $new);
        $new = str_replace("%PASSWORD%", $_POST['db_password'], $new);
        $new = str_replace("%DATABASE%", $_POST['database'], $new);

        $handle = fopen($output_path, 'w+');

        @chmod($output_path, 0777);
        if (file_exists($install)) {
            unlink($install);
        }
        if (is_writable($output_path)) {

            if (fwrite($handle, $new)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function base_url()
    {
        $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
        $base_url .= '://' . $_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $base_url = preg_replace('/install.*/', '', $base_url);

        return $base_url;
    }

    public function get_timezones_list()
    {
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();
        $utcTime = new DateTime('now', new DateTimeZone('UTC'));

        $tempTimezones = array();
        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $currentTimezone = new DateTimeZone($timezoneIdentifier);

            $tempTimezones[] = array(
                'offset' => (int)$currentTimezone->getOffset($utcTime),
                'identifier' => $timezoneIdentifier
            );
        }

        usort($tempTimezones, function ($a, $b) {
            return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
        });

        $timezoneList = array();
        foreach ($tempTimezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
                $tz['identifier'];
        }
        return $timezoneList;
    }
}
