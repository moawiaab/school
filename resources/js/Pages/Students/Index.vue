<template>
    <main-page :headers="headers" role="student" title="نافذة الطلاب">
        <template #create>
            <v-btn variant="text" @click="model.showModalCreate = true">
                إضافة</v-btn
            >
            <create-student v-if="model.showModalCreate" />
        </template>

        <template #item-photo="{ item }">
            <v-avatar :image="item.photo"/>
        </template>

        <edit-student />
        <show-student />
    </main-page>
</template>

<script lang="ts" setup>
// import Image from "../../components/media/UploadIamge.vue";
import CreateStudent from "./Create.vue";
import EditStudent from "./Edit.vue";
import ShowStudent from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { useAbility } from "@casl/vue";
import { ref, watch } from "vue";

const { can } = useAbility();

// const filter = ref({ type: "" });

const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("students");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "اسم طالب", value: "name", width: 200, sortable: true },
    { text: "تاريخ الميلاد", value: "age", width: 200, sortable: true },
    { text: "البريد", value: "email", width: 200 },
    { text: "رقم الهاتف", value: "phone", sortable: true },
    // { text: "الصلاحية", value: "role", sortable: true },
    { text: "الفصل الدراسي", value: "level" },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    { text: "الصورة", value: "photo" },
    { text: "إعدادات", value: "operation", width: 150 },
];

// watch(
//     filter,
//     (q) => {
//         pages.setFilter(q);
//         pages.fetchIndexData();
//     },
//     { deep: true }
// );
</script>
