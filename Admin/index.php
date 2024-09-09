<?php
session_start();
require 'Database.php';
require 'User.php'; // Ensure you include the User class

$db = (new Database())->connect();
$userObj = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Debug: Check if email and password are received
    if (empty($email) || empty($password)) {
        $error_message = 'Email and password are required.';
    } else {
        $user = $userObj->findUserByEmail($email);

        if ($user && $userObj->verifyPassword($password, $user['password'])) {
            // Start the session
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['idUsers'];
            $_SESSION['role'] = $user['role'];

            header('Location: welcome.php');  // Redirect to welcome.php after successful login
            exit;
        } else {
            $error_message = 'Invalid login credentials.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .dark-mode {
            background-color: #1f2937; /* Dark background color */
            color: #e5e7eb; /* Light text color */
        }
        .light-mode {
            background-color: #f9fafb; /* Light background color */
            color: #1f2937; /* Dark text color */
        }
    </style>
</head>
<body class="light-mode">

    <!-- Theme Toggle Button -->
    <div class="fixed top-4 right-4">
        <button id="theme-toggle" class="p-2 bg-gray-200 rounded-full text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
            <span id="theme-icon" class="material-icons">brightness_6</span>
        </button>
    </div>

    <!-- Login Form -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg dark:bg-gray-800">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Admin Login</h1>
            <?php if (isset($error_message)) : ?>
                <div class="mb-4 p-4 text-red-700 bg-red-200 rounded">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                    <input type="email" name="email" id="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-indigo-400">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wachtwoord</label>
                    <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-indigo-400">
                </div>
                <div>
                    <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        Inloggen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Theme Toggle -->
    <script>
        const themeToggleButton = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;

        themeToggleButton.addEventListener('click', () => {
            if (body.classList.contains('light-mode')) {
                body.classList.remove('light-mode');
                body.classList.add('dark-mode');
                themeIcon.textContent = 'brightness_7';
            } else {
                body.classList.remove('dark-mode');
                body.classList.add('light-mode');
                themeIcon.textContent = 'brightness_6';
            }
        });
    </script>
</body>
</html>
