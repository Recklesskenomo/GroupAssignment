<?php
@session_start(); // Using @ to suppress the notice

// Optional: Log to error_log instead of displaying on page
if (session_status() === PHP_SESSION_ACTIVE) {
    error_log("Notice: session already active in header.php");
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_COOKIE['theme']) ? htmlspecialchars($_COOKIE['theme']) : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number World</title>
    <!-- Tailwind CSS and DaisyUI CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar bg-base-100 shadow-lg">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="number-facts.php">Number Facts</a></li>
                        <li><a href="number-analyzer.php">Number Analyzer</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <a href="index.php" class="btn btn-ghost text-xl">Number World</a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="number-facts.php">Number Facts</a></li>
                    <li><a href="number-analyzer.php">Number Analyzer</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img alt="Avatar" src="<?php echo !empty($_SESSION["profile_picture"]) ? htmlspecialchars($_SESSION["profile_picture"]) : 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION["username"]); ?>" />
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li><span class="text-sm font-semibold">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></span></li>
                            <li><a href="profile.php" class="justify-between">
                                Profile
                                <span class="badge badge-sm">New</span>
                            </a></li>
                            <li><a href="logout.php" class="text-error">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-ghost">Login</a>
                    <a href="register.php" class="btn btn-primary ml-2">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </header> 