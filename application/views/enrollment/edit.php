<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Enrollment</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Enrollment</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

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
            <h3 class="box-title">Edit Enrollment</h3>
          </div>
          <!-- /.box-header -->


          <form role="form" method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="row">
                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class="control-label" style="text-align:left;"> Project</label>
                    <select name="project_id" type="text" class="form-control"
                      onchange='loadCourses(this, "#coursesAppender", "<?php echo $enrollment["course_id"]; ?>")'
                      id="projectCombo" required>
                      <option>Select Project</option>
                      <?php
                      $sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
                      $query = $this->db->query($sql, array(1));
                      $branch = $query->result_array();
                      foreach ($branch as $v) {
                        ?>
                        <option value="<?php echo $v['id']; ?>" <?php echo (($enrollment["project_id"] == $v['id']) ? "selected" : ""); ?>>
                          <?php echo $v['name']; ?>
                        </option>
                      <?php } ?>
                    </select>
                    <input type="hidden" name="id" value="<?php echo $enrollment['id'] ?>">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <div class="col-sm-12">
                      <label for="gross_amount" class="control-label" style="text-align:left;">Course</label>
                      <select name="course_id" type="text" class="form-control" id="coursesAppender" required>
                      </select>
                      <input type="hidden" name="id" value="<?php echo $enrollment['id'] ?>">
                    </div>
                  </div>
                </div>
              </div>



              <div class="row">
                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;"> Name</label>

                    <input type="text" class="form-control" id="customer_name" name="name"
                      placeholder="Enter Student Name" value="<?php echo $enrollment['name'] ?>" autocomplete="off">
                  </div>
                </div>



                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">Father Name</label>

                    <input type="text" class="form-control" id="father_name" name="father_name"
                      value="<?php echo $enrollment['father_name'] ?>" autocomplete="off">
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="paid_status">Gender: </label>
                  <select class="form-control" id="gender" name="gender" readonly>
                    <option value="0" <?php echo (($enrollment['gender'] == 0) ? "selected" : ""); ?>>Female</option>
                    <option value="1" <?php echo (($enrollment['gender'] == 1) ? "selected" : ""); ?>>Male</option>
                    <option value="2" <?php echo (($enrollment['gender'] == 2) ? "selected" : ""); ?>>Other</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">Address</label>

                    <input type="text" class="form-control" id="customer_address" name="address"
                      placeholder="Enter Student Address" value="<?php echo $enrollment['address'] ?>"
                      autocomplete="off">
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">Contact Number</label>

                    <input type="number" class="form-control" id="customer_phone" name="contact"
                      placeholder="Enter Customer Phone" value="<?php echo $enrollment['contact'] ?>"
                      autocomplete="off">
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">E-mail ID</label>

                    <input type="text" class="form-control" id="customer_gstin" name="email"
                      placeholder="Enter Student Email" value="<?php echo $enrollment['email'] ?>" autocomplete="off">


                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">College Name</label>

                    <input type="text" class="form-control" id="remark" name="college" placeholder="Enter College Name"
                      value="<?php echo $enrollment['college'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">Admission</label>

                    <input type="date" class="form-control" id="customer_gstin" name="admission" placeholder="Admission"
                      value="<?php echo $enrollment['admission'] ?>" autocomplete="off">
                  </div>
                </div>





                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">Education: </label> &nbsp;
                    &nbsp;

                    <input type="text" class="form-control" id="customer_name" name="education"
                      value="<?php echo $enrollment['education']; ?>" autocomplete="off">
                  </div>
                </div>


                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label" style="text-align:left;">Annual Income: </label>
                    &nbsp; &nbsp;

                    <input type="text" class="form-control" id="remark" name="annual_income"
                      value="<?php echo $enrollment['annual_income'] ?> " autocomplete="off">
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount">State : </label> &nbsp; &nbsp;
                    <input type="text" class="form-control" id="organization" name="state"
                      value="<?php echo $enrollment['state'] ?>" autocomplete="off"> &nbsp;
                    <!-- <input type="radio"  id="organization" name="organization"  <?php  //echo ($order_data['order']['organization']=='TCIL')? 'checked':'' ?>  value="TCIL" autocomplete="off">TCIL &nbsp;                   -->
                  </div>
                </div>




                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount">Adhar No : </label> &nbsp; &nbsp;
                    <input type="number" class="form-control" id="time" name="adhar_no"
                      value="<?php echo $enrollment['adhar'] ?>" autocomplete="off">
                  </div>
                </div>



                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount">10th Marks : </label> &nbsp; &nbsp;

                    <input type="number" class="form-control" id="time" name="tenth"
                      value="<?php echo $enrollment['10th'] ?>" autocomplete="off">
                  </div>
                </div>


                <!-- New added remark-->
                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="remark">12th Marks : </label> &nbsp; &nbsp;

                    <input type="number" class="form-control" id="remark" name="twelth"
                      value="<?php echo $enrollment['12th'] ?>" autocomplete="off">
                  </div>
                </div>



                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="discount" class=" control-label">Graduate Passing Year</label>

                    <input type="date" class="form-control" id="discount" name="graduation_passing"
                      placeholder="Graduate Passing" onkeyup="cal3()" onkeypress="return isNumber(event)"
                      value="<?php echo $enrollment['graduation_passing'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="col-sm-12">
                    <label for="gross_amount" class=" control-label">Graduation Marks</label>
                    <input type="number" class="form-control" id="gross_amount" name="graduation"
                      value="<?php echo $enrollment['graduation'] ?>" placeholder="Graduation Marks" autocomplete="off">
                    <!-- <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" value="<?php //echo $order_data['order']['gross_amount'] ?>" autocomplete="off"> -->
                  </div>
                </div>
              </div>

            </div>
        </div>
        <div class="container" style="margin-top: 10px;">
          <div class="row">
            <div class="col-lg-12" style="display:flex;gap:10px;">
              <div class="form-group col-md-3">
                <label for="paid_status">10th Certificate/Marksheet Upload: </label>

                <input type="file" name="tenth_certificate" class="form-control">

              </div>
              <div class="form-group col-md-3">
                <label for="paid_status">12th Certificate/Marksheet Upload: </label>

                <input type="file" name="twelth_certificate" class="form-control">

              </div>
              <div class="form-group col-md-3">
                <label for="paid_status">Income Certificate: </label>

                <input type="file" name="income" class="form-control">

              </div>
              <div class="form-group col-md-3">
                <label for="paid_status">Graduate Certificate: </label>

                <input type="file" name="graduate_certificate" class="form-control">

              </div>
            </div>
            <div class="col-lg-12" style="display:flex;gap:10px;margin-top:8px">
              <div class="form-group col-md-3">
                <label for="paid_status">Photograph: </label>

                <input type="file" name="photograph" class="form-control">

              </div>


              <div class="form-group col-md-3">
                <label for="paid_status">Aadhar Card: </label>

                <input type="file" name="adhar" class="form-control">

              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-primary" onclick="paidcal()">Save Changes</button>
        <a href="<?php echo base_url('enrollment/') ?>" class="btn btn-warning">Back</a>
      </div>

    </div>
    </form>


    <!-- /.box-body -->
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
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function () {
    loadSelectCourses("<?php echo $enrollment['project_id']; ?>", "#coursesAppender", "<?php echo $enrollment['course_id']; ?>");
    $(".select_group").select2();  // For select multiple array
    $('#chq_no').show();
    $('#pay_mode').change(function () {
      if ($('#pay_mode').val() == 'cheque') {
        $('#chq_no').show();

      } else {
        $('#chq_no').hide();

      }
    });
  }); // /document

  /*
   * Created By: Akash K. Fulari
   * On Date: 04-05-2024
   */
  function loadCourses(me, ele, selectValue) {
    loadSelectCourses(me.value, ele, selectValue);
  }
  function loadSelectCourses(val, ele, selectValue) {
    $.ajax({
      url: "<?php echo base_url('enquiry/loadCoursesByProjectId/') ?>" + val,
      type: "get",
      data: {},
      dataType: "json",
      success: function (res) {
        if (res.status) {
          $(ele).html(res.message);
          if (ele.indexOf(selectValue) > -1)
            $(ele).val(selectValue);
        } else {
          $(ele).html("<option>Please select course!</option>");
        }
      }
    });
  }


  //3-29-19 of for manual entry of rate then automatic rate calculate



  function cal() {
    var paid = document.getElementById("pay").value;

    var net_amt = document.getElementById("net_amount").value;

    var remain = Number(net_amt) - Number(paid);
    document.getElementById("remain").value = Number(remain);


  }


  function paidcal() {
    var paid = document.getElementById("paid").value
    var newpay = document.getElementById("npay").value;
    var tot = Number(paid) + Number(newpay);
    var net_amt = document.getElementById("net_amount").value;
    document.getElementById("pay").value = Number(tot);
    var remain = Number(net_amt) - Number(tot);
    document.getElementById("remain").value = Number(remain);


  }


  function ratecal() {

    var discount = $("#discount").val();
    var rate = document.getElementById("rate_1").value;

    document.getElementById("gross_amount").value = Number(rate);

    document.getElementById("amount_1").value = Number(rate);

    var grs = $("#gross_amount").val();
    document.getElementById("net_amount").value = Number(grs) - Number(discount);

    var paid = document.getElementById("paid").value


    var net = document.getElementById("net_amount").value;
    var pay = document.getElementById("npay").value;

    document.getElementById("remain").value = Number(net) - Number(pay) - Number(paid);
    // For Pay total set
    document.getElementById("pay").value = Number(paid) + Number(pay);

  }



  function cal3() {
    var totalAmount = $("#gross_amount").val();


    var paid = document.getElementById("paid").value;
    var pay = document.getElementById("npay").value;
    document.getElementById("pay").value = Number(paid) + Number(pay);
    var remain = Number(totalAmount) - Number(pay) - Number(paid);

    var discount = $("#discount").val();
    if (discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);
      var remain_final = grandTotal - pay - paid;
      $("#remain").val(remain_final);
      $("#net_amount").val(grandTotal);

    } else {
      $("#remain").val(remain);
      $("#net_amount").val(totalAmount);


    } // /else discount 


  }



  function isNumber(event) {
    var keyCode = event.keyCode;
    if (keyCode >= 48 && keyCode <= 57) {
      return true;
    }
    return false;
  }



  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }


</script>