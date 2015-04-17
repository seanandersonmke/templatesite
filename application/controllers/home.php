<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){	
		$this->load->model('lindsdata');
		$nav['nav'] = $this->lindsdata->nav();
		$this->load->view('header');
		$this->load->view('main_nav', $nav);
		$this->load->view('twitter_view');
		$this->load->view('html_footer');
		$this->load->view('footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */