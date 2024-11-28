<?php

/*
 * Created By: Akash K. Fulari
 * On Date: 23-03-2024
 */
?>

<style>
	.divider {
		height: 1px;
		margin: 9px 0;
		overflow: hidden;
		background-color: #e5e5e5;
	}
</style>

<div class="content-wrapper">
	<link rel="stylesheet" href="<?php echo base_url('assets/dist/css/viewDeatilsPage.min.css') ?>">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			View
			<small>Job Details</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Job Details</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="box">
			<div class="box-header">
				<div style="display:flex;align-items:center:justify-content:space-between;">
					<h3 class="box-title" style="width:50%">Job Details</h3>

				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<?php
				if ($job != null) {
					?>
					<div class="container-fliud">
						<div class="row">
							<div class="details col-md-12">
								<h3 class="product-title"><?php echo $job['job_title'] ?></h3>
								<label class="price" style="margin:3px 0"><?php echo $job['company_name'] ?></label>
								<div class="rating" style="padding:0 20px">
									<?php
									if ($branch != null) {
										?>
										<span style="width:100;display:block;padding:3px 0">Project:
											<span><?php echo $branch['name'] ?></span></span>
									<?php
									}
									?>
									<span style="width:100;display:block;padding:3px 0">Job ID:
										<span><?php echo $job['job_id'] ?></span></span>
									<span style="width:100;display:block;padding:3px 0">Role:
										<span><?php echo $job['job_possition'] ?></span></span>
								</div>
								<span style="width:100;display:block;padding:3px 0"><b>Job Description:</b></span>
								<p class="product-description" style="padding:0 20px"><?php echo $job['job_description'] ?>
								</p>
								<span style="width:100;display:block;padding:3px 0"><b>Qualification:</b></span>
								<p class="product-description" style="padding:0 20px"><?php echo $job['qualification'] ?>
								</p>
								<span style="width:100;display:block;padding:3px 0"><b>No.Of Vaccancy:</b></span>
								<h4 class="price"><span><?php echo $job['no_of_vaccancy'] ?></span></h4>

								<?php
								$buttons = "";
								$status = "";
								if ($userGroup == "Student") {
									$isStudentJoined = $this->model_appliedjobs->isStudentJoined($userId);

									$appliedJobs = $model_appliedjobs->getAppliedJobData($job['id'], $userId);
									if ($appliedJobs) {
										$buttons = "<span class='label label-success'>Applied</span>";
										$appliedJobs = $appliedJobs[0];

										if ($appliedJobs['status'] == -1)
											$status = "<span class='label label-danger'>Rejected</span>";
										else if ($appliedJobs['status'] == 0)
											$status = "<span class='label label-primary'>Pending</span>";
										else if ($appliedJobs['status'] == 1)
											$status = "<span class='label label-success'>Shortlisted</span>";
									} else {
										$status = "<span class='label label-warning'>Not Applied</span>";

										if (!$isStudentJoined && $job['active'] == 1) {
											$buttons .= ' <a type="button" class="btn btn-sm btn-success d-block" href="' . base_url('jobs/applyJob/' . $job['id']) . '"><i class="fa fa-send"></i> Apply This Job</a>';
										}
									}
									?>
									<span style="width:100;display:block;padding:3px 0"><b>Status:</b></span>
									<p class="product-description" style="padding:0 20px"><?php echo $status; ?></p>
									<?php
								}
								?>
								<div class="divider"></div>
								<div class="action">
									<span style="width:100;display:block;padding:3px 0"><b>Actions:</b></span>
									<div style="display:flex;align-items:center;justify-content:flex-start;gap:10px">
										<?php echo $buttons; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				} else {
					?>
					<h1>Sorry!. No record found.</h1>
				<?php
				}
				?>
			</div>
		</div>

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->