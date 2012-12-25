<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		
		$this->load->view('front/common/header', $data);
		$this->load->view('front/common/sidebar', $data);	
		$this->load->view('front/'.$this->router->class, $data);
		$this->load->view('front/common/footer', $data);
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