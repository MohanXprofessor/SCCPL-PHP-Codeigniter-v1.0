<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      List Under Batch
      <small>Batches</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Batches</li>
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
            <h3 class="box-title">Manage Batches</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <th>ID</th>
              <th>Course Name</th>
              <!--<th>Price</th>-->
              <!--<th>Timing</th>-->
              <th>Duration IN Month</th>


              <?php
              if ($h) {

                foreach ($h as $k => $v) {
                  foreach ($v as $r) {

                    ?>
                    <tr>
                      <td><?php echo $r['id']; ?></td>
                      <td><?php echo $r['name']; ?></td>
                      <!--<td><?php echo $r['rate']; ?></td>-->
                      <!--<td><?php echo $r['timing']; ?></td>-->
                      <td><?php echo $r['duration']; ?></td>
                    <tr>

                    <?php }
                }
              } else {
                ?>
                <tr>
                  <td><?php echo "Null"; ?></td>
                  <td><?php echo "Null"; ?></td>
                  <td><?php echo "Null" ?></td>
                  <td><?php echo "Null" ?></td>
                  <td><?php echo "Null" ?></td>
                <tr>
                <?php } ?>

            </table>
            <div class="box-footer">

              <a href="<?php echo base_url('products') ?>" class="btn btn-warning">Back</a>

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