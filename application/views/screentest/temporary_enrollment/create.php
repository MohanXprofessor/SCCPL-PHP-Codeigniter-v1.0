<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-05-10 14:52:27
 Last Modification Date: 2024-06-06 18:04:14
*
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <style>
        body {
            background-color: whitesmoke !important;
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-weight: 400;
            overflow-x: hidden;
        }

        form {
            width: 80%;
            margin-left: 10%;
            padding: 50px;
            background-color: white !important;
            box-shadow: 0 0 65px 0 rgba(0, 0, 0, 0.20);
            border-radius: 50px;
        }

        label {
            font-size: 14px;
            font-weight: 700;
        }

        input,
        select {
            box-shadow: none !important;
            outline: none !important;
            border: 1px solid rgb(209, 206, 206) !important;
            height: 35px !important;
        }
    </style>
</head>

<body>
    <div class="p-3" id="messages"></div>

    <form class="my-3" onsubmit="addDocument(this);return false;" method="post" enctype="multipart/form-data">
        <h4 class="mb-3">Enrollment Now</h4>
        <p>Please submit form to get enroll!!!.</p>
        <div class="row mt-5">
            <div class="col-md-6 mb-3" hidden>
                <label for="inputPassword4" class="form-label">Enroll ID:</label>
                <input type="number" class="form-control" name="temp_enq_id" value="<?php echo $data['id']; ?>"
                    readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Project :</label>
                <select class="form-select" aria-label="Default select example" name="project_id" readonly>
                    <?php
                    if ($project_data == null) {
                        ?>
                        <option>Select Project</option>
                    <?php } else { ?>
                        <option value="<?php echo $project_data['id']; ?>"><?php echo $project_data['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Course :</label>
                <select class="form-select" aria-label="Default select example" name="course_id" readonly>
                    <?php
                    if ($course_data == null) {
                        ?>
                        <option selected>Select Course</option>
                    <?php } else { ?>
                        <option value="<?php echo $course_data['id']; ?>"><?php echo $course_data['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Name:</label>
                <input type="text" class="form-control" value="<?php echo $data['name']; ?>" name="name" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="inputEmail4" class="form-label">Father Name :</label>
                <input type="text" class="form-control" name="father_name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputEmail4" class="form-label">Mother Name :</label>
                <input type="text" class="form-control" name="mother_name">
            </div>

            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Address
                    :</label>
                <input type="text" class="form-control" value="<?php echo $data['address']; ?>" name="address" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="inputEmail4" class="form-label">Contact
                    Number :</label>
                <input type="text" class="form-control" value="<?php echo $data['contact']; ?>" name="contact" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">E-mail ID
                    :</label>
                <input type="email" class="form-control" value="<?php echo $data['email']; ?>" name="email" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="inputEmail4" class="form-label">College
                    Name :</label>
                <input type="text" class="form-control" value="<?php echo $data['college']; ?>" name="college" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Admission :</label>
                <input type="date" class="form-control" name="admission">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Education :</label>
                <input type="text" class="form-control" value="<?php echo $data['education']; ?>" name="education"
                    readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Annual Income :</label>
                <input type="text" class="form-control" name="annual_income">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">State :</label>
                <input type="text" class="form-control" name="state">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">City :</label>
                <input type="text" class="form-control" name="city">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Aadhar No :</label>
                <input type="text" class="form-control" name="adhar_no">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">10th Marks :</label>
                <input type="text" class="form-control" name="tenth">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">12th Marks :</label>
                <input type="text" class="form-control" name="twelth">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Graduate Passing Year :</label>
                <input type="text" class="form-control" name="graduation_passing">
            </div>
            <div class="col-md-6 mb-3">
                <label for="inputPassword4" class="form-label">Graduation Marks :</label>
                <input type="text" class="form-control" name="graduation">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Gender :</label>
                <select name="gender" class="form-control" required>
                    <option selected>Select Gender</option>
                    <option value="0" <?php echo (($data['gender'] == 0) ? "selected" : "") ?>>Feamle</option>
                    <option value="1" <?php echo (($data['gender'] == 1) ? "selected" : "") ?>>Male</option>
                    <option value="1" <?php echo (($data['gender'] == 2) ? "selected" : "") ?>>Other</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">10th Certificate/Marksheet Upload :</label>
                <input type="file" class="form-control" name="tenth_certificate">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">12th Certificate/Marksheet Upload :</label>
                <input type="file" class="form-control" name="twelth_certificate">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Income Certificate :</label>
                <input type="file" class="form-control" name="income">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Graduate Certificate :</label>
                <input type="file" class="form-control" name="graduate_certificate">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Photograph :</label>
                <input type="file" class="form-control" name="photograph">
            </div>
            <div class="col-md-4 mb-3">
                <label for="inputPassword4" class="form-label">Aadhar card :</label>
                <input type="file" class="form-control" name="adhar">
            </div>
            <div class="mt-4">
                <input type="submit" class="btn text-white btn-info" value="Submit" />
                <input type="reset" class="btn text-white btn-warning" value="Reset" />
            </div>
        </div>

    </form>

</body>

</html>
<script>
    function addDocument(form) {
        $.ajax({
            url: "<?php echo base_url('mailtemplete/fillMyRequiredDocuments') ?>",
            type: "POST",
            data: (new FormData(form)),
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (res) {
                if (res.status === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + res.message +
                        '</div>');
                } else {
                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + res.message +
                        '</div>');
                }
            },
            error: function (err) {

            }
        });

    }

</script>