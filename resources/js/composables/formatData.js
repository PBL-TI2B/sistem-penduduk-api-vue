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


export const formatDate = (value, withTime = true, withDayName = false) => {
    if (value == null || value === '') return '-';
    const date = new Date(value);
    const tanggal = date.getDate();
    const bulan = date.toLocaleDateString('id-ID', { month: 'long' });
    const tahun = date.getFullYear();
    const hari = withDayName ? date.toLocaleDateString('id-ID', { weekday: 'long' }) + ', ' : '';
    const waktu = withTime ? ' ' + date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '';
    return `${hari}${tanggal} ${bulan} ${tahun}${waktu}`;
};
