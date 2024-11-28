<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-04-27 17:33:57
 Last Modification Date: 2024-05-09 18:47:43
*
**/


?>

<style>
    .dataTables_scrollHeadInner {
        width: 100% !important;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="margin-bottom:10px !important;">
        <h1>
            Dashboard
            <small>My Batch Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li>My Batch Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div id="messages"></div>
        <?php
        if (in_array('viewMyBatches', $this->permission)):
            ?>
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
                    <h3 class="box-title"><?php echo $bdata['batch_name']; ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#students">Batch Students</a></li>
                        <li><a data-toggle="tab" href="#paper">Question Paper</a></li>
                        <li><a data-toggle="tab" href="#results">Results</a></li>
                        <li><a data-toggle="tab" href="#projects">Project documents</a></li>
                        <li><a data-toggle="tab" href="#stdmaterials">Study Material</a></li>
                        <li><a data-toggle="tab" href="#syllabus">Syllabus</a></li>
                        <li><a data-toggle="tab" href="#otherDocs">Other Documents</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="students" class="tab-pane active container-fluid">
                            <div style="padding:20px">
                                <!-- Table to display data -->
                                <table id="manageTable1" class="table table-bordered table-striped nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Student Name</th>
                                            <th>Location</th>
                                            <th>Email Id</th>
                                            <th>Contact No</th>
                                            <th>Project</th>
                                            <th>Batch</th>
                                            <th>Subject</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div id="paper" class="tab-pane fade container-fluid">
                            <div
                                style="display:flex;align-items:center;justify-content:flex-start;gap:7px;margin:20px 5px 5px 5px">
                                <?php if (in_array('createDocuments', $this->permission)): ?>
                                    <button data-target="#addModal" data-toggle="modal" class="btn btn-primary">
                                        Add Question Paper
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="padding:20px">
                                <!-- Table to display data -->
                                <table id="manageTable2" class="table table-bordered table-striped nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Title</th>
                                            <th>Batch</th>
                                            <th>Subject</th>
                                            <th>Project</th>
                                            <!-- <th>Batch</th> -->
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div id="results" class="tab-pane fade container-fluid">
                            <div style="padding:20px">
                                <!-- Table to display data -->
                                <table id="manageTable"
                                    class="table table-bordered table-striped responsive display nowrap table-hover">
                                    <thead style="width:100% !imoortant;">
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Student Name</th>
                                            <th>Email Id</th>
                                            <th>Project</th>
                                            <th>Course Name</th>
                                            <th>Subject Title</th>
                                            <th>Grade 1</th>
                                            <th>Grade 2</th>
                                            <th>Grade 3</th>
                                            <th>Assessment 1</th>
                                            <th>Assessment 2</th>
                                            <th>Assessment 3</th>
                                            <th>Project</th>
                                            <th>Viva</th>
                                            <th>Certification</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div id="projects" class="tab-pane fade container-fluid">
                            <div
                                style="display:flex;align-items:center;justify-content:flex-start;gap:7px;margin:20px 5px 5px 5px">
                                <?php if (in_array('createDocuments', $this->permission)): ?>
                                    <button data-target="#addProjectModal" data-toggle="modal" class="btn btn-primary">
                                        Add Project Document
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="padding:20px">
                                <!-- Table to display data -->
                                <table id="manageTable3" class="table table-bordered table-striped nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Title</th>
                                            <th>Batch</th>
                                            <th>Subject</th>

                                            <th>Project</th>
                                            <!-- <th>Batch</th> -->

                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                        <div id="stdmaterials" class="tab-pane fade container-fluid">
                            <div
                                style="display:flex;align-items:center;justify-content:flex-start;gap:7px;margin:20px 5px 5px 5px">
                                <?php if (in_array('createDocuments', $this->permission)): ?>
                                    <button data-target="#addStudyModal" data-toggle="modal" class="btn btn-primary">
                                        Add Study Material
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="padding:20px">
                                <!-- Table to display data -->
                                <table id="manageTable4" class="table table-bordered table-striped nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Title</th>
                                            <th>Batch</th>
                                            <th>Subject</th>

                                            <th>Project</th>
                                            <!-- <th>Batch</th> -->

                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div id="syllabus" class="tab-pane fade container-fluid">

                            <div
                                style="display:flex;align-items:center;justify-content:flex-start;gap:7px;margin:20px 5px 5px 5px">
                                <?php if (in_array('createDocuments', $this->permission)): ?>
                                    <button data-target="#addSyllabusModal" data-toggle="modal" class="btn btn-primary">
                                        Add Syllabus
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="padding:20px">
                                <!-- Table to display data -->
                                <table id="manageTable5" class="table table-bordered table-striped nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Title</th>
                                            <th>Batch</th>
                                            <th>Subject</th>

                                            <th>Project</th>
                                            <!-- <th>Batch</th> -->

                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div id="otherDocs" class="tab-pane fade container-fluid">

                            <div
                                style="display:flex;align-items:center;justify-content:flex-start;gap:7px;margin:20px 5px 5px 5px">
                                <?php if (in_array('createDocuments', $this->permission)): ?>
                                    <button data-target="#addOtherDocsModal" data-toggle="modal" class="btn btn-primary">
                                        Add Other Documents
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="padding:20px">
                                <!-- Table to display data -->
                                <table id="manageTable6" class="table table-bordered table-striped nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Title</th>
                                            <th>Batch</th>
                                            <th>Subject</th>

                                            <th>Project</th>
                                            <!-- <th>Batch</th> -->

                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        <?php endif; ?>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Question Paper</h4>
            </div>
            <div class="modal-body">
                <form onsubmit="addDocument(this);return false;" method="post" id="addDocumentForm"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Question Paper Title</label>
                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="batch_id">Select Batch</label>
                        <select class='form-control batchAppendar' name='batch' id='batch_id' readonly></select>
                    </div>
                    <div class="form-group">
                        <label for="subject_id">Select Subject</label>
                        <div class="courseSelector"></div>
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
                            <!-- <option value="7">Event</option>
                                <option value="8">Project Docs</option>
                                <option value="9">Other</option> -->
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
                <button type="submit" form="addDocumentForm" class="btn btn-primary">Add
                    Question Paper</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addProjectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Project Document</h4>
            </div>
            <div class="modal-body">
                <form onsubmit="addDocument(this);return false;" method="post" id="addProjectForm"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Document Title</label>
                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="batch_id">Select Batch</label>
                        <select class='form-control batchAppendar' name='batch' id='batch_id' readonly></select>
                    </div>
                    <div class="form-group">
                        <label for="subject_id">Select Subject</label>
                        <div class="courseSelector"></div>
                    </div>
                    <div class="form-group">
                        <label for="type">Select Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value="8">Project Docs</option>
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
                <button type="submit" form="addProjectForm" class="btn btn-primary">Add
                    Project</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addStudyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Study Material</h4>
            </div>
            <div class="modal-body">
                <form onsubmit="addDocument(this);return false;" method="post" id="addStudyMaterialForm"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Study Material Title</label>
                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="batch_id">Select Batch</label>
                        <select class='form-control batchAppendar' name='batch' id='batch_id' readonly></select>
                    </div>
                    <div class="form-group">
                        <label for="subject_id">Select Subject</label>
                        <div class="courseSelector"></div>
                    </div>
                    <div class="form-group">
                        <label for="type">Select Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value="10">Study Material</option>
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
                <button type="submit" form="addStudyMaterialForm" class="btn btn-primary">Add
                    Study Material</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addSyllabusModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Syllabus</h4>
            </div>
            <div class="modal-body">
                <form onsubmit="addDocument(this);return false;" method="post" id="addSyllabusForm"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Syllabus Title</label>
                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="batch_id">Select Batch</label>
                        <select class='form-control batchAppendar' name='batch' id='batch_id' readonly></select>
                    </div>
                    <div class="form-group">
                        <label for="subject_id">Select Subject</label>
                        <div class="courseSelector"></div>
                    </div>
                    <div class="form-group">
                        <label for="type">Select Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value="11">Syllabus</option>
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
                <button type="submit" form="addSyllabusForm" class="btn btn-primary">Add
                    Syllabus</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addOtherDocsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Other Documents</h4>
            </div>
            <div class="modal-body">
                <form onsubmit="addDocument(this);return false;" method="post" id="addOtherDocsForm"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Document Title</label>
                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="batch_id">Select Batch</label>
                        <select class='form-control batchAppendar' name='batch' id='batch_id' readonly></select>
                    </div>
                    <div class="form-group">
                        <label for="subject_id">Select Subject</label>
                        <div class="courseSelector"></div>
                    </div>
                    <div class="form-group">
                        <label for="type">Select Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value="9">Other Docs</option>
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
                <button type="submit" form="addOtherDocsForm" class="btn btn-primary">Add
                    Other Documents</button>
            </div>
        </div>
    </div>
</div>

<?php
if (in_array('updateDocuments', $this->permission)):
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="updateDocsModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Document</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="updateDocument(this);return false;" method="post" id="updateOtherDocsForm"
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
                            <select class='form-control batchAppendar' name='batch' id='updt_batch_id' readonly></select>
                        </div>
                        <div class="form-group">
                            <label for="updt_subject_id">Select Subject</label>
                            <div class="courseSelector"></div>
                        </div>
                        <div class="form-group">
                            <label for="updt_type">Select Type</label>
                            <select class="form-control" id="updt_type" name="type" readonly>
                                <option value="1">Grade 1</option>
                                <option value="2">Grade 2</option>
                                <option value="3">Grade 3</option>
                                <option value="4">Assessment 1</option>
                                <option value="5">Assessment 2</option>
                                <option value="6">Assessment 3</option>
                                <option value="7">Event</option>
                                <option value="8">Project Docs</option>
                                <option value="9">Other</option>
                                <option value="10">Study Material</option>
                                <option value="11">Syllabus</option>
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
                    <button type="submit" form="updateOtherDocsForm" class="btn btn-primary">Update
                        Document</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <?php
endif;
?>

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

<!--  -->

<script type="text/javascript">
    var manageTable, manageTable1, manageTable2, manageTable3, manageTable4, manageTable5, manageTable6;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        loadSubjects();
        // initialize the datatable 
        manageTable1 = $('#manageTable1').DataTable({
            'ajax': base_url + 'batch/loadStudentDataBID/<?php echo $bdata['id']; ?>',
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'batch/loadStudentDataBIDForResult/<?php echo $bdata['id']; ?>',
            scrollY: true,
            "scrollX": true,
            autoWidth: false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });

    function loadSubjects() {
        $.ajax({
            url: "<?php echo base_url('documents/loadSubjectsByBidAndFacultyId/') ?>" + <?php echo $userData['id']; ?> + "/<?php echo $bdata['id']; ?>",
            // url: "<?php // echo base_url('documents/loadSubjectsByBidAndFacultyId/') ?>" + <?php // echo $userData['id']; ?> + "/" + me.value,
            type: "get",
            data: {},
            dataType: "json",
            success: function (res) {
                if (res.status) {
                    $(".courseSelector").html(res.message);
                } else {
                    $(ele).html("<option>No Subject found!</option>");
                }
            }
        });

    }

    $.ajax({
        url: "<?php echo base_url('documents/loadBatchesByUid/') ?>" + <?php echo $userData['id']; ?>,
        type: "get",
        data: {},
        dataType: "json",
        success: function (res) {
            if (res.status) {
                $(".batchAppendar").html(res.message);
                $(".batchAppendar").val(<?php echo $bdata['id']; ?>);
            } else {
                $(".batchAppendar").html("<option>NO batches found!</option>");
            }

            $(".batchAppendar").trigger('change');
        }
    });

    // initialize the datatable 
    manageTable2 = $('#manageTable2').DataTable
        ({
            'ajax': base_url + 'documents/getDocuments/' + <?php echo $bid; ?>,
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    // initialize the datatable 

    manageTable3 = $('#manageTable3').DataTable
        ({
            'ajax': base_url + 'documents/getProjectDocuments/' + <?php echo $bid; ?>,
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    // initialize the datatable 
    manageTable4 = $('#manageTable4').DataTable
        ({
            'ajax': base_url + 'documents/getStudyMaterial/' + <?php echo $bid; ?>,
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    // initialize the datatable 
    manageTable5 = $('#manageTable5').DataTable
        ({
            'ajax': base_url + 'documents/getSyllabus/' + <?php echo $bid; ?>,
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    // initialize the datatable 
    manageTable6 = $('#manageTable6').DataTable
        ({
            'ajax': base_url + 'documents/getOtherDocsDocuments/' + <?php echo $bid; ?>,
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });


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
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + res.message +
                            '</div>');

                        // hide the modal
                        $("#addModal").modal('hide');

                        manageTable1.ajax.reload(null, false);
                        manageTable2.ajax.reload(null, false);
                        manageTable3.ajax.reload(null, false);
                        manageTable4.ajax.reload(null, false);
                        manageTable5.ajax.reload(null, false);
                        manageTable6.ajax.reload(null, false);

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

                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + res.message +
                            '</div>');

                        $("#updateDocumentModal").modal('hide');

                        manageTable1.ajax.reload(null, false);
                        manageTable2.ajax.reload(null, false);
                        manageTable3.ajax.reload(null, false);
                        manageTable4.ajax.reload(null, false);
                        manageTable5.ajax.reload(null, false);
                        manageTable6.ajax.reload(null, false);
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
            console.log(qid, title, bid, sid, type);
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