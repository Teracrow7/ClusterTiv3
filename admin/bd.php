<?php

// Use environment variables to store sensitive information
$servidor = getenv('DB_HOST') ?: 'localhost:3306';
$baseDatos = getenv('DB_NAME') ?: 'clusterti';
$usuario = getenv('DB_USER') ?: 'testerMaster';
$contrasenia = getenv('DB_PASS') ?: 'testbaby333';

// PDO options for improved security and error handling
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions for error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Default fetch mode to associative arrays
    PDO::ATTR_TIMEOUT => 5, // Set connection timeout (in seconds)
];

try {
    // Establish the database connection with PDO
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDatos", $usuario, $contrasenia, $options);
} catch (Exception $error) {
    // Log the error securely
    error_log($error->getMessage(), 3, '/path/to/your/logfile.log'); // Replace with your log file path

    // Display a generic error message to the user
    echo "Error: Unable to connect to the database. Please try again later.";
    exit; // Stop execution to prevent further issues
}

?>
