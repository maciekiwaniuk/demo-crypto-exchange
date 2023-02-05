import axios from 'axios';
import { cookies } from '../plugins/cookies';

const JWToken = `${JSON.parse(cookies.get('TOKEN')) ?? ''}`;

export const axiosInstance = axios.create({
    baseURL: 'http://127.0.0.1:8000/',
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Authorization': JWToken
    },
});

