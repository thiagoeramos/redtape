<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model de Parâmetros
 * @author Felipe <felipe@wadtecnologia.com.br>
 */
class Parameter_model extends CI_Model{
	
	private $tablename;
	private $per_page;
	
	public final function __construct()
	{
		parent::__construct();
		
		$this->tablename	= 'sys_parameter';
		$this->per_page		= $this->get('rows_per_page');
	}
	
	public final function by($by, $value)
	{
		$query = $this->db->get_where($this->tablename, array('status_id >' => 0, $by => $value));
		
		if($query->num_rows() > 0){
			return $query->result();
		}
		
		return false;
	}
	
	public final function get($name)
	{
		$query = $this->db->get_where($this->tablename, array('status_id >' => 0, 'name' => $name));
		
		if($query->num_rows() > 0){
			$row = $query->result();
			return $row[0]->value;
		}
	}
	
	public final function create($data)
	{
		if($this->db->insert($this->tablename, $data)){
			return true;
		}
		
		return false;
	}
	
	public final function total($start=0)
	{
		$this->db->where(array('status_id' => 1));
		
		return $this->db->count_all_results($this->tablename);
	}
	
	public final function read_pag($limit = 0, $page_now = 0, $search = null)
	{
		$result = array(
                'count' => 0,
                'rows' => array()
            );
		 
		$this->db->select('*');
		$this->db->from($this->tablename);
		$this->db->where(array('status_id' => 1));
		$this->db->order_by('name');
		
		if(isset($limit))
		{
			$this->db->limit($limit, $page_now);
		}
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){			
			$result['rows'] = $query->result();
			$result['count'] = $query->num_rows();
			return $result;
		}
		
		return false;
	}
	
	public final function read($start=0)
	{
		$query = $this->db->get_where(
			$this->tablename,
			array('status_id >' => 0),
			$this->per_page,
			$start
		);
		
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
	
	public final function update($id, $data)
	{
		$this->db->where('id', $id);
		
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
