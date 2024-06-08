<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brewery Info</title>
    <link rel="stylesheet" type="text/css" href="brewery_info.css">
</head>
<body>
    <h2>Brewery Info</h2>

    <?php
    session_start();
    require_once 'db_connection.php';
    $breweryId = $_GET['id'];
    // Fetch brewery details from the OpenBreweryDB API
    $apiUrl = "https://api.openbrewerydb.org/breweries/$breweryId";
    $breweryDetails = json_decode(file_get_contents($apiUrl), true);

    if (!$breweryDetails) {
        echo "<p>Brewery not found.</p>";
        exit;
    }

    // Display brewery details
    echo "<h3>{$breweryDetails['name']}</h3>";
    echo "<p><strong>Type:</strong> {$breweryDetails['brewery_type']}</p>";
    echo "<p><strong>Address 1:</strong> {$breweryDetails['address_1']}</p>";
    if ($breweryDetails['address_2']) echo "<p><strong>Address 2:</strong> {$breweryDetails['address_2']}</p>";
    if ($breweryDetails['address_3']) echo "<p><strong>Address 3:</strong> {$breweryDetails['address_3']}</p>";
    echo "<p><strong>City:</strong> {$breweryDetails['city']}</p>";
    echo "<p><strong>State:</strong> {$breweryDetails['state_province']}</p>";
    echo "<p><strong>Postal Code:</strong> {$breweryDetails['postal_code']}</p>";
    echo "<p><strong>Country:</strong> {$breweryDetails['country']}</p>";
    echo "<p><strong>Longitude:</strong> {$breweryDetails['longitude']}</p>";
    echo "<p><strong>Latitude:</strong> {$breweryDetails['latitude']}</p>";
    echo "<p><strong>Phone:</strong> {$breweryDetails['phone']}</p>";
    echo "<p><strong>Website:</strong> <a href=\"{$breweryDetails['website_url']}\" target=\"_blank\">{$breweryDetails['website_url']}</a></p>";

    // Form to add review
    echo "<h3>Add Review</h3>";
    echo '<form action="add_review.php" method="post">
        <input type="hidden" name="brewery_id" value="' . htmlspecialchars($breweryId) . '">
        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <button type="submit">Submit</button>
    </form>';

    // Fetch reviews from the database
    $sql = "SELECT r.rating, r.description, u.username 
            FROM reviews r
            JOIN users u ON r.id = u.id
            WHERE r.brewery_id = '" . mysqli_real_escape_string($conn, $breweryId) . "'";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Reviews</h3>";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p><strong>User:</strong> {$row['username']}</p>";
            echo "<p><strong>Rating:</strong> {$row['rating']}</p>";
            echo "<p><strong>Description:</strong> {$row['description']}</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>No reviews yet.</p>";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
