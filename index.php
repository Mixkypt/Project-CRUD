<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Thanakarn Thanajai</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1>ธนาคาร T-T (Thanakarn-Thanajai)</h1>
        <h2>List of Customer</h2>
        <a class="btn btn-primary" href="/TnkTnj/create.php" role="button">New Customer</a>
        <a class="btn btn-success" href="/TnkTnj/add.php?id=$row[customer_id]">Add</a> 

        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $server = "localhost";
                    $usr = "root";
                    $psw = ""; 
                    $db = "Thanakarn_Thanajai";
                    
                    $conn = new mysqli($server, $usr, $psw, $db);
                    
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM customer ORDER BY CAST(customer_id AS UNSIGNED) ASC";
                    $result = $conn->query($sql); 

                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }

                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>$row[customer_id]</td>
                            <td>$row[customer_name]</td>
                            <td>$row[email]</td>
                            <td>$row[customer_phone]</td>
                            <td>$row[customer_address]</td>
                            <td>$row[date_join]</td>
                            <td>   
                                <a class=\"btn btn-primary btn-sm\" href=\"/TnkTnj/edit.php?id=$row[customer_id]\">Edit</a>
                                <a class=\"btn btn-danger btn-sm\" href=\"/TnkTnj/delete.php?id=$row[customer_id]\">Delete</a>
                            </td>
                        </tr>
                        "; 
                    }                    
                ?>                
            </tbody>
        </table>
    </div>
</body>
</html>
