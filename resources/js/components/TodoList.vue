<script setup lang="ts">

import {nextTick, onMounted, ref} from "vue";
import {useTaskListStore} from "../stores/useTaskListStore";
import {useProjectListStore} from "../stores/useProjectListStore";
import TodoItem from "./TodoItem.vue";
import ProjectFilter from "./ProjectFilter.vue";
import {TaskItem} from "../types/taskItem";
import TodoForm from "./TodoForm.vue";
import {VueDraggableNext} from "vue-draggable-next";

const store = useTaskListStore();
const projectStore = useProjectListStore();
const taskEmitted = ref<TaskItem>();

const getProjectTasks = () => {
    if (projectStore.selectedProject.id != 0) {
        store.fetchProjectTasks(projectStore.selectedProject.id);
    } else {
        store.fetchTasks();
    }

}

const getEmittedTask = (task: TaskItem) => {
    taskEmitted.value = task;
}

const formActivation = () => {
    store.isActive = !store.isActive;
    taskEmitted.value = null;
}

const todoRef = ref(null);

async function scrollToForm() {
    const target = todoRef.value;
    if (target && store.isActive) {
        await nextTick();
        target.$el.scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
    }
}

let isDragging = ref(false);

const updateTaskOrder = (item) => {
    if (isDragging.value) {
        const movedTask =  item.moved.element;
        const newPriority = item.moved.newIndex + 1;
        store.updateTaskOrder(projectStore.selectedProject.id, movedTask, newPriority);
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
            <button v-if="projectStore.selectedProject.id !== 0" @click="formActivation()"
                    class="p-2 rounded-xl transition duration-300 hover:bg-gray-300/40 focus:bg-gray-300/40 active:bg-gray-300/60">
                <span class="sr-only">Add new task</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
            </button>
        </div>
        <todo-form
            :task="taskEmitted"
            ref="todoRef"
        />
        <vue-draggable-next
            :list="store.tasks"
            :disabled="projectStore.selectedProject.id === 0"
            @start="isDragging = true"
            @end="isDragging = false"
            @change="updateTaskOrder"
            class="space-y-3"
        >
            <transition-group type="transition">
                <todo-item
                    v-for="task in store.tasks"
                    :key="task.priority"
                    :task="task"
                    @emitted-task="getEmittedTask"
                    v-on:click="scrollToForm"
                    :class="projectStore.selectedProject.id !== 0 ? 'cursor-grab' : 'cursor-no-drop'"
                />
            </transition-group>
        </vue-draggable-next>
    </div>
</template>
