import axios from 'axios';
import { cookies } from './cookies';

const JWToken = JSON.parse(cookies.get('TOKEN')) ?? '';

export const axiosInstance = axios.create({
    baseURL: 'https://localhost:80/',
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Authorization': JWToken
    },
});
