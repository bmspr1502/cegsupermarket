<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Now: CEG Super Market</title>
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
        <legend>Buy Now:</legend>

        <?php
        if(isset($_SESSION['user'])) {
            if(isset($_POST['submit'])){
                $id = $_POST['radio'];
                $qty = $_POST[$id];

                $conn= mysqli_connect("localhost", "id12912220_root", "helloworld", "id12912220_shop");
                if(!$conn) {
                    echo "Connection Unsuccessful";
                } else{
                    $query = "INSERT INTO cart (itemid, qty, user) VALUES ('$id', $qty, '" . $_SESSION['user']. "');";
                    if(mysqli_query($conn, $query)){
                        echo "Added to Cart";
                        echo "<script>
                                    setTimeout(function(){
                                      window.location.href = 'buynow.php';
                                    }, 1500);
                                  </script>";
                    }
                    else {
                        echo "Value Not Added<br> $query <br>" . mysqli_error($conn);
                    }
                }
            }

            $conad = mysqli_connect("localhost", "id12912220_root", "helloworld", "id12912220_shop");
            if (!$conad) {
                echo "Connection Unsuccessful " . mysqli_error($conad);
            } else {
                $query = "SELECT * FROM items ORDER BY itemid;";
                if ($result = mysqli_query($conad, $query)) {
                    if (mysqli_num_rows($result) >= 0) {
                        $i = 0;
                        ?>
                        <div id="tab_wrap">
                            <p>
                                Select one item that you want to buy, and then enter the quantity in the box,and click add to cart for each item, one at a time.
                            </p>
                            <form action="buynow.php" method="post">
                                <?php
                                $output = "<table><tr style='background-color: #a5afbe'><td>Select:</td><td>Item Id</td><td>Item Name</td><td>Price(for KG)</td><td>Type</td><td>Stock(in KG)</td><td>Qty(in Kg)</td></tr>";
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $i++;
                                    $output = $output . "<tr><td><input type='radio' name='radio' required value=" . $row['itemid']."></td><td>" . $row["itemid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["price"] . "</td><td>" . $row['type'] . "</td><td>" . $row["stock"] . "</td><td><input type='text' name='" . $row['itemid'] ."'></td></tr>";
                                }
                                $output = $output . "</table>";
                                echo $output;

                                ?>
                                <table>
                                    <td><input type="submit" name="submit" class="submit" value="Add to Cart"></td>
                                    <td><input type="button" class="submit" value="View Cart" onclick="window.location.href='cart.php'"></td>
                                </table>
                            </form>
                        </div>
                        <?php
                    } else {
                        echo "NO VALUES FOUND:";
                    }
                }
                mysqli_close($conad);

            }


        } else{
            echo "You Must Log In to continue. <a href='login.php'>Click Here</a>";
        }
        ?>
    </fieldset>
</div>
</body>
</html>
