<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-30 15:03:39
 Last Modification Date: 2024-04-26 17:49:39
*
**/
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Documents / Results</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Documents</li>
            <li class="active">Results</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="successMessage">
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
                </div>
                <div>

                    <div class="box">
                        <div class="box-header">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                                <h3 class="box-title">Result List</h3>
                            </div>
                            <!-- /.box-header -->
                        </div>
                        <div class="box-body table-responsive">
                            <style>
                            </style>
                            <table id="manageTable"
                                class="table table-bordered table-striped responsive display nowrap table-hover">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Document Title</th>
                                        <th>Batch</th>
                                        <th>Subject</th>
                                        <th>Type</th>
                                        <th>Result Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
?>
<style>
    .myBox {
        display: flex;
        align-items: center;
        justify-content: between;
        gap: 10px;
    }

    .myBox>div {
        width: 100%;
    }
</style>

<?php
if (in_array('deleteDocuments', $this->permission)):
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="removeResultModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="holder"></span>Delete Result</h4>
                </div>

                <form role="form" action="<?php echo base_url('documents/deleteResult') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Do you really want to delete Result?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete anyway</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <?php
endif;
?>
<?php
if (in_array('updateDocuments', $this->permission)):
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="updateResultModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Result</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="updateResult(this);return false;" method="post" id="submitResultForm"
                        enctype="multipart/form-data">
                        <div class="form-group" hidden>
                            <label for="rslt_document_id">Document ID</label>
                            <input type="number" class="form-control" id="rslt_document_id" name="document_id"
                                autocomplete="off" readonly />
                        </div>
                        <div class="form-group">
                            <label for="rslt_result_id">Result ID</label>
                            <input type="number" class="form-control" id="rslt_result_id" name="result_id"
                                autocomplete="off" readonly />
                        </div>
                        <div class="form-group">
                            <label for="document">Select Result File</label>
                            <input type="file" class="form-control" id="document" name="document" autocomplete="off"
                                multiple />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="rslt_submit_btn" form="submitResultForm" class="btn btn-primary">Submit
                        Result</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <?php
endif;
?>
<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function () {
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'documents/getResults/' + <?php echo $qid; ?>,
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
              buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
              ]
        });

    });

    <?php
    if (in_array('updateDocuments', $this->permission)):
        ?>
        function updateResult(form) {
            $("#rslt_submit_btn").attr("disabled", "");
            $.ajax({
                url: "<?php echo base_url('documents/updateResult') ?>",
                type: "post",
                data: new FormData(form),
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (res) {
                    if (res.status === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + res.message +
                            '</div>');
                        // hide the modal
                        $("#updateResultModal").modal('hide');
                        form.reset();
                    } else {

                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + res.message +
                            '</div>');
                    }
                }
            });
            $("#rslt_submit_btn").removeAttr("disabled");
        }

        function openUpdateResultModal(rid, qid) {
            $("#rslt_result_id").val(rid);
            $("#rslt_document_id").val(qid);
        }
        <?php
    endif;
    ?>
    <?php
    if (in_array('deleteDocuments', $this->permission)):
        ?>
        function deleteResult(id) {
            if (id) {
                $("#removeForm").on('submit', function () {

                    var form = $(this);

                    // remove the text-danger
                    $(".text-danger").remove();

                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: { id: id },
                        dataType: 'json',
                        success: function (response) {

                            manageTable.ajax.reload(null, false);

                            if (response.success === true) {
                                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                    '</div>');
                                // hide the modal
                                $("#removeResultModal").modal('hide');
                            } else {

                                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                    '</div>');
                            }
                        }
                    });

                    return false;
                });
            }
        }

        <?php
    endif;
    ?>
</script>