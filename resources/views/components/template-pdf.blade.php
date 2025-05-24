<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 0;
        }

        .title {
            text-align: center;
            font-size: 20px;
            margin: 30px 0;
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

    <div style="text-align: center;">
        <img src="{{ public_path('/images/LOGO_KABUPATEN_KLATEN.png') }}" alt="Logo" style="position: absolute; left: 60px; top: 20px;" height="80">
        <h2 style="margin: 0;">PEMERINTAH KABUPATEN KLATEN</h2>
        <h2 style="margin: 0;">KECAMATAN GANTIWARNO</h2>
        <h1 style="margin: 0;">DESA JABUNG</h1>
        <p style="margin: 0; font-size: 12px;">Alamat: Jl. Ganti Warno, Gedongan, Gesikan, Kec. Gantiwarno, Kab. Klaten, Jawa Tengah Kode Pos : 57455</p>
        <hr style="border: 2px solid #000; margin-top: 10px;">
    </div>    
    
    {{ $slot }}

</body>
</html>
