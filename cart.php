<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Cart: CEG Super Market</title>
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
            <div class="navele"  onclick="producter()"><li >Products Available</li></div>
            <div class="navele" style="background-color: #cccccc" onclick="buynow()"><li>BuyNow</li></div>
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
        <legend>View Cart:</legend>
        <div id="tab_wrap">
            <?php
            if(isset($_SESSION['user'])) {
            $conad = mysqli_connect("localhost", "id12912220_root", "helloworld", "id12912220_shop");
            if (!$conad) {
                echo "Connection Unsuccessful " . mysqli_error($conad);
            } else {
                $query = "SELECT items.itemid, name, qty,(price*qty) FROM items, cart WHERE items.itemid = cart.itemid AND user = \"" . $_SESSION['user']. "\" ORDER BY itemid;";


                if($result = mysqli_query($conad, $query)){
                    if(mysqli_num_rows($result)>0) {
                        $i = 0;
                        $output = "<table><tr style='background-color: #a5afbe'><td>S.No</td><td>Item Id</td><td>Item Name</td><td>Quantity</td><td>Price</td></tr>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            $output = $output . "<tr><td>" . $i . "</td><td>" . $row['itemid'] . "</td><td>" . $row['name'] . "</td><td>" . $row['qty'] . "</td><td>" . $row['(price*qty)'] . "</td></tr>";
                            if (isset($_POST['paid'])) {
                                date_default_timezone_set("Asia/Kolkata");
                                $filename = "receipts/" . $_SESSION['phone'] .".txt";
                                $writefile = fopen($filename, "a");
                                $txt = "$i    ". "Purchase on ". date("d-m-Y") . " - " . date("h:i:sa") . "\n";
                                $txt = $txt . $row['itemid']  ."    ". $row['name'] ."     " . $row['qty'] . "     " . $row['(price*qty)'] ." \n";
                                fwrite($writefile, $txt);
                                $update = "UPDATE items SET stock = stock - " . $row['qty'] . " WHERE itemid = \"" . $row['itemid'] . "\";";
                                $delete = "DELETE FROM cart WHERE itemid = \"" . $row['itemid'] . "\" ;";
                                $insert = "INSERT INTO accounts (itemid, qty, price, user) VALUES (\"" . $row['itemid'] . "\", " . $row['qty'].", " . $row['(price*qty)'].", '" . $_SESSION['user']."')";
                                if (mysqli_query($conad, $update) && mysqli_query($conad, $delete) && mysqli_query($conad, $insert)) {
                                    echo "Paid succesful <br>";
                                    echo "<script>
                                    setTimeout(function(){
                                      window.location.href = 'cart.php';
                                    }, 1500);
                                  </script>";

                                } else {
                                    echo "Wrong qrey $update or<br> $delete or<br> $insert" . mysqli_error($conad);
                                }
                            }
                        }
                        $output = $output . "</table>";
                        echo $output;
                        ?>
                        <form action="cart.php" method="post">
                            <table>
                                <td><input type="submit" class="submit" name="paid" value="Pay Now"></td>
                            </table>
                        </form>
                        <?php
                    } else {
                        echo "<p>No items in the cart</p>";
                        $file = 'receipts/'. $_SESSION['phone']. '.txt';
                        if(file_exists($file)){
                            echo "Click <a href=" . $file . " target='_blank'>here</a> to see your previous transaction.";
                        } else {
                            echo "You have not shopped, click <a href='buynow.php'>here</a> to buy new stuff";
                        }
                    }

                } else {
                    echo "NOT Displyaed" . mysqli_error($conad);
                }
                mysqli_close($conad);
            }
            ?>
        </div>

        <?php
        } else{
            echo "You Must Log In to continue. <a href='login.php'>Click Here</a>";
        }
        ?>
    </fieldset>
</div>
</body>
</html>
