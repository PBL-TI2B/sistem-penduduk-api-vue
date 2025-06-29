export const formatCurrency = (value) => {
    if (value == null || value === '') return '-';
    return new Number(value).toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        // minimumFractionDigits: 2
        // maximumFractionDigits: 5
    });
};


export const formatDate = (value, withTime = true, withDayName = false, withSeconds = false) => {
    if (value == null || value === '') return '-';
    const date = new Date(value);
    const tanggal = date.getDate();
    const bulan = date.toLocaleDateString('id-ID', { month: 'long' });
    const tahun = date.getFullYear();
    const hari = withDayName ? date.toLocaleDateString('id-ID', { weekday: 'long' }) + ', ' : '';
    let waktu = ' ';
    if (withTime) {
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        waktu = ` - ${hours}:${minutes}`;
        if (withSeconds) {
            const seconds = date.getSeconds().toString().padStart(2, '0');
            waktu += `:${seconds}`;
        }
    }
    return `${hari}${tanggal} ${bulan} ${tahun} ${waktu}`;
};
