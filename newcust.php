<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Customer: CEG Super Market</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <script src="script.js"></script>
    <style>
        #mainform{
            left:5%;
            height: auto;
            width:90%;
        }
    </style>
</head>
<body>
<div id="main">
    <div id="header">
        <h1>CEG Super Market</h1>
    </div>
    <div id = "nav">
        <ul>
            <div class="navele"  onclick="homer()"><li >Home</li></div>
            <div class="navele" onclick="producter()"><li >Products Available</li></div>
            <div class="navele"  onclick="buynow()"><li>BuyNow</li></div>
            <div class="navele" onclick="loginer()" ><li >
                  <?php
                    if(isset($_SESSION['user']))
                        echo "Account";
                    else
                        echo "Login";
                    ?></li></div>
        </ul>
        <?php
        if(isset($_SESSION['user'])){
            ?>
            <p style="text-align: right">Welcome: <?php echo $_SESSION['user']?></p>
            <?php
        }
        ?>
    </div>
    <fieldset id="mainform">
        <legend>New Customer</legend>
        <div id="tab_wrap">
        <form action="newcust.php" method="post">
            <table>
                <table>
                    <tr>
                        <td>Enter ur Phone no.:</td>
                        <td><input type="text" id="phone" name="phone" required></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="name" required></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" id="newpass" name="password" onkeyup="checkPassMatch()" required></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input type="password" id="confpass" name="confirm" onkeyup="checkPassMatch()" required><p id="checkpass"></p></td>

                    </tr>
                    <tr>
                        <td><input type="submit" class="submit" name="createuser" value="Create Customer"></td>
                        <td><input type="button" class="submit" name="existinguser" onclick="loginer()" value="Login"></td>
                    </tr>
                </table>
        </form>
        <?php
        if(isset($_POST['createuser'])){

            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $pass = $_POST['password'];
            $conf = $_POST['confirm'];

            if ($pass == $conf) {
                $con = mysqli_connect("localhost", "id12912220_root", "helloworld", "id12912220_shop");
                if (!$con) {
                    echo "connection not done " . mysqli_error($con);
                } else {
                    echo "connection successful ";
                }

                $query = "INSERT INTO customer (name,phone,password,shopping)
			VALUES ('$name', $phone, '$pass',0);";

                if (mysqli_query($con, $query)) {
                    echo "<br>Values entered.";
                    echo "<script>
                                    setTimeout(function(){
                                      window.location.href = 'login.php';
                                    }, 1500);
                                  </script>";
                } else {
                    echo "<br>Unsuccessful " . mysqli_error($con);
                }

                mysqli_close($con);
            } else {
                echo "Password is not same";
                echo "<script>
                                    setTimeout(function(){
                                      window.location.href = 'newcust.php';
                                    }, 1500);
                                  </script>";
            }
        }
        ?>
        </div>
    </fieldset>
</div>
</body>
</html>
