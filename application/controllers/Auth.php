<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authentication Class
 * Designed by TaskIT (U) Ltd
 * January 2023
 */
class Auth extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('model_auth');
	}

	/*
		Check if the login form has been submitted, and validate the user credentials
		else redirect to the login form
	*/

	public function login(){
		$this->logged_in();

		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run()==TRUE){
			$username_exists = $this->model_auth->check_username($this->input->post('username'));
			if($username_exists==TRUE){
				$login = $this->model_auth->login($this->input->post('username'),$this->input->post('password'));
				if($login){
					$logged_in_sess = array(
						'id'		=>$login['userid'],
						'username'	=>$login['username'],
						'fname'		=>$login['fname'],
						'lname'		=>$login['lname'],
						'catname'	=>$login['user_cat_name'],
						'catgroup'	=>$login['user_cat_group_name'],
						'email'		=>$login['email'],
						'usercat'	=>$login['usercategory'],
						'logged_in'	=>TRUE
					);

				//user credential are ok create session and take them to the Dahboard
					$this->session->set_userdata($logged_in_sess);
					redirect('dashboard','refresh');

				}
				else {
					//credentials not Ok . Generate feedback and redirect to login page
					$this->data['errors'] = 'Incorrect username/password combination';
					$this->load->view('login',$this->data);
				}
			}
			else{
				//the username is not registered. Generate feedback and redirect to login
				$this->data['errors'] = 'Username does not exist in the system. Please contact the system administrator';
				$this->load->view('login',$this->data);
			}
		}
		else{
			//form validation failed.  Generate feedback and go back to login
			$this->data['errors'] = 'Username/password are required';
			$this->load->view('login',$this->data);
		}
	}

	public function generalDashboard(){

		$data['registeredTesters']		=count($this->Model_tester->getTester());
		$data['registeredFacility']		=count($this->Model_facility->getFacility());
		$data['targetedTesters']		=count($this->Model_distributions->getDistribution());
		$data['returnedTesters']		=count($this->Model_hivdtssamples->getReturnsByCycle());
		$data['passes']					=count($this->Model_hivdtssamples->getPassedReturnsByCycle());
		$data['fail']					=count($this->Model_hivdtssamples->getFailedReturnsByCycle());
		$data['ungrade']				=count($this->Model_hivdtssamples->getUngradedReturnsByCycle());
		$data['perform']				=$this->Model_dashboard->getQuarterlyPerformance();
		$data['region_chart']			=$this->Model_dashboard->RegionalGraphByCycle();
		$data['level_chart']			=$this->Model_dashboard->FacilityLevelGraphByCycle();
		$data['responseRate']			=$this->Model_dashboard->getResponseRate();
		$data['quarter']				=$this->Model_dashboard->getQuarter();
		$data['region_perf']			=$this->Model_dashboard->getRegionalPerformanceByQuarter();
		$data['level_perf']				=$this->Model_dashboard->getFacilityLevelPerformanceByQuarter();
		$data['delimode']				=$this->Model_dashboard->getDelimodePerformanceByQuarter();
		$data['owner']					=$this->Model_dashboard->getOwnerPerformanceByQuarter();
		

		$this->load->view('general_dash',$data);
	}
	///Logout method
	public function logout(){
		$this->session->sess_destroy();
		redirect('auth/login','refresh');
	}
}