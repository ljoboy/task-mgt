<script>
    import TodoItem from "@/components/TodoItem.vue"
    import NewTodoItem from "@/components/NewTodoItem.vue"
    import ProjectFilter from "@/components/ProjectFilter.vue"
    import { store } from '@/store'

    export default {
        components: {
            TodoItem,
            NewTodoItem,
            ProjectFilter
        },
        data(){
            return {
                store
            }
        },
    };
</script>

<template>
    <project-filter />
    <div class="space-y-3 rounded-3xl bg-gray-100 border border-gray-300/30 p-3">
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <span class="w-6 h-6 flex items-center justify-center rounded-xl text-sm font-semibold  bg-primary/10 text-cyan-900">
                    {{store.todoItems.length}}
                </span>
                <span>
                    Task<span v-if="store.todoItems.length > 1">s</span>
                </span>
            </h1>
            <button @click="store.isActive = !store.isActive" class="p-2 rounded-xl transition duration-300 hover:bg-gray-300/40 focus:bg-gray-300/40 active:bg-gray-300/60">
                <span class="sr-only">Add new task</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </div>
        <new-todo-item />
        <todo-item
            v-for="todoItem in store.todoItems"
            :key="todoItem.id"
            :title="todoItem.title"
        />
    </div>
</template>
