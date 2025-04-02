<?php
@session_start(); // Using @ to suppress the notice

// Optional: Log to error_log instead of displaying on page
if (session_status() === PHP_SESSION_ACTIVE) {
    error_log("Notice: session already active in number-facts.php");
}

$number_facts = [
    [
        'title' => 'Prime Numbers',
        'description' => 'Prime numbers are natural numbers greater than 1 that are only divisible by 1 and themselves. The first few prime numbers are 2, 3, 5, 7, 11, 13, 17, 19, 23, and 29.',
        'fun_fact' => 'The largest known prime number has over 24 million digits!',
        'icon' => 'fa-star'
    ],
    [
        'title' => 'Perfect Numbers',
        'description' => 'A perfect number is a positive integer that is equal to the sum of its proper divisors. The first perfect number is 6 (1 + 2 + 3 = 6).',
        'fun_fact' => 'Only 51 perfect numbers have been discovered so far, and they\'re all even!',
        'icon' => 'fa-check-circle'
    ],
    [
        'title' => 'Fibonacci Numbers',
        'description' => 'The Fibonacci sequence is a series where each number is the sum of the two preceding ones. It starts with 0, 1, 1, 2, 3, 5, 8, 13, 21, 34, ...',
        'fun_fact' => 'The Fibonacci sequence appears in nature, like in the spiral arrangement of leaves and flower petals!',
        'icon' => 'fa-leaf'
    ],
    [
        'title' => 'Pi (π)',
        'description' => 'Pi is the ratio of a circle\'s circumference to its diameter. It\'s approximately 3.14159, but its decimal places go on forever without repeating.',
        'fun_fact' => 'Pi has been calculated to over 31 trillion digits!',
        'icon' => 'fa-circle'
    ],
    [
        'title' => 'Golden Ratio',
        'description' => 'The golden ratio (approximately 1.618) is considered the most aesthetically pleasing proportion in nature and art.',
        'fun_fact' => 'The golden ratio is often found in the proportions of famous buildings and artworks!',
        'icon' => 'fa-ruler'
    ],
    [
        'title' => 'Zero',
        'description' => 'Zero is neither positive nor negative. It\'s a crucial concept in mathematics that represents nothingness.',
        'fun_fact' => 'Ancient civilizations struggled with the concept of zero, and it wasn\'t widely accepted until the 9th century!',
        'icon' => 'fa-circle-notch'
    ]
];
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_COOKIE['theme']) ? htmlspecialchars($_COOKIE['theme']) : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Facts - Number World</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="min-h-screen bg-base-200">
    <?php include 'includes/header.php'; ?>
    
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-base-content">Fascinating Number Facts</h1>
                <p class="mt-4 text-xl text-base-content/70">Discover interesting facts about numbers that will amaze you!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($number_facts as $fact): ?>
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                        <div class="card-body">
                            <div class="flex items-center gap-3 mb-4">
                                <i class="fas <?php echo $fact['icon']; ?> text-2xl text-primary"></i>
                                <h2 class="card-title text-base-content"><?php echo $fact['title']; ?></h2>
                            </div>
                            <p class="text-base-content/70"><?php echo $fact['description']; ?></p>
                            <div class="divider"></div>
                            <div class="bg-base-200 rounded-lg p-4">
                                <p class="text-sm font-medium text-base-content">Fun Fact:</p>
                                <p class="text-base-content/70 mt-1"><?php echo $fact['fun_fact']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-16 bg-base-100 rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-base-content mb-6">Why Numbers Matter</h2>
                <div class="prose prose-lg max-w-none text-base-content/70">
                    <p>Numbers are fundamental to our understanding of the universe. They help us count, measure, and make sense of the world around us. From ancient civilizations to modern mathematics, numbers have played a crucial role in human development.</p>
                </div>
            </div>

            <div class="mt-12 bg-base-100 rounded-lg shadow-xl p-8">
                <h2 class="text-2xl font-bold text-base-content mb-6">Historical Number Systems</h2>
                <div class="prose prose-lg max-w-none text-base-content/70">
                    <p>Throughout history, different civilizations developed their own number systems. The Babylonians used a base-60 system, which we still see in our measurements of time. The Maya developed a vigesimal (base-20) system, while the Romans used letters to represent numbers.</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 