<?php
/**
 * PHP 8.x compatibility shims for CodeIgniter 3 and bundled RolandERP libraries.
 * Loaded from index.php before the framework bootstrap.
 */

// Some hardened VPS kernels block the executable-memory allocation PCRE JIT
// needs, which makes every preg_* call emit a warning. A warning raised while
// config.php is loading re-enters get_config() and fatals the request, so
// disable JIT before any pattern functions run. Negligible perf cost.
if (function_exists('ini_set')) {
    @ini_set('pcre.jit', '0');
}

if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_OFF);
}

if (PHP_VERSION_ID >= 80000) {
    $level = error_reporting();
    error_reporting($level & ~E_DEPRECATED & ~E_USER_DEPRECATED);
}

if (!function_exists('each')) {
    /**
     * @param array|ArrayAccess $array
     * @return array|false
     */
    function each(&$array)
    {
        if (!is_array($array)) {
            return false;
        }
        $key = key($array);
        if ($key === null) {
            return false;
        }
        $value = current($array);
        next($array);
        return array(
            1 => $value,
            'value' => $value,
            0 => $key,
            'key' => $key,
        );
    }
}

if (!function_exists('create_function')) {
    /**
     * @param string $args
     * @param string $code
     * @return Closure
     */
    function create_function($args, $code)
    {
        return eval('return function(' . $args . ') {' . $code . '};');
    }
}
