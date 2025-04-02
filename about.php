<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_COOKIE['theme']) ? htmlspecialchars($_COOKIE['theme']) : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Number World</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="min-h-screen bg-base-200">
    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="space-y-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-base-content mb-4">About Number World</h1>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-base-content"><i class="fas fa-bullseye text-primary"></i> Our Mission</h2>
                    <p class="text-base-content/70">Number World is dedicated to making mathematics accessible and engaging for everyone. We believe that understanding numbers and their properties is fundamental to appreciating the mathematical patterns that surround us in daily life.</p>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-base-content"><i class="fas fa-star text-primary"></i> What We Offer</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body items-center text-center">
                            <i class="fas fa-calculator text-3xl text-primary mb-2"></i>
                            <h3 class="card-title text-base-content">Number Analysis</h3>
                            <p class="text-base-content/70">Our number analyzer tool helps you discover various properties of numbers, including whether they're prime, even/odd, perfect squares, or palindromes.</p>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body items-center text-center">
                            <i class="fas fa-book text-3xl text-primary mb-2"></i>
                            <h3 class="card-title text-base-content">Educational Content</h3>
                            <p class="text-base-content/70">Explore our collection of number facts and learn about different types of numbers, their properties, and their significance in mathematics.</p>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body items-center text-center">
                            <i class="fas fa-users text-3xl text-primary mb-2"></i>
                            <h3 class="card-title text-base-content">Community</h3>
                            <p class="text-base-content/70">Join our community of number enthusiasts! Create an account to save your favorite numbers and participate in discussions about mathematical concepts.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-base-content"><i class="fas fa-users text-primary"></i> Who We Are</h2>
                    <p class="text-base-content/70">Number World was created by a team of mathematics enthusiasts and educators who share a passion for numbers and mathematical discovery. Our goal is to create a platform that makes learning about numbers fun and accessible to everyone, from students to curious adults.</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-base-content"><i class="fas fa-flag text-primary"></i> Our Goals</h2>
                    <ul class="space-y-2 text-base-content/70">
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            Make mathematics more approachable and enjoyable
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            Provide tools for exploring number properties
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            Create a community of number enthusiasts
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            Share fascinating facts about numbers and their significance
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            Support mathematical education and discovery
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-base-content"><i class="fas fa-rocket text-primary"></i> Future Plans</h2>
                    <p class="text-base-content/70 mb-4">We're constantly working to improve Number World and add new features. Some of our upcoming plans include:</p>
                    <ul class="space-y-2 text-base-content/70">
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            Interactive mathematical games and puzzles
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            More advanced number analysis tools
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            Educational resources for teachers and students
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary">•</span>
                            Community forums for mathematical discussions
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 