<?php

// Database connection details
$servername = "localhost"; // Your MySQL server hostname (usually 'localhost')
$username = "root"; // **IMPORTANT: Your MySQL username**
$password = ""; // **IMPORTANT: Your MySQL password**
$dbname = "gym_management"; // The name of the database to create

// --- Establish Database Connection ---
$conn = new mysqli($servername, $username, $password);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Create the Database if it Doesn't Exist ---
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database '$dbname' created successfully or already exists.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// --- Select the Database to Work With ---
$conn->select_db($dbname);

// --- SQL Commands to Create Tables ---
// Using IF NOT EXISTS ensures tables are only created if they don't already exist.
// ON DELETE CASCADE ensures related records are deleted when a parent record is.
$sql_create_tables = "
CREATE TABLE IF NOT EXISTS clients (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE,
    phone_number VARCHAR(20),
    email VARCHAR(100) UNIQUE NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS memberships (
    membership_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    membership_type VARCHAR(50) NOT NULL, -- e.g., 'Monthly', 'Annual', '10-visits'
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(client_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS trainers (
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone_number VARCHAR(20),
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS trainings (
    training_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    trainer_id INT NOT NULL,
    training_date DATE NOT NULL,
    training_time TIME NOT NULL,
    duration_minutes INT,
    notes TEXT,
    FOREIGN KEY (client_id) REFERENCES clients(client_id) ON DELETE CASCADE,
    FOREIGN KEY (trainer_id) REFERENCES trainers(trainer_id) ON DELETE CASCADE
);
";

// --- Execute Multiple SQL Queries for Table Creation ---
// The loop handles multiple queries and correctly checks for more results
// to avoid the "Strict Standards" warning.
if ($conn->multi_query($sql_create_tables)) {
    do {
        // Store result set if any (e.g., from SELECT, which isn't used here, but good practice)
        if ($result = $conn->store_result()) {
            $result->free(); // Free the result set memory
        }
        // Move to the next result set only if there are more results
    } while ($conn->more_results() && $conn->next_result());
    echo "Tables created successfully or already exist.<br>";
} else {
    echo "Error creating tables: " . $conn->error . "<br>";
}

// --- Close the Database Connection ---
$conn->close();

?>