<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = 'localhost';  // Database host
$dbname = 'boardingease';  // Database name
$dbusername = 'root';  // Database username
$dbpassword = '';  // Database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


// Check if form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = isset($_POST['street']) ? $_POST['street'] : '';
    $rooms = isset($_POST['rooms']) ? $_POST['rooms'] : '';
    $payment = isset($_POST['payment']) ? $_POST['payment'] : '';

    // Build the query
    $query = "SELECT * FROM uploads WHERE city LIKE :city AND barangay LIKE :barangay";
    
    // Add optional filters to the query if they are set
    if ($street != '') {
        $query .= " AND street LIKE :street";
    }
    if ($rooms != '') {
        $query .= " AND rooms >= :rooms";
    }
    if ($payment != '') {
        $query .= " AND payment <= :payment";
    }

    // Prepare the query
    $stmt = $pdo->prepare($query);

    // Bind parameters
    $stmt->bindValue(':city', "%$city%");
    $stmt->bindValue(':barangay', "%$barangay%");
    
    // Bind optional parameters
    if ($street != '') {
        $stmt->bindValue(':street', "%$street%");
    }
    if ($rooms != '') {
        $stmt->bindValue(':rooms', $rooms, PDO::PARAM_INT);
    }
    if ($payment != '') {
        $stmt->bindValue(':payment', $payment, PDO::PARAM_STR);
    }

    // Execute the query
    $stmt->execute();

    // Fetch results
    $uploads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($uploads)) {
        echo '<p>No data to show. Use the search form to find available rooms.</p>';
    } else {
        echo '<div class="search-results">';
        foreach ($uploads as $upload) {
            echo '<div class="room-item">';
            echo '<h4>' . htmlspecialchars($upload['city']) . ', ' . htmlspecialchars($upload['barangay']) . ' - ' . htmlspecialchars($upload['street']) . '</h4>';
            echo '<p>Rooms: ' . $upload['rooms'] . '</p>';
            echo '<p>Monthly Payment: ' . number_format($upload['payment'], 2) . '</p>';
            echo '<p>Photos: ';
            $photos = explode(',', $upload['photos']);
            foreach ($photos as $photo) {
                echo '<img src="uploads/' . htmlspecialchars($photo) . '" alt="Room Photo" class="room-photo">';
            }
            echo '</p>';
            echo '</div>';
        }
        echo '</div>';
    }
}
?>
