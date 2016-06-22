<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @package	Freelance Office
 * @author	William M
 */
class Welcome extends CI_Model
{
	

	function recent_projects($user,$limit)
	{   
		$this->db->join('assign_projects','assign_projects.project_assigned = projects.project_id');
		$this->db->where('assigned_user', $user);
		return $this->db->order_by('date_created','desc')->group_by('project_assigned')->get(Applib::$projects_table,$limit)->result();
	}
	function recent_tasks($user,$limit)
	{
		$this->db->join('assign_tasks','assign_tasks.task_assigned = tasks.t_id');
		$this->db->where('assigned_user', $user);
		return $this->db->order_by('assign_date','desc')->group_by('task_assigned')->get(Applib::$tasks_table,$limit)->result();
	}
	function recent_activities($limit)
	{
		$query = $this->db->where('user',$this->tank_auth->get_user_id())->order_by('activity_date','DESC')->get(Applib::$activities_table,$limit);
		if ($query->num_rows() > 0){
			return $query->result();
		} 
	}
	function _assigned_projects($user){
		$query = $this->db->select('project_assigned')->where('assigned_user',$user)->get('assign_projects');
		if ($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	function search_payment($keyword)
	{
		$this->db->where('paid_by', Applib::profile_info($this->tank_auth->get_user_id())->company);
		return $this->db->like('trans_id', $keyword)->order_by("created_date","desc")->get(Applib::$payments_table)->result();
	}
	
}

/* End of file model.php */