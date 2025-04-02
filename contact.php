<?php
session_start();

$name = $email = $subject = $message = "";
$name_err = $email_err = $subject_err = $message_err = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } elseif (strlen(trim($_POST["name"])) < 2) {
        $name_err = "Name must be at least 2 characters long.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate subject
    if (empty(trim($_POST["subject"]))) {
        $subject_err = "Please enter a subject.";
    } elseif (strlen(trim($_POST["subject"])) < 5) {
        $subject_err = "Subject must be at least 5 characters long.";
    } else {
        $subject = trim($_POST["subject"]);
    }

    // Validate message
    if (empty(trim($_POST["message"]))) {
        $message_err = "Please enter your message.";
    } elseif (strlen(trim($_POST["message"])) < 10) {
        $message_err = "Message must be at least 10 characters long.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Check if there are no errors
    if (empty($name_err) && empty($email_err) && empty($subject_err) && empty($message_err)) {
        // In a real application, you would send the email here
        // For this example, we'll just show a success message
        $success_message = "Thank you for your message! We'll get back to you soon.";
        
        // Clear the form
        $name = $email = $subject = $message = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo isset($_COOKIE['theme']) ? htmlspecialchars($_COOKIE['theme']) : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Number World</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="min-h-screen bg-base-200">
    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-base-content mb-4">Contact Us</h1>
                <p class="text-xl text-base-content/70">Have questions about numbers or suggestions for our website? We'd love to hear from you!</p>
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success mb-8">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-control w-full mb-4">
                                    <label class="label">
                                        <span class="label-text">Name</span>
                                    </label>
                                    <input type="text" name="name" 
                                           class="input input-bordered w-full <?php echo (!empty($name_err)) ? 'input-error' : ''; ?>" 
                                           value="<?php echo $name; ?>" />
                                    <?php if (!empty($name_err)): ?>
                                        <label class="label">
                                            <span class="label-text-alt text-error"><?php echo $name_err; ?></span>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <div class="form-control w-full mb-4">
                                    <label class="label">
                                        <span class="label-text">Email</span>
                                    </label>
                                    <input type="email" name="email" 
                                           class="input input-bordered w-full <?php echo (!empty($email_err)) ? 'input-error' : ''; ?>" 
                                           value="<?php echo $email; ?>" />
                                    <?php if (!empty($email_err)): ?>
                                        <label class="label">
                                            <span class="label-text-alt text-error"><?php echo $email_err; ?></span>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <div class="form-control w-full mb-4">
                                    <label class="label">
                                        <span class="label-text">Subject</span>
                                    </label>
                                    <input type="text" name="subject" 
                                           class="input input-bordered w-full <?php echo (!empty($subject_err)) ? 'input-error' : ''; ?>" 
                                           value="<?php echo $subject; ?>" />
                                    <?php if (!empty($subject_err)): ?>
                                        <label class="label">
                                            <span class="label-text-alt text-error"><?php echo $subject_err; ?></span>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <div class="form-control w-full mb-6">
                                    <label class="label">
                                        <span class="label-text">Message</span>
                                    </label>
                                    <textarea name="message" 
                                              class="textarea textarea-bordered h-32 w-full <?php echo (!empty($message_err)) ? 'textarea-error' : ''; ?>"
                                    ><?php echo $message; ?></textarea>
                                    <?php if (!empty($message_err)): ?>
                                        <label class="label">
                                            <span class="label-text-alt text-error"><?php echo $message_err; ?></span>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <div class="flex gap-4">
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                    <button type="reset" class="btn btn-ghost">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body items-center text-center">
                            <i class="fas fa-envelope text-3xl text-primary mb-2"></i>
                            <h3 class="card-title text-base-content">Email</h3>
                            <p class="text-base-content/70">info@numberworld.com</p>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body items-center text-center">
                            <i class="fas fa-clock text-3xl text-primary mb-2"></i>
                            <h3 class="card-title text-base-content">Response Time</h3>
                            <p class="text-base-content/70">We typically respond within 24-48 hours</p>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body items-center text-center">
                            <i class="fas fa-question-circle text-3xl text-primary mb-2"></i>
                            <h3 class="card-title text-base-content">FAQ</h3>
                            <p class="text-base-content/70">Check our <a href="#" class="link link-primary">frequently asked questions</a> for quick answers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 