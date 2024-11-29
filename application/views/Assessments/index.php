<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Assessment</title>
</head>

<body>

    <?php

    $sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
    $query = $this->db->query($sql, array(1));
    $branch = $query->result_array();

    $sql = "SELECT * FROM batch  ORDER BY id DESC";


    $query = $this->db->query($sql);

    $row = $query->result_array();
    if ($row != null)
        $randomId = "BHID" . $row[0]["id"];
    else
        $randomId = "BHID1";



    ?>

    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }



        .form-container {
            background-color: #fff;
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        select,
        input[type="text"],
        input[type="date"],
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
        }

        /* Flex layout for the first three dropdowns */


        /* Style adjustments for dropdown elements inside the flex group */
        /*    */
        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .form-container {
                padding: 15px;
            }

            label,
            select,
            input[type="text"],
            input[type="date"],
            input[type="file"] {
                font-size: 14px;
            }

            button {
                font-size: 14px;
                padding: 8px;
            }

            .dropdown-group {
                flex-direction: column;
                gap: 10px;
            }

            .dropdown-group select {
                width: 100%;
                /* Stack dropdowns vertically on smaller screens */
            }


        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Assessment
                <small>Assessment</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Assessment</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">


            <form action=" <?php echo base_url('Assessments/create_assessment') ?>  " method="post" enctype="multipart/form-data">
                <!-- Flex group for first 3 dropdowns -->
                <div class="dropdown-group">

                    <div class="form-group">
                        <!-- 
                    <select name="project_id" type="text" class="form-control select_group"
                        onchange='loadCourses(this, "#coursesAppender", "<?php echo $edata["course_id"]; ?>")'
                        id="projectCombo" required readonly>
                        <option>Select Project</option>
                        <?php
                        $sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
                        $query = $this->db->query($sql, array(1));
                        $branch = $query->result_array();
                        foreach ($branch as $v) {
                        ?>
                            <option value="<?php echo $v['id']; ?>" <?php echo (($edata['project_id'] == $v['id']) ? "selected" : ""); ?>>
                                <?php echo $v['name']; ?>
                            </option>
                        <?php } ?>
                    </select> -->




                        <div class="form-group col-md-4">
                            <label for="gross_amount">Project :</label> &nbsp;
                            <select name="project_id" type="text" class="form-control" id="projectCombo" required
                                onchange='loadCourses(this, "#coursesAppender")'>
                                <option>Select Project</option>
                                <?php
                                foreach ($branch as $v) { ?>

                                    <option value="<?php echo $v['name']; ?>">


                                        <?php echo $v['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>






                        <div class="form-group col-md-4">
                            <label for="company_name">Course :</label>
                            <select name="course_id" type="text" id="coursesAppender" class="form-control" required>
                            </select>
                        </div>











                        <div class="form-group col-md-4">
                            <label for="subject">Select Subject:</label>
                            <select name="subject" id="subject">
                                <option value="">--Select Subject--</option>
                                <?php if (!empty($subjects)) : ?>
                                    <?php foreach ($subjects as $subject) : ?>
                                        <option value="<?= $subject->subject_title ?>"><?= $subject->subject_title ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="">No Subjects Available</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- <div class="form-group col-md-4">
                        <label for="subject">Subject:</label>
                        <select name="subject" id="subject" required>
                            <option value="Java">JAVA</option>
                            <option value="PHP Developer">PHP Developer</option>
                            <option value="Python">Python</option>
                        </select>
                    </div> -->


                        <select name="assignment_type" id="assignment_type" required>
                            <option selected disabled>Assignment_Type</option>
                            <option value="MCQ">M C Q</option>
                            <option value="Quiz">Quiz</option>

                        </select>
                    </div>



                    <!-- Remaining form fields -->




                    <div class="form-group">
                        <label for="assignment_marks">Assignment Marks:</label>
                        <input type="text" name="assignment_marks" id="assignment_marks" required>
                    </div>

                    <div class="form-group">
                        <label for="passing_marks">Passing Marks:</label>
                        <input type="text" name="passing_marks" id="passing_marks" required>
                    </div>

                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" name="date" id="date" required>
                    </div>

                    <div class="col-md-5 form-group" id="facultyElement">
                        <label for="store">Faculty</label>
                        <select class="form-control" id="availability" name="faculty_id" required>
                            <?php

                            $sql = "SELECT users.id,users.firstname FROM users join user_group on users.id=user_group.user_id WHERE group_id = 19";
                            $query = $this->db->query($sql);
                            $counseller_details = $query->result_array();
                            foreach ($counseller_details as $v) {
                            ?>
                                <option value="<?php echo $v['firstname']; ?>">
                                    <?php echo $v['firstname']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>



                    <input type="file" name="file" id="file" required>


                    <button type="submit">Submit</button>
            </form>

        </section>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            loadCourses($("#projectCombo"), "#coursesAppender");
            $(".select_group").select2();
            $("#description").wysihtml5();
            $("#mainProductNav").addClass('active');
            $("#addProductNav").addClass('active');
            var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
                'onclick="alert(\'Call your custom code here.\')">' +
                '<i class="glyphicon glyphicon-tag"></i>' +
                '</button>';
            $("#product_image").fileinput({
                overwriteInitial: true,
                maxFileSize: 1500,
                showClose: false,
                showCaption: false,
                browseLabel: '',
                removeLabel: '',
                browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                removeTitle: 'Cancel or reset changes',
                elErrorContainer: '#kv-avatar-errors-1',
                msgErrorClass: 'alert alert-block alert-danger',
                // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
                layoutTemplates: {
                    main2: '{preview} ' + btnCust + ' {remove} {browse}'
                },
                allowedFileExtensions: ["jpg", "png", "gif"]
            });
        });


        function loadCourses(me, ele) {
            $.ajax({
                url: "<?php echo base_url('enquiry/loadCoursesByProjectId/') ?>" + me.value, // Sending selected project ID
                type: "get",
                dataType: "json", // Expecting JSON response
                success: function(res) {
                    if (res.status) {
                        // Populate the courses dropdown with the returned data
                        $(ele).html(res.message);
                    } else {
                        // Handle no courses found or an error
                        $(ele).html("<option>Please select course!</option>");
                    }
                },
                error: function() {
                    // Handle error in AJAX request
                    $(ele).html("<option>Error loading courses!</option>");
                }
            });
        }
    </script>
</body>

</html>