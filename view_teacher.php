
<?php include('head.php');?>
<?php include('header.php');?>
<?php include('sidebar.php');

if(isset($_GET['id']))
{ ?>
<div class="popup popup--icon -question js_question-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Sure
    </h1>
    <p>Are You Sure To Delete This Record?</p>
    <p>
      <a href="del_teacher.php?id=<?php echo $_GET['id']; ?>" class="button button--success" data-for="js_success-popup">Yes</a>
      <a href="view_teacher.php" class="button button--error" data-for="js_success-popup">No</a>
    </p>
  </div>
</div>
<?php } ?>

        <div class="page-wrapper">
            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"> View Teacher</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">View Teacher</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid">
               
                 <div class="card">
                            <div class="card-body">
                            <a href="add_teacher.php"><button class="btn btn-primary">Add Teacher</button></a>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                
                                                <th>Class</th>
                                                <th>Subject</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Birth Date</th>
                                                <th>Contact No.</th>
                                               <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php 
                                    include 'connect.php';
                                    $sql = "SELECT * FROM `tbl_teacher`";
                                                                       
                                     $result = $conn->query($sql);

                                   while($row = $result->fetch_assoc()) { 
                                   $sql1="SELECT * FROM `tbl_subject` WHERE id='".$row['subjectname']."'";
                                     $result1=$conn->query($sql1);
                                     $row1=$result1->fetch_assoc();
                                     $sql2="SELECT * FROM `tbl_class` WHERE id='".$row['classname']."'";
                                     $result2=$conn->query($sql2);
                                     $row2=$result2->fetch_assoc();
                                      ?>
                                            <tr>
                                                <td><?php echo $row['tfname']; ?></td>
                                                <td><?php echo $row['tlname']; ?></td>
                                               
                                                <td><?php echo $row2['classname']; ?></td>
                                                 <td><?php echo $row1['subjectname']; ?></td>
                                                <td><?php echo $row['temail']; ?></td>
                                                <td><?php echo $row['tgender']; ?></td>
                                                <td><?php echo $row['tdob']; ?></td>
                                                <td><?php echo $row['tcontact']; ?></td>
                                                <td><?php echo $row['taddress']; ?></td>
                                                
                                                <td>
            
                                                <a href="edit_teacher.php?id=<?=$row['id'];?>"><button type="button" class="btn btn-xs btn-primary" ><i class="fa fa-plus-square"></i></button></a>
                                              
                                                <a href="view_teacher.php?id=<?=$row['id'];?>"><button type="button" class="btn btn-xs btn-danger" ><i class="fa fa-trash"></i></button></a>
                                              
                                                
                                                </td>
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
               
             
<?php include('footer.php');?>

<link rel="stylesheet" href="popup_style.css">
<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Success 
    </h1>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]);  
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Error 
    </h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]);  } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
  el.addEventListener('click', function () {
    var popupEl = document.querySelector('.' + el.dataset.for);
    popupEl.classList.toggle('popup--visible');
  });
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
    </script>