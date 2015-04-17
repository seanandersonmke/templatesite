<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update extends CI_Controller {
	function __construct(){
 		parent::__construct();
		$this->load->helper('form');
	}	
	public function index(){
		$logged_in = $this->session->userdata('logged_in');
		//if($logged_in == "true"){
			$this->load->view('header');
			$this->load->view('select_film');
			$this->load->view('footer');
		//}else{
		//	redirect('/login', 'location');	
		//}
	}
	public function add_entry(){
		$logged_in = $this->session->userdata('logged_in');
		//if($logged_in == "true"){
			$selected_film = $this->input->post('movie_select');
			$this->load->model('lindsdata');
			$query['actor_tag'] = $this->lindsdata->get_actor();
			$query['get_cat'] = $this->lindsdata->get_category();
			$this->load->view('header');
			$this->load->view('update', $query);
			$this->load->view('footer');
		//}else{
	//		redirect('/login', 'location');	
	//	}
	}
	public function user(){
		$logged_in = $this->session->userdata('logged_in');
		//if($logged_in == "true"){
			$user_id = $this->session->userdata('user_id');
			//print_r($user_id);
			$this->load->model('lindsdata');
			$data['titles'] = $this->lindsdata->page_by_author($user_id);
			$this->load->view('header');
			$this->load->view('update_home', $data);
			$this->load->view('footer');
		//}	
	}
	public function save_entry(){
			//$data = array();	
			$data['user_id'] = $this->session->userdata('user_id');
			$data['actor_id'] = $this->input->post('actor_id');
			$data['film_id'] = $this->input->post('film_id');
			$data['custom_count'] = $this->input->post('custom_count');
			$data['field_title'] = $this->input->post('field_title');
			$data['body_count'] = $this->input->post('body_count');
			$data['film_total'] = $this->input->post('film_total');
			$data['heading'] = $this->input->post('heading');
			$data['article'] = $this->input->post('article');			
			$data['cat_id'] = $this->input->post('cat_id');
			$data['film_id'] = $this->input->post('film_id');
			$this->load->model('lindsdata');
			$this->lindsdata->save_entry($data);
			//print_r($data);
	}
	public function update_drag(){
		$data = $this->input->post('itemid');
		$this->load->model('lindsdata');
		$this->lindsdata->save_drag($data);
	}
	public function order(){
		$logged_in = $this->session->userdata('logged_in');
		if($logged_in == "true"){
			$data = $this->input->post('page');
			$this->load->model('lindsdata');
			$query['data'] = $this->lindsdata->order($data);
			$this->load->view('header');
			$this->load->view('order', $query);
			$this->load->view('footer');
			$itemid = $this->input->post('item_id');
			if(isset($itemid)){
				$this->load->model('lindsdata');
				$this->lindsdata->delete_item($itemid);
			}
		}else{
			redirect('/login', 'location');
		}
	}
	public function add_page(){
		$data['nav_item'] = $this->input->post('nav_item');
		$this->load->model('lindsdata');
		$this->lindsdata->add_page($data);
		redirect('/update', 'location');	
	}
	public function delete_page(){
		$data['nav_id'] = $this->input->post('nav_id');
		$data['nav_item'] = $this->input->post('nav_item');
		$this->load->model('lindsdata');
		$this->lindsdata->delete_page($data);
		redirect('/update', 'location');	
	}
	public function get_author_edit(){
		$data['item_id'] = $this->input->post('item_id');
		$this->load->model('lindsdata');
		$article = $this->lindsdata->retrieve_page($data);
		$article = json_encode($article);
		print_r($article);
		return $article;
	}
	/*
	public function add_item(){
		$this->load->model('lindsdata');
		$heading = $this->input->post('heading');
		$iframe = $this->input->post('iframe');
		$descript = $this->input->post('descript');
		$page = $this->input->post('page');
		$data = array(
			'heading'=>$heading,
			'descript'=>$descript,
			'page'=>$page	
		);
		$this->lindsdata->add_item($data);
		redirect('/update', 'location');	
	}
	*/
	public function delete_item(){
		$data = $this->input->post('item_id');
		var_dump($data);
		$this->load->model('lindsdata');
		$this->lindsdata->delete_item($data);
	}
	public function add_category(){
		$data['cat_title'] = $this->input->post('cat_title');
		$this->load->model('lindsdata');
		$this->lindsdata->add_cat($data);
		//redirect('/update', 'location');		
	}
	public function add_actor(){
		$data['actor_name'] = $this->input->post('actor_name');
		$this->load->model('lindsdata');
		$this->lindsdata->add_actor($data);
		redirect('/update', 'location');		
	}
	public function get_cat(){
		$this->load->model('lindsdata');
		$query['get_cat'] = $this->lindsdata->get_category();
		$cats = $query['get_cat']; 
		return $cats;
	}
}
/* End of file order.php */
/* Location: ./application/controllers/order.php */