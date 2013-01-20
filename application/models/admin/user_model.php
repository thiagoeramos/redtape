<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
	
	private $tablename;
	private $per_page;
	
	function __construct()
	{
		parent::__construct();

		$this->tablename	= 'users';
		$this->per_page		= 10;
	}

	
	
	public final function is_logged()
	{
		if($this->session->userdata('user_logged')){
			
			$data = $this->by(array('id' => $this->session->userdata('user_id')));
			
			if(count($data) > 0){
				return true;
			}
		}
		
		//redirect('admin/login');
	}
	
	public final function login($email, $password)
	{
		return false;
	}
	
	
	
}
