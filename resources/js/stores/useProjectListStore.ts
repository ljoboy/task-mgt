import {defineStore} from "pinia";
import projectsApi from "../api/projectsApi";
import {ProjectItem} from "../types/projectItem";
import {toast} from "vue3-toastify";

const defaultProject: ProjectItem = {
    created_at: null,
    id: 0,
    name: 'All Projects',
    updated_at: null,
}

export const useProjectListStore = defineStore("projectList", {
    state: () => ({
        projects: [] as ProjectItem[],
        selectedProject: defaultProject as ProjectItem,
    }),
    getters: {
        getProjects(state) {
            return state.projects;
        }
    },
    actions: {
        async fetchProjects() {
            try {
                const projects = await projectsApi.getProjects();
                this.projects = [defaultProject, ...projects.data.data.data];
            } catch (e) {
                console.log(e.message)
            }
        },
    },
});
