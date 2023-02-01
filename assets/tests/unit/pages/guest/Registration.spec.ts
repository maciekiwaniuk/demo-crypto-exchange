import { mount } from '@vue/test-utils';
import Registration from '../../../../frontend/pages/guest/Registration/Registration.vue';
import { router } from "../../../../frontend/router/router";
import { createTestingPinia } from '@pinia/testing';
import { expect } from '@jest/globals';

describe('Guest - Registration', () => {
    const wrapper = mount(Registration, {
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
        expect(wrapper.text()).toContain('Registration');
    });
});

