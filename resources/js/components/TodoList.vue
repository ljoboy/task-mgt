<script setup lang="ts">

import {onMounted} from "vue";
import {useTaskListStore} from "../stores/useTaskListStore";
import {useProjectListStore} from "../stores/useProjectListStore";
import TodoItem from "./TodoItem.vue";
import ProjectFilter from "./ProjectFilter.vue";
import NewTodoItem from "./NewTodoItem.vue";

const store = useTaskListStore();
const projectStore = useProjectListStore();

const getProjectTasks = () => {
    if (projectStore.selectedProject.id != 0) {
        store.fetchProjectTasks(projectStore.selectedProject.id);
    } else {
        store.fetchTasks();
    }

}

onMounted(() => {
    store.fetchTasks();
});
</script>

<template>
    <project-filter @emitted-project="getProjectTasks"/>
    <div class="space-y-3 rounded-3xl bg-gray-100 border border-gray-300/30 p-3">
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <span
                    class="w-6 h-6 flex items-center justify-center rounded-xl text-sm font-semibold  bg-primary/10 text-cyan-900">
                    {{ store.tasks.length }}
                </span>
                <span>
                    {{ projectStore.selectedProject.name }} Task<span v-if="store.tasks.length > 1">s</span>
                </span>
            </h1>
            <button v-if="projectStore.selectedProject.id !== 0" @click="store.isActive = !store.isActive"
                    class="p-2 rounded-xl transition duration-300 hover:bg-gray-300/40 focus:bg-gray-300/40 active:bg-gray-300/60">
                <span class="sr-only">Add new task</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
            </button>
        </div>
        <new-todo-item/>
        <todo-item
            v-for="task in store.tasks"
            :key="task.id"
            :id="task.id"
            :name="task.name"
            :priority="task.priority"
            :created_at="task.created_at"
        />
    </div>
</template>
