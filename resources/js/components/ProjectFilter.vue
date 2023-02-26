<script>
    import { store } from '@/store'

    export default{
        data(){
            return {
                store
            }
        }
    }
</script>

<template>
    <select class="mb-6 w-full p-4 border rounded-lg" v-model="store.activeProject">
        <option v-for="project in store.projects" :key="project">
            {{ project }}
        </option>
    </select>
</template>
