document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector("nav .form-group input");
    const rows = document.querySelectorAll(".modern-table tbody tr");

    searchInput.addEventListener("input", function () {
        const keyword = this.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.children[1]?.textContent.toLowerCase() || "";
            const departemen = row.children[2]?.textContent.toLowerCase() || "";

            if (nama.includes(keyword) || departemen.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    rows.forEach(row => {
        row.addEventListener("click", function () {
            const idMagang = this.getAttribute("data-id");
            if (idMagang) {
                window.location.href = `/admin/detail/${idMagang}`;
            }
        });
    });
});
