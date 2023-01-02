import { createRouter, createWebHistory } from "vue-router";

import DefaultLayout from "@/layouts/DefaultLayout.vue";
import LoginLayout from "@/layouts/LoginLayout.vue";
const routes = [
    {
        path: '/login',
        name : "Layout Login",
        component : LoginLayout,
        redirect: "/login",
        children : [
            {
                path: '/login',
                name : "Login",
                component: () => import("@/Pages/auth/Login.vue"),
            },
            {
                path : '/password/reset',
                name : "request",
                component: () => import("@/Pages/auth/Reset.vue"),
            },
            {
                path : '/reset-password/:token',
                name : "reset-password",
                component: () => import("@/Pages/auth/ResetPassword.vue"),
            },
            {
                path : '/register',
                name : "register",
                component: () => import("@/Pages/auth/Register.vue"),
            }

        ]
    },
    {
        path: "/",
        name: "Main Dashboard",
        component: DefaultLayout,
        redirect: "/dashboard",
        children: [
            {
                path: "/dashboard",
                name: "لوحة التحكم",
                component: () => import("@/Pages/DashboardPage.vue"),
            },
            {
                path: "/users",
                name: " المستخدمين",
                component: () => import("@/Pages/Users/Index.vue"),
            },
            // {
            //     path: "/accounts",
            //     name: " accounts.index",
            //     component: () => import("@/Pages/Accounts/Index.vue"),
            // },
            {
                path: "/roles",
                name: " الصلاحيات",
                component: () => import("@/Pages/Roles/Index.vue"),
            },
            {
                path: "/permissions",
                name : "الأذونات",
                component: () => import("@/Pages/Permissions/Index.vue"),
            },
            {
                path: "/categories",
                name: " أقسام المنتجات",
                component: () => import("@/Pages/Categories/Index.vue"),
            },
            {
                path: "/products",
                name: " المنتجات",
                component: () => import("@/Pages/Products/Index.vue"),
            },
            {
                path: "/stores",
                name: " المخازن",
                component: () => import("@/Pages/Stores/Index.vue"),
            },
        ],
    },
    {
        path : '/:pathMatch(.*)*',
        name : 'NotFound',
        component : () => import("@/Pages/NotFound.vue")
    }
];

const router = createRouter({
    history: createWebHistory(),
    mode: "history",
    routes,
});

export default router;
