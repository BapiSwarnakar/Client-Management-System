<?php
class Student extends CI_Controller
{
	
	public function __construct()
	{
        parent::__construct();
        $this->logged_in();
	}
    
    private function logged_in()
    {
      if(! $this->session->userdata('admin_active'))
      {
      	redirect(base_url('admin'));
      }
    }

  public function add_student()
  {
     $page_title['title']="Add Student";
     $this->load->model('Student_Model');
     $page_title['course']= $this->Student_Model->All_Course();
     $page_title['Institute']= $this->Student_Model->All_Institute();
     $page_title['Fees']= $this->Student_Model->All_FeesType();
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/add_student');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function view_student()
  {
     $page_title['title']="View Student";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/view_student');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function display_student()
  {  
      //  Array
    // (
    //     [from_date] => 
    //     [to_date] => 
    //     [search_val] => 
    //     [status] => All
    //     [top] => 50
    // )
     
     $from_date = $this->input->post('from_date');
     $to_date = $this->input->post('to_date');
     $search_val = $this->input->post('search_val');
     $status = $this->input->post('status');
     $top = $this->input->post('top');
     $this->load->model('Student_Model');
     if($data = $this->Student_Model->All_Client($from_date,$to_date,$search_val,$status,$top))
     {
        $output =array();
        $i = 1;
         foreach ($data as $value) {  
           // $value['delete']='<a href="view_ncert_mcq_summeries.php?id='.$value['Sum_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
           $value['Sl_no']=$i;
           // if($value['admin_flag']=='1')
           // {
           //   $value['admin_flag']='<button type="button" data-id="'.$value['id'].'" class="btn btn-success btn-sm status_update" data-val="0">Activate</button>';
           // }
           // else
           // {
           //   $value['admin_flag']='<button type="button" data-id="'.$value['id'].'" class="btn btn-danger btn-sm status_update" data-val="1">Deactivate</button>';
           // }


           $value['edit']='<a href="'.base_url('Student/edit_student/').$value['id'].'" class="btn btn-warning btn-sm" ><i class="fas fa-edit"></i></a>';
           $output[]= array_values($value);
         $i++;
         }
        $value = array_values($output);
        $result['status_code']=1;
        $result['message']='Data Successfully Found';
        $result['data']=$value;
        $json = json_encode($result);
        echo $json;
     }
     

  }


  public function Add_Student_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_client_form'))
    {
       $phone1 = $this->security->xss_clean($this->input->post('phone1'));
       $post = $this->input->post();
       $this->load->model('Student_Model');
       if($this->Student_Model->Duplicate_Client($phone1))
       {
           $data = $this->Student_Model->Add_Client($post);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Client Create Successfully Done',
                  );

            }
            else
            {
               $array = array(
                    'error'   => true,
                    'message' => '<div class="alert alert-danger">Technical issue, Please try again  !</div>',
                    );

            }
       }
       else
       {
          $array = array(
                    'error'   => true,
                    'message' => '<div class="alert alert-danger"> This Phone No 1 Already Exist !</div>',
                    );
       }
       
    
    }
    else
    {
       $array = array(
        'error'   => true,
        'message' => '
        <div class="alert alert-danger">'.form_error('name').'</div>
        <div class="alert alert-danger">'.form_error('phone1').'</div>
        <div class="alert alert-danger">'.form_error('phone2').'</div>
        <div class="alert alert-danger">'.form_error('course').'</div>
        <div class="alert alert-danger">'.form_error('institute').'</div>
        <div class="alert alert-danger">'.form_error('address').'</div>
        <div class="alert alert-danger">'.form_error('fees').'</div>
        <div class="alert alert-danger">'.form_error('follow_date').'</div>
        <div class="alert alert-danger">'.form_error('remark').'</div>
        '    
       );
    }


   echo json_encode($array);

  }


  public function delete_student()
  {
    $id = $this->input->post('id');
    $this->load->model('Student_Model');
    if($this->Student_Model->Delete_Client($id))
    {

       $array = array(
        'success'   => true,
        'message' => 'Client Delete Successfully Done',
      );

    }
    else
    {
       $array = array(
        'error'   => true,
        'message' => '<div class="alert alert-danger">Technical issue, Please try again  !</div>',
      );

    }

    echo json_encode($array);

  }


  public function sub_admin_status_update()
  {
    $val = $this->input->post('val');
    $id = $this->input->post('id');
    $this->load->model('Student_Model');
    if($this->Student_Model->Sub_Admin_Status_Update($id,$val))
    {

       $array = array(
        'success'   => true,
        'message' => 'Sub Admin Status Update Successfully Done',
      );

    }
    else
    {
       $array = array(
        'error'   => true,
        'message' => '<div class="alert alert-danger">Technical issue, Please try again  !</div>',
      );

    }

    echo json_encode($array);

  }

   
  public function edit_student($id)
  {
     $page_title['title']="Update Student Details";
     $this->load->model('Student_Model');
     $page_title['details']=$this->Student_Model->Fetch_Client_Details($id);
     $page_title['course']= $this->Student_Model->All_Course();
     $page_title['Institute']= $this->Student_Model->All_Institute();
     $page_title['Fees']= $this->Student_Model->All_FeesType();
     
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/edit_student');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }


  public function Update_Student_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_client_form'))
    {
       $id = $this->security->xss_clean($this->input->post('id'));
       $phone1 = $this->security->xss_clean($this->input->post('phone1'));
       $post = $this->input->post();
       $this->load->model('Student_Model');
       if($this->Student_Model->Update_Duplicate_Client($phone1,$id))
       {
           $data = $this->Student_Model->Update_Client($post);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Client Details Update Successfully Done',
                  );

            }
            else
            {
               $array = array(
                    'error'   => true,
                    'message' => '<div class="alert alert-danger">Technical issue, Please try again  !</div>',
                    );

            }
       }
       else
       {
          $array = array(
                    'error'   => true,
                    'message' => '<div class="alert alert-danger"> This Phone No 1 Already Exist !</div>',
                    );
       }
       
    
    }
    else
    {
       $array = array(
        'error'   => true,
        'message' => '
        <div class="alert alert-danger">'.form_error('name').'</div>
        <div class="alert alert-danger">'.form_error('phone1').'</div>
        <div class="alert alert-danger">'.form_error('phone2').'</div>
        <div class="alert alert-danger">'.form_error('course').'</div>
        <div class="alert alert-danger">'.form_error('institute').'</div>
        <div class="alert alert-danger">'.form_error('address').'</div>
        <div class="alert alert-danger">'.form_error('fees').'</div>
        <div class="alert alert-danger">'.form_error('follow_date').'</div>
        <div class="alert alert-danger">'.form_error('remark').'</div>
        '    
       );
    }


   echo json_encode($array);

  }







}
?>