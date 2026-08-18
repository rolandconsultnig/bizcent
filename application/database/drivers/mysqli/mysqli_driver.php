<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Soft-fail SELECT queries when a table or column is missing so the app
 * can render instead of dumping a CodeIgniter database error page.
 */
class MY_DB_mysqli_driver extends CI_DB_mysqli_driver
{
    public function __construct($params)
    {
        if (function_exists('mysqli_report')) {
            mysqli_report(MYSQLI_REPORT_OFF);
        }
        parent::__construct($params);
    }

    public function query($sql, $binds = FALSE, $return_object = NULL)
    {
        $debug = $this->db_debug;
        $this->db_debug = FALSE;
        $result = parent::query($sql, $binds, $return_object);
        $this->db_debug = $debug;

        if ($result !== FALSE) {
            return $result;
        }

        if (preg_match('/^\s*(SELECT|SHOW|DESCRIBE|DESC|EXPLAIN)\b/i', (string) $sql)) {
            return $this->_empty_result();
        }

        return FALSE;
    }

    protected function _empty_result()
    {
        $RES = new CI_DB_mysqli_result($this);
        $RES->num_rows = 0;
        $RES->result_id = FALSE;
        $RES->result_array = array();
        $RES->result_object = array();
        return $RES;
    }
}
