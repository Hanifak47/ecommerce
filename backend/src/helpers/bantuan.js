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

