<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $postal = $_POST['postal'];
    $reference = $_POST['reference'];
    $laptop_model = $_POST['laptop_model'];
    $processor = $_POST['processor'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Email
    $toEmail = "kalamfirmsap@gmail.com";
    $mailHeaders = "From: " . $email . " <" . $email . ">\r\n";

    $body = "From: $name \n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Company: $company\n";
    $body .= "Address: $address\n";
    $body .= "State: $state\n";
    $body .= "Postal: $postal\n";
    $body .= "Reference: $reference\n";
    $body .= "Laptop Model: $laptop_model\n";
    $body .= "Processor: $processor\n";
    $body .= "Start Date: $start_date\n";
    $body .= "End Date: $end_date\n";

    if (!mail($toEmail, $laptop_model, $body, $mailHeaders)) {
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

    $sql = "INSERT INTO rent (name, email, phone, company, address, state, postal, reference, laptop_model, processor, start_date, end_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Statement preparation failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssssssssssss", $name, $email, $phone, $company, $address, $state, $postal, $reference, $laptop_model, $processor, $start_date, $end_date);
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    echo "<script>alert('Sent successfully.');window.location.href = 'index.html';</script>";
}
?>
