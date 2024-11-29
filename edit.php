<?php
$server = "localhost";
$usr = "root";
$psw = ""; 
$db = "Thanakarn_Thanajai";

$conn = new mysqli($server, $usr, $psw, $db);

$customer_id = "";
$customer_name = "";  
$email = "";
$customer_phone = ""; 
$customer_address = "";

$errorMessage = "";
$successMessage = "";

// Check if request method is GET to fetch customer data
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        // Redirect if id is not set in URL
        header("location: /TnkTnj/index.php");
        exit;
    }

    $customer_id = $_GET["id"];
    $sql = "SELECT * FROM customer WHERE customer_id=$customer_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_name = $row["customer_name"];
        $email = $row["email"];
        $customer_phone = $row["customer_phone"];
        $customer_address = $row["customer_address"];
    } else {
        // Redirect if no such customer is found
        header("location: /TnkTnj/index.php");
        exit;
    }
}

// Check if request method is POST to update customer data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $customer_phone = $_POST['customer_phone'];
    $customer_address = $_POST['customer_address'];

    // Validation
    if (empty($customer_name) || empty($email) || empty($customer_phone) || empty($customer_address)) {
        $errorMessage = "All fields are required";
    } else {
        // Update customer data
        $sql = "UPDATE customer SET customer_name = '$customer_name', email = '$email', customer_phone = '$customer_phone', customer_address = '$customer_address' WHERE customer_id = $customer_id";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "Record updated successfully.";
        } else {
            $errorMessage = "Error updating record: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanakarn Thanajai</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Customer</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        if (!empty($successMessage)) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        <form method="post">
            <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">
            <div>
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>">
                </div>
            </div>
            <div>
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>
            <div>
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="customer_phone" value="<?php echo htmlspecialchars($customer_phone); ?>">
                </div>
            </div>
            <div>
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="customer_address" value="<?php echo htmlspecialchars($customer_address); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/TnkTnj/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
