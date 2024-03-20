declare module '*.vue' {
    import { defineComponent } from 'vue';
    const component: ReturnType<typeof defineComponent>;
    export default component;
}

declare module 'mdb4-vue/lib/components/mdbBtn';
declare module 'mdb4-vue/lib/components/mdbRow';
declare module 'mdb4-vue/lib/components/mdbCol';
declare module 'mdb4-vue/lib/components/mdbModal';
declare module 'mdb4-vue/lib/components/mdbModalBody';
declare module 'mdb4-vue/lib/components/mdbModalTitle';
declare module 'mdb4-vue/lib/components/mdbModalHeader';
declare module 'mdb4-vue/lib/components/mdbModalFooter';
declare module 'mdb4-vue/lib/components/mdbBtnGroup';
