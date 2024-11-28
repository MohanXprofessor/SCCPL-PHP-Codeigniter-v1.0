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
                Manage Assessment
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
                <h1 class="text-center">Assessments List</h1>
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Project_id</th>
                            <th>Assessment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($assessments)): ?>
                            <?php foreach ($assessments as $assessment): ?>
                                <tr>
                                    <td><?= $assessment['id']; ?></td>
                                    <td><?= $assessment['project_id']; ?></td>
                                    <td><?= $assessment['course_id']; ?></td>
                                    <td><?= $assessment['subject_id']; ?></td>
                                    <td><?= $assessment['assignment_type']; ?></td>
                                    <td><?= $assessment['assignment_marks']; ?></td>
                                    <td><?= $assessment['assignment_passing']; ?></td>
                                    <td><?= $assessment['date']; ?></td>




                                    <td><?= $assessment['assessment_date']; ?></td>
                                    <td><?= $assessment['status']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No assessments found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


        </section>
    </div>
</body>

</html>