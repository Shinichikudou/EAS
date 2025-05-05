document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const toggleSidebar = document.querySelector("nav .toggle-sidebar");
    const allDropdowns = document.querySelectorAll("#sidebar .side-dropdown");
    const allSideDividers = document.querySelectorAll("#sidebar .divider");
    const profile = document.querySelector("nav .profile");
    const imgProfile = profile.querySelector("img");
    const dropdownProfile = profile.querySelector(".profile-link");
    const allMenu = document.querySelectorAll(".content-data .head .menu");

    // Sidebar Dropdown Toggle
    allDropdowns.forEach(dropdown => {
        const link = dropdown.parentElement.querySelector("a:first-child");
        link.addEventListener("click", function (e) {
            e.preventDefault();

            if (!this.classList.contains("active")) {
                allDropdowns.forEach(i => {
                    i.classList.remove("show");
                    i.parentElement.querySelector("a:first-child").classList.remove("active");
                });
            }

            this.classList.toggle("active");
            dropdown.classList.toggle("show");
        });
    });

    // Sidebar Collapse Toggle
    toggleSidebar.addEventListener("click", function () {
        sidebar.classList.toggle("hide");
        localStorage.setItem("sidebarState", sidebar.classList.contains("hide") ? "hidden" : "visible");
        allSideDividers.forEach(item => {
            item.textContent = sidebar.classList.contains("hide") ? "-" : item.dataset.text;
        });
    });

    sidebar.addEventListener("mouseleave", function () {
        if (sidebar.classList.contains("hide")) {
            allDropdowns.forEach(item => {
                item.classList.remove("show");
                item.parentElement.querySelector("a:first-child").classList.remove("active");
            });
        }
    });

    sidebar.addEventListener("mouseenter", function () {
        if (sidebar.classList.contains("hide")) {
            allDropdowns.forEach(item => {
                item.classList.remove("show");
                item.parentElement.querySelector("a:first-child").classList.remove("active");
            });
        }
    });

    // Profile Dropdown
    imgProfile.addEventListener("click", function () {
        dropdownProfile.classList.toggle("show");
    });

    // Menu Toggle
    allMenu.forEach(item => {
        const icon = item.querySelector(".icon");
        const menuLink = item.querySelector(".menu-link");
        icon.addEventListener("click", function () {
            menuLink.classList.toggle("show");
        });
    });

    // Close dropdowns on outside click
    window.addEventListener("click", function (e) {
        if (!imgProfile.contains(e.target) && !dropdownProfile.contains(e.target)) {
            dropdownProfile.classList.remove("show");
        }
        allMenu.forEach(item => {
            const icon = item.querySelector(".icon");
            const menuLink = item.querySelector(".menu-link");
            if (!icon.contains(e.target) && !menuLink.contains(e.target)) {
                menuLink.classList.remove("show");
            }
        });
    });

    // Show Notification
    function showNotification(message) {
        const notification = document.createElement("div");
        notification.className = "notification";
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    document.querySelectorAll(".menu .menu-link li a").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            showNotification(`Anda memilih: ${this.textContent}`);
        });
    });

    // Set Progress Values
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".progress").forEach(item => {
            let value = item.dataset.value; // Ambil nilai persentase dari data-value
            item.style.setProperty("--value", value + "%"); // Atur nilai ke CSS
            item.style.width = value + "%"; // Terapkan ke lebar progress
        });
    });

    // Maintain Sidebar State after Refresh
    if (localStorage.getItem("sidebarState") === "hidden") {
        sidebar.classList.add("hide");
        allSideDividers.forEach(item => item.textContent = "-");
    }

});
