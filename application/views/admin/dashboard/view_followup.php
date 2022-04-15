<style type="text/css">
  #display_info_details{
    background-color: white;
    color: black;
  }
</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
         <!--  <div class="col-sm-6">
            <h1>Display Billing Details</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Display FollowUp Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View FollowUp List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
             
                <div  class="form-row">

                  <div class="form-group">
                    <label>Top
                    <select name="top" id="top" class="form-control form-control-sm">
                      <option value="50">50</option>
                      <option value="200">200</option>
                      <option value="500">500</option>
                      <option value="All">All</option>
                    </select>
                  </label>

                    <label>From
                    <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"></label>
                  </div>&nbsp;
                  <div class="form-group">
                    <label>To
                    <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"></label>
                  </div>&nbsp;
                  <div class="form-group" style="display: none;">
                    <label>Status
                      <select class="form-control form-control-sm" name="status" id="status">
                        <?php
                        $all ='';
                        $two ='';
                        $one ='';
                        $three = '';
                         if(isset($_GET['status']) && !empty($_GET['status'])){

                           if($_GET['status']=='All')
                           {
                             $all .='selected'; 
                           }
                           if($_GET['status']=='2')
                           {
                             $two .='selected'; 
                           }
                           if ($_GET['status']=='1') {
                             $one .='selected'; 
                           }
                           if ($_GET['status']=='3') {
                             $three .='selected'; 
                           }
                         }
                         else
                         {
                           $all .='selected';
                         }
                        ?>
                        <option value="All" <?php echo $all; ?>>All</option>
                        <option value="1" <?php echo $one; ?>>Pending</option>
                        <option value="2" <?php echo $two; ?>>Active</option>
                        <option value="3" <?php echo $three; ?>>Rejected</option>
                        
                      </select>
                    </label>
                  </div>
                  <div class="form-group">
                  <label>Client Type
                     <select class="form-control form-control-sm" name="myInput1" id="myInput1">
                          <option value="">Select</option>
                          <option value="Follow Up">Follow Up</option>
                          <option value="Prospective">Prospective</option>
                          <option value="Closed">Closed</option>
                    </select>
                        </label>
                </div>
                   
              </div>
              
                    
              </div>
           
                

              <form id="frm-example" method="POST">
                
                <div class="row ml-3">
                    <select class="form-control select2 col-md-4" name="name" id="name">
                        <option value="">Select Transfer User</option>
                        <?php
                            foreach ($sub_admin as $key => $value) {
                            echo "<option value='".$value['id']."'>".$value['name']."</option>";
                            }
                        ?>
                    </select>
                    <button type="submit" name="submit" id="transfer" class="btn btn-success mb-3 ml-2">Transfer Now</button>&nbsp;
                </div>
                <!-- <button type="submit" name="submit" id="delete" class="btn btn-danger btn-sm mb-3 d-none"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</button>&nbsp; -->
               <table id="table" class="table table-bordered table-striped">
                  <thead>

                  <tr>

                    <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                    <th>Sl</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Phone 2</th> 
                    <th>Address</th> 
                    <th>Course</th> 
                    <th>Institute</th>
                    <th>Fees</th> 
                    <th>FollowUp</th> 
                    <th>Remark</th>
                    <th>Action</th>
                    <th>Date</th> 
                    
                                     
                  </tr>
                  </thead>
                  <tbody id="data_success">
                       <tr id="load">
                          <td colspan="14" class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></td>
                        </tr>
                  </tbody>
                </table>

               
            </form>
              </div>
           
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


<!-- Modal -->
<div class="modal fade" id="modal_form" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update FollowUp Date</h5>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
      </div>
      <div class="modal-body">
        <form id="Admin_login_form">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="Password"> Follow Up Date :*</label>
                    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                      <input type="text" name="follow_date" id="follow_date" class="form-control datetimepicker-input" data-target="#reservationdatetime" required>
                      <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="Password">Remark :*</label>
                    <textarea name="remark" class="form-control" id="remark" placeholder="Remark" autocomplete="off" required></textarea>
                  </div>
                  <div class="card-footer d-flex justify-content-center">
                  <input type="hidden" id="id" name="id">
                  <input type="hidden" id="access_id" name="access_id">
                  <input type="submit" name="submit" id="submit" class="btn btn-success" value="Submit">
                </div>
            </div>
        </form>
      </div>
     
    </div>
  </div>
</div>
<div class="modal fade" id="history_form" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Follow Up History</h5>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
      </div>
      <div class="modal-body" id="data">
        
      </div>
     
    </div>
  </div>
</div>
  <!-- /.content-wrapper -->
  <!-- Display Value -->
  <!-- <input type="hidden" id="display" value="Display_Billing_Point_All"> -->
  <input type="hidden" id="modal_url" value="Follow_Client/Update_Client_FollowUp">
  <input type="hidden" id="display_url" value="Follow_Client/display_followup">
  <input type="hidden" id="select_url" value="Follow_Client/Update_Client_Type">
  <input type="hidden" id="transfer_url" value="Student_Transfer/update_student_accessId">
  <!-- <input type="hidden" id="delete_url" value="Client/delete_client">
  <input type="hidden" id="status_url" value="Sub_Admin/sub_admin_status_update"> -->
