<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="width:100%;height:100%;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Payments Details
      <small>Payments</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Payments</li>
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
            <h3 class="box-title">Details</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <th>ID</th>
              <th>Pay</th>
              <th>Pay Mode</th>
              <th>Cheque Number</th>
              <th>Date</th>


              <?php $i = 1;
              foreach ($h as $k => $r) {

                ?>
                <tr>
                  <td><?php echo $i ?></td>
                  <td><?php echo $r['pay']; ?></td>
                  <td><?php echo $r['pay_mode']; ?></td>
                  <td><?php echo $r['cheque_number']; ?></td>
                  <td><?php echo $r['date']; ?></td>
                <tr>

                  <?php $i++;
              } ?>

            </table>


            <div class="box-footer">

              <a href="<?php echo base_url('orders/index') ?>" class="btn btn-warning">Back</a>

            </div>

          </div>
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