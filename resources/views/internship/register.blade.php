<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Form Register</title>
    <link rel="stylesheet" href="{{ asset('css/form-intern.css') }}">
</head>
<body>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div id="success-alert" class="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Notifikasi Error -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="container">
        <div class="left">
            Let’s setup your Information
        </div>

        <div class="right">
            <h2>Let’s get started</h2>

            <form id="internshipForm" action="{{ route('internship.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h3>A. Data Diri</h3>
                <div class="form-group">
                    <div class="half">
                        <label>Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="half">
                        <label>Nomor Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="half">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="half">
                        <label>Asal Sekolah/Instansi</label>
                        <input type="text" name="instansi" value="{{ old('instansi') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="half">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="half">
                        <label>Pas Foto</label>
                        <input type="file" name="pas_foto" accept="image/png, image/jpeg, image/jpg" required>
                    </div>
                </div>

                <h3>B. Informasi Tujuan Magang</h3>
                <div class="form-group">
                    <div class="half">
                        <label for="departemen_id">Departemen</label>
                        <select id="departemen_id" name="departemen_id" required>
                            <option value="" disabled selected>Pilih Departemen</option>
                            @foreach($departemens as $depart)
                                <option value="{{ $depart->id_departemen }}"
                                    {{ old('departemen_id') == $depart->id_departemen ? 'selected' : '' }}>
                                    {{ $depart->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="half">
                        <label>Area Kerja</label>
                        <input type="text" name="area_kerja" value="{{ old('area_kerja') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="half">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                    </div>
                    <div class="half">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Surat Rekomendasi HC</label>
                    <input type="file" name="surat_rekomendasi" accept=".pdf,.doc,.docx" required>
                </div>

                <div class="submit-container">
                    <button type="submit" class="submit-button">Submit</button>
                    <button type="button" class="back-button" onclick="window.location.href='{{ route('internship.splash') }}'">Kembali</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var successAlert = document.getElementById('success-alert');

            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                    window.location.href = "{{ route('internship.splash') }}";
                }, 3000);
            }

            document.getElementById("internshipForm").addEventListener("submit", function() {
                let loadingOverlay = document.getElementById("loading");
                if (loadingOverlay) loadingOverlay.style.display = "flex";
            });
        });
    </script>

</body>
</html>
