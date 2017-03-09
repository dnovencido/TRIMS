<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{	
	private $limit = 10;

	public function __construct(){
		parent:: __construct();		
		$this->_require_login();
		$this->load->model('Dashboard_model');
	}
	private function _require_login(){
		$user_id =$this->session->userdata('user_id');
		if(!$user_id){
			$this->logout();
		}		
	}
	public function index(){
		$this->load->view('includes/header');
		$this->load->view('dashboard');
		$this->load->view('includes/footer');
	}
	public function add_request(){
		$this->load->view('includes/header');
		$this->load->view('add_job_request' ,compact('query' , 'page_links'));
		$this->load->view('includes/footer');		
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}	


}
