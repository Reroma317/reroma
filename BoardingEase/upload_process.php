<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to upload.']);
    exit;
}

// Database connection
$host = 'localhost';
$dbname = 'boardingease';
$dbusername = 'root';
$dbpassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $city = htmlspecialchars($_POST['upload_city']);
    $barangay = htmlspecialchars($_POST['upload_barangay']);
    $street = htmlspecialchars($_POST['upload_street']);
    $rooms = (int)$_POST['upload_rooms'];
    $payment = (float)$_POST['upload_payment'];
    $photo_paths = [];

    // File upload directory
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // File upload handling
    if (!empty($_FILES['upload_photos']['name'][0])) {
        foreach ($_FILES['upload_photos']['tmp_name'] as $key => $tmp_name) {
            $filename = basename($_FILES['upload_photos']['name'][$key]);
            $target_path = $upload_dir . uniqid() . "_" . $filename;

            if (move_uploaded_file($tmp_name, $target_path)) {
                $photo_paths[] = $target_path;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload file: ' . $filename]);
                exit;
            }
        }
    }

    $photos = implode(',', $photo_paths);

    // Insert into database
    $sql = "INSERT INTO uploads (user_id, city, barangay, street, rooms, payment, photos) 
            VALUES (:user_id, :city, :barangay, :street, :rooms, :payment, :photos)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':city' => $city,
        ':barangay' => $barangay,
        ':street' => $street,
        ':rooms' => $rooms,
        ':payment' => $payment,
        ':photos' => $photos,
    ]);

    // Log notification
    $notification_message = "New upload successful!";
    logNotification($pdo, $user_id, $notification_message);

    // Redirect to main page
    header('Location: main.php');
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Function to log notification
function logNotification($pdo, $userId, $message) {
    $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (:user_id, :message)");
    $stmt->execute([
        'user_id' => $userId,
        'message' => $message,
    ]);
}
?>
