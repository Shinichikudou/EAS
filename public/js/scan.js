document.addEventListener("DOMContentLoaded", () => {
    // Manual input
    document.getElementById("manual-input-btn").addEventListener("click", () => {
        const idMagang = document.getElementById("employee-id").value;

        fetch("/get-intern", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id_magang: idMagang })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            showPopup(data);
        });
    });

    // Check In
    document.getElementById("check-in-btn").addEventListener("click", () => {
        fetch("/check-in", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id_magang: document.getElementById("intern-id").textContent })
        })
        .then(res => res.json())
        .then(res => alert(res.message || res.error));
    });

    // Check Out
    document.getElementById("check-out-btn").addEventListener("click", () => {
        fetch("/check-out", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id_magang: document.getElementById("intern-id").textContent })
        })
        .then(res => res.json())
        .then(res => alert(res.message || res.error));
    });

    // Close Popup
    document.getElementById("close-popup-btn").addEventListener("click", () => {
        document.getElementById("intern-data-popup").style.display = "none";
        isPopupOpen = false;
    });

    // QR Scanner
    const qrRegion = document.getElementById("reader");
    const scanTrigger = document.getElementById("start-scan");
    let isPopupOpen = false;
    const html5QrCode = new Html5Qrcode("reader");

    scanTrigger.addEventListener("click", () => {
        qrRegion.style.display = "block";

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                const cameraId = devices[0].id;

                html5QrCode.start(
                    cameraId,
                    { fps: 10, qrbox: 250 },
                    qrCodeMessage => {
                        if (!isPopupOpen) {
                            isPopupOpen = true;
                            html5QrCode.stop().then(() => {
                                qrRegion.style.display = "none";
                            });

                            try {
                                const jsonData = JSON.parse(qrCodeMessage.trim());
                                const idMagang = jsonData.id_magang;

                                if (!idMagang) throw new Error("QR tidak memiliki id_magang");

                                fetch("/get-intern", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({ id_magang: idMagang })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.error) {
                                        alert(data.error);
                                        isPopupOpen = false;
                                        return;
                                    }
                                    showPopup(data);
                                });

                            } catch (err) {
                                console.error("Gagal parsing QR:", err);
                                alert("QR Code tidak valid atau tidak berisi id_magang.");
                                isPopupOpen = false;
                            }
                        }
                    },
                    errorMessage => {
                        // Optional: tampilkan di console
                    }
                ).catch(err => {
                    console.error("Gagal membuka kamera:", err);
                    alert("Tidak bisa mengakses kamera.");
                });
            }
        });
    });

    function showPopup(data) {
        document.getElementById("intern-id").textContent = data.id_magang;
        document.getElementById("intern-name").textContent = data.nama;
        document.getElementById("intern-department").textContent = data.departemen;
        document.getElementById("intern-photo").src = data.foto;
        document.getElementById("intern-data-popup").style.display = "block";
    }
});
