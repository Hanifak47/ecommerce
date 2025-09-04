// berisikan bantuan bantuan toolkit

export const toRupiah = (number) => {
    if (typeof number !== 'number') {
        return 'Invalid number';
    }
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0, // Mengabaikan desimal jika 0
    }).format(number);
};


// Menambahkan validasi dan perbaikan kecil
export const formatTanggal = (tanggalWaktu, tampilkanWaktu = true) => {
    const d = new Date(tanggalWaktu);

    // Validasi: periksa apakah objek Date valid
    if (isNaN(d.getTime())) {
        return 'Invalid Date';
    }

    const namaBulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const tanggal = d.getDate();
    const bulan = namaBulan[d.getMonth()];
    const tahun = d.getFullYear();

    // Perbaikan: gunakan array untuk format yang lebih rapi
    const bagianTanggal = [`${tanggal}`, bulan, `${tahun}`];

    // Periksa apakah waktu akan ditampilkan sebelum menambahkannya
    if (tampilkanWaktu) {
        const jam = String(d.getHours()).padStart(2, '0');
        const menit = String(d.getMinutes()).padStart(2, '0');
        const detik = String(d.getSeconds()).padStart(2, '0');
        bagianTanggal.push(`Pkl. ${jam}:${menit}:${detik}`);
    }

    // Gabungkan semua bagian menjadi satu string
    return bagianTanggal.join(' ');
};
