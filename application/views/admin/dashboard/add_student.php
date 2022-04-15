
<style type="text/css">
	#add_brand{
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
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Student Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid col-md-9">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Student Details</h3>
                <button class="btn btn-success btn-sm mb-1 float-right" onclick="location.href='<?= base_url('Student/view_student') ?>'"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="Admin_login_form">
                <div class="card-body">
              <div class="row"> 
                <div class="form-group col-md-6">
                    <label for="Password">Name :*</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" autocomplete="off" required>
                  </div>
                <div class="form-group col-md-3">
                    <label for="">Phone No 1 :*</label>
                    <input type="text" name="phone1" class="form-control" id="phone1" placeholder="Phone 1" autocomplete="off" required>
                  </div>
                <div class="form-group col-md-3">
                    <label for="Password">Phone No 2 :*</label>
                    <input type="text" name="phone2" class="form-control" id="phone2" placeholder="Phone 2" autocomplete="off" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="name">Course :*</label>
                    <select class="form-control select2" name="course" id="course" required>
                      <option value="">Select</option>
                       <?php
                         foreach ($course as $key => $value) {
                           echo "<option value='".$value['id']."'>".$value['name']."</option>";
                         }
                       ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="name">Institute :*</label>
                    <select class="form-control select2" name="institute" id="institute" required>
                      <option value="">Select</option>
                       <?php
                         foreach ($Institute as $key => $value) {
                           echo "<option value='".$value['id']."'>".$value['name']."</option>";
                         }
                       ?>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-8">
                    <label for="Password">Address :*</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="Address" autocomplete="off" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="fees">Fees :*</label>
                    <input type="number" name="fees" class="form-control" id="fees" placeholder="Fees" autocomplete="off" required>
                  </div>
                  <!-- <div class="form-group col-md-4">
                    <label for="name">Fees Type :*</label>
                    <select class="form-control select2" name="fees" id="fees" required>
                      <option value="">Select</option>
                       <?php
                        //  foreach ($Fees as $key => $value) {
                        //    echo "<option value='".$value['id']."'>".$value['name']."</option>";
                        //  }
                       ?>
                    </select>
                  </div> -->
                  <div class="form-group col-md-4">
                    <label for="Password"> Follow Up Date :*</label>
                    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                      <input type="text" name="follow_date" id="follow_date" class="form-control datetimepicker-input" data-target="#reservationdatetime" required>
                      <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="Password">Remark :*</label>
                    <input type="text" name="remark" class="form-control" id="remark" placeholder="Remark" autocomplete="off" required>
                  </div>
                  
                  
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-center">
                  <input type="submit" name="submit" id="submit" class="btn btn-success" value="Submit">
                </div>
              </form>
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
  <!-- /.content-wrapper -->
     <input type="hidden" id="url" value="Student/Add_Student_Form">