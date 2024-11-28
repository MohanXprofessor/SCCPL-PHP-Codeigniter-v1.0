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
          <form role="form" action="<?php base_url('orders/create') ?>" method="post" class="form-horizontal">
            <div class="box-body">

              <?php if (validation_errors()) { ?>
                <div class="alert alert-error alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                      aria-hidden="true">&times;</span></button>
                  <?php echo validation_errors(); ?>
                </div>
              <?php } ?>

              <div class="form-group">
                <label for="gross_amount" class="col-sm-12 control-label">Date: <input type="date" data-date=""
                    data-date-format="DD MM YYYY" class="" name="date" required></label>
              </div>


              <div class="col-md-8 col-xs-12 pull pull-left">

                <!--<div class="form-group">-->
                <!--       <label for="gross_amount" ><h4>Branch</h4></label> &nbsp;        -->
                <!--     <select name="branch"  type="text"  style="height:30px;"required>-->

                <!--           <option value="Civil">Civil</option>-->
                <!--           <option value="Mechanical">Mechanical</option>-->
                <!--           <option value="Electrical">Electrical</option>-->
                <!--            <option value="SAP">SAP</option>-->

                <!--     </select>-->

                <!--     <label style="-->
                <!--      width: 70px;-->
                <!--      margin-left: 60px;-->
                <!--      font-family: Times New Roman, Times, serif;-->
                <!--      font-size: large;">Name :</label>         -->
                <!--       <input type="text" id="customer_name" name="customer_name" placeholder="Enter Student Name" style="widht:50px;width: 253.99306px;height: 35.99306px;"autocomplete="off" required/>-->
                <!--   </div>-->


                <div class="form-group">
                  <label for="gross_amount">
                    <h4>Branch</h4>
                  </label> &nbsp;
                  <select name="franchise" type="text" style="height:30px;" required>
                    <?php $branch_id = $_SESSION['branch_id'];
                    if ($branch_id != 2) {
                      foreach ($branch as $v) { ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                      <?php }
                    } else { ?>

                      <option value="2" selected>KHARADI</option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="gross_amount">
                    <h4>Educational Branch</h4>
                  </label> &nbsp;
                  <select name="branch" type="text" style="height:30px;" required>

                    <option value="Civil">Civil</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="SAP">SAP</option>
                    <option value="Electrical">Electrical</option>
                    <option value="DigitalMarketing">Digital Marketing</option>
                  </select>

                  <label style="
                      width: 70px;
                      margin-left: 60px;
                      font-family: Times New Roman, Times, serif;
                      font-size: large;">Name :</label>
                  <input type="text" id="customer_name" name="customer_name" placeholder="Enter Student Name"
                    style="widht:50px;width: 253.99306px;height: 35.99306px;" autocomplete="off" />
                </div>







                <!-- <div class="form-group">
                       <label for="gross_amount" >Name</label>         
                       <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Student Name" style="widht:30px"autocomplete="off" />
                   </div>
                  -->
                <div class="form-group">
                  <label>Father Name</label>
                  <input type="text" id="father_name" name="father_name" placeholder="Enter Father Name"
                    style="widht:50px;width: 253.99306px;height: 35.99306px;" autocomplete="off" />
                </div>


                <div class="form-group">
                  <label for="gross_amount" ">Address</label>
                    
                      <input type=" text" class="form-control" id="customer_address" name="customer_address"
                    placeholder="Enter Student Address" autocomplete="off">

                </div>

                <div class="form-group">
                  <label for="gross_amount">Contact No</label>

                  <input type="number" class="form-control" id="customer_phone" name="customer_phone"
                    placeholder="Enter Student Phone" autocomplete="off" required />

                </div>

                <div class="form-group">
                  <label for="gross_amount">E-mail ID </label>

                  <input type="text" class="form-control" id="customer_gstin" name="customer_gst"
                    placeholder="Enter Student Email" autocomplete="off" required>

                  <!-- Pass added -->
                  <label>Password </label>

                  <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>



                  <label for="gross_amount">Work/Study Organization </label>

                  <input type="text" class="form-control" id="student_clg" name="college"
                    placeholder="Enter College Name" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="gross_amount">Professional Status :</label> &nbsp; &nbsp;

                  <input type="radio" id="prof_status" name="status" value="Student" autocomplete="off" required>Student
                  &nbsp;
                  <input type="radio" id="prof_status" name="status" value="Employeed" autocomplete="off">Employed
                  &nbsp;
                  <input type="radio" id="prof_status" name="status" value="Non-Employed"
                    autocomplete="off">Non-Employed

                </div>

                <div class="form-group">
                  <label for="gross_amount">Education Qualification : </label> &nbsp; &nbsp;

                  <input type="radio" id="prof_status" name="education" value="Diploma in " autocomplete="off">Diploma
                  in &nbsp;
                  <input type="radio" id="prof_status" name="education" value="B.E." autocomplete="off">B.E. &nbsp;
                  <input type="radio" id="prof_status" name="education" value="M.Tech" autocomplete="off">M.Tech &nbsp;
                  <input type="radio" id="prof_status" name="education" value="Dip+BE" autocomplete="off">Diploma+BE
                  &nbsp;
                  <input type="radio" id="prof_status" name="education" value="Other" autocomplete="off">Other


                </div>

                <!--<div class="form-group">-->
                <!--  <label for="gross_amount">Programe </label>-->

                <!--    <input type="text" class="form-control" id="programe" name="programe" autocomplete="off" >                   -->
                <!--</div>-->

                <div class="form-group">
                  <label for="gross_amount">Organization : </label> &nbsp; &nbsp;

                  <input type="radio" id="organization" name="organization" value="G.Tech " autocomplete="off">G.Tech
                  &nbsp;
                  <input type="radio" id="organization" name="organization" value="TCIL" autocomplete="off">TCIL

                </div>

                <div class="form-group">
                  <label for="paid_status">Caste : </label>

                  <select type="text" id="caste" name="caste">
                    <option value="OPEN">OPEN</option>
                    <option value="OBC">OBC</option>
                  </select>

                </div>



                <!--<div class="form-group">-->
                <!--  <label for="gross_amount">Other Customized Programs : </label> &nbsp; &nbsp;                 -->
                <!--    <input type="text" class="form-control"  id="cust_program" name="cust_program" autocomplete="off" >                                         -->
                <!--</div>-->

                <div class="form-group">
                  <label for="gross_amount">Batch Timing : </label> &nbsp; &nbsp;
                  <input type="text" class="form-control" id="time" name="time" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="remark">Remark : </label> &nbsp; &nbsp;
                  <input type="text" class="form-control" id="remark" name="remark" placeholder="Enter Remark"
                    autocomplete="off">
                </div>



              </div>


              <br /> <br />
              <table class="table table-bordered" id="product_info_table">
                <thead>
                  <tr>

                    <th style="width:15%">Batch Name</th>
                    <th style="width:15%">Course</th>
                    <th style="width:10%">Duration in Month</th>
                    <!-- <th style="width:10%">Qty</th> -->
                    <!-- <th style="width:10%">Color</th>
                       <th style="width:10%">S.No</th>
                        <th style="width:10%">Battery No</th>
                         <th style="width:10%">Charger No</th> -->
                    <th style="width:15%">Rate</th>
                    <th style="width:15%">Amount</th>
                    <!-- <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th> -->
                  </tr>
                </thead>

                <tbody>
                  <tr id="row_1">
                    <td>
                      <select class="form-control select_group product" data-row-id="row_1" id="product_1"
                        name="product[]" style="width:100%;" required>
                        <option value=""></option>
                        <?php foreach ($products as $k => $v): ?>
                          <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </td>
                    <td>
                      <select class="form-control select_group product" name="sku[]" style="width:100%;" multiple>
                        <option value=""></option>
                        <?php foreach ($brandp as $row22) { ?>
                          <option value="<?php echo $row22['name']; ?>"><?php echo $row22['name']; ?></option>
                        <?php } ?>
                      </select>
                    </td>


                    <td><input type="text" name="hsn[]" id="hsn_1" class="form-control" required>
                      <input type="hidden" name="qty[]" id="qty_1" class="form-control" value="1">

                      <input type="hidden" name="color[]" id="color_1" class="form-control" value="null">

                      <input type="hidden" name="sno[]" id="sno_1" class="form-control" value="0">
                      <input type="hidden" name="batteryno[]" id="batteryno_1" class="form-control" value="null">
                      <input type="hidden" name="chargerno[]" id="chargerno_1" class="form-control" value="null">
                    </td>


                    <td>
                      <input type="text" name="rate[]" id="rate_1" class="form-control" onkeyup="ratecal()"
                        autocomplete="off">
                      <input type="hidden" name="rate_value[]" id="rate_value_1" class="form-control"
                        autocomplete="off">
                    </td>
                    <td>
                      <input type="text" name="amount[]" id="amount" class="form-control" readonly autocomplete="off">
                      <input type="hidden" name="amount_value[]" id="amount_value_1" class="form-control"
                        autocomplete="off">
                    </td>
                    <!-- <td><button type="button" class="btn btn-default" onclick="removeRow('1')"><i class="fa fa-close"></i></button></td> -->
                  </tr>
                </tbody>
              </table>

              <br /> <br />

              <div class="col-md-6 col-xs-12 pull pull-right">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="gross_amount" name="gross_amount" readonly
                      autocomplete="off">
                    <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value"
                      autocomplete="off">
                  </div>
                </div>
                <!-- <?php if ($is_service_enabled == true): ?>
                  <div class="form-group">
                    <label for="service_charge" class="col-sm-5 control-label">S.G.S.T <?php echo $company_data['service_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="service_charge" name="service_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" autocomplete="off">
                    </div>
                  </div>
                  <?php endif; ?>
                  <?php if ($is_vat_enabled == true): ?>
                  <div class="form-group">
                    <label for="vat_charge" class="col-sm-5 control-label">C.G.S.T<?php echo $company_data['vat_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value" autocomplete="off">
                    </div>
                  </div>
                  <?php endif; ?> -->
                <div class="form-group">
                  <label for="discount" class="col-sm-5 control-label">Discount</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="discount" name="discount" value="0" onkeyup="cal3()"
                      onkeypress="return isNumber(event)" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="discount" class="col-sm-5 control-label">Pay</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="pay" name="pay" placeholder="Pay" onkeyup="cal()"
                      onkeypress="return isNumber(event)" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="discount" class="col-sm-5 control-label">Remaining</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="remain" name="remain" autocomplete="off" readonly>
                    <input type="hidden" class="form-control" name="warrenty" value="0" autocomplete="off">

                  </div>
                </div>

                <!-- <div class="form-group">
                    <label for="discount" class="col-sm-5 control-label">Warrenty</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="discount" name="warrenty" placeholder="Enter Warrenty"  autocomplete="off">
                    </div>
                  </div>
           -->
                <div class="form-group">
                  <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" id="net_amount" name="net_amount" readonly
                      autocomplete="off">
                    <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value"
                      autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="net_amount" class="col-sm-5 control-label">Next Payment Date</label>
                  <div class="col-sm-7">
                    <input type="date" class="form-control" id="fdate" name="fdate" autocomplete="off">
                  </div>
                </div>


                <div class="form-group">
                  <label for="paid_status" class="col-sm-5 control-label">Pay Mode</label>
                  <div class="col-sm-7">
                    <select type="text" class="form-control" id="pay_mode" name="pay_mode">
                      <option value="cash" selected>Cash</option>
                      <option value="credit">Credit</option>
                      <option value="cheque">Cheque</option>
                    </select>
                  </div>
                </div>

                <div id="chq_no" class="form-group">
                  <label for="ch" class="col-sm-5 control-label">Cheque Number</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="cheque" name="cheque_number" value="0"
                      autocomplete="off">

                  </div>
                </div>


              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <input type="hidden" name="service_charge_rate"
                value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
              <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>"
                autocomplete="off">
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="reset" class="btn btn-warning">reset</button>

              <a href="<?php echo base_url('orders/') ?>" class="btn btn-warning">Back</a>
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
    $(".select_group").select2();  // For select multiple array
    $('#chq_no').hide();
    $('#pay_mode').change(function () {
      if ($('#pay_mode').val() == 'cheque') {
        $('#chq_no').show();

      } else {
        $('#chq_no').hide();

      }
    });
  }); // /document


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