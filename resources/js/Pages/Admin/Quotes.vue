<script setup lang="ts">
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import ConfirmationDialog from '@/Components/HandleConfirm.vue';
import SuccessFlash from '@/Components/Success.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { Trash2, RefreshCw } from 'lucide-vue-next';
import axios from 'axios';
import { route } from 'ziggy-js';
import { ref } from 'vue';
import { IUser, IQuote, IPagination, ISharedProps } from '@/interfaces'

const props = defineProps<{
    quotes: IPagination<IQuote>;
    user: IUser;
}>();
const page = usePage<ISharedProps>();

async function deleteQuote(quoteId: number) {
    await axios.delete(route('admin.users.quotes.delete'), {
        data: {
            quote_id: quoteId,
            user_id: props.user.id,
        },
    });
    Inertia.reload({ only: ['quotes', 'flash'] });
}

const confirm = ref<typeof ConfirmationDialog>()
const quote = ref<IQuote>()

function openModal(selectedQuote: IQuote) {
    quote.value = selectedQuote
    confirm.value?.openModal(`Are you sure you want to delete this resource?`)
}

function cancel() {
    quote.value = undefined;
    confirm.value?.closeModal();
}

function confirmDelete() {
    if (quote.value?.quote_id)
        deleteQuote(quote.value.quote_id);
    quote.value = undefined;
    confirm.value?.closeModal();
}


</script>

<template>
    <Head title="Favorite Quotes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2 grid-flow-col">
                <h2 class="col-span-2 font-semibold text-xl text-gray-800 leading-tight">
                    {{ user.name }}'s Favorite Quotes
                </h2>
                <Link :href="route('admin.users.quotes', user.id)" :only="['quotes']">
                <RefreshCw />
                </Link>
            </div>
        </template>
        <div class="py-12">
            <ConfirmationDialog ref="confirm" message="" @confirm="confirmDelete" @cancel="cancel" />
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <SuccessFlash :success="page.props.value?.flash?.success || ''" />
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div v-for="q in quotes.data" :key="q.id"
                            class="grid grid-cols-2 grid-flow-col p-2 rounded border my-2">
                            <div class="col-span-2">{{ q.quote }} - {{ q.author }}</div>
                            <div class="cursor-pointer">
                                <Trash2 @click="openModal(q)" />
                            </div>
                        </div>
                        <div v-if="!quotes.data.length">
                            No data found
                        </div>
                    </div>
                    <div class="p-3 flex justify-center">
                        <Pagination :links="quotes.links" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>