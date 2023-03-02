import axios from "axios";
import {TaskItem} from "../types/taskItem";

const base_path = '/api/v1';
export default {
    getTasks() {
        return axios.get(`${base_path}/tasks`);
    },
    getProjectTasks(projectId: Number) {
        return axios.get(`${base_path}/projects/${projectId}`)
    },
    createTask(projectId: Number, name: String) {
        return axios.post(`${base_path}/projects/${projectId}/tasks`, {name});
    },
    updateTask(projectId: Number, task: TaskItem, name: String) {
        return axios.patch(`${base_path}/projects/${projectId}/tasks/${task.id}`, {name});
    },
    deleteTask(projectId: Number, $taskId: Number) {
        return axios.delete(`${base_path}/projects/${projectId}/tasks/${$taskId}`);
    },
    reorderTask(projectId: Number, $taskId: Number, order: Number) {
        return axios.post(`${base_path}/projects/${projectId}/tasks/${$taskId}/reorder`, {new_priority: order});
    }
}
