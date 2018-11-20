<?php
$pages = ($this->uri->segment(3) ? $this->uri->segment(3) : '1');
$row_count = $this->Modules->count_users();
$count_data = $row_count->result();

$search = $this->input->get('Search');

foreach ($count_data as $key_count) {
    $total = $key_count->count;
}
?>

<div class="container ">
   <div class="panel">
      <div class="panel-body">
         <p class="bigcaption">Employee List</>
         <form method="get">
            <div style="white-space:nowrap !important; float: right ;padding:10px;word-wrap: break-word; vertical-align: top!important;">
               <div class="input-group" >
                  <a class="btn btn-success add-user" style="text-decoration: none !important;"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;&nbsp;
                  <input type="text" class="form-control search-form" placeholder="Search" id="Search" name="Search" placeholder="Search" style="width:300px;" value="<?php echo $search; ?>">
                  <!--DO NOT NEED TRAILING SLASH "/" As HTML5 FORMS SLASHES ARE NO LONGER REQUIRED--> <span class="input-group-btn"><button type="submit" class="btn btn-primary search-btn" type="submit" data-target="#search-form" name="q"><i class="fa fa-search"></i>
                     </button></span>
               </div>
            </div>
         </form>
         <table id="list" class="table table-striped table-bordered" cellspacing="0" width="100%" >
            <thead>
               <tr style=" border-bottom : none!important">
                  <th>#</th>
                  <th>Name</th>
                  <th>Employee ID</th>
                  <th>Department</th>
                  <th>Email Address</th>
                  <th>Location</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
                <?php
                $set_val = 50;
                $to = $pages * $set_val;
                $from = $to - $set_val + 1;
                $count = 0;
                $row = $this->Modules->user_list_w_page($from, $to, $search);
                $data = $row->result();
                foreach ($data as $key) {
                  $count++;
                  ?>
                   <tr>
                      <td style="heigt"><?php echo $key->nowef; ?></td>
                      <td class="fname_<?php echo $key->ID; ?>"><?php echo $key->first_name . " " . $key->last_name; ?></td>
                      <td class="employee_no_<?php echo $key->ID; ?>"><?php echo $key->employee_id_no; ?></td>
                      <td class="department_<?php echo $key->ID; ?>"><?php echo $key->department; ?></td>
                      <td class="email_<?php echo $key->ID; ?>"><?php echo $key->email; ?></td>
                      <td class="location_<?php echo $key->ID; ?>"><?php echo $key->location; ?></td>
                      <td>
                         <div class="btn-group btn-group-xs actionbtn">
                            <button class="btn btn-primary edit-user btn-sm" data-id="<?php echo $key->ID; ?>"><i class="fa fa-edit"></i></button>
                            <a class="btn btn-success btn-xs btn-sm tag-group-user" href="<?php echo $key->ID; ?>"><i class="fas fa-tags"></i></a>
                            <button class="btn btn-danger btn-xs delete-profile btn-sm" data-id="<?php echo $key->ID; ?>"><i class="fa fa-trash"></i></button>
                         </div>
                      </td>
                   </tr>
                   <?php
                      }
                   ?>
            </tbody>
         </table>
      </div>
      <div  style=" text-align: right;">
         <div class="pagination_new"><?php echo $this->Modules->pagination($set_val, $pages, $total); ?> &nbsp;</div>
      </div>
      <br>

   </div>

   <div class="modal  modal_deletet_confirmation modal-small" >
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-body" >


               <div class="modal-body">
                  <p>Are you sure you want delete this record?</p>
               </div>
               <div class="modal-footer">
                  <input type="hidden" class="delete_id_value" name="delete_id_value">
                  <button type="button" class="btn btn-danger delete-user-record" data-dismiss="modal">Ok</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
   <div class="modal  modal-view-user modal-large" >
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-body" >
               <a href="#close" class="close"><i class="fa fa-times"></i></a>
               <div class="wrapper_modal">
                  <form class="reg-form"  method="">
                     <p class="bigcaption">Employee Record</>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Employee ID No </label>
                           <input type="text" class="form-control" name="employee_id_no">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">First Name </label>
                           <input type="text" class="form-control" name="first_name">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Middle Name</label>
                           <input type="text" class="form-control" name="middle_name">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Last Name </label>
                           <input type="text" class="form-control" name="last_name">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-4 form-group">
                           <label  class=" labelcaption">Gender </label>
                           <select class="form-control" name="gender">
                              <option value="">Select Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                           </select>
                        </div>
                        <div class="col-4 form-group">
                           <label  class=" labelcaption">Civil Status</label>
                           <select class="form-control" name="civil_status">
                              <option value="">Select Status</option>
                              <option value="Single">Single</option>
                              <option value="Married">Married</option>
                              <option value="Widowed">Widowed</option>
                              <option value="Divorced">Divorced</option>
                           </select>
                        </div>





                        <div class="col-4 form-group">
                           <label  class=" labelcaption">Date Of Birth </label>
                           <div class="date" data-provide="datepicker" data-date-show-on-focus="false">
                              <input type="text" class="form-control date_picker_bootstrap datetimepicker1 date1" name="date_of_birth" placeholder="MM/DD/YYYY"  name="date1">
                              <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-th"></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Contact</label>
                           <input type="text" class="form-control" name="contact">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Permanent Address </label>
                           <input type="text" class="form-control" name="permanent_address">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Current Address </label>
                           <input type="text" class="form-control" name="current_address">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Email </label>
                           <input type="text" class="form-control" name="email">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Department </label>
                           <input type="text" class="form-control" name="department">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Client Name </label>
                           <input type="text" class="form-control" name="client_name">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Segment </label>
                           <input type="text" class="form-control" name="segment">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Department ID</label>
                           <input type="text" class="form-control" name="department_id">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Location</label>
                           <input type="text" class="form-control" name="location">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Site</label>
                           <input type="text" class="form-control" name="site">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Job Code</label>
                           <input type="text" class="form-control" name="job_code">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Job Title</label>
                           <input type="text" class="form-control" name="job_title">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Job Level/Grade</label>
                           <input type="text" class="form-control" name="job_level_grade">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Payroll Type</label>
                           <input type="text" class="form-control" name="payroll_type">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Employee Type</label>
                           <input type="text" class="form-control" name="employee_type">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Employment Status </label>
                           <input type="text" class="form-control" name="employment_status">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">HR Status</label>
                           <input type="text" class="form-control" name="hr_status">
                        </div>
                        <div class="col-3 form-group">
                           <label  class="labelcaption">Hire Date </label>

                           <input type="text" class="form-control  date1" name="hire_date" placeholder="MM/DD/YYYY">

                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Regularization Date</label>

                           <input type="text" class="form-control date1" name="regularization_date" placeholder="MM/DD/YYYY">

                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Separation Date</label>

                           <input type="text" class="form-control  date1" name="separation_date" placeholder="MM/DD/YYYY">

                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">General Reason</label>
                           <input type="text" class="form-control" name="general_reason">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Specific Reason</label>
                           <input type="text" class="form-control" name="specific_reason">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Voluntary/Involuntary</label>
                           <input type="text" class="form-control" name="voluntary_involuntary">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Biometric ID </label>
                           <input type="text" class="form-control" name="biometric_id">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Reports To Employee ID No </label>
                           <input type="text" class="form-control" name="reports_to_employee_id_no">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Second Level Supervisor</label>
                           <input type="text" class="form-control" name="second_level_supervisor">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Billability</label>
                           <input type="text" class="form-control" name="billability">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Employee Remarks </label>
                           <input type="text" class="form-control" name="employee_remarks">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Schedule Type </label>
                           <input type="text" class="form-control" name="schedule_type">
                        </div>


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Payroll Pie ID </label>
                           <input type="text" class="form-control" name="payroll_pie_id">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Highest Education Attainment </label>
                           <input type="text" class="form-control" name="highest_education_attainment">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">College Degree </label>
                           <input type="text" class="form-control" name="college_degree">
                        </div>

                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Major </label>
                           <input type="text" class="form-control" name="major">
                        </div>


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Institution </label>
                           <input type="text" class="form-control" name="institution">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Prior Work Experience </label>
                           <input type="text" class="form-control" name="prior_work_experience">
                        </div>


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Previous Employer </label>
                           <input type="text" class="form-control" name="previous_employer">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Type of Industry </label>
                           <input type="text" class="form-control" name="type_of_industry">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">PRC License No </label>
                           <input type="text" class="form-control" name="prc_license_no">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">SSS No </label>
                           <input type="text" class="form-control" name="sss_no">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">TIN No </label>
                           <input type="text" class="form-control" name="tin_no">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">PhilHealth No </label>
                           <input type="text" class="form-control" name="philhealth_no">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">PAG IBIG No </label>
                           <input type="text" class="form-control" name="pag_ibig_no">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Passport No </label>
                           <input type="text" class="form-control" name="passport_no">
                        </div>


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Tax Status </label>
                           <input type="text" class="form-control" name="tax_status">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Local Trunk Line </label>
                           <input type="text" class="form-control" name="local_trunk_line">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Local Trunk Line Pin </label>
                           <input type="text" class="form-control" name="local_trunk_line_pin">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Local Trunk Line </label>
                           <input type="text" class="form-control" name="local_trunk_line">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Local Trunk Line Pin </label>
                           <input type="text" class="form-control" name="local_trunk_line_pin">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Skype ID </label>
                           <input type="text" class="form-control" name="skype_id">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Emergency Contact Name </label>
                           <input type="text" class="form-control" name="emergency_contact_name">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Emergency Contact No </label>
                           <input type="text" class="form-control" name="emergency_contact_no">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Emergency Contact Relationship </label>
                           <input type="text" class="form-control" name="emergency_contact_relationship">
                        </div>

                     </div>
                     <div class="row">


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Bank name </label>
                           <input type="text" class="form-control" name="bank_name">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Bank Account No </label>
                           <input type="text" class="form-control" name="bank_account_no">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Emergency Contact Address </label>
                           <input type="text" class="form-control" name="emergency_contact_address">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Bank name </label>
                           <input type="text" class="form-control" name="bank_name">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Basic Salary </label>
                           <input type="text" class="form-control" name="basic_salary">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Deminimis </label>
                           <input type="text" class="form-control" name="deminimis">
                        </div>

                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Transportation Allowance </label>
                           <input type="text" class="form-control" name="transportation_allowance">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Travel Allowance </label>
                           <input type="text" class="form-control" name="travel_allowance">
                        </div>



                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Other Allowance </label>
                           <input type="text" class="form-control" name="other_allowance">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">User Level </label>




                           <select class="form-control" name="user_level">
                              <option value="">-Select-</option>
                              <option value="1">User</option>
                              <option value="2">Client</option>
                              <option value="3">Management</option>
                              <option value="4">Administrator</option>
                           </select>

                        </div>
                        <div class="col-12 text-right">
                           <div class="ln_solid"></div>
                        </div>
                        <div class="col-12 text-right">
                           <button type="submit" class="btn btn-success">Save</button>
                        </div>

                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal  modal_edit_user modal-large" >
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-body" >
               <a href="#close" class="close"><i class="fa fa-times"></i></a>
               <div class="wrapper_modal">
                  <form class="update-reg-form"  method="post">
                     <p class="bigcaption">Employee Record</p>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Employee ID No </label>
                           <input type="hidden" class="mainid" name="mainid">
                           <input type="text" class="form-control emp_no" name="employee_id_no">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">First Name </label>
                           <input type="text" class="form-control first_name" name="first_name">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Middle Name</label>
                           <input type="text" class="form-control middle_name" name="middle_name">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Last Name </label>
                           <input type="text" class="form-control last_name" name="last_name">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-4 form-group">
                           <label  class=" labelcaption">Gender </label>
                           <div class="id_100">
                              <select class="form-control gender" name="gender">
                                 <option value="">Select Gender</option>
                                 <option value="Male">Male</option>
                                 <option value="Female">Female</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-4 form-group ">
                           <label  class=" labelcaption">Civil Status</label>

                           <select class="form-control civil_status " name="civil_status">
                              <option value="">Select Status</option>
                              <option value="Single">Single</option>
                              <option value="Married">Married</option>
                              <option value="Widowed">Widowed</option>
                              <option value="Divorced">Divorced</option>
                           </select>

                        </div>
                        <div class="col-4 form-group">
                           <label  class=" labelcaption">Date Of Birth </label>

                           <input type="text" class="form-control date_of_birth date2" name="date_of_birth" placeholder="MM/DD/YYYY">

                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Contact</label>
                           <input type="text" class="form-control contact" name="contact">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Permanent Address </label>
                           <input type="text" class="form-control permanent_address " name="permanent_address">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Current Address </label>
                           <input type="text" class="form-control current_address " name="current_address">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Email </label>
                           <input type="text" class="form-control email " name="email">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Department </label>
                           <input type="text" class="form-control department " name="department">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Client Name </label>
                           <input type="text" class="form-control client_name " name="client_name">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Segment </label>
                           <input type="text" class="form-control segment " name="segment">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Department ID</label>
                           <input type="text" class="form-control department_id " name="department_id">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Location</label>
                           <input type="text" class="form-control location " name="location">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Site</label>
                           <input type="text" class="form-control site " name="site">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Job Code</label>
                           <input type="text" class="form-control job_code " name="job_code">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Job Title</label>
                           <input type="text" class="form-control job_title " name="job_title">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Job Level/Grade</label>
                           <input type="text" class="form-control job_level_grade " name="job_level_grade">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Payroll Type</label>
                           <input type="text" class="form-control payroll_type " name="payroll_type">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Employee Type</label>
                           <input type="text" class="form-control employee_type " name="employee_type">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Employment Status </label>
                           <input type="text" class="form-control employment_status " name="employment_status">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">HR Status</label>
                           <input type="text" class="form-control hr_status " name="hr_status">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Hire Date </label>

                           <input type="text" class="form-control hire_date  date1" name="hire_date" placeholder="MM/DD/YYYY">

                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Regularization Date</label>

                           <input type="text" class="form-control regularization_date  date1" name="regularization_date" placeholder="MM/DD/YYYY">

                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Separation Date</label>

                           <input type="text" class="form-control seperation_dates date1" name="separation_date" placeholder="MM/DD/YYYY">

                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">General Reason</label>
                           <input type="text" class="form-control general_reason " name="general_reason">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Specific Reason</label>
                           <input type="text" class="form-control specific_reason " name="specific_reason">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Voluntary/Involuntary</label>
                           <input type="text" class="form-control voluntary_involuntary " name="voluntary_involuntary">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Biometric ID </label>
                           <input type="text" class="form-control biometric_id" name="biometric_id">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Reports To Employee ID No </label>
                           <input type="text" class="form-control reports_to_employee_id_no" name="reports_to_employee_id_no">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Second Level Supervisor</label>
                           <input type="text" class="form-control second_level_supervisor" name="second_level_supervisor">
                        </div>

                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Billability</label>
                           <input type="text" class="form-control bilability" name="billability">
                        </div>
                        <div class="col-3 form-group">
                           <label  class=" labelcaption">Employee Remarks </label>
                           <input type="text" class="form-control employee_remarks" name="employee_remarks">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Schedule Type </label>
                           <input type="text" class="form-control schedule_type" name="schedule_type">
                        </div>


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Payroll Pie ID </label>
                           <input type="text" class="form-control payroll_pre_id" name="payroll_pie_id">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Highest Education Attainment </label>
                           <input type="text" class="form-control highest_education_attainment  " name="highest_education_attainment">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">College Degree </label>
                           <input type="text" class="form-control college_degree" name="college_degree">
                        </div>

                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Major </label>
                           <input type="text" class="form-control major" name="major">
                        </div>


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Institution </label>
                           <input type="text" class="form-control institution" name="institution">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Prior Work Experience </label>
                           <input type="text" class="form-control prior_work_expirience " name="prior_work_experience">
                        </div>


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Previous Employer </label>
                           <input type="text" class="form-control previous_employer " name="previous_employer">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Type of Industry </label>
                           <input type="text" class="form-control type_of_industry " name="type_of_industry">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">PRC License No </label>
                           <input type="text" class="form-control prc_license " name="prc_license_no">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">SSS No </label>
                           <input type="text" class="form-control sss_no " name="sss_no">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">TIN No </label>
                           <input type="text" class="form-control tin_no " name="tin_no">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">PhilHealth No </label>
                           <input type="text" class="form-control philhealth_no " name="philhealth_no">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">PAG IBIG No </label>
                           <input type="text" class="form-control pag_ibig_no " name="pag_ibig_no">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Passport No </label>
                           <input type="text" class="form-control passport_no " name="passport_no">
                        </div>


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Tax Status </label>
                           <input type="text" class="form-control tax_status " name="tax_status">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Local Trunk Line </label>
                           <input type="text" class="form-control local_trunk_line " name="local_trunk_line">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Local Trunk Line Pin </label>
                           <input type="text" class="form-control local_trunk_line_pin " name="local_trunk_line_pin">
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Skype ID </label>
                           <input type="text" class="form-control skype_id " name="skype_id">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Emergency Contact Name </label>
                           <input type="text" class="form-control emergency_contact_name " name="emergency_contact_name">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Emergency Contact No </label>
                           <input type="text" class="form-control emergency_contact_no " name="emergency_contact_no">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Emergency Contact Relationship </label>
                           <input type="text" class="form-control emergency_contact_relationship " name="emergency_contact_relationship">
                        </div>

                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Emergency Contact Address </label>
                           <input type="text" class="form-control emergency_contact_address " name="emergency_contact_address">
                        </div>

                        <div class="col-6 form-group">
                           <label  class=" labelcaption">User Status </label>
                           <input type="text" class="form-control user_level  " name="user_level">
                        </div>
                     </div>
                     <div class="row">


                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Bank name </label>
                           <input type="text" class="form-control bank_account_no " name="bank_name">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Bank Account No </label>
                           <input type="text" class="form-control bank_account_no " name="bank_account_no">
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Basic Salary </label>
                           <input type="text" class="form-control basic_salary " name="basic_salary">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Deminimis </label>
                           <input type="text" class="form-control deminimis " name="deminimis">
                        </div>

                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Transportation Allowance </label>
                           <input type="text" class="form-control transportation_allowance " name="transportation_allowance">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Travel Allowance </label>
                           <input type="text" class="form-control travel_allowance " name="travel_allowance">
                        </div>



                     </div>
                     <div class="row">
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">Other Allowance </label>
                           <input type="text" class="form-control other_allowance " name="other_allowance">
                        </div>
                        <div class="col-6 form-group">
                           <label  class=" labelcaption">User Level </label>
                           <select class="form-control user_level " name="user_level">
                              <option value="">-Select-</option>
                              <option value="1">User</option>
                              <option value="2">Client</option>
                              <option value="3">Admin Editor</option>
                              <option value="4">Administrator</option>
                           </select>

                        </div>

                     </div>
                     <div class="row">
                        <div class="col-12 text-right">
                           <div class="ln_solid"></div>
                        </div>
                        <div class="col-12 text-right">
                           <button type="submit" class="btn btn-success">Update</button>
                        </div>

                     </div>
                  </form>
               </div>
               <div class="progress hide progress-upload">
                  <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 1%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
               </div>
            </div>
         </div>
      </div>
   </div>

<div class="modal modal-tag modal-medium">
   <div class="modal-dialog" role="document">
      <div class="modal-content tag-form">
         <a href="#close" class="close"><i class="fa fa-times"></i></a>
         <div class="modal-body ">
            <div class="form-group">

               <input type="hidden" class="hide id-tag-group" name="get_id"  />
               <div class="tag-options">
                  <span class="span-tag"></span>
                  <div class="tag-selector"><input type="text" class="tag-input" placeholder="Type and select group name"/></div>
                  <div class="selected-option">
                     <ul class="hide"></ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
