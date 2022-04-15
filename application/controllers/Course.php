<?php
class Course extends CI_Controller
{
	
	public function __construct()
	{
        parent::__construct();
        $this->logged_in();
        $this->only_admin_access();
	}
    
    private function logged_in()
    {
      if(! $this->session->userdata('admin_active'))
      {
      	redirect(base_url('admin'));
      }
    }

    private function only_admin_access()
    {
      if($this->session->userdata('admin_type') !='MA')
      {
        //Not Access This Page without Admin
        redirect(base_url('Dashboard/not_access'));
      }
    }

  public function add_course()
  {
     $page_title['title']="Add Course";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/add_course');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function view_course()
  {
     $page_title['title']="View Institute";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/view_course');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function display_course()
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
     $this->load->model('Course_Model');
     if($data = $this->Course_Model->All_Institute_Details($from_date,$to_date,$search_val,$status,$top))
     {
        $output =array();
        $i = 1;
         foreach ($data as $value) {  
           // $value['delete']='<a href="view_ncert_mcq_summeries.php?id='.$value['Sum_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
           $value['Sl_no']=$i;
           if($value['flag']=='1')
           {
             $value['flag']='<button type="button" data-id="'.$value['id'].'" class="btn btn-success btn-sm status_update" data-val="0">Activate</button>';
           }
           else
           {
             $value['flag']='<button type="button" data-id="'.$value['id'].'" class="btn btn-danger btn-sm status_update" data-val="1">Deactivate</button>';
           }


           $value['edit']='<a href="'.base_url('Course/edit_course/').$value['id'].'" class="btn btn-warning btn-sm" ><i class="fas fa-edit"></i></a>';
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


  public function Add_Course_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_institute_form'))
    {
       $name = $this->security->xss_clean($this->input->post('name'));
       $this->load->model('Course_Model');
       if($this->Course_Model->Duplicate_Course($name))
       {
           $data = $this->Course_Model->Add_Course($name);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Course Create Successfully Done',
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
                    'message' => '<div class="alert alert-danger"> This Institute Name Already Exist !</div>',
                    );
       }
       
    
    }
    else
    {
       $array = array(
        'error'   => true,
        'message' => '
        <div class="alert alert-danger">'.form_error('name').'</div>
        '    
       );
    }


   echo json_encode($array);

  }


  public function delete_course()
  {
    $id = $this->input->post('id');
    $this->load->model('Course_Model');
    if($this->Course_Model->Delete_Course($id))
    {

       $array = array(
        'success'   => true,
        'message' => 'Course Delete Successfully Done',
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


  public function course_status_update()
  {
    $val = $this->input->post('val');
    $id = $this->input->post('id');
    $this->load->model('Course_Model');
    if($this->Course_Model->Course_Status_Update($id,$val))
    {

       $array = array(
        'success'   => true,
        'message' => 'Course Status Update Successfully Done',
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

   
  public function edit_course($id)
  {
     $page_title['title']="Update Institute";
     $this->load->model('Course_Model');
     $page_title['details']=$this->Course_Model->Fetch_Course_Details($id);
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/edit_course');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }


 public function Update_Course_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_institute_form'))
    {
       $name = $this->security->xss_clean($this->input->post('name'));
       $id = $this->security->xss_clean($this->input->post('id'));
       $this->load->model('Course_Model');
       if($this->Course_Model->Update_Duplicate_Course($name,$id))
       {
           $data = $this->Course_Model->Update_Course($name,$id);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Course Update Successfully Done',
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
                    'message' => '<div class="alert alert-danger"> This Institute Name Already Exist !</div>',
                    );
       }
       
    
    }
    else
    {
       $array = array(
        'error'   => true,
        'message' => '
        <div class="alert alert-danger">'.form_error('name').'</div>
        '    
       );
    }


   echo json_encode($array);

  }







}
?>