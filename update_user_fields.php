<?php
require_once "config/database.php";

// SQL to alter table if profile_picture column doesn't exist
$alter_table_sql = "ALTER TABLE users 
    ADD COLUMN IF NOT EXISTS profile_picture VARCHAR(255) DEFAULT NULL,
    MODIFY COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";

if ($mysqli->query($alter_table_sql) === TRUE) {
    echo "Table structure updated successfully<br>";
} else {
    echo "Error updating table structure: " . $mysqli->error . "<br>";
}

// Update the existing user record
$update_sql = "UPDATE users 
               SET profile_picture = NULL 
               WHERE username = 'george'";

if ($mysqli->query($update_sql) === TRUE) {
    echo "User record updated successfully";
} else {
    echo "Error updating user record: " . $mysqli->error;
}

$mysqli->close();
?> 