document.addEventListener("DOMContentLoaded", function () {
    let qrData = {
        id_magang: "{{ $internship->id_magang }}",
        nama: "{{ $internship->nama }}",
        departemen: "{{ $internship->departemen->nama_departemen }}",
        email: "{{ $internship->email }}",
        no_telepon: "{{ $internship->no_telepon }}"
    };

    // Konversi data ke format JSON string
    let qrString = JSON.stringify(qrData);

    // Generate QR Code
    new QRCode(document.getElementById("qrcode"), {
        text: qrString,
        width: 200,
        height: 200
    });

    // Pastikan tombol dapat diklik
    document.getElementById("btnCetakPDF").addEventListener("click", function () {
        cetakPDF();
    });
});

function cetakPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: [90, 150] // Ukuran sesuai ID Card
    });

    const idCardFront = document.getElementById("idCardFront");
    const idCardBack = document.getElementById("idCardBack");

    // Ambil tampilan depan
    html2canvas(idCardFront, { scale: 2 }).then(canvasFront => {
        let imgDataFront = canvasFront.toDataURL("image/png");
        doc.addImage(imgDataFront, "PNG", 5, 5, 80, 140);

        // Tambah halaman kedua untuk bagian belakang
        doc.addPage();

        // Beri waktu agar QR Code dapat dirender
        setTimeout(() => {
            html2canvas(idCardBack, { scale: 2 }).then(canvasBack => {
                let imgDataBack = canvasBack.toDataURL("image/png");
                doc.addImage(imgDataBack, "PNG", 5, 5, 80, 140);

                // Simpan PDF
                doc.save("IDCard_{{ $internship->id_magang }}.pdf");
            });
        }, 1000);
    });
}
