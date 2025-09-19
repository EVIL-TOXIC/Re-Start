<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN-UP</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, rgb(33, 64, 72), black);
        }

        .wrapper {
            position: relative;
            max-width: 430px;
            width: 100%;
            background: #fff;
            padding: 34px;
            border-radius: 6px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .wrapper h2 {
            position: relative;
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        .wrapper h2::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 28px;
            border-radius: 12px;
            background: linear-gradient(to right, rgb(12, 55, 66), yellow);
        }

        .wrapper form {
            margin-top: 30px;
        }

        .wrapper form .input-box {
            height: 52px;
            margin: 18px 0;
        }

        form .input-box input {
            height: 100%;
            width: 100%;
            outline: none;
            padding: 0 15px;
            font-size: 17px;
            font-weight: 400;
            color: #333;
            border: 1.5px solid #C7BEBE;
            border-bottom-width: 2.5px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .input-box input:focus,
        .input-box input:valid {
            border-color: rgb(27, 35, 55);
        }

        form .policy {
            display: flex;
            align-items: center;
        }

        form h3 {
            color: #707070;
            font-size: 14px;
            font-weight: 500;
            margin-left: 10px;
        }

        .input-box.button input {
            color: #fff;
            letter-spacing: 1px;
            border: none;
            background: rgb(16, 26, 54);
            cursor: pointer;
        }

        .input-box.button input:hover {
            background: #0e4bf1;
        }

        form .text h3 {
            color: #333;
            width: 100%;
            text-align: center;
        }

        form .text h3 a {
            color: #4070f4;
            text-decoration: none;
        }

        form .text h3 a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
    class Database
    {
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        public $dbname = "oops";
        public $conn;

        public function getConnection()
        {
            $this->conn = null;
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            } catch (PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }

    class User
    {
        private $conn;
        private $tableName = "users";

        public $name;
        public $email;
        public $password;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function create()
        {
            $query = "INSERT INTO " . $this->tableName . " (name, email, password) VALUES (:name, :email, :password)";
            $fetch = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);

            $fetch->bindParam(":name", $this->name);
            $fetch->bindParam(":email", $this->email);
            $fetch->bindParam(":password", $this->password);

            if ($fetch->execute()) {
                return true;
            }
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];

        if ($user->create()) {
            echo "<script>alert('User registered successfully!');</script>";
            // header("Location: dashboard.php");
        } else {
            echo "<script>alert('Unable to register user.');</script>";
        }
    }
    ?>


    <div class="wrapper">
        <h2>SIGN-UP</h2>
        <form action="" method="POST">
            <div class="input-box">
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Create password" required>
            </div>
            <div class="input-box button">
                <input type="submit" value="Register Now">
            </div>
        </form>
    </div>
</body>

</html>