<?php

/**
 * Description of MY_Controller
 *
 * @author Nayeem
 */
#[\AllowDynamicProperties]
class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    
        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('admin_model');
        $this->load->model('items_model');
        $this->load->model('invoice_model');
        $this->load->model('common_model');
        $this->load->helper('language');
    
        if (admin() && $this->input->get('skip_modules_load') && $this->input->get('skip_modules_load')) {
            $modules = [];
        } else {
            $modules = $this->module->get_active_module();
        }
        if (!empty($modules) && is_array($modules)) {
            foreach ($modules as $module) {
                if (!empty($module['init_file']) && file_exists($module['init_file'])) {
                    require_once($module['init_file']);
                }
            }
        }
        do_action('appended_to_my_controller');
      
    
        $config_data = $this->db->get('tbl_config')->result();
        foreach ($config_data as $v_config_info) {
            $this->config->set_item($v_config_info->config_key, $v_config_info->value);
        }
    
        $system_lang = $this->admin_model->get_lang();
        $this->config->set_item('language', $system_lang);
    
        $files = $this->admin_model->all_files();
        if (!is_array($files)) {
            $files = array();
        }
        $lang_to_load = !empty($system_lang) ? $system_lang : 'english';
        foreach ($files as $file => $altpath) {
            $shortfile = str_replace("_lang.php", "", $file);
            $this->lang->load($shortfile, $lang_to_load);
        }
        $uri = null;
        for ($i = 1; $i <= $this->uri->total_segments(); $i++) {
            $uri .= $this->uri->segment($i) . '/';
        }
        $uriSegment = rtrim((string) $uri, '/');
        $menu_uri['menu_active_id'] = $this->admin_model->select_menu_by_uri($uriSegment);
        $menu_uri['menu_active_id'] == false || $this->session->set_userdata($menu_uri);
        $timezone = config_item('timezone');
        if (empty($timezone)) {
            $timezone = 'Australia/Sydney';
        }

        $unread_notifications = $this->db->where(array('to_user_id' => $this->session->userdata('user_id'), 'read' => 0))->get('tbl_notifications')->result();
        $unread_count = is_array($unread_notifications) ? count($unread_notifications) : 0;
        $currency_row = $this->db->where('code', config_item('default_currency'))->get('tbl_currencies')->row();
        $auto_loaded_vars = array(
            'unread_notifications' => $unread_count,
            'd_currency' => $currency_row ? $currency_row->symbol : '',
        );
        $this->load->vars($auto_loaded_vars);
    
        date_default_timezone_set($timezone);
        set_mysql_timezone($timezone);
        check_installation();
        
    }
}
