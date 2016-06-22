<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
* Copyright: gitbench 2014
* Licence: Please check CodeCanyon.net for licence details. 
* More licence clarification available here: htttp://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
* CodeCanyon User: http://codecanyon.net/user/gitbench
* CodeCanyon Project: http://codecanyon.net/item/freelancer-office/8870728
* Package Date: 2014-09-24 09:33:11 
***********************************************************************************
*/


class Calendar extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('tank_auth'));
    }

    function index()
    {
                $this->load->module('layouts');
                $this->load->library('template');
                $this->template->title(lang('calendar'));
                $data['fullcalendar'] = TRUE;
                $data['page'] = lang('calendar');
                $data['role'] = $this->tank_auth->get_role_id();
                $this->template
                ->set_layout('users')
                ->build('calendar',isset($data) ? $data : NULL);

    }
    function settings()
    {
                if ($_POST) {
                    $this->db->where('config_key','gcal_api_key')->update('config',array('value' => $_POST['gcal_api_key']));
                    $this->db->where('config_key','gcal_id')->update('config',array('value' => $_POST['gcal_id']));
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->load->view('modal/calendar-settings',isset($data) ? $data : NULL);
                }
    }
        
        function event($type, $id) {
                
            switch ($type) {
                case "tasks" : 
                    $tasks = $this->db
                                ->join('projects','project_id = project')
                                ->join('users','id = added_by')
                                ->where('t_id',$id)
                                ->get('tasks')
                                ->result();
                    $data['task'] = $tasks[0];
                    break;
                case "payments" : 
                    $payments = $this->db
                                ->join('payment_methods','method_id = payment_method')
                                ->join('companies','paid_by = co_id')
                                ->join('invoices','inv_id = invoice')
                                ->where('p_id',$id)
                                ->get('payments')
                                ->result();
                    $data['payment'] = $payments[0];
                    break;
                case "projects" : 
                    $projects = $this->db
                                ->join('companies','client = co_id')
                                ->where('project_id',$id)
                                ->get('projects')
                                ->result();
                    $data['project'] = $projects[0];
                    break;
                case "invoices" : 
                    $invoices = $this->db
                                ->join('companies','client = co_id')
                                ->where('inv_id',$id)
                                ->get('invoices')
                                ->result();
                    $data['invoice'] = $invoices[0];
                    break;
                case "estimates" : 
                    $estimates = $this->db
                                ->join('companies','client = co_id')
                                ->where('est_id',$id)
                                ->get('estimates')
                                ->result();
                    $data['estimate'] = $estimates[0];
                    break;
            }

                $this->load->view('modal/event-details',isset($data) ? $data : NULL);
		}
}
