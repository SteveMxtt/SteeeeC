<?php 
include('head.php');
include('header.php');
include('sidebar.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
include 'connect.php';

// Fetch all rooms from the database
$sql = "SELECT * FROM `room`";
$room_result = $conn->query($sql);

?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">All Rooms and Students List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Room Students List</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <?php
                    if ($room_result && $room_result->num_rows > 0) {
                        // Loop through all rooms
                        while ($room = $room_result->fetch_assoc()) {
                            $room_type_id = $room['id'];
                            $room_name = $room['name'];

                            // Fetch the exam ID associated with this room from the `allot` table
                            $exam_sql = "SELECT exam_id FROM `allot` WHERE room_type_id = '$room_type_id' LIMIT 1";
                            $exam_result = $conn->query($exam_sql);
                            
                            if ($exam_result && $exam_result->num_rows > 0) {
                                $exam = $exam_result->fetch_assoc();
                                $exam_id = $exam['exam_id'];

                                // Fetch the exam details using the exam ID
                                $exam_details_sql = "SELECT name FROM `exam` WHERE id = '$exam_id'";
                                $exam_details_result = $conn->query($exam_details_sql);
                                
                                if ($exam_details_result && $exam_details_result->num_rows > 0) {
                                    $exam_details = $exam_details_result->fetch_assoc();
                                    $exam_name = $exam_details['name'];
                                } else {
                                    $exam_name = 'No exam details found';
                                }
                            } else {
                                $exam_name = 'No exam found for this room';
                            }

                            // Fetch students allotted to this room
                            $student_sql = "SELECT as1.*, s.regno, as1.stud_id 
                                            FROM `allot_student` as as1
                                            JOIN `tbl_student` as s ON as1.stud_id = s.id
                                            WHERE as1.allot_id IN (SELECT id FROM `allot` WHERE room_type_id = '$room_type_id')";
                            $student_result = $conn->query($student_sql);
                            
                            // Check if there are students for this room
                            if ($student_result && $student_result->num_rows > 0) {
                                // Display room name and exam name
                                echo "<h4>Room: " . htmlspecialchars($room_name) . " - Exam: " . htmlspecialchars($exam_name) . "</h4>";
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead><tr><th>Student Registration No</th><th>Exam Seat Number</th></tr></thead><tbody>";
                                
                                // Display students for this room
                                while ($student = $student_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($student['regno']) . "</td>";  // Display Registration Number
                                    echo "<td>" . htmlspecialchars($student['stud_id']) . "</td>"; // Display Seat Number
                                    echo "</tr>";
                                }
                                
                                echo "</tbody></table>";
                            } else {
                                // No students found for this room
                                echo "<h4>Room: " . htmlspecialchars($room_name) . " - Exam: " . htmlspecialchars($exam_name) . "</h4>";
                                echo "<p>No students found for this room.</p>";
                            }
                        }
                    } else {
                        echo "<p>No rooms found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
