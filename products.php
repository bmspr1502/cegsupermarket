<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products Available: CEG Super Market</title>
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

            <div class="navele" style="background-color: #cccccc" onclick="producter()"><li >Products Available</li></div>
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
        <legend>Products:</legend>
        <?php
        $conad = mysqli_connect("localhost", "id12912220_root", "helloworld", "id12912220_shop");
        if(!$conad){
            echo "Connection Unsuccessful " . mysqli_error($conad);
        } else {
            $query = "SELECT * FROM items ORDER BY itemid;";
            if($result = mysqli_query($conad, $query)){
                if(mysqli_num_rows($result) >= 0) {
                    $i=0;
                    $output = "<table><tr style='background-color: #a5afbe'><td>S.No</td><td>Item Id</td><td>Item Name</td><td>Price(for KG)</td><td>Type</td><td>Stock(in KG)</td></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        $output = $output . "<tr><td>$i</td><td>" . $row["itemid"]."</td><td>". $row["name"]."</td><td>". $row["price"]."</td><td>" . $row['type']."</td><td>". $row["stock"]."</td></tr>";
                    }
                    $output = $output . "</table>";
                    echo $output;
                } else {
                    echo "NO VALUES FOUND:";
                }
            }
            mysqli_close($conad);

        }
        ?>
    </fieldset>
</div>
</body>
</html>
