<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsuid']) == 0) {
    header('location:logout.php');
    exit;
}


$serviceid = isset($_GET['sid']) ? $_GET['sid'] : '';
$servicename = '';

if ($serviceid != '') {
    $qry = mysqli_query($con, "SELECT ServiceName FROM tblservices WHERE ID='$serviceid'");
    if ($row = mysqli_fetch_array($qry)) {
        $servicename = $row['ServiceName'];
    }
}

if (isset($_POST['submit'])) {

    $uid = $_SESSION['bpmsuid'];
    $adate = $_POST['adate'];
    $atime = $_POST['atime'];
    $msg   = $_POST['message'];
    $aptnumber = mt_rand(100000000, 999999999);


    $query = mysqli_query(
        $con,
        "INSERT INTO tblbook(UserID,AptNumber,AptDate,AptTime,Message,ServiceID)
         VALUES('$uid','$aptnumber','$adate','$atime','$msg','$serviceid')"
    );

    if ($query) {
        $_SESSION['aptno'] = $aptnumber;
        echo "<script>window.location.href='thank-you.php'</script>";
    } else {
        echo "<script>alert('Something Went Wrong. Please try again');</script>";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Beauty Parlour Management System | Appointment Page</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>

<body id="home">
    <?php include_once('includes/header.php'); ?>

    <section class="w3l-contact-info-main" id="contact">
        <div class="contact-sec">
            <div class="container">
                <div class="d-grid contact-view">
                    <div class="map-content-9 mt-lg-0 mt-4">
                        <form method="post">


                            <div style="padding-top: 20px;">
                                <label>Selected Service</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $servicename; ?>" readonly>
                            </div>

                            <div style="padding-top: 20px;">
                                <label>Appointment Date</label>
                                <input type="date" class="form-control" name="adate" id="adate" required>
                            </div>

                            <div style="padding-top: 20px;">
                                <label>Appointment Time</label>
                                <input type="time" class="form-control" name="atime" required>
                            </div>

                            <div style="padding-top: 20px;">
                                <textarea class="form-control" name="message"
                                    placeholder="Message" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-contact" name="submit">
                                Make an Appointment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script>
        $(function() {
            var dtToday = new Date();
            var month = ('0' + (dtToday.getMonth() + 1)).slice(-2);
            var day = ('0' + dtToday.getDate()).slice(-2);
            var year = dtToday.getFullYear();
            $('#adate').attr('min', year + '-' + month + '-' + day);
        });
    </script>
</body>

</html>