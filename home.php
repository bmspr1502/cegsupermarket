<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CEG Super Market</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <script src="script.js"></script>
    <style>
        #mainform{
            left:5%;
            height: auto;
            width:90%;
        }
        #content{
            text-align: center;
            display: block;
        }

        section > img{
            height: 10vh;
            width: 15vh;
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
                <div class="navele" style="background-color: #cccccc" onclick="homer()"><li >Home</li></div>
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
            <legend>Home:</legend>

            <section id="content">
                <img src="leaves.JPG" >
                <h3>Welcome to CEG Super Market</h3>
                <p style="font-style: italic">Your one stop destination for all Fruits, Fresh Juices and Miscellaneous items </p>
                <p style="font-weight: bold;">To buy new item, goto the buy now page</p>
                <br><p><b>Contact:</b></p>
                <p><b>Gurunath: <span style="font-style: italic">+919234151241</span></b></p>
                <p><address>M/s. Gurunath, CEG Campus,<br>Sardar Patel Road, Guindy, <br> Chennai - 600 025. </address></p>
            </section>
        </fieldset>
    </div>
</body>
</html>