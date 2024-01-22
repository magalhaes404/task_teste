import { createRouter, createWebHistory } from 'vue-router'
import LoginView from  '../views/LoginView.vue'
import TaskView from  '../views/TaskView.vue'
import TaskNewView from  '../views/TaskNewView.vue'
import TaskEditView from  '../views/TaskEditView.vue'

const routes = [
  {
    path: '/',
    name: 'login',
    component: LoginView
  },
  {
    path: '/task/:id',
    name: 'task-edit',
    component: TaskEditView
  },
  {
    path: '/task',
    name: 'task',
    component: TaskView
  },
  {
    path: '/task/new',
    name: 'task-new',
    component: TaskNewView
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
