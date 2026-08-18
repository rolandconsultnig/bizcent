<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]
class MY_Lang extends CI_Lang
{
    public function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '')
    {
        if (empty($idiom)) {
            $CI =& get_instance();
            $idiom = $CI->config->item('language');
        }
        $idiom = !empty($idiom) ? strtolower(trim($idiom)) : 'english';
        return parent::load($langfile, $idiom, $return, $add_suffix, $alt_path);
    }
}
