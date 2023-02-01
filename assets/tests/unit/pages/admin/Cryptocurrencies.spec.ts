import { mount } from '@vue/test-utils';
import Cryptocurrencies from '../../../../frontend/pages/admin/Cryptocurrencies/Cryptocurrencies.vue';
import { expect } from '@jest/globals';

describe('Admin - Cryptocurrencies', () => {
    const wrapper = mount(Cryptocurrencies, {
        global: {
            provide: {
                '$swal': {}
            }
        }
    });

    it('renders', () => {
        expect(wrapper.text()).toContain('Cryptocurrencies');
    });
});

