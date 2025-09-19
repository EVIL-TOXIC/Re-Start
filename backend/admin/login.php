<?php
// Always check before starting session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple static login (you can replace this with DB login later)
    if ($username === 'admin' && $password === 'password@123admin') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #121212;
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            width: 800px;
            background: #1e1e1e;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
        }

        .left {
            width: 50%;
            background: #181818;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 4s ease-in-out infinite;
        }

        .left img {
            width: 80%;
            border-radius: 10px;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .right {
            width: 50%;
            padding: 40px;
        }

        form h2 {
            margin-bottom: 30px;
            color: #00e5ff;
            text-align: center;
        }

        .inputBox {
            position: relative;
            margin-bottom: 30px;
        }

        .inputBox input {
            width: 100%;
            padding: 10px;
            background: transparent;
            border: none;
            border-bottom: 2px solid #555;
            color: white;
            font-size: 16px;
            transition: 0.3s;
        }

        .inputBox input:focus,
        .inputBox input:hover {
            border-bottom: 2px solid #00e5ff;
            outline: none;
        }

        .inputBox label {
            position: absolute;
            top: 10px;
            left: 0;
            color: #888;
            pointer-events: none;
            transition: 0.3s;
        }

        .inputBox input:focus+label,
        .inputBox input:valid+label {
            top: -20px;
            font-size: 14px;
            color: #00e5ff;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #00e5ff;
            border: none;
            border-radius: 5px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #00bcd4;
        }

        #errorMsg {
            color: red;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <img src="https://media.giphy.com/media/f9k1tV7HyORcngKF8v/giphy.gif" alt="Animated Admin" />
        </div>
        <div class="right">
            <form method="POST" action="">
                <h2>Admin Login</h2>
                <div class="inputBox">
                    <input type="text" name="username" required />
                    <label>Username</label>
                </div>
                <div class="inputBox">
                    <input type="password" name="password" required />
                    <label>Password</label>
                </div>
                <button type="submit">Login</button>
                <?php if (!empty($error)) echo "<p id='errorMsg'>$error</p>"; ?>
            </form>
        </div>
    </div>
</body>

</html>