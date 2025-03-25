<?php include('head.php');?>

<?php include('header.php');?>
<?php include('sidebar.php');?> 

<?php
include('connect.php');
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Student Management</h3> 
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Student Management</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8" style="margin-left: 10%;">
                <div class="card">
                    <div class="card-title">
                    </div>
                    <div class="card-body">
                        <div class="input-states">
                            <form class="form-horizontal" method="POST" action="pages/save_student.php" name="studentform" enctype="multipart/form-data">
                                <input type="hidden" name="currnt_date" class="form-control" value="<?php echo $current_date; ?>">

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Roll Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="regno" class="form-control" placeholder="Roll Number" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Exam Seat No</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="stud_id" class="form-control" placeholder="Exam Seat No" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="sfname" class="form-control" placeholder="First Name" onkeydown="return alphaOnly(event);" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="slname" class="form-control" placeholder="Last Name" onkeydown="return alphaOnly(event);" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Class</label>
                                        <div class="col-sm-9">
                                            <select name="classname" class="form-control" required>
                                                <option value="">--Select Class--</option>
                                                <?php  
                                                $c1 = "SELECT * FROM `tbl_class`";
                                                $result = $conn->query($c1);

                                                if ($result->num_rows > 0) {
                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                        <option value="<?php echo $row["id"];?>">
                                                            <?php echo $row['classname'];?>
                                                        </option>
                                                    <?php
                                                    }
                                                } else {
                                                    echo "0 results";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="semail" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Email" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" id="password" placeholder="Password" onkeyup='check();' class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Confirm Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="cpassword" id="confirm_password" placeholder="Confirm Password" onkeyup='check();' class="form-control" required>
                                            <span id="message"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Gender</label>
                                        <div class="col-sm-9">
                                            <select name="sgender" id="gender" class="form-control" required>
                                                <option value="">--Select Gender--</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Date Of Birth</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="sdob" class="form-control" placeholder="Birth Date">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Parents Contact</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="scontact" class="form-control" placeholder="Parents Contact Number" minlength="10" maxlength="10" onkeypress="javascript:return isNumber(event)" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-3 control-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="4" name="saddress" placeholder="Address" style="height: 120px;"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-30 m-t-30">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php');?>

<script>
  var check = function() {
      if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
          document.getElementById('message').style.color = 'green';
          document.getElementById('message').innerHTML = 'Matching';
      } else {
          document.getElementById('message').style.color = 'red';
          document.getElementById('message').innerHTML = 'NOT Matching';
      }
  }

  function alphaOnly(event) {
      var keyCode = event.keyCode || event.which;
      var key = String.fromCharCode(keyCode).toLowerCase();
      var allowedChars = "abcdefghijklmnopqrstuvwxyz";
      if (allowedChars.indexOf(key) === -1) {
          event.preventDefault();
      }
  }

  function isNumber(event) {
      var keyCode = event.keyCode || event.which;
      if (keyCode < 48 || keyCode > 57) {
          event.preventDefault();
      }
  }
</script>
