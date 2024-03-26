<script setup lang="ts">
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import BreezeButton from '@/Components/Button.vue';
import BreezeLinkButton from '@/Components/LinkButton.vue';
import ConfirmationDialog from '@/Components/HandleConfirm.vue';
import SuccessFlash from '@/Components/Success.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { RefreshCw } from 'lucide-vue-next';
import axios from 'axios';
import { route } from 'ziggy-js';
import { IUser, IPagination, ISharedProps } from '@/interfaces'
import {ref} from 'vue';

defineProps<{
	users: IPagination<IUser>;
}>();

const user = ref<IUser>()
const page = usePage<ISharedProps>();

async function banSwitchUser(userId: number) {
	await axios.post(route('admin.users.ban'), {
		user_id: userId,
	});
	Inertia.reload({ only: ['users', 'flash']});
}

const confirm = ref<typeof ConfirmationDialog>()

function openModal(selectedUser: IUser) {
    user.value = selectedUser
    confirm.value?.openModal(`Are you sure you want to ${selectedUser.active ? 'block' : 'unblock'} this user?`)
}

function cancel() {
    user.value = undefined;
    confirm.value?.closeModal();
}

function ban() {
    if (user.value?.id)
        banSwitchUser(user.value.id);
    user.value = undefined;
    confirm.value?.closeModal();
}


</script>

<template>
	<Head title="Users" />

	<BreezeAuthenticatedLayout>
		<template #header>
			<div class="grid grid-cols-2 grid-flow-col">
				<h2 class="col-span-2 font-semibold text-xl text-gray-800 leading-tight">
					Users
				</h2>
				<Link :href="route('admin.users')" :only="['users']">
				<RefreshCw />
				</Link>
			</div>
		</template>
		<div class="py-12">
            <ConfirmationDialog ref="confirm" message="" @confirm="ban" @cancel="cancel" />
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200 relative overflow-x-auto">
                        <SuccessFlash :success="page.props.value?.flash?.success || ''" />
						<table class="w-full text-sm text-left rtl:text-right">
							<thead class="text-xs uppercase ">
								<tr class="bg-white border-b">
									<th scope="col" class="px-6 py-3">#</th>
									<th scope="col" class="px-6 py-3">Name</th>
									<th scope="col" class="px-6 py-3">Email</th>
									<th scope="col" class="px-6 py-3">Role</th>
									<th scope="col" class="px-6 py-3">Status</th>
									<th scope="col" class="px-6 py-3">Action</th>
								</tr>
							</thead>
							<tbody>
								<tr class="bg-white border-b" v-for="u in users.data" :key="u.id">
									<td class="px-6 py-4">{{ u.id }}</td>
									<td class="px-6 py-4">{{ u.name }}</td>
									<td class="px-6 py-4">{{ u.email }}</td>
									<td class="px-6 py-4">{{ u.role.toUpperCase() }}</td>
									<td class="px-6 py-4">{{ u.active ? 'ACTIVE' : 'BANNED' }}</td>
									<td class="px-6 py-4 ">
										<BreezeLinkButton :href="route('admin.users.quotes', u.id)" class="mr-2">Quotes
										</BreezeLinkButton>
                                        <!-- confirm -->
                                        <BreezeButton @click="openModal(u)"> {{ u.active ? "Block" : "Unblock" }}
										</BreezeButton>
										<!-- <BreezeButton @click="banSwitchUser(u.id)"> {{ u.active ? "Ban" : "Unban" }}
										</BreezeButton> -->
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="p-3 flex justify-center">
						<Pagination :links="users.links" />
					</div>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>