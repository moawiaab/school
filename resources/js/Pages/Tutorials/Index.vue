<template>
    <main-page
        :headers="headers"
        role="tutorial"
        title="الدروس"
        :createNewItem="false"
        :viewable="false"
    >
        <template #create>
            <v-btn variant="text" @click="model.showModalCreate = true">
                إضافة</v-btn
            >
            <create-tutorial v-if="model.showModalCreate" />
        </template>
        <template #table-operation="{item}">
            <v-btn
                icon="mdi-link"
                color="info"
                :to="`/tutorials/details/${item.id}`"
                size="30"
                variant="text"
            />
        </template>
        <template #expand="{ item }">
            <v-card>
                <v-card-title class="text-h5 text-primary"
                    >أسئلة الدرس</v-card-title
                >
                <v-card-text>
                    <v-list>
                        <v-list-item
                            v-for="(i, index) in item.answers"
                            :key="i.id"
                            :title="`# ${index + 1} - ${i.ask}`"
                        >
                            <v-radio-group v-model="status">
                                <v-list-item-subtitle
                                    v-for="(a, id) in i.answers"
                                    :key="id"
                                >
                                    <v-radio
                                        :label="`${a.answer}`"
                                        :value="a.status"
                                        disabled
                                    />
                                </v-list-item-subtitle>
                            </v-radio-group>
                        </v-list-item>
                    </v-list>
                </v-card-text>
            </v-card>
        </template>

        <edit-user />
        <show-user />
    </main-page>
</template>

<script lang="ts" setup>
// import Image from "../../components/media/UploadIamge.vue";
import CreateTutorial from "./Create.vue";
import EditUser from "./Edit.vue";
import ShowUser from "./Show.vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { ref } from "vue";

const status = ref("1");

const pages = usePageIndex();
const model = useSinglePage();
pages.$reset();
pages.setup("tutorials");
const headers: import("vue3-easy-data-table").Header[] = [
    { text: "#", value: "id" },
    { text: "عنوان الدرس", value: "title" },
    { text: " المادة الدراسية", value: "material" },
    { text: "الفصل الدراسي", value: "level", width: 200 },
    { text: "المعلم", value: "teacher" },
    // { text: "الصلاحية", value: "role" },
    // { text: "الفرع", value: "account" },
    { text: "تاريخ الإنشاء", value: "created_at" }, //
    { text: "إعدادات", value: "operation", width: 150 },
];
</script>
