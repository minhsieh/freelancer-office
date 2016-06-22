<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Demo_data extends MX_Controller {


    function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin') {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('access_denied'));
            redirect('logout');
        }
        $this->load->helper('curl','file');
    }

    function index() {
        
    }



    function clean_my_data() {
        $this->load->dbforge();
        $this->load->database();

        $file_content = remote_get_contents(UPDATE_URL.'files/demo.sql');
        $this->db->query('USE ' . $this->db->database . ';');
        foreach (explode(";\n", $file_content) as $sql) {
            $sql = trim($sql);
            if ($sql) {
                $this->db->query($sql);
            }
        }
       die('Demo data installed');
    }

}

/* End of file updater.php */