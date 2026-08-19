<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Requisition extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

    public function index()
    {
        $this->my_requisitions();
    }

    public function my_requisitions()
    {
        $data['title'] = lang('my_requisitions');
        $user_id = $this->session->userdata('user_id');
        
        $this->db->select('tbl_requisitions.*, tbl_departments.deptname, tbl_account_details.fullname');
        $this->db->from('tbl_requisitions');
        $this->db->join('tbl_departments', 'tbl_departments.departments_id = tbl_requisitions.departments_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_requisitions.user_id', 'left');
        $this->db->where('tbl_requisitions.user_id', $user_id);
        $this->db->order_by('tbl_requisitions.requisition_id', 'DESC');
        $data['all_requisitions'] = $this->db->get()->result();

        $data['subview'] = $this->load->view('admin/requisition/my_requisitions', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function all_requisitions()
    {
        $data['title'] = lang('all_requisitions');
        
        $this->db->select('tbl_requisitions.*, tbl_departments.deptname, tbl_account_details.fullname');
        $this->db->from('tbl_requisitions');
        $this->db->join('tbl_departments', 'tbl_departments.departments_id = tbl_requisitions.departments_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_requisitions.user_id', 'left');
        $this->db->order_by('tbl_requisitions.requisition_id', 'DESC');
        $data['all_requisitions'] = $this->db->get()->result();

        $data['subview'] = $this->load->view('admin/requisition/all_requisitions', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function new_requisition($id = null)
    {
        $data['title'] = lang('new_requisition');
        if (!empty($id)) {
            $data['requisition'] = $this->db->where('requisition_id', $id)->get('tbl_requisitions')->row();
            $data['requisition_items'] = $this->db->where('requisition_id', $id)->get('tbl_requisition_items')->result();
        }
        $data['all_departments'] = $this->db->get('tbl_departments')->result();
        
        $data['subview'] = $this->load->view('admin/requisition/new_requisition', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_requisition($id = null)
    {
        $user_id = $this->session->userdata('user_id');
        $data = [
            'departments_id' => $this->input->post('departments_id', true),
            'title' => $this->input->post('title', true),
            'priority' => $this->input->post('priority', true) ?: 'medium',
            'expected_date' => $this->input->post('expected_date', true) ? date('Y-m-d', strtotime($this->input->post('expected_date', true))) : date('Y-m-d', strtotime('+7 days')),
            'purpose' => $this->input->post('purpose', true),
            'notes' => $this->input->post('notes', true),
        ];

        $item_names = $this->input->post('item_name', true) ?: [];
        $descriptions = $this->input->post('item_desc', true) ?: [];
        $quantities = $this->input->post('quantity', true) ?: [];
        $units = $this->input->post('unit', true) ?: [];
        $unit_prices = $this->input->post('unit_price', true) ?: [];

        $total_amount = 0;
        $items_to_insert = [];

        for ($i = 0; $i < count($item_names); $i++) {
            if (!empty($item_names[$i])) {
                $qty = (float)($quantities[$i] ?? 1);
                $price = (float)($unit_prices[$i] ?? 0);
                $line_total = $qty * $price;
                $total_amount += $line_total;

                $items_to_insert[] = [
                    'item_name' => $item_names[$i],
                    'description' => $descriptions[$i] ?? '',
                    'quantity' => $qty,
                    'unit' => $units[$i] ?? 'pcs',
                    'unit_price' => $price,
                    'total_price' => $line_total
                ];
            }
        }

        $data['total_amount'] = $total_amount;

        if (!empty($id)) {
            $this->db->where('requisition_id', $id)->update('tbl_requisitions', $data);
            $this->db->where('requisition_id', $id)->delete('tbl_requisition_items');
            $req_id = $id;
            set_message('success', 'Requisition updated successfully.');
        } else {
            $data['requisition_no'] = 'REQ-' . date('Ymd') . '-' . rand(1000, 9999);
            $data['user_id'] = $user_id;
            $data['status'] = 'pending';
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_requisitions', $data);
            $req_id = $this->db->insert_id();

            // Get department head if available
            $dept_head_id = null;
            if (!empty($data['departments_id'])) {
                $dept = $this->db->where('departments_id', $data['departments_id'])->get('tbl_departments')->row();
                if ($dept && !empty($dept->department_head_id)) {
                    $dept_head_id = $dept->department_head_id;
                }
            }

            // Alert authorized reviewers by User Level and Permission
            notify_authorized_users('requisitions', 'view', [
                'description' => 'not_new_requisition_submitted',
                'link' => 'admin/requisition/all_requisitions',
                'value' => $data['requisition_no'] . ' (' . $data['title'] . ')',
                'icon' => 'fa fa-shopping-cart',
                'from_user_id' => $user_id
            ], $dept_head_id);

            set_message('success', 'Requisition submitted successfully.');
        }

        foreach ($items_to_insert as $item) {
            $item['requisition_id'] = $req_id;
            $this->db->insert('tbl_requisition_items', $item);
        }

        redirect('admin/requisition/my_requisitions');
    }

    public function view_details($id)
    {
        $this->db->select('tbl_requisitions.*, tbl_departments.deptname, tbl_account_details.fullname, tbl_account_details.avatar');
        $this->db->from('tbl_requisitions');
        $this->db->join('tbl_departments', 'tbl_departments.departments_id = tbl_requisitions.departments_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_requisitions.user_id', 'left');
        $this->db->where('tbl_requisitions.requisition_id', $id);
        $data['requisition'] = $this->db->get()->row();
        
        $data['requisition_items'] = $this->db->where('requisition_id', $id)->get('tbl_requisition_items')->result();
        $this->load->view('admin/requisition/view_requisition', $data);
    }

    public function change_status($id, $status)
    {
        $user_id = $this->session->userdata('user_id');
        $rejection_reason = $this->input->post('rejection_reason', true);
        
        $req_info = $this->db->where('requisition_id', $id)->get('tbl_requisitions')->row();

        $update = [
            'status' => $status,
            'approved_by' => $user_id,
            'approved_date' => date('Y-m-d H:i:s')
        ];
        if (!empty($rejection_reason)) {
            $update['rejection_reason'] = $rejection_reason;
        }

        $this->db->where('requisition_id', $id)->update('tbl_requisitions', $update);

        // Notify the requester about the status change
        if ($req_info && !empty($req_info->user_id) && $req_info->user_id != $user_id) {
            add_notification([
                'to_user_id' => $req_info->user_id,
                'from_user_id' => $user_id,
                'description' => 'not_requisition_status_updated',
                'value' => $req_info->requisition_no . ' (' . ucfirst($status) . ')',
                'link' => 'admin/requisition/my_requisitions',
                'icon' => ($status == 'approved') ? 'fa fa-check-circle' : 'fa fa-times-circle'
            ]);
        }

        set_message('success', 'Requisition status updated to ' . ucfirst($status));
        
        if (!empty($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect('admin/requisition/all_requisitions');
        }
    }

    public function delete($id)
    {
        $this->db->where('requisition_id', $id)->delete('tbl_requisitions');
        $this->db->where('requisition_id', $id)->delete('tbl_requisition_items');
        set_message('success', 'Requisition deleted.');
        redirect('admin/requisition/my_requisitions');
    }
}
