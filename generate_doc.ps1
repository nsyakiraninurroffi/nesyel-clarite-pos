# ============================================================
# AUTO-GENERATE WORD DOCUMENTATION - NESYEL CLARITE POS
# Jalankan: powershell -ExecutionPolicy Bypass -File "d:\laravel-POS\generate_doc.ps1"
# ============================================================

$outputPath = "d:\laravel-POS\Dokumentasi_NesyelClarite_POS.docx"
Write-Host "Output path: $outputPath" -ForegroundColor Cyan

$word = New-Object -ComObject Word.Application
$word.Visible = $true
$word.DisplayAlerts = 0
$doc = $word.Documents.Add()
$sel = $word.Selection

# ── Suppress COM return values cleanly ──────────────────────
function TypeText($text)      { $null = $sel.TypeText($text) }
function TypePara()           { $null = $sel.TypeParagraph() }
function PageBreak()          { $null = $sel.InsertBreak(7) }

function SetStyle($name) {
    try { $sel.Style = $doc.Styles.Item($name) } catch {}
}

# ── Content Helpers ─────────────────────────────────────────
function H1($text) {
    TypePara
    SetStyle("Heading 1")
    TypeText($text)
    TypePara
    SetStyle("Normal")
}

function H2($text) {
    SetStyle("Heading 2")
    TypeText($text)
    TypePara
    SetStyle("Normal")
}

function H3($text) {
    SetStyle("Heading 3")
    TypeText($text)
    TypePara
    SetStyle("Normal")
}

function Para($text) {
    SetStyle("Normal")
    TypeText($text)
    TypePara
}

function Bullet($text) {
    SetStyle("List Bullet")
    TypeText($text)
    TypePara
    SetStyle("Normal")
}

function ScreenshotPlaceholder() {
    TypePara
    SetStyle("Normal")
    # Bold label
    $sel.Font.Bold = $true
    TypeText("[ SCREENSHOT ]")
    $sel.Font.Bold = $false
    TypePara
    # Shaded placeholder line using border paragraph
    SetStyle("Normal")
    $sel.Font.Italic = $true
    $sel.Font.Color = 8421504  # Gray
    TypeText(">> Paste screenshot di sini: klik paragraf ini > Insert > Pictures >> pilih file gambar <<")
    $sel.Font.Italic = $false
    $sel.Font.Color = -16777216  # Auto/Black
    TypePara
    TypePara
}

function Module($num, $title, $url, $desc, $bullets) {
    PageBreak
    H1("Modul $num - $title")
    H3("URL / Cara Akses")
    Para($url)
    H3("Screenshot")
    ScreenshotPlaceholder
    H3("Deskripsi")
    Para($desc)
    H3("Fitur Utama")
    foreach ($b in $bullets) { Bullet($b) }
}

# ── PAGE SETUP ───────────────────────────────────────────────
$doc.PageSetup.TopMargin    = $word.CentimetersToPoints(2.5)
$doc.PageSetup.BottomMargin = $word.CentimetersToPoints(2.5)
$doc.PageSetup.LeftMargin   = $word.CentimetersToPoints(3.0)
$doc.PageSetup.RightMargin  = $word.CentimetersToPoints(2.5)

# ── COVER PAGE ───────────────────────────────────────────────
$sel.ParagraphFormat.Alignment = 1  # Center

TypePara; TypePara; TypePara; TypePara

$sel.Font.Name = "Cambria"
$sel.Font.Size = 13
TypeText("DOKUMENTASI SISTEM")
TypePara; TypePara

$sel.Font.Size = 28
$sel.Font.Bold = $true
TypeText("NESYEL CLARITE")
TypePara

$sel.Font.Size = 16
$sel.Font.Bold = $false
TypeText("Point of Sale System")
TypePara; TypePara

$sel.Font.Size = 11
TypeText("- - - - - - - - - - - - - - - - - - - - - - -")
TypePara; TypePara

$sel.Font.Size = 12
TypeText("Sistem Kasir Berbasis Web untuk Toko Skincare dan Makeup")
TypePara; TypePara

$sel.Font.Bold = $true
TypeText("Teknologi : ")
$sel.Font.Bold = $false
TypeText("Laravel 12  |  PHP 8.2  |  Bootstrap 5  |  MySQL")
TypePara; TypePara

$sel.Font.Size = 11
TypeText("- - - - - - - - - - - - - - - - - - - - - - -")
TypePara; TypePara; TypePara; TypePara; TypePara

$sel.Font.Size = 12
$sel.Font.Bold = $true
TypeText("Disusun oleh :")
TypePara
$sel.Font.Bold = $false
TypePara
TypeText("Nesya Kirani Nurroffi (Absen 27)")
TypePara
TypeText("XI PPLG-RPL 2 / Pengembangan Perangkat Lunak & Gim (PPLG)")
TypePara
TypeText("Kepala Program Keahlian: Pak Yaqub Hadi Permana")
TypePara
$sel.Font.Size = 10
$sel.Font.Color = 16711680 # Blue
TypeText("https://github.com/nsyakiraninurroffi/nesyel-clarite-pos")
$sel.Font.Color = -16777216 # Black
$sel.Font.Size = 12
TypePara; TypePara
$sel.Font.Size = 12
TypeText("2026")

# Reset
$sel.ParagraphFormat.Alignment = 0
$sel.Font.Name = "Calibri"
$sel.Font.Size = 11
$sel.Font.Bold = $false

# ── DAFTAR ISI ───────────────────────────────────────────────
PageBreak
H1("DAFTAR ISI")
$null = $doc.TablesOfContents.Add($sel.Range, $true, 1, 3)
TypePara

# ── PENDAHULUAN ──────────────────────────────────────────────
PageBreak
H1("Pendahuluan")

H2("Latar Belakang")
Para("NESYEL CLARITE POS adalah sistem Point of Sale berbasis web yang dirancang untuk membantu operasional toko skincare dan makeup secara digital. Sistem ini menggantikan pencatatan penjualan manual dengan solusi terintegrasi yang mencakup manajemen produk, proses transaksi real-time, dan analitik penjualan.")

H2("Tujuan Sistem")
Bullet("Mempermudah proses transaksi penjualan di kasir")
Bullet("Mengelola stok produk skincare dan makeup secara terpusat")
Bullet("Menyajikan data penjualan dalam bentuk dashboard analitik")
Bullet("Menyimpan riwayat transaksi secara permanen di database")

H2("Teknologi yang Digunakan")
Bullet("Backend   : Laravel 12 (PHP 8.2)")
Bullet("Frontend  : Blade Template, Bootstrap 5.3, Vanilla JavaScript")
Bullet("Grafik    : Chart.js (Line Chart dan Doughnut Chart)")
Bullet("Notifikasi: SweetAlert2")
Bullet("Ikon      : Font Awesome 6")
Bullet("Font      : Poppins + Playfair Display (Google Fonts)")
Bullet("Database  : MySQL")

# ── MODUL-MODUL ──────────────────────────────────────────────

Module 1 "Autentikasi - Login" `
    "Buka browser, akses: http://localhost:8000/login" `
    "Halaman Login merupakan gerbang utama sistem NESYEL CLARITE POS. Hanya admin terdaftar yang dapat mengakses seluruh fitur sistem. Form login dilengkapi validasi input dan proteksi CSRF token untuk keamanan data." `
    @(
        "Form login dengan validasi email dan password",
        "Menampilkan logo dan nama brand NESYEL CLARITE",
        "Link navigasi ke halaman Register dan Lupa Password",
        "Proteksi route: user yang belum login otomatis diarahkan ke halaman ini",
        "Notifikasi error jika email atau password salah"
    )

Module 2 "Autentikasi - Register" `
    "Buka browser, akses: http://localhost:8000/register" `
    "Halaman Register memungkinkan pembuatan akun admin baru. Form pendaftaran dilengkapi validasi lengkap untuk memastikan integritas data pengguna sebelum tersimpan ke database." `
    @(
        "Form pendaftaran: nama, email, password, konfirmasi password",
        "Validasi sisi server untuk seluruh field input",
        "Password wajib dikonfirmasi sebelum tersimpan",
        "Redirect otomatis ke dashboard setelah berhasil mendaftar"
    )

Module 3 "Dashboard Analitik" `
    "Setelah login, akses: http://localhost:8000/dashboard" `
    "Dashboard adalah pusat kendali sistem NESYEL CLARITE POS. Halaman ini menampilkan ringkasan performa penjualan secara real-time, dilengkapi visualisasi data interaktif untuk membantu admin dalam mengambil keputusan bisnis." `
    @(
        "Kartu Statistik: Total Pendapatan Hari Ini",
        "Kartu Statistik: Jumlah Transaksi Hari Ini",
        "Kartu Statistik: Total Barang Terjual Hari Ini",
        "Kartu Statistik: Produk dengan Stok Hampir Habis (kurang dari 5 unit)",
        "Grafik Line Chart: Pendapatan 7 Hari Terakhir menggunakan Chart.js",
        "Daftar Top 5 Produk Terlaris dengan gambar dan kategori",
        "Doughnut Chart: Distribusi penjualan per kategori produk",
        "Animasi counter-up pada angka statistik saat halaman dimuat"
    )

Module 4 "Kasir (Point of Sale)" `
    "Klik menu Kasir di navbar, akses: http://localhost:8000/transaksi" `
    "Halaman Kasir adalah inti operasional sistem POS ini. Admin dapat memilih produk, mengelola keranjang belanja, dan memproses transaksi secara real-time tanpa reload halaman, dilengkapi fitur search dan filter produk." `
    @(
        "Grid tampilan produk: gambar, nama, harga, dan stok",
        "Filter kategori: Skincare, Makeup, Bodycare, Aksesoris, Lainnya",
        "Filter urutan: Termurah, Termahal, Ada Stok",
        "Search bar real-time untuk pencarian nama produk",
        "Efek animasi pulse glow saat produk ditambahkan ke keranjang",
        "Keranjang belanja sticky di kanan layar dengan update real-time",
        "Tombol plus/minus untuk mengubah kuantitas item di keranjang",
        "Proses transaksi dengan konfirmasi popup dan loading spinner",
        "Pengurangan stok otomatis di database setelah transaksi berhasil",
        "Reload produk otomatis via AJAX setelah transaksi selesai"
    )

Module 5 "Cetak Struk" `
    "Di halaman Kasir, selesaikan transaksi, lalu klik tombol Cetak Struk" `
    "Fitur Cetak Struk memungkinkan admin mencetak bukti transaksi langsung dari browser tanpa software tambahan. Struk diformat dalam layout kasir standar menggunakan CSS Print khusus." `
    @(
        "Header struk: logo dan nama NESYEL CLARITE",
        "Daftar produk yang dibeli beserta kuantitas dan subtotal",
        "Tanggal dan waktu transaksi ditampilkan otomatis",
        "Grand total di bagian bawah struk",
        "Print CSS: hanya area struk yang dicetak, elemen lain tersembunyi",
        "Ukuran cetak optimal lebar 300px, standar printer thermal kasir"
    )

Module 6 "Manajemen Produk - Daftar Produk" `
    "Klik menu Produk di navbar, akses: http://localhost:8000/barang" `
    "Halaman Daftar Produk menampilkan semua produk yang terdaftar dalam sistem secara tabular. Admin dapat melihat informasi lengkap setiap produk dan mengakses aksi edit atau hapus dengan mudah." `
    @(
        "Tabel produk: gambar, nama, kategori, harga, dan stok",
        "Tombol Edit per baris untuk navigasi ke form edit",
        "Tombol Hapus per baris dengan konfirmasi SweetAlert2",
        "Notifikasi toast sukses setelah aksi tambah, edit, atau hapus",
        "Tombol Tambah Produk di bagian atas untuk navigasi ke form tambah"
    )

Module 7 "Manajemen Produk - Tambah Produk" `
    "Di halaman Produk, klik tombol Tambah Produk" `
    "Form Tambah Produk memungkinkan admin menambahkan produk baru ke dalam sistem. Form dilengkapi validasi lengkap dan fitur upload gambar produk yang tersimpan di server." `
    @(
        "Input: Nama Produk, Harga (Rupiah), Stok (unit), Kategori",
        "Upload gambar produk format JPEG, PNG, JPG, GIF, SVG maksimal 2MB",
        "Gambar tersimpan di folder public/images/ pada server",
        "Validasi server-side untuk semua field sebelum disimpan",
        "Dropdown pilihan kategori: Skincare, Makeup, Bodycare, Aksesoris, Lainnya",
        "Redirect kembali ke daftar produk setelah berhasil disimpan"
    )

Module 8 "Manajemen Produk - Edit Produk" `
    "Di halaman Produk, klik tombol Edit pada salah satu produk" `
    "Form Edit Produk memungkinkan admin memperbarui informasi produk yang sudah ada, termasuk mengganti gambar. Data lama ditampilkan otomatis di form sebagai nilai default." `
    @(
        "Form pre-filled dengan data produk yang sudah ada sebelumnya",
        "Opsi ganti gambar produk, gambar lama otomatis dihapus dari server",
        "Validasi server-side identik dengan form tambah produk",
        "Tombol Batal untuk kembali ke daftar tanpa menyimpan perubahan",
        "Notifikasi sukses setelah produk berhasil diperbarui"
    )

Module 9 "Riwayat Transaksi" `
    "Klik menu History di navbar, akses: http://localhost:8000/history" `
    "Halaman Riwayat Transaksi menampilkan seluruh rekap transaksi yang pernah dilakukan, diurutkan dari yang terbaru. Admin dapat memantau semua aktivitas penjualan dan mengakses detail per transaksi." `
    @(
        "Daftar semua transaksi: nomor ID, tanggal dan waktu, total pembayaran",
        "Diurutkan dari transaksi terbaru secara descending",
        "Tombol Lihat Detail per transaksi untuk melihat rincian produk",
        "Total transaksi ditampilkan dalam format Rupiah",
        "Empty state informatif jika belum ada transaksi tersimpan"
    )

Module 10 "Detail Transaksi" `
    "Di halaman History, klik tombol Lihat Detail pada salah satu transaksi" `
    "Detail Transaksi menampilkan rincian lengkap dari satu transaksi dalam modal popup. Admin dapat melihat produk, kuantitas, harga satuan, subtotal, dan grand total tanpa meninggalkan halaman." `
    @(
        "Popup modal dengan tabel: Produk, Harga Satuan, Qty, Subtotal",
        "Grand total transaksi ditampilkan di bagian bawah popup",
        "Data diambil secara AJAX dari server tanpa reload halaman",
        "Handle produk yang sudah dihapus dengan label Barang Dihapus",
        "Desain modal responsif dan konsisten dengan sistem keseluruhan"
    )

Module 11 "Profil Admin" `
    "Klik nama user di navbar kanan atas, lalu klik Profile" `
    "Halaman Profil Admin memungkinkan admin mengelola informasi akunnya sendiri, termasuk memperbarui nama, email, dan mengganti password kapan saja." `
    @(
        "Avatar inisial dinamis berupa huruf pertama nama dengan gradient warna",
        "Form edit: Nama Lengkap dan Email Address",
        "Ganti password bersifat opsional, biarkan kosong jika tidak ingin ganti",
        "Konfirmasi password baru wajib diisi sebelum disimpan",
        "Validasi server-side untuk semua perubahan data",
        "Notifikasi sukses setelah profil berhasil diperbarui"
    )

Module 12 "Dark Mode" `
    "Klik ikon bulan di pojok kanan navbar untuk mengaktifkan Dark Mode" `
    "Fitur Dark Mode memberikan kenyamanan visual bagi admin yang bekerja di lingkungan pencahayaan rendah. Mode ini dapat diaktifkan dan dinonaktifkan kapan saja dengan satu klik." `
    @(
        "Toggle icon bulan atau matahari di navbar kanan atas",
        "Palet warna dark: deep purple (#1e1823) dan mocha (#2d2435)",
        "Semua komponen menyesuaikan otomatis: kartu, tabel, form, navbar",
        "Preferensi mode tersimpan di localStorage browser",
        "Transisi halus 0.3 detik antar mode terang dan gelap",
        "Persisten: mode tidak hilang setelah refresh atau buka tab baru"
    )

Module 13 "Laporan Pendapatan Harian & Export Excel" `
    "Klik menu Laporan di navbar, akses: http://localhost:8000/laporan" `
    "Halaman Laporan menyajikan analitik pendapatan berdasarkan rentang tanggal yang dapat di-filter. Admin dapat melihat ringkasan performa dan mengekspor data ke format Excel untuk kebutuhan pelaporan." `
    @(
        "Filter tanggal: Tanggal Mulai dan Tanggal Akhir",
        "Quick Filters: shortcut untuk melihat laporan Hari Ini, Kemarin, 7 Hari, 30 Hari, dan Bulan Ini",
        "Summary Cards: Total Pendapatan, Jumlah Transaksi, Item Terjual, Rata-rata per Hari",
        "Bar Chart: Visualisasi pendapatan harian jika rentang tanggal lebih dari 1 hari",
        "Tabel Detail: Daftar transaksi dengan row produk yang bisa di-expand (collapsible)",
        "Export Excel: Download otomatis data tabel ke file Native Excel (.xls) berformat rapi lengkap dengan Grand Total"
    )

# ── KESIMPULAN ───────────────────────────────────────────────
PageBreak
H1("Kesimpulan")
Para("Sistem NESYEL CLARITE POS merupakan solusi kasir berbasis web yang dirancang untuk memenuhi kebutuhan operasional toko skincare dan makeup modern. Dengan menggunakan framework Laravel 12, sistem ini berhasil mengintegrasikan fitur autentikasi, manajemen produk, proses transaksi real-time, dan analitik penjualan dalam satu platform yang mudah digunakan.")
Para("Desain antarmuka yang mengadopsi prinsip glassmorphism, dark mode, dan micro-animation menjadikan pengalaman pengguna terasa premium dan modern. Sistem ini siap digunakan untuk membantu toko dalam mencatat transaksi, memantau stok, dan menganalisis performa penjualan secara efisien.")

# ── UPDATE TOC ───────────────────────────────────────────────
try {
    $doc.TablesOfContents.Item(1).Update()
} catch {
    Write-Host "TOC update skipped" -ForegroundColor DarkGray
}

# ── SAVE ─────────────────────────────────────────────────────
Write-Host "Saving to: $outputPath" -ForegroundColor DarkCyan
try {
    $doc.SaveAs2($outputPath, 16)
    Write-Host "Save successful!" -ForegroundColor Green
} catch {
    # Fallback: save without format specifier
    Write-Host "Trying fallback save..." -ForegroundColor Yellow
    try {
        $doc.SaveAs($outputPath)
        Write-Host "Fallback save successful!" -ForegroundColor Green
    } catch {
        # Last resort: save to project folder
        $fallback = "d:\laravel-POS\Dokumentasi_NesyelClarite_POS.docx"
        Write-Host "Saving to project folder: $fallback" -ForegroundColor Yellow
        $doc.SaveAs2($fallback, 16)
        Write-Host "Saved to project folder!" -ForegroundColor Green
        $outputPath = $fallback
    }
}

$doc.Close($false)
$word.Quit()
$null = [System.Runtime.Interopservices.Marshal]::ReleaseComObject($word)

Write-Host ""
Write-Host "DONE! File tersimpan di:" -ForegroundColor Green
Write-Host "   $outputPath" -ForegroundColor Cyan
Write-Host ""
Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
Write-Host "   1. Buka file Word di lokasi tersebut" -ForegroundColor White
Write-Host "   2. Isi [Nama Lengkap], [NIM], [Institusi] di cover page" -ForegroundColor White
Write-Host "   3. Klik teks placeholder abu-abu >> di setiap modul" -ForegroundColor White
Write-Host "      Hapus teksnya, lalu Insert > Pictures > pilih file screenshot" -ForegroundColor White
Write-Host "   4. File > Export > Create PDF/XPS untuk export ke PDF" -ForegroundColor White
