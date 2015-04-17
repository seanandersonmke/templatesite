<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
 		parent::__construct();
		$this->load->helper('form');
		$this->load->library('encrypt');
		//$this->load->library('tank_auth');
	}	
	public function index(){
		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');		
	}
	public function check_pw(){
		$username = $this->input->post('user_name');
		//print_r($data);
		
		$password = $this->input->post('password');
		//print_r($password);
		//$this->load->model('lindsdata');
		//$return_data = $this->lindsdata->password($data);
		//print_r($return_data);
		//$decode = $return_data[0]['word_of_passing'];
		//$pw = password_verify($password, $decode);
		///print_r($decode); 
		//$return_data = $this->encrypt->decode($return_data);
		//$test = password_hash('Gwar4you',PASSWORD_DEFAULT);
		//$test = password_verify('Gwar4you', $test);
		//print_r($test);
		
		$db = new PDO('mysql:dbname=moviedb;host=localhost', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, 
                                             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$statement = $db->prepare("SELECT word_of_passing FROM cred WHERE user_name = :user_name");
		$statement->execute(array(':user_name' => $username));
		$row = $statement->fetch(); // Use fetchAll() if you want all results, or just iterate over the statement, since it implements Iterator
		$hash = $row['word_of_passing'];
		//print_r($hash);
		$pw = password_verify($password, $hash);
		//print_r($pw);
		if ($pw == 1) {
			$this->session->set_userdata(array("logged_in" => "true",
        											"user_id"  => 	$return_data[0]['user_id']
        											));
			redirect('/update/', 'location');
		}else{
			$error['the_error'] = 'Your Credentials are Wrong';
		}
		
		//$test = 'Gwar4you';
		//$check = password_hash($test, PASSWORD_DEFAULT);
		//print_r($check);
		//$check = password_verify('Gwar4you#', '$2y$10$BS70bLiuvrLGAazIyRtn0.oMhhp4Ren0w/9PkMsSZmdp228XDmaeq');
		//print_r($check);
		

		
	}

	public function register(){
		$this->load->view('header');
		$this->load->view('register');
		$this->load->view('footer');
	}
	
	/*	
	public function register(){
		$this->load->view('header');
		$this->load->view('auth/register_form');
		$this->load->view('footer');
	}
	*/
	public function register_submit(){
		//print_r($_POST);
		



		$data['user_name'] = $this->input->post('user_name');
		$data['word_of_passing'] = $this->input->post('word_of_passing');
		print_r($data['word_of_passing']);
		$data['word_of_passing'] =  password_hash($data['word_of_passing'], PASSWORD_DEFAULT);
		$this->load->model('lindsdata');
		$this->lindsdata->register($data);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */