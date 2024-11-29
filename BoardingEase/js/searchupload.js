document.addEventListener("DOMContentLoaded", function () {
    const searchButton = document.getElementById("show-search");
    const uploadButton = document.getElementById("show-upload");
    const searchForm = document.getElementById("search-form");
    const uploadForm = document.getElementById("upload-form");

    // Function to toggle forms
    function toggleForms(activeForm, inactiveForm, activeButton, inactiveButton) {
        activeForm.classList.remove("hidden");
        inactiveForm.classList.add("hidden");
        activeButton.classList.add("active");
        inactiveButton.classList.remove("active");
    }

    // Show Search Form and Hide Upload Form
    searchButton.addEventListener("click", function () {
        toggleForms(searchForm, uploadForm, searchButton, uploadButton);
    });

    // Show Upload Form and Hide Search Form
    uploadButton.addEventListener("click", function () {
        toggleForms(uploadForm, searchForm, uploadButton, searchButton);
    });

    // Initial Display (Search Form visible by default)
    toggleForms(searchForm, uploadForm, searchButton, uploadButton);
});
