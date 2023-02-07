export function round (numberToRound: number | string, places: number) {
    return +(Math.round(Number(numberToRound + 'e+' + places))  + 'e-' + places);
}