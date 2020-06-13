<?php
    $host = "www.math-cs.ucmo.edu";
    $username = "cs4130_sp2020";
    $password = "tempPWD!";
    $db_name = "cs4130_sp2020";
    
    $dbc = mysqli_connect($host, $username, $password, $db_name) OR die('Could not connect. Sorry! D:');
    mysqli_set_charset($dbc, 'utf8');

    $countQuery = "SELECT COUNT(*) FROM CEC_GSD_Sushi;";
    if (!mysqli_error($dbc))
    {
        $count = mysqli_query($dbc, $countQuery);
        $row = mysqli_fetch_array($count, MYSQLI_BOTH);
        $numberOfSushiOptions = $row[0];
    }
    else
    {
        echo mysqli_error($dbc); // Returns and error if the query was bad
    }

    $displayConfirmation = false;
    $displayError = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $customerName = $dbc->real_escape_string($_POST["customerName"]);
        $street = $dbc->real_escape_string($_POST["street"]);
        $city = $dbc->real_escape_string($_POST["city"]);
        $state = $_POST["state"];
        $zip = $_POST["zip"];
        $ordernotes = $dbc->real_escape_string($_POST["ordernotes"]);

        if (!(empty($customerName)) && !(empty($street)) && !(empty($city)) && !(empty($state)) && !(empty($zip)))
        {
            // Find other info
            $date = new DateTime("now", new DateTimeZone('America/Chicago'));
            $sushi = array();
            $totalcost = 0.00;
            for ($i = 1; $i <= $numberOfSushiOptions; $i++)
            {
                $numberWanted = (int)($_POST["number" . $i]);
                if (!(empty($numberWanted)) && $numberWanted > 0)
                {
                    $priceQuery = "SELECT Price FROM CEC_GSD_Sushi WHERE Sushi_ID = " . $i . ";";
                    if (!mysqli_error($dbc))
                    {
                        $price = mysqli_query($dbc, $priceQuery);
                        $row = mysqli_fetch_array($price, MYSQLI_BOTH);
                        $sushiPrice = $row[0];
                    }
                    else
                    {
                        echo mysqli_error($dbc); // Returns and error if the query was bad
                        $displayError = true;
                    }

                    $totalcost += $sushiPrice * $numberWanted;
                }
            }

            // Write the order
            if (!(empty($ordernotes)))
            {
                $orderQuery = "INSERT INTO CEC_GSD_Orders
                           (Customer_Name, Total_Price, Street, City, State, Zip, Order_Note, Time_Ordered)
                           VALUES
                           ('" . $customerName . "', " . $totalcost . ", '" . $street . "', '" . $city . "', '" . $state . "', " . $zip . ", '" . $ordernotes . "', '" . $date->format('Y-m-d H:i:s') . "' );";
            }
            else
            {
                $orderQuery = "INSERT INTO CEC_GSD_Orders
                           (Customer_Name, Total_Price, Street, City, State, Zip, Time_Ordered)
                           VALUES
                           ('" . $customerName . "', " . $totalcost . ", '" . $street . "', '" . $city . "', '" . $state . "', " . $zip . ", '" . $date->format('Y-m-d H:i:s') . "' );";
            }

            // Submit the order
            if (!mysqli_error($dbc))
            {
                mysqli_query($dbc, $orderQuery);
            }
            else
            {
                echo mysqli_error($dbc); // Returns and error if the query was bad
                $displayError = true;
            }
            
            // Write the sushi's associated with the order
            $idQuery = "SELECT Order_ID FROM CEC_GSD_Orders WHERE Customer_Name = '" . $customerName . "' AND Time_Ordered = '" . $date->format('Y-m-d H:i:s') . "';";
            if (!mysqli_error($dbc))
            {
                $id = mysqli_query($dbc, $idQuery);
                $row = mysqli_fetch_array($id, MYSQLI_BOTH);
                $orderID = $row[0];
            }
            else
            {
                echo mysqli_error($dbc); // Returns and error if the query was bad
                $displayError = true;
            }

            for ($i = 1; $i <= $numberOfSushiOptions; $i++)
            {
                $numberWanted = (int)($_POST["number" . $i]);
                if (!(empty($numberWanted)) && $numberWanted > 0)
                {
                    $sushiQuery = "INSERT INTO CEC_GSD_SushiOrdered
                                   (Order_ID, Sushi_ID, Number_Of_Sushi)
                                   VALUES
                                   (" . $orderID . "," . $i . "," . $numberWanted . ");";
                    // Submit the sushis associated with the order
                    if (!mysqli_error($dbc))
                    {
                        mysqli_query($dbc, $sushiQuery);
                        $displayConfirmation = true;
                    }
                    else
                    {
                        echo mysqli_error($dbc); // Returns and error if the query was bad
                        $displayError = true;
                    }
                }
            }
        }
        else
        {
            // Something isn't right here!
            $displayError = true;
        }
    }
?>

<html>
    <head>
        <title> Assignment 3</title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "style.css">
        <script type = "text/javascript" src = "script.js"></script>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
    <form action = "index.php" method = "post">
        <div class = "backwall"> 
            <!-- Page content begins here -->
                <div id = "popupForm" class = "popup">
                    <!-- Popup content begins here -->
                    <div class = "content">
                        <div class = "orderspacing">
                            <div id = "orderinfo" class = "orderdisplay">
                                <p class = "orderheader">Your Order:</p>
                                <p id = "sushiordered" class = "sushilist"></p>
                                <hr>
                                <p class = "ordertotal">Total price: <span name = "total" id = "orderCost">$0.00<span></p>
                            </div>
                        </div>
                        <hr class = "vertical">
                        <div class = "orderspacing">
                            <div class = "orderform">
                                <p>Customer Name: <input name = "customerName" type = "text" required></input> </p>
                                <h2> Delivery Address:</h2>
                                <p>Street: <input name = "street" type = "text" required></input> </p>
                                <p>City: <input name = "city" type = "text" required></input> </p>
                                <p>State: <input name = "state" id = "state" type = "text" size = 1 minlength = 2 maxlength = 2 required onchange = "CleanStateInput()" onkeydown = "CleanStateInput()" onpaste = "CleanStateInput()" oninput = "CleanStateInput()"></input> </p>
                                <p>Zip: <input name = "zip" id = "zip" type = "text" size = 5 minlength = 5 maxlength = 5 required onchange = "CleanZipInput()" onkeydown = "CleanZipInput()" onpaste = "CleanZipInput()" oninput = "CleanZipInput()"></input> </p>
                                <h2> Order Notes:</h2>
                                <textarea name = "ordernotes"></textarea>
                                <input type = "submit" value = "Place Order"></input>
                                <div class = "cancelbutton" onClick = "ClosePopup()">Cancel Order</div>
                            </div>
                        </div>
                    </div>
                    <!-- Popup content begins here -->
                </div>
            <div id = "popupWarning" class = "popup">
                <!-- Popup content begins here -->
                <div class = "content">
                    <h2 class = "text">
                        Please select something to order.
                        <div class = "closebutton" onClick = "CloseWarningPopup()">Back To Selection</div>
                    </h2>
                    
                </div>
                <!-- Popup content begins here -->
            </div>

            <div id = "popupError" class = "popup">
                <!-- Popup content begins here -->
                <div class = "content">
                    <h2 class = "text">
                        There was trouble submitting your request. Please try again.
                        <div class = "closebutton" onClick = "CloseErrorPopup()">Back To Selection</div>
                    </h2>
                    
                </div>
                <!-- Popup content begins here -->
            </div>

            <div id = "popupConfirmation" class = "popup">
                <!-- Popup content begins here -->
                <div class = "content">
                    <h2 class = "text">
                        Your order has been successfully processed.
                        <?php 
                            $timeQuery = "SELECT COUNT(*) FROM CEC_GSD_Orders WHERE Time_Delivered IS NULL;";
                            if (!mysqli_error($dbc))
                            {
                                $time = mysqli_query($dbc, $timeQuery);
                                $row = mysqli_fetch_array($time, MYSQLI_BOTH);
                                $numLeft = $row[0];

                                $minutes = 30 + 5 * ($numLeft - 1);
                                echo '<p class = "time">Your order will be ready in ' . $minutes . ' minutes.</p>';
                            }
                            else
                            {
                                echo mysqli_error($dbc); // Returns and error if the query was bad
                            }
                        ?>
                        <div class = "closebutton" onClick = "CloseConfirmationPopup()">Back To Selection</div>
                    </h2>
                    
                </div>
                <!-- Popup content begins here -->
            </div>

            <div class = "header">
                <img class = "logo" src = "assets/gunma_logo.png">
                <p class = "companyname">Gunma Sushi Delivery</p>
                <hr>
            </div>

            <div class = "middle">
                <?php

                // Get all available sushis
                $query = "SELECT * FROM CEC_GSD_Sushi;";
                if (!mysqli_error($dbc))
                {
                    $result = mysqli_query($dbc, $query);
                    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) // MYSQLI_BOTH is both MYSQLI_ASSOC and MYSQLI_
                    {
                        echo '<div class = "sushispace">';
                        echo '  <div class = "sushi">';
                        echo '      <p id = "name' . $row['Sushi_ID'] .  '" class = "name">' . $row['Name'] . '</p>';
                        echo '      <img class = "food" src = "assets/' . $row['Image_Name'] . '">';
                        echo '      <p class = "description">' . $row['Description'] . '</p>';
                        echo '      <p class = "order">$<span id = "price' . $row['Sushi_ID'] .  '">' . number_format($row['Price'], 2, '.', '') . '</span> x 
                                    <input id = "number' . $row['Sushi_ID'] .  '" type = "text" placeholder = "0" size = 1 maxlength = 3 onchange = "CalculateSushiPricing(' . $row['Sushi_ID'] .  ', ' . $row['Price'] . ')" 
                                                                                                                                         onkeydown = "CalculateSushiPricing(' . $row['Sushi_ID'] .  ', ' . $row['Price'] . ')" 
                                                                                                                                         onpaste = "CalculateSushiPricing(' . $row['Sushi_ID'] .  ', ' . $row['Price'] . ')" 
                                                                                                                                         oninput = "CalculateSushiPricing(' . $row['Sushi_ID'] .  ', ' . $row['Price'] . ')" name = "number' . $row['Sushi_ID'] .  '"> = 
                                    $<span id = "totalPrice' . $row['Sushi_ID'] .  '">0.00</span></p>';
                        echo '  </div>';
                        echo '</div>';
                    }

                    echo '<script>ResetValues(' . $numberOfSushiOptions . ');</script>';
                }
                else
                {
                    echo mysqli_error($dbc); // Returns and error if the query was bad
                }
                ?>
            </div>

            <div class = "footer">
                <hr>
                <p class = "footerinformation">
                    Please note that Gunma Sushi Delivery is not real.<br>
                    This was a project done by Courtney E. Cole as an assignment for her CS 4130 course. <br>
                    I know very little about common sushi prices, so please forgive me if they seem inaccurate.<br>
                    All images were found via Google Images. This site is strictly for educational practice.
                </p>
                <p class = "footerinformation">
                    <a href = "order_handler.php">Order Handler</a> + <a href = "shareholder.php">Shareholder's Page</a>
                </p>
            </div>

            <?php 
                echo '<div class = "submitbutton" onClick = "DisplayPopup(' . $numberOfSushiOptions . ')">Check & Submit Order</div>';
            ?>
            <!-- Page content ends here -->
        </div>
    </form>
    </body>
</html>

<?php
    if ($displayConfirmation == true)
    {
        echo "<script>DisplayConfirmationPopup();</script>";
        $displayConfirmation = false;
    }

    if($displayError == true)
    {
        echo "<script>DisplayErrorPopup();</script>";
        $displayError = false;
    }
?>