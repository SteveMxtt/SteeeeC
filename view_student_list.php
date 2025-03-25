<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>   

<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');

// Database query to fetch manage_website settings
$sql_currency = "SELECT * FROM manage_website"; 
$result_currency = $conn->query($sql_currency);
if ($result_currency === FALSE) {
    echo "Error fetching manage_website data: " . $conn->error;
    exit();
}
$row_currency = mysqli_fetch_array($result_currency);
?>    

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Exam List</h3> 
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Exam List</li>
            </ol>
        </div>
    </div>
    
    <div class="container-fluid">                    
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Student Exam Seat No</th>
                                <th>Time</th> 
                                <th>Room Name</th>
                                <th>Subject Name</th>
                                <th>Student Registration No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            include 'connect.php';  // Ensure you have a valid DB connection here

                            // Ensure the 'id' parameter is present in the URL
                            if (isset($_GET['id'])) {
                                $allot_id = $_GET['id'];

                                // Fetch data from allot_student table
                                $sql1 = "SELECT * FROM `allot_student` WHERE allot_id='$allot_id'";
                                $result1 = $conn->query($sql1);
                                
                                if ($result1 === FALSE) {
                                    echo "Error fetching allot_student data: " . $conn->error;
                                    exit();
                                }

                                while($row = $result1->fetch_assoc()) {
                                    // Get exam details
                                    $s1 = "SELECT * FROM `exam` WHERE id='".$row['exam_id']."'";
                                    $sr = $conn->query($s1);
                                    $sres = mysqli_fetch_array($sr); 

                                    if ($sres === NULL) {
                                        echo "No exam found for exam_id: " . $row['exam_id'];
                                        continue;
                                    }

                                    // Get room details
                                    $s2 = "SELECT * FROM `room` WHERE id='".$row['room_id']."'";
                                    $sr1 = $conn->query($s2);
                                    $sres1 = mysqli_fetch_array($sr1); 

                                    if ($sres1 === NULL) {
                                        echo "No room found for room_id: " . $row['room_id'];
                                        continue;
                                    }

                                    // Get subject details based on exam_id
                                    $subject_query = "SELECT * FROM `tbl_subject` WHERE id='".$sres['subject_id']."'";
                                    $subject_result = $conn->query($subject_query);
                                    $subject_row = mysqli_fetch_array($subject_result);

                                    if ($subject_row === NULL) {
                                        echo "No subject found for subject_id: " . $sres['subject_id'];
                                        continue;
                                    }

                                    // Get student registration number
                                    $student_query = "SELECT * FROM `tbl_student` WHERE id='".$row['student_id']."'";
                                    $student_result = $conn->query($student_query);
                                    $student_row = mysqli_fetch_array($student_result); 

                                    if ($student_row === NULL) {
                                        echo "No student found with stud_id: " . $row['student_id'];
                                        continue;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $row['stud_id']; ?></td>
                                        <td><?php echo $row['start_time'].'-'.$row['end_time']; ?></td>
                                        <td><?php echo $sres1['name']; ?></td>
                                        <td><?php echo $subject_row['subjectname']; ?></td>
                                        <td><?php echo $student_row['regno']; ?></td> <!-- Displaying the student registration number -->
                                    </tr>
                            <?php } 
                            } else {
                                echo "No exam ID provided.";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>

<?php include('footer.php'); ?>
