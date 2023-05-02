export function toCurrency(val) {
    let value = val;
    if (!Number.isInteger(val)) value = parseInt(value.replace(/\s/g, ''));
    if (Number.isNaN(value)) return val;

    const formatter = new Intl.NumberFormat("cs-CZ", {
        style: "currency",
        currency: "CZK",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });

    return formatter.format(value);
}
