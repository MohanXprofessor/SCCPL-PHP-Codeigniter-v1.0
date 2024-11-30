<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create |</title>

</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Assessment
                <small>Manage Assessment</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Manage Assessment</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">



            <h3 class="text-center">Assessment List</h3>

            <div class="box-body table-responsive">
                <div style="position: relative;">
                    <!-- Buttons for print and Excel export -->
                    <div style="position: absolute; top: 0; left: 0; margin: 10px;">
                        <button id="printTable" class="btn btn-success">Print</button>
                        <button id="exportExcel" class="btn btn-primary">Export to Excel</button>
                    </div>

                    <!-- Search input box for filtering -->
                    <input type="text" id="tableSearch" placeholder="Search..." style="position: absolute; top: 0; right: 0; margin: 10px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; width: 200px;">
                </div>
                <br> <br> <!-- <input type="text" id="tableSearch" placeholder="Search..."> -->

                <table id="manageTable"
                    class="table table-bordered table-striped responsive display nowrap table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Project</th>
                            <th>course</th>
                            <th>subject</th>
                            <th>assignment_type</th>
                            <th>Marks</th>
                            <th>Passing Marks</th>
                            <th>Date</th>
                            <th>Faculty</th>
                            <th>file</th>
                            <th colspan="4">Action</th>
                        </tr>
                    </thead>
                    <tbody>



                        <?php if (!empty($dassess)): ?>

                            <?php foreach ($dassess as $assessment): ?>

                                <tr>
                                    <td><?= $assessment->id ?></td>
                                    <td><?= $assessment->project ?></td>
                                    <td><?= $assessment->course ?></td>
                                    <td><?= $assessment->subject ?></td>
                                    <td><?= $assessment->assignment_type ?></td>
                                    <td><?= $assessment->assignment_marks ?></td>
                                    <td><?= $assessment->passing_marks ?></td>
                                    <td><?= $assessment->date ?></td>
                                    <td><?= $assessment->faculty ?></td>
                                    <td><?= $assessment->file_path ?></td>
                                    <td> <button class="btn btn-primary" onclick="viewFile('<?= isset($assessment->file_path) ? $assessment->file_path : '' ?>')">View</button></td>
                                    <td>
                                    </td>
                                    <td> <button class="btn btn-info">publish</button></td>

                                    <td> <button class="btn btn-danger" onclick="deleteRecord(<?= isset($assessment->id) ? $assessment->id : 'N/A'; ?>)">Delete</button></td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center">Hey..!! No DATA </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>



        </section>
    </div>



</body>

</html>
<script>
    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this assessment?")) {
            // Make an AJAX request to delete the record
            fetch(`<?= site_url('Assessments/delete_assessment'); ?>/${id}`, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Record deleted successfully!");
                        location.reload(); // Reload the page to reflect the changes
                    } else {
                        alert("Error deleting record.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Error deleting record.");
                });
        }
    }
</script>

<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {
        loadCourses($("#projectCombo"), "#coursesAppender");
        loadCourses($("#projectCombo2"), "#coursesAppender2");
        $("#mainOrdersNav").addClass('active');
        $("#manageOrdersNav").addClass('active');

        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'enquiry/fetchEnquiryData',
            scrollY: true,
            autoWidth: false,
            "scrollX": true,
            order: [],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });

    /*
     * Created By: Akash K. Fulari
     * On Date: 04-05-2024
     */
    function loadCourses(me, ele) {
        $.ajax({
            url: "<?php echo base_url('enquiry/loadCoursesByProjectId/') ?>" + me.value,
            type: "get",
            data: {},
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    $(ele).html("<option value=''>Please select course!</option>" + res.message);
                } else {
                    $(ele).html("<option value=''>Please select course!</option>");
                }
            }
        });
    }

    function addTestFunc(id) {
        $("#enquiryId").val(id);
    }
    // remove functions 
    function removeFunc(id) {
        if (id) {
            $("#removeForm").on('submit', function() {

                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {

                        manageTable.ajax.reload(null, false);

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                '</div>');

                            // hide the modal
                            $("#removeModal").modal('hide');

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

    function downloadBulkTextSubmitCSVTemplete() {
        $(".dt-button.buttons-csv.buttons-html5").click();
    }

    function submitFilter(form) {
        manageTable.ajax.url(base_url + 'enquiry/fetchFilteredEnquiryData?start_date=' + form.start_date.value + '&end_date=' + form.end_date.value + '&project_id=' + form.project_id.value + '&course_id=' + form.course_id.value + '&counseller_id=' + form.counseller_id.value).load();
    }

    function resetFilter() {
        manageTable.ajax.url(base_url + 'enquiry/fetchEnquiryData').load();
    }

    validateFollowUpDate(document.getElementById("status"));

    function validateFollowUpDate(ele) {
        document.getElementById("validateFollowUpDateField").style.display = ((ele.value == "Next-date") ? "block" : "none");
    }
</script>

<!-- ******************************************************************
  -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const table = document.getElementById('manageTable');
        const headers = table.querySelectorAll('thead th');
        const tableBody = table.querySelector('tbody');
        const rows = Array.from(tableBody.rows);

        headers.forEach((header, index) => {
            // Add a click event listener for sorting
            header.addEventListener('click', () => {
                const ascending = header.dataset.order === 'asc';
                header.dataset.order = ascending ? 'desc' : 'asc';

                // Sort rows based on clicked column
                rows.sort((rowA, rowB) => {
                    const cellA = rowA.cells[index].innerText.trim();
                    const cellB = rowB.cells[index].innerText.trim();

                    if (!isNaN(cellA) && !isNaN(cellB)) {
                        return ascending ? cellA - cellB : cellB - cellA;
                    }
                    return ascending ?
                        cellA.localeCompare(cellB) :
                        cellB.localeCompare(cellA);
                });

                // Append sorted rows back to the table body
                rows.forEach(row => tableBody.appendChild(row));
                updateArrows(header, ascending);
            });
        });


    });
</script>
<style>
    thead {
        background-color: white;

    }

    #tableSearch {
        display: flex;
        justify-content: center;
        margin-left: 85%;
    }
</style>
<script>
    document.getElementById('tableSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#manageTable tbody tr');

        rows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            row.style.display = rowText.includes(query) ? '' : 'none';
        });
    });
</script>

<script>
    // Print functionality
    document.getElementById('printTable').addEventListener('click', () => {
        const tableContent = document.getElementById('manageTable').outerHTML;

        // Add styles for the table to be included in the print window
        const styles = `
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f1f1f1;
                }
                .btn {
                    padding: 5px;
                }
            </style>
        `;

        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write('<html><head><title>Print Table</title>');
        printWindow.document.write(styles);
        printWindow.document.write('</head><body>');
        printWindow.document.write(tableContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });

    // Export to Excel functionality
    document.getElementById('exportExcel').addEventListener('click', () => {
        const table = document.getElementById('manageTable');
        const rows = Array.from(table.rows);
        let csvContent = '';

        rows.forEach(row => {
            const cols = Array.from(row.cells);
            const rowData = cols.map(cell => `"${cell.innerText}"`).join(',');
            csvContent += rowData + '\n';
        });

        // Create a downloadable file for CSV
        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);

        link.setAttribute('href', url);
        link.setAttribute('download', 'table_data.csv');
        link.style.display = 'none';
        document.body.appendChild(link);

        link.click();
        document.body.removeChild(link);
    });
</script>