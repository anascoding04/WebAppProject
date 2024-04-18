<?php
require("_connect.php");

// Check if firstName parameter is set in the GET request
if (isset($_GET['firstName'])) {
    // Get the value of firstName from the GET request
    $firstName = $_GET['firstName'];

    if ($firstName == "all") {
        $SQL = "SELECT * FROM Employees";
        $stmt = mysqli_prepare($connect, $SQL);
    } else {
        $SQL = "SELECT * FROM Employees WHERE FirstName = ?";
        $stmt = mysqli_prepare($connect, $SQL);
        mysqli_stmt_bind_param($stmt, 's', $firstName);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        // Initialize variable to store buttons HTML
        $buttonsHTML = '';

        // Generate HTML for each user found
        while ($row = mysqli_fetch_assoc($result)) {
            $firstName = $row['FirstName'];
            $lastName = $row['LastName'];
            $ID = $row['ID'];
            // Generate button with onclick event to show user details
            $buttonsHTML .= "<button class='name-button' data-id='$ID' onclick='showUserDetails(\"$ID\")'>$firstName $lastName</button>";
        }

        // Output the generated buttons HTML
        echo $buttonsHTML;
    } else {
        // Output message if no users found
        echo "No users found.";
    }

    // Free result and close statement
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
} else {
    // Output message if firstName parameter is not set
    echo "No user specified.";
}

// Close the database connection
mysqli_close($connect);
?>
