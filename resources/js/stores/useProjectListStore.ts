import {defineStore} from "pinia";
import projectsApi from "../api/projectsApi";
import {ProjectItem} from "../types/projectItem";

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
                this.projects = [defaultProject, ...projects.data.data];
            } catch (e) {
                console.log(e.message)
            }
        },
        addProject(item: string) {
            return this.projectList.push({item, id: this.id++});
        },
        deleteProject(itemID: Number) {
            return this.projectList = this.projectList.filter((object) => {
                return object.id !== itemID;
            });
        },
        // inputAlert() {
        //     this.showAlert = true;
        //     setTimeout(() => {
        //         this.showAlert = false;
        //     }, 1000);
        // },
    },
});
