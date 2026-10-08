<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class StrukController extends Controller
{
    /**
     * Cetak struk transaksi
     */
    public function struk()
    {
        try {
            // 1. Koneksi ke Printer Windows (Nama printer harus sama persis dengan nama sharing Windows)
            $connector = new WindowsPrintConnector("POS-58");
            $printer = new Printer($connector);

            // 2. Ambil Data Item
            $items = $this->getItems();

            // 3. Hitung Total
            $grandTotal = 0;
            foreach ($items as $item) {
                $grandTotal += ($item['qty'] * $item['price']) - $item['discount'];
            }

            // 4. Header Toko
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("POLIJE MART\n");
            $printer->setEmphasis(false);
            $printer->text("Jl. Mastrip No. 164, Jember\n");
            $printer->text("Telp. 0812-3456-7890\n");
            $printer->text("--------------------------------\n");

            // 5. Informasi Transaksi
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("No   : TRX-20260916-001\n");
            $printer->text("Kasir: David\n");
            $printer->text("Tgl  : " . date('d-m-Y H:i') . "\n");
            $printer->text("--------------------------------\n");

            // 6. Detail Barang
            foreach ($items as $item) {
                $subtotal = ($item['qty'] * $item['price']) - $item['discount'];
                
                // Nama Barang
                $printer->text($item['name'] . "\n");
                
                // Qty x Harga = Subtotal
                $printer->text($item['qty'] . "x" . number_format($item['price'], 0, ',', '.'));
                $printer->text(" = Rp " . number_format($subtotal, 0, ',', '.') . "\n");
            }

            // 7. Total
            $printer->text("--------------------------------\n");
            $printer->setEmphasis(true);
            $printer->text("TOTAL: Rp " . number_format($grandTotal, 0, ',', '.') . "\n");
            $printer->setEmphasis(false);

            // 8. Pembayaran & Kembalian
            $bayar = 100000;
            $kembalian = $bayar - $grandTotal;
            $printer->text("BAYAR  : Rp " . number_format($bayar, 0, ',', '.') . "\n");
            $printer->text("KEMBALI: Rp " . number_format($kembalian, 0, ',', '.') . "\n");

            // 9. Footer
            $printer->text("--------------------------------\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima Kasih Atas Kunjungan Anda\n");
            $printer->text("Selamat Berbelanja Kembali\n");

            // Feed & Potong Kertas
            $printer->feed(3);
            $printer->cut();

            // 10. Tutup Koneksi
            $printer->close();

            return "Struk berhasil dicetak.";

        } catch (Exception $e) {
            return "Gagal mencetak struk: " . $e->getMessage();
        }
    }

    /**
     * Mengambil data item transaksi (Dummy Data)
     */
    private function getItems()
    {
        return [
            [
                'code' => '899100210001',
                'name' => 'Indomie Goreng',
                'qty' => 2,
                'price' => 3500,
                'discount' => 0,
            ],
            [
                'code' => '899100210002',
                'name' => 'Aqua 600ml',
                'qty' => 2,
                'price' => 4000,
                'discount' => 0,
            ],
            [
                'code' => '899100210003',
                'name' => 'Roti Coklat',
                'qty' => 1,
                'price' => 7500,
                'discount' => 500,
            ],
            [
                'code' => '899100210004',
                'name' => 'Teh Botol Sosro',
                'qty' => 2,
                'price' => 5000,
                'discount' => 0,
            ],
        ];
    }
}