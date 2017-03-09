<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller 
{	
	private $user_id = null;

	public function __construct(){
		parent:: __construct();	
		$this->_authenticity();	
		$this->load->model('Dashboard_model');
	}

	private function _authenticity(){
		$user_id =$this->session->userdata('user_id');
		$this->user_id = $user_id; 
		
	}	
	public function generate_request_no(){
   		$this->db->select_max('jobReqNo');
     	$result= $this->db->get('tbl_job_request')->row_array();
     	if($result['jobReqNo'] == 0) {
     		$last_id = 119;
     	} else {
     		$last_id = $result['jobReqNo'];
     	}
     	$last_id++;
		$format_id = str_pad($last_id, 5, '0', STR_PAD_LEFT);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(['last_id' => $format_id]));
	}
	public function add_job_request(){
		$this->output->set_content_type('application/json');
		$name = $this->input->post('name');
		$company = $this->input->post('company');
		$faults = $this->input->post('faults');
		$prod_item = $this->input->post('prod-item');
		$prod_name = $this->input->post('prod-name');
		$prod_model = $this->input->post('prod-model');
		$contact_no = $this->input->post('contact-no');
		$cost = $this->input->post('cost');
		$jobReqNo = $this->input->post('job-req-no');

		$this->form_validation->set_rules('name', 'Name' ,'required|min_length[3]');
		$this->form_validation->set_message('required','<span class="glyphicon glyphicon-remove"></span> Please enter customer name.');
		$this->form_validation->set_message('min_length','<span class="glyphicon glyphicon-remove"></span> Please enter valid name');

		if(!$this->user_id){
			$this->output->set_output(json_encode(['result' => 0, 'user_login' => 0]));
		} else {
			if($this->form_validation->run() == false){
				$this->output->set_output(json_encode(['result' => 0, 'user_login' => 1 ,'error' => validation_errors()]));
				return false;
			} else {
	   		
				$result_add_customer = $this->Dashboard_model->add_customer([
					'name' => $name,
					'company' => $company,
					'contact' => $contact_no
				]);

		   		$this->db->select_max('customerID');
		     	$result= $this->db->get('tbl_customer')->row_array();
		     	$customerID = $result['customerID'];
		     	// Get last id customer

				$result_job_req = $this->Dashboard_model->add_job_req([
					'jobReqNo' => $jobReqNo,
					'product'=> $prod_name,
					'product_item' => $prod_item,
					'model' => $prod_model,
					'fault' => $faults,
					'received' => $this->user_id,
					'cost' => $cost,
					'customerID' =>  $customerID
				]);
				$result_last_record = $this->Dashboard_model->get_latest_record();
				//Get latest record from database

				if($result_add_customer && $result_job_req) {
					$this->output->set_output(json_encode([
						'result' => 1,
						'last_row' => $result_last_record,
						'user_login' => 1
					]));
				} 
			}			
		}

	}
	public function display_job_req(){
		$result = $this->Dashboard_model->get_job();
		$this->output->set_content_type('application/json');
		if($result) {
			$this->output->set_output(json_encode($result));
		} else {
			$this->output->set_output(json_encode(['result' => 0, 'error' => 'Empty record']));
		}		
	}
	public function prev_job(){
		$data_id = $this->input->post('jobReqID');
		$this->output->set_content_type('application/json');

		$result_job_prev = $this->Dashboard_model->get_job_prev($data_id);
		$this->output->set_output(json_encode($result_job_prev));		

	}
	public function update_job_req(){
		$this->output->set_content_type('application/json');

		$data_id = $this->input->post('jobReqID');
		$prev_name = $this->input->post('prev_name');
		$prev_company = $this->input->post('prev_company');
		$prev_contact_no = $this->input->post('prev_contact-no');
		$prev_prod_item = $this->input->post('prev_prod-item');
		$prev_prod_name = $this->input->post('prev_prod-name');
		$prev_prod_model = $this->input->post('prev_prod-model');
		$prev_faults = $this->input->post('prev_faults');
		$prev_cost = $this->input->post('prev_cost');

		$this->db->select('customerID');
		$this->db->where('jobReqID',$data_id); 
		$result= $this->db->get('tbl_job_request')->row_array();
		$customerID = $result['customerID'];
		//Get customer id of a specific job request no

		$customer_data =  array(
			'name' =>  $prev_name, 
			'company' => $prev_company,
			'contact' => $prev_contact_no
		);
		$job_request_data =  array(
			'product_item' =>  $prev_prod_name, 
			'product' => $prev_prod_name, 
			'model' => $prev_prod_model,
			'fault' => $prev_faults,
			'cost' => $prev_cost
		);

		$result_customer_data = $this->Dashboard_model->update_prev_cust($customer_data,$customerID);
		$result_job_request = $this->Dashboard_model->update_job_request($job_request_data,$data_id);

		$updated_record = $this->Dashboard_model->get_updated_record($data_id);
		// //Get row updated record

		if($result_customer_data || $result_job_request){
			$this->output->set_output(json_encode([
				'result' => 1, 
				'data_id' => $data_id,
				'update_row' => $updated_record
			]));	
		} else {
			$this->output->set_output(json_encode(['result' => 0]));
		}
	}	

	public function delete_job_req(){
		$this->output->set_content_type('application/json');	
		$data_id = $this->input->post('jobReqID');
		$status = array('status' => 1);

		$delete_result = $this->Dashboard_model->delete_job($data_id,$status);

		if($delete_result) {
			$this->output->set_output(json_encode([
				'result' => 1,
				'data_id' => $data_id
			]));
		} else {
			$this->output->set_output(json_encode([
				'result' => 0
			]));
		}
	}

	public function search_by(){
		$this->output->set_content_type('application/json');
		$data_field = $this->input->post('data_val');
		$to_search = $this->input->post('input_field');
		$field = $data_field;
			// $this->output->set_output(json_encode([
			// 	'field' => $field,
			// ]));		
		switch($field){
			case 1 :
				$where_val = array('jr.status' => 0, 'c.name' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}

			break;
			
			case 2 :
				$where_val = array('jr.status' => 0, 'jr.jobReqNo' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}
			break;

			case 3 :
				$where_val = array('jr.status' => 0, 'c.company' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}
			break;	

			case 4 :
				$where_val = array('jr.status' => 0, 'jr.fault' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}
			break;	

			case 5 :
				$where_val = array('jr.status' => 0, 'jr.product_item' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}
			break;	

			case 6 :
				$where_val = array('jr.status' => 0, 'jr.product' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}
			break;	

			case 7 :
				$where_val = array('jr.status' => 0, 'jr.model' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}
			break;	

			case 8 :
				$where_val = array('jr.status' => 0, 'u.full_name' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}
			break;		

			case 9 :
				$where_val = array('jr.status' => 0, 'c.contact' => $to_search);
				$search = $this->Dashboard_model->search_by($where_val);
				
				if($search){
					$this->output->set_output(json_encode([
						'result' => 1,
						'entry' => $search
					]));					
				} else {
					$this->output->set_output(json_encode([
						'result' => 0
					]));					
				}
			break;																						
		}

	}

}