import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../views/LoginPage.vue";
import Home from "../views/Home.vue";
import HomeAdmin from "../views/HomeAdmin.vue";
import HomeProfessor from "../views/HomeProfessor.vue";
import HomeAluno from "../views/HomeAluno.vue";
import PerfilAdmin from "../views/PerfilAdmin.vue";
import PerfilProfessor from "../views/PerfilProfessor.vue";
import PerfilAluno from "../views/PerfilAluno.vue";
import PerfilUsuario from "../views/PerfilUsuario.vue";


const routes = [
  { path: "/", redirect: "/login" }, 
  { path: "/login", component: LoginPage },
  { path: "/home", component: Home, meta: { requiresAuth: true } },
  { path: "/perfil", component: PerfilUsuario, meta: { requiresAuth: true, role: "perfil" } },
  { path: "/admin/home", component: HomeAdmin, meta: { requiresAuth: true, role: "admin" } },
  { path: "/professor/home", component: HomeProfessor, meta: { requiresAuth: true, role: "professor" } },
  { path: "/aluno/home", component: HomeAluno, meta: { requiresAuth: true, role: "aluno" } },
  { path: "/admin/perfil", component: PerfilAdmin, meta: { requiresAuth: true, role: "admin" } },
  { path: "/professor/perfil", component: PerfilProfessor, meta: { requiresAuth: true, role: "professor" } },
  { path: "/aluno/perfil", component: PerfilAluno, meta: { requiresAuth: true, role: "aluno" } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Proteção de rotas com verificação de papel (role)
router.beforeEach((to, from, next) => {
  const user = JSON.parse(localStorage.getItem("user"));

  if (to.meta.requiresAuth && !user) {
    next("/login");
  } else if (to.meta.role && user?.role !== to.meta.role) {
    next("/login"); // Redireciona para o login caso o usuário tente acessar algo sem permissão
  } else {
    next();
  }
});

export default router;
