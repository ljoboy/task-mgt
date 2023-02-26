import { reactive } from 'vue'

export const store = reactive({
    projects : [
        "Project One",
        "Project Two",
        "Project Three"
    ],
    todoTitle : "",
    isActive: false,
    todoItems:[
        {   
            id : 0,
            title : "Make my bed",
        },
        {
            id : 1,
            title : "Run for 30 minutes deofwe evjepv wsvowejvsse ldvjre jeue eifhe"
        }
    ],
})