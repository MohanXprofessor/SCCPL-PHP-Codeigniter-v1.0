<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create |</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
            /* Enable horizontal scroll */
        }
    </style>
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
            <div class="container mt-5">
                <h1 class="text-center">Assessment title</h1>
                <!-- Responsive Table Wrapper -->
                <?php foreach ($assess as $row): ?>
                    <p><?php echo $row->faculty_id; ?></p> <!-- Ensure correct casing -->
                <?php endforeach; ?>
                <div class="table-responsive">
                    <table id="manageTable"
                        class="table table-bordered table-striped responsive display nowrap table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Project_id</th>
                                <th>course_id</th>
                                <th>subject_id</th>
                                <th>assignment_type</th>
                                <th>assignment_marks</th>
                                <th>passing_marks</th>
                                <th>Date</th>
                                <th>Faculty_id</th>
                                <th>file_path</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php if (!empty($assess)): ?>
                                <?php foreach ($assess as $assessment): ?>
                                    <tr>
                                        <td><?= $assessment->id; ?></td>
                                        <td><?= $assessment->project; ?></td>
                                        <td><?= $assessment->course; ?></td>
                                        <td><?= $assessment->subject; ?></td>
                                        <td><?= $assessment->assignment; ?></td>
                                        <td><?= $assessment->assignment_marks; ?></td>
                                        <td><?= $assessment->passing_marks; ?></td>
                                        <td><?= $assessment->date; ?></td>
                                        <td><?= $assessment->Faculty; ?></td>
                                        <td><?= $assessment->file_path; ?></td>
                                        <td> </td>

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
            </div>

        </section>
    </div>
</body>

</html>