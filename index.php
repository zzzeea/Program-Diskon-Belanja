<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Diskon Belanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block; 
            width: 100%; 
            margin-bottom: 5px; 
        }

        .form-group input[type="number"],
        .form-group select {
            width: 100%; 
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; 
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
        }

        .discount-details {
            margin-top: 10px;
            padding: 10px;
            background-color: #d4edda;
            border-radius: 5px;
            color: #155724;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Perhitungan Diskon Belanja</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="totalBelanja">Total Belanja (Rp):</label>
                <input type="number" id="totalBelanja" name="totalBelanja" required>
            </div>

            <div class="form-group">
                <label for="isMember">Status Member:</label>
                <select id="isMember" name="isMember" required>
                    <option value="1">Member</option>
                    <option value="0">Non-member</option>
                </select>
            </div>

            <button type="submit" name="submit">Hitung Total Bayar</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Fungsi perhitungan diskon
            function hitungTotalBelanja($totalBelanja, $isMember)
            {
                $diskon = 0;
                $diskonKeterangan = '';

                if ($isMember) {
                    // Potongan member 10%
                    $diskon = 0.10;
                    $diskonKeterangan = "Diskon member 10%";

                    // Diskon tambahan untuk total belanja lebih dari 1.000.000
                    if ($totalBelanja > 1000000) {
                        $diskon += 0.15;
                        $diskonKeterangan .= " + Tambahan diskon 15% (belanja > Rp 1.000.000)";
                    } elseif ($totalBelanja >= 500000) {
                        // Diskon 10% untuk total belanja 500.000 sampai 1.000.000
                        $diskon += 0.10;
                        $diskonKeterangan .= " + Tambahan diskon 10% (belanja antara Rp 500.000 dan Rp 1.000.000)";
                    }
                } else {
                    // Diskon untuk non-member jika total belanja lebih dari 1.000.000
                    if ($totalBelanja > 1000000) {
                        $diskon = 0.10;
                        $diskonKeterangan = "Diskon non-member 10% (belanja > Rp 1.000.000)";
                    } elseif ($totalBelanja >= 500000) {
                        // Diskon 5% untuk total belanja 500.000 sampai 1.000.000
                        $diskon = 0.05;
                        $diskonKeterangan = "Diskon non-member 5% (belanja antara Rp 500.000 dan Rp 1.000.000)";
                    }
                }

                // Hitung jumlah diskon
                $totalDiskon = $totalBelanja * $diskon;
                // Hitung total setelah diskon
                $totalSetelahDiskon = $totalBelanja - $totalDiskon;

                return [
                    'totalSetelahDiskon' => $totalSetelahDiskon,
                    'totalDiskon' => $totalDiskon,
                    'diskonKeterangan' => $diskonKeterangan
                ];
            }

            // Mendapatkan input dari form
            $totalBelanja = $_POST['totalBelanja'];
            $isMember = $_POST['isMember'] == 1 ? true : false;

            // Menghitung total bayar
            $hasil = hitungTotalBelanja($totalBelanja, $isMember);
            $totalBayar = $hasil['totalSetelahDiskon'];
            $totalDiskon = $hasil['totalDiskon'];
            $diskonKeterangan = $hasil['diskonKeterangan'];

            // Menampilkan hasil
            echo '<div class="result">Total yang harus dibayar: Rp ' . number_format($totalBayar, 0, ',', '.') . '</div>';
            echo '<div class="discount-details">';
            echo '<p>Jumlah diskon: Rp ' . number_format($totalDiskon, 0, ',', '.') . '</p>';
            echo '<p>Keterangan diskon: ' . $diskonKeterangan . '</p>';
            echo '</div>';
        }
        ?>

    </div>

</body>

</html>