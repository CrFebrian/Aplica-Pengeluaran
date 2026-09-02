<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
    ];

    protected const ICON_MAP = [
        // ---- Pengeluaran ----
        'restaurant' => ['makan', 'minum', 'kopi', 'resto', 'kuliner', 'santap', 'warung', 'cafe', 'makanan', 'minuman', 'sarapan', 'makan siang', 'makan malam'],
        'fastfood' => ['fast food', 'burger', 'ayam geprek', 'pizza', 'kfc', 'mcd', 'nasi goreng', 'mie ayam', 'bakso', 'sate'],
        'local_cafe' => ['jajan', 'camilan', 'snack', 'cemilan', 'street food', 'angkringan', 'es teh', 'es kopi', 'es krim', 'jelly', 'boba'],
        'directions_car' => ['bensin', 'solar', 'bbm', 'bahan bakar', 'transport', 'ojek', 'grab', 'gojek', 'taxi', 'bus', 'kereta', 'parkir', 'tol'],
        'bolt' => ['listrik', 'pln'],
        'wifi' => ['internet', 'wifi', 'kuota', 'paket data'],
        'smartphone' => ['pulsa', 'telpon', 'telepon', 'provider', 'axis', 'telkomsel', 'indosat', 'xl'],
        'water_drop' => ['air', 'pdam', 'galon'],
        'local_fire_department' => ['gas', 'elpiji', 'tabung gas'],
        'home' => ['rumah', 'sewa', 'kontrakan', 'kos', 'kpr', 'rumah tangga', 'kebersihan', 'maintenance', 'perbaikan rumah'],
        'shopping_bag' => ['belanja', 'shopee', 'tokopedia', 'lazada', 'blibli', 'olshop', 'market', 'toko', 'minimarket', 'indomaret', 'alfamart', 'grosir'],
        'checkroom' => ['pakaian', 'baju', 'sepatu', 'fashion', 'sendal', 'celana', 'jaket', 'hoodie', 'kaos'],
        'movie' => ['hiburan', 'nonton', 'film', 'movie', 'netflix', 'spotify', 'game', 'streaming', 'konser', 'bioskop', 'youtube'],
        'medical_services' => ['kesehatan', 'obat', 'dokter', 'klinik', 'rumah sakit', 'apotek', 'rumkit', 'vitamin', 'berobat'],
        'school' => ['pendidikan', 'sekolah', 'kuliah', 'buku', 'kursus', 'bimbel', 'belajar', 'spp', 'les', 'uang sekolah', 'study'],
        'child_friendly' => ['bayi', 'anak', 'pampers', 'susu bayi', 'mainan anak', 'popok'],
        'pets' => ['hewan', 'peliharaan', 'kucing', 'anjing', 'pet', 'makanan kucing', 'vet'],
        'volunteer_activism' => ['sumbangan', 'donasi', 'zakat', 'infak', 'amal', 'sedekah', 'charity'],
        'fitness_center' => ['olahraga', 'gym', 'fitnes', 'lari', 'renang', 'badminton', 'futsal', 'sepak bola', 'senam'],
        'flight' => ['perjalanan', 'liburan', 'wisata', 'travel', 'tiket pesawat', 'hotel', 'tour', 'pantai', 'gunung', 'outbond'],
        'savings' => ['asuransi', 'bpjs', 'tabungan', 'investasi', 'saham', 'emas', 'reksadana', 'dana darurat', 'dividen', 'royalti', 'passive income', 'penghasilan pasif', 'penarikan', 'tarik tabungan', 'bunga bank'],
        'account_balance' => ['hutang', 'cicilan', 'pinjaman', 'kredit', 'angsuran', 'bayar hutang', 'blt', 'subsidi', 'pemerintah', 'kartu sembako', 'keringanan', 'bansos', 'bantuan sosial'],
        'receipt_long' => ['tagihan', 'utilitas', 'administrasi', 'subscription', 'langganan'],
        'paint' => ['alat tulis', 'kantor', 'sparepart', 'bahan', 'peralatan', 'elektronik', 'gadget', 'aksesoris', 'alat'],
        'local_police' => ['denda', 'pajak', 'tilang', 'retribusi', 'iuran', 'sumbangan wajib'],
        'card_giftcard' => ['hadiah', 'kado', 'oleh oleh', 'oleh-oleh', 'souvenir', 'bunga', 'undian', 'event', 'doorprize'],
        'person' => ['pribadi', 'personal', 'kebutuhan pribadi', 'pengeluaran lain', 'lainnya'],

        // ---- Pemasukan ----
        'payments' => ['gaji', 'upah', 'gawe', 'penghasilan', 'salary'],
        'work' => ['freelance', 'proyek', 'kontrak', 'honor', 'job', 'kerja', 'kuli', 'tukang'],
        'sell' => ['reseller', 'bisnis', 'usaha', 'dagang', 'jualan', 'jual', 'dropship', 'affiliate'],
        'redeem' => ['bonus', 'thr', 'tunjangan', 'insentif', 'prestasi', 'reward'],
        'family_restroom' => ['orang tua', 'ortu', 'keluarga', 'pemberian', 'kasih', 'ayah', 'ibu', 'orangtua', 'dari ortu'],
        'storefront' => ['kios', 'warung', 'toko sendiri', 'online shop'],
        'trending_up' => ['capital gain', 'untung', 'profit', 'laba', 'keuntungan'],
    ];

    /**
     * Menentukan ikon Material Symbols dari nama kategori berdasarkan kata kunci.
     * Fallback membedakan tipe: income -> payments, expense -> label.
     */
    public static function iconFor(string $name, ?string $type = null): string
    {
        $name = strtolower(trim($name));
        $name = str_replace(['-', '_'], ' ', $name);

        foreach (static::ICON_MAP as $icon => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($name, $keyword)) {
                    return $icon;
                }
            }
        }

        return $type === 'income' ? 'payments' : 'label';
    }

    /**
     * Konvenien: ambil ikon untuk instance kategori ini.
     */
    public function icon(): string
    {
        return static::iconFor($this->name, $this->type);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}