import {defineStore} from "pinia";
import tasksApi from "../api/tasksApi";
import {TaskItem} from "../types/taskItem";

export const useTaskListStore = defineStore("taskList", {
    state: () => ({
        tasks: [] as TaskItem[],
        id: 0,
    }),
    getters: {
        getTasks(state) {
            return state.tasks;
        }
    },
    actions: {
        async fetchTasks() {
            try {
                const tasks = await tasksApi.getTasks();
                this.tasks = tasks.data.data;
            } catch (e) {
                console.log(e.message)
            }
        },
        async fetchProjectTasks(projectID: number) {
            try {
                const tasks = await tasksApi.getProjectTasks(projectID);
                this.tasks = tasks.data.data.tasks;
            } catch (e) {
                console.log(e.message)
            }
        },
        addTask(item: string) {
            return this.taskList.push({item, id: this.id++});
        },
        deleteTask(itemID: number) {
            this.taskList = this.taskList.filter((object) => {
                return object.id !== itemID;
            });
        },
        reorder(idToFind: number) {
            const Task = this.taskList.find((obj) => obj.id === idToFind);
            if (Task) {
                Task.completed = !Task.completed;
            }
        },
    },
});
