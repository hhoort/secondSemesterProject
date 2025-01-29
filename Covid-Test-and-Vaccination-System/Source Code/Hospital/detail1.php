<?php
include '../Includes/config.php';

$user_id = $_POST['pid'];
$user_name = $_POST['pname'];
$user_hname = $_POST['hospitalname'];
$user_vaccine = $_POST['Vaccine'];
$user_date = $_POST['date'];
$user_status = $_POST['pstatus3'];
$deliveryFile = $_FILES['deliveryFile']['name'];
$deliveryFile_tmp = $_FILES['deliveryFile']['tmp_name'];
$deliveryFile_size = $_FILES['deliveryFile']['size'];
$update = "UPDATE `appointment` AS a 
INNER JOIN `hospital` AS h ON a.`hospital name` = h.`id` 
INNER JOIN `vaccines` AS v ON a.`vaccine` = v.`id` 
SET a.`pname` = '$user_name', 
    h.`Hospital Name` = '$user_hname', 
    v.`Vaccine` = '$user_vaccine', 
    a.`visit date` = '$user_date',
    a.`PStatus3` = '$user_status',
    a.`Report` = '$deliveryFile'
WHERE a.`pid` = '$user_id';
";
move_uploaded_file($deliveryFile_tmp, '../Reports' . $deliveryFile);
$res = mysqli_query($conn, $update);
if (!$res) {
    die("Query failed");
} else if ($user_status == 'On The Way For Sample Collection') {
    echo "<script> alert('No Data Update')</script>";
    echo "<script> window.location.href='ontheway.php'</script>";
} else if ($user_status == 'Sample Collected') {
    echo "<script> alert('Sample Collected Successful')</script>";
    echo "<script> window.location.href='samplecollected.php'</script>";
} else if ($user_status == 'Sent To Lab') {
    echo "<script> alert('Sent To Lab Successful')</script>";
    echo "<script> window.location.href='senttolab.php'</script>";
} else if ($user_status == 'Delivered') {
    echo "<script> alert('Report Delivered Successful')</script>";
    echo "<script> window.location.href='reportdelivered.php'</script>";
}
?>