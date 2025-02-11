import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../views/LoginPage.vue";
import Home from "../views/Home.vue";

const routes = [
    { path: "/", redirect: "/login" }, // Redireciona "/" para "/login"
    { path: "/login", component: LoginPage },
    { path: "/home", component: Home, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Proteção de rotas
router.beforeEach((to, from, next) => {
  const user = JSON.parse(localStorage.getItem("user"));

  if (to.meta.requiresAuth && !user) {
    next("/");
  } else {
    next();
  }
});

export default router;
