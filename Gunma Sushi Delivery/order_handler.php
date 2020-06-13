<?php
    $host = "www.math-cs.ucmo.edu";
    $username = "cs4130_sp2020";
    $password = "tempPWD!";
    $db_name = "cs4130_sp2020";
    
    $dbc = mysqli_connect($host, $username, $password, $db_name) OR die('Could not connect. Sorry! D:');
    mysqli_set_charset($dbc, 'utf8');

    $displayError = false;
    $needsRefresh = false;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $orderID = $_POST["orderID"];

        if (!(empty($orderID)))
        {
            // Check the condition of the order
            $checkQuery = "SELECT Time_Ready FROM CEC_GSD_Orders WHERE Order_ID = " . $orderID . ";";
            if (!mysqli_error($dbc))
            {
                $check = mysqli_query($dbc, $checkQuery);
                $row = mysqli_fetch_array($check, MYSQLI_BOTH);
                $readyStatus = $row[0];

                if ($readyStatus == NULL)
                {
                    // Mark it as ready
                    $date = new DateTime("now", new DateTimeZone('America/Chicago'));
                    $updateQuery = "UPDATE CEC_GSD_Orders SET Time_Ready = '" . $date->format('Y-m-d H:i:s') . "' WHERE Order_ID = " . $orderID . ";";
                    if (!mysqli_error($dbc))
                    {
                        mysqli_query($dbc, $updateQuery);
                    }
                    else
                    {
                        echo mysqli_error($dbc); // Returns and error if the query was bad
                    }

                    $needsRefresh = true;
                }
                else
                {
                    // Mark it as delivered
                    $date = new DateTime("now", new DateTimeZone('America/Chicago'));
                    $updateQuery = "UPDATE CEC_GSD_Orders SET Time_Delivered = '" . $date->format('Y-m-d H:i:s') . "' WHERE Order_ID = " . $orderID . ";";
                    if (!mysqli_error($dbc))
                    {
                        mysqli_query($dbc, $updateQuery);
                    }
                    else
                    {
                        echo mysqli_error($dbc); // Returns and error if the query was bad
                    }

                    $needsRefresh = false;
                }
            }
            else
            {
                echo mysqli_error($dbc); // Returns and error if the query was bad
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
        <title> Assignment 3 - Order Handler</title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "style.css">
        <script type = "text/javascript" src = "script.js"></script>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <div id = "popupError" class = "popup">
            <!-- Popup content begins here -->
            <div class = "content">
                <h2 class = "text">
                    Oops! Something went wrong. Please try again!
                    <div class = "closebutton" onClick = "CloseErrorPopup()">Back</div>
                </h2>
                
            </div>
            <!-- Popup content begins here -->
        </div>
        
        <div class = "nav">
            <p class = "navinformation">
                Please note that Gunma Sushi Delivery is not real.<br>
                This was a project done by Courtney E. Cole as an assignment for her CS 4130 course. <br>
                I know very little about common sushi prices, so please forgive me if they seem inaccurate.<br>
                All images were found via Google Images. This site is strictly for educational practice.
            </p>
            <p class = "navinformation">
                <a href = "index.php">Home</a> + <a href = "shareholder.php">Shareholder's Page</a>
            </p>
            <hr>
        </div>
        
        <div class = "orderHolder">
            <h2 class = "header"> Cooked/Ready Orders: </h2>
            <div class = "readyOrders">
                <?php
                    // Ready Orders
                    $query = "SELECT * FROM CEC_GSD_Orders WHERE Time_Ready IS NOT NULL AND Time_Delivered IS NULL ORDER BY Time_Ready ASC;";
                    if (!mysqli_error($dbc))
                    {
                        $result = mysqli_query($dbc, $query);
                        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) // MYSQLI_BOTH is both MYSQLI_ASSOC and MYSQLI_
                        {
                            echo '<div class = "orderSpace">';
                            echo '<form action = "order_handler.php" method = "post">';
                            echo '  <div class = "order">';
                            echo '      <h2>Order #' . $row["Order_ID"] . '</h2>';
                            echo '      <p><b>Customer:</b> ' . $row["Customer_Name"] . '</p>';
                            echo '      <p><b>Address:</b><br>' . $row["Street"] . '<br>' . $row["City"] . ', ' . $row["State"] . ' ' . $row["Zip"] . '<br></p>';
                            echo '      <p><b>Total Price:</b> $' . $row["Total_Price"] . '</p>';
                            $sushiQuery = "SELECT Number_Of_Sushi, Name FROM CEC_GSD_SushiOrdered NATURAL JOIN CEC_GSD_Sushi WHERE Order_ID = " . $row["Order_ID"];
                            if (!mysqli_error($dbc))
                            {
                                $sushi = mysqli_query($dbc, $sushiQuery);
                                echo '<p><b>Sushi Requested:</b><br>';
                                while ($info = mysqli_fetch_array($sushi, MYSQLI_BOTH)) // MYSQLI_BOTH is both MYSQLI_ASSOC and MYSQLI_
                                {
                                    if ($info["Number_Of_Sushi"] > 1)
                                    {
                                        echo $info["Number_Of_Sushi"] . " " . $info["Name"] . "s<br>";
                                    }
                                    else
                                    {
                                        echo $info["Number_Of_Sushi"] . " " . $info["Name"] . "<br>";
                                    }
                                }
                                echo '</p>';
                            }
                            else
                            {
                                echo mysqli_error($dbc); // Returns and error if the query was bad
                            }
                            if ($row["Order_Note"] != NULL)
                            {
                                echo '      <p><b>Order Note:</b><br>' . $row["Order_Note"] . '</p>';
                            }
                            echo '      <p class = time><b>Time Ordered:</b> ' . $row["Time_Ordered"] . '</p>';
                            echo '      <p class = time><b>Time Prepared:</b> ' . $row["Time_Ready"] . '</p>';

                            echo '      <input type = "hidden" name = "orderID" value = "' . $row["Order_ID"] . '"></input>';
                            echo '      <input type = "submit" value = "Mark As Delivered"></input>';
                            echo '  </div>';
                            echo '</form>';
                            echo '</div>';
                        }
                    }
                    else
                    {
                        echo mysqli_error($dbc); // Returns and error if the query was bad
                    }
                ?>
            </div>

            <h2 class = "header"> Unprepared Orders: </h2>
            <div class = "unpreppedOrders">
                <?php
                    // Unprepared Orders
                    $query = "SELECT * FROM CEC_GSD_Orders WHERE Time_Ready IS NULL AND Time_Delivered IS NULL ORDER BY Time_Ordered ASC;";
                    if (!mysqli_error($dbc))
                    {
                        $result = mysqli_query($dbc, $query);
                        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) // MYSQLI_BOTH is both MYSQLI_ASSOC and MYSQLI_
                        {
                            echo '<div class = "orderSpace">';
                            echo '<form action = "order_handler.php" method = "post">';
                            echo '  <div class = "order">';
                            echo '      <h2>Order #' . $row["Order_ID"] . '</h2>';
                            echo '      <p><b>Customer:</b> ' . $row["Customer_Name"] . '</p>';
                            echo '      <p><b>Address:</b><br>' . $row["Street"] . '<br>' . $row["City"] . ', ' . $row["State"] . ' ' . $row["Zip"] . '<br></p>';
                            echo '      <p><b>Total Price:</b> $' . $row["Total_Price"] . '</p>';
                            $sushiQuery = "SELECT Number_Of_Sushi, Name FROM CEC_GSD_SushiOrdered NATURAL JOIN CEC_GSD_Sushi WHERE Order_ID = " . $row["Order_ID"];
                            if (!mysqli_error($dbc))
                            {
                                $sushi = mysqli_query($dbc, $sushiQuery);
                                echo '<p><b>Sushi Requested:</b><br>';
                                while ($info = mysqli_fetch_array($sushi, MYSQLI_BOTH)) // MYSQLI_BOTH is both MYSQLI_ASSOC and MYSQLI_
                                {
                                    if ($info["Number_Of_Sushi"] > 1)
                                    {
                                        echo $info["Number_Of_Sushi"] . " " . $info["Name"] . "s<br>";
                                    }
                                    else
                                    {
                                        echo $info["Number_Of_Sushi"] . " " . $info["Name"] . "<br>";
                                    }
                                }
                                echo '</p>';
                            }
                            else
                            {
                                echo mysqli_error($dbc); // Returns and error if the query was bad
                            }
                            if ($row["Order_Note"] != NULL)
                            {
                                echo '      <p><b>Order Note:</b><br>' . $row["Order_Note"] . '</p>';
                            }
                            echo '      <p class = time><b>Time Ordered:</b> ' . $row["Time_Ordered"] . '</p>';

                            echo '      <input type = "hidden" name = "orderID" value = "' . $row["Order_ID"] . '"></input>';
                            echo '      <input type = "submit" value = "Mark As Ready"></input>';
                            echo '  </div>';
                            echo '</form>';
                            echo '</div>';
                        }
                    }
                    else
                    {
                        echo mysqli_error($dbc); // Returns and error if the query was bad
                    }
                ?>
            </div>
            
            <h2 class = "header"> Delivered/Finished Orders: </h2>
            <div class = "finishedOrders">
                <?php
                    // Finished Orders
                    $query = "SELECT * FROM CEC_GSD_Orders WHERE Time_Delivered IS NOT NULL ORDER BY Time_Delivered DESC;";
                    if (!mysqli_error($dbc))
                    {
                        $result = mysqli_query($dbc, $query);
                        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) // MYSQLI_BOTH is both MYSQLI_ASSOC and MYSQLI_
                        {
                            echo '<div class = "orderSpace">';
                            echo '<form action = "order_handler.php" method = "post">';
                            echo '  <div class = "order">';
                            echo '      <h2>Order #' . $row["Order_ID"] . '</h2>';
                            echo '      <p><b>Customer:</b> ' . $row["Customer_Name"] . '</p>';
                            echo '      <p><b>Address:</b><br>' . $row["Street"] . '<br>' . $row["City"] . ', ' . $row["State"] . ' ' . $row["Zip"] . '<br></p>';
                            echo '      <p><b>Total Price:</b> $' . $row["Total_Price"] . '</p>';
                            $sushiQuery = "SELECT Number_Of_Sushi, Name FROM CEC_GSD_SushiOrdered NATURAL JOIN CEC_GSD_Sushi WHERE Order_ID = " . $row["Order_ID"];
                            if (!mysqli_error($dbc))
                            {
                                $sushi = mysqli_query($dbc, $sushiQuery);
                                echo '<p><b>Sushi Requested:</b><br>';
                                while ($info = mysqli_fetch_array($sushi, MYSQLI_BOTH)) // MYSQLI_BOTH is both MYSQLI_ASSOC and MYSQLI_
                                {
                                    if ($info["Number_Of_Sushi"] > 1)
                                    {
                                        echo $info["Number_Of_Sushi"] . " " . $info["Name"] . "s<br>";
                                    }
                                    else
                                    {
                                        echo $info["Number_Of_Sushi"] . " " . $info["Name"] . "<br>";
                                    }
                                }
                                echo '</p>';
                            }
                            else
                            {
                                echo mysqli_error($dbc); // Returns and error if the query was bad
                            }
                            if ($row["Order_Note"] != NULL)
                            {
                                echo '      <p><b>Order Note:</b><br>' . $row["Order_Note"] . '</p>';
                            }
                            echo '      <p class = time><b>Time Ordered:</b> ' . $row["Time_Ordered"] . '</p>';
                            echo '      <p class = time><b>Time Prepared:</b> ' . $row["Time_Ready"] . '</p>';
                            echo '      <p class = time><b>Time Delivered:</b> ' . $row["Time_Delivered"] . '</p>';
                            echo '      <input type = "submit" value = "Mark As Delivered"></input>';
                            echo '  </div>';
                            echo '</div>';
                        }
                    }
                    else
                    {
                        echo mysqli_error($dbc); // Returns and error if the query was bad
                    }
                ?>
            </div>
        </div>
    </body>
</html>

<?php
    if($displayError == true)
    {
        echo "<script>DisplayErrorPopup();</script>";
        $displayError = false;
    }

    if($needsRefresh == true)
    {
        echo "<script>RefreshView();</script>";
        $needsRefresh = false;
    }
?>