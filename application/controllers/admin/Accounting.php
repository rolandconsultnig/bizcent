<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Accounting extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

    public function index()
    {
        $this->chart_of_accounts();
    }

    // 1. Chart of Accounts
    public function chart_of_accounts()
    {
        $data['title'] = lang('chart_of_accounts');
        $data['assets'] = $this->db->where('account_type', 'asset')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['liabilities'] = $this->db->where('account_type', 'liability')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['equity'] = $this->db->where('account_type', 'equity')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['revenue'] = $this->db->where('account_type', 'revenue')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['expenses'] = $this->db->where('account_type', 'expense')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();

        $data['subview'] = $this->load->view('admin/accounting/chart_of_accounts', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_account($id = null)
    {
        $data = [
            'account_code' => $this->input->post('account_code', true),
            'account_name' => $this->input->post('account_name', true),
            'account_type' => $this->input->post('account_type', true),
            'description' => $this->input->post('description', true),
            'balance' => (float)$this->input->post('balance', true),
            'status' => 1
        ];

        if (!empty($id)) {
            $this->db->where('account_id', $id)->update('tbl_chart_of_accounts', $data);
            set_message('success', 'Account updated successfully.');
        } else {
            $this->db->insert('tbl_chart_of_accounts', $data);
            set_message('success', 'New account added to Chart of Accounts.');
        }
        redirect('admin/accounting/chart_of_accounts');
    }

    // 2. Journal Entries
    public function journal_entries()
    {
        $data['title'] = lang('journal_entries');
        $this->db->select('tbl_journal_entries.*, tbl_account_details.fullname');
        $this->db->from('tbl_journal_entries');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_journal_entries.created_by', 'left');
        $this->db->order_by('tbl_journal_entries.journal_id', 'DESC');
        $data['journal_entries'] = $this->db->get()->result();

        $data['subview'] = $this->load->view('admin/accounting/journal_entries', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function new_journal_entry()
    {
        $data['title'] = 'New Journal Entry';
        $data['accounts'] = $this->db->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['subview'] = $this->load->view('admin/accounting/new_journal_entry', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_journal_entry()
    {
        $user_id = $this->session->userdata('user_id');
        $entry_date = $this->input->post('entry_date', true) ?: date('Y-m-d');
        $reference_no = $this->input->post('reference_no', true);
        $notes = $this->input->post('notes', true);

        $account_ids = $this->input->post('account_id', true) ?: [];
        $debits = $this->input->post('debit', true) ?: [];
        $credits = $this->input->post('credit', true) ?: [];
        $memos = $this->input->post('memo', true) ?: [];

        $total_debit = 0;
        $total_credit = 0;
        $items = [];

        for ($i = 0; $i < count($account_ids); $i++) {
            if (!empty($account_ids[$i])) {
                $deb = (float)($debits[$i] ?? 0);
                $cred = (float)($credits[$i] ?? 0);
                if ($deb > 0 || $cred > 0) {
                    $total_debit += $deb;
                    $total_credit += $cred;
                    $items[] = [
                        'account_id' => $account_ids[$i],
                        'debit' => $deb,
                        'credit' => $cred,
                        'memo' => $memos[$i] ?? ''
                    ];
                }
            }
        }

        // Validate double-entry balance
        if (abs($total_debit - $total_credit) > 0.01 || $total_debit == 0) {
            set_message('error', 'Double-entry violation: Total debits (' . display_money($total_debit) . ') must equal total credits (' . display_money($total_credit) . ') and be greater than 0.');
            redirect('admin/accounting/new_journal_entry');
            return;
        }

        $entry_number = 'JV-' . date('Ymd') . '-' . rand(1000, 9999);
        $journal_data = [
            'entry_number' => $entry_number,
            'entry_date' => date('Y-m-d', strtotime($entry_date)),
            'reference_no' => $reference_no,
            'notes' => $notes,
            'total_debit' => $total_debit,
            'total_credit' => $total_credit,
            'created_by' => $user_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('tbl_journal_entries', $journal_data);
        $journal_id = $this->db->insert_id();

        foreach ($items as $item) {
            $item['journal_id'] = $journal_id;
            $this->db->insert('tbl_journal_items', $item);

            // Update account balance
            $acc = $this->db->where('account_id', $item['account_id'])->get('tbl_chart_of_accounts')->row();
            if ($acc) {
                // Asset & Expense increase on debit, decrease on credit
                // Liability, Equity, Revenue increase on credit, decrease on debit
                if (in_array($acc->account_type, ['asset', 'expense'])) {
                    $new_bal = $acc->balance + $item['debit'] - $item['credit'];
                } else {
                    $new_bal = $acc->balance + $item['credit'] - $item['debit'];
                }
                $this->db->where('account_id', $acc->account_id)->update('tbl_chart_of_accounts', ['balance' => $new_bal]);
            }
        }

        set_message('success', 'Journal Entry ' . $entry_number . ' posted successfully.');
        redirect('admin/accounting/journal_entries');
    }

    public function view_journal($id)
    {
        $data['journal'] = $this->db->where('journal_id', $id)->get('tbl_journal_entries')->row();
        $this->db->select('tbl_journal_items.*, tbl_chart_of_accounts.account_code, tbl_chart_of_accounts.account_name, tbl_chart_of_accounts.account_type');
        $this->db->from('tbl_journal_items');
        $this->db->join('tbl_chart_of_accounts', 'tbl_chart_of_accounts.account_id = tbl_journal_items.account_id', 'left');
        $this->db->where('tbl_journal_items.journal_id', $id);
        $data['items'] = $this->db->get()->result();

        $this->load->view('admin/accounting/view_journal', $data);
    }

    // 3. General Ledger
    public function general_ledger()
    {
        $data['title'] = lang('general_ledger');
        $account_id = $this->input->get('account_id', true);
        $start_date = $this->input->get('start_date', true) ?: date('Y-01-01');
        $end_date = $this->input->get('end_date', true) ?: date('Y-12-31');

        $data['accounts'] = $this->db->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['selected_account_id'] = $account_id;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        if (!empty($account_id)) {
            $data['account'] = $this->db->where('account_id', $account_id)->get('tbl_chart_of_accounts')->row();
            $this->db->select('tbl_journal_items.*, tbl_journal_entries.entry_number, tbl_journal_entries.entry_date, tbl_journal_entries.reference_no, tbl_journal_entries.notes');
            $this->db->from('tbl_journal_items');
            $this->db->join('tbl_journal_entries', 'tbl_journal_entries.journal_id = tbl_journal_items.journal_id', 'inner');
            $this->db->where('tbl_journal_items.account_id', $account_id);
            $this->db->where('tbl_journal_entries.entry_date >=', $start_date);
            $this->db->where('tbl_journal_entries.entry_date <=', $end_date);
            $this->db->order_by('tbl_journal_entries.entry_date', 'ASC');
            $data['transactions'] = $this->db->get()->result();
        }

        $data['subview'] = $this->load->view('admin/accounting/general_ledger', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    // 4. Trial Balance
    public function trial_balance()
    {
        $data['title'] = lang('trial_balance');
        $data['accounts'] = $this->db->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        
        $data['subview'] = $this->load->view('admin/accounting/trial_balance', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    // 5. Balance Sheet
    public function balance_sheet()
    {
        $data['title'] = lang('balance_sheet');
        $data['assets'] = $this->db->where('account_type', 'asset')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['liabilities'] = $this->db->where('account_type', 'liability')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['equity'] = $this->db->where('account_type', 'equity')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        
        // Calculate Net Income to include in Equity
        $rev = $this->db->where('account_type', 'revenue')->select_sum('balance')->get('tbl_chart_of_accounts')->row();
        $exp = $this->db->where('account_type', 'expense')->select_sum('balance')->get('tbl_chart_of_accounts')->row();
        $data['net_income'] = ($rev->balance ?? 0) - ($exp->balance ?? 0);

        $data['subview'] = $this->load->view('admin/accounting/balance_sheet', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    // 6. Income Statement (P&L)
    public function income_statement()
    {
        $data['title'] = lang('income_statement');
        $data['revenue'] = $this->db->where('account_type', 'revenue')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();
        $data['expenses'] = $this->db->where('account_type', 'expense')->order_by('account_code', 'ASC')->get('tbl_chart_of_accounts')->result();

        $data['subview'] = $this->load->view('admin/accounting/income_statement', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }
}
