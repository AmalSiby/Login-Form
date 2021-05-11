<?php
$name = $_POST['name'];
$email = $_POST['email'];
$mnumber = $_POST['mnumber'];
$dob = $_POST['dob'];
$pincode = $_POST['pincode'];
if (!empty($name) || !empty($email) || !empty($mnumber) || !empty($dob) || !empty($pincode)) {
  $host = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbname = "forms";
  //create connection
  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
  if (mysqli_connect_error()) {
   die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
  } else {
   $SELECT = "SELECT email From registor Where email = ? Limit 1";
   $INSERT = "INSERT Into registor (name,email,mnumber,dob,pincode) values(?, ?, ?, ?, ?, ?)";
   //Prepare statement
   $stmt = $conn->prepare($SELECT);
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $stmt->bind_result($email);
   $stmt->store_result();
   $rnum = $stmt->num_rows;
   if ($rnum==0) {
    $stmt->close();
    $stmt = $conn->prepare($INSERT);
    $stmt->bind_param("ssiii",$name,$email,$mnumber,$dob,$pincode);
    $stmt->execute();
    echo "New record inserted sucessfully";
   } else {
    echo "Someone already register using this email";
   }
   $stmt->close();
   $conn->close();
  }
}else {
  echo "All field are required";
  die();
}
?>