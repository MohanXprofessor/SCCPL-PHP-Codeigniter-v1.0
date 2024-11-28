<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-30 15:03:39
 Last Modification Date: 2024-05-09 17:12:56
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
            <small>Documents</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Documents</li>
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
                <div style="display:flex;align-items:center;justify-content:flex-start;gap:7px;margin-bottom:20px">
                    <?php
                    if (in_array('createDocuments', $this->permission)):
                        ?>
                        <a data-target="#addDocumentModal" data-toggle="modal" class="btn btn-primary">Add Document</a>
                        <?php
                    endif;
                    ?>
                </div>
                <div>

                    <div class="box">
                        <div class="box-header">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                                <h3 class="box-title">Document List</h3>
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
                                        <th>Document Attachment</th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="removeDocumentModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span class="holder"></span>Delete Document</h4>
                </div>

                <form role="form" action="<?php echo base_url('documents/delete') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Do you really want to delete Document</p>
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
if (in_array('createDocuments', $this->permission)):
    ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="addDocumentModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Document</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="addDocument(this);return false;" method="post" id="addDocumentForm"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Document Title</label>
                            <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="batch_id">Select Batch</label>
                            <select class='form-control batchAppendar' name='batch' id='batch_id'
                                onchange='loadSubjects(this, "#subjectAppendar1")'></select>
                        </div>
                        <div class="form-group">
                            <label for="subject_id">Select Subject</label>
                            <div id="subjectAppendar1"></div>
                        </div>
                        <div class="form-group">
                            <label for="type">Select Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="1">Grade 1</option>
                                <option value="2">Grade 2</option>
                                <option value="3">Grade 3</option>
                                <option value="4">Assessment 1</option>
                                <option value="5">Assessment 2</option>
                                <option value="6">Assessment 3</option>
                                <option value="7">Event</option>
                                <option value="8">Project Docs</option>
                                <option value="9">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="document">Select Document</label>
                            <input type="file" class="form-control" id="document" name="document" autocomplete="off">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" form="addDocumentForm" class="btn btn-primary">Add Document</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <?php
endif;
?>
<?php
if (in_array('updateDocuments', $this->permission)):
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="updateDocumentModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Document</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="updateDocument(this);return false;" method="post" id="updateDocumentForm"
                        enctype="multipart/form-data">
                        <div class="form-group" hidden>
                            <label for="updt_document_id">Document ID</label>
                            <input type="number" class="form-control" id="updt_document_id" name="document_id"
                                autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label for="updt_title">Document Title</label>
                            <input type="text" class="form-control" id="updt_title" name="title" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="updt_batch_id">Select Batch</label>
                            <select class='form-control batchAppendar' name='batch' id='updt_batch_id'
                                onchange='loadSubjects(this, "#subjectAppendar2")'></select>
                        </div>
                        <div class="form-group">
                            <label for="updt_subject_id">Select Subject</label>
                            <div id="subjectAppendar2"></div>
                        </div>
                        <div class="form-group">
                            <label for="updt_type">Select Type</label>
                            <select class="form-control" id="updt_type" name="type">
                                <option value="1">Grade 1</option>
                                <option value="2">Grade 2</option>
                                <option value="3">Grade 3</option>
                                <option value="4">Assessment 1</option>
                                <option value="5">Assessment 2</option>
                                <option value="6">Assessment 3</option>
                                <option value="7">Event</option>
                                <option value="8">Project Docs</option>
                                <option value="9">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="document">Select Document</label>
                            <input type="file" class="form-control" id="document" name="document" autocomplete="off">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" form="updateDocumentForm" class="btn btn-primary">Update Question
                        Paper</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <?php
endif;
?>
<?php
if (in_array('createDocuments', $this->permission)):
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="addResultModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Submit Result</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="addResult(this);return false;" method="post" id="submitResultForm"
                        enctype="multipart/form-data">
                        <div class="form-group" hidden>
                            <label for="rslt_document_id">Document ID</label>
                            <input type="number" class="form-control" id="rslt_document_id" name="document_id"
                                autocomplete="off" readonly />
                        </div>
                        <div class="form-group">
                            <label>Document</label>
                            <input type="text" class="form-control" id="q_title" disabled readonly />
                        </div>
                        <div class="form-group">
                            <label for="document">Select Result Files</label>
                            <input type="file" class="form-control" id="document" name="document[]" autocomplete="off"
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
        $.ajax({
            url: "<?php echo base_url('documents/loadBatchesByUid/') ?>" + <?php echo $userData['id']; ?>,
            type: "get",
            data: {},
            dataType: "json",
            success: function (res) {
                if (res.status) {
                    $(".batchAppendar").html(res.message);
                } else {
                    $(".batchAppendar").html("<option>NO batches found!</option>");
                }

                $(".batchAppendar").trigger('change');
            }
        });
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'documents/getDocuments/' + <?php echo $userData['id']; ?>,
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
              buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
              ]
        });

    });

    function loadSubjects(me, ele) {
        $.ajax({
            url: "<?php echo base_url('documents/loadSubjectsByBidAndFacultyId/') ?>" + <?php echo $userData['id']; ?> + "/" + me.value,
            type: "get",
            data: {},
            dataType: "json",
            success: function (res) {
                if (res.status) {
                    $(ele).html(res.message);
                } else {
                    $(ele).html("<option>No Subject found!</option>");
                }
            }
        });

    }

    <?php
    if (in_array('createDocuments', $this->permission)):
        ?>
        function addDocument(form) {
            $.ajax({
                url: "<?php echo base_url('documents/create') ?>",
                type: "post",
                data: new FormData(form),
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (res) {
                    if (res.status === true) {
                        manageTable.ajax.reload(null, false);
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + res.message +
                            '</div>');
                        // hide the modal
                        $("#addDocumentModal").modal('hide');
                    } else {

                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + res.message +
                            '</div>');
                    }
                }
            });
        }

        <?php
    endif;
    ?>
    <?php
    if (in_array('updateDocuments', $this->permission)):
        ?>
        function updateDocument(form) {
            $.ajax({
                url: "<?php echo base_url('documents/update') ?>",
                type: "post",
                data: new FormData(form),
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (res) {
                    if (res.status === true) {
                        manageTable.ajax.reload(null, false);

                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + res.message +
                            '</div>');

                        $("#updateDocumentModal").modal('hide');
                    } else {
                        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + res.message +
                            '</div>');
                    }
                }
            });
        }

        function openUpdateDocumentModal(qid, title, bid, sid, type) {
            $("#updt_document_id").val(qid);
            $("#updt_title").val(title);
            $("#updt_batch_id").val(bid);
            $("#updt_subject_id").val(sid);
            $("#updt_type").val(type);
        }

        <?php
    endif;
    ?>
    <?php
    if (in_array('createDocuments', $this->permission)):
        ?>
        function addResult(form) {
            $("#rslt_submit_btn").attr("disabled", "");
            $.ajax({
                url: "<?php echo base_url('documents/submitResult') ?>",
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
                        $("#addResultModal").modal('hide');
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

        function openSubmitResultModal(qid, title) {
            $("#rslt_document_id").val(qid);
            $("#q_title").val(title);
        }

        <?php
    endif;
    ?>
    <?php
    if (in_array('deleteDocuments', $this->permission)):
        ?>
        function deleteDocument(id) {
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
                                $("#removeDocumentModal").modal('hide');
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