<?php
class Student_Model extends CI_Model
{
	public function All_Client($from_date,$to_date,$search_val,$status,$top)
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
        $sess_id .="AND tbl_client.owner_id='".$this->session->userdata('id')."'";
      }
      // $lmt = "";
      // if($top !='All')
      // {
      //   $lmt = 'LIMIT '.$top;
      // }
    $sql = "SELECT tbl_client.id,0 AS Sl_no, tbl_client.name, `phone1`, `address`,tbl_course.name as course,tbl_institute.name as institute,fees, `followup_date`, `remark`,DATE_FORMAT(tbl_client.date,'%d-%m-%Y %h:%i')date,0 as edit, `phone2` FROM `tbl_client` INNER JOIN tbl_course ON tbl_course.id=tbl_client.course_id INNER JOIN tbl_institute ON tbl_institute.id=tbl_client.institute_id  WHERE tbl_client.id !='' $sess_id $date ORDER BY tbl_client.id DESC";
    //echo $sql;
    $query = $this->db->query($sql);

    if($query->num_rows()>0)
    {
      return $query->result_array(); //array
      //return $query->result(); //object
    }
  }
  
  public function Duplicate_Client($phone1)
  {
  	$sql = $this->db->select()
		            ->where('phone1',$phone1)
		            ->get('tbl_client');

		if($sql->num_rows()>0)
		{
		  return false;
		}

		return true;
  }

  public function Update_Duplicate_Client($phone1,$id)
  {
    $sql = $this->db->select()
                ->where('phone1',$phone1)
                ->where('id !=',$id)
                ->get('tbl_client');

    if($sql->num_rows()>0)
    {
      return false;
    }

    return true;
  }
  public function Add_Client($post)
  {
  	 $data = array(
		        'name' => $post['name'],
		        'phone1' => $post['phone1'],
		        'phone2' => $post['phone2'],
		        'course_id' => $post['course'],
            'institute_id' => $post['institute'],
            'address' => $post['address'],
            'fees_id' =>'',
            'fees' => $post['fees'],
            'followup_date' => $post['follow_date'],
            'remark' => $post['remark'],
            'admin_id'=>2,
            'owner_id'=>$this->session->userdata('id'),
            'access_id'=>$this->session->userdata('id'),
            'client_type'=>'Follow Up',
            'flag'=>1
		       
		    );
		if($this->db->insert('tbl_client', $data))
		{
      $last_id= $this->db->insert_id();
			$array = array(
        'client_id'=>$last_id,
        'access_id'=>$this->session->userdata('id'),
        'followup_date'=>$post['follow_date'],
        'remark'=>$post['remark']
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
		else
		{
			return false;
		} 
  }


  public function Delete_Client($id)
  {
  	return $this ->db-> where_in('id', $id)
                     -> delete('tbl_client');
  }


  public function Sub_Admin_Status_Update($id,$val){

      $data = array(
        'admin_flag' => $val
      );

    return  $this->db->where('id', $id)
                     ->update('tbl_client', $data);
  }

  public function Fetch_Client_Details($id)
  {
    $sql = $this->db->select()
                     ->where('id',$id)
                     ->get('tbl_client');

    return $sql->row();
  }


  public function Update_Sub_Admin($username,$password,$id){

      $data = array(
        'username' => $username,
        'password'=>$password
      );

    return  $this->db->where('id', $id)
                     ->update('tbl_client', $data);
  }

   public function Update_Client($post)
  {
     $data = array(
            'name' => $post['name'],
            'phone1' => $post['phone1'],
            'phone2' => $post['phone2'],
            'course_id' => $post['course'],
            'institute_id' => $post['institute'],
            'address' => $post['address'],
            'fees_id' =>'' ,
            'fees' => $post['fees'],
            'followup_date' => $post['follow_date'],
            'remark' => $post['remark'],
                       
        );
     return  $this->db->where('id', $post['id'])
                     ->update('tbl_client', $data);
  }


  public function All_Course()
  {
      $sql = $this->db->select()
                     ->where('flag !=',0)
                     ->get('tbl_course');

    return $sql->result_array();
  }

  public function All_Institute()
  {
      $sql = $this->db->select()
                     ->where('flag !=',0)
                     ->get('tbl_institute');

    return $sql->result_array();
  }

  public function All_FeesType()
  {
      $sql = $this->db->select()
                     ->where('flag !=',0)
                     ->get('tbl_fees');

    return $sql->result_array();
  }







}

?>