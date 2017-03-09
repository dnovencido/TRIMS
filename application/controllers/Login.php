<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	public function __construct(){
		parent:: __construct();
		$user_id =$this->session->userdata('user_id');
		
		if($user_id){
			redirect('menu');
		} //Check if user logged in...

		$this->load->model('Dashboard_model');
	}
	public function index(){
		$this->load->view('includes/header');
		$this->load->view('login');
		$this->load->view('includes/footer');
	}
	public function login_process(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$result = $this->Dashboard_model->get([
			'username' => $username,
			'password' => hash('sha256', $password . SALT) //Hashed password
 		]);
		
		if($result){
			$this->session->set_userdata([
				'user_id' => $result[0]['userID'] ,
				'username' => $result[0]['username'],
				'userfullname' => $result[0]['full_name']

			]);	// Initialize session variables
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(['result' => 1]));

			return false;		

		} 

		$this->output->set_output(json_encode(['result' => 0])); // If this has result, pass json variable result = 1 else = 0			
	}

}
