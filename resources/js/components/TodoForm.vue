<script setup lang="ts">

import {useTaskListStore} from "../stores/useTaskListStore";
import {useProjectListStore} from "../stores/useProjectListStore";
import {PropType, ref, watch} from "vue";
import {TaskItem} from "../types/taskItem";

const store = useTaskListStore();
const projectStore = useProjectListStore()
const emit = defineEmits(['update:propValue']);

const props = defineProps({
    task: {
        type: Object as PropType<TaskItem> | null,
        default: null,
    }
});

const name = ref(props.task?.name);
watch(
    () => props.task?.name,
    (inputedName) => {
        name.value = inputedName;
    }
);

watch(
    name,
    (inputedName) => {
        if (inputedName !== props.task?.name) {
            emit('update:propValue', inputedName);
        }
    }
);

const submit = () => {
    if (!props.task) {
        store.addTask(projectStore.selectedProject.id, name.value);
    } else {
        store.editTask(projectStore.selectedProject.id, props.task, name.value);
    }
    name.value = "";
    store.isActive = !store.isActive;
}
</script>

<template>
    <form
        v-if="store.isActive && (projectStore.selectedProject.id !== 0)"
        class="p-3 bg-white rounded-xl"
        @submit.prevent="submit()"
    >
        <input class="w-full rounded-md p-4 bg-white border border-gray-300/50" placeholder="What's your new task ?"
               type="text" v-model="name"/>
        <div class="mt-3 grid grid-cols-2 gap-3">
            <button class="py-1.5 px-3 text-sm rounded bg-gray-600 border border-transparent text-white" type="submit">
                {{ props.task ? 'Edit' : 'Add' }}
            </button>
            <button @click="store.isActive = !store.isActive"
                    class="py-1.5 px-3 text-sm rounded bg-white border border-gray-300 text-gray-600">Cancel
            </button>
        </div>
    </form>
</template>
