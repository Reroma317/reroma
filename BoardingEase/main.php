
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/main.css">
    <script defer src="js/searchupload.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="logo">BoardingEase</div>
        <ul class="nav-links">
    <li><a href="#home">Home</a></li>
    <li><a href="#request">Request</a></li>
    <li><a href="#notification" id="notification-btn">Notification</a></li>
</ul>

        <div class="logout-btn">
            <form action="includes/logout.inc.php" method="post">
                <button type="submit">Logout</button>
            </form>
        </div>
    </nav>
    <div class="main-container">
        <!-- Fixed Profile Container -->
        <div class="fixed-container">
            <div class="profile-pic">
                <img src="<?php echo $profile_image; ?>" alt="Profile Picture">
            </div>
            <div class="profile-details">
                <p><strong>Name:</strong> </p>
                <p><strong>Email:</strong> </p>
            </div>
        </div>
    </div>


        <!-- Newsfeed Container (Middle Section) -->
        <div class="newsfeed-container" id="newsfeed-container">
            <p>No data to show. Use the search form to find available rooms.</p>
        </div>

        <!-- Right Container -->
<div class="right-container">
    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button id="show-search" class="active">Search</button>
        <button id="show-upload">Upload</button>
    </div>

    <!-- Search Form -->
    <div id="search-form" class="form-section">
        <h3>Search</h3>
        <form id="searchForm" method="POST">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <label for="barangay">Barangay:</label>
            <input type="text" id="barangay" name="barangay" required>

            <label for="street">Street:</label>
            <input type="text" id="street" name="street">

            <label for="rooms">Rooms:</label>
            <input type="number" id="rooms" name="rooms" min="1">

            <label for="payment">Monthly Payment:</label>
            <input type="number" id="payment" name="payment" min="0">

            <button type="submit" class="submit-btn">Search</button>
        </form>
    </div>

    <!-- Upload Form -->
    <div id="upload-form" class="form-section hidden">
    <h3>Upload</h3>
    <form action="upload_process.php" method="POST" enctype="multipart/form-data">
        <label for="upload-city">City:</label>
        <input type="text" id="upload-city" name="upload_city" required>

        <label for="upload-barangay">Barangay:</label>
        <input type="text" id="upload-barangay" name="upload_barangay" required>

        <label for="upload-street">Street:</label>
        <input type="text" id="upload-street" name="upload_street">

        <label for="upload-rooms">Rooms:</label>
        <input type="number" id="upload-rooms" name="upload_rooms" min="1" required>

        <label for="upload-payment">Monthly Payment:</label>
        <input type="number" id="upload-payment" name="upload_payment" min="0" required>

        <!-- Photo Uploader -->
        <label for="upload-photos">Upload Photos:</label>
        <input type="file" id="upload-photos" name="upload_photos[]" accept="image/*" multiple>

        <button type="submit" class="submit-btn">Upload</button>
    </form>
    </div>
    </div>

    

<!-- Hidden Notification Content -->
<div id="notification-container" style="display: none;">
    <h3>Notifications</h3>
    <div class="notification-card">
        <p>You have a new message from User123.</p>
    </div>
    <div class="notification-card">
        <p>Search completed successfully. View your results.</p>
    </div>
    <div class="notification-card">
        <p>Room availability updated in your preferred area.</p>
    </div>
</div>





    <script>
        // AJAX request to handle form submission without page reload
        document.getElementById('searchForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent form from submitting normally

            const formData = new FormData(this);

            fetch('search.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())  // The server returns HTML content
            .then(data => {
                document.getElementById('newsfeed-container').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const notificationBtn = document.getElementById('notification-btn');
        const newsfeedContainer = document.getElementById('newsfeed-container');
        const notificationContainer = document.getElementById('notification-container');

        // Function to display the notification container in the newsfeed
        function showNotifications() {
            // Replace the newsfeed content with the notification container
            newsfeedContainer.innerHTML = notificationContainer.innerHTML;
        }

        // Attach click event to the notification button
        notificationBtn.addEventListener('click', showNotifications);
    });
</script>





</body>

</html>
