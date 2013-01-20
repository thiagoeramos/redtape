<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model de Racional
 * @author Felipe <albert@questa.com.br>
 */
class Channels_model extends CI_Model{
	
	private $tablename;
	private $per_page;
	
	public final function __construct()
	{
		parent::__construct();
		
		$this->tablename	= 'sys_channels';
		$this->per_page		= $this->parameter_model->get('rows_per_page');
	
	}
	
	public final function by($where = array(),$group_by='id')
	{
		if($group_by!='id'){
			$group_type_changer=explode(',',$this->parameter_model->get('change_status_group_id'));
			if(!in_array($this->session->userdata('group_id'),$group_type_changer)){
				$this->db->where_in('sys_channels.id',explode(',',$this->session->userdata('channel_id')));
			}
		}
		$where['status_id'] = '1';
		$this->db->select('*');
		$this->db->from($this->tablename);	
		$this->db->where($where);
		$this->db->group_by($group_by);
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return false;
	}
	public final function create($data = array())
	{
		$data['idHash']			= getHash();
		$data['created_in']		= date('Y-m-d H:i:s');
		$data['status_id'] 		= $this->input->post('status_id', TRUE);
		
		if($this->db->insert($this->tablename, $data)){
			return true;
		}
		
		return false;
	}
	
	public final function total()
	{
		$this->db->where(array('status_id' => '1'));
		
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
		
		$this->getWhere($search);		
		
		$this->db->order_by('name');
		
		if(isset($limit))
		{
			$this->db->limit($limit, $page_now);
		}
		
		$query = $this->db->get();
	
		if($query->num_rows() > 0){			
			$result['rows'] = $query->result_array();
			$result['count'] = $query->num_rows();
			return $result;
		}
		
		return false;
	}
	
	public final function read($start=0)
	{
		$query = $this->db->get_where($this->tablename, array('status_id' => '1'), $this->per_page, $start);
		
		if($query->num_rows() > 0){
			return array($query->result(), $query->num_rows());
		}
		
		return false;
	}
	
	public final function all()
	{
		$query = $this->db->get_where($this->tablename, array('status_id' => '1'));
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		
		return false;
	}
	
	public final function update($id, $hash, $data = array())
	{
		$data['update_in']		= date('Y-m-d H:i:s');
		$data['status_id'] 		= $this->input->post('status_id', TRUE);
		
		$this->db->where(array('id' => $id, 'idHash' => $hash));
		
		if($this->db->update($this->tablename, $data)){
			return true;
		}
		
		return false;
	}
	
	
	public final function delete($id = '', $idHash = '')
	{
		$this->db->where(array('id' => $id, 'idHash' => $idHash));
		
		if($this->db->update($this->tablename, array('status_id' => 0))){
			return true;
		}
		
		return false;
	}
	
	public final function id_or_create($name)
	{
		$query = $this->db->get_where($this->tablename, array('name' => $name));
		
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->id;
		} else {
			if($this->db->insert($this->tablename, array('name' => $name))){
				return $this->db->insert_id();
			}
		}
		
		return false;
	}
	
	public final function import_data($data = array())
	{
		//die('acesso negado!!');
		
		if(count($data) > 0){
			
			foreach($data as $k=>$v){
				
				$insert = array();
				$channel 	= array();
				
				//if($v['tipo']=='direto'){$v['tipo']=1;}else{$v['tipo']=2;}
				
				$channel['name']			= $v['nome'];
				//$channel['type']			= $this->getType($v['tipo']);
				$channel['created_in']		= date('Y-m-d H:i:s');
				$channel['status_id'] 		= '1';
				
				if(!$this->db->insert($this->tablename, $channel)){
					echo 'Erro na Inserção dos seguintes dados: <br>';
					printr($rational);
				}
			}
			
			die('Importação Finalizada.');
		}
		
		die('Arquivo vazio para importação, ou cabeçalho incorreto.');
	}
		// **** MÉTODO GENIAL ************************************************************************
	public final function getWhere($data)
	{
			if(isset($data['seeking']) && @$data['seeking']){	
				$this->db->like('name', $data['seeking']);
			}
			
			if(isset($data['start_in']) && @$data['start_in']){			
				$this->db->where(array('created_in >= ' => format_date_to_mysql($data['start_in'])));
			}
			if(isset($data['end_in']) && @$data['end_in']){				
				$this->db->where(array('created_in <= ' => format_date_to_mysql($data['end_in'])));
			}
			if(isset($data['status_id']) && @$data['status_id']){			
				$this->db->where(array('status_id ' => $data['status_id']));
			}else{
				$this->db->where(array('status_id > ' => 0));
			}
	}
	
}
