// File: tuition/assets/js/script.js
document.addEventListener("DOMContentLoaded", function() {
    var menuToggle = document.getElementById("menu-toggle");
    var wrapper = document.getElementById("wrapper");

    if (menuToggle) {
        // Toggle sidebar on click
        menuToggle.addEventListener("click", function(e) {
            e.preventDefault();
            wrapper.classList.toggle("toggled");
        });
    }
});

