<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
            padding: 0 10px;
        }

        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: url("https://images.squarespace-cdn.com/content/v1/5fe4caeadae61a2f19719512/e29e6a85-ed60-408c-806b-622a99c34c35/Screenshot+%281730%29.jpg"), #000;
            background-position: center;
            background-size: cover;
        }

        .wrapper {
            /* height: 400px; */
            width: 400px;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .input-field {
            position: relative;
            border-bottom: 2px solid #ccc;
            margin: 15px 0;
        }

        .input-field label {
            position: absolute;
            left: 0;
            transform: translateY(-50%);
            color: #fff;
            font-size: 16px;
            pointer-events: none;
            transition: 0.15s ease;
        }

        .input-field input {
            width: 100%;
            height: 40px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #fff;
        }

        .input-field input:focus~label,
        .input-field input:valid~label {
            font-size: 0.8rem;
            /* top: 10px; */
            transform: translateY(-120%);
        }

        .forget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 25px 0 35px 0;
            color: #fff;
        }

        #remember {
            accent-color: #fff;
        }

        .forget label {
            display: flex;
            align-items: center;
        }

        .forget label p {
            margin-left: 8px;
        }

        .wrapper a {
            color: #efefef;
            text-decoration: none;
        }

        .wrapper a:hover {
            text-decoration: underline;
        }

        button {
            background: #fff;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
            border: 2px solid transparent;
            transition: 0.3s ease;
        }

        button:hover {
            color: #fff;
            border-color: #fff;
            background: rgba(255, 255, 255, 0.15);
        }

        .register {
            text-align: center;
            margin-top: 30px;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form action="" method="POST">
            <h2>LOGIN</h2>
            <div class="input-field">
                <input type="text" name="email" required>
                <label>email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>password</label>
            </div>
            <button type="submit" name="submit">🤗LOG-IN🤗</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            class Database
            {
                private $host = "localhost";
                private $username = "root";
                private $password = "";
                private $dbname = "oops";
                private $conn;

                public function __construct()
                {
                    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
                    if ($this->conn->connect_error) {
                        die("Connection failed: " . $this->conn->connect_error);
                    }
                }

                public function fetchUser($email, $password)
                {
                    $fetch = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
                    $fetch->bind_param("ss", $email, $password);
                    $fetch->execute();
                    $result = $fetch->get_result();
                    return $result->fetch_assoc();
                }
            }

            $db = new Database();
            $user = $db->fetchUser($email, $password);

            if ($user) {
                echo "<p style='color: green;'>Login successful. Welcome.</p>";
                // header("Location: dashboard.php");
            } else {
                echo "<p style='color: red;'>Invalid email or password.</p>";
            }
        }
        ?>
    </div>



</body>

</html>