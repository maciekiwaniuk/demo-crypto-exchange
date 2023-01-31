import { mount } from '@vue/test-utils';
import Settings from '../../../../frontend/pages/user/Settings/Settings.vue';

describe('User - Settings', () => {
    const wrapper = mount(Settings);

    it('renders', () => {
        expect(wrapper.text()).toContain('Settings');
    });
});

