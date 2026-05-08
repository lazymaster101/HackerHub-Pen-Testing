<?php
require_once 'config.php';

// Redirect to dashboard if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HackerHub - Security Research Platform</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 class="logo">🔐 HackerHub</h1>
            <p class="tagline">Connect. Research. Exploit.</p>
        </header>

        <div class="auth-container">
            <div class="auth-box">
                <h2>Login</h2>
                <form id="loginForm" class="auth-form">
                    <div class="form-group">
                        <label for="login-username">Username</label>
                        <input type="text" id="login-username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <div id="login-message" class="message"></div>
            </div>

            <div class="auth-box">
                <h2>Register</h2>
                <form id="registerForm" class="auth-form">
                    <div class="form-group">
                        <label for="reg-username">Username</label>
                        <input type="text" id="reg-username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="reg-email">Email</label>
                        <input type="email" id="reg-email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="reg-uin">UIN (9 digits)</label>
                        <input
                            type="text"
                            id="reg-uin"
                            name="uin"
                            pattern="\d{9}"
                            maxlength="9"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="reg-password">Password</label>
                        <input type="password" id="reg-password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-secondary">Register</button>
                </form>

                <div id="register-message" class="message"></div>
            </div>
        </div>

        <div class="info-section">
            <h3>Welcome to HackerHub</h3>
            <p>A community platform for security researchers, penetration testers, and ethical hackers.</p>
            <ul>
                <li>Share security research and findings</li>
                <li>Browse technical documentation</li>
                <li>Connect with fellow researchers</li>
                <li>Collaborate on security projects</li>
            </ul>
            <p class="hint">Register a new account with your 9-digit UIN to get started.</p>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script>
        // Login form handler
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'login',
                        username: formData.get('username'),
                        password: formData.get('password')
                    })
                });

                const data = await response.json();
                const messageDiv = document.getElementById('login-message');

                if (data.success) {
                    messageDiv.className = 'message success';
                    messageDiv.textContent = 'Login successful! Redirecting...';
                    setTimeout(() => window.location.href = 'dashboard.php', 1000);
                } else {
                    messageDiv.className = 'message error';
                    messageDiv.textContent = data.message || 'Login failed';
                }
            } catch (error) {
                const msg = document.getElementById('login-message');
                msg.className = 'message error';
                msg.textContent = 'Error: ' + error.message;
            }
        });

        // Register form handler
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'register',
                        username: formData.get('username'),
                        email: formData.get('email'),
                        password: formData.get('password'),
                        uin: formData.get('uin')
                    })
                });

                const data = await response.json();
                const messageDiv = document.getElementById('register-message');

                if (data.success) {
                    messageDiv.className = 'message success';
                    messageDiv.textContent = 'Registration successful! You can now login.';
                    e.target.reset();
                } else {
                    messageDiv.className = 'message error';
                    messageDiv.textContent = data.message || 'Registration failed';
                }
            } catch (error) {
                const msg = document.getElementById('register-message');
                msg.className = 'message error';
                msg.textContent = 'Error: ' + error.message;
            }
        });
    </script>
</body>
</html>
