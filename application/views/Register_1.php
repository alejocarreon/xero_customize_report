<div class="wrapper">
    <div class="panel-body">
        <h2>Register Employee</h2>
        <div class="container main-container">

            <form class="reg-form"  method="post">

                <div class="row">
                    <div class="col-3 form-group">
                        <label>Employee ID No </label>
                        <input type="text" class="form-control" name="employee_id_no">
                    </div>

                    <div class="col-3 form-group">
                        <label>First Name </label>
                        <input type="text" class="form-control" name="first_name">
                    </div>
                    <div class="col-3 form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="middle_name">
                    </div>
                    <div class="col-3 form-group">
                        <label>Last Name </label>
                        <input type="text" class="form-control" name="last_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 form-group">
                        <label>Gender </label>
                        <select class="form-control" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-4 form-group">
                        <label>Civil Status</label>
                        <select class="form-control" name="civil_status">
                            <option value="">Select Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Divorced">Divorced</option>
                        </select>
                    </div>
                    <div class="col-4 form-group">
                        <label>Date Of Birth </label>             
                        <div class='input-group date normal_datepicker'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <input type="text" class="form-control" name="date_of_birth" placeholder="MM/DD/YYYY">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 form-group">
                        <label>Contact</label>
                        <input type="text" class="form-control" name="contact">
                    </div>
                    <div class="col-3 form-group">
                        <label>Permanent Address </label>
                        <input type="text" class="form-control" name="permanent_address">
                    </div>

                    <div class="col-3 form-group">
                        <label>Current Address </label>
                        <input type="text" class="form-control" name="current_address">
                    </div>
                    <div class="col-3 form-group">
                        <label>Email </label>
                        <input type="text" class="form-control" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 form-group">
                        <label>Department </label>
                        <input type="text" class="form-control" name="department">
                    </div>
                    <div class="col-3 form-group">
                        <label>Client Name </label>
                        <input type="text" class="form-control" name="client_name">
                    </div>
                    <div class="col-3 form-group">
                        <label>Segment </label>
                        <input type="text" class="form-control" name="segment">
                    </div>

                    <div class="col-3 form-group">
                        <label>Department ID</label>
                        <input type="text" class="form-control" name="department_id">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location">
                    </div>
                    <div class="col-3 form-group">
                        <label>Site</label>
                        <input type="text" class="form-control" name="site">
                    </div>
                    <div class="col-3 form-group">
                        <label>Job Code</label>
                        <input type="text" class="form-control" name="job_code">
                    </div>
                    <div class="col-3 form-group">
                        <label>Job Title</label>
                        <input type="text" class="form-control" name="job_title">
                    </div> 
                </div>
                <div class="row">
                    <div class="col-3 form-group">
                        <label>Job Level/Grade</label>
                        <input type="text" class="form-control" name="job_level_grade">
                    </div>
                    <div class="col-3 form-group">
                        <label>Payroll Type</label>
                        <input type="text" class="form-control" name="payroll_type">
                    </div>
                    <div class="col-3 form-group">
                        <label>Employee Type</label>
                        <input type="text" class="form-control" name="employee_type">
                    </div>
                    <div class="col-3 form-group">
                        <label>Employment Status </label>
                        <input type="text" class="form-control" name="employment_status">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 form-group">
                        <label>HR Status</label>
                        <input type="text" class="form-control" name="hr_status">
                    </div>
                    <div class="col-3 form-group">
                        <label>Hire Date </label>
                        <div class='input-group date normal_datepicker'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <input type="text" class="form-control" name="hire_date" placeholder="MM/DD/YYYY">
                        </div>
                    </div>
                    <div class="col-3 form-group">
                        <label>Regularization Date</label>
                        <div class='input-group date normal_datepicker' id='myDatepicker'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <input type="text" class="form-control" name="regularization_date" placeholder="MM/DD/YYYY">
                        </div>
                    </div>

                    <div class="col-3 form-group">
                        <label>Separation Date</label>
                        <div class='input-group date normal_datepicker' id='myDatepicker'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <input type="text" class="form-control " name="separation_date" placeholder="MM/DD/YYYY">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 form-group">
                        <label>General Reason</label>
                        <input type="text" class="form-control" name="general_reason">
                    </div>

                    <div class="col-3 form-group">
                        <label>Specific Reason</label>
                        <input type="text" class="form-control" name="specific_reason">
                    </div>

                    <div class="col-3 form-group">
                        <label>Voluntary/Involuntary</label>
                        <input type="text" class="form-control" name="voluntary_involuntary">
                    </div>

                    <div class="col-3 form-group">
                        <label>Biometric ID </label>
                        <input type="text" class="form-control" name="biometric_id">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 form-group">
                        <label>Reports To Employee ID No </label>
                        <input type="text" class="form-control" name="reports_to_employee_id_no">
                    </div>

                    <div class="col-3 form-group">
                        <label>Second Level Supervisor</label>
                        <input type="text" class="form-control" name="second_level_supervisor">
                    </div>

                    <div class="col-3 form-group">
                        <label>Billability</label>
                        <input type="text" class="form-control" name="billability">
                    </div>
                    <div class="col-3 form-group">
                        <label>Employee Remarks </label>
                        <input type="text" class="form-control" name="employee_remarks">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Schedule Type </label>
                        <input type="text" class="form-control" name="schedule_type">
                    </div>


                    <div class="col-6 form-group">
                        <label>Payroll Pie ID </label>
                        <input type="text" class="form-control" name="payroll_pie_id">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Highest Education Attainment </label>
                        <input type="text" class="form-control" name="highest_education_attainment">
                    </div>

                    <div class="col-6 form-group">
                        <label>College Degree </label>
                        <input type="text" class="form-control" name="college_degree">
                    </div>

                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Major </label>
                        <input type="text" class="form-control" name="major">
                    </div>


                    <div class="col-6 form-group">
                        <label>Institution </label>
                        <input type="text" class="form-control" name="institution">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Prior Work Experience </label>
                        <input type="text" class="form-control" name="prior_work_experience">
                    </div>


                    <div class="col-6 form-group">
                        <label>Previous Employer </label>
                        <input type="text" class="form-control" name="previous_employer">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Type of Industry </label>
                        <input type="text" class="form-control" name="type_of_industry">
                    </div>

                    <div class="col-6 form-group">
                        <label>PRC License No </label>
                        <input type="text" class="form-control" name="prc_license_no">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>SSS No </label>
                        <input type="text" class="form-control" name="sss_no">
                    </div>

                    <div class="col-6 form-group">
                        <label>TIN No </label>
                        <input type="text" class="form-control" name="tin_no">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>PhilHealth No </label>
                        <input type="text" class="form-control" name="philhealth_no">
                    </div>

                    <div class="col-6 form-group">
                        <label>PAG IBIG No </label>
                        <input type="text" class="form-control" name="pag_ibig_no">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Passport No </label>
                        <input type="text" class="form-control" name="passport_no">
                    </div>


                    <div class="col-6 form-group">
                        <label>Tax Status </label>
                        <input type="text" class="form-control" name="tax_status">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Local Trunk Line </label>
                        <input type="text" class="form-control" name="local_trunk_line">
                    </div>

                    <div class="col-6 form-group">
                        <label>Local Trunk Line Pin </label>
                        <input type="text" class="form-control" name="local_trunk_line_pin">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Local Trunk Line </label>
                        <input type="text" class="form-control" name="local_trunk_line">
                    </div>

                    <div class="col-6 form-group">
                        <label>Local Trunk Line Pin </label>
                        <input type="text" class="form-control" name="local_trunk_line_pin">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Skype ID </label>
                        <input type="text" class="form-control" name="skype_id">
                    </div>
                    <div class="col-6 form-group">
                        <label>Emergency Contact Name </label>
                        <input type="text" class="form-control" name="emergency_contact_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Emergency Contact No </label>
                        <input type="text" class="form-control" name="emergency_contact_no">
                    </div>
                    <div class="col-6 form-group">
                        <label>Emergency Contact Relationship </label>
                        <input type="text" class="form-control" name="emergency_contact_relationship">
                    </div>

                </div>
                <div class="row">
                    

                    <div class="col-6 form-group">
                        <label>Bank name </label>
                        <input type="text" class="form-control" name="bank_name">
                    </div>
                       <div class="col-6 form-group">
                                                        <label>Bank Account No </label>
                                                        <input type="text" class="form-control" name="bank_account_no">
                                                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label>Emergency Contact Address </label>
                        <input type="text" class="form-control" name="emergency_contact_address">
                    </div>

                    <div class="col-6 form-group">
                        <label>Bank name </label>
                        <input type="text" class="form-control" name="bank_name">
                    </div>
                </div>
                <div class="row">
                         <div class="col-6 form-group">
                                                        <label>Basic Salary </label>
                                                        <input type="text" class="form-control" name="basic_salary">
                                                    </div>
                    <div class="col-6 form-group">
                        <label>Deminimis </label>
                        <input type="text" class="form-control" name="deminimis">
                    </div>
                   
                </div>
                <div class="row">
                     <div class="col-6 form-group">
                        <label>Transportation Allowance </label>
                        <input type="text" class="form-control" name="transportation_allowance">
                    </div>
                    <div class="col-6 form-group">
                        <label>Travel Allowance </label>
                        <input type="text" class="form-control" name="travel_allowance">
                    </div>

                  

                </div>
                <div class="row">
                      <div class="col-6 form-group">
                        <label>Other Allowance </label>
                        <input type="text" class="form-control" name="other_allowance">
                    </div>
                    <div class="col-6 form-group">
                        <label>User Level </label>
                        <input type="text" class="form-control" name="user_level">
                    </div>
                    <div class="col-12 text-right">
                        <div class="ln_solid"></div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
<div class="hide">
    <textarea placeholder="Post announcement here..." class="post-announcement" style="height: 100px;margin-bottom: 15px;" id="post-announcement" class="form-control"></textarea>
</div>
