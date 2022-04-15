<?php
$config = [
     'validate_client_form'=>[
          
          [
          	'field'=>'name',
          	'label'=>'<b>Name</b>',
          	'rules'=>'trim|required',
          	
          ],
          [
          	'field'=>'phone1',
          	'label'=>'<b>Phone 1</b>',
          	'rules'=>'trim|required'
          ],
          [
               'field'=>'phone2',
               'label'=>'<b>Phone 2</b>',
               'rules'=>'trim|required'
          ],
          [
               'field'=>'course',
               'label'=>'<b>Course</b>',
               'rules'=>'trim|required'
          ],
          [
               'field'=>'institute',
               'label'=>'<b>Institute</b>',
               'rules'=>'trim|required'
          ],
          [
               'field'=>'address',
               'label'=>'<b>Address</b>',
               'rules'=>'trim|required'
          ],
          [
               'field'=>'fees',
               'label'=>'<b>Fees Type</b>',
               'rules'=>'trim|required'
          ],
          [
               'field'=>'follow_date',
               'label'=>'<b>Follow Up Date</b>',
               'rules'=>'trim|required'
          ],
          [
               'field'=>'remark',
               'label'=>'<b>Remark</b>',
               'rules'=>'trim|required'
          ]
          

     ],

     'validate_admin_login'=>[
          
          [
               'field'=>'username',
               'label'=>'<b>UserName</b>',
               'rules'=>'trim|required',
               
          ],
          [
               'field'=>'password',
               'label'=>'<b>Password</b>',
               'rules'=>'trim|required'
          ]
     ],

     'validate_change_password'=>[

          [
               'field'=>'password',
               'label'=>'<b>Password</b>',
               'rules'=>'trim|required',
               
          ],
          [
               'field'=>'c_password',
               'label'=>'<b>Confirm Password</b>',
               'rules'=>'trim|required|matches[password]'
          ]

     ],
     'validate_sub_admin_form'=>[

          [
               'field'=>'name',
               'label'=>'<b>Name</b>',
               'rules'=>'trim|required',
               
          ],
          [
               'field'=>'username',
               'label'=>'<b>UserName</b>',
               'rules'=>'trim|required',
               
          ],
          [
               'field'=>'password',
               'label'=>'<b>Password</b>',
               'rules'=>'trim|required',
               
          ],
          [
               'field'=>'c_password',
               'label'=>'<b>Confirm Password</b>',
               'rules'=>'trim|required|matches[password]'
          ]

     ],
     'validate_institute_form'=>[

         [
               'field'=>'name',
               'label'=>'<b>Name</b>',
               'rules'=>'trim|required',
               
          ]
          
     ],
     'validate_client_followup_update_form'=>[
          [
               'field'=>'follow_date',
               'label'=>'<b>FollowUp Date</b>',
               'rules'=>'trim|required',
                    
          ],
          [
               'field'=>'remark',
               'label'=>'<b>Remark</b>',
               'rules'=>'trim|required',
                    
          ]  
     ]


];

?>