<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';
import BreezeButton from "@/Components/PrimaryButton.vue";
import { Inertia } from '@inertiajs/inertia';
import PrimaryButton from "@/Components/PrimaryButton.vue";
const props = defineProps({
    tasks: Object,
    can: Object,
});


function destroy(id) {
    Inertia.delete(route('tasks.destroy',id),{
        onBefore: () => confirm('Are you sure you want to delete ? '),

    })
}

</script>

<template>

    <Head title="Tasks" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tasks List
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" >
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4" v-if="$page.props.can.createTask">
                            <Link :href="route('tasks.create')" class="bg-green-500 hover:bg-green-700 text-white border border-transparent font-bold px-4 py-2 text-xs uppercase tracking-widest rounded-md">
                                Create
                            </Link>
                        </div>
                        <div class="min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left w-10">
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left" >
                                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-full">Description</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left w-48">

                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                <tr class="bg-white" v-for="task in tasks" :key="task.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-900">
                                        {{task.id}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-900">
                                        {{task.description}}
                                    </td>
                                    <td class="space-x-2">
                                        <Link v-if="$page.props.can.editTask" :href="route('tasks.edit', task)" class="bg-green-500 hover:bg-green-700 text-white border border-transparent font-bold px-4 py-2 text-xs uppercase tracking-widest rounded-md">
                                            Edit
                                        </Link>
                                        <PrimaryButton v-if="$page.props.can.destroyTask" @click="destroy(task.id)">
                                            Delete
                                        </PrimaryButton>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
