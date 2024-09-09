<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styling for background image */
        .login-bg {
            background-image: url('../Media/coffee.jpg'); /* Update with your actual image path */
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="login-bg bg-cover bg-no-repeat h-screen flex items-center justify-center">
    <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
        <div class="text-white">
            <div class="mb-8 flex flex-col items-center">
                <h1 class="mb-2 text-2xl">Login in</h1>
            </div>
            <?php if (!empty($error)): ?>
                <p class="text-red-400 mb-4"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post">
                <div class="mb-4 text-lg">
                    <input style="background-color: #b45309;" class="rounded-3xl border-none px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="email" name="email" id="email" placeholder="id@email.com" required>
                </div>
                <div class="mb-4 text-lg">
                    <input style="background-color: #b45309;" class="rounded-3xl border-none px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="password" name="password" id="password" placeholder="*********" required>
                </div>
                <div class="mt-8 flex justify-center text-lg text-black">
                    <input style="background-color: #b45309;" type="submit" name="login" value="Inloggen" class="rounded-3xl px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-orange-600 cursor-pointer">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
