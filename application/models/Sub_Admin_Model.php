<?php
class Sub_Admin_Model extends CI_Model
{
	public function All_Sub_Admin($from_date,$to_date,$search_val,$status,$top)
	{

	  $date = "";
	  if($from_date !='' && $to_date !='')
      {
         $date .="AND DATE(admin_date) BETWEEN '$from_date' AND '$to_date'";
      }
      if($from_date =='' && $to_date !='')
      {
         $date .="AND DATE(admin_date)<= '$to_date'"; 
      }
      if($from_date !='' && $to_date =='')
      {
         $date .="AND DATE(admin_date) >= '$from_date'"; 
      }
      if($status !='All')
      {
        $date .="AND admin_flag='$status'";
      } 
      // $lmt = "";
      // if($top !='All')
      // {
      //   $lmt = 'LIMIT '.$top;
      // }
    $sql = "SELECT `id`,0 AS Sl_no,`name`,`username`, `password`, `admin_type`, `admin_flag`, DATE_FORMAT(admin_date,'%d-%m-%Y %h:%i')admin_date FROM `tbl_admin` WHERE id !='' AND admin_type !='MA' $date ORDER BY id DESC";
    $query = $this->db->query($sql);

    if($query->num_rows()>0)
	{
	  return $query->result_array(); //array
	  //return $query->result(); //object
	}
  }
  
  public function Duplicate_Sub_Admin($username)
  {
  	$sql = $this->db->select()
		            ->where('username',$username)
		            ->get('tbl_admin');

		if($sql->num_rows()>0)
		{
		  return false;
		}

		return true;
  }

  public function Update_Duplicate_Sub_Admin($username,$id)
  {
    $sql = $this->db->select()
                ->where('username',$username)
                ->where('id !=',$id)
                ->get('tbl_admin');

    if($sql->num_rows()>0)
    {
      return false;
    }

    return true;
  }
  public function Add_Sub_Admin($name,$username,$password)
  {
  	 $data = array(
            'name' => $name,
		        'username' => $username,
		        'password' => $password,
		        'admin_type' => 'SA',
		        'admin_flag' => 1
		       
		);
		if($this->db->insert('tbl_admin', $data))
		{
			return true;
		}
		else
		{
			return false;
		} 
  }


  public function Delete_Sub_Admin($id)
  {
  	return $this ->db-> where_in('id', $id)
                     -> delete('tbl_admin');
  }


  public function Sub_Admin_Status_Update($id,$val){

      $data = array(
        'admin_flag' => $val
      );

    return  $this->db->where('id', $id)
                     ->update('tbl_admin', $data);
  }

  public function Fetch_Sub_Admin_Details($id)
  {
    $sql = $this->db->select()
                     ->where('id',$id)
                     ->get('tbl_admin');

    return $sql->row();
  }


  public function Update_Sub_Admin($name,$username,$password,$id){

      $data = array(
        'name' => $name,
        'username' => $username,
        'password'=>$password
      );

    return  $this->db->where('id', $id)
                     ->update('tbl_admin', $data);
  }







}

?>