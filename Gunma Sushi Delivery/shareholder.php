<?php
    $host = "www.math-cs.ucmo.edu";
    $username = "cs4130_sp2020";
    $password = "tempPWD!";
    $db_name = "cs4130_sp2020";
    
    $dbc = mysqli_connect($host, $username, $password, $db_name) OR die('Could not connect. Sorry! D:');
    mysqli_set_charset($dbc, 'utf8');
?>

<html>
    <head>
        <title> Assignment 3 - Shareholder's Page</title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "style.css">
        <script type = "text/javascript" src = "script.js"></script>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <div class = "nav">
            <p class = "navinformation">
                Please note that Gunma Sushi Delivery is not real.<br>
                This was a project done by Courtney E. Cole as an assignment for her CS 4130 course. <br>
                I know very little about common sushi prices, so please forgive me if they seem inaccurate.<br>
                All images were found via Google Images. This site is strictly for educational practice.
            </p>
            <p class = "navinformation">
                <a href = "index.php">Home</a> + <a href = "order_handler.php">Order Handler</a>
            </p>
            <hr>
        </div>
        
        <div class = "backing">
            <div class = "statsspace">
                <div class = "stats">
                    <h2 class = "header">Sushi Picked per Order:</h2>
                    <?php 
                        $sushiQuery = "SELECT COUNT(*) FROM CEC_GSD_Sushi;";
                        $numQuery = "SELECT COUNT(*) FROM CEC_GSD_Orders;";
                        if (!mysqli_error($dbc))
                        {
                            $sQ = mysqli_query($dbc, $sushiQuery);
                            $result = mysqli_fetch_array($sQ, MYSQLI_BOTH);
                            $numberOfSushis = $result[0];

                            $nQ = mysqli_query($dbc, $numQuery);
                            $result = mysqli_fetch_array($nQ, MYSQLI_BOTH);
                            $numberOfOrders = $result[0];
                        }
                        else
                        {
                            echo mysqli_error($dbc); // Returns and error if the query was bad
                        }

                        // Create an array to keep track of the total sushi count
                        $sushiArray = array();

                        $counterQuery = "SELECT Sushi_ID, Number_Of_Sushi FROM CEC_GSD_SushiOrdered;";
                        if (!mysqli_error($dbc))
                        {
                            $cQ = mysqli_query($dbc, $counterQuery);
                            while ($row = mysqli_fetch_array($cQ, MYSQLI_BOTH))
                            {
                                if (array_key_exists($row["Sushi_ID"], $sushiArray))
                                {
                                    $sushiArray[$row["Sushi_ID"]] += $row["Number_Of_Sushi"];
                                }
                                else
                                {
                                    $sushiArray[$row["Sushi_ID"]] = $row["Number_Of_Sushi"];
                                }
                            }

                            $sushiQuery = "SELECT Sushi_ID, Name FROM CEC_GSD_Sushi;";
                            if (!mysqli_error($dbc))
                            {
                                echo '<p>';
                                $sQ = mysqli_query($dbc, $sushiQuery);
                                while($row = mysqli_fetch_array($sQ, MYSQLI_BOTH))
                                {
                                    if (array_key_exists($row["Sushi_ID"], $sushiArray))
                                    {
                                        $averageAmount = $sushiArray[$row["Sushi_ID"]] / $numberOfOrders;
                                        echo $row["Name"] . ': <b>' . number_format($averageAmount, 2, '.', '') . '</b><br>';
                                    }
                                }
                                echo '</p>';
                            }
                            else
                            {
                                echo mysqli_error($dbc); // Returns and error if the query was bad
                            }
                        }
                        else
                        {
                            echo mysqli_error($dbc); // Returns and error if the query was bad
                        }
                    ?>
                </div>
            </div>

            <div class = "statsspace">
                <div class = "stats">
                    <h2 class = "header">Average Orders per Day of the Week:</h2>
                    <?php
                        $numQuery = "SELECT COUNT(*) FROM CEC_GSD_Orders;";
                        if (!mysqli_error($dbc))
                        {
                            $nQ = mysqli_query($dbc, $numQuery);
                            $result = mysqli_fetch_array($nQ, MYSQLI_BOTH);
                            $numberOfOrders = $result[0];
                        }
                        else
                        {
                            echo mysqli_error($dbc); // Returns and error if the query was bad
                        }

                        $busiestDay = 1;
                        $weekArray = array();
                        $weekQuery = "SELECT DAYOFWEEK(Time_Ordered) FROM CEC_GSD_Orders;";
                        if (!mysqli_error($dbc))
                        {
                            $wQ = mysqli_query($dbc, $weekQuery);
                            while($result = mysqli_fetch_array($wQ, MYSQLI_BOTH))
                            {
                                if (array_key_exists($result[0], $weekArray))
                                {
                                    $weekArray[$result[0]] += 1;
                                }
                                else
                                {
                                    $weekArray[$result[0]] = 1;
                                }

                                if ($weekArray[$result[0]] > $weekArray[$busiestDay])
                                {
                                    $busiestDay = $result[0];
                                }
                            }

                            echo '<p>';
                            for ($i = 1; $i <= 7; $i++)
                            {
                                if ($i == 1)
                                {
                                    $dayOfWeek = "Sunday";
                                }
                                else if ($i == 2)
                                {
                                    $dayOfWeek = "Monday";
                                }
                                else if ($i == 3)
                                {
                                    $dayOfWeek = "Tuesday";
                                }
                                else if ($i == 4)
                                {
                                    $dayOfWeek = "Wednesday";
                                }
                                else if ($i == 5)
                                {
                                    $dayOfWeek = "Thursday";
                                }
                                else if ($i == 6)
                                {
                                    $dayOfWeek = "Friday";
                                }
                                else
                                {
                                    $dayOfWeek = "Saturday";
                                }

                                if (array_key_exists($i, $weekArray))
                                {
                                    $average = $weekArray[$i] / $numberOfOrders * 100;
                                    echo $dayOfWeek . ': <b>' . number_format($average, 2, '.', '') . '%</b><br>';
                                }
                                else
                                {
                                    echo $dayOfWeek . ': <b> 0.00% </b><br>';
                                }
                            }
                            echo '</p>';

                            if ($busiestDay == 1)
                            {
                                $dayOfWeek = "Sunday";
                            }
                            else if ($busiestDay == 2)
                            {
                                $dayOfWeek = "Monday";
                            }
                            else if ($busiestDay == 3)
                            {
                                $dayOfWeek = "Tuesday";
                            }
                            else if ($busiestDay == 4)
                            {
                                $dayOfWeek = "Wednesday";
                            }
                            else if ($busiestDay == 5)
                            {
                                $dayOfWeek = "Thursday";
                            }
                            else if ($busiestDay == 6)
                            {
                                $dayOfWeek = "Friday";
                            }
                            else
                            {
                                $dayOfWeek = "Saturday";
                            }

                            echo '<p>The busiest day of the week is <b>' . $dayOfWeek . '</b>.</p>';
                        }
                        else
                        {
                            echo mysqli_error($dbc); // Returns and error if the query was bad
                        }
                    ?>
                </div>
            </div>

            <div class = "statsspace">
                <div class = "stats">
                    <h2 class = "header">Average Order-to-Delivery Time:</h2>
                    <?php
                        $numQuery = "SELECT COUNT(*) FROM CEC_GSD_Orders;";
                        if (!mysqli_error($dbc))
                        {
                            $nQ = mysqli_query($dbc, $numQuery);
                            $result = mysqli_fetch_array($nQ, MYSQLI_BOTH);
                            $numberOfOrders = $result[0];
                        }
                        else
                        {
                            echo mysqli_error($dbc); // Returns and error if the query was bad
                        }

                        $timeDifference = 0;
                        $timeQuery = "SELECT UNIX_TIMESTAMP(Time_Ordered), UNIX_TIMESTAMP(Time_Delivered) FROM CEC_GSD_Orders WHERE Time_Delivered IS NOT NULL;";
                        if (!mysqli_error($dbc))
                        {
                            $tQ = mysqli_query($dbc, $timeQuery);
                            while ($row = mysqli_fetch_array($tQ, MYSQLI_BOTH))
                            {
                                $timeDifference += $row[1] - $row[0];
                            }

                            $averageTimeDifference = $timeDifference / $numberOfOrders;
                            $time = new DateTime("@$averageTimeDifference");
                            echo '<p>It takes <b>' . $time->format('H') . ' hours</b>, <b>' . $time->format('i') . ' minutes</b>, and <b>' . $time->format('s') . ' seconds</b> on average for an order to be delivered.</p>';
                        }
                        else
                        {
                            echo mysqli_error($dbc); // Returns and error if the query was bad
                        }
                    ?>
                </div>
            </div>

            <div class = "statsspace">
                <div class = "stats">
                    <h2 class = "header">Average Payment per Order:</h2>
                    <?php
                        $numQuery = "SELECT COUNT(*) FROM CEC_GSD_Orders;";
                        if (!mysqli_error($dbc))
                        {
                            $nQ = mysqli_query($dbc, $numQuery);
                            $result = mysqli_fetch_array($nQ, MYSQLI_BOTH);
                            $numberOfOrders = $result[0];
                        }
                        else
                        {
                            echo mysqli_error($dbc); // Returns and error if the query was bad
                        }

                        $totalAmount = 0.00;
                        $priceQuery = "SELECT Total_Price FROM CEC_GSD_Orders;";
                        if (!mysqli_error($dbc))
                        {
                            $pQ = mysqli_query($dbc, $priceQuery);
                            while ($result = mysqli_fetch_array($pQ, MYSQLI_BOTH))
                            {
                                $totalAmount += $result[0];
                            }
                            
                            $averageAmount = $totalAmount / $numberOfOrders;
                            echo '<p><b>$' . number_format($averageAmount, 2, '.', '') . '</b> is made on average for each order.</p>';
                        }
                        else
                        {
                            echo mysqli_error($dbc); // Returns and error if the query was bad
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>