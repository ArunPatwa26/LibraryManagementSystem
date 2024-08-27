<?php
        // Connection details
        $server = "localhost";
        $username = "root";
        $password = "root";
        $db = "library";
        // Create connection
        $connection = mysqli_connect($server, $username, $password, $db);
        // Check connection status
        if (!$connection) {
            die("Connection failed. Reason: " . mysqli_connect_error());
        }
        ##echo "Connected!\n";
