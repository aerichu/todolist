<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f3f3f3;
        }
        .login-container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #007bff;
        }
        .login-btn,
        .create-account-btn {
            width: 100%;
            padding: 10px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
        .create-account-btn {
            background-color: #28a745;
            margin-top: 10px;
        }
        .create-account-btn:hover {
            background-color: #218838;
        }
        .g-recaptcha {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form novalidate action="<?= base_url('home/aksi_login') ?>" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="pw" required>
            <span class="toggle-password" onclick="togglePassword()">👁️</span>
        </div>
        <div class="g-recaptcha" data-sitekey="6Lc4hyAqAAAAAII6iyuoLStoTtQFhP4_FKGMl_R_"></div>
        <button type="submit" class="login-btn">Login</button>
        <button type="button" class="create-account-btn" onclick="window.location.href='<?= base_url('home/register') ?>'">Create Account</button>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>

</body>
</html>
