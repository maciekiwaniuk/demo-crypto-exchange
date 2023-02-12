import { mount } from '@vue/test-utils';
import Security from '../../../../frontend/pages/user/Security/Security.vue';
import { expect } from '@jest/globals';

describe('User - Security', () => {
    const wrapper = mount(Security);

    it('renders', () => {
        expect(wrapper.text()).toContain('Security');
    });
});

