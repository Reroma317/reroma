document.addEventListener("DOMContentLoaded", function () {
    const editProfileBtn = document.getElementById("edit-profile-btn");
    const saveProfileBtn = document.getElementById("save-profile-btn");
    const cancelEditBtn = document.getElementById("cancel-edit-btn");
    const saveCancelButtons = document.getElementById("save-cancel-buttons");

    const profileName = document.getElementById("profile-name");
    const profileContact = document.getElementById("profile-contact");
    const profileEmail = document.getElementById("profile-email");

    const editName = document.getElementById("edit-name");
    const editContact = document.getElementById("edit-contact");
    const editEmail = document.getElementById("edit-email");

    const editProfilePicBtn = document.getElementById("edit-profile-pic");
    const profilePicInput = document.getElementById("profile-pic-input");
    const profilePicture = document.getElementById("profile-picture");

    // Toggle Edit Mode
    editProfileBtn.addEventListener("click", function () {
        profileName.classList.add("hidden");
        profileContact.classList.add("hidden");
        profileEmail.classList.add("hidden");

        editName.classList.remove("hidden");
        editContact.classList.remove("hidden");
        editEmail.classList.remove("hidden");

        editProfileBtn.classList.add("hidden");
        saveCancelButtons.classList.remove("hidden");
    });

    // Cancel Editing
    cancelEditBtn.addEventListener("click", function () {
        profileName.classList.remove("hidden");
        profileContact.classList.remove("hidden");
        profileEmail.classList.remove("hidden");

        editName.classList.add("hidden");
        editContact.classList.add("hidden");
        editEmail.classList.add("hidden");

        editProfileBtn.classList.remove("hidden");
        saveCancelButtons.classList.add("hidden");
    });

    // Save Edited Data
    saveProfileBtn.addEventListener("click", function () {
        profileName.textContent = editName.value;
        profileContact.textContent = editContact.value;
        profileEmail.textContent = editEmail.value;

        cancelEditBtn.click(); // Switch back to view mode
    });

    // Edit Profile Picture
    editProfilePicBtn.addEventListener("click", function () {
        profilePicInput.click();
    });

    profilePicInput.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                profilePicture.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
