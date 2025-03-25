<?php include('head.php');?>
<?php include('header.php');?>
<?php include('sidebar.php');?> 

<?php
if(isset($_GET['id'])) { ?>
<div class="popup popup--icon -question js_question-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">Sure</h3>
    <p>Are You Sure To Delete This Record?</p>
    <p>
      <a href="del_allot.php?id=<?php echo $_GET['id']; ?>" class="button button--success" data-for="js_success-popup">Yes</a>
      <a href="view_allotment.php" class="button button--error" data-for="js_success-popup">No</a>
    </p>
  </div>
</div>
<?php } ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">View Allotment</h3> 
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Allotment</li>
            </ol>
        </div>
    </div>

    <!-- Add Search Form here -->
    <div class="container-fluid">
        <form method="GET" action="view_room_students.php">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search_room" class="form-control" placeholder="Search by Room Name" value="<?php echo isset($_GET['search_room']) ? $_GET['search_room'] : ''; ?>" />
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
        <br>

        <div class="card">
            <div class="card-body">
                <a href="add_allotment.php"><button class="btn btn-primary">Add Allotment</button></a>
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Exam Name</th>
                                <th>Exam Date</th> <!-- Added Exam Date column -->
                                <th>Room Name</th> <!-- Added Room Name column -->
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        include 'connect.php';

                        // Check if there is a search term and modify the query accordingly
                        $search_room = isset($_GET['search_room']) ? $_GET['search_room'] : '';
                        $sql1 = "SELECT * FROM `allot`";
                        
                        if (!empty($search_room)) {
                            $sql1 .= " WHERE room_type_id IN (SELECT id FROM room WHERE name LIKE '%$search_room%')";
                        }

                        $result1 = $conn->query($sql1);
                        while($row = $result1->fetch_assoc()) {
                            $s1 = "SELECT * FROM `exam` WHERE id='".$row['exam_id']."'";
                            $sr = $conn->query($s1);
                            $sres = mysqli_fetch_array($sr); 

                            // Fetch the exam date
                            $exam_date = $sres['exam_date']; // Assuming the column for exam date is 'exam_date'

                            // Fetch the room name using the allotment record (assuming a room_id is stored in the `allot` table)
                            $room_type_id = $row['room_type_id']; // Assuming `room_id` column exists in the `allot` table
                            $room_query = "SELECT * FROM `room` WHERE id='$room_type_id'";
                            $room_result = $conn->query($room_query);
                            $room_data = mysqli_fetch_array($room_result);
                            $room_name = $room_data['name']; // Assuming 'room_name' column in the 'room' table
                        ?>
                            <tr>
                                <td><?php echo $sres['name']; ?></td>
                                <td><?php echo $exam_date; ?></td> <!-- Display Exam Date -->
                                <td><?php echo $room_name; ?></td> <!-- Display Room Name -->
                                <td>
                                    <a title="View Room Details" href="view_allotment_detail.php?id=<?=$row['id'];?>">
                                        <button type="button" class="btn btn-xs btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    <a title="View Student List" href="view_student_list.php?id=<?=$row['id'];?>">
                                        <button type="button" class="btn btn-xs btn-success">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="del_allot.php?id=<?=$row['id'];?>">
                                        <button type="button" class="btn btn-xs btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php');?>

<link rel="stylesheet" href="popup_style.css">

<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">Success</h3>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]); } ?>

<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">Error</h3>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]); } ?>

<script>
  var addButtonTrigger = function addButtonTrigger(el) {
    el.addEventListener('click', function () {
        var popupEl = document.querySelector('.' + el.dataset.for);
        popupEl.classList.toggle('popup--visible');
    });
};

Array.from(document.querySelectorAll('button[data-for]')).forEach(addButtonTrigger);
</script>
