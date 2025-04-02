<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_COOKIE['theme']) ? htmlspecialchars($_COOKIE['theme']) : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Number World</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="min-h-screen bg-base-100">
    <?php include 'includes/header.php'; ?>

    <div class="hero min-h-[50vh] bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-3xl">
                <h1 class="text-5xl font-bold text-base-content mb-8">Welcome to Number World</h1>
                <p class="text-xl text-base-content/70 mb-8">Discover the fascinating world of numbers and their properties</p>
                <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true): ?>
                    <div class="flex gap-4 justify-center">
                        <a href="register.php" class="btn btn-primary">Get Started</a>
                        <a href="login.php" class="btn btn-ghost">Login</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16 max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-primary mb-4">Explore Our Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                <div class="card bg-base-200 shadow-xl">
                    <div class="card-body items-center text-center">
                        <i class="fas fa-calculator text-4xl text-primary mb-4"></i>
                        <h3 class="card-title">Number Analyzer</h3>
                        <p class="text-base-content/70">Analyze any number to discover its properties: prime, even/odd, perfect square, and more!</p>
                        <div class="card-actions mt-4">
                            <a href="number-analyzer.php" class="btn btn-primary">Try It Now</a>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-200 shadow-xl">
                    <div class="card-body items-center text-center">
                        <i class="fas fa-book text-4xl text-primary mb-4"></i>
                        <h3 class="card-title">Number Facts</h3>
                        <p class="text-base-content/70">Learn fascinating facts about different types of numbers and their significance in mathematics.</p>
                        <div class="card-actions mt-4">
                            <a href="number-facts.php" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-200 shadow-xl">
                    <div class="card-body items-center text-center">
                        <i class="fas fa-users text-4xl text-primary mb-4"></i>
                        <h3 class="card-title">Join Community</h3>
                        <p class="text-base-content/70">Connect with other number enthusiasts and share your mathematical discoveries.</p>
                        <div class="card-actions mt-4">
                            <a href="register.php" class="btn btn-primary">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-primary mb-8">Did You Know?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card bg-base-200 shadow-xl">
                    <div class="card-body">
                        <h4 class="card-title justify-center text-primary">Zero</h4>
                        <p class="text-base-content/70">The concept of zero was developed independently by ancient civilizations including the Mayans and Indians.</p>
                    </div>
                </div>
                <div class="card bg-base-200 shadow-xl">
                    <div class="card-body">
                        <h4 class="card-title justify-center text-primary">Golden Ratio</h4>
                        <p class="text-base-content/70">The golden ratio (approximately 1.618) appears throughout nature and is considered aesthetically pleasing.</p>
                    </div>
                </div>
                <div class="card bg-base-200 shadow-xl">
                    <div class="card-body">
                        <h4 class="card-title justify-center text-primary">Prime Numbers</h4>
                        <p class="text-base-content/70">There are infinitely many prime numbers, as proven by Euclid around 300 BCE.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
