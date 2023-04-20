<template>
    <main-page
        :headers="headers"
        role="material"
        title="المواد الدراسية"
        :viewable="false"
    >
        <template #create>
            <v-btn variant="text" @click="model.showModalCreate = true">
                إضافة</v-btn
            >
            <create-material v-if="model.showModalCreate" />
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
                        <template #item-operation="item">
                            <div class="operation-wrapper text-left">
                                <v-btn
                                    icon="mdi-link"
                                    color="info"
                                    to="/"
                                    size="30"
                                    variant="text"
                                />

                                <v-icon
                                    icon="mdi-plus-circle-outline"
                                    color="indigo"
                                    @click="single.entry.material_id = item.id; single.dialog = true"
                                />
                                <delete-icon
                                    @click="showDeletedMethod(item.id)"
                                    role="material"
                                />
                            </div>
                        </template>
                    </data-table>
                </v-card-text>
            </v-card>
        </template>

        <edit-material />
        <show-material />

        <create-tutorial />

        <delete-item title="هل تريد الحذف" v-model="pages.showDeleted">
            <template #content>
                <span>هل تريد الحذف بالفعل ستفقد البيانات </span>
            </template>
            <template #footer>
                <v-btn
                    color="blue-darken-1"
                    prepend-icon="mdi-trash-can"
                    variant="tonal"
                    @click="deleteItem()"
                >
                    تأكيد الحذف
                </v-btn>
                <v-btn
                    color="red-darken-1"
                    prepend-icon="mdi-close"
                    variant="tonal"
                    @click="pages.showDeleted = false"
                >
                    إلغاء الأمر
                </v-btn>
            </template>
        </delete-item>

        <v-dialog v-model="pages.dialog" max-width="400">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    <v-row>
                        <v-col> هل تريد حذف الفصل الدراسي </v-col>
                        <v-col class="text-left">
                            <v-icon icon="mdi-alert-circle-outline"></v-icon>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-divider />
                <v-card-text>
                    <span
                        >هل تريد الحذف بالفعل ستفقد البيانات برقم الكود
                        {{ materialId }}</span
                    >
                </v-card-text>
                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue-darken-1"
                        prepend-icon="mdi-trash-can"
                        variant="tonal"
                        @click="pages.delete(`materials/${materialId}`)"
                    >
                        تأكيد الحذف
                    </v-btn>
                    <v-btn
                        color="red-darken-1"
                        prepend-icon="mdi-close"
                        variant="tonal"
                        @click="pages.dialog = false"
                    >
                        إلغاء الأمر
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </main-page>
</template>

<script lang="ts" setup>
// import Image from "../../components/media/UploadIamge.vue";
import CreateMaterial from "./Create.vue";
import CreateTutorial from "../Tutorials/Create.vue"
import EditMaterial from "./Edit.vue";
import ShowMaterial from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { useSingleTutorials } from "../../stores/tutorials/single";
import { ref } from "vue";

const pages = usePageIndex();
const model = useSinglePage();
const single = useSingleTutorials();
const materialId = ref<Number | null>(null);
pages.$reset();
pages.setup("materials");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "اسم المادة الدراسية", value: "name", width: 200, sortable: true },
    { text: "أعلى درجة", value: "max_degree", width: 200 },
    { text: "أقل درجة", value: "min_degree", width: 200 },
    { text: " التفاصيل", value: "details", sortable: true },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    { text: "إعدادات", value: "operation", width: 150 },
];

const headersItems: import("vue3-easy-data-table").Header[] = [
    { text: " الكود", value: "id", width: 200 },
    { text: "اسم المادة", value: "material", width: 200 },
    { text: "اسم المعلم", value: "teacher", width: 200 },
    { text: "الفصل الدرايس", value: "level", width: 200, sortable: true },
    { text: "عدد الطلاب", value: "status", width: 200 },
    // { text: "اسم المعلم", value: "teacher", width: 200 },
    { text: "تاريخ الإنشاء", value: "created_at", sortable: true }, //
    { text: "إعدادات", value: "operation", width: 150 },
];

const showDeletedMethod = (id: Number) => {
    pages.dialog = true;
    materialId.value = id;
};
</script>
