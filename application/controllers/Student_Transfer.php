<?php
class Student_Transfer extends CI_Controller
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

    public function view_student_transfer()
    {
        $page_title['title']="View Student Transfer";
        $this->load->model('Student_Transfer_Model');
        $page_title['sub_admin']= $this->Student_Transfer_Model->All_SubAdmin();
        $this->load->view('admin/dashboard/header',$page_title);
        $this->load->view('admin/dashboard/view_student_transfer');
        $this->load->view('admin/dashboard/footer');
        $this->load->view('admin/dashboard/script/jquery');
    }
    public function display_student_transfer()
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
     $this->load->model('Student_Transfer_Model');
     if($data = $this->Student_Transfer_Model->All_Student_Transfer($from_date,$to_date,$search_val,$status,$top))
     {
        $output =array();
        $i = 1;
         foreach ($data as $value) {  
           
           $value['Sl_no']=$i;
           
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

  public function delete_student_transfer()
  {
    $id = $this->input->post('id');
    $this->load->model('Student_Transfer_Model');
    if($this->Student_Transfer_Model->Delete_Student($id))
    {

       $array = array(
        'success'   => true,
        'message' => 'Student Delete Successfully Done',
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

  public function update_student_accessId()
  {
    $name = $this->input->post('name');
    $id = $this->input->post('id');
    $this->load->model('Student_Transfer_Model');
    if($this->Student_Transfer_Model->Student_Transfer_AccessId($id,$name))
    {

       $array = array(
        'success'   => true,
        'message' => 'Student Transfer Successfully Done',
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




}

?>