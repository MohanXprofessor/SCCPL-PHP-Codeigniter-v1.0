<?php
/*
 *
 * Author: Akash K Fulari
 * Contact-mail: akashfulari31@gmail.com
 * Description: ________________your_description_here_________________
 * Created: 2024-05-04 15:01:01
 Last Modification Date: 2024-05-07 17:36:46
 *
 **/
$query = $this->db->query("SELECT * FROM stores");
$projects = $query->result_array();

$sel_query = $this->db->query("SELECT distinct(`branch`) as branch_name FROM orders");
$project_list = $sel_query->result_array();

?>


<div class="modal fade" id="completedListModal" tabindex="-1" aria-labelledby="completedListModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="completedListModalLabel">Completed List</h5>
      </div>
      <div class="modal-body">
        <form action="orders/filter" method="get">

          <div class="form-group">
            <label for="brands">Select Project</label>
            <select class="form-control select_group" name="b">
              <?php
              foreach ($projects as $project) {
                ?>
                <option value="<?php echo $project['id'] ?>"><?php echo $project['name'] ?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <input type="hidden" name="s" value="1" />

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" style="margin-right:10px">View Batches</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="incompletedListModal" tabindex="-1" aria-labelledby="incompletedListModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="incompletedListModalLabel">Incompleted List</h5>
      </div>
      <div class="modal-body">
        <form action="orders/filter" method="get">

          <div class="form-group">
            <label for="brands">Select Project</label>
            <select class="form-control select_group" name="b">
              <?php
              foreach ($projects as $project) {
                ?>
                <option value="<?php echo $project['id'] ?>"><?php echo $project['name'] ?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <input type="hidden" name="s" value="0" />

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" style="margin-right:10px">View Batches</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="todayEnquiryListModal" tabindex="-1" aria-labelledby="todayEnquiryListModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="todayEnquiryListModalLabel">Total Enquiry List</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="brands">Select Project</label>
          <select class="form-control select_group" onchange="this.nextElementSibling.innerHTML=this.value">
            <option selected>Please Select Branch</option>
            <?php
            //echo $projects;die();
            $totalEnquiry_count = 0;
            foreach ($projects as $project) {
              $totalEnquiry = $this->db->get_where('enquiry', ['project_id' => $project['id']])->result();

              // if(sizeof($totalEnquiry)>0)
              //     $todayEnquiry_count = sizeof($totalEnquiry);
            
              $totalEnquiry_count = sizeof($totalEnquiry);

              ?>
              <option value="<?php echo $totalEnquiry_count ?>"><?php echo $project['name'] ?></option>
              <?php
            }
            ?>
          </select>
          <h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="remainingFeesEnquiryListModal" tabindex="-1" aria-labelledby="remainingFeesEnquiryListModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remainingFeesEnquiryListModalLabel">Remaning Fees Enquiry</h5>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label for="brands">Select Project</label>
                <select class="form-control select_group" onchange="this.nextElementSibling.innerHTML=this.value">
                <option selected>Please Select Branch</option>
                <?php
                // foreach($projects as $project){
                //     $feesEnquiry = $this->db->get_where('orders', ['branch_id' => $project['id']])->result();
                //     $feesEnquiry_fee = 0;
                
                //     foreach($feesEnquiry as $order)
                //         $feesEnquiry_fee += $order->remain;
                
                ?>
                    <option value="<?php //echo $feesEnquiry_fee ?>"><?php //echo $project['name'] ?></option>
                <?php
                //}
                ?>
                </select>
                <h3></h3>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="paidFeesEnquiryListModal" tabindex="-1" aria-labelledby="paidFeesEnquiryListModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paidFeesEnquiryListModalLabel">Paid Fees Enquiry</h5>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label for="brands">Select Branch</label>
                <select class="form-control select_group" onchange="this.nextElementSibling.innerHTML=this.value">
                <option selected>Please Select Branch</option>
                <?php
                // foreach($projects as $project){
                //     $feesEnquiry = $this->db->get_where('orders', ['branch_id' => $project['id']])->result();
                //     $feesEnquiry_fee = 0;
                
                //     foreach($feesEnquiry as $order)
                //         $feesEnquiry_fee += $order->pay;
                
                ?>
                    <option value="<?php //echo $feesEnquiry_fee ?>"><?php //echo $project['name'] ?></option>
                <?php
                // }
                ?>
                </select>
                <h3></h3>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

<div class="modal fade" id="ongoingBatchesModal" tabindex="-1" aria-labelledby="ongoingBatchesModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ongoingBatchesModalLabel">Ongoing Batches</h5>
      </div>
      <div class="modal-body">
        <form action="orders/view_ongoing_batches" method="get">
          <div class="form-group">
            <label for="brands">Select Branch</label>
            <select class="form-control select_group" name="b">
              <option selected>Please Select Branch</option>
              <?php
              foreach ($projects as $project) {
                ?>
                <option value="<?php echo $project['id'] ?>"><?php echo $project['name'] ?></option>
                <?php
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="brands">Select Branch</label>
            <select class="form-control select_group" name="name">
              <option selected>Please Select Course Branch</option>
              <?php
              foreach ($project_list as $project) {
                ?>
                <option value="<?php echo $project['branch_name'] ?>"><?php echo $project['branch_name'] ?></option>
                <?php
              }
              ?>
            </select>
          </div>


          <div class="box-footer">
            <button type="submit" class="btn btn-primary" style="margin-right:10px">Save Changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="totalPlacementModal" tabindex="-1" aria-labelledby="totalPlacementModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="totalPlacementModalLabel">All Placements</h5>
      </div>
      <div class="modal-body">
        <form action="Jobs/jobFilter" method="get">
          <div class="form-group">
            <label for="brands">Select Project</label>
            <select class="form-control select_group" name="b">
              <option selected>Please Select Project</option>
              <?php
              foreach ($projects as $project) {
                ?>
                <option value="<?php echo $project['id'] ?>"><?php echo $project['name'] ?></option>
                <?php
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="brands">Select Status</label>
            <select class="form-control select_group" name="s">
              <option value="-1">Rejected</option>
              <option value="0">Pending</option>
              <option value="1">Selected</option>
              <option value="2">Joined</option>
            </select>
          </div>

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" style="margin-right:10px">View Data</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>