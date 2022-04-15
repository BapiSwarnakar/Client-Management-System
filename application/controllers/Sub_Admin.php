<?php
class Sub_Admin extends CI_Controller
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

  public function add_sub_admin()
  {
     $page_title['title']="Add Sub Admin";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/add_sub_admin');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function view_sub_admin()
  {
     $page_title['title']="View Sub Admin";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/view_sub_admin');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function display_sub_admin()
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
     $this->load->model('Sub_Admin_Model');
     if($data = $this->Sub_Admin_Model->All_Sub_Admin($from_date,$to_date,$search_val,$status,$top))
     {
        $output =array();
        $i = 1;
         foreach ($data as $value) {  
           // $value['delete']='<a href="view_ncert_mcq_summeries.php?id='.$value['Sum_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
           $value['Sl_no']=$i;
           if($value['admin_flag']=='1')
           {
             $value['admin_flag']='<button type="button" data-id="'.$value['id'].'" class="btn btn-success btn-sm status_update" data-val="0">Activate</button>';
           }
           else
           {
             $value['admin_flag']='<button type="button" data-id="'.$value['id'].'" class="btn btn-danger btn-sm status_update" data-val="1">Deactivate</button>';
           }


           $value['edit']='<a href="'.base_url('Sub_Admin/edit_sub_admin/').$value['id'].'" class="btn btn-warning btn-sm" ><i class="fas fa-edit"></i></a>';
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


  public function Add_Sub_Admin_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_sub_admin_form'))
    {
       $name = $this->security->xss_clean($this->input->post('name'));
       $username = $this->security->xss_clean($this->input->post('username'));
       $password = $this->security->xss_clean($this->input->post('password'));
       $this->load->model('Sub_Admin_Model');
       if($this->Sub_Admin_Model->Duplicate_Sub_Admin($username))
       {
           $data = $this->Sub_Admin_Model->Add_Sub_Admin($name,$username,$password);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Sub Admin Create Successfully Done',
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
                    'message' => '<div class="alert alert-danger"> Please Enter Another UserName or Password !</div>',
                    );
       }
       
    
    }
    else
    {
       $array = array(
        'error'   => true,
        'message' => '
        <div class="alert alert-danger">'.form_error('name').'</div>
        <div class="alert alert-danger">'.form_error('username').'</div>
        <div class="alert alert-danger">'.form_error('password').'</div>
        <div class="alert alert-danger">'.form_error('c_password').'</div>
        '    
       );
    }


   echo json_encode($array);

  }


  public function delete_sub_admin()
  {
    $id = $this->input->post('id');
    $this->load->model('Sub_Admin_Model');
    if($this->Sub_Admin_Model->Delete_Sub_Admin($id))
    {

       $array = array(
        'success'   => true,
        'message' => 'Sub Admin Delete Successfully Done',
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
    $this->load->model('Sub_Admin_Model');
    if($this->Sub_Admin_Model->Sub_Admin_Status_Update($id,$val))
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

   
  public function edit_sub_admin($id)
  {
     $page_title['title']="Update Sub Admin Details";
     $this->load->model('Sub_Admin_Model');
     $page_title['details']=$this->Sub_Admin_Model->Fetch_Sub_Admin_Details($id);
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/edit_sub_admin');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }


  public function Update_Sub_Admin_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_sub_admin_form'))
    {
       $name = $this->security->xss_clean($this->input->post('name'));
       $username = $this->security->xss_clean($this->input->post('username'));
       $password = $this->security->xss_clean($this->input->post('password'));
       $id = $this->security->xss_clean($this->input->post('id'));
       $this->load->model('Sub_Admin_Model');
       if($this->Sub_Admin_Model->Update_Duplicate_Sub_Admin($username,$id))
       {
           $data = $this->Sub_Admin_Model->Update_Sub_Admin($name,$username,$password,$id);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Sub Admin Details Update Successfully Done',
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
                    'message' => '<div class="alert alert-danger"> Please Enter Another UserName or Password !</div>',
                    );
       }
       
    
    }
    else
    {
       $array = array(
        'error'   => true,
        'message' => '
        <div class="alert alert-danger">'.form_error('username').'</div>
        <div class="alert alert-danger">'.form_error('password').'</div>
        <div class="alert alert-danger">'.form_error('c_password').'</div>
        '    
       );
    }


   echo json_encode($array);

  }







}
?>