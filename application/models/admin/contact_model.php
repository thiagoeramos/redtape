<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model de Envio de email do form de contato
 * @author Felipe <felipe@wadtecnologia.com.br>
 */
class Contact_model extends CI_Model{
	
	public final function __construct()
	{
		parent::__construct();
		
		$this->load->model('email_text_model');
	}
	
	public final function enviaEmail()
	{
		$data = array();
		
		$data['nome'] 		= $this->input->post('contactName', TRUE);
		$data['email']		= $this->input->post('email', TRUE);
		$data['mensagem'] 	= $this->input->post('comments', TRUE);
		
		if($data['nome'] != '' and $data['email'] != '' and $data['mensagem'] != ''){
			
			$this->email->set_mailtype('html');
			$this->email->from($data['email'], $data['nome']);
			$this->email->to($this->parameter_model->get('CONTACT_EMAIL'));
			$this->email->subject($this->parameter_model->get('SUBJECT_EMAIL'));		
			$msg = '<html><head></head><body>
				Nome:       ' . $data['nome'] . ' <br />
				E-mail:     ' . $data['email'] . ' <br />
				Mensagem:   ' . $data['mensagem'] . ' <br />
				</body></html>';
			$this->email->message($msg);
			
			if($this->email->send()){
				return true;
			}else{
				return false;
			}
			
		}
		
		return false;
	}
	
	public final function send_pass($data = array())
	{
		if($data){
			
			$email_text = $this->email_text_model->by(array('status_id' => 1, 'email_category_id' => 3, 'group_id' => $data[0]['group_id']));
			
			$email_text_alterado = str_replace('[#nome]', $data[0]['name'], $email_text[0]['text']);
			$email_text_alterado = str_replace('[#senha]', $data[0]['new_pass'], $email_text_alterado);
			$email_text_alterado = str_replace('[#link]', '<a href="'.site_url().'">'.site_url().'</a>', $email_text_alterado);
			
			$this->email->set_mailtype('html');
			$this->email->from($this->parameter_model->get('CONTACT_EMAIL'));
			$this->email->to($data[0]['email'], $data[0]['name']);
			$this->email->subject($this->parameter_model->get('SUBJECT_EMAIL_PASS'));
			
			$this->email->message($email_text_alterado);
			
			if($this->email->send()){
				return true;
			}else{
				return false;
			}
		}
		
		return false;
	}
	
	public final function send_email_update($data = array())
	{
		if(count($data) > 0){
			
			$this->email->set_mailtype('html');
			$this->email->from($this->parameter_model->get('CONTACT_EMAIL'));
			$this->email->to($data['email'], $data['name']);
			$this->email->subject($this->parameter_model->get('SUBJECT_EMAIL_EDIT'));
			
			$msg = "<html><head></head><body>
				Olá " . $data['name'] . " <br />
				
				Seus dados foram Aprovados / Editados por um administrador do sistema
				
				Sua nova senha para acesso ao SMPV é: " . $data['new_pass'] . " <br />
				Assim que efetuar o Login no sistema é obrigatório a atualização da sua senha! <br />
				
				Para acessar o sistema, clique no link a seguir: <br />
				
				<a href='".site_url()."' /> ".site_url()."</a>
				
				</body></html>";
			
			$this->email->message($msg);
			
			if($this->email->send()){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public final function send_email_status($data = array())
	{
		$email_text = $this->email_text_model->by(array('status_id' => 1, 'email_category_id' => 1, 'group_id' => 10));
		
		foreach($data as $k => $v){
			
			$email_text_alterado = str_replace('[#nomeGA]', $v['user_name'], $email_text[0]['text']);
			$email_text_alterado = str_replace('[#onda]', $v['wave_name'], $email_text_alterado);
			$email_text_alterado = str_replace('[#status]', $v['status_name'], $email_text_alterado);
			
			$this->email->set_mailtype('html');
			$this->email->from($this->parameter_model->get('CONTACT_EMAIL'));
			$this->email->to($v['user_email'], $v['user_name']);
			$this->email->subject('Alteração de Status da Solicitação da '.$v['wave_name']);
			
			$this->email->message($email_text_alterado);
			
			$this->email->send();
		}
		
		return true;
	}
}