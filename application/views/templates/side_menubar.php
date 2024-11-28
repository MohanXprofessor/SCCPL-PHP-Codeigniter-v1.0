<style>
	.enrollRequestCounter {
		position: absolute;
		right: 0;
		z-index: 4;
		display: inline;
	}
</style>
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">

			<li id="dashboardMainMenu">
				<a href="<?php echo base_url('dashboard') ?>">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>

			<!--  <?php if (in_array('updateOrder', $user_permission)): ?>-->
			<!-- <li class="treeview" id="mainOrdersNav">-->
			<!--     <a href="#">-->
			<!--       <i class="glyphicon glyphicon-stats"></i>-->
			<!--       <span>Enquiry</span>-->
			<!--       <span class="pull-right-container">-->
			<!--         <i class="fa fa-angle-left pull-right"></i>-->
			<!--       </span>-->
			<!--     </a>-->
			<!--     <ul class="treeview-menu">-->
			<!--     <li id="lead"><a href="<?php echo base_url('counseller/create') ?>"><i class="fa fa-circle-o"></i> Add Enquiry</a></li>-->
			<!--     <li id="lead"><a href="<?php echo base_url('counseller') ?>"><i class="fa fa-circle-o"></i> Todays Enquiry</a></li>-->
			<!--     <li id="lead"><a href="<?php echo base_url('counseller/all_lead') ?>"><i class="fa fa-circle-o"></i> ALL Enquiry</a></li>     -->
			<!--  </ul>-->
			<!--</li> -->
			<!--<?php endif; ?>-->

			<?php if (in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
				<li class="treeview" id="storeNav">
					<a href="#">
						<i class="fa fa-cube"></i>
						<span>Project</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<!-- <?php if (in_array('createStore', $user_permission)): ?>
				  <li id="addProductNav"><a href="<?php echo base_url('stores/create') ?>"><i class="fa fa-circle-o"></i> Add Project</a></li>
				<?php endif; ?> -->
						<?php if (in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
							<li id="manageProductNav"><a href="<?php echo base_url('stores/') ?>"><i class="fa fa-circle-o"></i>
									Manage
									Projects</a></li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>

			<?php if (in_array('createBrand', $user_permission) || in_array('updateBrand', $user_permission) || in_array('viewBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
				<li class="treeview" id="brandNav">
					<a href="#">
						<i class="glyphicon glyphicon-tags"></i>
						<span>Courses</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<!-- <?php if (in_array('createBrand', $user_permission)): ?>
				<li id="addProductNav"><a href="<?php echo base_url('brands/create') ?>"><i class="fa fa-circle-o"></i> Add
					Course</a></li>
			  <?php endif; ?> -->
						<?php if (in_array('updateBrand', $user_permission) || in_array('viewBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
							<li id="manageProductNav"><a href="<?php echo base_url('brands/') ?>"><i class="fa fa-circle-o"></i>
									Manage
									Courses</a></li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>

			<li class="treeview" id="mainProductNav">
				<a href="#">
					<i class="fa fa-cube"></i>
					<span>Subject</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<?php if (in_array('addSubject', $user_permission)): ?>
						<li id="addProductNav"><a href="<?php echo base_url('subject/addSubject') ?>"><i
									class="fa fa-circle-o"></i> Add Subject</a></li>
					<?php endif; ?>
					<?php if (in_array('updateProduct', $user_permission) || in_array('viewSubject', $user_permission) || in_array('deleteSubject', $user_permission)): ?>
						<li id="manageProductNav"><a href="<?php echo base_url('subject/addSubject') ?>"><i
									class="fa fa-circle-o"></i> Manage Subject</a></li>
					<?php endif; ?>
				</ul>
			</li>

			<?php if (in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
				<li class="treeview" id="orderNav">
					<a href="#">
						<i class="glyphicon glyphicon-stats"></i>
						<span>Enquiry</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<?php if (in_array('createOrder', $user_permission)): ?>
							<li id="addProductNav"><a href="<?php echo base_url('enquiry/create') ?>"><i
										class="fa fa-circle-o"></i>
									Create Enquiry</a></li>
						<?php endif; ?>
						<?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
							<li id="manageProductNav"><a href="<?php echo base_url('enquiry/manage') ?>"><i
										class="fa fa-circle-o"></i>
									Manage
									Enquiry</a></li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>


			<?php if (in_array('updateScreeningTest', $user_permission) || in_array('viewScreeningTest', $user_permission) || in_array('deleteScreeningTest', $user_permission)): ?>
				<li class="treeview" id="orderNav">
					<a href="#">
						<i class="fa fa-dollar"></i>
						<span>Screening Test</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li id="manageOrdersNav"><a href="<?php echo base_url('screeningtest/tempenrollmentIndex') ?>"><i
									class="fa fa-circle-o"></i>Manage Enroll Request</a></li>
						<li id="manageProductNav"><a href="<?php echo base_url('screeningtest/manage') ?>"><i
									class="fa fa-circle-o"></i> Manage
								Screening Test</a></li>
					</ul>
				</li>
			<?php endif; ?>
			<?php if (in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
				<li class="treeview d-flex align-items-center" id="mainOrdersNav">
					<a href="#">
						<i class="fa fa-dollar"></i>
						<span>Enrollment</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
						<span class="label label-success enrollRequestCounter" hidden>0</span>
					</a>
					<ul class="treeview-menu">
						<?php if (in_array('createOrder', $user_permission)): ?>
							<!-- <li id="addOrderNav"><a href="<?php //echo base_url('enrollment/create') 
																?>"><i class="fa fa-circle-o"></i> Add
				  Enrollment</a></li>
			<?php endif; ?> -->
							<?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
								<li id="manageOrdersNav"><a href="<?php echo base_url('enrollment') ?>"><i
											class="fa fa-circle-o"></i> Manage
										Enrollment</a></li>
								<li id="manageOrdersNav"><a style="display:flex;align-items:center"
										href="<?php echo base_url('enrollment/enrollment_requests') ?>"><i
											class="fa fa-circle-o"></i> Manage
										Enrollment Requests
										<span class="pull-right-container d-flex align-items-center">
											<span class="label label-success enrollRequestCounter" hidden>0</span>
										</span>
									</a>
								</li>
							<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>

			<?php if (in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
				<li class="treeview" id="mainProductNav">
					<a href="#">
						<i class="fa fa-cube"></i>
						<span>Batches</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<?php if (in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
							<li id="manageProductNav"><a href="<?php echo base_url('batch/create') ?>"><i
										class="fa fa-circle-o"></i>
									Create
									Batches</a></li>
						<?php endif; ?>
						<?php if (in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
							<li id="manageProductNav"><a href="<?php echo base_url('batch') ?>"><i class="fa fa-circle-o"></i>
									Manage
									Batches</a></li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>

			<?php if (in_array('createAttendance', $user_permission) || in_array('updateAttendance', $user_permission) || in_array('viewAttendance', $user_permission) || in_array('deleteAttendance', $user_permission)): ?>

				<li class="treeview" id="storeNav">
					<a href="#">
						<i class="fa fa-calendar"></i>
						<span>Attendance</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li id="manageProductNav"><a href="<?php echo base_url('attendance/student') ?>"><i
									class="fa fa-circle-o"></i> Manage Students</a></li>
						<li id="manageProductNav"><a href="<?php echo base_url('attendance/staff') ?>"><i
									class="fa fa-circle-o"></i>
								Manage Staff</a></li>
					</ul>
				</li>

			<?php endif; ?>
			<?php if ($user_permission): ?>
				<?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
					<li class="treeview" id="mainUserNav">
						<a href="#">
							<i class="fa fa-users"></i>
							<span>Users</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<?php if (in_array('createUser', $user_permission)): ?>
								<li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i
											class="fa fa-circle-o"></i> Add
										User</a></li>
							<?php endif; ?>

							<?php if (in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
								<li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i>
										Manage
										Users</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>



				<?php if (in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
					<li class="treeview" id="mainGroupNav">
						<a href="#">
							<i class="fa fa-files-o"></i>
							<span>Groups</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<?php if (in_array('createGroup', $user_permission)): ?>
								<li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i
											class="fa fa-circle-o"></i> Add
										Group</a></li>
							<?php endif; ?>
							<?php if (in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
								<li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i>
										Manage
										Groups</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ((in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)) & (1 < 0)): ?>
					<li id="categoryNav">
						<a href="<?php echo base_url('category/') ?>">
							<i class="fa fa-files-o"></i> <span>Training Type</span>
						</a>
					</li>
				<?php endif; ?>

				<!--NEW SIDEBAR MENU New added By Ramiz 3/4/2019 if student fees is remain then not access permissioin to placement -->
				<?php if (in_array('createPlacement', $user_permission) || in_array('viewPlacment', $user_permission)): ?>
					<li class="treeview" id="mainOrdersNav">
						<a href="#">
							<i class="fa fa-dollar"></i>
							<span>Placement</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<?php if (in_array('viewStudent', $user_permission)) {
								$emt = $_SESSION['email'];

								$sql = "SELECT * FROM orders WHERE customer_gst='$emt'";
								$query = $this->db->query($sql);
								$da = $query->result_array();
								//  var_dump($da);
								//  die();
								foreach ($da as $value) {
									$ord = $value['id']; ?>


									<li id="studentDetail"><a href="<?php echo base_url('placement/student_detail/' . $ord) ?>"><i
												class="fa fa-circle-o"></i> Student Detail</a></li>
									<li id="course_status"><a href="<?php echo base_url('placement/course_status/' . $ord) ?>"><i
												class="fa fa-circle-o"></i> Course Status</a></li>


									<?php if ($value['remain'] == 0.00) {

									?>
										<?php if (in_array('createPlacement', $user_permission)) { ?>

											<?php
											$sql = "SELECT * FROM placement WHERE  email='$emt'";
											$query = $this->db->query($sql);
											$data = $query->result_array();
											if ($data == null) { ?>
												<li id="addPlacement"><a href="<?php echo base_url('placement/create') ?>"><i
															class="fa fa-circle-o"></i> Apply Placement</a></li>
												{ ?>

											<?php }
											foreach ($data as $value) {
												$id = $value['id'];

											?>



												<li id="viwPlacement"><a href="<?php echo base_url('placement/view/' . $id) ?>"><i
															class="fa fa-circle-o"></i> View Placement</a></li>

												<li id="uloadPlacement"><a href="<?php echo base_url('placement/resume/' . $id) ?>"><i
															class="fa fa-circle-o"></i> Upload Placement</a></li>


								<?php }
										}
									}
								}
							} else { ?>


								<?php if (in_array('createPlacement', $user_permission)) { ?>
									<li id="addPlacement"><a href="<?php echo base_url('placement/create') ?>"><i
												class="fa fa-circle-o"></i> Apply Placement</a></li>
							<?php }
							} ?>

							<?php if (in_array('updatePlacement', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
								<li id="managePlacement"><a href="<?php echo base_url('placement') ?>"><i
											class="fa fa-circle-o"></i> Manage Placement</a></li>

								<!-- New for sort wagholi and shivajinagar placement -->
								<!--<li class="treeview" id="mainOrdersNav">-->
								<!--	<a href="#">-->
								<!--		<i class="fa fa-dollar"></i>-->
								<!--		<span>Manage</span>-->
								<!--		<span class="pull-right-container">-->
								<!--			<i class="fa fa-angle-left pull-right"></i>-->
								<!--		</span>-->
								<!--	</a>-->
								<!--	<ul class="treeview-menu">-->
								<!--		<li id="managePlacement"><a href="<?php //echo base_url('placement/placement_wagholi') 
																				?>"><i-->
								<!--					class="fa fa-circle-o"></i>KHARADI</a></li>-->
								<!--		<?php //if ($_SESSION['branch_id'] != 2) { 
											?>-->
								<!--			<li id="managePlacement"><a-->
								<!--					href="<?php //echo base_url('placement/placement_shivajinagar') 
																?>"><i-->
								<!--						class="fa fa-circle-o"></i>Shivajinagar</a></li>-->
								<!--		<?php //} 
											?>-->
								<!--	</ul>-->
								<!--</li>-->
							<?php endif; ?>


						</ul>
					</li>
				<?php endif; ?>

				<!--NEW SIDEBAR MENU New added By Akash 07/03/2024 -->
				<?php if (in_array('createPlacement', $user_permission) || in_array('viewPlacment', $user_permission)): ?>
					<li class="treeview" id="mainOrdersNav">
						<a href="#">
							<i class="glyphicon glyphicon-stats"></i>
							<span>Jobs</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<?php if (in_array('createPlacement', $user_permission) && $userGroup != "Student"): ?>
								<li id="addJob"><a href="<?php echo base_url("jobs/create"); ?>"><i class="fa fa-circle-o"></i> Add
										Jobs</a>
								</li>
							<?php endif; ?>
							<?php if ($userGroup != "Student"): ?>
								<li>
									<a href="<?php echo base_url('jobs/viewJobs') ?>">
										<i class="fa fa-circle-o"></i>
										<!--<span>Manage Jobs</span>-->
										<span>Manage Placement</span>
									</a>
								</li>
							<?php endif; ?>

							<?php if (in_array('viewPlacement', $user_permission) && $userGroup == "Student"): ?>
								<li><a href="<?php echo base_url("jobs/viewAllJobs"); ?>"><i class="fa fa-circle-o"></i> My Jobs</a>
								</li>
								<li><a href="<?php echo base_url("jobs/viewPendingJobs"); ?>"><i class="fa fa-circle-o"></i> Pending
										Jobs</a>
								</li>
								<li><a href="<?php echo base_url("jobs/viewRejectedJobs"); ?>"><i class="fa fa-circle-o"></i>
										Rejected
										Jobs</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<!-- END MENU -->
				<!--NEW SIDEBAR MENU New added By Akash 27/04/2024 -->
				<?php if (in_array('viewMyBatches', $this->permission)): ?>
					<li class="treeview" id="mainOrdersNav">
						<a href="#">
							<i class="fa fa-briefcase"></i>
							<span>Documents</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li>
								<a href="<?php echo base_url('documents/index') ?>">
									<i class="fa fa-circle-o"></i>
									<span>Manage Documents</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="treeview" id="mainOrdersNav">
						<a href="#">
							<i class="fa fa-users"></i>
							<span>My Batches</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<?php
							$subjects = $this->model_subjectnew->getAllocatedBatchesByFacultyId($this->userData['id']);
							if (sizeof($subjects) > 0) {
								foreach ($subjects as $subject) {
									$bid = $subject["bid"];
									$b = $this->model_batch->single_batch($bid);
									if ($b != null) {
										echo '
										<li>
											<a href="' . base_url("batch/viewMyBatch/" . $b['id']) . '">
											<i class="fa fa-circle-o"></i>
											<span>' . $b['batch_name'] . '</span>
											</a>
										</li>';
									}
								}
							} else {
								echo '<li><a><i class="fa fa-circle-o"></i><span>NO Batches Allocated</span></a></li>';
							}
							?>
						</ul>
					</li>
					<!-- END MENU -->
				<?php endif; ?>

				<?php if (in_array('viewReports', $user_permission)): ?>
					<li class="treeview" id="mainOrdersNav">
						<a href="#">
							<i class="glyphicon glyphicon-stats"></i>
							<span>Reports</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li id="reportNav">
								<a href="<?php echo base_url('reports/batch_wise_student') ?>">
									<i class="fa fa-bar-chart"></i> <span>Batchwise Student</span>
								</a>
							</li>
							<li id="reportNav">
								<a href="<?php echo base_url('reports/batch_wise_completion') ?>">
									<i class="fa fa-bar-chart"></i> <span>Batchwise Completion</span>
								</a>
							</li>
							<li id="reportNav">
								<a href="<?php echo base_url('reports/trainer_wise_student') ?>">
									<i class="fa fa-bar-chart"></i> <span>Trainerwise Student</span>
								</a>
							</li>
							<li id="reportNav">
								<a href="<?php echo base_url('reports/total_active_student') ?>">
									<i class="fa fa-bar-chart"></i> <span>Total Active Student</span>
								</a>
							</li>
							<li id="reportNav">
								<a href="<?php echo base_url('reports/total_completed_student') ?>">
									<i class="fa fa-bar-chart"></i> <span>Total Completed Student</span>
								</a>
							</li>
							<li id="reportNav">
								<a href="<?php echo base_url('reports/palcement_eligible_students') ?>">
									<i class="fa fa-bar-chart"></i> <span>Placement Eligible Student</span>
								</a>
							</li>
							<li id="reportNav">
								<a href="<?php echo base_url('reports/project_wise_enrollment') ?>">
									<i class="fa fa-bar-chart"></i> <span>Projectwise Enrollement</span>
								</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if (in_array('updateCompany', $user_permission) && (1 < 0)): ?>
					<li id="companyNav"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-files-o"></i>
							<span>Organization</span></a></li>
				<?php endif; ?>


				<!-- kdk  Assessment Tab  -->


				<!-- <li class="treeview" id="mainProductNav">
					<a href="#">
						<i class="fa fa-user-o"></i>
						<span>Assessment</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<?php if (in_array('addSubject', $user_permission)): ?>
							<li id="addProductNav"><a href="<?php echo base_url('assessments/index') ?>"><i
										class="fa fa-circle-o"></i> Add Assessment</a></li>
						<?php endif; ?>
						<?php if (in_array('updateProduct', $user_permission) || in_array('viewSubject', $user_permission) || in_array('deleteSubject', $user_permission)): ?>
							<li id="manageProductNav"><a href="<?php echo base_url('assessments/index') ?>"><i
										class="fa fa-circle-o"></i> Add Assessment</a>
							</li>

							<li id="manageProductNav"><a href="<?php echo base_url('assessments/show_assessment') ?>"><i
										class="fa fa-circle-o"></i> Manage Assessment</a>
							</li>

						<?php endif; ?>
					</ul>
				</li> -->



				<!-- ork  -->

				<?php if (in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
					<li class="treeview" id="orderNav">
						<a href="#">
							<i class="fa fa-user-o"></i>
							<span>Assessment</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<?php if (in_array('createOrder', $user_permission)): ?>
								<li id="addProductNav"><a href="<?php echo base_url('assessments/index') ?>"><i
											class="fa fa-circle-o"></i>
										Create Assessments</a></li>
							<?php endif; ?>
							<?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
								<li id="manageProductNav"><a href="<?php echo base_url('Assessments/show') ?>"><i
											class="fa fa-circle-o"></i>
										Manage
										Assessment</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>



				<!-- end  -->


				<!-- <li class="header">Settings</li> -->

				<?php if (in_array('viewProfile', $user_permission)): ?>
					<li><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>Profile</span></a>
					</li>
				<?php endif; ?>
				<?php if (in_array('updateSetting', $user_permission)): ?>
					<li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>Setting</span></a>
					</li>
				<?php endif; ?>

			<?php endif; ?>
			<!-- user permission info -->
			<li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i>
					<span>Logout</span></a></li>

		</ul>
	</section>
	<!-- /.sidebar -->
</aside>