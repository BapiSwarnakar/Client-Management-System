<?php
class Admin_Model extends CI_Model
{
	public function Admin_Login($username,$password)
	{
		
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->where('admin_flag','1');
        $query = $this->db->get('tbl_admin');
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		
		return false;
	}

	public function All_Register_Student($from_date,$to_date,$search_val,$status,$top)
	{

	  $date = "";
	  if($from_date !='' && $to_date !='')
      {
         $date .="AND DATE(Reg_Date) BETWEEN '$from_date' AND '$to_date'";
      }
      if($from_date =='' && $to_date !='')
      {
         $date .="AND DATE(Reg_Date)<= '$to_date'"; 
      }
      if($from_date !='' && $to_date =='')
      {
         $date .="AND DATE(Reg_Date) >= '$from_date'"; 
      }
      if($status !='All')
      {
        $date .="AND Reg_Flag='$status'";
      } 
      // $lmt = "";
      // if($top !='All')
      // {
      //   $lmt = 'LIMIT '.$top;
      // }

    $sql = "SELECT `Reg_Id`,0 AS Sl_no, `name`, `father`, `guardian`, `dob`, `school`,`aadhar`, `mobile1`, `address`, `addmission`,0 as print,DATE_FORMAT(Reg_Date,'%d-%m-%Y %h:%i')Reg_Date FROM `tbl_registration` WHERE Reg_Id !='' $date ORDER BY Reg_Id DESC";
    $query = $this->db->query($sql);

    if($query->num_rows()>0)
	{
	  return $query->result_array(); //array
	  //return $query->result(); //object
	}




	}


	public function Fetch_Application_Details($id)
	{
		$sql = $this->db->select()
		                 ->where('Reg_Id',$id)
		                 ->get('tbl_registration');

		return $sql->row();
	}


	public function Number_of_Client()
	{  
		if($this->session->userdata('id') !="2" && $this->session->userdata('admin_type') !="MA")
		{
			
			$sql = $this->db->select()
                    ->from('tbl_client')
					->where('owner_id',$this->session->userdata('id'))
                    ->order_by('id', 'ASC')
                    ->get();
		}
		else{

			$sql = $this->db->select()
							->from('tbl_client')
							->order_by('id', 'ASC')
							->get();
		}
		
      return $sql->num_rows();
	}

	public function Number_of_Institute()
	{
		$sql = $this->db->select()
                    ->from('tbl_institute')
                    ->order_by('id', 'ASC')
                    ->get();
      return $sql->num_rows();
	}

	public function Number_of_Course()
	{
		$sql = $this->db->select()
                    ->from('tbl_course')
                    ->order_by('id', 'ASC')
                    ->get();
      return $sql->num_rows();
	}

	public function Number_of_FollowUp()
	{
			
			$sql = $this->db->select()
                    ->from('tbl_client')
					->where('access_id',$this->session->userdata('id'))
					->where('client_type', 'Follow Up')
                    ->order_by('id', 'ASC')
                    ->get();
		
      return $sql->num_rows();
	}
	public function Number_of_Prospective()
	{
		
			
			$sql = $this->db->select()
                    ->from('tbl_client')
					->where('access_id',$this->session->userdata('id'))
					->where('client_type', 'Prospective')
                    ->order_by('id', 'ASC')
                    ->get();
	
      return $sql->num_rows();
	}
	public function Number_of_Closed()
	{
			
			$sql = $this->db->select()
                    ->from('tbl_client')
					->where('access_id',$this->session->userdata('id'))
					->where('client_type', 'Closed')
                    ->order_by('id', 'ASC')
                    ->get();
		
      return $sql->num_rows();
	}

	public function All_Trans_Pending()
	{
	  
		   $sql = $this->db->select()
                    ->from('tbl_client')
                    ->where('access_id',$this->session->userdata('id'))
                    ->get();
		
      return $sql->num_rows();
	}


	public function Change_Password($password,$id)
	{
		$data = array(
	       'password'=>$password 
        );
        return $this->db->where('id',$id)
                    ->update('tbl_admin',$data);
	}




}

?>