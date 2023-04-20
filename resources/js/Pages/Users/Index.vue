<template>
    <main-page :headers="headers" role="user" title="المستخدمين">
        <template #create>
            <v-btn variant="text" @click="model.showModalCreate = true">
                إضافة</v-btn
            >
            <create-user v-if="model.showModalCreate" />
        </template>

        <template #table-operation="{ item }">
            <toggle-icon
                @click="pages.toggleItem(item.id)"
                role="category"
                :toggle="item.status"
                v-if="can('user_edit', 'all')"
            />
        </template>

        <template #item-phone="{ item }">
            {{ item.id }}
        </template>

        <template #filter>
            <v-col>
                <v-radio-group v-model="filter.type">
                    <v-radio
                        label=" حسابات الإدارة "
                        value="1"
                        color="info"
                    ></v-radio>
                    <v-radio
                        label="حسابات المعلمين"
                        value="2"
                        color="info"
                    ></v-radio>
                    <v-radio
                        label="حسابات الطلاب"
                        value="3"
                        color="info"
                    ></v-radio>
                    <v-radio
                        label="جميع الحسابات"
                        value=""
                        color="info"
                    ></v-radio>
                </v-radio-group>
            </v-col>
        </template>

        <edit-user />
        <show-user />
    </main-page>
</template>

<script lang="ts" setup>
// import Image from "../../components/media/UploadIamge.vue";
import CreateUser from "./Create.vue";
import EditUser from "./Edit.vue";
import ShowUser from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { useAbility } from "@casl/vue";
import { ref, watch } from "vue";

const { can } = useAbility();

const filter = ref({ type: "" });

const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("users");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "اسم المستخدم", value: "name", width: 200, sortable: true },
    { text: "البريد", value: "email", width: 200 },
    { text: "رقم الهاتف", value: "phone", sortable: true },
    { text: "الصلاحية", value: "role", sortable: true },
    { text: "الفرع", value: "account" },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    { text: "إعدادات", value: "operation", width: 150 },
];

watch(
    filter,
    (q) => {
        pages.setFilter(q);
        pages.fetchIndexData();
    },
    { deep: true }
);
</script>
