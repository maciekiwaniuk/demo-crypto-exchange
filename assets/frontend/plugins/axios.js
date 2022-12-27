import axios from 'axios';

const JWToken = `Bearer ${localStorage.getItem('token') ?? ''}`

export const axiosInstance = axios.create({
    baseURL: 'http://localhost:8000/',
    timeout: 1000,
    headers: {
        'Content-Type': 'application/json',
        'Authorization': JWToken
    },
});

