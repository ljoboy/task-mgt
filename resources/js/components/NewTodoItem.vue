<script setup lang="ts">

    import {useTaskListStore} from "../stores/useTaskListStore";
    import {useProjectListStore} from "../stores/useProjectListStore";
    import {ref} from "vue";

    const store = useTaskListStore();
    const projectStore = useProjectListStore()
    let title = ref("");

    const addTask = () => {
        store.addTask(projectStore.selectedProject.id, title.value)
        title.value = "";
    }

</script>

<template>
    <form v-if="store.isActive && (projectStore.selectedProject.id !== 0)" class="p-3 bg-white rounded-xl" @submit.prevent="addTask()">
        <input class="w-full rounded-md p-4 bg-white border border-gray-300/50" placeholder="What's your new task ?" type="text" v-model="title">
        <div class="mt-3 grid grid-cols-2 gap-3">
            <button class="py-1.5 px-3 text-sm rounded bg-gray-600 border border-transparent text-white" type="submit">Add</button>
            <button @click="store.isActive = !store.isActive" class="py-1.5 px-3 text-sm rounded bg-white border border-gray-300 text-gray-600">Cancel</button>
        </div>
    </form>
</template>
