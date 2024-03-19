<?php
require_once "connection.php";

try {
    // Create connections dynamically for each database
    $connections = array();
    foreach ($databaseNames as $dbName) {
        $connection = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connections[$dbName] = $connection;
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Function to fetch data from a specific table based on a SQL query
function fetchData($connection, $query, $params = array()) {
    try {
        // Prepare SQL query with named placeholders
        $stmt = $connection->prepare($query);

        // Bind parameters if provided
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        // Execute the prepared statement
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch(PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return false;
    }
}
?>
