import axios from 'axios';
import cookies from 'vue-cookies';

const JWToken = `Bearer ${cookies.get('token') ?? ''}`

export const axiosInstance = axios.create({
    baseURL: 'http://localhost:8000/',
    timeout: 1000,
    headers: {
        'Content-Type': 'application/json',
        'Authorization': JWToken
    },
});

