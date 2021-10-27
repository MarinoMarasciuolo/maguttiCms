

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';

import DashboardComponent from '../components/admin/Dashboard/DashboardButtonsComponent'
import SideBarComponent  from './../components/admin/SideBar';
import SeoInputComponent from './../components/admin/SeoInputComponent';
import SeoTextComponent from './../components/admin/SeoTextComponent';
import ClearableInputComponent from './../components/admin/ClearableInputComponent';
import CopyableInputComponent from './../components/admin/CopyableInputComponent';
import GeneratorInputComponent from './../components/admin/GeneratorInputComponent';
import CheckboxGridComponent from '../components/admin/CheckBoxesGrid/CheckGridComponent';

import FileManagerGridComponent from '../components/admin/Filemanager/IndexComponent';

//import ListComponent from '../components/admin/ListComponent';

import languageBundle from '@kirschbaum-development/laravel-translations-loader!@kirschbaum-development/laravel-translations-loader';
import { createI18n } from 'vue-i18n'


const i18n = createI18n({
    locale: window._LANG, // set locale
    fallbackLocale: 'en', // set fallback locale
    messages: languageBundle,
    // If you need to specify other options, you can set other options
    // ...
})

import mitt from 'mitt'

window.emitterHub = mitt()

const app = createApp({
    components: {
        DashboardComponent,
        SideBarComponent,
        SeoInputComponent,
        SeoTextComponent,
        ClearableInputComponent,
        CopyableInputComponent,
        GeneratorInputComponent,
        CheckboxGridComponent,
        FileManagerGridComponent,

    }
});
app.use(i18n);
app.mount("#app");









/*





';


*/

