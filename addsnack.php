<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Snack</title>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body>
    <form action="addsnack.php" method="post" enctype="multipart/form-data">
        <label for="categoryid">Category Id:</label>
        <!-- <input type="text" id="snackname" name="snackname" required><br> -->
        <label for="cid">Category</label>
        <select class="form-control" id="cid" name="cid">
            <option value="">select category</option>
            <?php
            $sql = "SELECT * FROM `category`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['cid'] . "'>" . $row['cname'] . "</option>";
            }
            ?>
        </select><br>

        <label for="snackname">Snack Name:</label>
        <input type="text" id="snackname" name="snackname" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" min="0.01" step="0.01" required><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select><br>

        <input type="submit" value="Add Snack">
    </form>


    <?php
    // Database connection code goes here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "newproject";

    $insert = false;

    // Create a connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Die if connection was not successful
    if (!$conn) {
        die("Sorry we failed to connect: " . mysqli_connect_error());
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cid = $_POST["cid"];
        $snackname = $_POST["snackname"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $status = $_POST["status"];

        // Handle image upload
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        // Insert data into the 'snack' table
        $query = "INSERT INTO snack (cid, snackname, description, image, price, status) 
              VALUES ('$cid', '$snackname', '$description', '$image', '$price', '$status')";

        if ($result) {
            $insert = true;
        } else {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn) . mysqli_errno($conn);
        }
        // Prepare and execute the query, binding parameters as needed
        // Replace :cid with the actual category ID

        // Redirect to a page where snacks are displayed
        header("Location: addsnack.php");
        exit();
    }
    ?>

    <script>
        $(document).ready(function() {
            $('#snacksTable').DataTable();
        });
    </script>

    <table id="snacksTable">
        <!-- Add table headers here -->
        <thead>
            <tr>
                <th>Snack Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through and display snack data here -->
            <?php
            // Fetch snack data from the database
            $query = "SELECT * FROM snack";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cid = $row['cid'];
                    $snackname = $row['snackname'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $status = $row['status'];

                    // Output a table row with snack data
                    echo "<tr>";
                    echo "<td>$cid</td>";
                    echo "<td>$snackname</td>";
                    echo "<td>$description</td>";
                    echo "<td>$price</td>";
                    echo "<td>$status</td>";
                    echo "</tr>";
                }
            } else {
                // Handle the case where no data is found
                echo "No snacks found in the database.";
            }

            // Fetch snack data from the database and loop through it to generate table rows
            ?>
        </tbody>
    </table>

</body>

</html>