<!DOCTYPE html>
<html>
<head>
    <title>Login Parkify</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8
        }
        .box {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 6px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="box">
        <h3>Login Parkify</h3>

        <?php if (isset($_GET['error'])): ?>
        <p style="color:red">
            Login gagal
        </p>
        <?php endif; ?>
        
        <form method="POST" action="/parkify/app/controllers/AuthController.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <label>
                <input type="checkbox" name="remember"> Ingat saya
            </label>

            <button type="submit" name="login">Login</button>
        </form>
    </div>

</body>
</html>