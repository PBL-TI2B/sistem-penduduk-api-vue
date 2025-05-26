<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .logo {
            position: absolute;
            top: 0px;
            left: 20px;
        }

        .logo img {
            height: 90px;
        }

        .header-text {
            text-align: center;
            margin-left: 130px; /* pastikan tidak tertimpa logo */
            padding: 0px 0px 0 20px;
        }

        .header-text h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header-text h1 {
            margin: 4px 0 0 0;
            font-size: 20px;
            font-weight: bold;
        }

        .header-text p {
            margin: 5px 0 0 0;
            font-size: 12px;
        }

        .kop-line {
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin-top: 8px;
            margin-bottom: 20px;
        }
                table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px 12px;
            font-size: 13px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #4f6781;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9f5ff;
        }
    </style>
</head>
<body>

    <!-- Logo di kiri atas -->
    <div class="logo">
        <img src="{{ public_path('/images/LOGO_KABUPATEN_KLATEN.png') }}" alt="Logo">
    </div>

    <!-- Teks kop surat -->
    <div class="header-text">
        <h2>PEMERINTAH KABUPATEN KLATEN</h2>
        <h2>KECAMATAN GANTIWARNO</h2>
        <h1>DESA JABUNG</h1>
        <p>Alamat: Jl. Ganti Warno, Gedongan, Gesikan, Kec. Gantiwarno, Kab. Klaten, Jawa Tengah Kode Pos : 57455</p>
    </div>

    <!-- Garis pemisah -->
    <div class="kop-line"></div>

    <!-- Isi surat -->
    {{ $slot }}

</body>
</html>
