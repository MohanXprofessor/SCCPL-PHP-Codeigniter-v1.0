<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Groups</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('groups/') ?>">Groups</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="submit" onclick="errorSessionDestory();" class="close" data-dismiss="alert"
              aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="submit" onclick="errorSessionDestory();" class="close" data-dismiss="alert"
              aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit Group</h3>
          </div>
          <form role="form" action="<?php base_url('groups/update') ?>" method="post">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="group_name">Group Name</label>
                <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter group name"
                  value="<?php echo $group_data['group_name']; ?>">
              </div>
              <div class="form-group">
                <label for="permission">Permission</label>

                <?php $serialize_permission = unserialize($group_data['permission']); ?>

                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Create</th>
                      <th>Update</th>
                      <th>View</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Users</td>
                      <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal"
                          value="createUser" <?php if ($serialize_permission) {
                            if (in_array('createUser', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser"
                          <?php
                          if ($serialize_permission) {
                            if (in_array('updateUser', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser"
                          <?php
                          if ($serialize_permission) {
                            if (in_array('viewUser', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser"
                          <?php
                          if ($serialize_permission) {
                            if (in_array('deleteUser', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                    </tr>
                    <tr>
                      <td>Groups</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createGroup"
                          <?php
                          if ($serialize_permission) {
                            if (in_array('createGroup', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateGroup"
                          <?php
                          if ($serialize_permission) {
                            if (in_array('updateGroup', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewGroup"
                          <?php
                          if ($serialize_permission) {
                            if (in_array('viewGroup', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteGroup"
                          <?php
                          if ($serialize_permission) {
                            if (in_array('deleteGroup', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                    </tr>

                    <?php
                    /**
                     * @author Akash K. Fulari
                     * @date 25-04-2023 
                     * This is new functionality for documents module.
                     **/
                    ?>
                    <tr>
                      <td>Screening Test</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="createScreeningTest" <?php
                          if ($serialize_permission) {
                            if (in_array('createScreeningTest', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="updateScreeningTest" <?php
                          if ($serialize_permission) {
                            if (in_array('updateScreeningTest', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="viewScreeningTest" <?php
                          if ($serialize_permission) {
                            if (in_array('viewScreeningTest', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="deleteScreeningTest" <?php
                          if ($serialize_permission) {
                            if (in_array('deleteScreeningTest', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                    </tr>
                    <tr>
                      <td>Documents</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="createDocuments" <?php
                          if ($serialize_permission) {
                            if (in_array('createDocuments', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="updateDocuments" <?php
                          if ($serialize_permission) {
                            if (in_array('updateDocuments', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="viewDocuments" <?php
                          if ($serialize_permission) {
                            if (in_array('viewDocuments', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="deleteDocuments" <?php
                          if ($serialize_permission) {
                            if (in_array('deleteDocuments', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                    </tr>
                    <tr>
                      <td>My Batches</td>
                      <td>--</td>
                      <td>--</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="viewMyBatches" <?php
                          if ($serialize_permission) {
                            if (in_array('viewMyBatches', $serialize_permission)) {
                              echo "checked";
                            }
                          }
                          ?>></td>
                      <td>--</td>
                    </tr>
                    <tr>
                      <td>Courses</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createBrand"
                          <?php if ($serialize_permission) {
                            if (in_array('createBrand', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateBrand"
                          <?php if ($serialize_permission) {
                            if (in_array('updateBrand', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewBrand"
                          <?php if ($serialize_permission) {
                            if (in_array('viewBrand', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteBrand"
                          <?php if ($serialize_permission) {
                            if (in_array('deleteBrand', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Branch</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createStore"
                          <?php if ($serialize_permission) {
                            if (in_array('createStore', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateStore"
                          <?php if ($serialize_permission) {
                            if (in_array('updateStore', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewStore"
                          <?php if ($serialize_permission) {
                            if (in_array('viewStore', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteStore"
                          <?php if ($serialize_permission) {
                            if (in_array('deleteStore', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Batches</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="createProduct" <?php if ($serialize_permission) {
                            if (in_array('createProduct', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="updateProduct" <?php if ($serialize_permission) {
                            if (in_array('updateProduct', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProduct"
                          <?php if ($serialize_permission) {
                            if (in_array('viewProduct', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="deleteProduct" <?php if ($serialize_permission) {
                            if (in_array('deleteProduct', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Enrollment</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOrder"
                          <?php if ($serialize_permission) {
                            if (in_array('createOrder', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrder"
                          <?php if ($serialize_permission) {
                            if (in_array('updateOrder', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOrder"
                          <?php if ($serialize_permission) {
                            if (in_array('viewOrder', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOrder"
                          <?php if ($serialize_permission) {
                            if (in_array('deleteOrder', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Attendance</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createAttendance"
                          class="minimal" <?php if ($serialize_permission) {
                            if (in_array('createAttendance', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateAttendance"
                          class="minimal" <?php if ($serialize_permission) {
                            if (in_array('updateAttendance', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewAttendance"
                          class="minimal" <?php if ($serialize_permission) {
                            if (in_array('viewAttendance', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteAttendance"
                          class="minimal" <?php if ($serialize_permission) {
                            if (in_array('deleteAttendance', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                    </tr>
                    <!-- Added new Placement -->
                    <tr>
                      <td>JOB</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="createPlacement" <?php if ($serialize_permission) {
                            if (in_array('createPlacement', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="updatePlacement" <?php if ($serialize_permission) {
                            if (in_array('updatePlacement', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="viewPlacement" <?php if ($serialize_permission) {
                            if (in_array('viewPlacement', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="deletePlacement" <?php if ($serialize_permission) {
                            if (in_array('deletePlacement', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Reports</td>
                      <td> - </td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewReports"
                          <?php if ($serialize_permission) {
                            if (in_array('viewReports', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Organization</td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="updateCompany" <?php if ($serialize_permission) {
                            if (in_array('updateCompany', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td> - </td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Profile</td>
                      <td> - </td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProfile"
                          <?php if ($serialize_permission) {
                            if (in_array('viewProfile', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Setting</td>
                      <td>-</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal"
                          value="updateSetting" <?php if ($serialize_permission) {
                            if (in_array('updateSetting', $serialize_permission)) {
                              echo "checked";
                            }
                          } ?>></td>
                      <td> - </td>
                      <td> - </td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Update Changes</button>
              <a href="<?php echo base_url('groups/') ?>" class="btn btn-warning">Back</a>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function () {
    $("#mainGroupNav").addClass('active');
    $("#manageGroupNav").addClass('active');

    $('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
  });
</script>