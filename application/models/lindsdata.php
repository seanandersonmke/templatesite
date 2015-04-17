<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lindsdata extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	function order($data){
		$this->db->select('*');
		$this->db->from('page_data');
		$this->db->where('nav_id', $data);
		$this->db->order_by("item_order", "asc"); 
		$query = $this->db->get();
		//$query = $this->db->query('SELECT * FROM '.$item);
        return $query->result_array();
	}
	function get_actor(){
		$this->db->select('actor_rt_id');
		$this->db->from('actors');
		$this->db->order_by("actor_rt_id", "asc"); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_category(){
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->order_by("cat_title", "asc"); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function retrieve_page($data){
		$this->db->select('*');
		$this->db->from('page_data');
		$this->db->where('page_data.item_id', $data['item_id']);
		//$join = 'actors.film_id = page_data.film_id';
	
		//$this->db->join('custom_field', 'page_data.film_id = custom_field.film_id');
		$this->db->join('actors', 'page_data.film_id = actors.film_id');
		//$this->db->where('film_id', $data);
		
		//$this->db->order_by("cat_title", "asc");
		$page_data = $this->db->get();
		return $page_data->result_array();
	}
	function page_by_author($user_id){
		$this->db->select('*');
		$this->db->from('page_data');
		$this->db->where('user_id', $user_id);
		$page_data = $this->db->get();
		return $page_data->result_array();	
	}
	function register($data){
		$this->db->insert('cred', $data);

	}
	function retrieve_custom_field($data){
		$this->db->select('field_title, custom_count');
		$this->db->from('custom_field');
		$this->db->where('film_id', $data);
		$custom_field_data = $this->db->get();
     
		return $custom_field_data->result_array();
	}
	function retrieve_actors($data){
		$this->db->select('*');
		$this->db->from('actors');
		$this->db->where('film_id', $data);
		$actors_data = $this->db->get();
     
		return $actors_data->result_array();
	}
	function page_model_all(){
		$this->db->select('*');
		$this->db->from('page_data');
	//	$this->db->order_by('film_total', 'desc');
		$query = $this->db->get();
        return $query->result_array();
	}
	function nav(){	
		$this->db->select('*');
		$this->db->from('categories');
		$query = $this->db->get();
        return $query->result_array();
	}
	function password($data){	
		//$username = $data'username');
		//print_r($data);
		//$password = $this->input->post('password');
		$query = $this->db->get_where('cred', array('user_name' => $data));
        $return = $query->result_array();	
        //$pw = $return[0]['word_of_passing'];
        	//$user_id = $return[0]['user_id'];
        //	$decode	= $this->encrypt->decode($pw);
        	//print_r($return);
        //print_r($return);
        	//$return = $query->result_array();
        	//$pw = $return[0]['word_of_passing'];
        	//$user_id = $return[0]['user_id'];
        	//$decode	= $this->encrypt->decode($pw);
        	//print_r($decode);
        	//exit();
        	/*
        	if ($decode == $password) {
        		$this->session->set_userdata(array("logged_in" => "true",
        											"user_id"  => $user_id
        											));
        	 	return 'pass';
        	 */
        	 return $return;
        	    	
	}
	function save_drag($data){
		$counter = 1;
		foreach ($data as $key => $value) {
			$this->db->query('UPDATE page_data SET item_order = ' . $counter .'  WHERE item_id = ' .$value); 
			$counter ++;
		}
	}
	function save_entry($data){
		$user_id = $data['user_id'];
		$heading = $this->input->post('heading');
		$article = $this->input->post('article');
		$cat_id = $this->input->post('cat_id');
		$custom_count['custom_count'] = $this->input->post('custom_count');
		$field_title['field_title'] = $this->input->post('field_title');
		$film_total = $this->input->post('film_total');
		//$film_id = array();
		$film_id = $data['film_id'];
		$data_itemone['actor_rt_id'] = $this->input->post('actor_id');
		$data_itemtwo['body_count'] = $this->input->post('body_count');
		$data_item = array_merge($data_itemone, $data_itemtwo);
		$custom_count_data = array_merge($custom_count, $field_title);
		//print_r($custom_count);
		$res_a = [];
		$res_b = [];
		foreach($data_item as $key_a => $value_a){
			foreach ($value_a as $data_a => $thevalue_a) {
				$res_a[$data_a][$key_a] = $thevalue_a;
				$res_a[$data_a]['film_id'] = $film_id;
			}
		}
		foreach($custom_count_data as $key_b => $value_b){
			foreach ($value_b as $data_b => $thevalue_b) {
				$res_b[$data_b][$key_b] = $thevalue_b;
				$res_b[$data_b]['film_id'] = $film_id;
			}
		}
		print_r($res_b);
		$this->db->insert_batch('actors', $res_a);
		$this->db->insert_batch('custom_field', $res_b);
		$the_data = array(
			'heading' => $heading,
			'article' => $article,
			'cat_id' => $cat_id,
			'user_id' => $user_id,
			'film_id' => $film_id,
			'film_total' => $film_total,
			);
		print_r($the_data);
		$this->db->insert('page_data', $the_data);
	}
	function add_cat($data){
		$this->db->insert('categories', $data);
	}
	function add_actor($data){
		$this->db->insert('actors', $data);
	}
	function add_page($data){
		$this->db->insert('nav', $data);
	}
	function delete_page($data){
		$nav_id = $data['nav_id'];
		$nav_item = $data['nav_item'];
		$this->db->delete('nav', array('nav_id' => $nav_id));
		$this->db->delete('page_data', array('nav_id' => $nav_id));
	}
	function delete_item($itemid){
		//$item_id = $itemid['itemid'];
		$this->db->delete('page_data', array('item_id' => $itemid));	
	}
}