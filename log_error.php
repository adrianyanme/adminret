<?php
include "functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['error'])) {
        logError($_POST['error']);
        echo "Error logged.";
    } else {
        echo "No error message provided.";
    }
} else {
    echo "Invalid request method.";
}
?>