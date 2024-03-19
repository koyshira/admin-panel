<?php
require_once "modules/fetchData.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input from the form
    $lookupValue = $_POST["lookup"];

    // Construct the SQL query to search for the entered value in character 1, 2, and 3
    $query = "SELECT Socialclubid, Login, Email, Redbucks, Gocoins, Totalplayed, Totalweekplayed FROM accounts WHERE character1 = :lookupValue OR character2 = :lookupValue OR character3 = :lookupValue LIMIT 1";

    // Execute the query
    $userData = fetchData($connections["pixel"], $query, array(':lookupValue' => $lookupValue));
    $accessLevel = fetchData($connections["pixel"], "SELECT adminlvl FROM characters WHERE uuid = $lookupValue");

    // Check if any results are returned
    if ($userData) {
        // Encode each element of $userData separately
        $encodedUserData = array_map('urlencode', $userData[0]);

        // Convert the encoded user data back into a query string
        $userDataQueryString = http_build_query($encodedUserData);

        // Redirect back to index.php with the user info appended to the URL
        header("Location: ../index.php?" . $userDataQueryString . "&accessLevel=" . urlencode($accessLevel[0]['adminlvl']));
        exit;
    } else {
        // No user found, redirect back to index.php with an error message appended to the URL
        header("Location: ../index.php?error=1");
        exit;
    }
} else {
    // If the form is not submitted, redirect back to index.php
    header("Location: ../index.php");
    exit;
}
?>
