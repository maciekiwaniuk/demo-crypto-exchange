import { useLoading } from 'vue-loading-overlay';

export const loading = useLoading({
    'width': 140,
    'height': 120,
    'color': 'blue',
    // @ts-ignore
    'background-color': '#00000066',
    'opacity': 0.4,
});