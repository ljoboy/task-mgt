import axios from "axios";
import {TaskItem} from "../types/taskItem";

const base_path = '/api/v1';
export default {
    getTasks() {
        return axios.get(`${base_path}/tasks`);
    },
    getProjectTasks(projectID: Number) {
        return axios.get(`${base_path}/projects/${projectID}`)
    },
    createTask(projectID: Number, name: String) {
        return axios.post(`${base_path}/projects/${projectID}/tasks`, {name});
    },
    updateTask(projectID: Number, task: TaskItem, name: String) {
        return axios.patch(`${base_path}/projects/${projectID}/tasks/${task.id}`, {name});
    },
    deleteTask(projectID: Number, itemID: Number) {
        return axios.delete(`${base_path}/projects/${projectID}/tasks/${itemID}`);
    },
    reorderTask(taskId) {
        return axios.post(base_path + '/reorder');
    }
}
