<?php
 class User extends CI_Controller
 {
 	public function index()
	{
		//$this->load->helper("html");
		$this->load->view('user/header');
		$this->load->view('user/index');
		$this->load->view('user/footer');
		//echo "Testing..";
	}

	public function validation()
	{
		//$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if($this->form_validation->run('validate_form'))
		{
			$post = $this->input->post();
			$post['Reg_Flag']='1';
			$this->load->model('User_Model');
			if($last_id = $this->User_Model->Register_Form($post))
			{
			  $this->session->set_userdata('id',$last_id);
              $array = array(
                'success'   => true,
		        'message' => '<div class="alert alert-success">Your Application Saved Successfully</div>',
              );
		   	 // return redirect('admin/Welcome');
			}
			else
			{
			   $array = array(
                'error'   => true,
		        'message' => '<div class="alert alert-danger">Technical issue, Please try again !</div>',
               );
		      
			}
		 

		}
		else
		{
		   $array = array(
		    'error'   => true,
		    'name' => form_error('name'),
		    'father' => form_error('father'),
		    'mother' => form_error('mother'),
		    'guardian' => form_error('guardian'),
		    'dob' => form_error('dob'),
		    'school' => form_error('school'),
		    'nationality' => form_error('nationality'),
		    'cast' => form_error('cast'),
		    'aadhar' => form_error('aadhar'),
		    'mobile1' => form_error('mobile1'),
		    'mobile2' => form_error('mobile2'),
		    'address' => form_error('address'),
		    'addmission' => form_error('addmission')


		   );
		}
	 echo json_encode($array);
	}


	public function print()
	{
      $id = $this->session->userdata('id');
      $this->load->model('User_Model');
	  $result = $this->User_Model->Fetch_Application_Details($id);
	  $this->load->view('user/header');
	  $this->load->view("user/print_application",['data'=>$result]);  
	  $this->load->view('user/footer');  
	}
	






// End Class

 }
  
?>