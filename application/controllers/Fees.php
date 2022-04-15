<?php
class Fees extends CI_Controller
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

  

  public function add_fees()
  {
     $page_title['title']="Add Fees Type";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/add_fees');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function view_fees()
  {
     $page_title['title']="View Fees Type";
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/view_fees');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }

  public function display_fees()
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
     $this->load->model('Fees_Model');
     if($data = $this->Fees_Model->All_Fees_Details($from_date,$to_date,$search_val,$status,$top))
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


           $value['edit']='<a href="'.base_url('Fees/edit_fees/').$value['id'].'" class="btn btn-warning btn-sm" ><i class="fas fa-edit"></i></a>';
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


  public function Add_Fees_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_institute_form'))
    {
       $name = $this->security->xss_clean($this->input->post('name'));
       $this->load->model('Fees_Model');
       if($this->Fees_Model->Duplicate_Fees($name))
       {
           $data = $this->Fees_Model->Add_Fees($name);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Fees Create Successfully Done',
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


  public function delete_fees()
  {
    $id = $this->input->post('id');
    $this->load->model('Fees_Model');
    if($this->Fees_Model->Delete_Fees($id))
    {

       $array = array(
        'success'   => true,
        'message' => 'Fees Delete Successfully Done',
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


  public function fees_status_update()
  {
    $val = $this->input->post('val');
    $id = $this->input->post('id');
    $this->load->model('Fees_Model');
    if($this->Fees_Model->Fees_Status_Update($id,$val))
    {

       $array = array(
        'success'   => true,
        'message' => 'Fees Status Update Successfully Done',
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

   
  public function edit_fees($id)
  {
     $page_title['title']="Update Institute";
     $this->load->model('Fees_Model');
     $page_title['details']=$this->Fees_Model->Fetch_Fees_Details($id);
     $this->load->view('admin/dashboard/header',$page_title);
     $this->load->view('admin/dashboard/edit_fees');
     $this->load->view('admin/dashboard/footer');
     $this->load->view('admin/dashboard/script/jquery');
  }


 public function Update_Fees_Form()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_institute_form'))
    {
       $name = $this->security->xss_clean($this->input->post('name'));
       $id = $this->security->xss_clean($this->input->post('id'));
       $this->load->model('Fees_Model');
       if($this->Fees_Model->Update_Duplicate_Fees($name,$id))
       {
           $data = $this->Fees_Model->Update_Fees($name,$id);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'Fees Update Successfully Done',
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