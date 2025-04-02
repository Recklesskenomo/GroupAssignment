<?php
session_start();

// Check if the user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

require_once "config/database.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password, profile_picture FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;
            
            if($stmt->execute()) {
                $result = $stmt->get_result();
                
                if($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    if(password_verify($password, $row["password"])) {
                        // Password is correct, start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $row["id"];
                        $_SESSION["username"] = $row["username"];
                        $_SESSION["profile_picture"] = $row["profile_picture"];
                        
                        // Redirect user to welcome page
                        header("location: index.php");
                        exit;
                    } else {
                        $login_err = "Invalid username or password.";
                    }
                } else {
                    $login_err = "Invalid username or password.";
                }
            } else {
                $login_err = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_COOKIE['theme']) ? htmlspecialchars($_COOKIE['theme']) : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Number World</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="min-h-screen bg-base-200">
    <?php include 'includes/header.php'; ?>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-base-content">Login</h2>
                        <p class="mt-2 text-base-content/70">Please fill in your credentials to login.</p>
                    </div>

                    <?php 
                    if(!empty($login_err)){
                        echo '<div class="alert alert-error mt-4">
                            <i class="fas fa-exclamation-circle"></i>
                            ' . $login_err . '
                        </div>';
                    }        
                    ?>

                    <form class="mt-8 space-y-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-control">
                            <label class="label" for="username">
                                <span class="label-text">Username</span>
                            </label>
                            <input type="text" name="username" id="username" 
                                class="input input-bordered w-full <?php echo (!empty($username_err)) ? 'input-error' : ''; ?>" 
                                value="<?php echo $username; ?>">
                            <?php if(!empty($username_err)): ?>
                                <label class="label">
                                    <span class="label-text-alt text-error"><?php echo $username_err; ?></span>
                                </label>
                            <?php endif; ?>
                        </div>

                        <div class="form-control">
                            <label class="label" for="password">
                                <span class="label-text">Password</span>
                            </label>
                            <input type="password" name="password" id="password" 
                                class="input input-bordered w-full <?php echo (!empty($password_err)) ? 'input-error' : ''; ?>">
                            <?php if(!empty($password_err)): ?>
                                <label class="label">
                                    <span class="label-text-alt text-error"><?php echo $password_err; ?></span>
                                </label>
                            <?php endif; ?>
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary w-full">Login</button>
                        </div>

                        <div class="text-center text-base-content/70">
                            Don't have an account? <a href="register.php" class="link link-primary">Sign up now</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 