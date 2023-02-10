import { mount } from '@vue/test-utils';
import Account from '../../../../frontend/pages/user/Account/Account.vue';
import { expect } from '@jest/globals';

describe('User - Account', () => {
    const wrapper = mount(Account);

    it('renders', () => {
        expect(wrapper.text()).toContain('Account');
    });
});

