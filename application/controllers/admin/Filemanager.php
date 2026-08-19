<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('memory_limit', '-1');
// set max execution time 2 hours / mostly used for exporting PDF
ini_set('max_execution_time', 3600);

require_once(APPPATH . 'third_party/elfinder/autoload.php');

class Filemanager extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

    public function index()
    {
        $this->ensure_filemanager_root();
        $this->load->helper('url');
        $data['title'] = lang('filemanager');
        $data['dataTables'] = true;
        $data['filemanager'] = true;
        $data['connector'] = base_url('admin/filemanager/elfinder_init');

        $data['subview'] = $this->load->view('admin/filemanager/filemanager', $data, TRUE);
        $this->load->view('admin/_layout_main', $data); //page load
    }

    public function elfinder_init()
    {
        if (empty($_GET['cmd']) && empty($_POST['cmd']) && !$this->input->is_ajax_request()) {
            redirect('admin/filemanager');
            return;
        }
        $this->ensure_filemanager_root();
        $this->load->helper('path');
        $allowed_files = $this->allowed_upload_mimes();
//        echo '<pre>';
//        print_r($allowed_files);
//        exit();

        $root_options = array(
            'dispInlineRegex' => '^(?:image|application/(?:vnd\.)?(?:ms(?:-office|word|-excel|-powerpoint)|openxmlformats-officedocument)|text/plain$)',
            'driver' => 'LocalFileSystem',
            'path' => set_realpath('filemanager'),
            'URL' => site_url('filemanager') . '/',
            'uploadMaxSize' => $this->upload_max_size(),
            'accessControl' => 'access',
            'uploadAllow' => $allowed_files,
//            'uploadAllow' => !$this->input->get('editor') ? [] : ['image', 'video'],
            'uploadDeny' => [
                'application/x-httpd-php',
                'application/php',
                'application/x-php',
                'text/php',
                'text/x-php',
                'application/x-httpd-php-source',
                'application/perl',
                'application/x-perl',
                'application/x-python',
                'application/python',
                'application/x-bytecode.python',
                'application/x-python-bytecode',
                'application/x-python-code',
                'wwwserver/shellcgi', // CGI
            ],
            'uploadOrder' => array(
                'allow',
                'deny'
            ),
            'attributes' => array(
                array(
                    'pattern' => '/.tmb/',
                    'hidden' => true
                ),
                array(
                    'pattern' => '/.quarantine/',
                    'hidden' => true
                )
            )
        );
        if ($this->session->userdata('user_type') == 3) {
            $user = $this->db->where('user_id', $this->session->userdata('user_id'))->get('tbl_users')->row();
            if ($user && $this->db->field_exists('media_path_slug', 'tbl_users')) {
                $path = set_realpath('filemanager/' . $user->media_path_slug);
                if (empty($user->media_path_slug)) {
                    $this->db->where('user_id', $user->user_id);
                    $slug = slug_it($user->username);
                    $this->db->update('tbl_users', array(
                        'media_path_slug' => $slug
                    ));
                    $user->media_path_slug = $slug;
                    $path = set_realpath('filemanager/' . $user->media_path_slug);
                }
                if (!is_dir($path)) {
                    mkdir($path);
                }
                if (!file_exists($path . '/index.html')) {
                    fopen($path . '/index.html', 'w');
                }
                array_push($root_options['attributes'], array(
                    'pattern' => '/.(' . $user->media_path_slug . '+)/',
                    'read' => true,
                    'write' => true,
                    'locked' => true
                ));
                $root_options['path'] = $path;
                $root_options['URL'] = site_url('filemanager/' . $user->media_path_slug) . '/';
            }
        }
        $opts = array(
            'roots' => array(
                $root_options
            )
        );

        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }

    protected function ensure_filemanager_root()
    {
        $path = FCPATH . 'filemanager';
        if (!is_dir($path)) {
            @mkdir($path, 0755, true);
        }
        $index = $path . DIRECTORY_SEPARATOR . 'index.html';
        if (!is_file($index)) {
            @file_put_contents($index, '');
        }
    }

    protected function upload_max_size()
    {
        $size = config_item('max_file_size');
        if ($size === null || $size === '' || $size === false) {
            $size = 32;
        }
        return $size . 'M';
    }

    protected function allowed_upload_mimes()
    {
        $raw = (string) config_item('allowed_files');
        $allowed_files = array();
        foreach (array_filter(array_map('trim', explode('|', $raw))) as $v_extension) {
            $extension = (strpos($v_extension, '.') === 0) ? $v_extension : '.' . $v_extension;
            $_mime = get_mime_by_extension($extension);
            if ($_mime == 'application/x-zip') {
                $allowed_files[] = 'application/zip';
            }
            if ($extension == '.exe') {
                $allowed_files[] = 'application/x-executable';
                $allowed_files[] = 'application/x-msdownload';
                $allowed_files[] = 'application/x-ms-dos-executable';
            }
            if (!empty($_mime)) {
                $allowed_files[] = $_mime;
            }
        }
        return $allowed_files;
    }

}
