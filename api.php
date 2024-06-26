<?php
header('Content-Type: application/json; charset=utf-8');

include("config.php");
// Check connectio"n
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["action"])) {

    $response = ["status" => 0, "data" => [], "message" => ""];

    switch ($_POST["action"]) {
        case 'get':
            // Example query

            $sql = "SELECT * FROM detectados ";

            // Execute query
            $result = $conn->query($sql);

            if ($result === false) {
                // Handle query error
                echo "Error executing query: " . $conn->error;
            } else {
                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    // Output data of each row
                    $array = [];
                    while ($row = $result->fetch_assoc()) {
                        // Do something with the data
                        $row["objeto"] = json_decode($row["objeto"], false);
                        $array[] = $row;
                    }
                    $response["data"] = $array;
                    $response["status"] = 200;
                    $response["message"] = "Data";
                    echo json_encode($response);
                    exit;
                }
                echo json_encode($response);
                exit;
            }
            $conn->close();
            break;
        case 'insert':
            // Example query
            $json = json_encode($_POST["objeto"]);
            $sql = "INSERT INTO detectados VALUES (null, $json)";

            // Execute query
            $result = $conn->query($sql);
            $conn->close();
            $response["status"] = 200;
            $response["message"] = "insertado con esxito";
            echo json_encode($response);
            break;

        default:
            $response["status"] = 200;
            $response["message"] = "No Action";
            echo json_encode($response);
            break;
    }
}

if (isset($_GET["action"])) {
    $response = ["status" => 0, "data" => [], "message" => ""];
    switch ($_GET["action"]) {
        case 'get':
            // Example query

            $sql = "SELECT * FROM detectados ";

            // Execute query
            $result = $conn->query($sql);

            if ($result === false) {
                // Handle query error
                echo "Error executing query: " . $conn->error;
            } else {
                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    // Output data of each row
                    $array = [];
                    while ($row = $result->fetch_assoc()) {
                        // Do something with the data
                        $row["objeto"] = json_decode($row["objeto"], false);
                        $array[] = $row;
                    }
                    $response["data"] = $array;
                    $response["status"] = 200;
                    $response["message"] = "Data";
                    echo json_encode($response);
                    exit;
                }
                echo json_encode($response);
                exit;
            }
            $conn->close();
            break;
        default:
            $response["status"] = 200;
            $response["message"] = "No Action";
            echo json_encode($response);
            break;
    }
}
