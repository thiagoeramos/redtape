<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
		
		private $url;
		private $title;
		private $validation;
		
	public final function __construct()
	{
		parent::__construct();

		$this->url = '/home/';
		
		$this->title = array(
			'index'			=>'Página Inicial | Redtape - Punk . Hardcore . Shop',
			'chapter'		=> 'Ir para a loja'
		);
	}
	private final function render($method, $data)
	{
		//$data['breadcrumbs'] = $this->breadcrumbs($this->router->method);
		
		$data['url']			= $this->url;
		$data['dir']			= $this->router->class.'/';
		$data['title']			= $this->title;
		
		$this->load->view('admin/common/header', $data);
		$this->load->view('admin/common/sidebar', $data);
		$this->load->view('admin/'.$this->router->class."/".$method, $data);
		$this->load->view('admin/common/footer', $data);
	}
	public function index()
	{
		$data['url_title']	= 'home';
		$data['scr_title']	= $this->title['index'];
		$this->render($this->router->method, $data);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
