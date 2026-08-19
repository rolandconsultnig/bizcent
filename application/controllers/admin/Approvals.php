<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Approvals extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

    public function index()
    {
        $this->pending();
    }

    public function pending()
    {
        $data['title'] = lang('approvals_hub');

        // 1. Pending Requisitions
        $this->db->select('tbl_requisitions.*, tbl_account_details.fullname, tbl_departments.deptname');
        $this->db->from('tbl_requisitions');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_requisitions.user_id', 'left');
        $this->db->join('tbl_departments', 'tbl_departments.departments_id = tbl_requisitions.departments_id', 'left');
        $this->db->where('tbl_requisitions.status', 'pending');
        $this->db->order_by('tbl_requisitions.requisition_id', 'DESC');
        $data['pending_requisitions'] = $this->db->get()->result();

        // 2. Pending Petty Cash Replenishments
        $this->db->select('tbl_petty_cash_replenishments.*, tbl_petty_cash_accounts.account_name, tbl_account_details.fullname as requester_name');
        $this->db->from('tbl_petty_cash_replenishments');
        $this->db->join('tbl_petty_cash_accounts', 'tbl_petty_cash_accounts.petty_account_id = tbl_petty_cash_replenishments.petty_account_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_petty_cash_replenishments.requested_by', 'left');
        $this->db->where('tbl_petty_cash_replenishments.status', 'pending');
        $data['pending_replenishments'] = $this->db->get()->result();

        // 3. Pending Leave Applications
        $this->db->select('tbl_leave_application.*, tbl_account_details.fullname');
        $this->db->from('tbl_leave_application');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_leave_application.user_id', 'left');
        $this->db->where('tbl_leave_application.application_status', '1');
        $data['pending_leaves'] = $this->db->get()->result();

        // 4. Pending Advance Salary
        $this->db->select('tbl_advance_salary.*, tbl_account_details.fullname');
        $this->db->from('tbl_advance_salary');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_advance_salary.user_id', 'left');
        $this->db->where('tbl_advance_salary.status', '0');
        $data['pending_advances'] = $this->db->get()->result();

        $data['subview'] = $this->load->view('admin/approvals/pending', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function action_item($type, $id, $action)
    {
        $user_id = $this->session->userdata('user_id');
        $status = ($action == 'approve') ? 'approved' : 'rejected';

        if ($type == 'requisition') {
            $req = $this->db->where('requisition_id', $id)->get('tbl_requisitions')->row();
            $this->db->where('requisition_id', $id)->update('tbl_requisitions', [
                'status' => $status,
                'approved_by' => $user_id,
                'approved_date' => date('Y-m-d H:i:s')
            ]);

            if ($req && !empty($req->user_id) && $req->user_id != $user_id) {
                add_notification([
                    'to_user_id' => $req->user_id,
                    'from_user_id' => $user_id,
                    'description' => 'not_requisition_status_updated',
                    'value' => $req->requisition_no . ' (' . ucfirst($status) . ')',
                    'link' => 'admin/requisition/my_requisitions',
                    'icon' => ($status == 'approved') ? 'fa fa-check-circle' : 'fa fa-times-circle'
                ]);
            }

            set_message('success', 'Requisition ' . ucfirst($status));
        } elseif ($type == 'replenishment') {
            $rep = $this->db->where('replenishment_id', $id)->get('tbl_petty_cash_replenishments')->row();
            if ($rep) {
                $this->db->where('replenishment_id', $id)->update('tbl_petty_cash_replenishments', [
                    'status' => $status,
                    'approved_by' => $user_id,
                    'approved_date' => date('Y-m-d H:i:s')
                ]);
                if ($status == 'approved') {
                    $acc = $this->db->where('petty_account_id', $rep->petty_account_id)->get('tbl_petty_cash_accounts')->row();
                    if ($acc) {
                        $this->db->where('petty_account_id', $acc->petty_account_id)->update('tbl_petty_cash_accounts', [
                            'current_balance' => $acc->current_balance + $rep->requested_amount
                        ]);
                    }
                }

                if (!empty($rep->requested_by) && $rep->requested_by != $user_id) {
                    add_notification([
                        'to_user_id' => $rep->requested_by,
                        'from_user_id' => $user_id,
                        'description' => 'not_petty_cash_status_updated',
                        'value' => $rep->ref_no . ' (' . ucfirst($status) . ')',
                        'link' => 'admin/petty_cash/replenishments',
                        'icon' => ($status == 'approved') ? 'fa fa-check-circle' : 'fa fa-times-circle'
                    ]);
                }
            }
            set_message('success', 'Replenishment ' . ucfirst($status));
        }

        redirect('admin/approvals/pending');
    }
}
