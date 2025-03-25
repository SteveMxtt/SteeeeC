<?php 
include('head.php');
include('header1.php');
include('stud_sidebar.php');   
include 'connect.php';

date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');

// Ensure database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get Student ID from session
if (!isset($_SESSION['id'])) {
    die("Error: Student ID not found in session.");
}
$student_id = mysqli_real_escape_string($conn, $_SESSION['id']);
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Dashboard</h3> 
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
    
    <div class="container-fluid">   
        
        <?php 
        function fetch_exam_details($conn, $student_id, $condition, $title) {
            echo "<div class='card'>
                    <div class='card-body'>
                        <h4 class='card-title'>$title</h4>
                        <div class='table-responsive'>
                            <table class='table table-bordered table-striped'>
                                <thead>
                                    <tr><th>Exam Seat No.</th>
                                        <th>Exam Name</th>
                                
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Room Name</th>
                                    </tr>
                                </thead>
                                <tbody>";
            
            $sql = "SELECT e.name AS exam_name, a.exam_date, stud_id,
                           a.start_time, a.end_time, r.name AS room_name
                    FROM allot_student a
                    JOIN exam e ON a.exam_id = e.id
                    JOIN room r ON a.room_id = r.id
                    WHERE a.student_id = '$student_id' $condition
                    ORDER BY a.exam_date ASC";
            
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
             {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" .htmlspecialchars($row['stud_id']) ."</td>
                            <td>" . htmlspecialchars($row['exam_name']) . "</td>
                            <td>" . htmlspecialchars($row['exam_date']) . "</td>
                            <td>" . htmlspecialchars($row['start_time'] . ' - ' . $row['end_time']) . "</td>
                            <td>" . htmlspecialchars($row['room_name']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No exams found.</td></tr>";
            }
            
            echo "</tbody>
                  </table>
                </div>
              </div>
            </div>";
        }

        // Display Today's Exams
        fetch_exam_details($conn, $student_id, "AND a.exam_date = '$current_date'", "Today's Exams");

        // Display Allotted Exams
        fetch_exam_details($conn, $student_id, "", "All Allotted Exams");
        ?>

    </div>

    <?php include('footer.php');?>   
</div>