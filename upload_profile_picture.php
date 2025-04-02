<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config/database.php";

$upload_success = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $allowed_types = ["image/jpeg", "image/png", "image/gif"];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        $file = $_FILES["profile_picture"];
        
        // Validate file type
        if (!in_array($file["type"], $allowed_types)) {
            $error_message = "Only JPG, PNG & GIF files are allowed.";
            error_log("Invalid file type uploaded: " . $file["type"]);
        }
        // Validate file size
        else if ($file["size"] > $max_size) {
            $error_message = "File size must be less than 5MB.";
            error_log("File too large: " . $file["size"] . " bytes");
        }
        else {
            // Create uploads directory if it doesn't exist
            $upload_dir = "uploads/profile_pictures/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Generate unique filename
            $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
            $filename = uniqid("profile_") . "." . $file_extension;
            $target_path = $upload_dir . $filename;
            
            // Move uploaded file
            if (move_uploaded_file($file["tmp_name"], $target_path)) {
                // Update database with new profile picture path
                $sql = "UPDATE users SET profile_picture = ? WHERE id = ?";
                if ($stmt = $mysqli->prepare($sql)) {
                    $file_path = $target_path;
                    $stmt->bind_param("si", $file_path, $_SESSION["id"]);
                    
                    if ($stmt->execute()) {
                        $upload_success = true;
                        
                        // Delete old profile picture if exists
                        $old_picture = $_SESSION["profile_picture"] ?? "";
                        if (!empty($old_picture) && file_exists($old_picture) && $old_picture != $file_path) {
                            unlink($old_picture);
                        }
                        
                        $_SESSION["profile_picture"] = $file_path;
                    } else {
                        $error_message = "Error updating database.";
                        error_log("Database error: " . $mysqli->error);
                        // Remove uploaded file if database update fails
                        unlink($target_path);
                    }
                    $stmt->close();
                }
            } else {
                $error_message = "Error uploading file.";
                error_log("Error moving uploaded file to target location");
            }
        }
    } else {
        $error_message = "Please select a file to upload.";
        error_log("No file uploaded or upload error occurred");
    }
}

$mysqli->close();

// Redirect back to profile page with status
if ($upload_success) {
    header("location: profile.php?upload_status=success");
} else {
    header("location: profile.php?upload_status=error&message=" . urlencode($error_message));
}
exit;
?> 