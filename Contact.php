<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Email = $_POST['Email'];
    $ContactNumber = $_POST['ContactNumber'];
    $Message = $_POST['Message'];
    $Subject = $_POST['Subject'];
  
    // Email
    $toEmail = "kalamfirmsap@gmail.com";
    $mailHeaders = "From: " . $Email . " <" . $Email . ">\r\n";
  
    $body = "From: $FirstName $LastName\n";
    $body .= "Email: $Email\n";
    $body .= "Contact Number: $ContactNumber\n";
    $body .= "Message: $Message\n";
    $body .= "Subject:  $Subject\n";
  
    if (!mail($toEmail, $Subject, $body, $mailHeaders)) {
        echo "There was an error sending the email.";
        exit;
    }
  
    // Database
    $host = "localhost";
    $username = "id20266531_contact";
    $password = "Kalam@123456";
    $dbname = "id20266531_contact_us";
  
    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
  
    $sql = "INSERT INTO contact (FirstName, LastName, Email, ContactNumber, Subject, Message)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Statement preparation failed: " . mysqli_error($conn));
    }
  
    mysqli_stmt_bind_param($stmt, "ssssss", $FirstName, $LastName, $Email, $ContactNumber, $Subject, $Message);
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit;
    }
  
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  
    echo "<script>alert('Sent successfully.');window.location.href = 'index.html';</script>";
}
?>
