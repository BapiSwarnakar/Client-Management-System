<?php
class Follow_Client extends CI_Controller
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
    
    public function view_followup()
    {
        $page_title['title']="View FollowUp";
        $this->load->model('Student_Transfer_Model');
        $page_title['sub_admin']= $this->Student_Transfer_Model->All_SubAdmin();
        $this->load->view('admin/dashboard/header',$page_title);
        $this->load->view('admin/dashboard/view_followup');
        $this->load->view('admin/dashboard/footer');
        $this->load->view('admin/dashboard/script/jquery');
    }

    public function display_followup()
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
     $this->load->model('Follow_Client_Model');
     if($data = $this->Follow_Client_Model->All_FollowUp_Client($from_date,$to_date,$search_val,$status,$top))
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

          
           if($value['client_type']=='Closed')
           {
            $value['followup_date']="<span class='badge badge-success'>".$value['followup_date']."</span>
            <input type='button' class='btn btn-info btn-sm m-1 History_show' data-id='".$value['id']."' data-url='Follow_Client/followup_history_display' value='History' />";
           }
           else
           {
            $value['followup_date']="<span class='badge badge-success'>".$value['followup_date']."</span>
            <input type='button' class='btn btn-warning btn-sm m-1 Model_Data_show' data-id='".$value['id']."' data-url='Follow_Client/modal_data_display' value='Update' />
            <input type='button' class='btn btn-info btn-sm m-1 History_show' data-id='".$value['id']."' data-url='Follow_Client/followup_history_display' value='History' />";
           }
           if($value['client_type']=='Follow Up')
           {
                $value['edit']='
                <select class="form-control select_tag" name="select_tag" id="select_tag">
                <option value="">Select Type</option>
                <option value="Follow Up" data-id="'.$value['id'].'" selected>Follow Up</option>
                <option value="Prospective" data-id="'.$value['id'].'">Prospective</option>
                <option value="Closed" data-id="'.$value['id'].'">Closed</option>
                </select>
                ';
           }
           elseif($value['client_type']=='Prospective'){

                $value['edit']='
                <select class="form-control select_tag" name="select_tag" id="select_tag">
                <option value="">Select Type</option>
                <option value="Follow Up" data-id="'.$value['id'].'">Follow Up</option>
                <option value="Prospective" data-id="'.$value['id'].'" selected>Prospective</option>
                <option value="Closed" data-id="'.$value['id'].'">Closed</option>
                </select>
                ';
           }
           else{

                $value['edit']='
                <select class="form-control select_tag" name="select_tag" id="select_tag">
                <option value="Closed" selected>Closed</option>
                </select>
                ';
           }
           
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

  public function modal_data_display()
  {
     $id = $this->input->post('id');
     $this->load->model('Follow_Client_Model');
     if($data = $this->Follow_Client_Model->Modal_Display($id))
     {
        $array = array(
            'id'=>$data->id,
            'follow_date'=>$data->followup_date,
            'remark'=>$data->remark,
            'access_id'=>$data->access_id,
            'success'=>true
        );
     }
     else{
        $array = array(
            'error'=>true
        );
     }
    echo json_encode($array);
  }

  public function Update_Client_FollowUp()
  {
    //$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if($this->form_validation->run('validate_client_followup_update_form'))
    {
       $post = $this->input->post();
       $this->load->model('Follow_Client_Model');
    
           $data = $this->Follow_Client_Model->Update_FollowUp($post);
           if($data)
           {
            
                $array = array(
                    'success'   => true,
                    'message' => 'FollowUp Update Successfully Done',
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
        'message' => '
        <div class="alert alert-danger">'.form_error('follow_date').'</div>
        <div class="alert alert-danger">'.form_error('remark').'</div>
        '    
       );
    }


   echo json_encode($array);

  }
    
  public function Update_Client_Type()
  {
    $post = $this->input->post();
    $this->load->model('Follow_Client_Model');
 
        $data = $this->Follow_Client_Model->Update_Client_Type($post);
        if($data)
        {
         
             $array = array(
                 'success'   => true,
                 'message' => 'Client Type Update Successfully Done',
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

  public function followup_history_display()
  {
    $post = $this->input->post();
    $this->load->model('Follow_Client_Model');
 
        $data = $this->Follow_Client_Model->FollowUp_History($post);
        if($data)
        {
          $output ='';
          foreach($data as $val){
            $output .='
               
              <div class="alert alert-light">'.$val['remark'].'
              <br><span class="badge badge-info">'.$val['followup_date'].'</span>
              <span class="badge badge-success float-right">'.$val['name'].'</span>

              </div>
            ';
          }
         
            $array = array(
                 'success'   => true,
                 'message' =>$output
               );

         }
         else
         {
            $array = array(
                 'success'   => true,
                 'message' => '<div class="alert alert-danger">History Not Found !</div>',
                 );

         }
    echo json_encode($array);
  }

  

}