<script type="text/javascript">
	$(document).ready(function(){

        //resize();
	    function resize() {
	      if ($(window).width() < 700) {
	         $("#table").addClass("table-responsive"); 
	       }
	    }

	    $(function () {
	        // Summernote
	        $('.textarea').summernote()
	      })

	    $('.select2').select2();

	        //Date and time picker
	    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

	    //Date range picker
	    $('#reservation').daterangepicker()
	    //Date range picker with time picker
	    $('#reservationtime').daterangepicker({
	      timePicker: true,
	      timePickerIncrement: 30,
	      locale: {
	        format: 'MM/DD/YYYY hh:mm A'
	      }
	    })

	    

        $('#Admin_login_form').parsley();
        $('#Admin_login_form').on('submit',function(event){
          if($('#Admin_login_form').parsley().validate())
          {
            $.ajax({
              url:"<?= site_url()?>/"+$('#url').val()+"",
              method:"post",
              data : $(this).serialize(),
              dataType:"json",
              beforeSend:function()
              {
                $('#submit').val('Please Wait..');
                $('#submit').attr('disabled',true);
              },
              success:function(data)
              {
              if(data.success)
                  {
                    swal("Thankyou",data.message, "success");
                    $('#Admin_login_form')[0].reset();
                    $('#submit').val('Submit');
                    $('#submit').attr('disabled',false);
                     
                  }
                   else
                   {
                      toastr.options = {
                        "closeButton": true,  // true or false
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,  // true or false
                        "rtl": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false, // true or false
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                     toastr["error"](data.message, "Message");
                     $('#submit').val('Submit');
                     $('#submit').attr('disabled',false);
                   }
              }
            });
          }
        event.preventDefault();
        });


	$(document).on('click','.Payment_Now',function(event){
         
         $.ajax({
		        url : "../../action-page/admin_ajax_action.php",
		        type : "POST",
		        data : {
		          page : "Payment_Amount",
		          action :"Payment_Amount",
		          id : $(this).data('id')
		        },
		        dataType: "json",
		        success : function(data){
		           $('#amount').val(data.amount);
		           $('#id').val(data.id);
		           $('#exampleModalCenter').modal('show');

		        }
		    });

		 event.preventDefault();
		});
		//current_date = (new Date()).toISOString().split('T')[0];
		Display_All_Payment(
			$('#from_date').val(),
			$('#to_date').val(),
			$('#myInput1').val(),
			$('#status').val(),
			$('#top').val()
			);

		  function Display_All_Payment(from_date,to_date,search_val,status,top)
		  {
             $.fn.dataTable.ext.errMode = 'none';
		     var table = $('#table').DataTable({
			      'ajax':{
			          'url': "<?= site_url()?>/"+$('#display_url').val()+"",
			          'method': 'POST',
			          'data' : {
				          'from_date' : from_date,
				          'to_date' : to_date,
				          'search_val' : search_val,
				          'status' : status,
				          'top' : top
			          },
			          'error': function(jqXHR, textStatus, errorThrown){
					        $('#table').DataTable().clear().draw();
					    }  
			       }, 
			      "bProcessing": true,
		        "bDestroy": true ,
			      'columnDefs': [{
					   'targets': 0,
					   'searchable':false,
					   'orderable':false,
					   'className': 'dt-body-center',
					   'render': function (data, type, full, meta){
					       return '<input type="checkbox" name="id[]" class="select_record" value="' + $('<div/>').text(data).html() + '">';
					   }
					}],
					'order': [[1, 'asc']],
					"responsive": true,
	                "autoWidth": false,
	                  dom: 'Bfrtip',
	                  buttons: [
	                      'copy', 'csv', 'excel', 'pdf', 'print'
	                  ]
			   });
            

            // Handle click on "Select all" control
			$('#example-select-all').on('click', function(){
			   // Get all rows with search applied
			   var rows = table.rows({ 'search': 'applied' }).nodes();
			   // Check/uncheck checkboxes for all rows in the table
			   $('input[type="checkbox"]', rows).prop('checked', this.checked);
			});
			// Handle click on checkbox to set state of "Select all" control
			$('#example tbody').on('change', 'input[type="checkbox"]', function(){
			   // If checkbox is not checked
			   if(!this.checked){
			      var el = $('#example-select-all').get(0);
			      // If "Select all" control is checked and has 'indeterminate' property
			      if(el && el.checked && ('indeterminate' in el)){
			         // Set visual state of "Select all" control
			         // as 'indeterminate'
			         el.indeterminate = true;
			      }
			   }
			});

            
			
					   
		}

    

	$('#delete').click(function(event){

        var id = $('.select_record:checked').map(function(){
           return $(this).val();
        }).get();  //.get().join(','); String  //.get(); Array
        
        if(id !='')
        {
           swal({
			  title: "Are you sure?",
			  text: "Delete Record",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			    $.ajax({
                      url : "<?= site_url()?>/"+$('#delete_url').val()+"",
                      type : "POST",
                      data:{
                        id : id
                      },
                      dataType : "json",
                      beforeSend : function(){
                         $('#delete').html('Please wait...');
                         $('#delete').attr('disabled',true);
                      },
                      success : function (data)
                      {
                         if(data.success)
                            {                   
                              Display_All_Payment(
								$('#from_date').val(),
								$('#to_date').val(),
								$('#myInput1').val(),
								$('#status').val(),
								$('#top').val()
								);
                              swal("Yah",data.message, "success");
                              $('#delete').html('<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete');
                              $('#delete').attr('disabled',false);

                             }
                             else
                             {
                              swal("Wrong",data.message, "error");
                              $('#delete').html('<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete');
                              $('#delete').attr('disabled',false);
                             }
                      }

                    });
			  } 
			});
           
        }
        else
        {
           swal("Warning", "Please Select Minimun One Record", "warning");
          
        }

      event.preventDefault();
        
     });



    //  TRANSFER USER

    $('#transfer').click(function(event){

    var id = $('.select_record:checked').map(function(){
      return $(this).val();
    }).get();  //.get().join(','); String  //.get(); Array

    if(id !='' && $('#name').val() !='')
    {
      swal({
    title: "Are you sure?",
    text: "Transfer Selected Record",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
      $.ajax({
                  url : "<?= site_url()?>/"+$('#transfer_url').val()+"",
                  type : "POST",
                  data:{
                    id : id,
                    name : $('#name').val()
                  },
                  dataType : "json",
                  beforeSend : function(){
                    $('#transfer').html('Please wait...');
                    $('#transfer').attr('disabled',true);
                  },
                  success : function (data)
                  {
                    if(data.success)
                        {                   
                          Display_All_Payment(
                            $('#from_date').val(),
                            $('#to_date').val(),
                            $('#myInput1').val(),
                            $('#status').val(),
                            $('#top').val()
                            );
                          swal("Yah",data.message, "success");
                          $('#transfer').html('Transfer Now');
                          $('#transfer').attr('disabled',false);

                        }
                        else
                        {
                          swal("Wrong",data.message, "error");
                          $('#transfer').html('Transfer Now');
                          $('#transfer').attr('disabled',false);
                        }
                  }

                });
    } 
    });
      
    }
    else
    {
      swal("Warning", "Please Select Minimun One Record &  Transfer User", "warning");
      
    }

    event.preventDefault();

    });

 

	   $('#from_date').change(function(event){
	      let from_date = $(this).val();
          Display_All_Payment(from_date,$('#to_date').val(),$('#myInput1').val(),$('#status').val(),$('#top').val());       
	    event.preventDefault();
	   });

	   $('#to_date').change(function(event){
	      let to_date = $(this).val();
          Display_All_Payment($('#from_date').val(),to_date,$('#myInput1').val(),$('#status').val(),$('#top').val());       
	    event.preventDefault();
	   });

	   $('#top').change(function(event){
	      let top = $(this).val();
          Display_All_Payment($('#from_date').val(),$('#to_date').val(),$('#myInput1').val(),$('#status').val(),top);       
	    event.preventDefault();
	   });

	   $('#myInput1').change(function(event){
	      let myInput1 = $(this).val();
          Display_All_Payment($('#from_date').val(),$('#to_date').val(),myInput1,$('#status').val(),$('#top').val());       
	    event.preventDefault();
	   });

	  // Select All Checkbox
	   $('#select_all').change(function(event){
	     $('.select_record').prop("checked",$(this).prop("checked"));

	    event.preventDefault();
	   });
	   // $('#select_all').on('change',function(event){
	   //   $('.select_record').prop("checked",$(this).prop("checked"));
	   //   event.preventDefault();
	   // })

	   $('#excel_downlode_btn').click(function(){
	      var id = $('.select_record:checked').map(function(){
	         return $(this).val();
	      }).get().join(' ');
	      window.open('export_excel_all_payment_list.php?id='+id+'','_blank' );
	      
	   });

	   // Search All AppointMent
	    // $("#myInput1").on("keyup", function() {
	    //   // var value = $(this).val().toLowerCase();
	    //   // $("#data_ tr").filter(function() {
	    //   //   $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    //   // });
	    //    var Search_val = $(this).val();
	    //    if(Search_val !="")
	    //    {
	    //      Display_All_Payment(
	    //      	$('#from_date').val(),
		// 		$('#to_date').val(),
		// 		$('#myInput1').val(),
		// 		$('#status').val()
		// 		);
	    //    }
	    // });

  
		/////////////// BTN /////////////
   $(document).on('click','.status_update',function(event){
        
        var btn = $(this);
        var id = $(this).data('id');
        var val = $(this).data('val');

           swal({
			  title: "Are you sure?",
			  text: "Update Status",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			    $.ajax({
                      url : "<?= site_url()?>/"+$('#status_url').val()+"",
                      type : "POST",
                      data:{
                        id : id,
                        val : val
                      },
                      dataType : "json",
                      beforeSend : function(){
                         btn.html('Please wait...');
                         btn.attr('disabled',true);
                      },
                      success : function (data)
                      {
                         if(data.success)
                            {                   
                              Display_All_Payment(
								$('#from_date').val(),
								$('#to_date').val(),
								$('#myInput1').val(),
								$('#status').val(),
								$('#top').val()
								);
                              swal("Yah",data.message, "success");
                              btn.html('<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete');
                              btn.attr('disabled',false);

                             }
                             else
                             {
                              swal("Wrong",data.message, "error");
                              btn.html('<i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete');
                              btn.attr('disabled',false);
                             }
                      }

                    });
			  } 
			});
           


      event.preventDefault();
        
     });



	 /////////////// SELECT TAG
$(document).on('change','.select_tag',function(event){
        
        var id = $(this).find(':selected').data('id');
        var val = $(this).val();

           swal({
			  title: "Are you sure?",
			  text: "Update Status",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			    $.ajax({
                      url : "<?= site_url()?>/"+$('#select_url').val()+"",
                      type : "POST",
                      data:{
                        id : id,
                        val : val
                      },
                      dataType : "json",
                      success : function (data)
                      {
                         if(data.success)
                            {                   
                              Display_All_Payment(
								$('#from_date').val(),
								$('#to_date').val(),
								$('#myInput1').val(),
								$('#status').val(),
								$('#top').val()
								);
                              swal("Yah",data.message, "success");
                             }
                             else
                             {
                              swal("Wrong",data.message, "error");
                             }
                      }

                    });
			  } 
			});
           


      event.preventDefault();
        
     });


	//  //////////////////////. MODAL DATA REQUEST METHOD .//////////////////////

$(document).on('click','.Model_Data_show',function(event){
        
        var btn = $(this);
        var id = $(this).data('id');
		var url = $(this).data('url');

          
			    $.ajax({
                      url : "<?= site_url()?>/"+url+"",
                      type : "POST",
                      data:{
                        id : id,
                      },
                      dataType : "json",
                      beforeSend : function(){
                         btn.html('Wait...');
                         btn.attr('disabled',true);
                      },
                      success : function (data)
                      {
                         if(data.success)
                            {  
							  $('#follow_date').val(data.follow_date); 
							  $('#remark').val(data.remark);
							  $('#id').val(data.id);  
							  $('#access_id').val(data.access_id);                
                              $('#modal_form').modal('show');
                              btn.html('Update');
                              btn.attr('disabled',false);

                             }
                             else
                             {
                              
                              btn.html('Update');
                              btn.attr('disabled',false);
                             }
                      }

                    });

      event.preventDefault();
        
     });

// History SHOW
  
$(document).on('click','.History_show',function(event){
        
    var btn = $(this);
    var id = $(this).data('id');
		var url = $(this).data('url');

          
			    $.ajax({
                      url : "<?= site_url()?>/"+url+"",
                      type : "POST",
                      data:{
                        id : id,
                      },
                      dataType : "json",
                      beforeSend : function(){
                         btn.html('Wait...');
                         btn.attr('disabled',true);
                      },
                      success : function (data)
                      {
                         if(data.success)
                            {  
                              $('#data').html(data.message);          
                              $('#history_form').modal('show');
                              btn.html('History');
                              btn.attr('disabled',false);

                             }
                             else
                             {
                              
                              btn.html('History');
                              btn.attr('disabled',false);
                             }
                      }

                    });

      event.preventDefault();
        
     });

	 $('#Admin_login_form').parsley();
        $('#Admin_login_form').on('submit',function(event){
          if($('#Admin_login_form').parsley().validate())
          {
            $.ajax({
              url:"<?= site_url()?>/"+$('#modal_url').val()+"",
              method:"post",
              data : $(this).serialize(),
              dataType:"json",
              beforeSend:function()
              {
                $('#submit').val('Please Wait..');
                $('#submit').attr('disabled',true);
              },
              success:function(data)
              {
              if(data.success)
                  {
                    swal("Thankyou",data.message, "success");
					$('#modal_form').modal('hide');
                    Display_All_Payment(
					$('#from_date').val(),
					$('#to_date').val(),
					$('#myInput1').val(),
					$('#status').val()
					);
                    $('#submit').val('Submit');
                    $('#submit').attr('disabled',false);
                     
                  }
                   else
                   {
                      toastr.options = {
                        "closeButton": true,  // true or false
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,  // true or false
                        "rtl": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false, // true or false
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                     toastr["error"](data.message, "Message");
                     $('#submit').val('Submit');
                     $('#submit').attr('disabled',false);
                   }
              }
            });
          }
        event.preventDefault();
        });













	});
</script>