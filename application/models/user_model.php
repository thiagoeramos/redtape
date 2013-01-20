<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model de Usuários
 * @author Felipe <felipe@wadtecnologia.com.br>
 */
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
				
				if($data[0]['first_update'] == 1){
					redirect('usuarios/primeiro-acesso/');
				}
				
				return true;
			}
		}
		
		redirect('/login');
	}
	
	public final function login($email, $password)
	{		
		$this->db->select('*');
		$this->db->from($this->tablename);
		$this->db->where(array(
			'email'			=> $email,
			'password'		=> md5($password),
			'status_id'		=> 1
		));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			
			$user_data = $query->result_array();
			
			$this->session->set_userdata('user_logged',	true);
			$this->session->set_userdata('user_id', $user_data[0]['id']);
			$this->session->set_userdata('user_id_hash', $user_data[0]['hash_id']);
			$this->session->set_userdata('group_id', $user_data[0]['group_id']);
			$this->session->set_userdata('regional_id', $user_data[0]['regional_id']);
			$this->session->set_userdata('channel_id', $user_data[0]['channel_id']);
		
			$this->session->set_userdata('is_admin', $user_data[0]['is_admin']);
			$this->session->set_userdata('user_name', $user_data[0]['name']);
			$this->session->set_userdata('user_email', $user_data[0]['email']);
			
			return true;
		}
		
		return false;
	}
	
	public final function id_or_create($data)
	{
		$query = $this->db->get_where($this->tablename, array('name' => $data['name']));
		
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->id;
		} else {
			if($this->db->insert($this->tablename, $data)){
				return $this->db->insert_id();
			}
		}
		
		return false;
	}
	
	public final function create_or_update($data = array(), $insert = array(), $insert2 = array(), $update = array())
	{
		// falta verificar o GA com racional
		
		if(count($data) > 0){
			
			$query = $this->db->get_where($this->tablename, array('email' => $data['email']));
			
			if($query->num_rows() > 0){
				
				$update					= $query->result_array();
				
				$insert['group_id']		= $data['group_id'];
				$insert['name'] 		= $data['name'];
				$insert['email'] 		= $data['email'];
				$insert['first_update']	= $data['first_update'];
				$insert['regional_id']	= $data['regional_id'];
				$insert['updated_in'] 	= date('Y-m-d H:i:s');
				$insert['status_id'] 	= $data['status_id'];
				
				$this->db->where(array('id' => $update[0]['id'], 'hash_id' => $update[0]['hash_id']));
				
				//Update do usuário
				if($this->db->update($this->tablename, $insert)){
					return true;
				}
				
			}else{
				
				$insert['hash_id'] 		= getHash();
				$insert['group_id']		= $data['group_id'];
				$insert['name'] 		= $data['name'];
				$insert['email'] 		= $data['email'];
				$insert['password'] 	= $data['password'];
				$insert['first_update']	= $data['first_update'];
				$insert['regional_id']	= $data['regional_id'];
				$insert['created_in'] 	= date('Y-m-d H:i:s');
				$insert['status_id'] 	= $data['status_id'];
				
				if($this->db->insert($this->tablename, $insert)){
					
					if($insert['group_id'] != 10){
						return true;
					}else{
						
						$user_id = $this->db->insert_id();
						
						foreach($data['layout'] as $k=>$v){
							
							$insert2['idHash']	 		= getHash();
							$insert2['user_id']			= $user_id;
							$insert2['layout_id']		= $v['layout_id'];
							$insert2['value'] 			= $v['value'];
							$insert2['created_in']		= date('Y-m-d H:i:s');
							$insert2['status_id']		= 1;
							
							if(!$this->db->insert('sys_user_store', $insert2)){
								echo "Erro ao Inserir Seguintes informações:<br>";
								printr($insert2);
							}
						}
						
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	// **** MÉTODO GENIAL ************************************************************************
	public final function getWhere($data)
	{
		if(isset($data['title']) && @$data['title']){	
			$this->db->like('sys_user.title', $data['title']);
		}
		if(isset($data['name']) && @$data['name']){	
			$this->db->like('sys_user.name', $data['name']);
		}
		if(isset($data['start_in']) && @$data['start_in']){			
			$this->db->where(array('sys_user.created_in >= ' => format_date_to_mysql($data['start_in'])));
		}
		if(isset($data['end_in']) && @$data['end_in']){				
			$this->db->where(array('sys_user.created_in <= ' => format_date_to_mysql($data['end_in'])));
		}
		if(isset($data['status_id']) && @$data['status_id']){			
			$this->db->where(array('sys_user.status_id ' => $data['status_id']));
		}else{
			
			if($this->router->method == 'index_approve'){
				$this->db->where(array('sys_user.status_id' => 3));
			}else{
				$this->db->where(array('sys_user.status_id' => 1));
			}
		}
	}
	
	
	public final function import_data($data = array(), $insert = array())
	{
		die('precisa terminar');
		//printr($data);
		
		foreach($data as $k=>$v){
			
			$insert['group_id']		= $this->user_group_model->id_or_create($v['CARGO']);
			$insert['name'] 		= $v['NOME'];
			$insert['email']		= strtolower($v['EMAIL']);
			$insert['password'] 	= md5('danone');
			$insert['status_id'] 	= 1;
			
			printr($insert);
			
		}
	}
	
	public final function import_data_server($data = array(), $insert = array(), $regional = '')
	{
		printr($data);
		
		if(count($data) > 0){
			
			foreach($data as $k=>$v){
				
				switch($v['CARGO']){
					
					case 'GR':
					case 'GN':
						if(!empty($v['REGIONAL']) and $v['REGIONAL'] != ''){
							
							for($i = 1; $i < 7; $i++){
								
								if($i == 1){
									$regional = $this->regional_model->id_or_create(array('name' => $v['REGIONAL']));
								}else{
									if(!empty($v['REGIONAL'.$i]) and $v['REGIONAL'.$i] != ''){
										$regional = $regional.','.$this->regional_model->id_or_create(array('name' => $v['REGIONAL'.$i]));
									}
								}
							}
						}
						
						$insert['group_id']		= $this->user_group_model->id_or_create($v['CARGO']);
						$insert['name'] 		= $v['NOME'];
						$insert['email']		= strtolower($v['EMAIL']);
						$insert['password'] 	= md5('danone');
						$insert['first_update']	= 1;
						$insert['regional_id']	= $regional;
						$insert['status_id'] 	= 1;
						
						if(!$this->create_or_update($insert)){
							echo 'Erro ao inserir seguintes dados:<br>';
							printr($insert);
						}
					break;
					
					case 'GA':
						
						$insert['group_id']		= $this->user_group_model->id_or_create($v['CARGO']);
						$insert['name'] 		= $v['GA'];
						$insert['email']		= strtolower(str_replace(" ",".", $v['GA'])).'@danone.com.br';
						$insert['password'] 	= md5('danone');
						$insert['regional_id']	= $this->regional_model->id_or_create(array('name' => $v['REGIONAL']));
						$insert['first_update']	= 1;
						$insert['status_id']	= 1;
						
						$count = 0;
						
						foreach($v as $k1=>$v1){
							
							if($k1 != 'CARGO' and $k1 != 'REGIONAL' and $k1 != 'GA'){
								
								$insert['layout'][$count]['layout_id']	= $this->layout_model->id_or_create(array('name' => utf8_encode($k1)));
								$insert['layout'][$count]['value'] 		= $v1;
								$count++;
							}
						}
						
						if(!$this->create_or_update($insert)){
							echo 'Erro ao inserir seguintes dados:<br>';
							printr($insert);
						}
						
					break;
					
					
				}
			}
		}else{
			return false;
		}
	}
	
	public final function forgot_pass($data = array(), $update = array())
	{
		$query = $this->db->get_where('sys_user', array('email' => $this->input->post('email', TRUE)));
		
		if($query->num_rows > 0){
			
			$data = $query->result_array();
			
			$data[0]['new_pass'] 		= geraSenha(8,true, true, true);
			$data[0]['new_pass_md5']	= md5($data[0]['new_pass']);
			
			$update['first_update'] 	= 1;
			$update['password'] 		= $data[0]['new_pass_md5'];
			
			$this->db->where(array('id' => $data[0]['id'], 'hash_id' => $data[0]['hash_id']));
			
			if($this->db->update('sys_user', $update)){
				
				if($this->contact_model->send_pass($data)){
					return true;
				}
			}
			
			return false;
		}
		
		return false;
	}
}
