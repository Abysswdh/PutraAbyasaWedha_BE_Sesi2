<?php
// Data produk
$produk = [
    ["kode" => "A001", "nama" => "Indomie Goreng", "harga" => 3500, "stok" => 100],
    ["kode" => "A002", "nama" => "Teh Botol Sosro", "harga" => 4000, "stok" => 50],
    ["kode" => "A003", "nama" => "Susu Ultra Milk", "harga" => 12000, "stok" => 30],
    ["kode" => "A004", "nama" => "Roti Tawar Sari Roti", "harga" => 15000, "stok" => 20],
    ["kode" => "A005", "nama" => "Minyak Goreng Bimoli 1L", "harga" => 18000, "stok" => 15]
];

// Fungsi untuk mencari produk berdasarkan kode
function cariProduk($array_produk, $kode) {
    foreach ($array_produk as $produk) {
        if ($produk["kode"] === $kode) {
            return $produk;
        }
    }
    return null;
}

// Fungsi untuk menghitung subtotal
function hitungSubtotal($harga, $jumlah) {
    return $harga * $jumlah;
}

// Fungsi untuk menghitung diskon
function hitungDiskon($total) {
    if ($total >= 100000) {
        return $total * 0.1; // Diskon 10%
    } elseif ($total >= 50000) {
        return $total * 0.05; // Diskon 5%
    } else {
        return 0; // Tidak ada diskon
    }
}

// Fungsi untuk menghitung pajak
function hitungPajak($total, $persen = 11) {
    return $total * ($persen / 100);
}

// Fungsi untuk mengurangi stok
function kurangiStok(&$produk, $jumlah) {
    $produk["stok"] -= $jumlah;
}

// Fungsi untuk format rupiah
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}

// Fungsi untuk membuat struk belanja
function buatStrukBelanja($transaksi, $array_produk) {
    $total_belanja = 0;
    
    echo "========================================\n";
    echo "         MINIMARKET SEJAHTERA\n";
    echo "========================================\n";
    echo "Tanggal: " . date("d F Y") . "\n\n";

    foreach ($transaksi as $item) {
        $produk = cariProduk($array_produk, $item["kode"]);
        $subtotal = hitungSubtotal($produk["harga"], $item["jumlah"]);
        $total_belanja += $subtotal;

        echo $produk["nama"] . "\n";
        echo formatRupiah($produk["harga"]) . " x " . $item["jumlah"];
        echo str_repeat(" ", 8 - strlen((string)$item["jumlah"]));
        echo "= " . formatRupiah($subtotal) . "\n\n";

        // Kurangi stok
        kurangiStok($produk, $item["jumlah"]);
    }

    $diskon = hitungDiskon($total_belanja);
    $subtotal_setelah_diskon = $total_belanja - $diskon;
    $pajak = hitungPajak($subtotal_setelah_diskon);
    $total_bayar = $subtotal_setelah_diskon + $pajak;

    echo "----------------------------------------\n";
    echo "Subtotal            = " . formatRupiah($total_belanja) . "\n";
    echo "Diskon (" . ($diskon > 0 ? ($diskon == $total_belanja * 0.1 ? "10%" : "5%") : "0%") . ")         = " . formatRupiah($diskon) . "\n";
    echo "Subtotal stl diskon = " . formatRupiah($subtotal_setelah_diskon) . "\n";
    echo "PPN (11%)           = " . formatRupiah($pajak) . "\n";
    echo "----------------------------------------\n";
    echo "TOTAL BAYAR         = " . formatRupiah($total_bayar) . "\n";
    echo "========================================\n\n";

    echo "Status Stok Setelah Transaksi:\n";
    foreach ($transaksi as $item) {
        $produk = cariProduk($array_produk, $item["kode"]);
        echo "- " . $produk["nama"] . ": " . $produk["stok"] . " pcs\n";
    }
    echo "========================================\n";
    echo "     Terima kasih atas kunjungan Anda\n";
    echo "========================================\n";
}

// Contoh penggunaan
$transaksi = [
    ["kode" => "A001", "jumlah" => 5],
    ["kode" => "A003", "jumlah" => 2],
    ["kode" => "A004", "jumlah" => 1]
];

buatStrukBelanja($transaksi, $produk);
?>