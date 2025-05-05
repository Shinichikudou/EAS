document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector("nav .form-group input");
    const rows = document.querySelectorAll(".modern-table tbody tr");

    searchInput.addEventListener("input", function () {
        const keyword = this.value.toLowerCase();

        rows.forEach(row => {
            const namaDepartemen = row.children[1]?.textContent.toLowerCase() || "";

            if (namaDepartemen.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});
