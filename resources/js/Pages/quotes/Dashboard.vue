
<script setup lang="ts">
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { IQuote } from '@/Interfaces';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { Heart, RefreshCw } from 'lucide-vue-next';
import { ref } from 'vue';
import { route } from 'ziggy-js';

interface Props {
  quotes: IQuote[];
  ratelimit: boolean;
}

defineProps<Props>();

const favorite = ref<Record<string, boolean>>({});

async function favoriteQuote(quote: IQuote) {
  try {
    await axios.post<void>(route('favorite-quotes'), quote);
    favorite.value[quote.id] = true;
  } catch (error) {
    console.error('Error favoriting quote:', error);
  }
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2 grid-flow-col">
                <h2 class="col-span-2 font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
              <Link href="/dashboard" :only="['quotes', 'ratelimit']"><RefreshCw /></Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                       <div v-if="ratelimit">
                        Too Many Attempts.
                       </div>
                       <div v-for="q in quotes" class="grid grid-cols-2 grid-flow-col p-2 rounded border my-2">
                        <div class="col-span-2">{{q.quote}} - {{ q.author }}</div>
                        <div class="cursor-pointer"><Heart :fill="favorite[q.id]? 'red': 'black'" strokeWidth={0} @click="favoriteQuote(q)"/></div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>