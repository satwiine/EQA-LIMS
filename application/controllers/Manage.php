<?php
error_reporting(0);
require FCPATH.'vendor/autoload.php'; // to work for mpdf

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller{
	
	var $permission = array();


	public function __construct() 
	{
		date_default_timezone_set('Africa/Nairobi');
		parent::__construct();
		$group_data = array();
		if(empty($this->session->userdata('logged_in'))) {
			$session_data = array('logged_in' => FALSE);
			$this->session->set_userdata($session_data);
		}
		else {
			$user_id = $this->session->userdata('id');
			//$this->load->model('model_groups');
			//$group_data = $this->model_groups->getUserGroupByUserId($user_id);
			
			//$this->data['user_permission'] = unserialize($group_data['permission']);
			//$this->permission = unserialize($group_data['permission']);
		}
	}
	 
	public function index(){
		$this->load->view('test');
	}

	public function wizard(){
		if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

		$this->load->view('templates/header');
		$this->load->view('templates/header_menu');
		$this->load->view('templates/side_menubar');

		$this->load->view('wizard');
		//$this->load->view('templates/footer');

	}

	public function dashboard()
	{
		if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

		 $data['Title']= 'HIV/SYPH PT';
		 $data['registeredTesters']		=count($this->Model_tester->getTester());
		 $data['registeredFacility']	=count($this->Model_facility->getFacility());
		 $data['targetedTesters']		=count($this->Model_distributions->getDistribution());
		 $data['returnedTesters']		=count($this->Model_hivdtssamples->getReturnsByCycle());

		 $data['regionDispatch']		=$this->Model_distributions->getDispatchedByCycle();
		 $data['regionReturns']			=$this->Model_distributions->getReturnsByRegionCycle();
		 $data['goodTAT']				=$this->Model_distributions->getOnTimeReturnsByRegionCycle();
		 $data['baddTAT']				=$this->Model_distributions->getOffTimeReturnsByRegionCycle();

		 $data['responseByFacility']	=$this->Model_dashboard->getResponseByFacilityLevel();
		 $data['facilitySummary']		=$this->Model_facility->getFacilityByLevel();
		 $data['testerSummary']			=$this->Model_tester->getTesterSummaryByCadre();
		 
		 $data['entries']					=$this->Model_hivdtssamples->showEntries();

		$this->load->view('templates/header');
		$this->load->view('templates/header_menu');
		$this->load->view('templates/side_menubar');

		$this->load->view('dashboard',$data);
		$this->load->view('templates/footer');
	}

	/*
		Category Management
	*/
		
		/*
			USERS + USER CATEGORY 
		*/

		public function viewUsers(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }
			  $data['title']	="Users";
			  $user_data = $this->Model_users->getUserData();
			  $result = array();

			  foreach ($user_data as $k => $v) {
			  	$result[$k]['user_info']=$v;
			  }
			  $data['user_data'] = $result;

			  	$this->load->view('templates/header');
				$this->load->view('templates/header_menu');
				$this->load->view('templates/side_menubar');
			  	$this->load->view('users/index',$data);
			  	$this->load->view('templates/footer');
		}

		public function addUser(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }
			  $data['title']	="Add User";
			  $data['usercategory'] = $this->Model_users->getUserCategory();
			  //$user_data = $this->Model_users->getUserData();
			  $this->load->view('templates/header');
				$this->load->view('templates/header_menu');
				$this->load->view('templates/side_menubar');
			  	$this->load->view('users/create',$data);
			  	$this->load->view('templates/footer');
		}
		public function createUser(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			  $this->form_validation->set_rules('category','Category','required');
			  $this->form_validation->set_rules('username','Username','trim|required|min_length[6]|is_unique[users.username]');
			  $this->form_validation->set_rules('email','Email','trim|required|is_unique[users.email]');
			  $this->form_validation->set_rules('password','Password','trim|required|min_length[8]');
			  $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]');
			  $this->form_validation->set_rules('fname','First Name','trim|required');
			  $this->form_validation->set_rules('lname','Last Name','trim|required');

			  if($this->form_validation->run()==TRUE){
			  	//encrypt password
			  	$password = sha1(md5($this->input->post('password')));

			  	$data =array(
			  		'username' 		=>$this->input->post('username'),
			  		'password' 		=>$password,
			  		'email'	   		=>$this->input->post('email'),
			  		'usercategory'	=>$this->input->post('category'),
			  		'fname'			=>$this->input->post('fname'),
			  		'lname'			=>$this->input->post('lname')
			  	);
			  	$create = $this->Model_users->create($data,$this->input->post('category'));
			  	if($create==true){
			  		$this->session->set_flashdata('success','User Created Successfully');
			  		redirect('Members','refresh');
			  	}
			  	else {
			  		$this->session->set_flashdata('error','User not Created, an error occured');
			  		redirect('createmember','refresh');
			  	}
			  }
			  else {
			  	redirect('createmember');
			  }
		}


		/*
			ITEMS + ITEM CATEGORY
		*/

		public function itemcategory(){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

			$data['title']	="Categorys";
			$data['status']   = $this->Model_status->getStatus();
			//$data['category'] = $this->Model_category->fetchCategory();

			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('category/index',$data);
			$this->load->view('templates/footer');
		}

		
		public function createItemCategory(){
			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

		  $response = array();

		  //validate parameters
		  $this->form_validation->set_rules('category_name','Category Name','trim|required');
		  $this->form_validation->set_rules('active','Status','trim|required');


		  $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		  if($this->form_validation->run() == TRUE){
		  	$data = array(
		  		'ItemCatDescription'=>$this->input->post('category_name'),
		  		'status' =>$this->input->post('active')
		  	);
		  	$create = $this->Model_category->createItemCategory($data);

		  	if($create==true){
		  		$response['success'] = true;
			  	$response['messages'] = 'Successfully created';
		  	}
		  	else {
		  		$response['success'] = false;
			  		$response['messages'] = 'Error in the Database while creating Category';
		  	}
		  }
		  else {
		  	$response['success'] = false;
			  		foreach($_POST as $key =>$value){
			  			$response['messages'][$key] = form_error($key);
			  		}
		  }
		  echo json_encode($response);
		}


		public function fetchCategoryData(){

			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

			$result = array('data' =>array());

			$data = $this->Model_category->fetchCategory();

			foreach ($data as $key => $value) {
				$buttons='';

				if($_SESSION['usercat']<3){
					//edit
					$buttons .='<button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['itemCatId'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				}
				if($_SESSION['usercat']<2){
					//delete
					$buttons .='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['itemCatId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
				}

				$status =($value['status_id'] ==1)?'<span class="label label-success">Active</span>' : '<span class="label label-warning">In-Active</span>';

				$result['data'][$key]=array(
					$value['ItemCatDescription'],
					$status,
					$buttons
				);
			}
			echo json_encode($result);
		}

		public function fetchCategoryDataById($id){
			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

			if($id) {
			$data = $this->Model_category->fetchCategory($id);
			echo json_encode($data);
		}

		return false;
		}


		public function updateCategory($id){

			///Check login data
			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

		  	$response = array();

		  	if($id){
		  		$this->form_validation->set_rules('edit_category_name', 'Category name', 'trim|required');
				$this->form_validation->set_rules('edit_category_status', 'Active', 'trim|required');

				$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run()==TRUE){
				$data = array(
					'ItemCatDescription' => $this->input->post('edit_category_name'),
					'status' => $this->input->post('edit_category_status')
				);

				$update = $this->Model_category->updateCategory($data,$id);

				if($update == true){
					$response['success'] =true;
					$response['messages'] ='Successfully Updated';
				}

				else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
	        	}
			}

			 else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }

		  	}
		  	else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}
		echo json_encode($response);
		}


		public function removeCategory($id){
			///Check login data
			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

		  	//$category_id = $this->input->post('category_id');

				$response = array();
				if($id) {
					$delete = $this->Model_category->removeCategory($id);
					if($delete == true) {
						$response['success'] = true;
						$response['messages'] = "Successfully removed";	
					}
					else {
						$response['success'] = false;
						$response['messages'] = "Error in the database while removing the brand information";
					}
				}
				else {
					$response['success'] = false;
					$response['messages'] = "Refresh the page again!!";
				}

				echo json_encode($response);
				//echo json_encode($_POST);
			}
		

		/*
			REGIONS
		*/

		public function getRegion(){

			if(!$this->session->logged_in){
	  			redirect('auth/login');
	  		}
	  		$data['title']	="Regions";
	  		$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('region/index',$data);
			//$this->load->view('templates/footer');
		}


		public function fetchRegion(){

			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
		  	$data = $this->Model_region->getRegion();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewRegionDetail/'.$value['regionid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a>';
		  		if($_SESSION['usercat']==1 ) {
		  			
		  		// $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['regionid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		//$status =($value['facstatus']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['RegionName'],
		  			$value['RegionPrefix'],
		  			$value['incharge'],
		  			$buttons
		  		);
		  		}

		  		echo json_encode($result);
		}

		public function fetchRegionDetail($id){
			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

		  	$data['title'] 			= 'Region Details';
		  	$data['districts']		= $this->Model_district->getDistrictByRegion($id)	;

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('region/details',$data);
		}
		 /*
			DISTRICTS
		 */
		public function getDistrict(){

			if(!$this->session->logged_in){
	  			redirect('auth/login');
	  		}
	  		$data['title']	="Districts";
	  		$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('district/index',$data);
			//$this->load->view('templates/footer');
		}


		public function fetchDistrict(){

			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
		  	$data = $this->Model_district->getDistrict();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewDistrictDetail/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1 ) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		//$status =($value['facstatus']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['DistrictName'],
		  			$value['RegionName'],
		  			$value['DistrictPrefix'],
		  			$value['map_internal_id'],
		  			$buttons
		  		);
		  		}

		  	echo json_encode($result);
		}


		/*

			FACILITIES
		*/
		public function getFacility(){

			if(!$this->session->logged_in)
				{
		  			redirect('auth/login');
		  		}

		  	$data['title']	="Facilities";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('facility/index',$data);
			//$this->load->view('templates/footer');
		}

		public function deactivetFacility($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data= array(
		  		'facstatus' 		=>0,
		  		'acted_on_by'	=>$_SESSION['id']
		  	);
		  	$remove=$this->Model_facility->deactivateFacility($id,$data);

		  	if($remove){
		  		redirect('manageFacility');
		  	}
		  	else {
		  		echo 'Tester Not De-Activated - Contact Informatics';
		  	}
		}

		public function reactivateFacility($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data= array(
		  		'facstatus' 		=>1,
		  		'acted_on_by'	=>$_SESSION['id']
		  	);
		  	$remove=$this->Model_facility->reactivateFacility($id,$data);

		  	if($remove){
		  		redirect('manageFacility');
		  	}
		  	else {
		  		echo 'Facility Not Re-Activated - Contact Informatics';
		  	}
		}

		public function fetchFacility(){

			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

	  		$result = array('data'=>array());
	  		$data = $this->Model_facility->getFacility();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewFacilityDetail/'.$value['sitecode']).'" class="btn btn-success btn-sm">View</a>
		  		';
		  		if($_SESSION['usercat']==1 or $_SESSION['usercat']==6 or $_SESSION['usercat']==3) {
		  			
		  		 $buttons.='<a href="'.base_url('editFacility/'.$value['sitecode']).'" class="btn btn-warning btn-sm">
				<i class="fa fa-pencil"></i></a>';

				if($status =($value['facstatus']==1)){
					$buttons.='<a href="'.base_url('delFacility/'.$value['sitecode']).'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
				}
				else {
					$buttons.='<a href="'.base_url('activateFacility/'.$value['sitecode']).'" class="btn btn-default btn-sm"><i class="fa fa-hand-o-up" aria-hidden="true"></i></a>';
				}

				
		  		}
		  		$status =($value['facstatus']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['sitecode'],
		  			$value['Sitename'],
		  			$value['level'],
		  			$value['owner'],
		  			$value['hub'],
		  			$value['DistrictName'],
		  			$value['RegionName'],
		  			$value['location'],
		  			$value['division'],
		  			$value['RegistrationDate'],
		  			$status,
		  			$buttons
		  		);
		  	}

	  		echo json_encode($result);
		}

		public function addFacility(){
			if(!$this->session->logged_in)
				{
		  			redirect('auth/login');
		  		}

		  	$data['title'] 			= "Add Facility";
		  	$data['district']		= $this->Model_district->getDistrict();
		  	$data['level']			= $this->Model_level->getLevel();
		  	$data['owner']			= $this->Model_owner->getOwner();
		  	$data['hub']			= $this->Model_hub->getHub();
		  	$data['deliverymode']	= $this->Model_deliveryMode->getDeliverymode();
		  	$data['sitecode']		= $this->Model_site->getOpensitecode();

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('facility/add',$data);
		}

		public function saveFacility(){
			if(!$this->session->logged_in)
				{
		  			redirect('auth/login');
		  		}
		  	
		  	$data=array(
		  		'sitecode' 		=> $this->input->post('sitecode'),
		  		'sitename'		=> $this->input->post('facilityname'),
		  		'districtid'	=> $this->input->post('district'),
		  		'levelid'		=> $this->input->post('facilitylevel'),
		  		'ownershipid'	=> $this->input->post('owner'),
		  		'hubcode'		=> $this->input->post('hubcode'),
		  		'delimode'		=> $this->input->post('delimode'),
		  		'division'		=> $this->input->post('division'),
		  		'location'		=> $this->input->post('location'),
		  		'registeredby' 	=> $_SESSION['id']
		  	);

		  	$create = $this->Model_facility->create($data);

		  	

		  	//delete sitecode from opensitecodes
		  	if($create){
		  		$cleanup=$this->Model_facility->delOpenSiteCode($this->input->post('sitecode'));
		  	}
			
			redirect ('addFacility');
		}

		public function editFacility($id){
			if(!$this->session->logged_in)
				{
		  			redirect('auth/login');
		  		}
		  	///
		  	$data['title'] 			= "Edit Facility";
		  	$data['district']		= $this->Model_district->getDistrict();
		  	$data['level']			= $this->Model_level->getLevel();
		  	$data['owner']			= $this->Model_owner->getOwner();
		  	$data['hub']			= $this->Model_hub->getHub();
		  	$data['deliverymode']	= $this->Model_deliveryMode->getDeliverymode();
		  	$data['facility']		= $this->Model_facility->getFacilityRaw($id);

		  	$this->load->view('facility/edit',$data);
		}

		public function updateFacility(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//update tester table

		  	$data=array(
		  			"Sitename"			=>$this->input->post('facilityname'),
		  			"Districtid" 		=>$this->input->post('district'),
		  			"levelid" 			=>$this->input->post('facilitylevel'),
		  			"ownershipid" 		=>$this->input->post('owner'),
		  			"hubcode" 			=>$this->input->post('hubcode'),
		  			"delimode" 			=>$this->input->post('delimode'),
		  			"division" 			=>$this->input->post('division'),
		  			"location" 			=>$this->input->post('location'),
					'acted_on_by'		=>$_SESSION['id']
		  	);

		  	$update = $this->Model_facility->updateFacility($this->input->post('sitecode'),$data);
		  	if($update){
		  		redirect('manageFacility');
		  	}
		  	else {
		  		echo 'Someting Wrong Happened';
		  		//print_r($data);
		  	}
		}
		/*
			ELEMENTS
		*/

		public function getElements(){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }
			$data['title']	="Elements";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('elements/index',$data);
			$this->load->view('templates/footer');
		}


		public function fetchElementData(){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }
			$result = array('data'=> array());
			$data = $this->Model_elements->getElementData();

			foreach ($data as $key => $value) {
				$count_attribute_value =$this->Model_elements->countElementValue($value['id']);

				//button
				$buttons ='<a href="'.base_url('addElementValue/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>Add Value</a>
				<button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>
				<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

				$status =($value['isactive']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

				// prepare an array to return to ajax call
				$result['data'][$key] = array(
					$value['attribute_name'],
					$count_attribute_value,
					$status,
					$buttons
				);
			} //end foreach
			echo json_encode($result);
		}

		public function addElementValue(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			$response=array();

			$this->form_validation->set_rules('elements_value', 'Element Value','trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			if($this->form_validation->run()==TRUE){
				$parent_id = $this->input->post('parent_id');

				$data = array(
					'value_name' =>$this->input->post('elements_value'),
					'parent_id' =>$parent_id
				);

				$create = $this->Model_elements->createValue($data);

				if($create==true){
					$response['success'] =true;
					$response['messages'] ='Successfully created';
				}
				else {
					$response['success'] =false;
					$response['messages'] ='Error in the Database wile adding element value';	
				}
			}
			else {
				$response['success'] =false;
				foreach($_POST as $key =>$value){
					$response['messages'][$key] = form_error($key);
				}
			}
			echo json_encode($response);
		}

		public function fetchElementDataById($id){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }
			if($id){
				$data = $this->Model_elements->getElementData($id);
				echo json_encode($data);
			}
		}

		public function addElement(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			 $response = array(); 
			 $this->form_validation->set_rules('element_name','Element Name','trim|required');
		  	 $this->form_validation->set_rules('element_status','Status','trim|required');

		  	 $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		  	 if($this->form_validation->run()==TRUE){
			  		$data = array(
			  			'attribute_name' => $this->input->post('element_name'),
			  			'isactive'	=> $this->input->post('element_status')
			  		);

			  		$create = $this->Model_elements->createElement($data);
			  		if($create ==true){
			  			$response['success'] = true;
			  			$response['messages'] = 'Successfully Added';
			  		}
			  		else {
			  			$response['success'] = false;
			  			$response['messages'] = 'Error in the Database while adding element';
			  		}
			  	}
			  	else {
			  		$response['success'] = false;
			  		foreach($_POST as $key =>$value){
			  			$response['messages'][$key] = form_error($key);
			  		}
			  	}
			  	echo json_encode($response);
		}

		public function updateElement($id){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			  $response = array();

			  if($id){
			  	$this->form_validation->set_rules('edit_element_name','Element Name','trim|required');
			  	$this->form_validation->set_rules('edit_element_status','Status','trim|required');

			  	$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			  	if($this->form_validation->run()==TRUE){
			  		$data = array(
			  			'attribute_name' => $this->input->post('edit_element_name'),
			  			'isactive'	=> $this->input->post('edit_element_status')
			  		);

			  		$update = $this->Model_elements->update($data,$id);
			  		if($update ==true){
			  			$response['success'] = true;
			  			$response['messages'] = 'Successfully Updated';
			  		}
			  		else {
			  			$response['success'] = false;
			  			$response['messages'] = 'Error in the Database while Updating';
			  		}
			  	}
			  	else {
			  		$response['success'] = false;
			  		foreach($_POST as $key =>$value){
			  			$response['messages'][$key] = form_error($key);
			  		}
			  	}

			  }
			  else {
			  	$response['success'] =false;
			  	$response['messages'] ='Error please refres the page and try again';
			  }
			  echo json_encode($response);
		}
		public function deleteElement(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			  $elementid = $this->input->post('element_id');

			  $response = array();
			  if($elementid){
			  	$delete = $this->Model_elements->removeElement($elementid);

			  	if($delete==true){
			  		$response['success'] = true;
			  		$response['messages'] = 'Successfully Removed';
			  	}
			  	else {
			  		$response['success'] = false;
			  		$response['messages'] = 'Error in the database while removing element';
			  	}
			  }
			  else {
			  	$response['success'] = false;
			  	$response['messages'] = 'Error: Please refresh and try again';
			  }
			  echo json_encode($response);
		}
		public function createElementValue($elementid=null){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

		  if(!$elementid){
			  	redirect('dashboard','refresh');
			  }

		  $this->data['element_data']= $this->Model_elements->getElementData($elementid);

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('elements/addvalue',$this->data);
			$this->load->view('templates/footer');
		}


		public function fetchElementValueData($parent_id){
			$result = array('data'=>array());

			$data = $this->Model_elements->getElementValueData($parent_id);

			foreach ($data as $key => $value) {
				$buttons ='
						<button type="button" class="btn btn-warning btn-sm" onclick="editFunc("'.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></buttnon> 
						<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc("'.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></buttnon>';

						$result['data'][$key] = array(
							$value['value_name'],
							$buttons
						);
			}  //foreach
			echo json_encode($result);
		}



		/*
		products
		*/
		public function getProducts(){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

		  	$data['title']	="Products";

		  	$attribute_data = $this->Model_attributes->getActiveAttributeData();

        	$attributes_final_data = array();
        	foreach ($attribute_data as $k => $v) {
        		$attributes_final_data[$k]['attribute_data'] = $v;

        		$value = $this->Model_attributes->getAttributeValueData($v['id']);

        		$attributes_final_data[$k]['attribute_value'] = $value;
        	}

        	$data['attributes'] = $attributes_final_data;
        	$data['category'] = $this->Model_category->getActiveCategroy();   
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('items/index',$data);
			$this->load->view('templates/footer');

		}
	
		public function editItem($id){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		 }

			  // $attribute_data = $this->Model_attributes->getActiveAttributeData();

		        // 	$attributes_final_data = array();
		        // 	foreach ($attribute_data as $k => $v) {
		        // 		$attributes_final_data[$k]['attribute_data'] = $v;

		        // 		$value = $this->Model_attributes->getAttributeValueData($v['id']);

		        // 		$attributes_final_data[$k]['attribute_value'] = $value;
		        // 	}

        	$data['attributes'] = $this->Model_items->fetchAtributeValuesByItemId($id);
        	$data['category'] = $this->Model_category->getActiveCategroy();  
        	$data['items']=$this->Model_items->fetchItems();
        	$data['id'] = $id;

			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('items/editItem',$data);
			$this->load->view('templates/footer');
		}		

		public function createItem(){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

		  	$data['title']	="Items";

		  	// attributes 
        	$attribute_data = $this->Model_attributes->getActiveAttributeData();

        	$attributes_final_data = array();
        	foreach ($attribute_data as $k => $v) {
        		$attributes_final_data[$k]['attribute_data'] = $v;

        		$value = $this->Model_attributes->getAttributeValueData($v['id']);

        		$attributes_final_data[$k]['attribute_value'] = $value;
        	}

        	$data['attributes'] = $attributes_final_data;
        	$data['category'] = $this->Model_category->getActiveCategroy();   
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('items/create',$data);
			$this->load->view('templates/footer');
		}

		

		public function addItem(){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

		  $this->form_validation->set_rules('product_name','Item Name','trim|required');
		  $this->form_validation->set_rules('product_expires','Product Expires','trim|required');
		  $this->form_validation->set_rules('product_group','Product Group','trim|required');
		  $this->form_validation->set_rules('attributes_value_id','Unit of Measure','trim|required');
		  $this->form_validation->set_rules('category','Category','trim|required');
		  $this->form_validation->set_rules('availability','Availability','trim|required');

		   if ($this->form_validation->run() == TRUE) {
		   	$data = array(
		   		'itemDescription' => $this->input->post('product_name'),
		   		'itemCategory' => $this->input->post('category'),
		   		'itemExpires' => $this->input->post('product_expires'),
		   		'attribute_value_id' => $this->input->post('attributes_value_id'),
		   		'ItemGroup' => $this->input->post('product_group'),
		   		'availability' => $this->input->post('availability')
		   	);
		   //print_r($data);exit();
		  // 	echo $this->input->post('product_name');exit();

		   	$create = $this->Model_items->create($data);
		   	if($create ==true){
			  			$response['success'] = true;
			  			$response['messages'] = 'Successfully Added';
			  		}
			  		else {
			  			$response['success'] = false;
			  			$response['messages'] = 'Error in the Database while adding element';
			  		}
			  	}
			  	else {
			  		$response['success'] = false;
			  		foreach($_POST as $key =>$value){
			  			$response['messages'][$key] = form_error($key);
			  		}
			  	}
			  	echo json_encode($response);
		}

		public function fetchItemData(){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

		  $result = array('data'=>array());
		  $data = $this->Model_items->getItems();

		  //iterate through the output
		  foreach($data as $key => $value){

		  	//create buttons
		  	$buttons="";

			  	if($_SESSION['usercat']<3){ //user can edit
			  		$buttons.= '<a href="'.base_url('editItem/'.$value['itemid']).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>';
			  	}
			  	if($_SESSION['usercat']<2){ //user can delete
			  		$buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['itemid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			  	}

			  	$expires =($value['itemExpires']==1) ? '<span class="label label-success">Yes</span>' : '<span class="label label-warning">No</span>';

			  	$qty_status ='';
			  	if ($value['quantity']<=0){
			  		$qty_status ='<span class="label label-danger pull-right">Out of Stock!</span>';
			  	}
			  	
			  	else if($value['quantity']<=10){
			  		$qty_status ='<span class="label label-warning pull-right">Low</span>';
			  	}

			  	$result['data'][$key]=array(
			  		$value['itemDescription'],
			  		$value['ItemCatDescription'],
			  		$expires,
			  		$value['ItemGroup'],
			  		$value['value_name'],
			  		$value['quantity'].' '.$qty_status,
			  		$buttons
			  	);
			}

			echo json_encode($result);
		}



		/*

			RECIPETS
		*/

		public function fetchRecieptData(){
			if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

		  $result = array('data'=>array());

		  ////Work on this after lunch
		  $data=$this->Model_reciepts->getRecieptData();

		  foreach ($data as $key => $value) {
				$count_reciept_lines =$this->Model_reciepts->countRecieptLines($value['id']);

				//button
				$buttons ='<a href="'.base_url('addRecieptLine/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>Add Line</a>
				<button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].') " data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>
				<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';

				//$status =($value['isactive']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

				// prepare an array to return to ajax call
				$result['data'][$key] = array(
					$value['recieptdate'],
					$value['recievedFrom'], 
					$count_reciept_lines,
					$value['description'],
					//$status,
					$buttons
				);
			} //end foreach
			echo json_encode($result);
		}
		public function getReciepts(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }


		  	$data['title']	="Manage Reciepts";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('reciepts/index',$data);
			$this->load->view('templates/footer');
		}

		public function stockItems(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			 $recs = array(
			  	'recieptdate' => $this->input->post('recieptdate'),
			  	'recievedFrom'=> $this->input->post('rxfrom'),
			  	'description' => $this->input->post('description'),
			  	'recievedby'  => $this->session->userdata('id')
			  );

			 $reciept_id = $this->Model_reciepts->createReciept($recs);
				
			$count_product = count($this->input->post('product'));

			 if($reciept_id){
				  for($x=0;$x<$count_product;$x++){
				
						$exp = array(
							'recieptid' =>$reciept_id,	
							'itemid'=> $this->input->post('product')[$x],
							'expirydate'=>$this->input->post('exp_dt')[$x]
						);

						$items = array(
							'recieptid' =>$reciept_id,
							'itemid'=> $this->input->post('product')[$x],
							'quantity' =>$this->input->post('qty')[$x],
							'store'=>$this->input->post('warehouse')[$x]
						);
						$this->Model_reciepts->addLineItem($items);
						$this->Model_reciepts->addExpiringData($exp);
				 }
			 } 
	
			
			redirect('RecieveItem');
		}

		public function RecieveItems(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }


		  	$data['title']	="Recieve Items";
		  	$data['products'] =$this->Model_items->getActiveItems();
		  	$data['stores']	  =$this->Model_warehouse->fetchWarehouse();
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('reciepts/create',$data);
			//$this->load->view('templates/footer');
		}

		/*
			REQUESTS
		*/

		public function getRequests(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }


		  	$data['title']	="Manage Requests";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('requests/index',$data);
			//$this->load->view('templates/footer');
		}

		public function fetchRequestData(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			$result = array('data'=>array());

		  ////Work on this after lunch
		  $data=$this->Model_requests->getRequestData();

		  foreach ($data as $key => $value) {
				$count_request_lines =$this->Model_requests->countRequestLines($value['requestid']);

				//button
				$buttons ='<a href="'.base_url('viewRequest/'.$value['requestid']).'" class="btn btn-default btn-sm">View Request</a>' ;
				if($value['requestedby']==$_SESSION['id']){
					if($value['status']==0){

						$buttons.='<button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['requestid'].') " data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>
						<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['requestid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
					}
				}

				if($value['toapprove']==$_SESSION['id']){
					/*$buttons.='<a href="'.base_url('approveRequest/'.$value['requestid']).'" class="btn btn-success btn-sm">Approve</a>
							   <a href="'.base_url('deferRequest/'.$value['requestid']).'" class="btn btn-warning btn-sm">Defer</a>
				               <a href="'.base_url('rejectRequest/'.$value['requestid']).'" class="btn btn-danger btn-sm">Reject</a>';
				               */
				    $buttons.='<a href="'.base_url('approveRequest/'.$value['requestid']).'" class="btn btn-success btn-sm">Action</a>';
				}

				// prepare an array to return to ajax call
				$result['data'][$key] = array(
					$value['requestdate'],
					$value['requester'], 
					$value['approver'],
					$value['requestStatus'],
					$count_request_lines,
					$value['comment'],
					//$status,
					$buttons
				);
			} //end foreach
			echo json_encode($result);
		}

		public function createRequest(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }


		  	$data['title']	="Request Items";
		  	$data['products'] =$this->Model_items->getActiveItems();
		  	$data['requester']	  =$this->Model_requests->getRequester();
		  	$data['approver'] =$this->Model_requests->getApprovers();
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('requests/create',$data);
			//$this->load->view('templates/footer');
		}


		public function addRequest(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			  $this->form_validation->set_rules('product[]','Item requested','required');

			  if($this->form_validation->run()==TRUE){

			  		$data=array(
			  			'requestdate' 	=> $this->input->post('requestdate'),
			  			'approver' 		=> $this->input->post('approver'),
			  			'requestedby'	=> $this->input->post('requestedby'),
			  		);
			  		$requestid=$this->Model_requests->create($data);

			  		$count_product = count($this->input->post('product'));

			  		if($requestid){
			  			for($x=0;$x<$count_product;$x++){
			  				$items= array(
			  					'requestid' =>$requestid,
			  					'itemid'	=>$this->input->post('product')[$x],
			  					'requestedquantity' => $this->input->post('qty_requested')[$x]
			  				);
			  				$this->Model_requests->addLineRequest($items);
			  			}
			  		}
			  	redirect('createRequest');
			  }
			  else {
			  	$this->session->set_flashdata('errors', 'Error occurred!!');
			  	redirect('createRequest');
			  }
			  
		}

		public function showRequest($requestid){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			  $data['request']=$this->Model_requests->getRequestData($requestid);
			  $data['requestdetail']=$this->Model_requests->getRequestDetail($requestid);

			  $this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('requests/viewRequest',$data);
		}

		/*
			ISSUES
		*/

		public function getIssues(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }


		  	$data['title']	="Manage Issues";

			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('issues/index',$data);
			$this->load->view('templates/footer');
		}


		/*
			ITEMS /PRODUCTS
		*/

		public function getActiveItems(){
			$products = $this->Model_items->getActiveItems();
			echo json_encode($products);
		}

		public function getItemValueById($id){
			//$product_id = $this->input->post('product_id');
			if($id){
				$product_data = $this->Model_items->getItemData($id);
				echo json_encode($product_data);
			}
		}


		/*
			WAREHOUSE
		*/

		public function Warehouse(){
		 if(!$this->session->logged_in){
		  	redirect('auth/login');
		  }

			$data['title']	="Warehouse";
			//$data['status']   = $this->Model_warehouse->getWarehouse();
			

			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('warehouse/index',$data);
			$this->load->view('templates/footer');
		}

		public function fetchWarehouseData(){

			if(!$this->session->logged_in){
		  		redirect('auth/login');
		  	}

			$result = array('data' =>array());

			$data = $this->Model_warehouse->fetchWarehouse();

			foreach ($data as $key => $value) {
				$buttons='';

				if($_SESSION['usercat']<3){
					//edit
					$buttons .='<button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
				}
				if($_SESSION['usercat']<2){
					//delete
					$buttons .='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
				}

				$status =($value['status'] ==1)?'<span class="label label-success">Active</span>' : '<span class="label label-warning">In-Active</span>';

				$result['data'][$key]=array(
					$value['name'],
					$status,
					$buttons
				);
			}
			echo json_encode($result);
		}


		public function addWarehouse(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			 $response = array(); 
			 $this->form_validation->set_rules('warehouse_name','Warehouse Name','trim|required');
		  	 $this->form_validation->set_rules('warehouse_status','Status','trim|required');

		  	 $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		  	 if($this->form_validation->run()==TRUE){
			  		$data = array(
			  			'name' 		=> $this->input->post('warehouse_name'),
			  			'status'	=> $this->input->post('warehouse_status')
			  		);

			  		$create = $this->Model_warehouse->createWarehouse($data);
			  		if($create ==true){
			  			$response['success'] = true;
			  			$response['messages'] = 'Successfully Added';
			  		}
			  		else {
			  			$response['success'] = false;
			  			$response['messages'] = 'Error in the Database while adding element';
			  		}
			  	}
			  	else {
			  		$response['success'] = false;
			  		foreach($_POST as $key =>$value){
			  			$response['messages'][$key] = form_error($key);
			  		}
			  	}
			  	echo json_encode($response);
		}

		public function fetchWarehouseDataById($id){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }
			if($id){
				$data = $this->Model_warehouse->getWarehouseData($id);
				echo json_encode($data);
			}
		}

		public function updateWarehouse($id){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			  $response = array();

			  if($id){
			  	$this->form_validation->set_rules('edit_warehouse_name','Warehouse Name','trim|required');
			  	$this->form_validation->set_rules('edit_warehouse_status','Status','trim|required');

			  	$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

			  	if($this->form_validation->run()==TRUE){
			  		$data = array(
			  			'name' => $this->input->post('edit_warehouse_name'),
			  			'status'	=> $this->input->post('edit_warehouse_status')
			  		);

			  		$update = $this->Model_warehouse->update($data,$id);
			  		if($update ==true){
			  			$response['success'] = true;
			  			$response['messages'] = 'Successfully Updated';
			  		}
			  		else {
			  			$response['success'] = false;
			  			$response['messages'] = 'Error in the Database while Updating';
			  		}
			  	}
			  	else {
			  		$response['success'] = false;
			  		foreach($_POST as $key =>$value){
			  			$response['messages'][$key] = form_error($key);
			  		}
			  	}

			  }
			  else {
			  	$response['success'] =false;
			  	$response['messages'] ='Error please refres the page and try again';
			  }
			  echo json_encode($response);
		}


		public function deleteWarehouse(){
			if(!$this->session->logged_in){
			  	redirect('auth/login');
			  }

			  $elementid = $this->input->post('warehouse_id');

			  $response = array();
			  if($elementid){
			  	$delete = $this->Model_warehouse->removeWarehouse($elementid);

			  	if($delete==true){
			  		$response['success'] = true;
			  		$response['messages'] = 'Successfully Removed';
			  	}
			  	else {
			  		$response['success'] = false;
			  		$response['messages'] = 'Error in the database while removing element';
			  	}
			  }
			  else {
			  	$response['success'] = false;
			  	$response['messages'] = 'Error: Please refresh and try again';
			  }
			  echo json_encode($response);
		}


		///////////////////////////////////////////////////////////////////////////////
		/////////////												///////////////////
		///////////// 				HIV/SYPHILIS METHODS	 		///////////////////
		///////////// 												///////////////////
		///////////////////////////////////////////////////////////////////////////////

		public function getTitleCategory() {
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}


		  	$data['title']	="Title Category";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('title/category',$data);
			//$this->load->view('templates/footer');
		}

		public function createTitle(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data=array(
		  	 "name" 			=>$this->input->post('cadre'),
		  	 "titleCategory"	=>$this->input->post('cadre_category')
		  	);

		  	$create=$this->Model_title->saveTitle($data);

		  	if($create){
		  		redirect('manageCadre');
		  	}
		  	else {
		  		echo 'Title Failed to Save';
		  	}
		}
		public function addTitle(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']		=	"Title Category";
		  	$data['category']	=	$this->Model_title->getTitleCategory();
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('title/addTitle',$data);
		}

		public function fetchTitleCategory(){

			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

	  		$result = array('data'=>array());
	  		$data = $this->Model_title->getTitleCategory();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewFacilityDetail/'.$value['categoryId']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['categoryId'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['categoryId'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		//$status =($value['facstatus']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['CategoryName'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function getTitle(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="Cadres";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('title/index',$data);
			//$this->load->view('templates/footer');
		}

		public function fetchTitle(){

			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

	  		$result = array('data'=>array());
	  		$data = $this->Model_title->getTitle();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewFacilityDetail/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		//$status =($value['facstatus']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['name'],
		  			$value['CategoryName'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}
		public function reactivateTester($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data= array(
		  		'status' 		=>1,
		  		'acted_on_by'	=>$_SESSION['id']
		  	);
		  	$remove=$this->Model_tester->reactivateTester($id,$data);

		  	if($remove){
		  		redirect('manageTester');
		  	}
		  	else {
		  		echo 'Tester Not De-Activated - Contact Informatics';
		  	}
		}
		public function removeTester($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data= array(
		  		'status' 		=>0,
		  		'acted_on_by'	=>$_SESSION['id']
		  	);
		  	$remove=$this->Model_tester->deactivateTester($id,$data);

		  	if($remove){
		  		redirect('manageTester');
		  	}
		  	else {
		  		echo 'Tester Not De-Activated - Contact Informatics';
		  	}
		}
		public function updateTester(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//update tester table

		  	$data=array(
		  			'TesterName' 	=>$this->input->post('testername'),
					'title'			=>$this->input->post('cadre'),
					'contacts'		=>$this->input->post('contacts'),
					'acted_on_by'	=>$_SESSION['id']
		  	);

		  	$sitetester= array(
		  		'dept'			=>	$this->input->post('dept'),
		  		'sitecode'		=>	$this->input->post('facility'),
		  		'acted_on_by'	=>$_SESSION['id']
		  	);


		  	$update = $this->Model_tester->updateTester($this->input->post('testercode'),$data);
		  	if($update){

		  		//update sitetester
		  		$st_update= $this->Model_tester->updateSiteTeste($this->input->post('testercode'),$sitetester);

		  		redirect('manageTester');
		  	}
		  	else {
		  		echo 'Someting Wrong Happened';
		  		//print_r($data);
		  	}
		}
		public function saveNewTester(){	
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	

		  	//insert into tester the new tester
		  	$data = array(
					'tcode'  		=>$this->input->post('testercode'),
					'TesterName' 	=>$this->input->post('testername'),
					'title'			=>$this->input->post('cadre'),
					'contacts'		=>$this->input->post('contacts'),
					'created_by'	=>$_SESSION['id']
				);
		  	$insert=$this->Model_tester->addNewTester($data);
		  	//insert into the site tester 
		  	$stdata = array(
		  		'sitecode' 		=>$this->input->post('facility'),
		  		'testercode'	=>$this->input->post('testercode'),
		  		'dept'			=>$this->input->post('dept'),
		  		'created_by'	=>$_SESSION['id']
		  	);

		  	if($insert){
		  		$stinsert=$this->Model_site->addNewSiteTester($stdata);
		  	}
		  	

		  	//delete tcode from opencodes
			$cleanup=$this->Model_tester->delOpenCode($this->input->post('testercode'));


		  	redirect ('addTester');
		}

		public function addTester(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']		= "Testers";
		  	//$data['sanitize']	= $this->Model_tester->sanitizeOpenCode();
		  	$data['cadre']		= $this->Model_title->getTitle();
		  	$data['facility']	= $this->Model_facility->getFacility();
		  	$data['dept']		= $this->Model_department->getDepartment();
		  	$data['opencode']	= $this->Model_tester->getOpencode();
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('tester/add',$data);
		}

		public function getTester(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']		= "Testers";
		  	

			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('tester/index',$data);
		}

		public function fetchproposedTester(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

	  		$result = array('data'=>array());
	  		$data = $this->Model_tester->getProposedTester();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('saveProposedTester/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Save</a>';
		  		if($_SESSION['usercat']==1 or $_SESSION['usercat']==3 or $_SESSION['usercat']==6) {
		  			
			  		
			  		 $buttons.='<a href="'.base_url('removeProposedTester/'.$value['id']).'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
			  		
			  		
		  		}
		  		
		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['sitename'],
		  			$value['testername'],
		  			$value['cadre'],
		  			$value['departmentname'],
		  			(int)$value['contact'],
		  			$value['suggestedDate'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function saveProposedTester($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	//clean opentcodes 
		  //	$cleanup=$this->Model_tester->cleanupOpenCode();

		  	//get tester details from proposed table
		  	$tester=$this->Model_tester->getProposedTesterDetail($id);
		  	//print_r($tester);

		  	//get next available tcode
		  	$tcode	= $this->Model_tester->getOpencode();

		  
		  

		  	//insert into tester the new tester
		  	$data = array(
					'tcode'  		=>$tcode['testercode'],
					'TesterName' 	=>$tester['testername'],
					'title'			=>$tester['title'],
					'contacts'		=>(int)$tester['contact'],
					'created_by'	=>$_SESSION['id']
				);
		  	$insert=$this->Model_tester->addNewTester($data);
		  	//insert into the site tester 
		  	$stdata = array(
		  		'sitecode' 		=>$tester['facility'],
		  		'testercode'	=>$tcode['testercode'],
		  		'dept'			=>$tester['dept'],
		  		'created_by'	=>$_SESSION['id']
		  	);

		  	if($insert){
		  		$stinsert=$this->Model_site->addNewSiteTester($stdata);
		  	}
		  	

		  	//delete tcode from opencodes
			$cleanup=$this->Model_tester->delOpenCode($tcode['testercode']);


		  	//update tester details as effected
		  	if($this->Model_tester->updateEffectedTester($id)){
		  		redirect ('viewProposedTesters');
		  	}
		}

		public function removeProposedTester($id){
			//update tester details as effected
		  	if($this->Model_tester->updateEffectedTester($id)){
		  		redirect('viewProposedTesters');
		  	}
		}

		public function fetchTester(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

	  		$result = array('data'=>array());
	  		$data = $this->Model_tester->getTester();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('testerDetail/'.$value['tcode']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a>
		  		<a href="'.base_url('editTester/'.$value['tcode']).'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
				</button>';
		  		if($_SESSION['usercat']==1 or $_SESSION['usercat']==3 or $_SESSION['usercat']==6) {
		  			
			  		if($value['status']==1){
			  		 $buttons.='<a href="'.base_url('removeTester/'.$value['tcode']).'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
			  		}
			  		else {
			  			$buttons.='<a href="'.base_url('reactivateTester/'.$value['tcode']).'" class="btn btn-default btn-sm"><i class="fa fa-hand-o-up" aria-hidden="true"></i></a>';
			  		}
		  		}
		  		$status =($value['status']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['tcode'],
		  			$value['TesterName'],
		  			$value['Title'],
		  			$value['sitename'],
		  			$value['sitecode'],
		  			$value['department'],
		  			$value['districtname'],
		  			$value['contacts'],
		  			$status,
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function getHub(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="Hubs";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('hub/index',$data);
		}

		public function fetchHub(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

	  		$result = array('data'=>array());
	  		$data = $this->Model_hub->getHub();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('testerDetail/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['name'],
		  			
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function getCycle(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="Cycles";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cycle/index',$data);
		}

		public function fetchCycle(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

	  		$result = array('data'=>array());
	  		$data = $this->Model_cycle->getCycle();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('cycleDetail/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		$status =($value['isActive']==1)?'<span class="label label-success">Active</span>':'<span class="label label-warning">In-Active</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['name'],
		  			$value['cycleyear'],
		  			$value['calendardesc'],
		  			$value['Description'],
		  			$status,
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function createCycle(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']		="Cycles";
		  	$data['copyears']	=$this->Model_cycle->getCopYears();
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cycle/create',$data);

		}

		public function SaveDtsCycle(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$cycleyear=date('Y', strtotime($this->input->post('startdate')));
		  	$caldesc = date('M', strtotime($this->input->post('startdate')))." - ".date('M', strtotime($this->input->post('enddate')))." ".$cycleyear;
		  	$data=array(
		  		'name' 				=> $this->input->post('cyclename'),
		  		'quater'			=> $this->input->post('quarter'),
		  		'cycleyear'			=> $cycleyear,
		  		'startdate'			=> $this->input->post('startdate'),
		  		'enddate'			=> $this->input->post('enddate'),
		  		'copid'				=> $this->input->post('copyear'),		  
		  		'description'		=> $this->input->post('cycledescription'),
		  		'calendardesc'		=> $caldesc,
		  		'panel_label'		=> $this->input->post('panellabel')
		  	);

		  	$create = $this->Model_cycle->create($data);
		  	if($create){
		  		redirect('manageCycle');
		  	}

		}
		public function getHivDtsSecondEntrySamples(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="Second Entry List";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('entry/hivdts_second_entry_list',$data);
		}

		public function hivdtssamplelist(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="Smples List";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('entry/hivdts_second_entry_list',$data);

		}

		public function hivrecencysampleList(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="HIV Recency Samples List";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('recency/index',$data);
		}

		public function dtsSecondEntry($sampleid){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="Second Entry";
		  	$data['tester']=$this->Model_tester->getTester();
		  	$data['facility'] = $this->Model_facility->getFacility();
		  	$data['department']= $this->Model_department->getDepartment();
		  	$data['hivtests']=$this->Model_testname->getHivTests();
		  	$data['activeqtr']=$this->Model_cycle->getCycle();
		  	$data['testresult']=$this->Model_testresult->getHivSyphTestResult();
		  	$data['reasons']=$this->Model_notestingreason->getReason();
		  	$data['cadre']=$this->Model_title->getTitle();

		  	//get data for the first sample
		  	$data['sample']		=$this->Model_hivdtssamples->getSampleDetail($sampleid);
		  	$data['hivtestkit']	= $this->Model_hivdtssamples->getHivSampleTestkit($sampleid);
		  	$data['syphiliskit']	=$this->Model_syphsample->getSyphilisTestkit($sampleid);
		  	$data['syphresult']	=$this->Model_syphsample->getSyphilisResult($sampleid);
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('entry/hivdts_second_entry',$data);
			$this->load->view('templates/footer');
		}
		public function showDtsEntry($sampleid){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//echo $sampleid;
		  	//fetch sample information based on sampleid
		  	$t['sample']				=	$this->Model_hivdtssamples->getSampleDetail($sampleid);
		  	$t['hivtestkit']			= 	$this->Model_hivdtssamples->getHivSampleTestkit($sampleid);
		  	$t['dtsresult']				= 	$this->Model_hivresult->getDtsResultBySample($sampleid);
		  	$t['syphiliskit']			=	$this->Model_syphsample->getSyphilisTestkit($sampleid);
		  	$t['syphresult']			=	$this->Model_syphsample->getSyphilisResult($sampleid);
		  	$t['resultcomment']			=	$this->Model_hivresult->getResultComment($sampleid);
		  	$t['testerInfor']			=	$this->Model_hivdtssamples->getTesterDetailBySampleId($sampleid);
		  	$t['samplecomment']			=	$this->Model_othercomments->readOtherCommentsBySampleid($sampleid);
		  	$t['approver']				= $this->Model_hivdtssamples->getApproverBySampleId($sampleid);

		  	
		  	// echo '<pre>';
		  	// print_r($t);
		  	// echo '</pre>';
		  
		  	//$this->load->view('templates/header');
			//$this->load->view('templates/header_menu');
			//$this->load->view('templates/side_menubar');

			$this->load->view('reports/dtsReview',$t);
		}

		public function fetchDoDBySiteCycle($testercode,$formserial,$site,$cycle=null){
			$dod=$this->Model_distributions->getDODByCycleSite($site,$cycle);
			$dupform=false;
			$isFormin=$this->Model_hivdtssamples->isFormUnique($testercode,$formserial,$cycle);
			if($isFormin>0){
				$dupform=true;
			}
			$data=array(
					'dupform' 	=>$dupform,
					'dod'		=>$dod['distributiondate']
			);
			echo json_encode($data);

		}

		public function fetchRecencyDoD($batch,$testercode,$formserial,$site){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$dod = $this->Model_distributions->getRecDoDByCycleSite($site,$batch);
		  	$dupform=false;
		  	$isFormin = $this->Model_recencysample->isFormUnique($formserial,$batch);
		  	if($isFormin>0){
				$dupform=true;
			}
			$data=array(
					'dupform' 	=>$dupform,
					'dod'		=>$dod['dod'],
					'isin'		=>$isFormin,
					'f_s'		=>$formserial,
					'batchnum'	=>$batch
			);
			echo json_encode($data);
		}
		public function recallHIVDtsApproval($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//remove approval information from the samples table
		  	$recallHIV=$this->Model_hivdtssamples->recallApproval($id);
		  	$recallSYP=$this->Model_syphsample->recallApproval($id);

		  	//remove any comments that were made during approval
		  	$hivcomdel=$this->Model_hivdtssamples->removeHIVCommentBySampleid($id);
		  	$sypcomdel=$this->Model_syphsample->removeSYPHCommentBySampleid($id);
		  	redirect('hivdtssamples');
		}

		public function fetchRecencySampleList(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_recencysample->getSamplesList();

	  		foreach($data as $key=>$value){
		  		if($value['approved']==1){
		  			$app_status='Approved';
		  		}
		  		else {
		  			$app_status='Pending';
		  		}
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewrecencyEntry/'.$value['sampleid']).'" class="btn btn-primary btn-sm" style="margin-right:3px;"><i class="fa fa-info" style="padding-right:2px;"></i></a>
		  			<a href ="'.base_url('loadrecencyPdfReport/'.$value['sampleid']).'" class="btn btn-warning btn-sm" style="margin-right:3px;" target="_blank"><i class="fa fa-file-pdf-o" style="padding-right:2px;" ></i></a>
		  		';
		  		if($_SESSION['usercat']==1) { ///super user
		  			if($value['enteredby']==$_SESSION['id'] && $value['destat']==1){
		  				$buttons.= '<a href="'.base_url('editrecencyEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		  			}
		  			
		  			elseif($value['destat']==1 && $value['enteredby']==$_SESSION['id'] ){
		  				$buttons.= '<a href="'.base_url('recencySecondEntry/'.$value['sampleid']).'" class="btn btn-default btn-sm" ><i class="fa fa-list" aria-hidden="true"></i></a>';
		  			}
		  			
		  		}
		  		elseif ($_SESSION['usercat']==4){ //Monitoring and Evaluation 

		  		}
		  		elseif ($_SESSION['usercat']==2){ // Lab tech
		  			if($value['approvedby']==$_SESSION['id'] && $value['printed']==0){
		  				$buttons.= '<a href="'.base_url('recallrecencyApproval/'.$value['sampleid']).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle" aria-hidden="true"></i>Recall</a>';
		  			}
		  			elseif ($value['destat']==3 && $value['approved']==0){
		  				$buttons.= '<a href="'.base_url('approveRecencyResult/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>';
		  			}
		  		}
		  		elseif ($_SESSION['usercat']==3){ //Data entry

		  			if($value['destat']==1 && $value['enteredby']!=$_SESSION['id'] ){
		  				$buttons.= '<a href="'.base_url('recencySecondEntry/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-database" aria-hidden="true"></i></a>';
		  			}
		  			elseif($value['enteredby']==$_SESSION['id'] && $value['destat']==1){
		  				$buttons.= '<a href="'.base_url('editrecencyEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		  			}

		  		}
		  		elseif ($_SESSION['usercat']==19){ //Informatics

		  		}
			/*
		  		$buttons= '<a href="'.base_url('addSecondEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>2nd Entry</a>

		  			<a href="'.base_url('reviewFirstEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Edit 1st Entry</a>
		  			<a href="'.base_url('reviewSecondEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Edit 2nd Entry</a>
		  		';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['sampleid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		
					*/
		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['testername'],
		  			$value['testercode'],
		  			$value['cadre'],

		  			$value['sitename'],
		  			$value['sitecode'],
		  			$value['levelname'],
		  			$value['owner'],
		  			$value['district'],
		  			$value['regionname'],
		  			$value['cycleid'],
		  			$value['departmentname'],
		  			$value['score'],
		  			$value['status'],
		  			$value['hub'],
		  			$value['dod'],
		  			$value['dsr'],
		  			$value['DateRxAtUVRI'],
		  			$value['formSerial'],
		  			$app_status,
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function approveRecResult($sampleid){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
			//echo $sampleid;
			$data['sampleInfo'] 		= $this->Model_recencysample->getSampleInfo($sampleid);
			$data['sampleRes'] 			= $this->Model_recencysample->getResultBySampleId($sampleid);
			$data['perform']			= $this->Model_recencysample->viewSampleResult($sampleid);
			$data['expected_res'] 		= $this->Model_recencysample->getExpectedFinalResSampleid($sampleid);
			$data['commentcategory']	= $this->Model_commentcategory->getHIVRecencyCommentCategory();
			
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			//$this->load->view('templates/side_menubar');
			$this->load->view('recency/approveSample',$data);
		}

		public function recsaveapproval(){
		//echo $this->input->post('sample');
			$recschemid=5;
		 // 	print_r($_POST);
		 // exit();

			//pick values for final marking and updating
			$sampleid=$this->input->post('sampleid');
			$approver=$this->input->post('approvedby');
			$syphscore = $this->input->post('pscore');
			$syphstatus = $this->input->post('pstat');

			////////////////////////////

			if($this->input->post('syphcomments'))
			{
			  	$sycomment=array();
				for($j=0;$j<count($this->input->post('syphcomments'));$j++)
			  	{
			  		if($this->input->post('syphcomments')[$j] )
			  		{
				  		$res=array(
					  			'sampleid'	=>$this->input->post('sampleid'),
					  			'schemeid'	=>$recschemid,
					  			'commentid'	=>$this->input->post('syphcomments')[$j]
					  		);

					  	array_push($sycomment,$res);
				  	}
			  	}

				 //check if the the comments that ungrade are in
			  	$ungrading_sycomment=array_column($sycomment, 'commentid');
			  	if (in_array(2,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	elseif (in_array(3,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	
			  	elseif (in_array(6,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	elseif (in_array(9,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	elseif(in_array(10,$ungrading_sycomment)){
	  				$syphscore='N/A';
	  				$syphstatus='Un-Graded';
			  	}
			  	elseif(in_array(13,$ungrading_sycomment)){
	  				$syphscore='N/A';
	  				$syphstatus='Un-Graded';
			  	}
			  	


			  	$recupdate=$this->Model_recencysample->approveRecencyRecord($sampleid,$_SESSION['id'],$syphscore,$syphstatus);
			  	

			 
			  	$com_insert=$this->Model_othercomments->insertRecencyComment($sycomment);
			}
			else 
			{
			  	$recupdate=$this->Model_recencysample->approveRecencyRecord($sampleid,$_SESSION['id'],$syphscore,$syphstatus);
			}

			redirect('hivrecencysamples');
			//////////////////////////////////
		}

		public function editDtsEntry($sampleid){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
			
			//get details
			$data['sample']				= $this->Model_hivdtssamples->getSampleDetail($sampleid);
		  	$data['hivtestkit']			= $this->Model_hivdtssamples->getHivSampleTestkit($sampleid);
		  	$data['nottestedreason']	= $this->Model_hivdtssamples->getReasonForNotTesting($sampleid);
		  	// $t['hivexpectedresult']	= $this->Model_hivdtssamples->getHivExpectedResult($sampleid);
		  	// $t['testerInfor']		= $this->Model_hivdtssamples->getTesterDetailBySampleid($sampleid);
		  	$data['dtsresult']			= $this->Model_hivresult->getDtsResultBySample($sampleid);
		  	$data['syphiliskit']		= $this->Model_syphsample->getSyphilisTestkit($sampleid);
		  	$data['syphresult']			= $this->Model_syphsample->getSyphilisResult($sampleid);
		  	$data['resultcomment']		= $this->Model_hivresult->getResultComment($sampleid);
		  	// $t['syphexpectedresult']= $this->Model_syphsample->getSyphExpectedResult($sampleid);
		  	// $t['commentcategory']	= $this->Model_commentcategory->getHIVDTSCommentCategory();	

		  	$data['tester']=$this->Model_tester->getTester();
		  	$data['facility'] = $this->Model_facility->getFacility();
		  	$data['department']= $this->Model_department->getDepartment();
		  	$data['hivtests']=$this->Model_testname->getHivTests();
		  	$data['activeqtr']=$this->Model_cycle->getCycle();
		  	$data['testresult']=$this->Model_testresult->getHivSyphTestResult();
		  	$data['reasons']=$this->Model_notestingreason->getReason();
		  	$data['cadre']=$this->Model_title->getTitle();
		  //	$data['entries']	= $this->Model_hivdtssamples->showEntries();

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('entry/dtsEdit',$data);	  
			//$this->load->view('templates/footer');	
		}
		public function fetchHIVSamples(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
			
			$result = array('data'=>array());
	  		$data = $this->Model_hivdtssamples->listHivDtsSamples();

	  		$dimensions=array('width'      => '800','height'     => '600');
		  	foreach($data as $key=>$value){
		  		$newDate = date("d-m-Y",strtotime($value['date_entered'])); // convert date to human readable format
		  		if($value['Approved']==1){
		  			$app_status='Approved';
		  		}
		  		else {
		  			$app_status='Pending';
		  		}
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewdtsEntry/'.$value['sampleid']).'" class="btn btn-primary btn-sm" style="margin-right:3px;"><i class="fa fa-info" style="padding-right:2px;"></i></a>
		  			<a href ="'.base_url('loadPdfReport/'.$value['sampleid']).'" class="btn btn-warning btn-sm" style="margin-right:3px;" target="_blank"><i class="fa fa-file-pdf-o" style="padding-right:2px;" ></i></a>
		  		';
		  		if($_SESSION['usercat']==6 or $_SESSION['usercat']==3) { /// Datamanager and super user to edit dts entry
		  			if( $value['Approved']!=1 || $app_status='Approved' ){ // $value['enteredby']==$_SESSION['id'] &&
		  				$buttons.= '<a href="'.base_url('editdtsEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		  			}
		  			elseif($value['destat']==1 && $value['enteredby']==$_SESSION['id'] ){
		  				$buttons.= '<a href="'.base_url('dtsSecondEntry/'.$value['sampleid']).'" class="btn btn-default btn-sm" ><i class="fa fa-list" aria-hidden="true"></i></a>';
		  			}
		  		}
		  		elseif ($_SESSION['usercat']==4){ //Monitoring and Evaluation 

		  		}
		  		elseif ($_SESSION['usercat']==2 || $_SESSION['usercat']==1){ // Lab tech
		  			if($value['ApprovedBy']==$_SESSION['id'] && $value['Printed']==0){
		  				$buttons.= '<a href="'.base_url('recalldtsApproval/'.$value['sampleid']).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle" aria-hidden="true"></i>Recall</a>';
		  			}
		  			elseif ($value['destat']==3 && $value['Approved']==0){
		  				$buttons.= '<a href="'.base_url('approveDtsResult/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>';
		  			}
		  		}
		  		elseif ($_SESSION['usercat']==3){ //Data entry

		  			if($value['destat']==1 && $value['enteredby']!=$_SESSION['id'] ){
		  				$buttons.= '<a href="'.base_url('dtsSecondEntry/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-database" aria-hidden="true"></i></a>';
		  			}
		  			elseif($value['enteredby']==$_SESSION['id'] && $value['destat']==1){
		  				$buttons.= '<a href="'.base_url('editdtsEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		  			}

		  		}
		  		elseif ($_SESSION['usercat']==19){ //Informatics

		  		}
			/*
		  		$buttons= '<a href="'.base_url('addSecondEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>2nd Entry</a>

		  			<a href="'.base_url('reviewFirstEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Edit 1st Entry</a>
		  			<a href="'.base_url('reviewSecondEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Edit 2nd Entry</a>
		  		';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['sampleid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		
					*/
		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['testercode'],
		  			$value['TesterName'],
		  			$value['Name'],
		  			$value['sitecode'],
		  			$value['Sitename'],
		  			$value['dod'],
		  			$value['dsr'],
		  			$value['dtsr'],
		  			$value['dtst'],
		  			$value['DateRxAtUVRI'],
		  			$value['formserial'],
		  			$value['date_entered'],
		  			$app_status,
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function getcycleDetail($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']			=	'Cycle Detail';
		  	$data['cycledata']		=  	$this->Model_cycle->getCycle($id);
		  	$data['targeted']		= 	$this->Model_cycle->getCycleSummary($id);
		  	$data['expected_res']	= 	$this->Model_cycle->getCycleExpectedResults($id);
		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cycle/cycledetail',$data);
		}

		public function syphilisSampleList(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('syphilis/index');

		}
		public function fetchSyphilisSamples(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
			
			$result = array('data'=>array());
	  		$data = $this->Model_syphsample->listSyphilisSamples();

	  		$dimensions=array('width'      => '800','height'     => '600');
		  	foreach($data as $key=>$value){
		  		$newDate = date("d-m-Y",strtotime($value['DateRxAtUVRI'])); // convert date to human readable format
		  		if($value['Approved']==1){
		  			$app_status='Approved';
		  		}
		  		else {
		  			$app_status='Pending';
		  		}
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewdtsEntry/'.$value['sampleid']).'" class="btn btn-primary btn-sm" style="margin-right:3px;"><i class="fa fa-info" style="padding-right:2px;"></i></a>
		  			<a href ="'.base_url('loadPdfReport/'.$value['sampleid']).'" class="btn btn-warning btn-sm" style="margin-right:3px;" target="_blank"><i class="fa fa-file-pdf-o" style="padding-right:2px;" ></i></a>
		  		';
		  		if($_SESSION['usercat']==1) { ///super user
		  			if($value['enteredby']==$_SESSION['id'] && $value['destat']==1){
		  				$buttons.= '<a href="'.base_url('editdtsEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		  			}
		  			elseif($value['destat']==1 && $value['enteredby']==$_SESSION['id'] ){
		  				$buttons.= '<a href="'.base_url('dtsSecondEntry/'.$value['sampleid']).'" class="btn btn-default btn-sm" ><i class="fa fa-list" aria-hidden="true"></i></a>';
		  			}
		  		}
		  		elseif ($_SESSION['usercat']==4){ //Monitoring and Evaluation 

		  		}
		  		elseif ($_SESSION['usercat']==2){ // Lab tech
		  			if($value['ApprovedBy']==$_SESSION['id'] && $value['Printed']==0){
		  				$buttons.= '<a href="'.base_url('recalldtsApproval/'.$value['sampleid']).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle" aria-hidden="true"></i>Recall</a>';
		  			}
		  			elseif ($value['destat']==3 && $value['Approved']==0){
		  				$buttons.= '<a href="'.base_url('approveDtsResult/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>';
		  			}
		  		}
		  		elseif ($_SESSION['usercat']==3){ //Data entry

		  			if($value['destat']==1 && $value['enteredby']!=$_SESSION['id'] ){
		  				$buttons.= '<a href="'.base_url('dtsSecondEntry/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-database" aria-hidden="true"></i></a>';
		  			}
		  			elseif($value['enteredby']==$_SESSION['id'] && $value['destat']==1){
		  				$buttons.= '<a href="'.base_url('editdtsEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		  			}

		  		}
		  		elseif ($_SESSION['usercat']==19){ //Informatics

		  		}
			/*
		  		$buttons= '<a href="'.base_url('addSecondEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>2nd Entry</a>

		  			<a href="'.base_url('reviewFirstEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Edit 1st Entry</a>
		  			<a href="'.base_url('reviewSecondEntry/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Edit 2nd Entry</a>
		  		';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['sampleid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		
					*/
		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['testercode'],
		  			$value['TesterName'],
		  			$value['cadre'],
		  			$value['CategoryName'],
		  			$value['sitecode'],
		  			$value['sitename'],
		  			$value['departmentname'],
		  			$value['LevelName'],
		  			$value['dispatchdate'],
		  			$value['samplerecieptdate'],
		  			$value['reconstitutiondate'],
		  			$value['testdate'],
		  			$value['DateRxAtUVRI'],
		  			$value['Supervisor'],
		  			$value['kitName'],
		  			$value['LotNo'],
		  			$value['expiryDate'],
		  			$value['score'],
		  			$value['Result'],
		  			$value['quarter'],
		  			$value['formserial'],
		  			$app_status,
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function importDistribution(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('distributions/import');
		}

		public function importFile(){
		 	if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		      if ($this->input->post('submit')) {
		                 
		                $path = 'assets/uploads/';
		                require_once APPPATH . "/third_party/PHPExcel.php";
		                $config['upload_path'] = $path;
		                $config['allowed_types'] = 'xlsx|xls|csv';
		                $config['remove_spaces'] = TRUE;
		                $this->load->library('upload', $config);
		                $this->upload->initialize($config);            
		                if (!$this->upload->do_upload('uploadFile')) {
		                    $error = array('error' => $this->upload->display_errors());
		                } else {
		                    $data = array('upload_data' => $this->upload->data());
		                }
		                if(empty($error)){
		                  if (!empty($data['upload_data']['file_name'])) {
		                    $import_xls_file = $data['upload_data']['file_name'];
		                } else {
		                    $import_xls_file = 0;
		                }
		                $inputFileName = $path . $import_xls_file;
		                 
		                try {
		                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		                    $objPHPExcel = $objReader->load($inputFileName);
		                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
		                    $flag = true;
		                    $i=0;
		                    foreach ($allDataInSheet as $value) {
		                      if($flag){
		                        $flag =false;
		                        continue;
		                      }
		                      $inserdata[$i]['tcode'] 		= $value['A'];
		                      $inserdata[$i]['cycle'] 		= $value['B'];
		                      $inserdata[$i]['dept'] 		= $value['C'];
		                      $inserdata[$i]['site'] 		= $value['D'];
		                      $inserdata[$i]['schemeid'] 	= $value['E'];
		                      $i++;
		                    }               
		                    $result = $this->Import->importData($inserdata);   
		                    if($result){
		                      echo "Imported successfully";
		                    }else{
		                      echo "ERROR !";
		                    }             
		      
		              } catch (Exception $e) {
		                   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
		                            . '": ' .$e->getMessage());
		                }
		              }else{
		                  echo $error['error'];
		                }
		                 
		                 
		        }
		        redirect('importDistro');
		    }

		    public function batchUpdate(){
		    	if(!$this->session->logged_in)
				{
			  		redirect('auth/login');
			  	}

			  	///batch updating sitetester
			  	if ($this->input->post('submit')) {
		                 
		                $path = 'assets/uploads/';
		                require_once APPPATH . "/third_party/PHPExcel.php";
		                $config['upload_path'] = $path;
		                $config['allowed_types'] = 'xlsx|xls|csv';
		                $config['remove_spaces'] = TRUE;
		                $this->load->library('upload', $config);
		                $this->upload->initialize($config);            
		                if (!$this->upload->do_upload('uploadFile')) {
		                    $error = array('error' => $this->upload->display_errors());
		                } else {
		                    $data = array('upload_data' => $this->upload->data());
		                }
		                if(empty($error)){
		                  if (!empty($data['upload_data']['file_name'])) {
		                    $import_xls_file = $data['upload_data']['file_name'];
		                } else {
		                    $import_xls_file = 0;
		                }
		                $inputFileName = $path . $import_xls_file;
		                 
		                try {
		                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		                    $objPHPExcel = $objReader->load($inputFileName);
		                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
		                    $flag = true;
		                    $i=0;
		                    foreach ($allDataInSheet as $value) {
		                      if($flag){
		                        $flag =false;
		                        continue;
		                      }
		                      $updatedata[$i]['old_sitecode'] 		= $value['A'];
		                      $updatedata[$i]['new_sitecode'] 		= $value['B'];
		                      $updatedata[$i]['testercode'] 		= $value['C'];
		                      $updatedata[$i]['dept'] 				= $value['D'];
		                      $updatedata[$i]['status'] 			= $value['E'];
		                      $i++;
		                    }               
		                    $result = $this->Import->updateBatch($updatedata);   
		                    if($result){
		                      echo "Imported successfully";
		                    }else{
		                      echo "ERROR !";
		                    }             
		      
		              } catch (Exception $e) {
		                   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
		                            . '": ' .$e->getMessage());
		                }
		              }else{
		                  echo $error['error'];
		                }
		                 
		                 
		        }
		    }

		public function dtsDataentry(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['tester']=$this->Model_tester->getTester();
		  	$data['facility'] = $this->Model_facility->getFacility();
		  	$data['department']= $this->Model_department->getDepartment();
		  	$data['hivtests']=$this->Model_testname->getHivTests();
		  	$data['activeqtr']=$this->Model_cycle->getCycle();
		  	$data['testresult']=$this->Model_testresult->getHivSyphTestResult();
		  	$data['reasons']=$this->Model_notestingreason->getReason();
		  	$data['cadre']=$this->Model_title->getTitle();
		  	$data['entries']	= $this->Model_hivdtssamples->showEntries();


		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('entry/dts',$data);
			//$this->load->view('templates/footer');
		}

		public function dtsResultApproval($sampleid){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//echo $id;
		  	$t['sample']			= $this->Model_hivdtssamples->getSampleDetail($sampleid);
		  	$t['hivtestkit']		= $this->Model_hivdtssamples->getHivSampleTestkit($sampleid);
		  	$t['hivexpectedresult']	= $this->Model_hivdtssamples->getHivExpectedResult($sampleid);
		  	$t['testerInfor']		= $this->Model_hivdtssamples->getTesterDetailBySampleid($sampleid);
		  	$t['dtsresult']			= $this->Model_hivresult->getDtsResultBySample($sampleid);
		  	$t['syphiliskit']		= $this->Model_syphsample->getSyphilisTestkit($sampleid);
		  	$t['syphresult']		= $this->Model_syphsample->getSyphilisResult($sampleid);
		  	$t['resultcomment']		= $this->Model_hivresult->getResultComment($sampleid);
		  	$t['syphexpectedresult']= $this->Model_syphsample->getSyphExpectedResult($sampleid);
		  	$t['commentcategory']	= $this->Model_commentcategory->getHIVDTSCommentCategory();


		  	$this->load->view('entry/dtsApprove',$t);
		  	//$this->load->view('templates/footer');
		}

		public function approveDtsForm(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//print_r($_POST); exit;

		  	$hivscore=$this->input->post('hivscore');
		  	$hivstatus=$this->input->post('hivstatus');
		  	$syphscore = $this->input->post('sypscore');
		  	$syphstatus = $this->input->post('sypstatus');
		  	$sampleid=$this->input->post('sampleid');

		  	if($this->input->post('append_kit_info')=='On'){
		  		$syphkit=$this->input->post('trans_kitname');
		  		$syphlot=$this->input->post('trans_lot');
		  		$syphexp=$this->input->post('trans_expdate');

		  		//update the syphilis table
		  		$updateSyphdata=$this->Model_syphsample->updateSyphSampleWithKitInfo($sampleid,$syphkit,$syphlot,$syphexp);
		  		//echo $updateSyphdata; exit;
		  	}

		  	$schemid=1;
		  	$syphschemid=2;

		  		//print_r($_POST);
		  		//exit;
		  	
		  	if($this->input->post('hivcomments'))
		  	{ 

			  	$comment=array();
			  	for($j=0;$j<count($this->input->post('hivcomments'));$j++)
			  	{
			  		if($this->input->post('hivcomments')[$j] )
			  		{
				  		$res=array(
					  			'sampleid'	=>$this->input->post('sampleid'),
					  			'schemeid'	=>$schemid,
					  			'commentid'	=>$this->input->post('hivcomments')[$j]
					  		);

					  	array_push($comment,$res);
				  	}
			  	}

			  	//check if the the comments that ungrade are in
			  	$ungrading_comment=array_column($comment, 'commentid');
			  	if (in_array(2,$ungrading_comment)){
			  		$hivscore='N/A';
			  		$hivstatus='Un-Graded';
			  	}
			  	elseif (in_array(3,$ungrading_comment)){
			  		$hivscore='N/A';
			  		$hivstatus='Un-Graded';
			  	}
			  	elseif (in_array(6,$ungrading_comment)){
			  		$hivscore='N/A';
			  		$hivstatus='Un-Graded';
			  	}
			  	elseif (in_array(9,$ungrading_comment)){
			  		$hivscore='N/A';
			  		$hivstatus='Un-Graded';
			  	}
			  	elseif (in_array(10,$ungrading_comment)){
			  		$hivscore='N/A';
			  		$hivstatus='Un-Graded';
			  	}
			  	elseif (in_array(15,$ungrading_comment)){
			  		$hivscore='N/A';
			  		$hivstatus='Un-Graded';
			  	}
			  	elseif (in_array(16,$ungrading_comment)){
			  		$hivscore='N/A';
			  		$hivstatus='Un-Graded';
			  	}
			  	elseif(in_array(5,$ungrading_comment)){
			  		if(!in_array(7,$ungrading_comment)){
			  			if(!in_array(8,$ungrading_comment)){
			  				$hivscore='N/A';
			  				$hivstatus='Un-Graded';
			  			}
			  		}
			  	}

			  	//update the hivdtssamples table
			  	$update=$this->Model_hivdtssamples->approveHivDtsRecord($sampleid,$_SESSION['id'],$hivscore,$hivstatus);
			  	
			  	//insert into othercomments the comments
			  	$com_insert=$this->Model_othercomments->insertComment($comment);
			  
			}
			 else //no comments just approve
			{ 
			  	$update=$this->Model_hivdtssamples->approveHivDtsRecord($sampleid,$_SESSION['id'],$hivscore,$hivstatus);
			}

			  	//work on Syphilis
			if($this->input->post('syphcomments'))
			{
			  	$sycomment=array();
				for($j=0;$j<count($this->input->post('syphcomments'));$j++)
			  	{
			  		if($this->input->post('syphcomments')[$j] )
			  		{
				  		$res=array(
					  			'sampleid'	=>$this->input->post('sampleid'),
					  			'schemeid'	=>$syphschemid,
					  			'commentid'	=>$this->input->post('syphcomments')[$j]
					  		);

					  	array_push($sycomment,$res);
				  	}
			  	}

				 //check if the the comments that ungrade are in
			  	$ungrading_sycomment=array_column($sycomment, 'commentid');
			  	if (in_array(2,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	elseif (in_array(3,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	elseif (in_array(5,$ungrading_sycomment) && (!in_array(7, $ungrading_sycomment) || !in_array(8,$ungrading_sycomment))){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	elseif (in_array(6,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	elseif (in_array(9,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	
			  	elseif (in_array(15,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}
			  	elseif (in_array(16,$ungrading_sycomment)){
			  		$syphscore='N/A';
			  		$syphstatus='Un-Graded';
			  	}

			  	///override comment 5 by 8 and or 7

			  	$sypupdate=$this->Model_syphsample->approveSyphilisRecord($sampleid,$_SESSION['id'],$syphscore,$syphstatus);
			  	

			 
			  	$com_insert=$this->Model_othercomments->insertComment($sycomment);
			}
			else 
			{
			  	$sypupdate=$this->Model_syphsample->approveSyphilisRecord($sampleid,$_SESSION['id'],$syphscore,$syphstatus);
			}
			redirect('hivdtssamples');
		}
		public function updateDtsRecord(){
			$sampleid=$this->input->post('sampleid');

			//hivdtssample array
				$sample=array(
				'sampleid'			=>$this->input->post('sampleid'),
		  		'testercode'		=>$this->input->post('testercode'), 
		  		'site'				=>$this->input->post('sitecode'), 
		  		'cycleid'			=>$this->input->post('batchnum'), 
		  		'dept'				=>$this->input->post('department'),
		  		'dod'				=>$this->input->post('dod'), 
		  		'dsr'				=>$this->input->post('dsr'), 
		  		'rxBy'				=>$this->input->post('rxby'), 
		  		'dtsr'				=>$this->input->post('dtsr'), 
		  		'dtst'				=>$this->input->post('dtst'), 
		  		'sqty'				=>$this->input->post('sqty'), 
		  		'DateRxAtUVRI'		=>$this->input->post('daterxatuvri'), 
		  		'testerdate'		=>$this->input->post('testingDate'), 
		  		'supervdate'		=>$this->input->post('testingDate'), 
		  		'supervisorname'	=>$this->input->post('supervisor'), 
		  		'title'				=>$this->input->post('supervCadre'), 
		  		'tel'				=>$this->input->post('supervcontact'), 
		  		'formserial'		=>$this->input->post('form_serial'), 
		  		'acted_on_by'		=>$_SESSION['id']
		  	);

			//syphsamples data array
			$syphysample=array(
				'sampleid'			=>$this->input->post('sampleid'),
		  		'testercode'        =>$this->input->post('testercode'), 
		  		'site'				=>$this->input->post('sitecode'), 
		  		'cycleid'			=>$this->input->post('batchnum'), 
		  		'dept'				=>$this->input->post('department'), 
		  		'dod'				=>$this->input->post('dod'), 
		  		'dsr'				=>$this->input->post('dsr'), 
		  		'rxBy'				=>$this->input->post('rxby'), 
		  		'dtsr'				=>$this->input->post('dtsr'), 
		  		'dtst'				=>$this->input->post('dtst'), 
		  		'sqty'				=>$this->input->post('sqty'), 
		  		'DateRxAtUVRI'		=>$this->input->post('daterxatuvri'), 
		  		'testerdate'		=>$this->input->post('testingDate'), 		  		
		  		'Supervisor'		=>$this->input->post('supervisor'), 
		  		'kitName'			=>$this->input->post('syphscreening'), 
		  		'LotNo'				=>$this->input->post('syphscreeninglot'), 
		  		'expiryDate'		=>$this->input->post('syphscreeningexpdate'), 
		  		'formSerial'		=>$this->input->post('form_serial')
		  	);

			//hivkit info
			$screeningkit=array(
		  			'sampleid'		=>$sampleid, 
		  			'testcatid'		=>$this->input->post('hivscrcatid'), 
		  			'testname'		=>$this->input->post('hivscreening'), 
		  			'lotno'			=>$this->input->post('hivscreeninglot'), 
		  			'expdt'			=>$this->input->post('hivscreeningexpdate'),
		  			'acted_on_by'		=>$_SESSION['id']
		  		);

			$confKit=array(
		  			'sampleid'		=>$sampleid, 
		  			'testcatid'		=>$this->input->post('hivconfcatid'), 
		  			'testname'		=>$this->input->post('hivconfirmatory'), 
		  			'lotno'			=>$this->input->post('hivconfirmatorylot'), 
		  			'expdt'			=>$this->input->post('hivconfirmatoryexpdate'),
		  			'acted_on_by'	=>$_SESSION['id']
		  		);
			$tbKit=array(
		  			'sampleid'		=>$sampleid, 
		  			'testcatid'		=>$this->input->post('hivtbcatid'), 
		  			'testname'		=>$this->input->post('hivtiebreaker'), 
		  			'lotno'			=>$this->input->post('hivtiebreakerlot'), 
		  			'expdt'			=>$this->input->post('hivtiebreakerexppdate'),
		  			'acted_on_by'		=>$_SESSION['id']
		  		);
			////////////////////////////////////////////////

			//Syph Results
			$syphfr=4;
			$sp1res=array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p1spanid'), 
		  			'testcatid'		=>$this->input->post('p1frcatid'),  
		  			'result'		=>$this->input->post('syphpanel1fr')	
		  		);

			$sp2res=array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p2spanid'), 
		  			'testcatid'		=>$this->input->post('p2frcatid'), 
		  			'result'		=>$this->input->post('syphpanel2fr')	
		  		);
			$sp3res=array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p3spanid'), 
		  			'testcatid'		=>$this->input->post('p3frcatid'), 
		  			'result'		=>$this->input->post('syphpanel3fr')	
		  		);
			$sp4res=array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p4spanid'), 
		  			'testcatid'		=>$this->input->post('p4frcatid'), 
		  			'result'		=>$this->input->post('syphpanel4fr')	
		  		);

			//print_r($sp3res);exit;

			//echo $this->Model_syphsample->checkresultLines($sp3res['sampleid'],$sp3res['panelid'],$sp3res['testcatid']); exit;
		  	//////////////////////////////////////////////////////////////////////

		  	//HIV results 
		  	///panel 1
		  	$hp1scr_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p1spanid'),
		  			'testcatid'		=>$this->input->post('p1scrcatid'),
		  			'result'		=>$this->input->post('hivpanel1scr')
		  		);
		  	$p1conf_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p1spanid'),
		  			'testcatid'		=>$this->input->post('p1confcatid'),
		  			'result'		=>$this->input->post('hivpanel1conf')
		  		);

		  	$p1tb_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p1spanid'),
		  			'testcatid'		=>$this->input->post('p1tbcatid'),
		  			'result'		=>$this->input->post('hivpanel1tb')
		  		);
		  	$p1fr_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p1spanid'),
		  			'testcatid'		=>$this->input->post('p1frcatid'),
		  			'result'		=>$this->input->post('hivpanel1fr')
		  		);

		  	////Panel 2
		  	$p2scr_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p2spanid'),
		  			'testcatid'		=>$this->input->post('p2scrcatid'),
		  			'result'		=>$this->input->post('hivpanel2scr')
		  		);

		  	$p2conf_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p2spanid'),
		  			'testcatid'		=>$this->input->post('p2confcatid'),
		  			'result'		=>$this->input->post('hivpanel2conf')
		  		);

	

		  	

		  	$p2tb_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p2spanid'),
		  			'testcatid'		=>$this->input->post('p2tbcatid'),
		  			'result'		=>$this->input->post('hivpanel2tb')
		  		);



		  	$p2fr_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p2spanid'),
		  			'testcatid'		=>$this->input->post('p2frcatid'),
		  			'result'		=>$this->input->post('hivpanel2fr')
		  		);

		  	////Panel 3
		  	$p3scr_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p3spanid'),
		  			'testcatid'		=>$this->input->post('p3scrcatid'),
		  			'result'		=>$this->input->post('hivpanel3scr')
		  		);

		  	$p3conf_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p3spanid'),
		  			'testcatid'		=>$this->input->post('p3confcatid'),
		  			'result'		=>$this->input->post('hivpanel3conf')
		  		);

		  	$p3tb_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p3spanid'),
		  			'testcatid'		=>$this->input->post('p3tbcatid'),
		  			'result'		=>$this->input->post('hivpanel3tb')
		  		);
		  	$p3fr_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p3spanid'),
		  			'testcatid'		=>$this->input->post('p3frcatid'),
		  			'result'		=>$this->input->post('hivpanel3fr')
		  		);

		  	////Panel 4
		  	$p4scr_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'),
		  			'testcatid'		=>$this->input->post('p4scrcatid'),
		  			'result'		=>$this->input->post('hivpanel4scr')
		  		);

		  	$p4conf_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'),
		  			'testcatid'		=>$this->input->post('p4confcatid'),
		  			'result'		=>$this->input->post('hivpanel4conf')
		  		);

		  	$p4tb_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'),
		  			'testcatid'		=>$this->input->post('p4tbcatid'),
		  			'result'		=>$this->input->post('hivpanel4tb')
		  		);

		  	$p4fr_res=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'),
		  			'testcatid'		=>$this->input->post('p4frcatid'),
		  			'result'		=>$this->input->post('hivpanel4fr')
		  		);

			///////////////////////////////////////////////////////////////

			//panel comments
			$p1com=array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p1spanid'), 
		  			'comment'		=>$this->input->post('panel1_comment')
		  		);

			$p2com=array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p2spanid'), 
		  			'comment'		=>$this->input->post('panel2_comment')
		  		);

			$p3com=array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p3spanid'), 
		  			'comment'		=>$this->input->post('panel3_comment')
		  		);

			$p4com=array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'), 
		  			'comment'		=>$this->input->post('panel4_comment')
		  		);

			//print_r($p4fr_res);
		  	
		  	//process no testing reasons 

		  	//update the different tables

		  	// echo  $p3syph_upd=$this->Model_syphsample->UpdateSyphResult($sp3res);
		  	// exit();

		  		//hivsamples
			  // echo '<pre>';
			  // print_r($_POST); exit();

				//print_r($sample);
			 $samp_upd=$this->Model_hivsample->updateSamples($sample);

				//hivtestkit
			 $hiv_kit_upd=$this->Model_sampletestkit->UpdateKit($screeningkit,$confKit,$tbKit);

				//hivresults
			 $p1scr_upd=$this->Model_hivresult->UpdateHIVResult($hp1scr_res);
			 $p1con_upd=$this->Model_hivresult->UpdateHIVResult($p1conf_res);
			 $p1tbr_upd=$this->Model_hivresult->UpdateHIVResult($p1tb_res);
			 $p1fr_upd=$this->Model_hivresult->UpdateHIVResult($p1fr_res);

			 $p2scr_upd=$this->Model_hivresult->UpdateHIVResult($p2scr_res);
			 $p2con_upd=$this->Model_hivresult->UpdateHIVResult($p2conf_res);
			 $p2tbr_upd=$this->Model_hivresult->UpdateHIVResult($p2tb_res);
			 $p2fr_upd=$this->Model_hivresult->UpdateHIVResult($p2fr_res);

			 $p3scr_upd=$this->Model_hivresult->UpdateHIVResult($p3scr_res);
			 $p3con_upd=$this->Model_hivresult->UpdateHIVResult($p3conf_res);
			 $p3tbr_upd=$this->Model_hivresult->UpdateHIVResult($p3tb_res);
			 $p3fr_upd=$this->Model_hivresult->UpdateHIVResult($p3fr_res);

			 $p4scr_upd=$this->Model_hivresult->UpdateHIVResult($p4scr_res);
			 $p4con_upd=$this->Model_hivresult->UpdateHIVResult($p4conf_res);
			 $p4tbr_upd=$this->Model_hivresult->UpdateHIVResult($p4tb_res);
			 $p4fr_upd=$this->Model_hivresult->UpdateHIVResult($p4fr_res);

				//hiv not tested

				//syphilis samples
			 
			 $syphsamp_upd=$this->Model_syphsample->updateSamples($syphysample);

				//syphilis result
			 $p1syph_upd=$this->Model_syphsample->UpdateSyphResult($sp1res);
			 $p2syph_upd=$this->Model_syphsample->UpdateSyphResult($sp2res);
			 $p3syph_upd=$this->Model_syphsample->UpdateSyphResult($sp3res);
			 $p4syph_upd=$this->Model_syphsample->UpdateSyphResult($sp4res);

			 redirect('hiv_second_entry');

		}
		public function addDtsRecord(){	
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$sampleid = uniqid()."-".$_SESSION['id'];
		  	if(!empty($this->input->post('hivnottested'))){
		  		//print_r($this->input->post('hivnottested'));
		  		$cx=array();
		  		for($a=0;$a<count($this->input->post('hivnottested'));$a++){
		  			$yx=array(
			  			'sampleid'=>$sampleid,
			  			'schemeid'=>1,
			  			'notestingreasonid'=>$this->input->post('hivnottested')[$a]
			  		);

			  		array_push($cx,$yx);
		  			//
		  			$panelnotesting=$this->Model_syphsample->savePanelNotTested($cx);

		  		}
		  	}
		  	

		 // echo '<pre>';print_r($_POST);echo '</pre>'; exit();
		  	$biomarkers=$this->input->post('biomakers');


		  	
		  	$syphfr=4;

		  	$sample=array(
		  		'sampleid'			=>$sampleid, 
		  		'testercode'		=>$this->input->post('testercode'), 
		  		'site'				=>$this->input->post('sitecode'), 
		  		'cycleid'			=>$this->input->post('batchnum'), 
		  		'dept'				=>$this->input->post('department'),
		  		'dod'				=>$this->input->post('dod'), 
		  		'dsr'				=>$this->input->post('dsr'), 
		  		'rxBy'				=>$this->input->post('rxby'), 
		  		'dtsr'				=>$this->input->post('dtsr'), 
		  		'dtst'				=>$this->input->post('dtst'), 
		  		'sqty'				=>$this->input->post('sqty'), 
		  		'DateRxAtUVRI'		=>$this->input->post('daterxatuvri'), 
		  		'testerdate'		=>$this->input->post('testingDate'), 
		  		'supervdate'		=>$this->input->post('testingDate'), 
		  		'supervisorname'	=>$this->input->post('supervisor'), 
		  		'title'				=>$this->input->post('supervCadre'), 
		  		'tel'				=>$this->input->post('supervcontact'), 
		  		'formserial'		=>$this->input->post('form_serial'), 
		  		'enteredby'			=>$_SESSION['id']
		  	);

		  	$syphysample=array(
		  		'sampleid' 			=>$sampleid,  
		  		'testercode'        =>$this->input->post('testercode'), 
		  		'site'				=>$this->input->post('sitecode'), 
		  		'cycleid'			=>$this->input->post('batchnum'), 
		  		'dept'				=>$this->input->post('department'), 
		  		'dod'				=>$this->input->post('dod'), 
		  		'dsr'				=>$this->input->post('dsr'), 
		  		'rxBy'				=>$this->input->post('rxby'), 
		  		'dtsr'				=>$this->input->post('dtsr'), 
		  		'dtst'				=>$this->input->post('dtst'), 
		  		'sqty'				=>$this->input->post('sqty'), 
		  		'DateRxAtUVRI'		=>$this->input->post('daterxatuvri'), 
		  		'testerdate'		=>$this->input->post('testingDate'), 		  		
		  		'Supervisor'		=>$this->input->post('supervisor'), 
		  		'kitName'			=>$this->input->post('syphscreening'), 
		  		'LotNo'				=>$this->input->post('syphscreeninglot'), 
		  		'expiryDate'		=>$this->input->post('syphscreeningexpdate'), 
		  		'enteredby'			=>$_SESSION['id'],
		  		'formSerial'		=>$this->input->post('form_serial')
		  	);

		  	$testkit=array(
		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'testcatid'		=>$this->input->post('hivscrcatid'), 
		  			'testname'		=>$this->input->post('hivscreening'), 
		  			'lotno'			=>$this->input->post('hivscreeninglot'), 
		  			'expdt'			=>$this->input->post('hivscreeningexpdate')
		  		),
		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'testcatid'		=>$this->input->post('hivconfcatid'), 
		  			'testname'		=>$this->input->post('hivconfirmatory'), 
		  			'lotno'			=>$this->input->post('hivconfirmatorylot'), 
		  			'expdt'			=>$this->input->post('hivconfirmatoryexpdate')
		  		),
		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'testcatid'		=>$this->input->post('hivtbcatid'), 
		  			'testname'		=>$this->input->post('hivtiebreaker'), 
		  			'lotno'			=>$this->input->post('hivtiebreakerlot'), 
		  			'expdt'			=>$this->input->post('hivtiebreakerexppdate')
		  		)

		  	);
		  	

		  	//Syph Results
		  	$syphresult = array(
		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p1spanid'), 
		  			'testcatid'		=>$syphfr, //always final result
		  			'result'		=>$this->input->post('syphpanel1fr')	
		  		),

		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p2spanid'), 
		  			'testcatid'		=>$syphfr, //always final result
		  			'result'		=>$this->input->post('syphpanel2fr')	
		  		),

		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p3spanid'), 
		  			'testcatid'		=>$syphfr, //always final result
		  			'result'		=>$this->input->post('syphpanel3fr')	
		  		),
		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p4spanid'), 
		  			'testcatid'		=>$syphfr, //always final result
		  			'result'		=>$this->input->post('syphpanel4fr')	
		  		)
		  	);

		  	

		  	//HIV results 
		  	$hivresults=array(
		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p1spanid'),
		  			'testcatid'		=>$this->input->post('p1scrcatid'),
		  			'result'		=>$this->input->post('hivpanel1scr')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p1spanid'),
		  			'testcatid'		=>$this->input->post('p1confcatid'),
		  			'result'		=>$this->input->post('hivpanel1conf')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p1spanid'),
		  			'testcatid'		=>$this->input->post('p1tbcatid'),
		  			'result'		=>$this->input->post('hivpanel1tb')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p1spanid'),
		  			'testcatid'		=>$this->input->post('p1frcatid'),
		  			'result'		=>$this->input->post('hivpanel1fr')
		  		),

		  		////Panel 2
		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p2spanid'),
		  			'testcatid'		=>$this->input->post('p2scrcatid'),
		  			'result'		=>$this->input->post('hivpanel2scr')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p2spanid'),
		  			'testcatid'		=>$this->input->post('p2confcatid'),
		  			'result'		=>$this->input->post('hivpanel2conf')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p2spanid'),
		  			'testcatid'		=>$this->input->post('p2tbcatid'),
		  			'result'		=>$this->input->post('hivpanel2tb')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p2spanid'),
		  			'testcatid'		=>$this->input->post('p2frcatid'),
		  			'result'		=>$this->input->post('hivpanel2fr')
		  		),

		  		////Panel 3
		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p3spanid'),
		  			'testcatid'		=>$this->input->post('p3scrcatid'),
		  			'result'		=>$this->input->post('hivpanel3scr')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p3spanid'),
		  			'testcatid'		=>$this->input->post('p3confcatid'),
		  			'result'		=>$this->input->post('hivpanel3conf')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p3spanid'),
		  			'testcatid'		=>$this->input->post('p3tbcatid'),
		  			'result'		=>$this->input->post('hivpanel3tb')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p3spanid'),
		  			'testcatid'		=>$this->input->post('p3frcatid'),
		  			'result'		=>$this->input->post('hivpanel3fr')
		  		),

		  		////Panel 4
		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'),
		  			'testcatid'		=>$this->input->post('p4scrcatid'),
		  			'result'		=>$this->input->post('hivpanel4scr')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'),
		  			'testcatid'		=>$this->input->post('p4confcatid'),
		  			'result'		=>$this->input->post('hivpanel4conf')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'),
		  			'testcatid'		=>$this->input->post('p4tbcatid'),
		  			'result'		=>$this->input->post('hivpanel4tb')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'),
		  			'testcatid'		=>$this->input->post('p4frcatid'),
		  			'result'		=>$this->input->post('hivpanel4fr')
		  		)
		  	);

		  	//panel comments
		  	$panelcomment=array(
		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p1spanid'), 
		  			'comment'		=>$this->input->post('panel1_comment')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p2spanid'), 
		  			'comment'		=>$this->input->post('panel2_comment')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid, 
		  			'panelid'		=>$this->input->post('p3spanid'), 
		  			'comment'		=>$this->input->post('panel3_comment')
		  		),

		  		array(
		  			'sampleid'		=>$sampleid,
		  			'panelid'		=>$this->input->post('p4spanid'), 
		  			'comment'		=>$this->input->post('panel4_comment')
		  		),
		  	);

		  	///get no test reasons and save them
		  	// if(!empty($this->input->post('hivnottested'))){
		  	// 	$x=array();
		  	// 	for($i=0;$i<count($this->input->post('hivnottested'));$i++){
			//   		$yx=array(
			//   			'sampleid'=>$sampleid,
			//   			'reasonid'=>$this->input->post('hivnottested')[$i]
			//   		);

			//   		array_push($x,$yx);
			//   	}
			//   	//save the record
			//   	$hivnotesting=$this->Model_hivdtssamples->saveDtsNoTesting($x);
		  	// }

		  	///get no test reasons and save them
		  	if($this->input->post('syphnottested')!=''){
		  		$x=array();
		  		for($i=0;$i<count($this->input->post('syphnottested'));$i++){
			  		$yx=array(
			  			'sampleid'=>$sampleid,
			  			'schemeid'=>2,
			  			'notestingreasonid'=>$this->input->post('syphnottested')[$i]
			  		);

			  		array_push($x,$yx);
		  			//
			  	}
		  			$panelnotesting=$this->Model_syphsample->savePanelNotTested($x);
		  	}
			//determine what to save based on biomarkers
		  	if($this->input->post('biomakers')=='hiv'){ //hiv only submision
		  		//submit hiv sample, result and comments
		  		$saveHiv=$this->Model_hivsample->saveSample($sample);

		  		if($saveHiv){
		  			//add testkit
		  			$testkit=$this->Model_sampletestkit->saveSampleKit($testkit);

		  			//add result
		  			$result=$this->Model_hivresult->saveResult($hivresults);

		  			//add panel comment
		  			$comment=$this->Model_panelcomment->saveComment($panelcomment);
		  		}
		  	}

		  	elseif($this->input->post('biomakers')=='hivsyph'){ // hiv and syphilis
		  		//submit hiv/syphylis sample, result and comments
		  		//hiv
		  		$saveHiv=$this->Model_hivsample->saveSample($sample);

		  		if($saveHiv){
		  			//add testkit
		  			$testkit=$this->Model_sampletestkit->saveSampleKit($testkit);

		  			//add result
		  			$result=$this->Model_hivresult->saveResult($hivresults);

		  			//add panel comment
		  			$comment=$this->Model_panelcomment->saveComment($panelcomment);
		  		}

		  		$saveSyph=$this->Model_syphsample->saveSample($syphysample);

		  		if($saveSyph){
		  			//add result
		  			$syphres=$this->Model_syphresult->saveResult($syphresult);

		  		}
		  	}

		  	elseif($this->input->post('hivsyph')=='syph'){ //syphilis only
		  		//submit syphilis sample, result and comments
		  		$saveSyph=$this->Model_syphsample->saveSample($syphysample);

		  		if($saveSyph){
		  			//add result
		  			$syphres=$this->Model_syphresult->saveResult($syphresult);

		  			//add comment(s)
		  			$comment=$this->Model_panelcomment->saveComment($panelcomment);

		  		}
		  	}
		  	else {
		  		//show error no selected bio markers
		  		echo '<P class="label-warning"> Please Choose Bio-markers to Save the data. Record not saved please try again </p>';
		  	}

		  	

		  	redirect ('addHivSyph');
		}

		public function proposedTester(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']		="Proposed Tester";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('tester/proposed_tester',$data);
		}

		public function editTester($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']		="Edit Tester";
		  	$data['tester'] 	= $this->Model_tester->getTester($id);
		  	$data['cadre']		= $this->Model_title->getTitle();
		  	$data['facility']	= $this->Model_facility->getFacility();
		  	$data['dept']		= $this->Model_department->getDepartment();
		  	$data['opencode']	= $this->Model_tester->getOpencode();
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('tester/edit',$data);
		}
		public function getTesterDetail($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	 $data = $this->Model_tester->getTesterDetail($id);
		   echo json_encode($data);
			// if(!$this->session->logged_in)
			// {
		  	// 	redirect('auth/login');
		  	// }
		}

		public function RecencyDispatch(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="All Approved Results";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('dispatch/recency',$data);
		}

		public function fetchRecDispatch(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_hivdtssamples->getRecSampleToDispatch();

		  	foreach($data as $key=>$value){
		  		//checkboxes
		  		$checks ='<input type="checkbox" name="samples[]" value="\''.$value['sampleid'].'\'" class="pchk">';
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('printrecSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
		  		
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$checks,
		  			$value['description'],
		  			$value['testercode'],
		  			$value['Quater'],
		  			$value['hub'],
		  			$value['Sitename'],
		  			$value['DistrictName'],
		  			$value['division'],
		  			$value['location'],
		  			$value['dod'],
		  			$value['dtst'],
		  			$value['DateRxAtUVRI'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}
		public function resultDispatch(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="All Approved Results";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('dispatch/index',$data);
		}


		public function fetchDispatch(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_hivdtssamples->getSampleToDispatch();

		  	foreach($data as $key=>$value){
		  		//checkboxes
		  		$checks ='<input type="checkbox" name="samples[]" value="\''.$value['sampleid'].'\'" class="pchk">';
		  		//buttons determined by user role
		  		$buttons='';
		  		if($_SESSION['id']==19){
		  		$buttons.='<a href="'.base_url('printdtsSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
		  		}
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$checks,
		  			$value['description'],
		  			$value['testercode'],
		  			$value['Quater'],
		  			$value['hub'],
		  			$value['Sitename'],
		  			$value['DistrictName'],
		  			$value['division'],
		  			$value['location'],
		  			$value['dod'],
		  			$value['dtst'],
		  			$value['DateRxAtUVRI'],
		  			$value['formserial'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function reDispatch(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="All Approved Results";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('dispatch/redispatch',$data);
		}

		public function fetchReDispatch(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_hivdtssamples->getSampleToReDispatch();

		  	foreach($data as $key=>$value){
		  		//checkboxes
		  		$checks ='<input type="checkbox" name="samples[]" value="\''.$value['sampleid'].'\'" class="pchk">';
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('printdtsSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
		  		
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$checks,
		  			$value['description'],
		  			$value['testercode'],
		  			$value['Quater'],
		  			$value['hub'],
		  			$value['Sitename'],
		  			$value['DistrictName'],
		  			$value['division'],
		  			$value['location'],
		  			$value['dod'],
		  			$value['dtst'],
		  			$value['DateRxAtUVRI'],
		  			$value['formserial'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function addCycleResult(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$data['cycle']			 = $this->Model_cycle->getCycle();
		  	$data['sec_testresults'] = $this->Model_testresult->getHivSyphTestResult_scr_section();
		  	$data['fr_testresults'] = $this->Model_testresult->getHivSyphTestResult_fr_section();
		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

		  	$this->load->view('cycle/cycleresults',$data);
		}

		public function saveHIVSypExpectedResults(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$sql="INSERT INTO panelresults(cycleid,schemeid,panelid,categoryid,result) values";
		  	$count_panel = count($this->input->post('panel'));
		  	$cycle 		=$this->input->post('cyclename');
		  	$hivscheme 	=$this->input->post('scr_sch')[0];
		  	$sypscheme  = $this->input->post('sfr_sch')[0];
		  	
		  	for($i=0; $i<$count_panel; $i++){
		  		if($this->input->post('scr')[$i]!='' ){
		  			
		  			//	$sql.="(".$cycle.",".$hivscheme.",".$this->input->post('panel')[$i].",1,".$this->input->post('scr')[$i].")";
		  				
		  			$result=array(
			  		'cycleid' 			=>$cycle,  
			  		'schemeid'        	=>$hivscheme, 
			  		'panelid'			=>$this->input->post('panel')[$i], 
			  		'categoryid'		=>1, 
			  		'result'			=>$this->input->post('scr')[$i]
			  	);
		  		$insert=$this->Model_cycle->addLineResult($result);
		  		}

		  		if($this->input->post('conf')[$i]!='' ){
		  			//$sql.=",(".$cycle.",".$hivscheme.",".$this->input->post('panel')[$i].",2,".$this->input->post('conf')[$i].")";

		  			$result=array(
			  		'cycleid' 			=>$cycle,  
			  		'schemeid'        	=>$hivscheme, 
			  		'panelid'			=>$this->input->post('panel')[$i], 
			  		'categoryid'		=>2, 
			  		'result'			=>$this->input->post('conf')[$i]
			  	);
		  		$insert=$this->Model_cycle->addLineResult($result);
		  		}

		  		if($this->input->post('tb')[$i]!='' ){
		  			//$sql.=",(".$cycle.",".$hivscheme.",".$this->input->post('panel')[$i].",3,".$this->input->post('tb')[$i].")";
		  			$result=array(
			  		'cycleid' 			=>$cycle,  
			  		'schemeid'        	=>$hivscheme, 
			  		'panelid'			=>$this->input->post('panel')[$i], 
			  		'categoryid'		=>3, 
			  		'result'			=>$this->input->post('tb')[$i]
			  	);
		  		$insert=$this->Model_cycle->addLineResult($result);
		  		}

		  		if($this->input->post('hivfr')[$i]!='' ){
		  			//$sql.=",(".$cycle.",".$hivscheme.",".$this->input->post('panel')[$i].",4,".$this->input->post('hivfr')[$i].")";

		  			$result=array(
			  		'cycleid' 			=>$cycle,  
			  		'schemeid'        	=>$hivscheme, 
			  		'panelid'			=>$this->input->post('panel')[$i], 
			  		'categoryid'		=>4, 
			  		'result'			=>$this->input->post('hivfr')[$i]
			  	);
		  		$insert=$this->Model_cycle->addLineResult($result);
		  		}

		  		if($this->input->post('sypfr')[$i]!='' ){
		  			//$sql.=",(".$cycle.",".$sypscheme.",".$this->input->post('panel')[$i].",4,".$this->input->post('sypfr')[$i].");";

		  			$result=array(
			  		'cycleid' 			=>$cycle,  
			  		'schemeid'        	=>$sypscheme, 
			  		'panelid'			=>$this->input->post('panel')[$i], 
			  		'categoryid'		=>4, 
			  		'result'			=>$this->input->post('sypfr')[$i]
			  	);
		  		$insert=$this->Model_cycle->addLineResult($result);
		  		}

		  	}
		  		// $insert=$this->Model_cycle->addLineResult($sql);
		  		// if($insert){
		  			redirect('manageCycle');
		  		// }
		  		// else{
		  		// 	echo 'There was an error Adding Cycle Results';
		  		// }

		}
		public function getTestResults_sec1(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$products = $this->Model_testresult->getHivSyphTestResult_scr_section();
				echo json_encode($products);	
		}

		public function getTestResult(){
			$products=$this->Model_testresult->testResult();
			echo json_encode($products);
		}

		public function printdtsSample($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//get sample results based on id

		  	$data['sampledetail']		=	$this->Model_hivdtssamples->getSampleDetail($id);
		  	$data['teskitinfo']			=	$this->Model_hivdtssamples->getHivSampleTestkit($id);
		  	$data['hivothercomments'] 	= 	$this->Model_hivdtssamples->getHivOtherComments($id);
		  	$data['hivresults']			=	$this->Model_hivresult->getCompareResultBySampleId($id);
		  	$data['syphresult']			=	$this->Model_syphresult->getComparedSyphResult($id);
		  	$data['syphkits']			=	$this->Model_syphsample->getSyphilisTestkit($id);
		  	$data['approver']			= 	$this->Model_hivdtssamples->getApproverBySampleId($id);
		  	$data['hivexpectedresult']	=	$this->Model_hivdtssamples->getHivExpectedResult($id);
		  	$data['syphexpectedresult']	=	$this->Model_syphsample->getSyphExpectedResult($id);
		  	$data['syphcomments']		= 	$this->Model_commentcategory->getCommentsBySchemeSampleid($id);
		  	
		  	//mark the sample is printed
		  	$data['isMarkedPrinted']	=	$this->Model_hivdtssamples->markSamplePrinted($id);
		  	$this->load->view('reports/hivdtsreport',$data);
		}

		public function reviewdtsSample($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//get sample results based on id

		  	$data['sampledetail']		=	$this->Model_hivdtssamples->getSampleDetail($id);
		  	$data['teskitinfo']			=	$this->Model_hivdtssamples->getHivSampleTestkit($id);
		  	$data['hivothercomments'] 	= 	$this->Model_hivdtssamples->getHivOtherComments($id);
		  	$data['hivresults']			=	$this->Model_hivresult->getCompareResultBySampleId($id);
		  	$data['syphresult']			=	$this->Model_syphresult->getComparedSyphResult($id);
		  	$data['syphkits']			=	$this->Model_syphsample->getSyphilisTestkit($id);
		  	$data['approver']			= 	$this->Model_hivdtssamples->getApproverBySampleId($id);
		  	$data['hivexpectedresult']	=	$this->Model_hivdtssamples->getHivExpectedResult($id);
		  	$data['syphexpectedresult']	=	$this->Model_syphsample->getSyphExpectedResult($id);
		  	$data['syphcomments']		= 	$this->Model_commentcategory->getCommentsBySchemeSampleid($id);
		  	
		  	//mark the sample is printed
		  	$data['isMarkedPrinted']	=	$this->Model_hivdtssamples->markSamplePrinted($id);
		  	$this->load->view('reports/hivdtsreportreview',$data);
		}
		public function printRecSample($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['sampleInfo']		=	$this->Model_recencysample->getPrintSampleInfo($id);
		  	$data['perform']		= 	$this->Model_recencysample->getSampleResult($id);
		  	$data['sampleRes'] 		= 	$this->Model_recencysample->getResultBySampleId($id);
		  	$data['samplecomments']	= 	$this->Model_recencysample->getRecencySampleComments($id);
		  	$data['expected_res']	=	$this->Model_recencysample->getExpectedFinalResSampleid($id);

		  	$this->load->view('recency/report',$data);

		}
		public function listResults(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}
			$data['title']	="All Approved Results";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			//$this->load->view('results/index',$data);
			$this->load->view('results/results_with_comments',$data);
		}


		public function getdtsResults(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}
			$result = array('data'=>array());
			$data = $this->Model_hivresult->getApprovedResults();
			foreach($data as $key=>$value){
				//checkboxes
				$checks = '<input type="checkbox" name="samples[]" value="\''.$value['sampleid'].'\'" class="pchk">';
				//buttons determined by user role
				if($value['quarter']!=1 && $_SESSION['id']==19){
					$buttons= '<a href="'.base_url('printdtsSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
				}
				elseif ($value['quarter']==1){
					$buttons= '<a href="'.base_url('printdtsSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
				}
				else {
					$buttons= '<a href="'.base_url('viewdtsEntry/'.$value['sampleid']).'" class="btn btn-primary btn-sm" style="margin-right:3px;"><i class="fa fa-info" style="padding-right:2px;"></i></a>
		  			<a href ="'.base_url('loadPdfReport/'.$value['sampleid']).'" class="btn btn-warning btn-sm" style="margin-right:3px;" target="_blank"><i class="fa fa-file-pdf-o" style="padding-right:2px;" ></i></a>';
				}
		  		
		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$checks,
		  			$value['quarter'],
		  			$value['testercode'],
		  			$value['TesterName'],
		  			$value['hub'],
		  			$value['Sitename'],
		  			$value['departmentname'],
		  			$value['DistrictName'],
		  			$value['division'],
		  			$value['location'],
		  			$value['dod'],
		  			$value['dtst'],
		  			$value['DateRxAtUVRI'],
		  			$value['hub'],
		  			$value['outcome'],
		  			$buttons
		  		);
			}
			echo json_encode($result);
		}

		public function listsyphResults(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}
			$data['title']	="All Approved Results";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			//$this->load->view('results/index',$data);
			$this->load->view('results/sypresults_with_comments',$data);
		}

		public function fetchResultsWithComments(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}
			$result = array('data'=>array());
			$data = $this->Model_hivresult->getResultsWithComments();

			foreach($data as $key=>$value){
				//checkboxes
				//$checks = '<input type="checkbox" name="samples[]" value="\''.$value['sampleid'].'\'" class="pchk">';
				//buttons determined by user role
				// if($value['quarter']!=1 && $_SESSION['id']==19){
				// 	$buttons= '<a href="'.base_url('printdtsSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
				// }
				// elseif ($value['quarter']==1){
				// 	$buttons= '<a href="'.base_url('printdtsSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
				// }
				// else {
				 	$buttons= '<a href="'.base_url('viewDtsSample/'.$value['sampleid']).'" class="btn btn-primary btn-sm" style="margin-right:3px;"><i class="fa fa-info" style="padding-right:2px;"></i></a>';
		  		// 	<a href ="'.base_url('loadPdfReport/'.$value['sampleid']).'" class="btn btn-warning btn-sm" style="margin-right:3px;" target="_blank"><i class="fa fa-file-pdf-o" style="padding-right:2px;" ></i></a>';
				// }
		  		
		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			//$checks,
		  			$value['testercode'],
		  			$value['TesterName'],
		  			$value['cadre'],
		  			$value['site'],
		  			$value['Sitename'],
		  			$value['departmentname'],
		  			$value['LevelName'],
		  			$value['owner'],
		  			$value['DistrictName'],
		  			$value['RegionName'],
		  			$value['cycle'],
		  			$value['testDate'],
		  			$value['DateRxAtUVRI'],
		  			$value['score'],
		  			$value['status'],
		  			$value['comments'],
		  			$value['formserial'],
		  			$value['hub'],
		  			$buttons
		  		);
			}
			echo json_encode($result);
		}

		public function fetchsypResultsWithComments(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}
			$result = array('data'=>array());
			$data = $this->Model_syphresult->getsypResultsWithComments();

			foreach($data as $key=>$value){
				//checkboxes
				//$checks = '<input type="checkbox" name="samples[]" value="\''.$value['sampleid'].'\'" class="pchk">';
				//buttons determined by user role
				// if($value['quarter']!=1 && $_SESSION['id']==19){
				// 	$buttons= '<a href="'.base_url('printdtsSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
				// }
				// elseif ($value['quarter']==1){
				// 	$buttons= '<a href="'.base_url('printdtsSample/'.$value['sampleid']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print</a>';
				// }
				// else {
				 	$buttons= '<a href="'.base_url('viewDtsSample/'.$value['sampleid']).'" class="btn btn-primary btn-sm" style="margin-right:3px;"><i class="fa fa-info" style="padding-right:2px;"></i></a>';
		  		// 	<a href ="'.base_url('loadPdfReport/'.$value['sampleid']).'" class="btn btn-warning btn-sm" style="margin-right:3px;" target="_blank"><i class="fa fa-file-pdf-o" style="padding-right:2px;" ></i></a>';
				// }
		  		
		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			//$checks,
		  			$value['testercode'],
		  			$value['TesterName'],
		  			$value['cadre'],
		  			$value['sitecode'],
		  			$value['sitename'],
		  			$value['departmentname'],
		  			$value['LevelName'],
		  			$value['owner'],
		  			$value['DistrictName'],
		  			$value['RegionName'],
		  			$value['quarter'],
		  			$value['testdate'],
		  			$value['DateRxAtUVRI'],
		  			$value['score'],
		  			$value['Result'],
		  			$value['description'],
		  			$value['formserial'],
		  			$value['deliverymode'],
		  			$buttons
		  		);
			}
			echo json_encode($result);
		}
		public function loadPdfReport($sampleid){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	//test pdf output
		  	//$data['sampleid']=$sampleid;
		  	$data['sampledetail']	=$this->Model_hivdtssamples->getSampleDetail($sampleid);
		  	$data['hivresults']		=$this->Model_hivresult->getCompareResultBySampleId($sampleid);

		  	// $html=$this->load->view('reports/hivsyphPdfReport',$data,true);
		  	// $mpdf = new \Mpdf\Mpdf();
		  	// $mpdf->writeHTML($html);
		  	// $mpdf->Output();

		  	//$data['sampledetail']=$this->Model_hivdtssamples->gpdfetSampleDetail($sampleid);

		  	//$this->load->view('reports/fpdf.php');
		  	$this->load->view('reports/hivsyphPdfReport',$data);
		  	//echo anchor_popup('http://localhost/coag_printing/pdfreport.php', 'Google', $data);
		  	

		}

		public function UpdateDashboard(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$update=$this->Model_MealWarehouse->insertPreliminaryData();
		  	//print_r($update);

		  	// foreach($update as $u):
		  	// 	echo $u['cycle'].'<br>';
		  	// endforeach;
		}

		public function getDistributions(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_distributions->listDistribution();

		  	foreach($data as $key=>$value){
		  		// //checkboxes
		  		// $checks ='<input type="checkbox" name="samples[]" value="\''.$value['sampleid'].'\'" class="pchk">';
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('viewDistroDetail/'.$value['cycle'].'/'.$value['sitecode']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>View Detail</a>';
		  		
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['Name'],
		  			$value['Sitename'],
		  			$value['DistrictName'],
		  			$value['DeliveryMode'],
		  			$value['panels'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}
		public function listDistributions(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
			$data['title']	="All Approved Results";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('distributions/index',$data);
		}

		public function listDistroDetail($cycle,$site){
			$data['cycle']=$cycle;
			$data['site']	=$site;
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('distributions/distrodetail',$data);
		}
		public function fetchDistributionByFacilityCycle($cycle,$site){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$result = array('data'=>array());
			$data=$this->Model_distributions->distributionDetailByFacilityCycle($cycle,$site);
			//print_r($data); exit;
			foreach($data as $key=>$value){
		  		// //checkboxes
		  		// $checks ='<input type="checkbox" name="samples[]" value="\''.$value['sampleid'].'\'" class="pchk">';
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('printReports/'.$value['tcode']).'" class="btn btn-default btn-sm"><i class="fa fa-list"></i>Print Reports</a>';
		  		
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['tcode'],
		  			$value['TesterName'],
		  			$value['title'],
		  			$value['CategoryName'],
		  			$value['departmentname'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);

		}
		/////////////////////////////////////////////////////////////////////////
		//////////////									/////////////////////////
		//////////////          RECENCY METHODS			/////////////////////////
		//////////////									/////////////////////////
		/////////////////////////////////////////////////////////////////////////
		
		public function recencyDataentry(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['tester']=$this->Model_tester->getTester();
		  	$data['facility'] = $this->Model_facility->getFacility();
		  	$data['department']= $this->Model_department->getDepartment();
		  	$data['hivtests']=$this->Model_testname->getRecencyTests();
		  	$data['activeqtr']=$this->Model_cycle->getRecencyCycle();
		  	$data['testresult']=$this->Model_testresult->getRecencyTestResult();
		  	$data['reasons']=$this->Model_notestingreason->getReason();
		  	$data['cadre']=$this->Model_title->getTitle();

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('entry/recency',$data);
			//$this->load->view('templates/footer');
		}
		public function addRecencyRecord(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	// echo '<pre>';
			// 	print_r($_POST);
			// echo '</pre>';
			// exit();
		  	$x=array();
		  

		  	
		  	///create sample for recency
		  	$sampleid = uniqid()."-".$_SESSION['id'];
		  	$sample=array(
		  		'sampleid'			=>$sampleid, 
		  		'testercode'		=>$this->input->post('testercode'), 
		  		'site'				=>$this->input->post('sitecode'), 
		  		'cycleid'			=>$this->input->post('batchnum'), 
		  		'dept'				=>$this->input->post('department'),
		  		'dod'				=>$this->input->post('dod'), 
		  		'dsr'				=>$this->input->post('dsr'), 
		  		'rxBy'				=>$this->input->post('rxby'), 
		  		'dtsr'				=>$this->input->post('dtsr'), 
		  		'dtst'				=>$this->input->post('dtst'), 
		  		'sqty'				=>$this->input->post('sqty'), 
		  		'DateRxAtUVRI'		=>$this->input->post('daterxatuvri'), 
		  		'testerdate'		=>$this->input->post('testingDate'), 
		  		'supervdate'		=>$this->input->post('testingDate'), 
		  		'supervisorname'	=>$this->input->post('supervisor'), 
		  		'title'				=>$this->input->post('supervCadre'), 
		  		'kitid'				=>$this->input->post('recencykitname'),
		  		'lotnum'			=>$this->input->post('recencylotnumber'),
		  		'expirydate'		=>$this->input->post('recencykitexpdate'),
		  		'tel'				=>$this->input->post('supervcontact'), 
		  		'formserial'		=>$this->input->post('form_serial'), 
		  		'enteredby'			=>$_SESSION['id']
		  	);


		  	//save the record in the database
		  	$createSample=$this->Model_recencysample->saveRecencySample($sample);
		  	 if($createSample){
		  	 $result=array();
		  	 /////create a results array to be pushed into DB
		///panel 1
		  	 if($this->input->post('p1_clineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p1_panel'),
		  			'catid'		=>$this->input->post('p1_ctrline'),
		  			'result'	=>$this->input->post('p1_clineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p1_vlineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p1_panel'),
		  			'catid'		=>$this->input->post('p1_vline'),
		  			'result'	=>$this->input->post('p1_vlineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p1_ltlineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p1_panel'),
		  			'catid'		=>$this->input->post('p1_ltline'),
		  			'result'	=>$this->input->post('p1_ltlineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p1_frval')!=''){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p1_panel'),
		  			'catid'		=>$this->input->post('p1_frline'),
		  			'result'	=>$this->input->post('p1_frval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }
		//end panel 1

		//panel 2
		  	 if($this->input->post('p2_clineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p2_panel'),
		  			'catid'		=>$this->input->post('p2_ctrline'),
		  			'result'	=>$this->input->post('p2_clineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p2_vlineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p2_panel'),
		  			'catid'		=>$this->input->post('p2_vline'),
		  			'result'	=>$this->input->post('p2_vlineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p2_ltlineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p2_panel'),
		  			'catid'		=>$this->input->post('p2_ltline'),
		  			'result'	=>$this->input->post('p2_ltlineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p2_frval')!=''){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p2_panel'),
		  			'catid'		=>$this->input->post('p2_frline'),
		  			'result'	=>$this->input->post('p2_frval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }
		//end panel 2

		//panel 3
		  	 if($this->input->post('p3_clineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p3_panel'),
		  			'catid'		=>$this->input->post('p3_ctrline'),
		  			'result'	=>$this->input->post('p3_clineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p3_vlineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p3_panel'),
		  			'catid'		=>$this->input->post('p3_vline'),
		  			'result'	=>$this->input->post('p3_vlineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p3_ltlineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p3_panel'),
		  			'catid'		=>$this->input->post('p3_ltline'),
		  			'result'	=>$this->input->post('p3_ltlineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p3_frval')!=''){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p3_panel'),
		  			'catid'		=>$this->input->post('p3_frline'),
		  			'result'	=>$this->input->post('p3_frval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }
		// end panel 3
		// panel 4
		  	 if($this->input->post('p4_clineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p4_panel'),
		  			'catid'		=>$this->input->post('p4_ctrline'),
		  			'result'	=>$this->input->post('p4_clineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p4_vlineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p4_panel'),
		  			'catid'		=>$this->input->post('p4_vline'),
		  			'result'	=>$this->input->post('p4_vlineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p4_ltlineval')==1){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p4_panel'),
		  			'catid'		=>$this->input->post('p4_ltline'),
		  			'result'	=>$this->input->post('p4_ltlineval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }

		  	 if($this->input->post('p4_frval')!=''){
		  	 	$res =array(
		  	 		'sampleid'	=>$sampleid,
		  			'panelid'	=>$this->input->post('p4_panel'),
		  			'catid'		=>$this->input->post('p4_frline'),
		  			'result'	=>$this->input->post('p4_frval')
		  	 	);
		  	 		array_push($result,$res);
		  	 }
		// end panel 4

		  	//save the results -- use a loop to create a batch insert array
		/*
		  	for($j=0;$j<count($this->input->post('cline'));$j++){
		  		 if(isset($this->input->post('clineval')[$j]))
		  		 {
			  		$res=array(
				  			'sampleid'	=>$sampleid,
				  			'panelid'	=>$this->input->post('panel')[$j],
				  			'catid'		=>$this->input->post('cline')[$j],
				  			'result'	=>$this->input->post('clineval')[$j]
				  		);

				  	array_push($result,$res);
			  	}
		  	}
		  	for($j=0;$j<count($this->input->post('vline'));$j++){
		  		if(isset($this->input->post('vlineval')[$j]))
		  		{
			  		$res=array(
				  			'sampleid'=>$sampleid,
				  			'panelid'	=>$this->input->post('panel')[$j],
				  			'catid'		=>$this->input->post('vline')[$j],
				  			'result'	=>$this->input->post('vlineval')[$j]
				  		);

				  	array_push($result,$res);
			  	}
		  	}
		  	for($j=0;$j<count($this->input->post('ltline'));$j++){
		  		if(isset($this->input->post('ltlineval')[$j]))
		  		{
			  		$res=array(
				  			'sampleid'	=>$sampleid,
				  			'panelid'	=>$this->input->post('panel')[$j],
				  			'catid'		=>$this->input->post('ltline')[$j],
				  			'result'	=>$this->input->post('ltlineval')[$j]
				  		);

				  	array_push($result,$res);
			  	}
		  	}
		  	for($j=0;$j<count($this->input->post('fr'));$j++){
		  		if(isset($this->input->post('frval')[$j]))
		  		{
			  		$res=array(
				  			'sampleid'	=>$sampleid,
				  			'panelid'	=>$this->input->post('panel')[$j],
				  			'catid'		=>$this->input->post('fr')[$j],
				  			'result'	=>$this->input->post('frval')[$j]
				  		);

				  	array_push($result,$res);
			  	}
		  	}
		*/

		  	// print_r($result);
		  	// exit();
		  	///create result
		  	$createResult=$this->Model_recencysample->saveRecencyResult($result);

		  	///If there is no testing create a record for if
		  	if($this->input->post('hivnottested')!=''){
			  	for($i=0;$i<count($this->input->post('hivnottested'));$i++){
			  		$yx=array(
			  			'sampleid'=>$sampleid,
			  			'reasonid'=>$this->input->post('hivnottested')[$i]
			  		);

			  		array_push($x,$yx);
			  	}
			  	//save the record
			  	$notesting=$this->Model_recencysample->saveRecencyNoTesting($x);
			}
		  }

		  redirect('addRecency');
		}
		/////////////////////////////////////////////////////////////////////////
		///////////////									////////////($id);
		/////////////
		/////////////// 		CD4 Methods				/////////////////////////
		///////////////									/////////////////////////
		/////////////////////////////////////////////////////////////////////////

		public function cd4ControlResults(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cd4/controlresults');
			$this->load->view('templates/footer');
		}

		public function fetchCD4Distributions(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_cd4->getCD4Distributions();

		  	foreach($data as $key=>$value){
		  		//TODO
		  		//the edit, delete, veiw detail requires to ids (Sampleid and testid)
		  		$buttons= '<a href="'.base_url('cd4ControlResult/'.$value['sampleid'].'/'.$value['sampleid']).' class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		// $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['distributionid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['sampleid'], 
		  			$value['issuedate'],
		  			$value['closingdate'], 			
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function cd4Distributions(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cd4/distribution');
			$this->load->view('templates/footer');
		}


		public function cd4Sample(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cd4/samples');
			$this->load->view('templates/footer');
		}

		// public function fetchCD4Distributions(){
			// 	if(!$this->session->logged_in)
			// 	{
			//   		redirect('auth/login');
			//   	}

			//   	$result = array('data'=>array());
		  	// 	$data = $this->Model_cd4->getCD4Distributions();

			//   	foreach($data as $key=>$value){
			//   		//buttons determined by user role
			//   		$buttons= '<a href="'.base_url('cd4Distributiondetail/'.$value['distributionid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['distributionid'].') " data-toggle="modal" data-target="#editModal">
			// 		<i class="fa fa-pencil"></i></button>';
			//   		if($_SESSION['usercat']==1) {
			  			
			//   		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['distributionid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			//   		}
			  		

			//   		//preprare an array to return in ajax call
			//   		$result['data'][$key]= array(
			//   			$value['trialumber'], 
			//   			$value['issuedate'],
			//   			$value['closingdate'], 			
			//   			$buttons
			//   		);
			//   		}

		  	// 	echo json_encode($result);
		// }

		public function fetchCD4Samples(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_cd4->getCD4Samples();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('cd4testDetail/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['sampleid'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['sampleid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['sampleid'],
		  			$value['trialumber'], 
		  			$value['issuedate'],
		  			$value['closingdate'], 			
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}
		public function cd4Facility(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cd4/facility');
			$this->load->view('templates/footer');
		}
		public function fetchCD4Facility(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_cd4->getFacility();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('cd4testDetail/'.$value['cd4id']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['cd4id'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['cd4id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['sitecode'],
		  			$value['Sitename'], 
		  			$value['LevelName'],
		  			$value['DistrictName'], 			
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}
		public function cd4testpanel(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cd4/tests');
			$this->load->view('templates/footer');
		}

		public function fetchcd4testpanel(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_cd4->getTests();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('cd4testDetail/'.$value['testid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['testid'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['testid'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['testname'],
		  			$value['category'], 			
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function cd4testmachine(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('cd4/machines');
			$this->load->view('templates/footer');
		}

		public function fetchCD4TestMachine(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_cd4->getMachines();

		  	foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('cd4MachineDetail/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a><button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].') " data-toggle="modal" data-target="#editModal">
				<i class="fa fa-pencil"></i></button>';
		  		if($_SESSION['usercat']==1) {
		  			
		  		 $buttons.='<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
		  		}
		  		

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['description'],			
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);

		}
		/////////////////////////////////////////////////////////////////////////
		//////////////////////							/////////////////////////
		////////////////////// Drug Resistance Methods 	/////////////////////////
		//////////////////////							/////////////////////////
		/////////////////////////////////////////////////////////////////////////

		public function getDrPendingResults(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="Samples with No Results";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('drnp/unresulted',$data);
		}

		public function fetchUnresultedSamples(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_DR_NP->samplePendingResult();

	  		foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('drSampleDetail/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>View</a>';

		  		$status =($value['days']<14)?'<span class="label label-success">Ok</span>':'<span class="label label-warning">Late</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['eligibleSampleid'],
		  			$value['patientArtNumber'],
		  			$value['sex'],
		  			$value['birthdate'],
		  			$value['facilityName'],
		  			$value['dateCollected'],
		  			$value['drLabSampleId'],
		  			$value['endpointrxdate'],
		  			$status,
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function getDRjsonResult(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['error']	="";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('drnp/getDrJsonResult',$data);
		}

		public function do_Upload(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$config['upload_path']		='./uploads/';
		  	$config['allowed_types']	='*';
		  	$config['overwrite']		=false;
		  	$config['detect_mime']		=true;

		  	$this->load->library('upload',$config);

		  	if(! $this->upload->do_Upload('fileToUpload')){
		  		$error = array('error' => $this->upload->display_errors());
		  		$this->load->view('templates/header');
		  		$this->load->view('templates/header_menu');
		  		$this->load->view('templates/side_menubar');
		  		$this->load->view('drnp/getDrJsonResult',$error);
		  	}
		  	else {
		  		$data = array('upload_data' => $this->upload->data());
		  		$this->load->view('templates/header');
		  		$this->load->view('templates/header_menu');
		  		$this->load->view('templates/side_menubar');
		  		$this->load->view('drnp/upload_success',$data);
		  	}			
		}

		public function createDrRecord(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$feedback=array();
		  	//get constants
		  	$sampleid = $_POST['sample_id'];
		  	$atype 		= $_POST['vtype'];
		  	//add sample base data
		  	$sbdata=array(
		  		'trandate'	=>$this->input->post('trandate'), 
		  		'sample_id'	=>$this->input->post('sample_id'), 
		  		'vtype'		=>$this->input->post('vtype')
		  	);
		  	$sbinsert=$this->Model_DR_NP->addSampleBaseData($sbdata);

		  	$feedback['samplebase']=$sbinsert;

			$mutations=array();
			for($r=0;$r<count($this->input->post('gene'));$r++){
				$mut['eligibleSampleid']=$sampleid;
				$mut['atype']=$atype;
				$mut['category']=$this->input->post('gene')[$r];
				$mut['mutation_text']=$this->input->post('muttype')[$r];
				$mut['mutation_string']=$this->input->post('mutstring')[$r];

				array_push($mutations,$mut);

			}

			$drugmutations=array();
			for($v=0;$v<count($this->input->post('drugcode'));$v++){
				$dc['sample_id']			=$sampleid;
				$dc['drugcode']				=$this->input->post('drugcode')[$v];
				$dc['drugname']				=$this->input->post('drugname')[$v];
				$dc['category']				=$this->input->post('category')[$v];
				$dc['score']				=$this->input->post('score')[$v];
				$dc['resistancelevel']		=$this->input->post('level')[$v];
				$dc['resistancetext']		=$this->input->post('restext')[$v];

				array_push($drugmutations,$dc);

			}

			$groupmutations=array();
			for($m=0;$m<count($this->input->post('gpmuttype'));$m++){
				$gp['sample_id']			=$sampleid;
				$gp['gene']					=$this->input->post('gpgene')[$m];
				$gp['mutationtype']			=$this->input->post('gpmuttype')[$m];
				$gp['mutation_string']		=$this->input->post('gpmutstr')[$m];

				array_push($groupmutations,$gp);
			}

			$comments=array();
			for($l=0;$l<count($this->input->post('cmgroup'));$l++){
				$cm['sample_id']		=$sampleid;
				$cm['category']			=$this->input->post('cmcategory')[$l];
				$cm['comment']			=$this->input->post('cmcomment')[$l];
				$cm['grp']				=$this->input->post('cmgroup')[$l];

				array_push($comments,$cm);
			}

		  //	$count_mutation		= count($this->input->post('gene'));
		  	//$count_drugcode 	= count($this->input->post('drugcode'));
		  	$count_upddrugcode 	= count($this->input->post('upddrugcode'));
		   //	$count_cmcategory 	= count($this->input->post('cmgroup'));
		   //	$count_gpmuttype 	= count($this->input->post('gpmuttype'));

	


		  	//add mutations if sample base insert was successful
		  	if($sbinsert){
		  		$bt_mut=$this->Model_DR_NP->addBatchMutations($mutations);
		  		$bt_drmuts=$this->Model_DR_NP->addBatchDrugMutations($drugmutations);
		  		$bt_grmuts =$this->Model_DR_NP->addBatchGroupMutations($groupmutations);
		  		$bt_comment=$this->Model_DR_NP->addBatchComment($comments);

		  		// for($i=0;$i<$count_mutation;$i++){
		  		// 	//process each row separately
		  		// 	$mutinsert=$this->Model_DR_NP->addMutationData($sampleid,$atype,$this->input->post('gene')[$i],$this->input->post('muttype')[$i],$this->input->post('mutstring')[$i]);
		  		// 	//save using model for mutations
		  		// 	$feedback['mutations'][$i] = $mutinsert;

		  		// }
		  		//$mutinsert=$this->Model_DR_NP->addMutationData($mutations);
		  		//drug mut
		  		// for($j=0;$j<$count_drugcode;$j++){
		  		// 	//save using model
		  		// 	//process each at a time
		  		// 	$druginsert=$this->Model_DR_NP->addDrugmutationData($sampleid,$this->input->post('drugcode')[$j],$this->input->post('drugname')[$j],$this->input->post('category')[$j],$this->input->post('score')[$j],$this->input->post('level')[$j],$this->input->post('restext')[$j]);

		  		// 	$feedback['drugmutations'][$j]=$druginsert;
		  		// }

		  		//get drugnames for updating 
		  		for($k=0;$k<$count_upddrugcode;$k++){
		  			///update data using model
		  			$upddrug=$this->Model_DR_NP->updateDrugnames($sampleid,$this->input->post('drugcode')[$k],$this->input->post('upddrugname')[$k]);
		  		}

		  		//comments
		  		// for($l=0;$l<count($count_cmcategory);$l++){
		  		// 	//save comments using model
		  		// 	$cominsert=$this->Model_DR_NP->addCommentsData($sampleid,$this->input->post('cmcategory')[$l],$this->input->post('cmcomment')[$l],$this->input->post('cmgroup')[$l]);
		  		// 	$feedback['comments'][$l]=$cominsert;
		  		// }
		  		

		  		//group mutations
		  		// for($m=0;$m<count($count_gpmuttype);$m++){
		  		// 	$gpmut=$this->Model_DR_NP->addGroupMutationData($sampleid,$this->input->post('gpgene')[$m],$this->input->post('gpmuttype')[$m],$this->input->post('gpmutstr')[$m]);
		  		// 	$feedback['mutgroup'][$m]=$gpmut;
		  		// }
		  		
		  	}

		  	redirect('hivdrdashboard');
		  	
		}

		public function getPendingDRUpload(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['error']	="";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('drnp/getPendingDrResult',$data);
			$this->load->view('templates/footer');
		}

		public function getSamplesForUnAmplified(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['error']	="";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('drnp/getUnamplifiedDrResult',$data);
			$this->load->view('templates/footer');
		}

		public function fetchDrUnAmplifiedUpload(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	////
		  	$result = array('data'=>array());
	  		$data = $this->Model_DR_NP->unamplifiedSamples();

	  		foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('drSendUnAmplified/'.$value['eligibleSampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Send Outcome </a>';

		  		$status =($value['days']<14)?'<span class="label label-success">Ok</span>':'<span class="label label-warning">Late</span>';

		  		//preprare an array to return in ajax call
		  			$result['data'][$key]= array(
		  			$value['eligibleSampleid'],
		  			$value['drLabSampleId'],
		  			//$value['vlsampleid'],
		  			$value['patientArtNumber'],
		  			$value['sex'],
		  			$value['birthdate'],
		  			$value['facilityName'],
		  			$status,
		  			$buttons		  			
		  		);
		  		}

	  		echo json_encode($result);
		}
		public function fetchUnUploadedResult(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	////
		  	$result = array('data'=>array());
	  		$data = $this->Model_DR_NP->resultsPendingUpload();

	  		foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('drSendResult/'.$value['eligibleSampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Send Result</a>';

		  		$status =($value['days']<14)?'<span class="label label-success">Ok</span>':'<span class="label label-warning">Late</span>';

		  		//preprare an array to return in ajax call
		  			$result['data'][$key]= array(
		  			$value['eligibleSampleid'],
		  			$value['drLabSampleId'],
		  			//$value['vlsampleid'],
		  			$value['patientArtNumber'],
		  			$value['sex'],
		  			$value['birthdate'],
		  			$value['facilityName'],
		  			$status,
		  			$buttons		  			
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function drUploadUnAmplified($sampleid){
			//prepare the array
			$pd=array();
			$out =array('lab'=>'UVRI');
			$out['data']=array();
			array_push($pd,$out);

			$data = array();
			$data['sampleProfile']=array();
			$data['polymorphism']=array();
			$data['resistance']['pi']=array();
			$data['resistance']['nrti']=array();
			$data['resistance']['nnrti']=array();
			$data['resistance']['insti']=array();

			$data['comments']['prComments']['piMajor']=array();
			$data['comments']['prComments']['Accessory']=array();
			$data['comments']['prComments']['Other']=array();

			$data['comments']['rtComments']['nrti']=array();
			$data['comments']['rtComments']['nnrti']=array();
			$data['comments']['rtComments']['Other']=array();

			$data['comments']['inComments']['Major']=array();
			$data['comments']['inComments']['Accessory']=array();
			$data['comments']['inComments']['Other']=array();


			//get sample profile

			$ro=$this->Model_DR_NP->getUnAmplifiedSampleProfile($sampleid);	
			
			$data['sampleProfile']['eligibleSampleId']=$ro['eligibleSampleId'];
			$data['sampleProfile']['testDate']=$ro['testDate'];
			$data['sampleProfile']['drLabSampleId']=$ro['drLabSampleId'];
			$data['sampleProfile']['releaseDate']=$ro['releaseDate'];
			$data['sampleProfile']['rtSubType']=$ro['rtSubType'];
			$data['sampleProfile']['amplified']=false;
		
			array_push($out['data'],$data);

			//prepare the array for pushing through

			$data = json_encode($out);

			array_push($out,$out['data']);
			  // echo '<pre>',json_encode($out),'</pre>';
			  // exit();


			$url='https://hivdr.cphluganda.org/api/postDrResults';
			$auth = base64_encode("uvri_lims:4B>{jaE54^_azqR[");

			$curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
               "Accept: application/json",
               "Authorization: Basic $auth",
               "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);
			//var_dump($resp);

			//echo count(json_encode($resp));
			//echo $resp[''];

			$r=json_encode($resp);
			$data = json_decode($resp, true);

			///go though the response and update thet database for result sent
			if(count($data['response']['result']['added'])>0){
				//sample result recieved mark it in the database here
				$res_sent=$this->Model_DR_NP->updateSampleRecieved($sampleid);
			}
			if(count($data['response']['result']['duplicate'])>0){
				//sample result is already recieved mark it in the database here
				$res_sent=$this->Model_DR_NP->updateSampleRecieved($sampleid);
			}
			if(count($data['response']['result']['failed'])>0){
				//sample result has a problem log it in the database
				$res_failed=$this->Model_DR_NP->createSampleError(addslashes($data['response']['result']['failed'][0]));
			}
			redirect('sendUnAmplified');
		}


		public function drUploadResult($sampleid){
			//echo $sampleid;
			//prepare the array
			$pd=array();
			$out =array('lab'=>'UVRI');
			$out['data']=array();
			array_push($pd,$out);
			
			// print_r($pd);
			// exit()

			//create an array to help in formating the data properly
			$data = array();
			$data['sampleProfile']=array();
			$data['polymorphism']=array();
			$data['resistance']['pi']=array();
			$data['resistance']['nrti']=array();
			$data['resistance']['nnrti']=array();
			$data['resistance']['insti']=array();

			$data['comments']['prComments']['piMajor']=array();
			$data['comments']['prComments']['Accessory']=array();
			$data['comments']['prComments']['Other']=array();

			$data['comments']['rtComments']['nrti']=array();
			$data['comments']['rtComments']['nnrti']=array();
			$data['comments']['rtComments']['Other']=array();

			$data['comments']['inComments']['Major']=array();
			$data['comments']['inComments']['Accessory']=array();
			$data['comments']['inComments']['Other']=array();

			//get sample profile

			$ro=$this->Model_DR_NP->getSampleProfile($sampleid);	
			
			$data['sampleProfile']['eligibleSampleId']=$ro['eligibleSampleId'];
			$data['sampleProfile']['testDate']=$ro['testDate'];
			$data['sampleProfile']['drLabSampleId']=$ro['drLabSampleId'];
			$data['sampleProfile']['releaseDate']=$ro['releaseDate'];
			$data['sampleProfile']['rtSubType']=$ro['rtSubType'];
			if($ro['amplified']==='true'){
				$data['sampleProfile']['amplified']=true;
			}

			// echo json_encode($data);
			// exit;
			// 	extract($ro);
			// 	$data['sampleProfile']=$ro;
				
			//get the polymorphism
			$po=$this->Model_DR_NP->getSamplePolymorphism($sampleid);
			extract($po);
			$data['polymorphism']=$po;

			//get drug resistance
			$dr=$this->Model_DR_NP->getSampleDr($sampleid);
			for($h=0;$h<count($dr);$h++){
				extract($dr[$h]);
				if($category=='PI'){
					
					$drug_item=array(
						'drugCode' 			=> $drugcode,
						'drugName'			=> $drugname,
						'resistanceLevel'	=> $resistancetext,
						'scoring'			=> $score
					);
					array_push($data['resistance']['pi'],$drug_item);
				}

				if($category=='NRTI'){
					
					$drug_item=array(
						'drugCode' 			=> $drugcode,
						'drugName'			=> $drugname,
						'resistanceLevel'	=> $resistancetext,
						'scoring'			=> $score
					);
					array_push($data['resistance']['nrti'],$drug_item);
				}

				if($category=='NNRTI'){
					
					$drug_item=array(
						'drugCode' 			=> $drugcode,
						'drugName'			=> $drugname,
						'resistanceLevel'	=> $resistancetext,
						'scoring'			=> $score
					);
					array_push($data['resistance']['nnrti'],$drug_item);
				}

				if($category=='INSTI'){
					
					$drug_item=array(
						'drugCode' 			=> $drugcode,
						'drugName'			=> $drugname,
						'resistanceLevel'	=> $resistancetext,
						'scoring'			=> $score
					);
					array_push($data['resistance']['insti'],$drug_item);
				}
			}


			//get comments
			$cm=$this->Model_DR_NP->getSammpleComment($sampleid);
			for($q=0;$q<count($cm);$q++){
				extract($cm[$q]);
				if($grp=='RT'){
					if($category=='NRTI'){

						$data['comments']['rtComments']['nrti'][]=$comment;
						//$comment_item=array(
						//'nrti'=>	$comment
						//);
						//array_push($data['comments']['rtComments']['nrti'],$comment_item);
					}
					if($category=='NNRTI'){
						$data['comments']['rtComments']['nnrti'][]=$comment;
						// $comment_item=array(
						// 	'nnrti'=>$comment
						// );
						// array_push($data['comments']['rtComments']['nnrti'],$comment_item);
					}

					if($category=='Other'){
						$data['comments']['rtComments']['Other'][]=$comment;
						// $comment_item=array(
						// 	'other'=>$comment
						// );
						// array_push($data['comments']['rtComments']['other'],$comment_item);
					}

				}

				if($grp=='PR'){
					if($category=='Major'){
						$data['comments']['prComments']['piMajor'][]=$comment;
						// $comment_item=array(
						// 	'piMajor'=>$comment
						// );
						// array_push($data['comments']['prComments']['piMajor'],$comment_item);
					}
					if($category=='Accessory'){
						$data['comments']['prComments']['Accessory'][]=$comment;
						// $comment_item=array(
						// 	'accessory'=>$comment
						// );
						// array_push($data['comments']['prComments']['Accessory'],$comment_item);
					}
					if($category=='Other'){
						$data['comments']['prComments']['Other'][]=$comment;
						// $comment_item=array(
						// 	'other'=>$comment
						// );
						// array_push($data['comments']['prComments']['other'],$comment_item);
					}
				}

				if($grp=='IN'){
					if($category=='Major'){
						$data['comments']['inComments']['piMajor'][]=$comment;
						// $comment_item=array(
						// 	'piMajor'=>$comment
						// );
						// array_push($data['comments']['inComments']['piMajor'],$comment_item);
					}
					if($category=='Accessory'){
						$data['comments']['inrComments']['Accessory'][]=$comment;
						// $comment_item=array(
						// 	'accessory'=>$comment
						// );
						// array_push($data['comments']['inrComments']['Accessory'],$comment_item);
					}
					if($category=='Other'){
						$data['comments']['inComments']['Other'][]=$comment;
						// $comment_item=array(
						// 	'other'=>$comment
						// );
						// array_push($data['comments']['inComments']['other'],$comment_item);
					}
				}
			}

			array_push($out['data'],$data);

			//prepare the array for pushing through

			$data = json_encode($out);

			//array_push($out,$out['data']);
			 // echo '<pre>',json_encode($out),'</pre>';
			 // exit();


			$url='https://hivdr.cphluganda.org/api/postDrResults';
			$auth = base64_encode("uvri_lims:4B>{jaE54^_azqR[");

			$curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
               "Accept: application/json",
               "Authorization: Basic $auth",
               "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);
		var_dump($resp);
		//exit;

			//echo count(json_encode($resp));
			//echo $resp[''];

			$r=json_encode($resp);
			$data = json_decode($resp, true);

			//echo $data;exit;
			///go though the response and update thet database for result sent
			if(count($data['response']['result']['added'])>0){
				//sample result recieved mark it in the database here
				$res_sent=$this->Model_DR_NP->updateSampleRecieved($sampleid);
			}
			if(count($data['response']['result']['duplicate'])>0){
				//sample result is already recieved mark it in the database here
				$res_sent=$this->Model_DR_NP->updateSampleRecieved($sampleid);
			}
			if(count($data['response']['result']['failed'])>0){
				//sample result has a problem log it in the database
				$res_failed=$this->Model_DR_NP->createSampleError(addslashes($data['response']['result']['failed'][0]));
			}
			redirect('getDrResultsToSend');
		}


///////////////////////////////////////////////////////////Methods for Reading APIS and endpoint transactions

		public function listNationalSamples(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="National Sample Requests";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('api/suspects',$data);
			$this->load->view('templates/footer');
		}

		public function fetchApiSample(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());

	  		$url ='https://apitest.cphluganda.org/suspects';


			// provide your username and password here
			$auth = base64_encode("uvri_lims:4B>{jaE54^_azqR[");

			// create HTTP context with basic auth
			$context = stream_context_create([
			    'http' => ['header' => "Authorization: Basic $auth"],
			    //enforce no verification for ssl
			    "ssl" => [
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ]
			]);

			// query for data
			$data = file_get_contents($url, false, $context);

			//convert data from json to array
			 $data =  json_decode($data,true);
			   //  echo '<pre>';
			   // print_r($data);
			   // echo '</pre>';

			   //exit();

	  		foreach($data as $key=>$value){
	  			
	  					  		//buttons determined by user role
	  					  		$buttons= '<form method="post" action="'.base_url('apisample').'" 
	  					  		<input type="hidden" value="'.$value['specimen_uuid'].'" name="uuid">
	  					  		<input type="hidden" value="'.$value['specimen_identifier'].'" name="specimen_no">
	  					  		<input type="hidden" value="'.$value['patient_surname'].'" name="surname">
	  					  		<input type="hidden" value="'.$value['patient_firstname'].'" name="fname">
	  					  		<input type="hidden" value="'.$value['sex'].'" name="gender">
	  					  		<input type="hidden" value="'.$value['age'].'" name="age">
	  					  		<input type="hidden" value="'.$value['nationality'].'" name="nationality">
	  					  		<input type="hidden" value="'.$value['disease'].'" name="disease_code">
	  					  		<input type="hidden" value="'.$value['type_of_collection_site'].'" name="type_of_collection_site">
	  					  		<input type="hidden" value="'.$value['name_of_collection_site'].'" name="name_of_collection_site">
	  					  		<input type="hidden" value="'.$value['specimen_uuid'].'" name="specimenuuid">
	  					  		<input type="hidden" value="'.$value['request_date'].'" name="request_date">
	  					  		<input type="hidden" value="'.$value['sample_type'].'" name="sample_type">
	  					  		<input type="hidden" value="'.$value['specimen_collection_date'].'" name="specimen_collection_date">
	  					  		<input type="hidden" value="'.$value['swabing_district'].'" name="swabing_district">
	  					  		<button type="submit" class="btn btn-success btn-sm vd" alt="'.$value['specimen_identifier'].'">Get</button></form>';

	  					  		//<a href="'.base_url('getCovidSample/'.$value['specimen_uuid']).'" class="btn btn-success btn-sm"><i class="fa fa-circle"></i>Get</a>';
	  							//$params='<form>';
	  					  		//$status =($value['days']<14)?'<span class="label label-success">Ok</span>':'<span class="label label-warning">Late</span>';
	  			
	  					  		//preprare an array to return in ajax call
	  					  		$result['data'][$key]= array(
	  					  			$value['patient_identifier'],
	  					  		
	  					  			$value['specimen_identifier'],
	  					  			$value['patient_surname'],
	  					  			$value['patient_firstname'],
	  					  			$value['sex'],
	  					  			$value['age'],
	  					  			$value['disease'],
	  					  			$value['who_disease_code'],
	  					  			$value['nationality'],
	  					  			$value['type_of_collection_site'],
	  					  			$value['name_of_collection_site'],
	  					  			$value['request_date'],
	  					  			$value['sample_type'],
	  					  			$value['specimen_collection_date'],
	  					  			$value['swabing_district'],
	  					  			$buttons
	  					  		);
	  					  		
	  					  	}

	  		echo json_encode($result);
		}

		public function SaveApiSample(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	// print_r($_POST); 
		  	// exit();
		  	//save data to db 
		  	$data = array(
			  			'specimenuuid' 						=> $this->input->post('specimenuuid'),
			  			'specimen_no'						=> $this->input->post('specimen_no'),
			  			'surname'							=> $this->input->post('surname'),
			  			'fname'								=> $this->input->post('fname'),
			  			'gender'							=> $this->input->post('gender'),
			  			'age'								=> $this->input->post('age'),

			  			//note I changed the disease_code to pick the disease for visual clarity -- 05-July 2023
			  			'disease_code'						=> $this->input->post('disease_code'),
			  			'nationality'						=> $this->input->post('nationality'),
			  			'type_of_sample_collection_point'	=> $this->input->post('type_of_collection_site'),
			  			'name_of_collection_point'			=> $this->input->post('name_of_collection_site'),
			  			'sample_type'						=> $this->input->post('sample_type'),
			  			'request_date'						=> $this->input->post('request_date'),
			  			'collection_date'					=> $this->input->post('specimen_collection_date'),
			  			'district'							=> $this->input->post('swabing_district')

			  		);

			  		$create = $this->Model_samples->createApiSample($data);
			  		if($create ==true){
			  			$response['success'] = true;
			  			$response['messages'] = 'Successfully Added';

			  			//and remove sample from pool of samples at CPHL
			  			$url='https://apitest.cphluganda.org/receive/samples';
						$auth = base64_encode("uvri_lims:4B>{jaE54^_azqR[");
						$dt['specimen_uuid']= $this->input->post('specimenuuid');

						$dt['lis_id']="eyJpdiI6Ijl3RlJzUEhGM1FcL2dsNWRqQUpxN2FRPT0iLCJ2YWx1ZSI6IkoyUUR2emJCVlpQYmRndFpFTzBoMmc9PSIsIm1hYyI6IjNhM2U5NGQwMDNiOGI5Yjc0ODQ1MjdkMTc5MzQ5YTk4NGY4YjA0OWZiNTMyOWI3OGNhNGM4MGJkM2Q5OGZiYjgifQ==";

						$dt['eac_lab_id']="eyJpdiI6InF2S0ZCTkh4WEdzK1RkZW5cL1NTNUxRPT0iLCJ2YWx1ZSI6Ijh4UFZUU1FIVnFDYVVGS2h1Vnk1dlE9PSIsIm1hYyI6Ijk0MzFhN2MxZjJkN2ZhZDI2Yzk4MmE0YjY3YzY1MGU0ZDQ0N2MwOTI1MGQ0ZTg5YTM3NjAxYjYwMTNiOTlhNDgifQ==";

						$dt['status']=true;

					$data = json_encode($dt);

				
							$curl = curl_init($url);
							            curl_setopt($curl, CURLOPT_URL, $url);
							            curl_setopt($curl, CURLOPT_POST, true);
							            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

							            $headers = array(
							               "Accept: application/json",
							               "Authorization: Basic $auth",
							               "Content-Type: application/json",
							            );
							            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
							/*
							            $data = <<<DATA
							            {
							                "accessionIdentifier":"NKS745"
							            }
							            DATA;
							*/
							            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

							            //for debug only!
							            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
							            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

							            $resp = curl_exec($curl);
							            curl_close($curl);
							//var_dump($resp);

							//echo count(json_encode($resp));
							//echo $resp[''];

							$r=json_encode($resp);
							$data = json_decode($resp, true);
							//print_r($data);
			  			//route to the apisample
			  			redirect('national_samples');
			  		}
			  		else {
			  			$response['success'] = false;
			  			$response['messages'] = 'Error in the Database while adding Sample';
			  		}
		}
		

		public function claimedSamples(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['error']	="";
			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('samples/showClaimed',$data);
		}

		public function fetchClaimed(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}	

		  	$result = array('data'=>array());
	  		$data = $this->Model_samples->getClaimedSamples();

	  
	  		foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('apiSampleDetail/'.$value['sampleid']).'" class="btn btn-success btn-sm"><i class="fa fa-list"></i>Process</a>';

		  		$status =($value['days']<14)?'<span class="label label-success">Ok</span>':'<span class="label label-warning">Late</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['sampleid'],
		  			$value['specimenuuid'],
		  			$value['specimen_no'],
		  			$value['surname'],
		  			$value['fname'],
		  			$value['gender'],
		  			$value['age'],
		  			$value['disease_code'],
		  			$value['nationality'],
		  			$value['name_of_collection_point'],
		  			$value['sample_type'],
		  			$value['request_date'],
		  			$value['collection_date'],
		  			$value['district'],
		  			$status,
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}


		public function processApiSample($id){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']	="National Sample Requests";
		  	$data['sampledetail']=$this->Model_samples->getSampleDetail($id);
		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('samples/process',$data);
			$this->load->view('templates/footer');
		}

		public function accession(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$sbdata=array(
		  		'sampleid'	=>$this->input->post('uuid'), 
		  		'labno'	=>$this->input->post('labno')
		  		
		  	);
		  	$sbinsert=$this->Model_samples->accessionSample($sbdata);

		  	if($sbinsert){
		  		redirect('claimed_samples');
		  	}
		  	
		  	else {
		  		echo 'Something wrong happened';
		  	}
		}

		public function getApiResultsNotSent(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}


		  	$data['title']	="National Sample Results";
		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('samples/listApiResults',$data);
			$this->load->view('templates/footer');
		}

		public function fetchApiPendingResult(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$result = array('data'=>array());
	  		$data = $this->Model_samples->getResultsPendingPushing();

	  
	  		foreach($data as $key=>$value){
		  		//buttons determined by user role
		  		$buttons= '<a href="'.base_url('sendApiResult/'.$value['specimenuuid']).'" class="btn btn-success btn-sm"><i class="fa fa-plane"></i>Send</a>';

		  		//$status =($value['days']<14)?'<span class="label label-success">Ok</span>':'<span class="label label-warning">Late</span>';

		  		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['labno'],
		  			$value['specimenuuid'],
		  			$value['name_of_collection_point'],
		  			$value['surname'],
		  			$value['gender'],
		  			$value['age'],
		  			
		  			$value['disease_code'],		  
		  			$value['outcome'],
		  			$buttons
		  		);
		  		}

	  		echo json_encode($result);
		}


		public function sendApiResult($id){

			$data=$this->Model_samples->getResultToSend($id);

			$url='https://apitest.cphluganda.org/sync/results';
  			$auth = base64_encode("uvri_lims:4B>{jaE54^_azqR[");

  			$dt = array(
				'token'=>'aYo423aVqXhKnG2QI6fcsPLyBmB0ONSLlOcWTkY8Jm9BEgA10y0AtiM'
			);

			$dt['result']=array();
			//get the uuid to use in updating sample_base
			$uuid=$data['specimenuuid'];

			$result=array(
				'specimen_uuid'=>$data['specimenuuid'],
				'lis_id'=>'eyJpdiI6Ijl3RlJzUEhGM1FcL2dsNWRqQUpxN2FRPT0iLCJ2YWx1ZSI6IkoyUUR2emJCVlpQYmRndFpFTzBoMmc9PSIsIm1hYyI6IjNhM2U5NGQwMDNiOGI5Yjc0ODQ1MjdkMTc5MzQ5YTk4NGY4YjA0OWZiNTMyOWI3OGNhNGM4MGJkM2Q5OGZiYjgifQ==',
				'eac_lab_id'=>'eyJpdiI6InF2S0ZCTkh4WEdzK1RkZW5cL1NTNUxRPT0iLCJ2YWx1ZSI6Ijh4UFZUU1FIVnFDYVVGS2h1Vnk1dlE9PSIsIm1hYyI6Ijk0MzFhN2MxZjJkN2ZhZDI2Yzk4MmE0YjY3YzY1MGU0ZDQ0N2MwOTI1MGQ0ZTg5YTM3NjAxYjYwMTNiOTlhNDgifQ==',
				'specimen_lab_id'=>$data['labno'],
				'ct_value'=>$data['ct_value'],
				'result'=>$data['outcome'],
				'test_date'=>$data['testdate'],
				'platform_range'=>$data['platform_range'],
				'testing_platform'=>$data['testing_platform'],
				'test_method'=>$data['test_method'],
				'tested_by'=>$data['testedby'],
				'uploaded_by'=> $_SESSION['fname'].' '.$_SESSION['lname'],
				'approved_by'=>$data['approvedby']
			);

				array_push($dt['result'], $result);


			   $data = json_encode($dt);

			   //push result
			   $curl = curl_init($url);
	            curl_setopt($curl, CURLOPT_URL, $url);
	            curl_setopt($curl, CURLOPT_POST, true);
	            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	            $headers = array(
	               "Accept: application/json",
	               "Authorization: Basic $auth",
	               "Content-Type: application/json",
	            );
	            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	/*
	            $data = <<<DATA
	            {
	                "accessionIdentifier":"NKS745"
	            }
	            DATA;
	*/
	            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

	            //for debug only!
	            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	            $resp = curl_exec($curl);
	            curl_close($curl);
	
				$r=json_encode($resp);
				$data = json_decode($resp, true);
				if($data=='Result succesfully received in RDS'){
					//update the database
					$dbupd = $this->Model_samples->updateApiSampleBaseResultSent($uuid);
				}

				//go back to the unsent results page
				redirect('getApiUnSentResult');
				//$vx=updateSample($id);
				//header('Location: view.php');


			
		}


		//////Site and tester evaluation

		public function testerEvaluation(){

			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}

		  	$data['title']="Tester Evaluation";

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('stc/testerevaluation',$data);
			//$this->load->view('templates/footer');
		}

		//method to release entries
		public function Release_Entries(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$this->Model_hivdtssamples->release_entry();
		  	redirect('dashboard');
		}




		/*
			reporting methods - Use the Datawarehouse
		*/

		public function reporting(){
			if(!$this->session->logged_in)
			{
		  		redirect('auth/login');
		  	}
		  	$this->load->model('Model_reporting');
		  	$data['title']="EQA Reporting";
		  	//$data['distro'] = $this->Model_reporting->getDistributionData('East Central','Jinja City','','Health Centre III');
		  	$data['regions']	= $this->Model_reporting->getDistinctRegions();
		  	$data['districts']	= $this->Model_reporting->getDistinctDistricts();
		  	$data['sites']		= $this->Model_reporting->getDistinctSites();
		  	$data['levels']		= $this->Model_reporting->getDistinctLevels();
		  	$data['cadres']		= $this->Model_reporting->getDistinctCadres();
		  	$data['cycles']		= $this->Model_reporting->getDistinctCycles();
		  	

		  	$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');

			$this->load->view('reports/index',$data);
		}

		public function DatabaseBackup(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}

			$data['title'] = "EQA Database Backup";

			$this->load->view('maintenance/backupdb');
		}

		public function listSnapshotData(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}

			$data['title'] ='EQA PT Data Snapshot';

			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');
			$this->load->view('warehouse/response_snapshot');
		}

		public function getHIVSnapshotData(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}

			$result = array('data'=>array());
	  		$data = $this->Model_snapshot->getSnapshotData();

	  
	  		foreach($data as $key=>$value){
		 		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['testercode'],
		  			$value['testername'],
		  			$value['testercontact'],
		  			$value['cadre'],
		  			$value['cadrecategory'],
		  			$value['sitecode'],
		  			
		  			$value['sitename'],		  
		  			$value['facilitylevel'],
		  			$value['facilityowner'],
		  			$value['departmentname'],
		  			$value['facilitydistrict'],
		  			$value['facilityregion'],
		  			$value['cycleid'],
		  			$value['cycleyear'],
		  			$value['cycledescription'],
		  			$value['cyclename'],
		  			$value['dod'],
		  			$value['dsr'],
		  			$value['rxby'],
		  			$value['dtsr'],
		  			$value['dtst'],
		  			$value['daterxatuvri'],
		  			$value['formserial'],
		  			$value['approvedby'],
		  			$value['approvaldate'],
		  			$value['score'],
		  			$value['status'],
		  			$value['supervisorname'],
		  			$value['delimode'],
		  			$value['comment']
		  		);
		  		}

	  		echo json_encode($result);
		}

		public function listHivResults_snapshot(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}

			$data['title'] ='EQA PT Results Snapshot';

			$this->load->view('templates/header');
			$this->load->view('templates/header_menu');
			$this->load->view('templates/side_menubar');
			$this->load->view('warehouse/hiv_result_snapshot');
		}
		
		public function getHIVResults_Sanpshot(){
			if(!$this->session->logged_in){
				redirect('auth/login');
			}

			$result = array('data'=>array());
	  		$data = $this->Model_snapshot->getHivResultSnapshotData();

	  
	  		foreach($data as $key=>$value){
		 		//preprare an array to return in ajax call
		  		$result['data'][$key]= array(
		  			$value['testercode'],
		  			$value['testername'],
		  			$value['testercontact'],
		  			$value['cadre'],
		  			$value['cadrecategory'],
		  			$value['sitecode'],
		  			
		  			$value['sitename'],		  
		  			$value['facilitylevel'],
		  			$value['facilityowner'],
		  			$value['departmentname'],
		  			$value['facilitydistrict'],
		  			$value['facilityregion'],
		  			$value['cycleid'],
		  			$value['cycleyear'],
		  			$value['cycledescription'],
		  			$value['cyclename'],
		  			$value['dod'],
		  			$value['dsr'],
		  			$value['rxby'],
		  			$value['dtsr'],
		  			$value['dtst'],
		  			$value['daterxatuvri'],
		  			$value['formserial'],
		  			$value['approvedby'],
		  			$value['approvaldate'],
		  			$value['score'],
		  			$value['status'],
		  			$value['supervisorname'],
		  			$value['delimode'],
		  			$value['panelid'],
		  			$value['Screening'], 
		  			$value['Confirmatory'], 
		  			$value['Tiebreaker'], 
		  			$value['Finalresult'],
		  			$value['comment']
		  		);
		  		}

	  		echo json_encode($result);
		}
}
