<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Meetings extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

    public function index()
    {
        $this->scheduled();
    }

    // 1. Scheduled Meetings List
    public function scheduled()
    {
        $data['title'] = lang('scheduled_meetings');
        $this->db->select('tbl_meetings.*, tbl_account_details.fullname as host_name');
        $this->db->from('tbl_meetings');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_meetings.host_id', 'left');
        $this->db->order_by('tbl_meetings.start_time', 'DESC');
        $data['meetings'] = $this->db->get()->result();

        $data['all_users'] = $this->db->get('tbl_users')->result();

        $data['subview'] = $this->load->view('admin/meetings/scheduled', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    // 2. Meet Now (Instant Meeting Launcher)
    public function instant()
    {
        $user_id = $this->session->userdata('user_id');
        $code = 'BIZ-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 9));
        
        $meeting_data = [
            'meeting_code' => $code,
            'title' => 'Instant Virtual Sync (' . date('M j, g:i A') . ')',
            'description' => 'Quick instant video / voice meeting room.',
            'host_id' => $user_id,
            'start_time' => date('Y-m-d H:i:s'),
            'duration_minutes' => 60,
            'status' => 'ongoing',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('tbl_meetings', $meeting_data);

        redirect('admin/meetings/room/' . $code);
    }

    public function save_meeting()
    {
        $user_id = $this->session->userdata('user_id');
        $start_date = $this->input->post('start_date', true) ?: date('Y-m-d');
        $start_time_str = $this->input->post('start_time', true) ?: date('H:i');
        $start_datetime = date('Y-m-d H:i:s', strtotime($start_date . ' ' . $start_time_str));

        $code = 'BIZ-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 9));

        $data = [
            'meeting_code' => $code,
            'title' => $this->input->post('title', true),
            'description' => $this->input->post('description', true),
            'host_id' => $user_id,
            'start_time' => $start_datetime,
            'duration_minutes' => (int)($this->input->post('duration_minutes', true) ?: 60),
            'passcode' => $this->input->post('passcode', true),
            'status' => 'scheduled',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tbl_meetings', $data);

        $attendees = $this->input->post('attendees', true);
        notify_authorized_users('meetings', 'view', [
            'description' => 'not_meeting_scheduled',
            'link' => 'admin/meetings/room/' . $code,
            'value' => $data['title'] . ' (' . date('M j, g:i A', strtotime($start_datetime)) . ')',
            'icon' => 'fa fa-video-camera',
            'from_user_id' => $user_id
        ], $attendees);

        set_message('success', 'Virtual meeting scheduled successfully.');
        redirect('admin/meetings/scheduled');
    }

    // 3. Virtual Meeting Room (Microsoft Teams-grade HD Video, Voice, Screen Share & Chat)
    public function room($code)
    {
        $data['title'] = lang('meeting_room');
        $this->db->select('tbl_meetings.*, tbl_account_details.fullname as host_name');
        $this->db->from('tbl_meetings');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_meetings.host_id', 'left');
        $this->db->where('tbl_meetings.meeting_code', $code);
        $data['meeting'] = $this->db->get()->row();

        if (empty($data['meeting'])) {
            // Auto-create room for direct ad-hoc code joins
            $user_id = $this->session->userdata('user_id');
            $data['meeting'] = (object)[
                'meeting_code' => $code,
                'title' => 'Virtual Meeting Room: ' . $code,
                'description' => 'Collaboration Room',
                'host_id' => $user_id,
                'host_name' => 'Host',
                'status' => 'ongoing',
                'passcode' => ''
            ];
        }

        $user_id = $this->session->userdata('user_id');
        $profile = $this->db->where('user_id', $user_id)->get('tbl_account_details')->row();
        $data['current_user_name'] = !empty($profile->fullname) ? $profile->fullname : 'Participant';
        $data['user_id'] = $user_id;

        $this->load->view('admin/meetings/room', $data);
    }
}
