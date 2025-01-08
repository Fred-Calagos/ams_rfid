<?php
// Database connection
$servername = "localhost"; // Replace with your database server name
$username = "username"; // Replace with your database username
$password = "password"; // Replace with your database password
$dbname = "your_database"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get table name from user input
    $table_name = $_POST["table_name"];

    // SQL to create table
    $sql = "CREATE TABLE $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        column1 VARCHAR(30) NOT NULL,
        column2 VARCHAR(30) NOT NULL,
        column3 INT(6)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table $table_name created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Table</title>
</head>
<body>
    <h2>Create New Table</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        Table Name: <input type="text" name="table_name"><br><br>
        <input type="submit" value="Create Table">
    </form>
</body>
</html>






<!-- FETHCING TABLE -->


<?php
// Database connection
$servername = "localhost"; // Replace with your database server name
$username = "username"; // Replace with your database username
$password = "password"; // Replace with your database password
$dbname = "your_database"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the newest table
$sql = "SELECT table_name
        FROM information_schema.tables
        WHERE table_schema = '$dbname' AND table_name LIKE '012%'
        ORDER BY table_name DESC
        LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the table name
    $row = $result->fetch_assoc();
    $newest_table = $row["table_name"];

    // Now you can use $newest_table in your queries or operations
    echo "Newest Table: " . $newest_table;
} else {
    echo "No matching tables found in the database";
}

// Close connection
$conn->close();
?>



$sy = $_POST['sy'];

// 1. Join sy_id with sy_name to fetch the corresponding sy_name
$select_sy_name_query = "SELECT sy_name FROM `school_year` WHERE sy_id = ?";
$stmt_sy_name = mysqli_prepare($conn, $select_sy_name_query);
mysqli_stmt_bind_param($stmt_sy_name, 'i', $sy);
mysqli_stmt_execute($stmt_sy_name);
mysqli_stmt_bind_result($stmt_sy_name, $sy_name);
mysqli_stmt_fetch($stmt_sy_name);
mysqli_stmt_close($stmt_sy_name);

// 2. Use the fetched sy_name to construct the table name
$new_table_name = "table_" . str_replace(' ', '_', $sy_name); // Generate a table name based on sy_name

// 3. Fetch the data from the created table
$select_query = "SELECT * FROM `$new_table_name` WHERE ..."; // Add your conditions here
$result = mysqli_query($conn, $select_query);

// Rest of your code to insert data into new_students table
// Ensure you use $sy_name in the INSERT query if needed

// Assuming you have already fetched all the necessary data and stored it in variables

// Construct the insert query for the new table using the fetched data
$insert_query_new_table = "INSERT INTO `$new_table_name` 
                            (column1, column2, column3) 
                           VALUES 
                            (?, ?, ?)";

// Prepare the statement
$stmt_insert_new_table = mysqli_prepare($conn, $insert_query_new_table);

// Bind parameters
mysqli_stmt_bind_param($stmt_insert_new_table, 'sss', $value1, $value2, $value3); // Adjust 'sss' according to your column types

// Assign values to variables (replace with actual values)
$value1 = $value1; // Example value for column1
$value2 = $value2; // Example value for column2
$value3 = $value3; // Example value for column3

// Execute the statement
$insert_success_new_table = mysqli_stmt_execute($stmt_insert_new_table);

// Check if insertion was successful
if ($insert_success_new_table) {
    // Insertion successful, perform any additional actions if needed
    // Example: Set success message, redirect user, etc.
} else {
    // Insertion failed, handle error
    // Example: Set error message, redirect user, etc.
}

// Close prepared statement
mysqli_stmt_close($stmt_insert_new_table);
