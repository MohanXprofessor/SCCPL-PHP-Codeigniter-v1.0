<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 0.1.0
  </div>
  <strong>Copyright &copy; 2018-<?php echo date('Y') ?>.</strong> All rights reserved.
</footer>

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

</body>

</html>

<script>
  function errorSessionDestory() {
    $.ajax({
      url: "<?php echo base_url(); ?>myerrors/remove",
      type:"post",
      data: {flag:0},
      success: function (response) { },
      error: function (error) {
      }
    });
  }
  
  function loadCount() {
    $.ajax({
      url: "<?php echo base_url(); ?>enrollment/loadcountEnrollmentCount",
      type: "post",
      data: { flag: 0 },
      success: function (response) {
        if (response != 0)
          $(".enrollRequestCounter").show();
        else
          $(".enrollRequestCounter").hide();
        $(".enrollRequestCounter").html(response);
      },
      error: function (error) {
        $(".enrollRequestCounter").hide();
      }
    });
    setTimeout(loadCount, 10000);
  }
  loadCount();
</script>