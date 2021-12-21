require('./bootstrap');

// Import modules...
import {createApp, h} from 'vue';
import {setupI18n} from './i18n';
import {createInertiaApp} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import moment from "moment";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, app, props, plugin}) {
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .mixin({methods: {route}})
            .use(setupI18n({
                locale: 'en',
                fallbackLocale: 'en'
            }))
            .mixin({
                created: function () {
                    this.moment = moment;
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({color: '#4B5563'});
