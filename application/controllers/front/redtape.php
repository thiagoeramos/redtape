<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redtape extends CI_Controller {

	public final function __construct()
	{
		parent::__construct();
		
	
		$this->url = '/redtape/';
		
		$this->title = array(
			'index'				=>'A Redtape | Redtape - Punk . Hardcore . Shop',
			'chapter'			=> 'Redtape'
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