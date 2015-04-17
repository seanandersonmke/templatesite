<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main_template extends CI_Controller {
	function __construct(){
 		parent::__construct();
		$this->load->helper('form');
	}
	public function index(){
		$this->load->model('lindsdata');
		$nav['nav'] = $this->lindsdata->nav();
		$query['data'] = $this->lindsdata->page_model_all();
		$this->load->view('header');
		$this->load->view('main_nav', $nav);
		$this->load->view('home', $query);
		$this->load->view('footer');
	}
	public function page(){
		$this->load->model('lindsdata');
		$data = $this->uri->segment(3);
		$query['the_film'] = $data;
		$query['page_data'] = $this->lindsdata->retrieve_page($data);
		$query['custom_field'] = $this->lindsdata->retrieve_custom_field($data);
		$query['actors_data'] = $this->lindsdata->retrieve_actors($data);
		//print_r($query);
		$nav['nav'] = $this->lindsdata->nav();
		$this->load->view('header');
		$this->load->view('main_nav', $nav);
		$this->load->view('main_template', $query);
		$this->load->view('footer');
	}
}