<template>
    <main-page :headers="headers" role="teacher" title="المعلمين">
        <template #create>
            <v-btn variant="text" @click="model.showModalCreate = true">
                إضافة</v-btn
            >
            <create-teacher v-if="model.showModalCreate" />
        </template>

        <edit-user />
        <show-user />

        <template #expand="{ item }">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    المواد الدراسية</v-card-title
                >
                <v-card-text>
                    <data-table
                        :headers="headersItems"
                        :items="item.materials"
                        body-text-direction="right"
                        :hide-footer="true"
                    >
                        <template #item-teacher="levels">
                            <v-chip
                                size="small"
                                class="mx-1"
                                v-for="i in levels.level"
                                :key="i.id"
                            >
                                {{ i.name }}</v-chip
                            >
                        </template>
                    </data-table>
                </v-card-text>
            </v-card>
        </template>
    </main-page>
</template>

<script lang="ts" setup>
// import Image from "../../components/media/UploadIamge.vue";
import CreateTeacher from "./Create.vue";
import EditUser from "./Edit.vue";
import ShowUser from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";

const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("teachers");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "اسم المعلم", value: "name", width: 200, sortable: true },
    { text: "رقم الهاتف", value: "phone", sortable: true },
    { text: "البريد", value: "email", width: 200 },
    { text: "العنوان", value: "address", width: 200 },
    { text: "عدد المواد", value: "material"},
    { text: "عدد الفصول", value: "level"},
    { text: "التفاصيل", value: "details"},
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    { text: "إعدادات", value: "operation", width: 150 },
];

const headersItems: import("vue3-easy-data-table").Header[] = [
    { text: "اسم المادة", value: "name", width: 200, sortable: true },
    { text: "أعلى درجة", value: "max_degree", width: 200 },
    { text: "أقل درجة", value: "min_degree", width: 200 },
    { text: "التفاصيل", value: "details", width: 200 },
    { text: "الفصول الدراسية", value: "teacher", width: 200 },
    // { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    // { text: "إعدادات", value: "operation", width: 150 },
];
</script>
