 <div class="table-responsive">
                     <table class="table table-bordered">
                        <thead>
                           <tr>
                              <th>Employee ID No</th>
                              <th>First Name</th>
                              <th>Middle Name</th>
                              <th>Last Name</th>
                              <th>Biometric ID</th>
                              <th class="text-center">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                            <?php
                            $row = $this->Modules->user_list();
                            $data = $row->result();
                            foreach ($data as $key) {
                                ?>
                               <tr class="<?php echo ($key->user_status ? "bg-warning" : "bg-row") ?>">
                                  <td><?php echo $key->employee_id_no ?></td>
                                  <td><?php echo $key->first_name ?></td>
                                  <td><?php echo $key->last_name ?></td>
                                  <td><?php echo $key->employee_id_no ?></td>
                                  <td><?php echo $key->biometric_id ?></td>
                                  <td class="text-center" style="width: 130px">
                                     <button class="btn <?php echo ($key->user_status ? "btn-dafault" : "btn-danger") ?> btn-xs active-inactive" data-bind="<?php echo $key->ID ?>" data-status="<?php echo $key->user_status ?>" title="Deactivate"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>
                                     <button class="btn btn-info btn-xs uppass" title="Change Password" data-bind="<?php echo $key->ID ?>"><i class="fa fa-lock" aria-hidden="true"></i></button>
                                     <a href="<?php echo site_url('update/id/' . $key->ID) ?>" class="btn btn-primary btn-xs" title="View Info"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                  </td>
                               </tr>
                               <?php
                           }
                           ?>
                        </tbody>
                     </table>
                  </div>