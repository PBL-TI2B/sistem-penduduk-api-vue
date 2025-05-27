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

export const formatDate = (value, withTime = true) => {
    if (value == null || value === '') return '-';
    return new Date(value).toLocaleString('id-ID', {
        dateStyle: 'medium',
        ...(withTime ? { timeStyle: 'short' } : {})
    });
};
