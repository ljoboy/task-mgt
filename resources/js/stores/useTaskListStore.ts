import {defineStore} from "pinia";
import tasksApi from "../api/tasksApi";
import {TaskItem} from "../types/taskItem";
import {toast} from "vue3-toastify";
import {AxiosResponse} from "axios";
import {ref} from "vue";

export const useTaskListStore = defineStore("taskList", {
    state: () => ({
        tasks: [] as TaskItem[],
        id: 0,
        isActive: false,
    }),
    getters: {
        getTasks(state) {
            return state.tasks;
        }
    },
    actions: {
        async fetchTasks() {
            const response = await tasksApi.getTasks();
            this.tasks = response.data.data.data;
        },
        async fetchProjectTasks(projectID: Number) {
            await this.alert(tasksApi.getProjectTasks(projectID), 'fetch');
        },
        async addTask(projectID: Number, task: String) {
            await this.alert(tasksApi.createTask(projectID, task), 'add');
        },
        async deleteTask(projectID: Number, itemID: Number) {
            await this.alert(tasksApi.deleteTask(projectID, itemID), 'delete', [itemID]);
        },
        async editTask(projectID: Number, task: TaskItem, name: String) {
            await this.alert(tasksApi.updateTask(projectID, task, name), 'edit');
        },
        async updateTaskOrder(projectID: Number, task: TaskItem, newPriority: Number) {
            await this.alert(tasksApi.reorderTask(projectID, task.id, newPriority), 'reorder');
        },
        async alert(promise, method: string = null, options: any[] = []) {
            await toast.promise(
                promise,
                {
                    pending: 'Loading... 🍕',
                    success: 'Everything went okay... 👌',
                    error: 'A problem occurred... 😞',
                },
                {
                    position: toast.POSITION.TOP_RIGHT,
                    closeButton: true,
                    pauseOnHover: false,
                    hideProgressBar: true,
                },
            ).then((result: AxiosResponse) => {
                switch (method) {
                    case 'delete':
                        this.tasks = this.tasks.filter((object: TaskItem) => {
                            return object.id !== options[0];
                        });
                        break;
                    case 'fetch':
                        this.tasks = result?.data.data.tasks;
                        break;
                    case 'add':
                        this.tasks.push(result?.data.data);
                        break;
                    case 'edit':
                        this.tasks = this.tasks.map((task: TaskItem) => {
                            return task.id === result?.data.data.id ? result?.data.data : task;
                        });
                        break;
                    case 'reorder':
                        const returnedTask = result?.data.data;
                        this.tasks = this.tasks.map((task: TaskItem) => {
                            return task.id === returnedTask.id ? returnedTask : task;
                        });
                        break;
                }

                setTimeout(() => { toast.clearAll(); }, 2000);

            });
        }
    },
});
