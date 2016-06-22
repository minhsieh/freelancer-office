<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Updates extends MX_Controller {

    private static $buyer_lang = 'We are unable to verify your purchase';
    private static $username_lang = 'Please set your envato username correctly';

    function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin') {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('access_denied'));
            redirect('logout');
        }
        $this->load->helper('curl');
        $this->load->helper('file');
        $this->clean_old_files();
    }

    function index() {
        $this->load->module('layouts');
        $this->load->library('template');

        $this->template->title(lang('updates') . ' - ' . config_item('company_name'));

        $data['page'] = lang('settings');

        Applib::pData();

        $installed_version = config_item('version');
        $releases = json_decode(remote_get_contents(UPDATE_URL . 'version.php'), true);

        Applib::switchon();

        $data['latest_version'] = $releases['version'];
        $data['release_date'] = $releases['release_date'];
        $data['update_tips'] = $releases['update_tips'];
        $data['updates'] = $this->applib->get_updates();
        $data['installed'] = $this->db->where('installed','1')->order_by('build','desc')->get('updates')->result();

        $backups = is_dir('./resource/backup/') ? get_filenames('./resource/backup/') : array();
        if (in_array('index.html', $backups)) { unset($backups[array_search('index.html', $backups)]); }
        $data['backups'] = $backups;
        
        $this->template
                ->set_layout('users')
                ->build('update', isset($data) ? $data : NULL);
    }
    
    function beta($state) {
        $value = $state == 1 ? 'TRUE' : 'FALSE';
        $this->db->where('config_key', 'beta_updates')->update('config', array("value" => $value));
        redirect($_SERVER['HTTP_REFERER']);
    }

    function get_update($update = NULL) {

        if ($update) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, UPDATE_URL . 'files/' . $update);

            $fp = fopen('./resource/updates/' . $update, 'w+');
            curl_setopt($ch, CURLOPT_FILE, $fp);

            curl_exec($ch);

            curl_close($ch);
            fclose($fp);
        }
        redirect('updates');
    }
    
    function download()
    {
        if (isset($_POST['build'])) { $build = $_POST['build']; } else { return FALSE; }
        
        $path = "./resource/updates/update-".$build.".zip";
        $url = UPDATE_URL."folite/update-".$build.".zip";
        
        $fp = fopen($path, "w+");
        $ch = curl_init(str_replace(" ","%20",$url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $curldata = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        
        $size = filesize($path);

        $data['json'] = array(
            "result"    => "1",
            "build"     => $build,
            "size"      => $size,
            "message"   => "File downloaded successfully",
        );
        $this->load->view('json',isset($data) ? $data : NULL);
    }
    
    function view() {
            $build = $this->uri->segment(3);
            $update = $this->db->where('build',$build)->get('updates')->result();
            $data['update'] = $update[0];
            $this->load->view('modal/view_update',$data);
    }

    function backup() {
        $this->mysql_backup();
        if (!is_dir('./resource/backup/')) {
            Applib::make_flashdata(
                    array(
                        'response_status' => 'error',
                        'message' => 'Create a folder named backup in resource folder'
            ));
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_writeable("./resource/backup/")) {
            Applib::make_flashdata(
                    array(
                        'response_status' => 'error',
                        'message' => 'We are unable to write to resource/backup folder'
            ));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->library('zip');
        $path = './';
        $this->zip->read_dir($path);
        $this->zip->archive('./resource/backup/freelancer_office_full_backup_' . date('Y-m-d') . '.zip');
        Applib::make_flashdata(
                array(
                    'response_status' => 'success',
                    'message' => 'Backup created and saved in resource/backup folder'
        ));
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    function check() {
        $this->applib->get_updates(TRUE);
        redirect($_SERVER['HTTP_REFERER']);
    }

    function extract()
    {
        if (isset($_POST['build'])) { $build = $_POST['build']; } else { return false; }
        
        $zip = new ZipArchive;
        if ($zip->open("./resource/updates/update-".$build.".zip") === TRUE) {
            $res = $zip->extractTo('./');
            $zip->close();
            $data['json'] = array(
                "result"    => $res,
                "build"     => $build,
                "message"   => "File extracted successfully",
            );
        } else {
            $data['json'] = array(
                "result"    => "0",
                "build"     => $build,
                "message"   => "Could not open file",
            );
        }
        $this->load->view('json',isset($data) ? $data : NULL);
    }

    function install() {
        $releases = json_decode(remote_get_contents(UPDATE_URL . 'version.php'), true);

        $latest_version = $releases['version'];
        $zip = new ZipArchive;
        if ($zip->open('./resource/updates/' . $latest_version . '.zip') === TRUE) {
            $zip->extractTo('./');
            $zip->close();
            // perform db changes
            $this->migrate_db($latest_version);
            $response = 'success';
            $message = 'Software updated successfully.';
        } else {
            $response = 'error';
            $message = 'Please click on Download Updates to continue.';
        }

        Applib::make_flashdata(
                array(
                    'response_status' => $response,
                    'message' => $message
        ));
        redirect($_SERVER['HTTP_REFERER']);
    }

    function db_upgrade() {
        if (isset($_POST['build'])) { $build = $_POST['build']; } else { return false; }
        $this->load->helper('curl');
        $url = UPDATE_URL.'folite/db/update-'.$build.'.sql';
        
        if (remote_file_exists($url)) {
            $lines = file($url, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $templine = "";
            foreach ($lines as $line)
            {
                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';') {
                    $this->db->query($templine);
                    $templine = '';
                }           
            }
        }
        // Fix database
        $this->db_upd_clients();
        $this->db_upd_users();
        
        $update = $this->db->where("build", $build)->get('updates')->result();
        $upd = $update[0];
        $dep = json_decode($upd->dependencies, TRUE);
        
        $this->db->where('build', $build)->update('updates',array('installed' => 1));
        $this->db->where('config_key', 'build')->update('config',array('value' => $build));
        
        if (!empty($dep['includes'])) {
            $this->db->where_in('build',explode(",", $dep['includes']))->update('updates',array("installed" => 1));
        }
        
        $data['json'] = array();
        $this->load->view('json',isset($data) ? $data : NULL);
    }

    function db_update() {
        $this->db_sync();
        $this->db_upgrade();
        $this->db_upd_clients();
        $this->db_upd_users();
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    function db_upd_clients() {
        $currency = config_item('default_currency');
        $language = config_item('default_language');
        $clients = $this->db->get('companies')->result();
        foreach ($clients as $client) {
            $cur = $client->currency;
            $lang = $client->language;
            if ($cur == '' || $cur == NULL || strlen($cur) != 3) {
                $this->db->where('co_id', $client->co_id)->update('companies', array('currency'=>$currency));
            } else {
                $currency = $cur;
            }
            if ($lang == '' || $lang == NULL) {
                $this->db->where('co_id', $client->co_id)->update('companies', array('language'=>$language));
            }
            $invoices = $this->db->where('client', $client->co_id)->get('invoices')->result();
            foreach ($invoices as $invoice) {
                $icur = $invoice->currency;
                if ($icur == '' || $icur == NULL || strlen($icur) != 3) {
                    $this->db->where('inv_id', $invoice->inv_id)->update('invoices', array('currency'=>$currency));
                }
            }
            $estimates = $this->db->where('client', $client->co_id)->get('estimates')->result();
            foreach ($estimates as $estimate) {
                $ecur = $estimate->currency;
                if ($ecur == '' || $ecur == NULL || strlen($ecur) != 3) {
                    $this->db->where('est_id', $estimate->est_id)->update('estimates', array('currency'=>$currency));
                }
            }
            $payments = $this->db->where('paid_by', $client->co_id)->get('payments')->result();
            foreach ($payments as $payment) {
                $pcur = $payment->currency;
                if ($pcur == '' || $pcur == NULL || strlen($pcur) != 3) {
                    $this->db->where('p_id', $payment->p_id)->update('payments', array('currency'=>$currency));
                }
            }
        }
    }

    function db_upd_users() {
        $locale = config_item('locale');
        $language = config_item('default_language');
        $users = $this->db->join('account_details','users.id = account_details.user_id')->get('users')->result();
        foreach ($users as $user) {
            if ($user->company > 0) {
                $company = $this->db->where('co_id', $user->company)->get('companies')->result();
                if (count($company) == 1) {
                    $co = $company[0];
                    $language = $co->language;
                }
            }
            $lang = $user->language;
            $loc = $user->locale;
            if ($lang == '' || $lang == NULL) {
                $this->db->where('user_id', $user->user_id)->update('users', array('language'=>$language));
            }
            if ($loc == '' || $loc == NULL) {
                $this->db->where('user_id', $user->user_id)->update('users', array('locale'=>$locale));
            }
        }
    }
    
    function db_upd_config($src) {
        $conf = $this->db->get('config')->result();
        $con = array();
        $rename = array("default_language" => "language");
        $delete = array();
        
        foreach($conf as $c) {
            $con[$c->config_key] = $c->value;
        }
        foreach($src as $key => $value) {
            if (in_array($key, $rename)) {
                $this->db->where("config_key", $rename[$key])->update("config", array("config_key" => $key));
                continue;
            }
            if (in_array($key, $delete)) {
                $this->db->delete("config", array("config_key" => $key));
                continue;
            }
            if (!isset($con[$key])) {
                $this->db->insert("config", array("config_key" => $key, "value" => $value));
                continue;
            }
        }
    }

    function db_upd_tables($data) {
        $tables = array("countries", "currencies", "languages", "locales");
        foreach($tables as $table) {
            $this->db->empty_table($table);
            $entries = $data["fx_".$table];
            foreach ($entries as $entry) {
                $this->db->insert($table, $entry);
            }
        }
    }

    function migrate_db($version = NULL) {
        $this->load->dbforge();
        $this->load->database();
        $version = ($version == NULL) ? config_item('version') : $version;
        $this->db_sync();

        $file_content = remote_get_contents(UPDATE_URL.'folite/db/upgrade.sql');
        $this->db->query('USE ' . $this->db->database . ';');
        foreach (explode(";\n", $file_content) as $sql) {
            $sql = trim($sql);
            if ($sql) {
                $this->db->query($sql);
            }
        }
        return TRUE;
    }

    function db_json($settings = array()) {
        $this->load->database();
        $this->load->helper('file');
        $url = './resource/db.json';
        $db = array(
            "schema" => array(),
            "data" => array()
        );

        $tables = $this->db->query('SHOW TABLES')->result_array();
        foreach ($tables as $table) {
            foreach ($table as $k => $name) {
                $db['schema'][$name] = array();
                $columns = $this->db->query('SHOW FULL COLUMNS FROM `' . $name . '`')->result_array();
                foreach ($columns as $col) {
                    $rows = $this->db->query('SELECT * FROM `' . $name . '`')->result_array();
                    $db['data'][$name] = $rows;
                    $db['schema'][$name][$col['Field']] = $col;
                }
            }
        }
        if (isset($settings['return'])) {
            return $db;
        }
        if (isset($settings['url'])) {
            $url = $settings['url'];
        }
        $data = json_encode($db, JSON_UNESCAPED_UNICODE);
        write_file($url, $data);
    }

    function column_string($col, $attr) {
        $query = "`".$col."`";
        $query .= " ".$attr['Type'];
        $query .= " ".($attr['Null'] == "YES" ? " NULL" : " NOT NULL");
        if ($attr['Collation'] != NULL) {
            $query .= " COLLATE ".$attr['Collation'];
        }
        if ($attr['Default'] != NULL) {
            if ($attr['Default'] == 'CURRENT_TIMESTAMP') {
                $query .= " DEFAULT ".$attr['Default']; 
            } else {
                $query .= " DEFAULT '".$attr['Default']."'"; 
            }
        } else {
            if ($attr['Null'] == "YES") {
                $query .= " DEFAULT NULL";
            }
        }
        return $query;
    }
    
    function db_sync() {
        $this->load->database();
        $this->load->helper('file');
        $source = remote_get_contents(UPDATE_URL."folite/db/db.json");
        $src = json_decode($source, TRUE);
        $db = array();
        $log = array();
            // Get local tables
        $t = $this->db->query('SHOW TABLES')->result_array();
        foreach ($t as $tab) {
            foreach ($tab as $x => $name) {
                $db[$name] = array();
            }
        }
            // Insert missing tables
        foreach ($src['schema'] as $table => $cols) {
            if (!isset($db[$table])) {
                $columns = array();
                foreach ($cols as $col => $attr) { $columns[] = $this->column_string($col, $attr); }
                $this->db->query("CREATE TABLE IF NOT EXISTS `".$table."` (".implode(",", $columns).");");
            }
        }
        foreach ($db as $name => $content) {
            if (isset($src['schema'][$name])) {
                $columns = $this->db->query('SHOW FULL COLUMNS FROM `' . $name . '`')->result_array();
                foreach ($columns as $col) {
                        // Delete obsolete columns
                    if (!isset($src['schema'][$name][$col['Field']])) {
                        $this->db->query('ALTER TABLE `' . $name . '` DROP COLUMN `' . $col['Field'] . '`');
                    } else {
                        $db[$name][$col['Field']] = $col;
                    }
                }
                $previous = '';
                foreach ($src['schema'][$name] as $field => $info) {
                        // Insert missing columns
                    if (!isset($db[$name][$field])) {
                        $this->db->query("ALTER TABLE `".$name."` ADD COLUMN ".$this->column_string($field, $info));
                        if ($info['Key'] == 'PRI') {
                            $this->db->query("ALTER TABLE `".$name."` ADD KEY `Index 1` (`".$field."`);");
                        }
                        if ($info['Extra'] == 'auto_increment') {
                            $this->db->query("ALTER TABLE `".$name."` MODIFY `".$field."` ".$info['Type']." NOT NULL AUTO_INCREMENT");
                        }
                        $log['column']['added'][] = array("table" => $name, "column" => $field);
                    } else {
                            // Synchronize existing columns
                        if (($info['Type'] != $db[$name][$field]['Type'] ||
                            $info['Null'] != $db[$name][$field]['Null'] || 
                            $info['Default'] != $db[$name][$field]['Default']) && 
                            $info['Key'] != 'PRI') {
                            $this->db->query("ALTER TABLE `".$name."` MODIFY COLUMN ".$this->column_string($field, $info));
                            $log['column']['modified'][] = array("table" => $name, "column" => $field);
                        }
                    }
                    $previous = $field;
                }
            }
        }
//        $this->db_upd_config($src['data']['fx_config']);
//        $this->db_upd_tables($src['data']);
        $data['json'] = $log;
        $this->load->view('json',isset($data) ? $data : NULL);
    }
    
    function db_check() {
        $this->load->database();
        $this->load->helper('file');
        $src = remote_get_contents(UPDATE_URL."folite/db/db.json");
        $src = json_decode($src, TRUE);
        $db = array();
        $log = array();

        // Get local tables
        $t = $this->db->query('SHOW TABLES')->result_array();
        foreach ($t as $tab) {
            foreach ($tab as $k => $name) {
                $db[$name] = array();
            }
        }
        
        // Insert missing tables
        foreach ($src['schema'] as $table => $cols) {
            if (!isset($db[$table])) {
                $log['table']['added'][] = $table;
            }
        }
        foreach ($db as $name => $content) {
            if (isset($src['schema'][$name])) {
                $columns = $this->db->query('SHOW FULL COLUMNS FROM `' . $name . '`')->result_array();
                foreach ($columns as $col) {
                    // Delete obsolete columns
                    if (!isset($src['schema'][$name][$col['Field']])) {
                        $log['column']['removed'][] = array("column" => $col['Field'], "table" => $name);
                    } else {
                        $db[$name][$col['Field']] = $col;
                    }
                }
                foreach ($src['schema'][$name] as $field => $info) {
                    
                    // Insert missing columns and synchronize existing ones
                    if (!isset($db[$name][$field])) {
                        $log['column']['added'][] = array("table" => $name, "column" => $field);
                    } else {
                        if (($info['Type'] != $db[$name][$field]['Type'] ||
                            $info['Null'] != $db[$name][$field]['Null'] || 
                            $info['Default'] != $db[$name][$field]['Default']) && 
                            $info['Key'] != 'PRI') {
                            $log['column']['modified'][] = array("table" => $name, "column" => $field);
                        }
                    }
                }
            }
        }
        
        return $log;
    }
    
    function mysql_backup() {
        $this->load->dbutil();
        $prefs = array('format' => 'zip', 'filename' => 'database-full-backup_' . date('Y-m-d'));

        $backup = & $this->dbutil->backup($prefs);

        if (!write_file('./resource/backup/database-full-backup_' . date('Y-m-d') . '.zip', $backup)) {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', 'Database backup failed cannot write to /resource/database.backup folder.');
            redirect('updates');
        }
        $this->db_json(array("data" => TRUE, "url" => './resource/backup/database-full-backup_' . date('Y-m-d') . '.json'));
        return true;
    }

    public function clean_old_files() {
        if (is_dir('./UPDATES/')) {
            if (!rmdir('./UPDATES'))
                rename('./UPDATES', './delete_this');
        }
    }

}

/* End of file updater.php */