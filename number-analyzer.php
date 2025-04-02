<?php
session_start();

function isPrime($number) {
    if ($number <= 1) return false;
    if ($number <= 3) return true;
    if ($number % 2 == 0 || $number % 3 == 0) return false;
    
    for ($i = 5; $i * $i <= $number; $i += 6) {
        if ($number % $i == 0 || $number % ($i + 2) == 0) return false;
    }
    return true;
}

function getNumberProperties($number) {
    $properties = [];
    
    // Check if odd or even
    $properties['isEven'] = ($number % 2 == 0);
    
    // Check if prime
    $properties['isPrime'] = isPrime($number);
    
    // Check if perfect square
    $sqrt = sqrt($number);
    $properties['isPerfectSquare'] = ($sqrt == floor($sqrt));
    
    // Check if palindrome
    $properties['isPalindrome'] = (strval($number) == strrev(strval($number)));
    
    return $properties;
}

$number = $error = "";
$properties = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["number"])) {
        $error = "Please enter a number";
    } else {
        $number = filter_var($_POST["number"], FILTER_VALIDATE_INT);
        if ($number === false) {
            $error = "Please enter a valid integer";
        } else {
            $properties = getNumberProperties($number);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_COOKIE['theme']) ? htmlspecialchars($_COOKIE['theme']) : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Analyzer - Number World</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="min-h-screen bg-base-200">
    <?php include 'includes/header.php'; ?>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-base-content">Number Analyzer</h1>
                <p class="mt-2 text-xl text-base-content/70">Discover the fascinating properties of any number!</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Analysis Form -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Enter a Number</h2>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
                            <div class="form-control">
                                <label class="label" for="number">
                                    <span class="label-text">Choose any integer to analyze</span>
                                </label>
                                <input type="number" name="number" id="number" 
                                    class="input input-bordered w-full <?php echo (!empty($error)) ? 'input-error' : ''; ?>" 
                                    value="<?php echo $number; ?>"
                                    placeholder="Enter a number">
                                <?php if(!empty($error)): ?>
                                    <label class="label">
                                        <span class="label-text-alt text-error"><?php echo $error; ?></span>
                                    </label>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary w-full">Analyze Number</button>
                        </form>
                    </div>
                </div>

                <!-- Results Section -->
                <?php if ($properties !== null): ?>
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Results for <?php echo $number; ?></h2>
                        <div class="stats stats-vertical shadow w-full">
                            <div class="stat">
                                <div class="stat-title">Even/Odd</div>
                                <div class="stat-value text-lg">
                                    <?php echo $properties['isEven'] ? 'Even Number' : 'Odd Number'; ?>
                                </div>
                                <div class="stat-desc">
                                    <?php echo $properties['isEven'] ? 'Divisible by 2' : 'Not divisible by 2'; ?>
                                </div>
                            </div>

                            <div class="stat">
                                <div class="stat-title">Prime Number</div>
                                <div class="stat-value text-lg">
                                    <?php echo $properties['isPrime'] ? 'Prime' : 'Not Prime'; ?>
                                </div>
                                <div class="stat-desc">
                                    <?php echo $properties['isPrime'] ? 'Only divisible by 1 and itself' : 'Has multiple factors'; ?>
                                </div>
                            </div>

                            <div class="stat">
                                <div class="stat-title">Perfect Square</div>
                                <div class="stat-value text-lg">
                                    <?php echo $properties['isPerfectSquare'] ? 'Perfect Square' : 'Not a Perfect Square'; ?>
                                </div>
                                <div class="stat-desc">
                                    <?php echo $properties['isPerfectSquare'] ? 'Square root is a whole number' : 'Square root is not a whole number'; ?>
                                </div>
                            </div>

                            <div class="stat">
                                <div class="stat-title">Palindrome</div>
                                <div class="stat-value text-lg">
                                    <?php echo $properties['isPalindrome'] ? 'Palindrome' : 'Not a Palindrome'; ?>
                                </div>
                                <div class="stat-desc">
                                    <?php echo $properties['isPalindrome'] ? 'Reads the same forwards and backwards' : 'Different when read backwards'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <i class="fas fa-calculator text-6xl text-primary mb-4"></i>
                        <h2 class="card-title">Ready to Analyze</h2>
                        <p class="text-base-content/70">Enter a number on the left to discover its mathematical properties!</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Additional Information -->
            <div class="mt-12 card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Understanding Number Properties</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <h3 class="font-semibold text-base-content">Even and Odd Numbers</h3>
                            <p class="text-base-content/70">Even numbers are divisible by 2 with no remainder, while odd numbers have a remainder of 1 when divided by 2.</p>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-semibold text-base-content">Prime Numbers</h3>
                            <p class="text-base-content/70">Prime numbers are natural numbers greater than 1 that are only divisible by 1 and themselves.</p>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-semibold text-base-content">Perfect Squares</h3>
                            <p class="text-base-content/70">A perfect square is a number that's the product of an integer with itself. For example: 1, 4, 9, 16, 25, etc.</p>
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-semibold text-base-content">Palindrome Numbers</h3>
                            <p class="text-base-content/70">A palindrome number reads the same backward as forward. For example: 11, 121, 12321, etc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 