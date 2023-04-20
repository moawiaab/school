<template>
    <main-page
        :headers="headers"
        role="student"
        title="نافذة الطلاب"
        :viewable="false"
    >
        <template #create>
            <v-btn variant="text" @click="model.showModalCreate = true">
                إضافة</v-btn
            >
            <create-student v-if="model.showModalCreate" />
        </template>

        <template #table-operation="{ item }">
            <v-icon
                icon="mdi-plus-circle-outline"
                color="indigo"
                @click="showDialog(item)"
            />
        </template>

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
                        <template #item-teacher="teachers">
                            <v-chip
                                size="small"
                                class="mx-1"
                                v-for="i in teachers.teacher"
                                :key="i.id"
                            >
                                {{ i.name }}</v-chip
                            >
                        </template>
                    </data-table>
                </v-card-text>
            </v-card>
        </template>

        <edit-student />
        <show-student />

        <v-dialog v-model="model.dialog" max-width="400">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    إضافة مادة الى الفصل الدراسي
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-select
                        v-if="model.lists"
                        v-model="model.entryData.teacher_id"
                        label="اسم المعلم"
                        :items="model.lists.teachers"
                        item-title="name"
                        item-value="id"
                    />
                    <v-select
                        v-if="model.lists"
                        v-model="model.entryData.material_id"
                        label="اسم المادة الدراسية"
                        :items="model.lists.materials"
                        item-title="name"
                        item-value="id"
                    />
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red-darken-1"
                        prepend-icon="mdi-close"
                        variant="tonal"
                        @click="model.dialog = false"
                    >
                        إلغاء الأمر
                    </v-btn>
                    <btn-save
                        :loading="model.loading"
                        @click="model.sendData('materials')"
                    />
                </v-card-actions>
            </v-card>
        </v-dialog>
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

const { can } = useAbility();

const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("levels");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "اسم الفصل", value: "name", width: 200, sortable: true },
    { text: "التفاصيل", value: "details", width: 200 },
    { text: "عدد المواد", value: "material", width: 200 },
    { text: "عدد المعلمين", value: "teacher", width: 200 },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    { text: "إعدادات", value: "operation", width: 150 },
];

const headersItems: import("vue3-easy-data-table").Header[] = [
    { text: "اسم المادة", value: "name", width: 200, sortable: true },
    { text: "أعلى درجة", value: "max_degree", width: 200 },
    { text: "أقل درجة", value: "min_degree", width: 200 },
    { text: "التفاصيل", value: "details", width: 200 },
    { text: "اسم المعلم", value: "teacher", width: 200 },
    // { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    // { text: "إعدادات", value: "operation", width: 150 },
];

const showDialog = (id: any) => {
    model.dialog = true;
    if (!model.lists) {
        model.fetchShowData(id.id);
    }
    model.entryData.level_id = id.id;
    model.setId(id);
};
</script>
