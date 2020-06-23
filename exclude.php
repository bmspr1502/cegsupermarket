<?php
if(isset($_POST['signup'])){
    $str = "New Customer";
} elseif (isset($_POST['login'])){
    $str = "Existing Customer";
} elseif (isset($_POST['createuser'])){
    $str = "Creating User";
}
else {
    $str = "Login";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $str;?>:CEG Super Market</title>
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
            <div class="navele" ><li >Home</li></div>
            <div class="navele" ><li >Products</li></div>
            <div class="navele" style="background-color: #cccccc"><li >Buy Now</li></div>
        </ul>
    </div>
    <fieldset id="mainform">
        <legend><?php echo $str;?></legend>
        <?php
        if($str == "Login") {
            ?>
            <form action="cart.php" method="post">
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
            <?php
        }
        elseif ($str == "New Customer") {
            ?>
            <form action="cart.php" method="post">
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
        } elseif ($str=="Creating User") {
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

                $query = "INSERT INTO customer (name,phone,password)
			VALUES ('$name', $phone, '$pass';";

                if (mysqli_query($con, $query)) {
                    echo "<br>Values entered.";
                    echo "<script>
                                    setTimeout(function(){
                                      window.location.href = 'cart.php';
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
                                      window.location.href = 'cart.php';
                                    }, 1500);
                                  </script>";
            }
        }
        elseif ($str == "Existing Customer") {
            if(($_POST['phone'] == 1111111111)&&(($_POST['password'])=='admin')){
                echo "<script>
                              window.location.href = 'admin/index.php';
                      </script>";
            }
            $conad = mysqli_connect("localhost", "id12912220_root", "helloworld", "id12912220_shop");
            if (!$conad) {
                echo "Connection Unsuccessful " . mysqli_error($conad);
            } else {
                $query = "SELECT * FROM items ORDER BY itemid;";
                if ($result = mysqli_query($conad, $query)) {
                    if (mysqli_num_rows($result) >= 0) {
                        $i = 0;
                        $output = "<table><tr style='background-color: #a5afbe'><td>S.No</td><td>Item Id</td><td>Item Name</td><td>Price(for KG)</td><td>Type</td><td>Stock(in KG)</td></tr>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            $output = $output . "<tr><td>$i</td><td>" . $row["itemid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["price"] . "</td><td>" . $row['type'] . "</td><td>" . $row["stock"] . "</td></tr>";
                        }
                        $output = $output . "</table>";
                        echo $output;
                    } else {
                        echo "NO VALUES FOUND:";
                    }
                }
                mysqli_close($conad);

            }
        }
        ?>
    </fieldset>
</div>
<script>
    function loginer() {
        window.location.href = 'cart.php';
    }
    function checkPassMatch() {
        var pass = document.getElementById("newpass").value;
        var conf = document.getElementById("confpass").value;

        if(pass != conf){
            document.getElementById("checkpass").innerHTML = "Passwords do not match";
        } else {
            document.getElementById("checkpass").innerHTML = "";
        }
    }
</script>
</body>
</html>