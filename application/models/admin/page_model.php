<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model de Páginas do Sistema
 * @author Felipe <felipe@wadtecnologia.com.br>
 */
class Page_model extends CI_Model{
	
	private $tablename;
	private $per_page;
	
	public final function __construct()
	{
		parent::__construct();
		$this->tablename	= 'sys_page';
		$this->per_page		= $this->parameter_model->get('rows_per_page');
	}
	
	public final function by($where = array())
	{
		$where['status_id'] = 1;
		
		$query = $this->db->get_where($this->tablename, $where);
		
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
	
	public final function total($start = 0)
	{
		$this->db->where(array('status_id' => 1));
		
		return $this->db->count_all_results($this->tablename);
	}
	
	public final function read($start = 0)
	{
		$this->db->select('*');
		$this->db->from($this->tablename);
		$this->db->where(array('status_id >' => 0));
		$this->db->order_by("name", "asc");
		$this->db->limit($this->per_page, $start);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return array($query->result(), $query->num_rows());
		}
		
		return false;
	}
	
	public final function all()
	{
		$query = $this->db->get_where($this->tablename, array('status_id' => 1));
		
		if($query->num_rows() > 0){
			return $query->result();
		}
		
		return false;
	}
	
	public final function update($id, $hash)
	{
		$data = array();
		
		$data['url'] = $this->input->post('url', TRUE);
		$data['title'] = $this->input->post('title', TRUE);
		$data['description'] = $this->input->post('description', TRUE);
		
		//printr($data);
		
		$this->db->where(array('id' => $id, 'hash' => $hash));
		
		if($this->db->update($this->tablename, $data)){
			return true;
		}
		
		return false;
	}
	
	public final function delete($id)
	{
		$this->db->where('id', $id);
		
		if($this->db->update($this->tablename, array('status_id' => 0))){
			return true;
		}
		
		return false;
	}
}
