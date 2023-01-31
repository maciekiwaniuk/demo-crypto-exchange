import { mount } from '@vue/test-utils';
import Cryptocurrencies from '../../../../frontend/pages/admin/Cryptocurrencies/Cryptocurrencies.vue';

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

