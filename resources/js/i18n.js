import {
    nextTick
} from 'vue'
import {
    createI18n
} from 'vue-i18n'

export const SUPPORT_LOCALES = ['en']

export function setupI18n(options) {
    const i18n = createI18n(options)
    setI18nLanguage(i18n.global, options.locale, i18n.mode)
    for (let locale of SUPPORT_LOCALES) {
        loadLocaleMessages(i18n.global, locale)
    }
    return i18n
}

export function setI18nLanguage(i18n, locale, mode = 'legacy') {
    if (mode === 'legacy') {
        i18n.locale = locale
    } else {
        i18n.locale.value = locale
    }
    /**
     * NOTE:
     * If you need to specify the language setting for headers, such as the `fetch` API, set it here.
     * The following is an example for axios.
     *
     * axios.defaults.headers.common['Accept-Language'] = locale
     */
    document.querySelector('html').setAttribute('lang', locale)
}

export async function loadLocaleMessages(i18n, locale) {
    // load locale messages with dynamic import
    const messages = await import( /* webpackChunkName: "locale-[request]" */ `./../locales/${locale}.json`)
    // set locale and locale message
    i18n.setLocaleMessage(locale, messages.default)
    return nextTick()
}
