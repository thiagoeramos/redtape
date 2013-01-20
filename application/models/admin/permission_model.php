<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model de Permissões
 * @author Felipe <felipe@wadtecnologia.com.br>
 */
class Permission_model extends CI_Model{
	
	private $tablename;
	private $per_page;
	
	function __construct()
	{
		parent::__construct();
		
		$this->tablename	= 'sys_permission';
		$this->per_page		= $this->parameter_model->get('rows_per_page');
	}
	
	public final function by($by, $value)
	{
		$query = $this->db->get_where($this->tablename, array('status_id >' => 0, $by => $value));
		
		if($query->num_rows() > 0){
			return $query->result();
		}
		
		return false;
	}
	
	public final function total($start=0)
	{
		$this->db->where(array('status_id' => 1));
		
		return $this->db->count_all_results($this->tablename);
	}
	
	public final function read($start=0)
	{
		$this->db->select('sys_permission.*, sys_group.name as group_name');
		$this->db->from($this->tablename);
		$this->db->join('sys_group', 'sys_group.id = sys_permission.group_id');
		$this->db->limit($this->per_page, $start);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return array($query->result(), $query->num_rows());
		}
		
		return false;
	}
	
	public final function all()
	{
		$query = $this->db->get($this->tablename);
		
		if($query->num_rows() > 0){
			return $query->result();
		}
		
		return false;
	}
	
	public final function create($data)
	{
		if($this->db->insert($this->tablename, $data)){
			return true;
		}
		
		return false;
	}
	
	public final function delete($id)
	{
		if($this->db->delete($this->tablename, array('id' => $id))){
			return true;
		}
		
		return false;
	}
}
