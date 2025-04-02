<?php
require_once "includes/config.php";

$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;
            if(mysqli_stmt_execute($stmt)) {
                header("location: login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}

include 'includes/header.php';
?>

<div class="min-h-screen bg-base-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-base-100 rounded-lg shadow-xl p-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-base-content">Create Account</h2>
            <p class="mt-2 text-base-content/70">Join our community of number enthusiasts!</p>
        </div>

        <form class="mt-8 space-y-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="space-y-4">
                <div>
                    <label class="label" for="username">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" name="username" id="username" 
                        class="input input-bordered w-full <?php echo (!empty($username_err)) ? 'input-error' : ''; ?>" 
                        value="<?php echo $username; ?>"
                        placeholder="Choose a unique username">
                    <?php if(!empty($username_err)): ?>
                        <div class="text-error text-sm mt-1"><?php echo $username_err; ?></div>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="label" for="email">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" id="email" 
                        class="input input-bordered w-full <?php echo (!empty($email_err)) ? 'input-error' : ''; ?>" 
                        value="<?php echo $email; ?>"
                        placeholder="Enter your email address">
                    <?php if(!empty($email_err)): ?>
                        <div class="text-error text-sm mt-1"><?php echo $email_err; ?></div>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="label" for="password">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" id="password" 
                        class="input input-bordered w-full <?php echo (!empty($password_err)) ? 'input-error' : ''; ?>"
                        placeholder="Choose a strong password">
                    <?php if(!empty($password_err)): ?>
                        <div class="text-error text-sm mt-1"><?php echo $password_err; ?></div>
                    <?php endif; ?>
                    <label class="label">
                        <span class="label-text-alt text-base-content/70">Must be at least 6 characters long</span>
                    </label>
                </div>

                <div>
                    <label class="label" for="confirm_password">
                        <span class="label-text">Confirm Password</span>
                    </label>
                    <input type="password" name="confirm_password" id="confirm_password" 
                        class="input input-bordered w-full <?php echo (!empty($confirm_password_err)) ? 'input-error' : ''; ?>"
                        placeholder="Confirm your password">
                    <?php if(!empty($confirm_password_err)): ?>
                        <div class="text-error text-sm mt-1"><?php echo $confirm_password_err; ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center justify-between space-x-4">
                <button type="submit" class="btn btn-primary flex-1">Create Account</button>
                <button type="reset" class="btn btn-ghost flex-1">Reset</button>
            </div>

            <div class="text-center text-base-content/70 pt-4 border-t border-base-content/10">
                Already have an account? <a href="login.php" class="link link-primary">Login here</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 