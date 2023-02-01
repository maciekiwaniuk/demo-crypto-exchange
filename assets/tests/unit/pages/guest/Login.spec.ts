import { mount } from '@vue/test-utils';
import Login from '../../../../frontend/pages/guest/Login/Login.vue';
import { router } from "../../../../frontend/router/router";
import { createTestingPinia } from '@pinia/testing'
import { expect } from '@jest/globals';

describe('Guest - Login', () => {
    const wrapper = mount(Login, {
        global: {
            plugins: [
                router, createTestingPinia()
            ],
            provide: {
                '$swal': {}
            }
        },
    });


    it('renders', () => {
        expect(wrapper.text()).toContain('Login');
    });
});

