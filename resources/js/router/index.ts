import { createRouter, createWebHistory } from "vue-router";

import DefaultLayout from "@/layouts/DefaultLayout.vue";
import LoginLayout from "@/layouts/LoginLayout.vue";
const routes = [
    {
        path: '/login',
        name: "Layout Login",
        component: LoginLayout,
        redirect: "/login",
        children: [
            {
                path: '/login',
                name: "Login",
                component: () => import("@/Pages/auth/Login.vue"),
            },
            {
                path: '/password/reset',
                name: "request",
                component: () => import("@/Pages/auth/Reset.vue"),
            },
            {
                path: '/reset-password/:token',
                name: "reset-password",
                component: () => import("@/Pages/auth/ResetPassword.vue"),
            },
            {
                path: '/register',
                name: "register",
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
            {
                path: "/materials",
                name: " المادة الدراسية",
                component: () => import("@/Pages/Materials/Index.vue"),
            },
            {
                path: "/students",
                name: " الطلاب",
                component: () => import("@/Pages/Students/Index.vue"),
            },
            {
                path: "/levels",
                name: " الفصول الدراسي",
                component: () => import("@/Pages/Levels/Index.vue"),
            },

            {
                path: "/roles",
                name: " الصلاحيات",
                component: () => import("@/Pages/Roles/Index.vue"),
            },
            {
                path: "/permissions",
                name: "الأذونات",
                component: () => import("@/Pages/Permissions/Index.vue"),
            },

            {
                path: "/private-lockers",
                name: " الخزائن الشخصية",
                component: () => import("@/Pages/PrivateLocker/Index.vue"),
            },
            {
                path: "/public-treasuries",
                name: " الخزنة العامة",
                component: () => import("@/Pages/PrivateLocker/PubIndex.vue"),
            },
            {
                path: "/stages",
                name: " السنة المالية",
                component: () => import("@/Pages/Stages/Index.vue"),
            },
            {
                path: "/budgets",
                name: " الموازنة العامة",
                component: () => import("@/Pages/Budgets/Index.vue"),
            },
            {
                path: "/budget-names",
                name: "اسماء الموازنة",
                component: () => import("@/Pages/BudgetName/Index.vue"),
            },

            {
                path: "/teachers",
                name: "المعلمين",
                component: () => import("@/Pages/Teachers/Index.vue"),
            },

            {
                path: "/tutorials",
                name: "الدروس",
                component: () => import("@/Pages/Tutorials/Index.vue"),
            },

            {
                path: "/tutorials/details/:id",
                name: "تفاصيل الدروس",
                component: () => import("@/Pages/Tutorials/Details.vue"),
            },

            {
                path: "/tutorials/add-ask/:id",
                name: "إضافة سؤال",
                component: () => import("@/Pages/Tutorials/CreateAsk.vue"),
            },




        ],
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import("@/Pages/NotFound.vue")
    }
];

const router = createRouter({
    history: createWebHistory(),
    mode: "history",
    routes,
});

export default router;
