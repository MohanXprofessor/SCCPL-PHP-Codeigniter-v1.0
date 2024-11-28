<?php
$this->db->select("*");
$this->db->from("categories");
$category_data = $this->db->get();

//For BRANCH 13/4/19 RMZ 
$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$branch = $query->result_array();


// $this->db->select("*");
// $this->db->from("brands");
// $bp=$this->db->get();
// foreach ($bp as $value) {
//   echo $value->rate;
// }


$sql = "SELECT * FROM brands";
$query = $this->db->query($sql);
$brandp = $query->result_array();

?>

<?php
$this->db->select("*");
$this->db->from("attribute_value");
$this->db->where('attribute_parent_id', '2');
$attr_bute = $this->db->get();
?>


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
            <h3 class="box-title">Add Enrollment</h3>
          </div>
          <!-- /.box-header -->

          <form role="form" action="<?php base_url('enrollment/create') ?>" method="post" class="form-horizontal"
            enctype="multipart/form-data">
            <div class="box-body">

              <?php if (validation_errors()) { ?>
                <div class="alert alert-error alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                      aria-hidden="true">&times;</span></button>
                  <?php echo validation_errors(); ?>
                </div>
              <?php } ?>



              <div class="row" style="padding: 0px 15px 0px 15px; display:block; gap:0px;">

                <div class="col-12" style="display:flex; gap:20px;">
                  <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-group">
                      <label for="gross_amount">
                        Project
                      </label>
                      <select name="project_id" type="text" class="form-control select_group"
                        onchange='loadCourses(this, "#coursesAppender", "<?php echo $edata["course_id"]; ?>")'
                        id="projectCombo" required readonly>
                        <option>Select Project</option>
                        <?php
                        $sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
                        $query = $this->db->query($sql, array(1));
                        $branch = $query->result_array();
                        foreach ($branch as $v) {
                        ?>
                          <option value="<?php echo $v['id']; ?>" <?php echo (($edata['project_id'] == $v['id']) ? "selected" : ""); ?>>
                            <?php echo $v['name']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-group">
                      <label for="gross_amount">
                        Course
                      </label>
                      <select name="course_id" type="text" class="form-control select_group" id="coursesAppender"
                        required readonly>
                      </select>
                    </div>
                  </div>
                </div>



                <div class="col-12 col-md-12 col-lg-12">

                  <div class="form-group">
                    <label for="gross_amount">Full Name:</label>
                    <input type="text" class="form-control" id="customer_name" name="name"
                      value="<?php echo $edata['student_name'] ?>" placeholder="Enter Student Name"
                      autocomplete="off" />
                  </div>

                </div>
              </div>


              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="gross_amount">Father Name :</label>
                    <input type="text" class="form-control" id="customer_phone" name="father_name"
                      placeholder="Enter Father Name" autocomplete="off" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="gross_amount">Mother Name: </label>
                    <input type="text" class="form-control" id="customer_phone" name="mother_name"
                      placeholder="Enter Mother Name" autocomplete="off" />
                  </div>
                </div>

              </div>


              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="paid_status">Gender: </label>
                    <select class="form-control" id="gender" name="gender" readonly>
                      <option value="0" <?php echo (($edata['gender'] == 0) ? "selected" : ""); ?>>Female</option>
                      <option value="1" <?php echo (($edata['gender'] == 1) ? "selected" : ""); ?>>Male</option>
                      <option value="2" <?php echo (($edata['gender'] == 2) ? "selected" : ""); ?>>Other</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">Contact No: </label>
                    <input type="number" class="form-control" id="customer_phone" name="contact"
                      value="<?php echo $edata['student_mobile'] ?>" placeholder="Enter Student Phone"
                      autocomplete="off" />
                  </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">Address: </label>
                    <input type="text" class="form-control" id="customer_address" name="address"
                      value="<?php echo $edata['student_address'] ?>" placeholder="Enter Student Address"
                      autocomplete="off">
                  </div>
                </div>

              </div>

              <div class="col-12" style="display:flex; gap:20px;">
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">City: </label>
                    <input type="text" class="form-control" id="customer_address" name="city" placeholder="Enter City"
                      autocomplete="off">
                  </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">State: </label>
                    <input type="text" class="form-control" id="customer_address" name="state" placeholder="Enter state"
                      autocomplete="off">
                  </div>
                </div>
              </div>


              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">E-mail ID: </label>
                    <input type="text" class="form-control" id="customer_gstin" name="email"
                      value="<?php echo $edata['student_email'] ?>" placeholder="Enter Student Email" autocomplete="off"
                      required>
                  </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">Aadhar No: </label>
                    <input type="number" class="form-control" id="customer_address" name="adhar_no"
                      placeholder="Enter Aadhar No" autocomplete="off">
                  </div>
                </div>

              </div>




              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-12 col-md-6 col-lg-6">

                  <div class="form-group">
                    <label for="gross_amount">10th Marks %: </label>
                    <input type="number" class="form-control" id="customer_phone" name="tenth"
                      placeholder="Enter 10th Marks" autocomplete="off" required />
                  </div>

                </div>
                <div class="col-12 col-md-6 col-lg-6">

                  <div class="form-group">
                    <label for="gross_amount">12th Marks %: </label>
                    <input type="number" class="form-control" id="customer_phone" name="twelth"
                      placeholder="Enter 12th Marks" autocomplete="off" required />
                  </div>

                </div>
              </div>



              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">Graduate Marks %: </label>
                    <input type="number" class="form-control" id="customer_phone" name="graduation"
                      placeholder="Enter Graduate Marks" autocomplete="off" required />
                  </div>



                </div>
                <div class="col-12 col-md-6 col-lg-6">

                  <div class="form-group">
                    <label for="gross_amount">Graduate Passing Year: </label>
                    <input type="date" class="form-control" id="customer_phone" name="graduation_passing"
                      placeholder="Enter Graduate Passing Year" autocomplete="off" required />
                  </div>


                </div>
              </div>


              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-12 col-md-6 col-lg-6">

                  <div class="form-group">
                    <label for="gross_amount">Education Qualification : </label> &nbsp; &nbsp;
                    <input type="input" class="form-control" id="prof_status" name="education"
                      value="<?php echo $edata['qualification'] ?>" placeholder="Education Qualification ">
                  </div>

                </div>
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">College Name: </label>
                    <input type="text" class="form-control" id="customer_phone" name="college_name"
                      value="<?php echo $edata['college_name'] ?>" placeholder="Enter College Name" autocomplete="off"
                      required />
                  </div>



                </div>
              </div>

              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-12 col-md-6 col-lg-6">

                  <div class="form-group">
                    <label for="paid_status">Admission Date: </label>
                    <input type="date" name="admission" class="form-control">
                  </div>

                </div>
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="gross_amount">Annual Income:</label>
                    <input type="number" class="form-control" id="customer_phone" name="annual_income"
                      placeholder="Enter Income" autocomplete="off" required />
                  </div>



                </div>
              </div>


              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="paid_status">Caste : </label>
                    <select class="form-control" id="caste" name="caste">
                      <option value="OPEN">OPEN</option>
                      <option value="OBC">OBC</option>
                    </select>
                  </div>
                </div>
              </div>


              <div class="col-12" style="display:flex; gap:20px;">

                <div class="col-12 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label for="paid_status">10th Certificate/Marksheet Upload: </label>
                    <input type="file" class="form-control" name="tenth_certificate" class="form-control">
                  </div>


                </div>
                <div class="col-12 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label for="paid_status">12th Certificate/Marksheet Upload: </label>
                    <input type="file" name="twelth_certificate" class="form-control">
                  </div>


                </div>
                <div class="col-12 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label for="paid_status">Income Certificate: </label>
                    <input type="file" name="income" class="form-control">
                  </div>



                </div>
                <div class="col-12 col-md-4 col-lg-4">

                  <div class="form-group">
                    <label for="paid_status">Graduate Certificate: </label>
                    <input type="file" name="graduate_certificate" class="form-control">
                  </div>

                </div>
              </div>


              <div class="col-12" style="display:flex; gap:20px;">
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="paid_status">Photograph: </label>
                    <input type="file" name="photograph" class="form-control">
                  </div>


                </div>
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="paid_status">Aadhar Card: </label>
                    <input type="file" name="adhar" class="form-control">
                  </div>
                </div>
              </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">

              <button type="submit" class="btn btn-primary">Save</button>
              <button type="reset" class="btn btn-warning">reset</button>

              <a href="<?php echo base_url('enrollment/') ?>" class="btn btn-warning">Back</a>
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

  $(document).ready(function() {
    loadSelectCourses("<?php echo $edata['project_id']; ?>", "#coursesAppender", "<?php echo $edata['course_id']; ?>");
    $(".select_group").select2(); // For select multiple array
    $('#chq_no').hide();
    $('#pay_mode').change(function() {
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
      success: function(res) {
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
  //rate System manual 29-3-19 RMZ


  function ratecal() {
    var rate = document.getElementById("rate_1").value;
    var pay = document.getElementById("pay").value;

    var discount = $("#discount").val();

    var nt = document.getElementById("net_amount").value = Number(rate) - Number(discount);

    document.getElementById("amount").value = Number(rate);

    document.getElementById("gross_amount").value = Number(rate);
    document.getElementById("remain").value = Number(nt) - Number(pay);


  }

  //is number input only 

  function isNumber(event) {
    var keyCode = event.keyCode;
    if (keyCode >= 48 && keyCode <= 57) {
      return true;
    }
    return false;
  }


  function cal3() {
    var totalAmount = $("#gross_amount").val();
    var pay = document.getElementById("pay").value;
    var remain = Number(totalAmount) - Number(pay)

    var discount = $("#discount").val();
    if (discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);
      var remain_final = grandTotal - pay;
      $("#remain").val(remain_final);
      $("#net_amount").val(grandTotal);

    } else {
      $("#remain").val(remain);
      $("#net_amount").val(totalAmount);


    } // /else discount 


  }




  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }
</script>