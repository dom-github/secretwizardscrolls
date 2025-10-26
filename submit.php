<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Simple validation
    if (empty($name) || empty($email)) {
        echo "All fields are required!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    // Display the input back to the user
    echo "<h2>Thank you for submitting your info!</h2>";
    echo "<p><strong>Name:</strong> " . $name . "</p>";
    echo "<p><strong>Email:</strong> " . $email . "</p>";

    // Optional: Save to a file
    $file = fopen("contacts.txt", "a");
    fwrite($file, "$name | $email\n");
    fclose($file);
}
?>