<script setup lang="ts">
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Pagination from '@/Components/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Trash2, RefreshCw } from 'lucide-vue-next';
import axios from 'axios';
import { route } from 'ziggy-js';
import { IPagination, IQuote } from '@/interfaces';

interface Props {
  quotes: IPagination<IQuote>;
}

defineProps<Props>();

async function deleteQuote(quoteId: number) {
  await axios.delete(route('favorite-quotes'), {
    data: {
      id: quoteId,
    },
  });
  Inertia.reload({ only: ['quotes'] });
}
</script>

<template>
    <Head title="Favorite Quotes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2 grid-flow-col">
                <h2 class="col-span-2 font-semibold text-xl text-gray-800 leading-tight">
                    Favorite Quotes
                </h2>
                <Link href="/favorite-quotes" :only="['quotes']">
                <RefreshCw />
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div v-for="q in quotes.data" class="grid grid-cols-2 grid-flow-col p-2 rounded border my-2">
                            <div class="col-span-2">{{ q.quote }} - {{ q.author }}</div>
                            <div class="cursor-pointer">
                                <Trash2 @click="deleteQuote(q.quote_id)"/>
                            </div>
                        </div>
                        <div v-if="!quotes.data.length">
                            Not found
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