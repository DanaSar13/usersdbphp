<?php
// user_upload.php

// Defining command line short and long options
$options = getopt("u:p:h:", ["file:", "create_table", "dry_run", "help", "database:"]);

// If help option is provided 
if (isset($options['help'])) {
    echo "Usage: php user_upload.php [options]\n";
    echo "Options:\n";
    echo "  --file [csv file name]   The name of the CSV to be parsed\n";
    echo "  --create_table           Create the MySQL users table (and no further action will be taken)\n";
    echo "  --dry_run                Execute script without altering the database\n";
    echo "  -u                       MySQL username\n";
    echo "  -p                       MySQL password\n";
    echo "  -h                       MySQL host\n";
    echo "  --database               MySQL database name\n";
    exit;
}
// The function to create the MySQL users table if it does not already exist
function createTable($mysqli) {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        name VARCHAR(50) NOT NULL,
        surname VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE
    )";
    if ($mysqli->query($sql) === TRUE) {
        echo "Users table created successfully\n";
    } else {
        echo "Error while creating table: " . $mysqli->error . "\n";
    }
}
// The function to read data from a CSV file and insert it into the MySQL users table
function insertData($mysqli, $filename, $dryRun) {
    // Opening the CSV file
    $file = fopen($filename, "r");
    if (!$file) {
        die("Error: Unable to open file: $filename\n");
    }

    // Skip the header row
    fgetcsv($file);

    // Prepare insert statement
    $stmt = $mysqli->prepare("INSERT INTO users (name, surname, email) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error: Failed to prepare statement\n");
    }

    // Bind parameters
    $stmt->bind_param("sss", $name, $surname, $email);

    // Iterate through CSV rows
    while (($data = fgetcsv($file)) !== FALSE) {
        $name = ucfirst(strtolower($data[0]));
        $surname = ucfirst(strtolower($data[1]));
        $email = strtolower($data[2]);

        // Validate email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format: $email\n";
            continue;
        }

        // Execute the insert statement
        if (!$dryRun) {
            try {
                if (!$stmt->execute()) {
                    echo "Error inserting data: " . $stmt->error . "\n";
                } else {
                    echo "Inserted data for: $name, $surname, $email\n";
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() === 1062) { // MySQL error code for duplicate entry
                    echo "Duplicate email found: $email\n";
                } else {
                    echo "Error inserting data: " . $e->getMessage() . "\n";
                }
            }
        }
    }

    // Close the CSV file
    fclose($file);

    // Close the prepared statement
    $stmt->close();

    echo "Data insertion sucessfully completed\n";
}

// Connect to MySQL database using the provided command line options
if (isset($options['database'])) {
    $mysqli = new mysqli($options['h'], $options['u'], $options['p'], $options['database']);
} else {
    die("Error: MySQL database name not provided\n");
}

// Check connection to the MySQL database
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
} else {
    echo "Connected to MySQL database: " . $options['database'] . "\n";
}

// Check if --create_table option is provided
if (isset($options['create_table'])) {
    // If create_table option is provided, call createTable() function to create the users table
    createTable($mysqli);
}

// Check if --file option is provided
if (isset($options['file'])) {
    // If file option is provided, insert data from the CSV file into the database
    $filename = $options['file'];
    if (!file_exists($filename)) {
        // Check if the specified file exists
        die("Error: File not found: $filename\n");
    }

    // Check if --dry_run option is provided
    $dryRun = isset($options['dry_run']);

    // Insert data into the users table
    insertData($mysqli, $filename, $dryRun);

    // Show users table as a table
    $result = $mysqli->query("SELECT * FROM users");
    if ($result->num_rows > 0) {
        // If there are rows in the users table, print them as a table
        echo "Users Table:\n";
        echo "-----------------------------------------\n";
        echo "| Name    | Surname | Email             |\n";
        echo "-----------------------------------------\n";
        while ($row = $result->fetch_assoc()) {
            printf("| %-7s | %-7s | %-17s |\n", $row["name"], $row["surname"], $row["email"]);
        }
        echo "-----------------------------------------\n";
    } else {
        // If there are no rows in the users table, print a message
        echo "No users found in the table\n";
    }
} else {
    // If file option is not provided, exit with an error message
    echo "Error: CSV file not provided\n";
}

// Close MySQL connection
$mysqli->close();


?>
