import axios from 'axios';
import cookies from 'vue-cookies';

const JWToken = `${JSON.parse(cookies.get('TOKEN')) ?? ''}`

export const axiosInstance = axios.create({
    baseURL: 'http://localhost:8000/',
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Authorization': JWToken
    },
});

