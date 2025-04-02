<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file for database connection
require_once "config/database.php";

// Initialize variables
$new_username = $new_email = $current_password = $new_password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";
$success_message = $error_message = "";

// Process profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_profile"])) {
        // Validate username
        if (empty(trim($_POST["new_username"]))) {
            $username_err = "Please enter a username.";
        } else {
            $new_username = trim($_POST["new_username"]);
            if ($new_username !== $_SESSION["username"]) {
                $sql = "SELECT id FROM users WHERE username = ? AND id != ?";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("si", $new_username, $_SESSION["id"]);
                    if ($stmt->execute()) {
                        $stmt->store_result();
                        if ($stmt->num_rows > 0) {
                            $username_err = "This username is already taken.";
                        }
                    } else {
                        error_log("Error executing username check: " . $mysqli->error);
                        $error_message = "Oops! Something went wrong. Please try again later.";
                    }
                    $stmt->close();
                }
            }
        }

        // Validate email
        if (empty(trim($_POST["new_email"]))) {
            $email_err = "Please enter an email.";
        } else {
            $new_email = trim($_POST["new_email"]);
            if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Please enter a valid email address.";
            }
        }

        // If no errors, proceed with update
        if (empty($username_err) && empty($email_err)) {
            $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ssi", $new_username, $new_email, $_SESSION["id"]);
                if ($stmt->execute()) {
                    $_SESSION["username"] = $new_username;
                    $success_message = "Profile updated successfully!";
                } else {
                    error_log("Error updating profile: " . $mysqli->error);
                    $error_message = "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }
    }
    
    // Process password reset request
    else if (isset($_POST["request_otp"])) {
        // Generate OTP
        $otp = sprintf("%06d", mt_rand(0, 999999));
        $_SESSION["reset_otp"] = $otp;
        $_SESSION["otp_timestamp"] = time();
        
        // For testing purposes, show OTP in the success message
        $success_message = "Your OTP is: " . $otp . " (This would be sent via email in production)";
        error_log("Generated OTP for password reset: " . $otp);
    }
    
    // Verify OTP and reset password
    else if (isset($_POST["reset_password"])) {
        $entered_otp = trim($_POST["otp"]);
        $new_password = trim($_POST["new_password"]);
        $confirm_password = trim($_POST["confirm_password"]);
        
        // Validate OTP
        if (empty($entered_otp)) {
            $error_message = "Please enter OTP.";
        } else if (!isset($_SESSION["reset_otp"]) || $entered_otp !== $_SESSION["reset_otp"]) {
            $error_message = "Invalid OTP.";
        } else if (time() - $_SESSION["otp_timestamp"] > 300) { // 5 minutes expiry
            $error_message = "OTP has expired. Please request a new one.";
        }
        // Validate password
        else if (empty($new_password)) {
            $password_err = "Please enter a new password.";
        } else if (strlen($new_password) < 6) {
            $password_err = "Password must have at least 6 characters.";
        }
        // Validate confirm password
        else if (empty($confirm_password)) {
            $confirm_password_err = "Please confirm password.";
        } else if ($new_password != $confirm_password) {
            $confirm_password_err = "Password did not match.";
        }
        
        // If no errors, proceed with password update
        if (empty($error_message) && empty($password_err) && empty($confirm_password_err)) {
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt->bind_param("si", $hashed_password, $_SESSION["id"]);
                if ($stmt->execute()) {
                    // Clear OTP session variables
                    unset($_SESSION["reset_otp"]);
                    unset($_SESSION["otp_timestamp"]);
                    $success_message = "Password has been reset successfully!";
                } else {
                    error_log("Error resetting password: " . $mysqli->error);
                    $error_message = "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }
    }
}

// Get current user data
$sql = "SELECT username, email, profile_picture FROM users WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $_SESSION["id"]);
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($current_username, $current_email, $current_profile_picture);
            $stmt->fetch();
        }
    } else {
        error_log("Error fetching user data: " . $mysqli->error);
    }
    $stmt->close();
}

// Close connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_COOKIE['theme']) ? htmlspecialchars($_COOKIE['theme']) : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management - Number World</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="min-h-screen bg-base-100">
    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-primary mb-4">Profile Management</h1>
                <p class="text-xl text-base-content/70">Manage your account settings and preferences</p>
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success mb-8">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-error mb-8">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Profile Picture Section -->
                <div class="card bg-base-200 shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="avatar mb-4">
                            <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="<?php echo !empty($current_profile_picture) ? htmlspecialchars($current_profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($current_username); ?>" alt="Profile Picture" />
                            </div>
                        </div>
                        <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data" class="w-full">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Update Profile Picture</span>
                                </label>
                                <input type="file" name="profile_picture" accept="image/*" class="file-input file-input-bordered w-full" />
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Upload Picture</button>
                        </form>
                    </div>
                </div>

                <!-- Profile Details Section -->
                <div class="card bg-base-200 shadow-xl md:col-span-2">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Profile Details</h2>
                        <form method="post">
                            <div class="form-control w-full mb-4">
                                <label class="label">
                                    <span class="label-text">Username</span>
                                </label>
                                <input type="text" name="new_username" class="input input-bordered w-full <?php echo (!empty($username_err)) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($current_username); ?>" />
                                <?php if (!empty($username_err)): ?>
                                    <label class="label">
                                        <span class="label-text-alt text-error"><?php echo $username_err; ?></span>
                                    </label>
                                <?php endif; ?>
                            </div>

                            <div class="form-control w-full mb-4">
                                <label class="label">
                                    <span class="label-text">Email</span>
                                </label>
                                <input type="email" name="new_email" class="input input-bordered w-full <?php echo (!empty($email_err)) ? 'input-error' : ''; ?>" value="<?php echo htmlspecialchars($current_email); ?>" />
                                <?php if (!empty($email_err)): ?>
                                    <label class="label">
                                        <span class="label-text-alt text-error"><?php echo $email_err; ?></span>
                                    </label>
                                <?php endif; ?>
                            </div>

                            <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                        </form>

                        <div class="divider"></div>

                        <h2 class="card-title mb-4">Reset Password</h2>
                        <form method="post" class="space-y-4">
                            <div class="form-control">
                                <button type="submit" name="request_otp" class="btn btn-secondary">Request OTP</button>
                            </div>

                            <?php if (isset($_SESSION["reset_otp"])): ?>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Enter OTP</span>
                                    </label>
                                    <input type="text" name="otp" class="input input-bordered" />
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">New Password</span>
                                    </label>
                                    <input type="password" name="new_password" class="input input-bordered <?php echo (!empty($password_err)) ? 'input-error' : ''; ?>" />
                                    <?php if (!empty($password_err)): ?>
                                        <label class="label">
                                            <span class="label-text-alt text-error"><?php echo $password_err; ?></span>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Confirm New Password</span>
                                    </label>
                                    <input type="password" name="confirm_password" class="input input-bordered <?php echo (!empty($confirm_password_err)) ? 'input-error' : ''; ?>" />
                                    <?php if (!empty($confirm_password_err)): ?>
                                        <label class="label">
                                            <span class="label-text-alt text-error"><?php echo $confirm_password_err; ?></span>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <button type="submit" name="reset_password" class="btn btn-primary">Reset Password</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- Settings Section -->
                <div class="card bg-base-200 shadow-xl md:col-span-3">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Settings</h2>
                        <div class="flex items-center gap-4">
                            <span class="text-base-content">Theme:</span>
                            <div class="btn-group">
                                <button onclick="setTheme('light')" class="btn btn-sm" data-theme="light">Light</button>
                                <button onclick="setTheme('dark')" class="btn btn-sm" data-theme="dark">Dark</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        document.cookie = `theme=${theme};path=/;max-age=31536000`; // 1 year expiry
        
        // Reload the page to ensure all components update
        location.reload();
    }
    </script>
</body>
</html> 