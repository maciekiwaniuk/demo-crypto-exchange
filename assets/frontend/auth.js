import axios from './axios';
axios.defaults.headers.post['Content-Type'] = 'application/json';
import { createAuth } from '@websanova/vue-auth';
import driverAuthBearer from '@websanova/vue-auth/dist/drivers/auth/bearer.esm.js';
import driverHttpAxios from '@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js';
import driverRouterVueRouter from "@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js";
import { router } from './router';

export const auth = createAuth({
    plugins: {
        http: axios,
        router: router
    },
    drivers: {
        http: driverHttpAxios,
        auth: driverAuthBearer,
        router: driverRouterVueRouter
    },
    options: {
        loginData: {
            url: '/api/login_check',
            method: 'POST'
        },
        // refreshData: {
        //     // data: {
        //     //   refresh_token: 'test'
        //     // },
        //     method: "POST",
        //     url: "refresh_token",
        // },
    }
})