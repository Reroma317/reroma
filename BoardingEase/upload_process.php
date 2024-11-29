<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    die("You must be logged in to upload.");
    header("Location: index.php");
}

$host = 'localhost';
$dbname = 'boardingease';
$dbusername = 'root';
$dbpassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in and user_id is stored in the session.
    $city = $_POST['upload_city'];
    $barangay = $_POST['upload_barangay'];
    $street = $_POST['upload_street'];
    $rooms = (int)$_POST['upload_rooms'];
    $payment = (float)$_POST['upload_payment'];
    $photo_paths = [];

    // Handle File Uploads
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (!empty($_FILES['upload_photos']['name'][0])) {
        foreach ($_FILES['upload_photos']['tmp_name'] as $key => $tmp_name) {
            $filename = basename($_FILES['upload_photos']['name'][$key]);
            $target_path = $upload_dir . uniqid() . "_" . $filename;

            if (move_uploaded_file($tmp_name, $target_path)) {
                $photo_paths[] = $target_path;
            } else {
                die("Failed to upload file: " . $filename);
            }
        }
    }

    $photos = implode(',', $photo_paths); // Store as comma-separated values.

    // Insert Data into Database
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

    echo "Upload successful!";
} else {
    echo "Invalid request method.";
}
?>
