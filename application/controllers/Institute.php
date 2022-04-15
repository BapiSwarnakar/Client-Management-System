<?php
class Institute extends CI_Controller
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


  public function add_institute()
  {
     $page_title['title']="Add Institute";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/add_institute');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function view_institute()
  {
     $page_title['title']="View Institute";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/view_institute');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function display_institute()
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
     $this->load->model('Institute_Model');
     if($data = $this->Institute_Model->All_Institute_Details($from_date,$to_date,$search_val,$status,$top))
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


           $value['edit']='<a href="'.base_url('Institute/edit_institute/').$value['id'].'" class="btn btn-warning btn-sm" ><i class="fas fa-edit"></i></a>';
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


  public function Add_Institute_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_institute_form'))
    {
       $name = $this->security->xss_clean($this->input->post('name'));
       $this->load->model('Institute_Model');
       if($this->Institute_Model->Duplicate_Institute($name))
       {
           $data = $this->Institute_Model->Add_Institute($name);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Institute Create Successfully Done',
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


  public function delete_institute()
  {
    $id = $this->input->post('id');
    $this->load->model('Institute_Model');
    if($this->Institute_Model->Delete_Institute($id))
    {

       $array = array(
        'success'   => true,
        'message' => 'Institute Delete Successfully Done',
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


  public function institute_status_update()
  {
    $val = $this->input->post('val');
    $id = $this->input->post('id');
    $this->load->model('Institute_Model');
    if($this->Institute_Model->Institute_Status_Update($id,$val))
    {

       $array = array(
        'success'   => true,
        'message' => 'Institute Status Update Successfully Done',
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

   
  public function edit_institute($id)
  {
     $page_title['title']="Update Institute";
     $this->load->model('Institute_Model');
     $page_title['details']=$this->Institute_Model->Fetch_Institute_Details($id);
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/edit_institute');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }


 public function Update_Institute_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_institute_form'))
    {
       $name = $this->security->xss_clean($this->input->post('name'));
       $id = $this->security->xss_clean($this->input->post('id'));
       $this->load->model('Institute_Model');
       if($this->Institute_Model->Update_Duplicate_Institute($name,$id))
       {
           $data = $this->Institute_Model->Update_Institute($name,$id);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Institute Update Successfully Done',
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