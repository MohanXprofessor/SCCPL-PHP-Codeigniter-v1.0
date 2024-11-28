<style>
  .isa_info,
  .isa_success,
  .isa_warning,
  .isa_error {
    margin: 10px 0px;
    padding: 12px;

  }

  .isa_error {
    color: #D8000C;
    background-color: #FFD2D2;
    font-size: 20px;
  }

  .isa_info i,
  .isa_success i,
  .isa_warning i,
  .isa_error i {
    margin: 10px 22px;
    font-size: 2em;
    vertical-align: middle;
  }

  .isa_info {
    color: #00529B;
    background-color: #BDE5F8;
  }
</style>


<!-- Content Wrapper. Contains page content -->

<?php

// If Branch_id is 2 then diplay only wagholi placement added by ramiz 18/4/2019
if ($_SESSION['branch_id'] == 2) {
  $sql = "SELECT * FROM orders WHERE branch='Civil' and branch_id=2";
  $query = $this->db->query($sql);
  $count_civil = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch='Electrical' and branch_id=2";
  $query = $this->db->query($sql);
  $count_electrical = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch='SAP' and branch_id=2";
  $query = $this->db->query($sql);
  $count_sap = $query->num_rows();



  $sql = "SELECT * FROM placement WHERE branch='DigitalMarketing'  and branch_id=2";
  $query = $this->db->query($sql);
  $placement_count_gdmkt = $query->num_rows();


  $sql = "SELECT * FROM orders WHERE branch='DigitalMarketing' and branch_id=2";
  $query = $this->db->query($sql);
  $count_dgmkt = $query->num_rows();


  $sql = "SELECT * FROM orders WHERE branch='Mechanical' and branch_id=2";
  $query = $this->db->query($sql);
  $count_mech = $query->num_rows();

  $sql = "SELECT * FROM placement WHERE branch='Civil' and branch_id=2";
  $query = $this->db->query($sql);
  $placement_count_civil = $query->num_rows();

  $sql = "SELECT * FROM placement WHERE branch='SAP' and branch_id=2";
  $query = $this->db->query($sql);
  $placement_count_sap = $query->num_rows();



  $sql = "SELECT * FROM placement WHERE branch='Electrical' and branch_id=2";
  $query = $this->db->query($sql);
  $placement_count_elect = $query->num_rows();

  $sql = "SELECT * FROM placement WHERE branch='Mechanical' and branch_id=2";
  $query = $this->db->query($sql);
  $placement_count_mech = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch_id=2 and fdate=DATE(NOW())";
  $query = $this->db->query($sql);
  $lead_wagholi = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch_id=1 and fdate=DATE(NOW())";
  $query = $this->db->query($sql);
  $lead_shivajinagar = $query->num_rows();

  $sql = "SELECT * FROM lead WHERE follow_date=DATE(NOW()) and branch_id=2";
  $query = $this->db->query($sql);
  $today_lead_wagholi = $query->num_rows();
} else {


  $sql = "SELECT * FROM `lead` WHERE follow_date=DATE(NOW()) and branch_id=1";
  $query = $this->db->query($sql);
  $today_lead_shivajinagar = $query->num_rows();

  $sql = "SELECT * FROM `lead` WHERE follow_date=DATE(NOW()) and branch_id=2";
  $query = $this->db->query($sql);
  $today_lead_wagholi = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch_id=2 and fdate=DATE(NOW())";
  $query = $this->db->query($sql);
  $lead_wagholi = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch_id=1 and fdate=DATE(NOW())";
  $query = $this->db->query($sql);
  $lead_shivajinagar = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch='Civil'";
  $query = $this->db->query($sql);
  $count_civil = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch='Electrical'";
  $query = $this->db->query($sql);
  $count_electrical = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch='SAP'";
  $query = $this->db->query($sql);
  $count_sap = $query->num_rows();

  $sql = "SELECT * FROM orders WHERE branch='DigitalMarketing'";
  $query = $this->db->query($sql);
  $count_dgmkt = $query->num_rows();



  $sql = "SELECT * FROM orders WHERE branch='Mechanical'";
  $query = $this->db->query($sql);
  $count_mech = $query->num_rows();

  $sql = "SELECT * FROM placement WHERE branch='Civil'";
  $query = $this->db->query($sql);
  $placement_count_civil = $query->num_rows();

  $sql = "SELECT * FROM placement WHERE branch='SAP'";
  $query = $this->db->query($sql);
  $placement_count_sap = $query->num_rows();

  $sql = "SELECT * FROM placement WHERE branch='Electrical'";
  $query = $this->db->query($sql);
  $placement_count_elect = $query->num_rows();

  $sql = "SELECT * FROM placement WHERE branch='DigitalMarketing'";
  $query = $this->db->query($sql);
  $placement_count_gdmkt = $query->num_rows();

  $sql = "SELECT * FROM placement WHERE branch='Mechanical'";
  $query = $this->db->query($sql);
  $placement_count_mech = $query->num_rows();
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="margin-bottom: 30px !important;">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <?php echo $this->session->flashdata('success'); ?>
      </div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div class="alert alert-error alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <?php echo $this->session->flashdata('error'); ?>
      </div>
    <?php endif; ?>


    <!--  If fees pending then not access -->
    <?php $emt = $_SESSION['email'];

    $sql = "SELECT * FROM orders WHERE customer_gst='$emt'";
    $query = $this->db->query($sql);
    $da = $query->result_array();
    //  var_dump($da);
    //  die();
    foreach ($da as $value) {
      if ($value['remain'] > 0.00) { ?>

        <div class="container">
          <h2 class="isa_info">Dear Students,</h2>
          <div class="isa_error">

            You are not eligible for login or placement as your fees are pending.</br>
            So kindly pay your fees to get eligible for upcoming placements
          </div>

        </div>
    <?php }
    } ?>




    <style>
      .cardBox>div p {
        position: relative;
        height: 40px !important;
        overflow: hidden;
      }
    </style>
    <div class="row cardBox">
      <?php if ($_SESSION['email'] == "hr.tcilitpune@gmail.com" || $_SESSION['email'] == "test@test.com") { ?>

        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $placement_count_civil ?></h3>

              <p> Placement Shivajinagar</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-user"></i>
            </div>
            <a href="<?php echo site_url('placement/') ?>" class="small-box-footer">More info <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-lime">
            <div class="inner">
              <h3><?php echo $placement_count_civil ?></h3>

              <p> Placement Kharadi</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url('placement/placement_wagholi') ?>" class="small-box-footer">More info <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      <?php } ?>

      <!-- Small boxes (Stat box) -->
      <?php if ($is_admin == true || $_SESSION['email'] == "counseller123@gmail.com" || $_SESSION['email'] == "counseller_w@gtech.com" || $_SESSION['email'] == "counseller_wagholi@gtech.com" || $_SESSION['email'] == "wagholi_admin@gtech.com" || $_SESSION['email'] == "dnyaneshwargtech@gmail.com" || $_SESSION['email'] == "wagholi_admin@gtech.com" || $_SESSION['email'] == "durga@gtech.com") {
        if ($is_admin == true) { ?>

          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <?php
                $query = $this->db->query("SELECT COUNT(*) as total_batches FROM batch");
                $result = $query->row();

                $total_batches = $result->total_batches;
                ?>
                <h3><?php echo $total_batches ?></h3>

                <p>Total Batches</p>
              </div>
              <div class="icon">
                <i class="ion  ion-ios-briefcase"></i>
              </div>
              <a href="<?php echo base_url('batch/') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <?php
                $query = $this->db->query("SELECT COUNT(*) as total_enrollments FROM enrollment");
                $result = $query->row();

                $total_enrollments = $result->total_enrollments;
                ?>

                <h3><?php echo $total_enrollments ?></h3>

                <p>Total Enrollment</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('enrollment/') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- 4-2-19 -->



          <!-- ./col -->
          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner">
                <h3><?php echo $total_users; ?></h3>

                <p>Total Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-people"></i>
              </div>
              <a href="<?php echo base_url('users/') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo $total_stores ?></h3>

                <p>Total Projects</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-home"></i>
              </div>
              <a href="<?php echo base_url('stores/') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- <div class="col-lg-2 col-xs-6">
          
            <div class="small-box bg-fuchsia">
              <div class="inner">
                <h3>
                  <?php //echo sizeof($this->db->get_where('orders', ['course_completed !=' => 'NULL', 'fdate' => `DATE(NOW())`])->result()); 
                  ?>
                </h3>
                <p>Course Completed List</p>
              </div>
              <div class="icon">

              </div>
              <a data-toggle="modal" data-target="#completedListModal" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> -->

          <!-- <div class="col-lg-2 col-xs-6">
          
            <div class="small-box bg-lime">
              <div class="inner">
                <h3>
                  <h3>
                    <?php //echo sizeof($this->db->get_where('orders', ['course_completed' => NULL, 'fdate' => `DATE(NOW())`])->result()); 
                    ?>
                  </h3>
                </h3>
                <p>Course Incompleted List</p>
              </div>
              <div class="icon">
                <i class="ion ion-certificate"></i>
              </div>
              <a data-toggle="modal" data-target="#incompletedListModal" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
 -->

        <?php } ?>

        <!--New for resend -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h3>0</h3>
              <p>Resend Email</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-email"></i>
            </div>
            <a href="<?php echo base_url('orders/load_resend_email') ?>" class="small-box-footer">More info <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <?php //if ($_SESSION['branch_id'] == 1 || $_SESSION['branch_id'] == 0) { 
        ?>

        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3><?php echo sizeof($this->db->get_where('enquiry')->result()); ?></h3>
              <p>Total Enquiry</p>
            </div>
            <div class="icon">
              <i class="ion  ion-ios-eye"></i>
            </div>
            <a data-toggle="modal" data-target="#todayEnquiryListModal" class="small-box-footer">More info <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- <div class="col-lg-2 col-xs-6">
           
            <div class="small-box bg-blue">
              <div class="inner">
                <h3>
                  <?php
                  // $feesEnquiry = $this->db->get_where('orders', [])->result();
                  // $feesEnquiry_fee = 0;
                  // foreach ($feesEnquiry as $order)
                  //   $feesEnquiry_fee += $order->pay;

                  // echo $feesEnquiry_fee;
                  ?>
                </h3>

                <p>Paid Fees Enquiry</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
              <a data-toggle="modal" data-target="#paidFeesEnquiryListModal" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-xs-6">
           
            <div class="small-box bg-red">
              <div class="inner">
                <h3>
                  <?php
                  // $feesEnquiry = $this->db->get_where('orders', [])->result();
                  // $feesEnquiry_fee = 0;
                  // foreach ($feesEnquiry as $order)
                  //   $feesEnquiry_fee += $order->remain;

                  // echo $feesEnquiry_fee;
                  ?>
                </h3>

                <p>Remaining Fees Enquiry</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
              <a data-toggle="modal" data-target="#remainingFeesEnquiryListModal" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> -->

        <?php //} 
        ?>

        <!-- <div class="col-lg-2 col-xs-6">
         
          <div class="small-box bg-fuchsia">
            <div class="inner">
              <h3><?php //echo ($count_mech + $count_mech + $count_sap + $count_electrical + $count_dgmkt + $count_civil) 
                  ?>
              </h3>

              <p>Ongoing Batches</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a data-toggle="modal" data-target="#ongoingBatchesModal" class="small-box-footer">More info <i
                class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         -->
        <?php if (in_array('viewPlacement', $user_permission)): ?>

          <?php
          $sql = "SELECT * FROM applied_jobs";
          $query = $this->db->query($sql);
          $placement_count = $query->num_rows();
          ?>
          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner">
                <h3><?php echo $placement_count ?></h3>

                <p>Total Placements</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a data-toggle="modal" data-target="#totalPlacementModal" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
              <!--<a href="<?php echo site_url("jobs/viewJobs"); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
            </div>
          </div>

        <?php
        endif;
      } else {
        ?>
        <?php if (in_array('viewMech', $user_permission)): ?>

          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3><?php echo $placement_count_mech ?></h3>

                <p>Mechanical Placement</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('LoadPlacement/load_mechanical') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-fuchsia">
              <div class="inner">
                <h3><?php echo $count_mech ?></h3>

                <p>Mechanical Student Details</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php $name = "SAP";
                        echo site_url('load/') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>

          </div>
        <?php endif; ?>

        <?php if (in_array('viewSap', $user_permission)): ?>
          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-fuchsia">
              <div class="inner">
                <h3><?php echo $placement_count_sap ?></h3>

                <p> Head Placament SAP</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('LoadPlacement/load_sap') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-lime">
              <div class="inner">
                <h3><?php echo $count_sap ?></h3>

                <p>Head SAP</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('load/load_sap') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        <?php endif; ?>

        <?php if (in_array('viewelect', $user_permission)): ?>
          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-lime">
              <div class="inner">
                <h3><?php echo $placement_count_elect ?></h3>

                <p>Head Placement Electrical</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('LoadPlacement/load_electrical') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-maroon">
              <div class="inner">
                <h3><?php echo $count_electrical ?></h3>

                <p>Head Electrical</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('load/load_electrical') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

        <?php endif; ?>

        <?php if (in_array('viewCivil', $user_permission)): ?>
          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3><?php echo $placement_count_civil ?></h3>

                <p>Head Civil Placement</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('LoadPlacement/') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-maroon">
              <div class="inner">
                <h3><?php echo $count_civil ?></h3>

                <p>Head Civil</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('load/load_civil') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        <?php endif; ?>

        <?php if (in_array('viewdigital', $user_permission)): ?>
          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3><?php echo $placement_count_gdmkt ?></h3>

                <p>Head Digital Placement</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('LoadPlacement/load_digitalmarketing') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-maroon">
              <div class="inner">
                <h3><?php echo $count_dgmkt ?></h3>

                <p>Head Digital</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo site_url('load/load_Digitalmarketing') ?>" class="small-box-footer">More info <i
                  class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
      <?php endif;
      } ?>

      <!-- ./col -->
    </div>
    <!-- /.row -->

    <?php if (in_array('viewMyBatches', $this->permission)): ?>
      <style>
        .card {
          box-shadow: none;
          -webkit-box-shadow: none;
          -moz-box-shadow: none;
          -ms-box-shadow: none;
          padding: 10px;
        }

        .card>.box {
          position: relative;
          display: flex;
          flex-direction: column;
          min-width: 0;
          word-wrap: break-word;
          background-color: #fff;
          background-clip: border-box;
          border-radius: 20px;
          box-shadow: 0 0 28px -18px #444;
          overflow: hidden;
          padding: 20px;
        }

        .card>.box>* {
          font-weight: bold;
        }

        .card .card-block {
          padding: 1.25rem;
        }

        h6 {
          font-size: 16px !important;
          margin: 3px 0;
          color: black;
        }

        h5 {
          color: #555;
        }

        .text-c-green {
          color: #2ed8b6;
        }

        .m-l-10 {
          margin-left: 10px;
        }

        .proj-progress-card {
          margin: 15px auto;
        }

        .proj-progress-card .progress {
          height: 6px;
          overflow: visible;
          margin-bottom: 10px;
        }

        .proj-progress-card .progress .progress-bar {
          position: relative;
        }

        .progress .progress-bar {
          height: 100%;
          color: inherit;
        }

        .bg-c-red {
          background: #FF5370;
        }

        .proj-progress-card .progress .progress-bar.bg-c-red:after {
          border: 3px solid #FF5370;
        }

        .proj-progress-card .progress .progress-bar:after {
          content: "";
          background: #fff;
          position: absolute;
          right: -6px;
          top: -4px;
          border-radius: 50%;
          width: 15px;
          height: 15px;
        }

        .bg-c-blue {
          background: #4099ff;
        }

        .proj-progress-card .progress .progress-bar.bg-c-blue:after {
          border: 3px solid #4099ff;
        }

        .proj-progress-card .progress .progress-bar.bg-c-green:after {
          border: 3px solid #2ed8b6;
        }

        .bg-c-green {
          background: #2ed8b6;
        }

        .bg-c-yellow {
          background: #FFB64D;
        }

        .proj-progress-card .progress .progress-bar.bg-c-yellow:after {
          border: 3px solid #FFB64D;
        }

        .m-b-30 {
          margin-bottom: 30px;
        }

        .text-c-red {
          color: #FF5370;
        }

        .text-c-blue {
          color: #4099ff;
        }

        .text-c-yellow {
          color: #FFB64D;
        }
      </style>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">My Courses</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#inProggess">In Progress Courses</a></li>
            <li><a data-toggle="tab" href="#past">Past Courses</a></li>
          </ul>

          <div class="tab-content">
            <div id="inProggess" class="tab-pane fade in active container-fluid">
              <div class="row proj-progress-card">
                <?php
                $txt_classes = array("text-c-red", "text-c-blue", "text-c-green", "text-c-yellow");
                $bg_classes = array("bg-c-red", "bg-c-blue", "bg-c-green", "bg-c-yellow");
                $ips = $this->model_subjectnew->getInProgressAllocatedBatchesByFacultyId($this->userData['id']);
                $i = 0;
                if (sizeof($ips) > 0) {
                  foreach ($ips as $ip) {
                    if ($i == 4)
                      $i = 0;
                ?>
                    <div class="col-xl-3 col-md-3 card">
                      <a class="box" href="<?php echo base_url("batch/viewMyBatch/" . $ip['id']); ?>">
                        <h6><?php echo $ip['batch_name']; ?></h6>
                        <h5 class="m-b-30 f-w-700">In-Progress<span
                            class="<?php echo $txt_classes[$i]; ?> m-l-10"><?php echo $ip['progress']; ?>%</span></h5>
                        <div class="progress">
                          <div class="progress-bar <?php echo $bg_classes[$i]; ?>"
                            style="width:<?php echo $ip['progress']; ?>%"></div>
                        </div>
                      </a>
                    </div>
                  <?php
                    $i++;
                  }
                } else {
                  ?>
                  <div class="col-xl-12 col-md-12 card">
                    <a class="box">
                      <h6>No Record found!</h6>
                    </a>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
            <div id="past" class="tab-pane fade container-fluid">
              <div class="row proj-progress-card">

                <?php
                $txt_classes = array("text-c-red", "text-c-blue", "text-c-green", "text-c-yellow");
                $bg_classes = array("bg-c-red", "bg-c-blue", "bg-c-green", "bg-c-yellow");
                $pasts = $this->model_subjectnew->getPastAllocatedBatchesByFacultyId($this->userData['id']);
                $i = 0;
                if (sizeof($pasts) > 0) {
                  foreach ($pasts as $past) {
                    if ($i == 4)
                      $i = 0;
                ?>
                    <div class="col-xl-3 col-md-3 card">
                      <a class="box" href="<?php echo base_url("batch/viewMyBatch/" . $past['id']); ?>">
                        <h6><?php echo $past['batch_name']; ?></h6>
                        <h5 class="m-b-30 f-w-700">Past<span
                            class="<?php echo $txt_classes[$i]; ?> m-l-10"><?php echo $past['progress']; ?>%</span></h5>
                        <div class="progress">
                          <div class="progress-bar <?php echo $bg_classes[$i]; ?>"
                            style="width:<?php echo $past['progress']; ?>%"></div>
                        </div>
                      </a>
                    </div>
                  <?php
                    $i++;
                  }
                } else {
                  ?>
                  <div class="col-xl-12 col-md-12 card">
                    <a class="box">
                      <h6>No Record found!</h6>
                    </a>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    <?php endif; ?>


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboardMainMenu").addClass('active');
  });
</script>