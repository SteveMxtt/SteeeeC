<?php include('head.php'); ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary"> View Subject</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Subjects</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Add Subject Button -->
                <a href="add_subject.php">
                    <button class="btn btn-primary">Add Subjects</button>
                </a><br><br>

                <!-- Filter by Class Dropdown -->
                <div class="filter-container">
                    <label for="class_select">Select Class:</label>
                    <select id="class_select" class="form-control filter-select">
                        <option value="">All Classes</option>
                        <?php
                        include 'connect.php';
                        $sql_classes = "SELECT * FROM `tbl_class`";
                        $result_classes = $conn->query($sql_classes);
                        while ($class = $result_classes->fetch_assoc()) {
                            $selected = isset($_GET['class_id']) && $_GET['class_id'] == $class['id'] ? 'selected' : '';
                            echo "<option value='" . $class['id'] . "' $selected>" . $class['classname'] . "</option>";
                        }
                        ?>
                    </select>
                    <button class="btn btn-secondary filter-button" onclick="filterClass()">Filter</button>
                </div>
            </div>
        </div>

        <!-- Display Selected Class Name -->
        <?php
        if (isset($_GET['class_id'])) {
            $class_id = $_GET['class_id'];
            $sql_class_name = "SELECT `classname` FROM `tbl_class` WHERE `id` = $class_id";
            $result_class_name = $conn->query($sql_class_name);
            $class_row = $result_class_name->fetch_assoc();
            $selected_class_name = $class_row['classname'];
            echo "<h3>Subjects for Class: " . $selected_class_name . "</h3>";
        }
        ?>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET['class_id'])) {
                                $class_id = $_GET['class_id'];
                                $sql1 = "SELECT * FROM `tbl_subject` WHERE `class_id` = $class_id";
                            } else {
                                $sql1 = "SELECT * FROM `tbl_subject`";
                            }

                            $result1 = $conn->query($sql1);
                            while ($row = $result1->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $row['subjectname']; ?></td>
                                    <td>
                                        <a href="edit_subject.php?id=<?= $row['id']; ?>">
                                            <button type="button" class="btn btn-xs btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                        <a href="del_subject.php?id=<?= $row['id']; ?>">
                                            <button type="button" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </a>
                                        <a href="view_class.php?subject_id=<?= $row['id']; ?>">
                                            <button type="button" class="btn btn-xs btn-info">
                                                View Class
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

<?php include('footer.php'); ?>

<!-- Updated CSS from View Student -->
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
    
    .btn-xs {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 5px;
    }
    
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
    }
    
    .btn-danger:hover {
        background-color: #bd2130;
    }
    
    .btn-info:hover {
        background-color: #138496;
    }
</style>

<!-- JavaScript for Filtering -->
<script>
    function filterClass() {
        var classId = document.getElementById("class_select").value;
        if (classId) {
            window.location.href = 'view_subject.php?class_id=' + classId;
        } else {
            alert("Please select a class!");
        }
    }
</script>