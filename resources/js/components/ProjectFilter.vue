<script setup lang="ts">
import {useProjectListStore} from '../stores/useProjectListStore'
import {computed, onMounted} from "vue";

const store = useProjectListStore();

const projects = computed(() => {
    return store.projects;
});

const emit = defineEmits(['emittedProject']);

function changedProject() {
    emit('emittedProject')
}

onMounted(() => {
    store.fetchProjects();
});



</script>

<template>
    <h1 class="text-lg font-bold text-gray-800 flex items-center gap-2">
        <span>
            Projects
        </span>
        <span
            class="w-6 h-6 flex items-center justify-center rounded-xl text-sm font-semibold  bg-primary/10 text-cyan-900">
            {{ store.projects.length - 1 }}
        </span>
    </h1>
    <select class="mb-6 w-full p-4 border rounded-lg" v-model="store.selectedProject" v-on:change="changedProject()">
        <option v-for="project in projects" :key="project.id" :value="project">
            {{ project.name }}
        </option>
    </select>
</template>
