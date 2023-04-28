export default function currencyBR(value) {
    return new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BR'}).format(value);
}