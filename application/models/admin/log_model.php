<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model de LOG do Sistema
 * @author Felipe <felipe@wadtecnologia.com.br>
 */
class Log_model extends CI_Model{

	private $tablename;

	function __construct()
	{
		parent::__construct();
		$this->tablename = 'sys_log';
	}

	public final function log($model, $action,$POST=array())
	{	
		
		$this->session->set_userdata('ip_address',gethostbyname($_SERVER["SERVER_NAME"]));
		
		$data = array(
			'user_id'		=> $this->session->userdata('user_id'),
			'session_id' 	=> $this->session->userdata('session_id'),
			'user_ip' 		=> $this->session->userdata('ip_address'),
			'user_browser' 	=> $this->session->userdata('user_agent'),
			'user_url' 		=> current_url(),
			'user_post' 	=> print_r($POST, TRUE),
			'model'			=> $model,
			'action'		=> $action
		);

		if($this->db->insert($this->tablename, $data)){
			return true;
		}

		return false;
	}
}