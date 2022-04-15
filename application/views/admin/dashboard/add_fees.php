
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
              <li class="breadcrumb-item active">Add Fees</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid col-md-6">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Fees</h3>
                <button class="btn btn-success btn-sm mb-1 float-right" onclick="location.href='<?= base_url('Fees/view_fees') ?>'"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="Admin_login_form">
                <div class="card-body">

                <div class="form-group">
                    <label for="Password">Fees Type Name :*</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Fees Type Name" autocomplete="off" required>
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
     <input type="hidden" id="url" value="Fees/Add_Fees_Form">