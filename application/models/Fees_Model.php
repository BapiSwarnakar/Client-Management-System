<?php
class Fees_Model extends CI_Model
{
	public function All_Fees_Details($from_date,$to_date,$search_val,$status,$top)
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
      // $lmt = "";
      // if($top !='All')
      // {
      //   $lmt = 'LIMIT '.$top;
      // }
    $sql = "SELECT `id`,0 AS Sl_no,`name`, `flag`,DATE_FORMAT(date,'%d-%m-%Y %h:%i')date FROM `tbl_fees` WHERE id !='' $date ORDER BY id DESC";
    $query = $this->db->query($sql);

    if($query->num_rows()>0)
	{
	  return $query->result_array(); //array
	  //return $query->result(); //object
	}
  }
  
  public function Duplicate_Fees($name)
  {
  	$sql = $this->db->select()
		            ->where('name',$name)
		            ->get('tbl_fees');

		if($sql->num_rows()>0)
		{
		  return false;
		}

		return true;
  }

  public function Update_Duplicate_Fees($name,$id)
  {
    $sql = $this->db->select()
                ->where('name',$name)
                ->where('id !=',$id)
                ->get('tbl_fees');

    if($sql->num_rows()>0)
    {
      return false;
    }

    return true;
  }
  public function Add_Fees($name)
  {
  	 $data = array(
		        'name' => $name,
		        'flag' => 1,		       
		);
		if($this->db->insert('tbl_fees', $data))
		{
			return true;
		}
		else
		{
			return false;
		} 
  }


  public function Delete_Fees($id)
  {
  	return $this ->db-> where_in('id', $id)
                     -> delete('tbl_fees');
  }


  public function Fees_Status_Update($id,$val){

      $data = array(
        'flag' => $val
      );

    return  $this->db->where('id', $id)
                     ->update('tbl_fees', $data);
  }

  public function Fetch_Fees_Details($id)
  {
    $sql = $this->db->select()
                     ->where('id',$id)
                     ->get('tbl_fees');

    return $sql->row();
  }


  public function Update_Fees($name,$id){

      $data = array(
        'name' => $name,
      );

    return  $this->db->where('id', $id)
                     ->update('tbl_fees', $data);
  }







}

?>