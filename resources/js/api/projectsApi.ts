import axios from "axios";

const base_path = '/api/v1/projects';
export default {
    getProjects() {
        return axios.get(base_path);
    },
    createTask(text) {
        return axios.post(base_path, {text});
    },
    updateTask(task) {
        return axios.put(base_path + '/' + task.id, {text: task.text});
    },
    deleteTask(task) {
        return axios.delete(base_path + '/' + task.id);
    },
}
