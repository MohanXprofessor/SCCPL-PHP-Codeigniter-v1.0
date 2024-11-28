<div class="modal fade" tabindex="-1" role="dialog" id="addModal1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Allocate Batch</h4>
        </div>

<form role="form" action="#" method="post" id="createForm">

<div class="modal-body">

  <div class="form-group">
    <label for=""></label>
    <!-- <input type="text" value="<?php //$data['name'] ?>"> -->
    <!-- <label for="brand_name">Allocated Batch</label>
    <input type="text" class="form-control" id="store_name" name="store_name" placeholder="Enter Project name"
      autocomplete="off"> -->
  </div>
  <div class="form-group">
    <label for="active">Select Batch</label>
    <select class="form-control" id="active" name="active">
      <option value="1">Active</option>
      <option value="2">Inactive</option>
    </select>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Reset</button>
  <button type="submit" class="btn btn-primary">Submit</button>
</div>

</form>

</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
