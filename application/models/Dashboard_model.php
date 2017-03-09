<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model 
{
	public function get($user_id = null){
		if($user_id === null){
			$query = $this->db->get('tbl_users');
		} else if (is_array($user_id)) {
			$query = $this->db->get_where('tbl_users', $user_id); ;
		} else {
			$query = $this->db->get_where('tbl_users', ['userID' => $user_id]);
		}
		return $query->result_array();
	}

	public function add_job_req($data){
		$this->db->insert('tbl_job_request',$data);
		return $this->db->insert_id();
	}

	public function add_customer($data){
		$this->db->insert('tbl_customer',$data);
		return $this->db->insert_id();
	}

	public function get_job(){
		$this->db->select('*');    
		$this->db->from('tbl_job_request as `jr`');
		$this->db->join('tbl_customer as `c`', 'c.customerID = jr.customerID');
		$this->db->join('tbl_users as `u`', 'u.userID = jr.received');
		$this->db->order_by("jr.jobReqID", "DESC");
		$this->db->where('jr.status' , 0); 
		$query = $this->db->get();
		return $query->result_array();
	}	


	public function search_by($where_val){
		$this->db->select('*');    
		$this->db->from('tbl_job_request as `jr`');
		$this->db->join('tbl_customer as `c`', 'c.customerID = jr.customerID');
		$this->db->join('tbl_users as `u`', 'u.userID = jr.received');
		$this->db->like($where_val); 
		$this->db->order_by("jr.jobReqID", "DESC");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_latest_record(){
		$this->db->select('jr.jobReqID, jr.jobReqNo, jr.product_item, jr.product, jr.model, jr.fault, jr.cost, c.name, c.company, c.contact, u.full_name');    
		$this->db->from('tbl_job_request as `jr`');
		$this->db->join('tbl_customer as `c`', 'c.customerID = jr.customerID');
		$this->db->join('tbl_users as `u`', 'u.userID = jr.received');
		$this->db->where('jr.jobReqID',$this->db->insert_id()); 
		$query = $this->db->get();
		return $query->result_array();		
	}

	public function get_updated_record($data_id){
		$this->db->select('jr.jobReqID, jr.jobReqNo, jr.product_item, jr.product, jr.model, jr.fault, jr.cost, c.name, c.company, c.contact, u.full_name');    
		$this->db->from('tbl_job_request as `jr`');
		$this->db->join('tbl_customer as `c`', 'c.customerID = jr.customerID');
		$this->db->join('tbl_users as `u`', 'u.userID = jr.received');
		$this->db->where('jr.jobReqID',$data_id); 
		$query = $this->db->get();
		return $query->result_array();		
	}


	public function get_job_prev($jobReqID){
		$this->db->select('jr.jobReqID, jr.jobReqNo, jr.product_item, jr.product, jr.model, jr.fault, jr.cost, c.name, c.company, c.contact, u.full_name');    
		$this->db->from('tbl_job_request as `jr`');
		$this->db->join('tbl_customer as `c`', 'c.customerID = jr.customerID');
		$this->db->join('tbl_users as `u`', 'u.userID = jr.received');
		$this->db->where('jr.jobReqID',$jobReqID); 
		$query = $this->db->get();
		return $query->result_array();		
	}

	public function update_prev_cust($customer_data,$customerID){
		$this->db->where('customerID', $customerID);
		$this->db->update('tbl_customer',$customer_data);
		$query = $this->db->affected_rows();
		return $query;
	}
	public function update_job_request($job_request_data,$data_id){
		$this->db->where('jobReqID', $data_id);
		$this->db->update('tbl_job_request',$job_request_data);	
		$query = $this->db->affected_rows();
		return $query;	
	}	

	public function delete_job($data_id,$status){
		$this->db->where('jobReqID', $data_id);
		$this->db->update('tbl_job_request',$status);
		$query = $this->db->affected_rows();
		return $query;
	}
}
