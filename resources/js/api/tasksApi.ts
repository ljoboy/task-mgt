import axios from "axios";

const base_path = '/api/v1';
export default {
    getTasks() {
        return axios.get(`${base_path}/tasks`);
    },
    getProjectTasks(projectID: number) {
        return axios.get(`${base_path}/projects/${projectID}`)
    },
    createTask(text: string) {
        return axios.post(base_path, {text});
    },
    updateTask(task) {
        return axios.put(base_path + '/' + task.id, {text: task.text});
    },
    deleteTask(task) {
        return axios.delete(base_path + '/' + task.id);
    },
    reorderTask(taskId) {
        return axios.post(base_path + '/reorder');
    }
}
