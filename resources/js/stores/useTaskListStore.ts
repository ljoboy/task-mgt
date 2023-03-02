import {defineStore} from "pinia";
import tasksApi from "../api/tasksApi";
import {TaskItem} from "../types/taskItem";

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
                if (response.status === 201) {
                    this.tasks.push(response.data.data)
                }
            } catch (e) {
                console.log(e.message)
            }
        },
        async deleteTask(projectID: Number, itemID: Number) {
            try {
                const response = await tasksApi.deleteTask(projectID, itemID);
                if (response.status === 204) {
                    this.tasks = this.tasks.filter((object: TaskItem) => {
                        return object.id !== itemID;
                    });
                    console.log("deleted")
                }
            } catch (e) {
                console.log(e.message)
            }
        },
        async editTask(projectID: Number, task: TaskItem, name: String) {
            try {
                const response = await tasksApi.updateTask(projectID, task, name);
                if (response.status === 202) {
                    const returnedTask = response.data.data;
                    this.tasks = this.tasks.map((task: TaskItem) => {
                        if (task.id === returnedTask.id) {
                            return task = returnedTask;
                        }
                        return task;
                    });
                }
            } catch (e) {
                console.log(e.message)
            }
        },
        reorder(idToFind: Number) {
            const Task = this.taskList.find((obj) => obj.id === idToFind);
            if (Task) {
                Task.completed = !Task.completed;
            }
        },
    },
});
