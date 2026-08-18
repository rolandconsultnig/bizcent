<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Petty_cash extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

    public function index()
    {
        $this->vouchers();
    }

    // 1. Petty Cash Accounts
    public function accounts()
    {
        $data['title'] = lang('petty_cash_accounts');
        $this->db->select('tbl_petty_cash_accounts.*, tbl_account_details.fullname as custodian_name');
        $this->db->from('tbl_petty_cash_accounts');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_petty_cash_accounts.custodian_id', 'left');
        $data['accounts'] = $this->db->get()->result();
        $data['users'] = $this->db->get('tbl_users')->result();

        $data['subview'] = $this->load->view('admin/petty_cash/accounts', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_account($id = null)
    {
        $data = [
            'account_name' => $this->input->post('account_name', true),
            'custodian_id' => $this->input->post('custodian_id', true),
            'float_limit' => (float)$this->input->post('float_limit', true),
            'current_balance' => (float)$this->input->post('current_balance', true),
            'status' => 1
        ];

        if (!empty($id)) {
            $this->db->where('petty_account_id', $id)->update('tbl_petty_cash_accounts', $data);
            set_message('success', 'Petty Cash Account updated.');
        } else {
            $this->db->insert('tbl_petty_cash_accounts', $data);
            set_message('success', 'New Petty Cash Account created.');
        }
        redirect('admin/petty_cash/accounts');
    }

    // 2. Disbursement Vouchers
    public function vouchers()
    {
        $data['title'] = lang('petty_cash_vouchers');
        $this->db->select('tbl_petty_cash_vouchers.*, tbl_petty_cash_accounts.account_name, tbl_account_details.fullname as creator_name');
        $this->db->from('tbl_petty_cash_vouchers');
        $this->db->join('tbl_petty_cash_accounts', 'tbl_petty_cash_accounts.petty_account_id = tbl_petty_cash_vouchers.petty_account_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_petty_cash_vouchers.created_by', 'left');
        $this->db->order_by('tbl_petty_cash_vouchers.voucher_id', 'DESC');
        $data['vouchers'] = $this->db->get()->result();

        $data['accounts'] = $this->db->get('tbl_petty_cash_accounts')->result();

        $data['subview'] = $this->load->view('admin/petty_cash/vouchers', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_voucher($id = null)
    {
        $user_id = $this->session->userdata('user_id');
        $amount = (float)$this->input->post('amount', true);
        $petty_account_id = $this->input->post('petty_account_id', true);

        $data = [
            'petty_account_id' => $petty_account_id,
            'date' => $this->input->post('date', true) ? date('Y-m-d', strtotime($this->input->post('date', true))) : date('Y-m-d'),
            'payee' => $this->input->post('payee', true),
            'category' => $this->input->post('category', true) ?: 'Office Supplies',
            'amount' => $amount,
            'description' => $this->input->post('description', true),
            'status' => 'approved',
            'created_by' => $user_id
        ];

        // Deduct from Petty Cash balance
        $petty = $this->db->where('petty_account_id', $petty_account_id)->get('tbl_petty_cash_accounts')->row();
        if ($petty) {
            $new_balance = max(0, $petty->current_balance - $amount);
            $this->db->where('petty_account_id', $petty_account_id)->update('tbl_petty_cash_accounts', ['current_balance' => $new_balance]);
        }

        if (!empty($id)) {
            $this->db->where('voucher_id', $id)->update('tbl_petty_cash_vouchers', $data);
            set_message('success', 'Petty Cash Voucher updated.');
        } else {
            $data['voucher_no'] = 'PCV-' . date('Ymd') . '-' . rand(100, 999);
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_petty_cash_vouchers', $data);
            set_message('success', 'Petty Cash Voucher recorded.');
        }
        redirect('admin/petty_cash/vouchers');
    }

    // 3. Replenishment Requests
    public function replenishments()
    {
        $data['title'] = lang('replenishments');
        $this->db->select('tbl_petty_cash_replenishments.*, tbl_petty_cash_accounts.account_name, tbl_account_details.fullname as requester_name');
        $this->db->from('tbl_petty_cash_replenishments');
        $this->db->join('tbl_petty_cash_accounts', 'tbl_petty_cash_accounts.petty_account_id = tbl_petty_cash_replenishments.petty_account_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_petty_cash_replenishments.requested_by', 'left');
        $this->db->order_by('tbl_petty_cash_replenishments.replenishment_id', 'DESC');
        $data['replenishments'] = $this->db->get()->result();

        $data['accounts'] = $this->db->get('tbl_petty_cash_accounts')->result();

        $data['subview'] = $this->load->view('admin/petty_cash/replenishments', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_replenishment()
    {
        $user_id = $this->session->userdata('user_id');
        $data = [
            'ref_no' => 'REP-' . date('Ymd') . '-' . rand(100, 999),
            'petty_account_id' => $this->input->post('petty_account_id', true),
            'requested_amount' => (float)$this->input->post('requested_amount', true),
            'reason' => $this->input->post('reason', true),
            'status' => 'pending',
            'requested_by' => $user_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tbl_petty_cash_replenishments', $data);
        set_message('success', 'Replenishment request submitted for approval.');
        redirect('admin/petty_cash/replenishments');
    }

    public function change_replenishment_status($id, $status)
    {
        $user_id = $this->session->userdata('user_id');
        $rep = $this->db->where('replenishment_id', $id)->get('tbl_petty_cash_replenishments')->row();
        if ($rep) {
            $this->db->where('replenishment_id', $id)->update('tbl_petty_cash_replenishments', [
                'status' => $status,
                'approved_by' => $user_id,
                'approved_date' => date('Y-m-d H:i:s')
            ]);

            if ($status == 'approved') {
                // Credit petty cash account
                $acc = $this->db->where('petty_account_id', $rep->petty_account_id)->get('tbl_petty_cash_accounts')->row();
                if ($acc) {
                    $new_bal = $acc->current_balance + $rep->requested_amount;
                    $this->db->where('petty_account_id', $acc->petty_account_id)->update('tbl_petty_cash_accounts', ['current_balance' => $new_bal]);
                }
            }
            set_message('success', 'Replenishment request ' . ucfirst($status));
        }
        redirect('admin/petty_cash/replenishments');
    }

    // 4. Reconciliation Log
    public function reconciliation()
    {
        $data['title'] = lang('reconciliation_log');
        $account_id = $this->input->get('account_id', true);
        
        $data['accounts'] = $this->db->get('tbl_petty_cash_accounts')->result();
        $data['selected_account_id'] = $account_id ?: (!empty($data['accounts'][0]) ? $data['accounts'][0]->petty_account_id : null);

        if (!empty($data['selected_account_id'])) {
            $data['account'] = $this->db->where('petty_account_id', $data['selected_account_id'])->get('tbl_petty_cash_accounts')->row();
            $data['vouchers'] = $this->db->where('petty_account_id', $data['selected_account_id'])->order_by('date', 'DESC')->get('tbl_petty_cash_vouchers')->result();
            $data['replenishments'] = $this->db->where('petty_account_id', $data['selected_account_id'])->where('status', 'approved')->order_by('approved_date', 'DESC')->get('tbl_petty_cash_replenishments')->result();
        }

        $data['subview'] = $this->load->view('admin/petty_cash/reconciliation', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }
}
