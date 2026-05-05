import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';   // no Inertia here
import { Inertia } from '@inertiajs/inertia';         // import Inertia here
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import LanguageToggle from './Components/LanguageToggle.vue';
import { installI18n, translatePage } from './i18n';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        Inertia.on('navigate', () => {
            window.scrollTo(0, 0);
            document.body.style.overflow = 'auto';
            document.documentElement.style.overflow = 'auto';
            translatePage();
        });

        const vueApp = createApp({
            render: () => h('div', [
                h(App, props),
                h(LanguageToggle),
            ]),
        });

        installI18n(vueApp);

        const mountedApp = vueApp
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);

        translatePage();

        return mountedApp;
    },
    progress: {
        color: '#4B5563',
    },
});
