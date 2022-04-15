<?php
class Follow_Client_Model extends CI_Model
{
	public function All_FollowUp_Client($from_date,$to_date,$search_val,$status,$top)
	{

	  $date = "";
	  if($from_date !='' && $to_date !='')
      {
         $date .="AND DATE(tbl_client.date) BETWEEN '$from_date' AND '$to_date'";
      }
      if($from_date =='' && $to_date !='')
      {
         $date .="AND DATE(tbl_client.date)<= '$to_date'"; 
      }
      if($from_date !='' && $to_date =='')
      {
         $date .="AND DATE(tbl_client.date) >= '$from_date'"; 
      }
      if($status !='All')
      {
        $date .="AND tbl_client.flag='$status'";
      }
	  if($search_val !='')
      {
        $date .= "AND tbl_client.client_type='$search_val'";
      }

      $sess_id='';
      if($this->session->userdata('admin_type') !='MA' && $this->session->userdata('id') != 2) 
      {
        $sess_id .="AND tbl_client.access_id='".$this->session->userdata('id')."'";
      }
	  else{
		$sess_id .="AND tbl_client.access_id='".$this->session->userdata('id')."'";
	  }
	  
    
      
    $sql = "SELECT tbl_client.id,0 AS Sl_no, tbl_client.name, `phone1`, `phone2`, `address`,tbl_course.name as course,tbl_institute.name as institute,fees, `followup_date`, `remark`,0 as edit,DATE_FORMAT(tbl_client.date,'%d-%m-%Y %h:%i')date,client_type FROM `tbl_client` INNER JOIN tbl_course ON tbl_course.id=tbl_client.course_id INNER JOIN tbl_institute ON tbl_institute.id=tbl_client.institute_id  WHERE tbl_client.id !='' $sess_id $date ORDER BY tbl_client.followup_date ASC";
    //echo $sql;
    $query = $this->db->query($sql);

    if($query->num_rows()>0)
    {
      return $query->result_array(); //array
      //return $query->result(); //object
    }
  }
 
  public function Modal_Display($id)
	{
		$sql = $this->db->select()
		                 ->where('id',$id)
		                 ->get('tbl_client');

		return $sql->row();
	}

	public function Update_FollowUp($data){

		$val = array(
		  'followup_date' => $data['follow_date'],
		  'remark' => $data['remark']
		);
  
	    $query= $this->db->where('id', $data['id'])
					   ->update('tbl_client', $val);
		if($query)
		{
			$array = array(
			   
			   'client_id'=>$data['id'],
               'access_id'=>$data['access_id'],
			   'followup_date'=>$data['follow_date'],
			   'remark'=>$data['remark']
			);
			if($this->db->insert('tbl_feedback', $array))
			{
				return true;
			}
			else
			{
				return false;
			} 
		}
		else{
			return false;
		}
	}

	public function Update_Client_Type($data)
	{
		$val = array(
			'client_type' => $data['val']
		  );
	
		return $this->db->where('id', $data['id'])
						 ->update('tbl_client', $val);
	}

	public function FollowUp_History($post)
	{
		
		$query = $this->db->query("SELECT tbl_feedback.*,tbl_admin.name as name FROM tbl_feedback INNER JOIN tbl_admin ON tbl_admin.id=tbl_feedback.access_id WHERE tbl_feedback.client_id='$post[id]' ORDER BY tbl_feedback.id DESC");
		if($query->num_rows()>0)
		{
		 return $query->result_array(); //array
		 //return $query->result(); //object
		}
	}




}