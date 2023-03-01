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
        async fetchProjectTasks(projectID: Number) {
            try {
                const response = await tasksApi.getProjectTasks(projectID);
                this.tasks = response.data.data.tasks;
            } catch (e) {
                console.log(e.message)
            }
        },
        async addTask(projectID: Number, task: String) {
            try {
                const response = await tasksApi.createTask(projectID, task);
                if (response.status  === 201) {
                    this.tasks.push(response.data.data)
                }
            } catch (e) {
                console.log(e.message)
            }
        },
        deleteTask(itemID: Number) {
            this.taskList = this.taskList.filter((object) => {
                return object.id !== itemID;
            });
        },
        reorder(idToFind: Number) {
            const Task = this.taskList.find((obj) => obj.id === idToFind);
            if (Task) {
                Task.completed = !Task.completed;
            }
        },
    },
});
