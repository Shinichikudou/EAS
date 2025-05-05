document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector("nav .form-group input");
    const rows = document.querySelectorAll(".modern-table tbody tr");

    searchInput.addEventListener("input", function () {
        const keyword = this.value.toLowerCase();

        rows.forEach(row => {
            const idMagang = row.children[1]?.textContent.toLowerCase() || "";
            const nama = row.children[2]?.textContent.toLowerCase() || "";

            if (idMagang.includes(keyword) || nama.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});
