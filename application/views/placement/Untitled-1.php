<div class="box">
  <div class="box-header">
    <h3 class="box-title">Add Placement</h3>
  </div>
  <!-- /.box-header -->
  <form role="form" action="<?php base_url('orders/createp') ?>" method="post" class="form-horizontal">
    <div class="box-body">

      <?php echo validation_errors(); ?>

      <div class="form-group">
        <label for="gross_amount" class="col-sm-12 control-label">Date: <?php echo date('Y-m-d') ?></label>
      </div>
      <div class="form-group">
        <label for="gross_amount" class="col-sm-12 control-label">Date: <?php echo date('h:i a') ?></label>
      </div>

      <div class="col-md-4 col-xs-12 pull pull-left">

        <div class="form-group">
          <label for="company_name">Student Name</label>
          <input type="text" class="form-control" id="Student_name" name="Student_name" placeholder="Enter Student name"
            autocomplete="off">
        </div>
        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Student Address</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="customer_address" name="student_address"
              placeholder="Enter Student Address" autocomplete="off" style="width:200px;">
          </div>
        </div>

        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Student Mobile</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="customer_phone" name="student_phone"
              placeholder="Enter Student Phone" autocomplete="off" style="width:200px;">
          </div>
        </div>

        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Student Email </label>
          <div class="col-sm-7">
            <input type="email" class="form-control" id="customer_gstin" name="student_email"
              placeholder="Enter Student Email" autocomplete="off" style="width:200px;">
          </div>
        </div>

        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Student College Name
          </label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="student_clg" name="customer_gst"
              placeholder="Enter College Name" autocomplete="off" style="width:200px;">
          </div>
        </div>
        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">10th % </label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="student_clg" name="student_10" placeholder="Enter 12th %"
              autocomplete="off" style="width:200px;">
          </div>
        </div>

        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">12th % </label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="student_clg" name="student_12" placeholder="Enter 10th % "
              autocomplete="off" style="width:80px;">
          </div>
        </div>

        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Gender </label>
          <div class="col-sm-7">
            <input type="radio" name="gender" value="male"> Male<br>
            <input type="radio" name="gender" value="female"> Female<br>
            <input type="radio" name="gender" value="other"> Other
          </div>
        </div>

        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Company Applied </label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="student_clg" name="company" placehoautocomplete="off"
              style="width:80px;">
          </div>
        </div>
        <div class="form-group">
          <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Status </label>
          <div class="col-sm-7">

            <select name="status">
              <option value="Selected">Selected</option>
              <option value="Rejected">Rejected</option>
          </div>
        </div>
      </div>

  </form>
  <!-- /.box-body -->
</div>