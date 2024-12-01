document.addEventListener("DOMContentLoaded", () => {
    // Handle Delete button click
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", event => {
            const uploadId = event.target.getAttribute("data-id");
            if (confirm("Are you sure you want to delete this upload?")) {
                fetch(`delete_upload.php?upload_id=${uploadId}`, {
                    method: "POST"
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Upload deleted successfully!");
                            location.reload(); // Refresh to show updated data
                        } else {
                            alert("Error deleting upload: " + data.error);
                        }
                    });
            }
        });
    });

    // Handle Update button click
    document.querySelectorAll(".update-btn").forEach(button => {
        button.addEventListener("click", event => {
            const uploadId = event.target.getAttribute("data-id");
            // Redirect to the update page (you can use a modal instead)
            window.location.href = `update_upload.php?upload_id=${uploadId}`;
        });
    });
});

