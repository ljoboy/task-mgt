<script>
    import { store } from '@/store'

    export default {
        props : {
            title : {
                type : String,
                required : true,
                default : "Task name"
            }
        },
        data(){
            return{
                store
            }
        },
        methods : {
            removeTodoItem(){
                return store.todoItems.splice(this.index,1)
            },
            editTodoItem(){
                if(store.isActive !== store.isActive){
                    console.log('active')
                }else {
                    store.isActive = true
                    store.todoTitle = "hey there"
                    console.log(store.todoItems.filter(todoItem => todoItem.id === 1))
                }
            }
        }
    }
</script>

<template>
    <div class="group relative overflow-hidden flex items-center gap-2 rounded-xl p-3 bg-white shadow-md shadow-gray-500/10 hover:shadow-gray-500/20 hover:scale-[1.025] transition duration-500">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="w-[calc(100%-3.75rem)] overflow-hidden">
            <h2 class="w-max font-semibold text-gray-600">
                {{title}}
            </h2>
        </div>
        <div class="absolute w-6 group-hover:w-16 transition duration-500 inset-y-0 my-auto right-3 flex items-center before:scale-x-150 before:origin-right before:absolute before:inset-0 before:bg-gradient-to-r before:from-transparent before:via-white before:to-white">
            <div class="flex gap-1 relative scale-75 translate-x-11 opacity-0 transition duration-500 group-hover:scale-100 group-hover:translate-x-0 group-hover:opacity-100">
                <button @click="editTodoItem()" class="h-8 w-8 flex rounded transition duration-300 hover:bg-gray-300/20 focus:bg-gray-300/30 active:bg-gray-300/40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 m-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>
                </button>
                <button @click="removeTodoItem()" class="h-8 w-8 flex rounded transition duration-300 hover:bg-gray-300/20 focus:bg-gray-300/30 active:bg-gray-300/40">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 m-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
