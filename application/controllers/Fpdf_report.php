<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fpdf_report extends CI_Controller {
	public function index() {	
		
		$jobReqId = $this->input->post('jobReqID');
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(['jobReqID' => $jobReqId]));	
	}
	public function print_job($jobReqId = null){
		$this->load->library('fpdf_gen');
		$this->load->model('Dashboard_model');
		$result = $this->Dashboard_model->get_job_prev($jobReqId);
		if($result) {
			$data['result'] = $result;
			$this->load->view('fpdf' , $data);
		} else {
			echo "No Records found";
		}
	}
}