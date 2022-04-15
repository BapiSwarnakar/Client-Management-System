<?php
class Student_Transfer_Model extends CI_Model
{
	public function All_Student_Transfer($from_date,$to_date,$search_val,$status,$top)
	{

	  $date = "";
	  if($from_date !='' && $to_date !='')
      {
         $date .="AND DATE(date) BETWEEN '$from_date' AND '$to_date'";
      }
      if($from_date =='' && $to_date !='')
      {
         $date .="AND DATE(date)<= '$to_date'"; 
      }
      if($from_date !='' && $to_date =='')
      {
         $date .="AND DATE(date) >= '$from_date'"; 
      }
      if($status !='All')
      {
        $date .="AND flag='$status'";
      }

      $sess_id='';
      if($this->session->userdata('admin_type') !='MA' && $this->session->userdata('id') != 2) 
      {
        $sess_id .="AND tbl_client.access_id='".$this->session->userdata('id')."'";
      }
      else
      {
        $sess_id .="AND tbl_client.access_id='".$this->session->userdata('id')."'";
      }
      
      // $lmt = "";
      // if($top !='All')
      // {
      //   $lmt = 'LIMIT '.$top;
      // }
    $sql = "SELECT tbl_client.id,0 AS Sl_no, tbl_client.name, `phone1`, `address`,tbl_course.name as course,tbl_institute.name as institute,fees, `followup_date`, `remark`,DATE_FORMAT(tbl_client.date,'%d-%m-%Y %h:%i')date FROM `tbl_client` INNER JOIN tbl_course ON tbl_course.id=tbl_client.course_id INNER JOIN tbl_institute ON tbl_institute.id=tbl_client.institute_id  WHERE tbl_client.id !='' $sess_id $date ORDER BY tbl_client.id DESC";
    //echo $sql;
    $query = $this->db->query($sql);

    if($query->num_rows()>0)
    {
      return $query->result_array(); //array
      //return $query->result(); //object
    }
  }


  public function Delete_Student($id)
  {
  	return $this ->db-> where_in('id', $id)
                     -> delete('tbl_client');
  }

  public function All_SubAdmin()
  {
    if($this->session->userdata('admin_type') !='MA' && $this->session->userdata('id') != 2) 
    {
      $sql = $this->db->select()
                     ->where('admin_type','MA')
                     ->order_by('id','desc')
                     ->get('tbl_admin');
    }
    else{
      $sql = $this->db->select()
                     ->where('admin_type','SA')
                     ->order_by('id','desc')
                     ->get('tbl_admin');
    }
      

    return $sql->result_array();
  }

  public function Student_Transfer_AccessId($id,$name)
  {
    $data = array(
        'access_id' => $name
      );
  	return $this ->db->where_in('id', $id)
                     ->update('tbl_client', $data);
  }



  

}

?>