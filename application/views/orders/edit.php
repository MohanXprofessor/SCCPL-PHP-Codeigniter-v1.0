<?php
$sql = "SELECT * FROM brands";
$query = $this->db->query($sql);
$brandp = $query->result_array();


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Orders</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders</li>
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
            <h3 class="box-title">Edit Order</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('orders/create') ?>" method="post" class="form-horizontal">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="date" class="col-sm-12 control-label">Date: <input type="date" name="date"
                    value="<?php echo $order_data['order']['date_time']; ?>" </label>
              </div>


              <div class="col-md-4 col-xs-12 pull pull-left">




                <div class="form-group">
                  <label for="gross_amount">
                    <h4>Branch</h4>
                  </label> &nbsp;
                  <select name="franchise" type="text" class="form-control" required>


                    <?php $branch_id = $_SESSION['branch_id'];
                    if ($branch_id == 2) { ?>
                      <option value="2" <?php if ($order_data['order']['branch_id'] == '2') { ?> selected<?php } ?>>KHARADI
                      </option>
                      <?php //} elseif($branch_id == '1'){ ?>

                    <?php } else { ?>
                      <option value="2" <?php if ($order_data['order']['branch_id'] == '2') { ?>   <?php } ?>>KHARADI</option>
                      <option value="1" <?php if ($order_data['order']['branch_id'] == '1') { ?> selected<?php } ?>>
                        SHIVAJINAGAR</option>
                    <?php } ?>

                  </select>
                </div>

                <div class="form-group">
                  <label for="gross_amount">Educational Branch</label>
                  <select name="branch" type="text" class="form-control">
                    <option value="Civil" <?php if ($order_data['order']['branch'] == 'Civil') { ?> selected<?php } ?>>
                      Civil</option>
                    <option value="Mechanical" <?php if ($order_data['order']['branch'] == 'Mechanical') { ?> selected<?php } ?>>Mechanical</option>
                    <option value="Electrical" <?php if ($order_data['order']['branch'] == 'Electrical') { ?> selected<?php } ?>>Electrical</option>
                    <option value="SAP" <?php if ($order_data['order']['branch'] == 'SAP') { ?> selected<?php } ?>>SAP
                    </option>
                    <option value="DigitalMarketing" <?php if ($order_data['order']['branch'] == 'DigitalMarketing') { ?>
                        selected<?php } ?>>Digital Marketing</option>


                  </select>
                </div>



                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;"> Name</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                      placeholder="Enter Student Name" value="<?php echo $order_data['order']['customer_name'] ?>"
                      autocomplete="off" style="width:200px;" />
                  </div>
                </div>



                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Father Name</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="father_name" name="father_name"
                      value="<?php echo $order_data['order']['father_name'] ?>" autocomplete="off"
                      style="width:200px;" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Address</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="customer_address" name="customer_address"
                      placeholder="Enter Student Address" value="<?php echo $order_data['order']['customer_address'] ?>"
                      autocomplete="off" style="width:200px;">
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Contact
                    Number</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" id="customer_phone" name="customer_phone"
                      placeholder="Enter Customer Phone" value="<?php echo $order_data['order']['customer_phone'] ?>"
                      autocomplete="off" style="width:200px;">
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">E-mail ID</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="customer_gstin" name="customer_gst"
                      placeholder="Enter Student Email" value="<?php echo $order_data['order']['customer_gst'] ?>"
                      autocomplete="off" style="width:200px;">
                    <input type="hidden" class="form-control" id="customer_gstin" name="email_hidden"
                      placeholder="Enter Student Email" value="<?php echo $order_data['order']['customer_gst'] ?>"
                      autocomplete="off" style="width:200px;">

                  </div>
                </div>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Password</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="password" name="password"
                      value="<?php echo $order_data['order']['password'] ?>" autocomplete="off" style="width:200px;">
                  </div>
                </div>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Work/Study
                    organization</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="customer_gstin" name="college"
                      placeholder="Enter College Name" value="<?php echo $order_data['order']['college'] ?>"
                      autocomplete="off" style="width:200px;">
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount">Professional Status :</label> &nbsp; &nbsp;
                  <input type="radio" id="prof_status" name="status" <?php echo ($order_data['order']['prof_status'] == 'Student') ? 'checked' : '' ?> value="Student">Student &nbsp;
                  <input type="radio" id="prof_status" name="status" <?php echo ($order_data['order']['prof_status'] == 'Employed') ? 'checked' : '' ?> value="Employed">Employed &nbsp;
                  <input type="radio" id="prof_status" name="status" <?php echo ($order_data['order']['prof_status'] == 'Non-Employed') ? 'checked' : '' ?>
                    value="Non-Employed">Non-Employed &nbsp;


                </div>

                <div class="form-group">
                  <label for="gross_amount">Education Qualification : </label> &nbsp; &nbsp;
                  <input type="radio" id="education" name="education" <?php echo ($order_data['order']['education'] == "Diploma in ") ? 'checked' : '' ?> value="Diploma in "
                    required>Diploma in &nbsp;
                  <input type="radio" id="education" name="education" <?php echo ($order_data['order']['education'] == 'B.E.') ? 'checked' : '' ?> value="B.E." autocomplete="off"
                    required>B.E. &nbsp;
                  <input type="radio" id="education" name="education" <?php echo ($order_data['order']['education'] == 'M.Tech') ? 'checked' : '' ?> value="M.Tech" autocomplete="off"
                    required>M.Tech &nbsp;
                  <input type="radio" id="education" name="education" <?php echo ($order_data['order']['education'] == 'Dip+BE') ? 'checked' : '' ?> value="Dip+BE"
                    autocomplete="off">Diploma+BE &nbsp;
                  <input type="radio" id="education" name="education" <?php echo ($order_data['order']['education'] == 'Other') ? 'checked' : '' ?> value="Other" autocomplete="off"
                    required>Other &nbsp;

                </div>


                <!--<div class="form-group">-->
                <!--  <label for="gross_amount">Programe </label>                 -->
                <!--    <input type="text" class="form-control" id="programe" name="programe" value="<?php //echo $order_data['order']['programe'] ?>" autocomplete="off" >                   -->
                <!--</div>-->



                <div class="form-group">
                  <label for="gross_amount">Organization : </label> &nbsp; &nbsp;
                  <input type="radio" id="organization" name="organization" <?php echo ($order_data['order']['organization'] == 'G.Tech ') ? 'checked' : '' ?> value="G.Tech"
                    autocomplete="off">G.Tech &nbsp;
                  <input type="radio" id="organization" name="organization" <?php echo ($order_data['order']['organization'] == 'TCIL') ? 'checked' : '' ?> value="TCIL" autocomplete="off">TCIL
                  &nbsp;
                </div>


                <div class="form-group">
                  <label for="paid_status">Caste :</label>
                  <select type="text" id="caste" name="caste">
                    <option value="NULL">SELECT</option>
                    <option value="OPEN" <?php if ($order_data['order']['caste'] == 'OPEN') {
                      echo "selected='selected'";
                    } ?>>OPEN</option>
                    <option value="OBC" <?php if ($order_data['order']['caste'] == 'OBC') {
                      echo "selected='selected'";
                    } ?>>OBC</option>
                  </select>
                </div>

                <!--<div class="form-group">-->
                <!--  <label for="gross_amount">Other Customized Programs : </label> &nbsp; &nbsp;                 -->
                <!--    <input type="text" class="form-control"  id="cust_program" name="cust_program" value="<?php //echo $order_data['order']['cust_program'] ?> "autocomplete="off" >                                         -->
                <!--</div>-->

                <div class="form-group">
                  <label for="gross_amount">Batch Timing : </label> &nbsp; &nbsp;
                  <input type="text" class="form-control" id="time" name="time"
                    value="<?php echo $order_data['order']['timing'] ?> " autocomplete="off">
                </div>
                <!-- New added remark-->
                <div class="form-group">
                  <label for="remark">Remark : </label> &nbsp; &nbsp;
                  <input type="text" class="form-control" id="remark" name="remark"
                    value="<?php echo $order_data['order']['remark'] ?> " autocomplete="off">
                </div>
              </div>


              <!-- New added for course status 2019/4/19 By Ramiz -->
              <!-- <div class="col-md-4 col-xs-4 pull pull-left">  -->
              <table class="table table-bordered" id="product_info_table" style="widht:50px;">
                <thead>
                  <tr>
                    <th style="width: 10px">Courses</th>
                    <th style="width: 10px">Status</th>

                  </tr>
                </thead>

                <tbody>

                  <?php
                  $course_comp = explode(",", $order_data['order']['course_completed']);
                  foreach ($order_data['order_item'] as $key => $val):
                    $bar = explode(",", $val['imei']);
                  endforeach;
                  ?>


                  <?php foreach ($bar as $row22) { ?>
                    <tr>
                      <td><?php echo $row22; ?></td>
                      <td> <input type="checkbox" name="course_completed[]" value="<?php echo $row22; ?>" <?php if (in_array($row22, $course_comp)) {
                             echo 'checked';
                           } ?>></td>
                    </tr>
                  <?php } ?>




                </tbody>
              </table>


              <br /> <br />
              <table class="table table-bordered" id="product_info_table">
                <thead>
                  <tr>
                    <th style="width:10%">Batch</th>
                    <th style="width:10%">Courses</th>
                    <th style="width:10%">Duration In Months</th>
                    <!-- <th style="width:10%">Qty</th> -->
                    <!-- <th style="width:10%">Color</th>
                       <th style="width:10%">S.No</th>
                        <th style="width:10%">Battery No</th>
                         <th style="width:10%">Charger No</th> -->
                    <th style="width:10%">Rate</th>
                    <th style="width:20%">Amount</th>

                    <!-- <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th> -->
                  </tr>
                </thead>

                <tbody>

                  <?php if (isset($order_data['order_item'])): ?>
                    <?php $x = 1; ?>
                    <?php foreach ($order_data['order_item'] as $key => $val): ?>
                      <?php //print_r($v); ?>
                      <tr id="row_<?php echo $x; ?>">
                        <td>
                          <select class="form-control select_group product" data-row-id="row_<?php echo $x; ?>"
                            id="product_<?php echo $x; ?>" name="product[]" style="width:100%;"
                            onchange="getProductData(<?php echo $x; ?>)" required>
                            <option value=""></option>
                            <?php foreach ($products as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>" <?php if ($val['product_id'] == $v['id']) {
                                   echo "selected='selected'";
                                 } ?>><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <?php $bar = explode(",", $val['imei']);

                        ?>
                        <td>
                          <select class="form-control select_group product" name="sku[]" style="width:100%;" multiple>
                            <option value=""></option>
                            <?php foreach ($bar as $row22) { ?>
                              <option value="<?php echo $row22; ?>" selected><?php echo $row22; ?></option>
                            <?php } ?>
                            <?php foreach ($brandp as $row) { ?>
                              <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>

                          </select>
                        </td>
                        <!-- <td><input type="text" name="sku[]" id="sku_1" class="form-control" value="<? php// echo $val['imei'] ?>" autocomplete="off"></td> -->
                        <td><input type="text" name="hsn[]" id="hsn_1" class="form-control"
                            value="<?php echo $val['hsn'] ?>" autocomplete="off" required>
                          <input type="hidden" name="qty[]" id="qty_1" class="form-control"
                            onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>" autocomplete="off">
                          <input type="hidden" name="color[]" id="color_1" class="form-control"
                            value="<?php echo $val['color'] ?>" autocomplete="off">
                          <input type="hidden" name="sno[]" id="sno_1" class="form-control"
                            value="<?php echo $val['s_no'] ?>" autocomplete="off">
                          <input type="hidden" name="batteryno[]" id="batteryno_1" class="form-control"
                            value="<?php echo $val['battery_no'] ?>" autocomplete="off">
                          <input type="hidden" name="chargerno[]" id="chargerno_1" class="form-control"
                            value="<?php echo $val['charger_no'] ?>" autocomplete="off">
                        </td>

                        <td>
                          <input type="text" name="rate[]" id="rate_1" class="form-control"
                            value="<?php echo $val['rate'] ?>" onkeyup="ratecal()" autocomplete="off">
                          <input type="hidden" name="rate_value[]" id="rate_value" class="form-control"
                            value="<?php echo $val['rate'] ?>" autocomplete="off">
                        </td>
                        <td>
                          <input type="text" name="amount[]" id="amount_1" class="form-control" readonly
                            value="<?php echo $val['amount'] ?>" autocomplete="off">
                          <input type="hidden" name="amount_value[]" id="amount_value_1" class="form-control" readonly
                            value="<?php echo $val['amount'] ?>" autocomplete="off">
                        </td>

                      </tr>
                      <?php $x++; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>

              <br /> <br />

              <div class="col-md-6 col-xs-12 pull pull-right">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="gross_amount" name="gross_amount" readonly
                      value="<?php echo $order_data['order']['gross_amount'] ?>" autocomplete="off">
                    <!-- <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" value="<?php echo $order_data['order']['gross_amount'] ?>" autocomplete="off"> -->
                  </div>
                </div>
                <!-- <?php if ($is_service_enabled == true): ?>
                  <div class="form-group">
                    <label for="service_charge" class="col-sm-5 control-label">S-Charge <?php echo $company_data['service_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="service_charge" name="service_charge" disabled value="<?php echo $order_data['order']['service_charge'] ?>" autocomplete="off">
                      <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" value="<?php echo $order_data['order']['service_charge'] ?>" autocomplete="off">
                    </div>
                  </div>
                  <?php endif; ?>
                  <?php if ($is_vat_enabled == true): ?>
                  <div class="form-group">
                    <label for="vat_charge" class="col-sm-5 control-label">Vat <?php echo $company_data['vat_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled value="<?php echo $order_data['order']['vat_charge'] ?>" autocomplete="off">
                      <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value" value="<?php echo $order_data['order']['vat_charge'] ?>" autocomplete="off">
                    </div>
                  </div>
                  <?php endif; ?> -->
                <div class="form-group">
                  <label for="discount" class="col-sm-5 control-label">Discount</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount"
                      onkeyup="cal3()" onkeypress="return isNumber(event)"
                      value="<?php echo $order_data['order']['discount'] ?>" autocomplete="off">
                  </div>
                </div>



                <div class="form-group">
                  <label for="discount" class="col-sm-5 control-label">Paid</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" id="paid" name="paid"
                      value="<?php echo $order_data['order']['pay'] ?>" autocomplete="off" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="discount" class="col-sm-5 control-label">Pay</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="npay" name="npay" onkeyup="paidcal()" value='0'
                      onkeypress="return isNumber(event)" autocomplete="off">
                    <input type="hidden" class="form-control" id="pay" name="pay" autocomplete="off">
                  </div>
                </div>



                <div class="form-group">
                  <label for="discount" class="col-sm-5 control-label">Remaining</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" id="remain" name="remain"
                      value="<?php echo $order_data['order']['remain'] ?>" autocomplete="off" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" id="net_amount" name="net_amount"
                      value="<?php echo $order_data['order']['net_amount'] ?>" readonly autocomplete="off">
                    <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value"
                      value="<?php echo $order_data['order']['net_amount'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="net_amount" class="col-sm-5 control-label"> Next Payment Date</label>
                  <div class="col-sm-7">
                    <input type="date" class="form-control" id="fdate" name="fdate"
                      value="<?php echo $order_data['order']['fdate'] ?>" autocomplete="off">
                  </div>
                </div>




                <div class="form-group">
                  <label for="paid_status" class="col-sm-5 control-label">Pay Mode</label>
                  <div class="col-sm-7">
                    <select type="text" class="form-control" id="pay_mode" name="pay_mode">
                      <option value="cash" <?php if ($order_data['order']['pay_mode'] == 'cash') { ?> selected<?php } ?>>
                        Cash</option>
                      <option value="credit" <?php if ($order_data['order']['pay_mode'] == 'credit') { ?> selected<?php } ?>>Credit</option>
                      <option value="cheque" <?php if ($order_data['order']['pay_mode'] == 'cheque') { ?> selected<?php } ?>>Cheque</option>
                    </select>
                  </div>
                </div>
                <div id="chq_no" class="form-group">
                  <label for="ch" class="col-sm-5 control-label">Cheque Number</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="cheque" name="cheque_number"
                      value="<?php echo $order_data['order']['cheque_number'] ?>" autocomplete="off">

                  </div>
                </div>



                <div class="form-group">
                  <label for="paid_status" class="col-sm-5 control-label">Paid Status</label>
                  <div class="col-sm-7">
                    <select type="text" class="form-control" id="paid_status" name="paid_status">
                      <option value="1">Paid</option>
                      <option value="2">Unpaid</option>
                    </select>
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


              <button type="submit" class="btn btn-primary" onclick="paidcal()">Save Changes</button>
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
    $('#chq_no').show();
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