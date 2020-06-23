<?php
session_start();
if(isset($_POST['signup'])){
    echo "<script>window.location.href='newcust.php';</script>";
}
if(isset($_POST['login']) ){
    $str = "View Profile";
    echo "<script>window.location.href='login.php';</script>";
}
elseif(isset($_SESSION['user'])){
    $str = $_SESSION['user'];
}
else {
    $str = "Login";
}

if(isset($_POST['logout'])){
    session_destroy();
    $str = "Logout";
    echo "<script>window.location.href='login.php';</script>";
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="script.js"></script>
    <meta charset="UTF-8">
    <title><?php echo $str;?>: CEG Super Market</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
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
            <div class="navele" style="background-color: #cccccc" onclick="loginer()" ><li >
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
        <legend><?php echo $str;?>:</legend>
        <?php
        if($str == "Login") {
        ?>
        <div id="tab_wrap">
            <table>
                <form action="login.php" method="post">
                    <table>
                        <tr>
                            <td>Customer Phone no.:</td>
                            <td><input type="text" id="phone" name="phone"></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password"></td>
                        </tr>
                        <tr>
                            <td><input type="submit" class="submit" name="login" value="Login"></td>
                            <td><input type="submit" class="submit" name="signup" value="New Customer"></td>
                        </tr>
                    </table>
                </form>
            </table>

            <?php
            } else
            {
                if ($str=="View Profile") {
                    $phone = $_POST['phone'];
                    $pass = $_POST['password'];
                } elseif(isset($_SESSION['user'])){
                    $phone = $_SESSION['phone'];
                    $pass= $_SESSION['pass'];
                }

                if($phone==1111 && $pass=='administrator'){
                    echo "<script>window.location.href='admin/index.php';</script>";
                }
                $con = mysqli_connect("localhost", "id12912220_root", "helloworld", "id12912220_shop");
                if(!$con) {
                    echo "connection not done " . mysqli_error($con);
                } else {
                    $found = false;
                    $query = "SELECT * FROM customer";
                    if ($result = mysqli_query($con, $query)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($phone == $row["phone"]) {
                                $found = true;
                                if ($pass == $row["password"]) {
                                    $_SESSION['user'] = $row["name"];
                                    $_SESSION['phone'] = $row["phone"];
                                    $_SESSION['pass'] = $row["password"];
                                    ?>
                                    <form action="login.php" method="post">
                                        <table>
                                            <tr>
                                                <td>Name:</td>
                                                <td><?php echo $_SESSION['user'] ; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Phone:</td>
                                                <td><?php echo $row["phone"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Total Shopping:</td>
                                                <td><?php
                                                    $file = 'receipts/'. $_SESSION['phone']. '.txt';
                                                    if(file_exists($file)){
                                                        echo "Click <a href=" . $file . " target='_blank'>here</a>";
                                                    } else {
                                                        echo "You have not shopped, click <a href='buynow.php'>here</a> to buy new stuff";
                                                    }?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><input type="submit" class="submit" name="logout" value="Logout"></td>
                                            </tr>
                                        </table>
                                    </form>
                                    <?php

                                } else {
                                    echo "Password incorrect, redirecting...";
                                    echo "<script>
                                    setTimeout(function(){
                                      window.location.href = 'login.php';
                                    }, 1500);
                                  </script>";
                                }
                            }
                        }
                        if($found == false) {
                            echo "Phone incorrect, redirecting...";
                            echo "<script>
                                    setTimeout(function(){
                                      window.location.href = 'login.php';
                                    }, 1500);
                                  </script>";
                        }

                    } else {
                        die("Error obtaining result ". mysqli_error($con));
                    }
                }
            }
            ?>
        </div>
    </fieldset>
</div>
</body>
</html>
