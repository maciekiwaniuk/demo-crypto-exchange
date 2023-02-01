import { mount } from '@vue/test-utils';
import Home from '../../../../frontend/pages/general/Home.vue';
import { expect } from '@jest/globals';

describe('General - Home', () => {
    const wrapper = mount(Home);

    it('renders', () => {
        expect(wrapper.text()).toContain('home page');
    });
});

