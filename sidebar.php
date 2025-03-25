<?php
include('connect.php');

// Ensure the user is logged in and has a session ID
if (!isset($_SESSION["id"])) {
    header('Location: login.php');
    exit();
}

// Fetch admin details securely using prepared statements
$sql = "SELECT * FROM admin WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION["id"]);
$stmt->execute();
$result = $stmt->get_result();

// If user doesn't exist in the database, redirect to login
if ($result->num_rows == 0) {
    header('Location: login.php');
    exit();
}

$row1 = $result->fetch_array();

// Get permissions associated with the user's role
$q = "SELECT * FROM tbl_permission_role WHERE role_id = ?";
$stmt = $conn->prepare($q);
$stmt->bind_param("s", $row1['group_id']);
$stmt->execute();
$ress = $stmt->get_result();

// Initialize an array to store permission names
$name = array();

// Loop through the permission roles and fetch permission names
while ($row = $ress->fetch_array()) {
    $sql = "SELECT * FROM tbl_permission WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $row['permission_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row2 = $result->fetch_array();
        array_push($name, $row2[1]);
    }
}

// Store the permission names in the session
$_SESSION['name'] = $name;
$useroles = $_SESSION['name'];

?>

<div class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li><a href="index.php" aria-expanded="false"><i class="fa fa-window-maximize"></i>Dashboard</a></li>

                
                    <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Teacher Management</span></a>
                        <ul aria-expanded="false" class="collapse">
                                <li><a href="add_teacher.php">Add Teacher</a></li>
                            <li><a href="view_teacher.php">View Teacher</a></li>
                        </ul>
                    </li>

                
                    <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Student Management</span></a>
                        <ul aria-expanded="false" class="collapse">
                                <li><a href="add_student.php">Add Student</a></li>
                            <li><a href="view_student.php">View Student</a></li>
                        </ul>
                    </li>

                
                    <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-newspaper-o"></i><span class="hide-menu">Subject Management</span></a>
                        <ul aria-expanded="false" class="collapse">
                           
                                <li><a href="add_subject.php">Add Subject</a></li>
                            
                            <li><a href="view_subject.php">View Subject</a></li>
                        </ul>
                    </li>
                

               
                    <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Class Management</span></a>
                        <ul aria-expanded="false" class="collapse">
                           
                                <li><a href="add_class.php">Add Class</a></li>
                            
                            <li><a href="view_class.php">View Class</a></li>
                        </ul>
                    </li>
               

                
                    <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Exam Management</span></a>
                        <ul aria-expanded="false" class="collapse">
                        <li><a href="add_roomtype.php">Add Room Type</a></li>
                                <li><a href="view_roomtype.php">View Room Type</a></li>
                                <li><a href="add_room.php">Add Room</a></li>
                                <li><a href="view_room.php">View Room</a></li>
                                <li><a href="add_exam.php">Add Exam</a></li>
                                <li><a href="view_exam.php">View Exam</a></li>
                                <li><a href="add_allotment.php">Add Allotment</a></li>
                                <li><a href="view_allotment.php">View Allotment</a></li>
                            </ul>
                    </li>
             
                <li class="nav-label">Reports</li>
                <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-file"></i><span class="hide-menu">Report Management</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="today_exam.php">Today's Exam</a></li>
                        <li><a href="report_exam.php">Exam Report</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
