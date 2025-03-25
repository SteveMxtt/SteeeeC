<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>

<?php if (isset($_GET['id'])) { ?>
    <div class="popup popup--icon -question js_question-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">Sure</h3>
            <p>Are You Sure To Delete This Record?</p>
            <p>
                <a href="del_student.php?id=<?php echo $_GET['id']; ?>" class="button button--success">Yes</a>
                <a href="view_student.php" class="button button--error">No</a>
            </p>
        </div>
    </div>
<?php } ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary"> View Student</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Student</li>
            </ol>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="add_student.php"><button class="btn btn-primary">Add Student</button></a><br><br>
                
                <div class="filter-container">
                    <label for="classFilter">Filter by Class:</label>
                    <select id="classFilter" class="form-control filter-select">
                        <option value="">All Classes</option>
                        <?php 
                        include 'connect.php';
                        $classQuery = "SELECT * FROM `tbl_class`";
                        $classResult = $conn->query($classQuery);
                        while ($classRow = $classResult->fetch_assoc()) {
                            echo '<option value="' . $classRow['id'] . '">' . $classRow['classname'] . '</option>';
                        }
                        ?>
                    </select>
                    <button class="btn btn-secondary filter-button" onclick="filterTable()">Filter</button>
                </div>
                
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr><th>Roll Number</th>
                                <th>Exam Seat No.</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Contact No.</th>
                                <th>Address</th>
                                <th>Class</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT tbl_student.*, tbl_class.classname, tbl_class.id as class_id FROM tbl_student 
                                    JOIN tbl_class ON tbl_student.classname = tbl_class.id";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) { 
                            ?>
                                <tr data-class="<?php echo $row['class_id']; ?>">
                                <td><?php echo $row['regno']; ?></td>
                                    <td><?php echo $row['stud_id']; ?></td>
                                    <td><?php echo $row['sfname']; ?></td>
                                    <td><?php echo $row['slname']; ?></td>
                                    <td><?php echo $row['semail']; ?></td>
                                    <td><?php echo $row['sgender']; ?></td>
                                    <td><?php echo $row['sdob']; ?></td>
                                    <td><?php echo $row['scontact']; ?></td>
                                    <td><?php echo $row['saddress']; ?></td>
                                    <td><?php echo $row['classname']; ?></td>
                                    <td>
                                        <a href="edit_student.php?id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-xs btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                        <a href="del_student.php?id=<?php echo $row['id']; ?>">
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

<?php include('footer.php'); ?>

<style>
    .filter-container {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
    .filter-select {
        width: 250px;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .filter-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .filter-button:hover {
        background-color: #0056b3;
    }
</style>

<script>
    function filterTable() {
        var filter = document.getElementById("classFilter").value;
        var rows = document.querySelectorAll("#myTable tbody tr");
        
        rows.forEach(row => {
            if (filter === "" || row.getAttribute("data-class") === filter) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>