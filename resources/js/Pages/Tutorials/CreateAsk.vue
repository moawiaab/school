<template>
    <!-- <v-dialog v-model="single.dialog" persistent fullscreen> -->
    <v-form @submit.prevent="submitForm">
        <v-card>
            <v-card-title class="text-h5 text-primary">
                إضافة سؤال جديد
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-text-field
                    clearable
                    label="السؤال "
                    v-model="single.entry.ask"
                    :rules="rules.required"
                    :error-messages="single.errors.ask"
                    required
                    color="primary"
                />
                <v-textarea
                    clearable
                    label="تفاصيل عن السؤال"
                    v-model="single.entry.details"
                    :rules="rules.required"
                    :error-messages="single.errors.details"
                    required
                    color="primary"
                />
                <v-list>
                    <v-radio-group inline v-model="single.entry.type">
                        <v-list-item
                            v-for="item in single.answers"
                            :key="item.id"
                            width="50%"
                        >
                            <v-list-item-title>
                                <v-text-field
                                    clearable
                                    v-model="item.answer"
                                    color="primary"
                                    placeholder="اكتب السؤال هنا من فضلك"
                                />
                                <v-list-item-subtitle>
                                    <v-radio
                                        label="الاجابة الصحيحة"
                                        :value="`${item.id}`"
                                    />
                                </v-list-item-subtitle>
                            </v-list-item-title>
                        </v-list-item>
                    </v-radio-group>
                </v-list>
                <v-btn @click="single.addAnswers">إضافة اجابة جديدة</v-btn>
            </v-card-text>

            <v-divider />
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="red-darken-1"
                    prepend-icon="mdi-chevron-right"
                    variant="tonal"
                    @click="back"
                >
                    رجوع
                </v-btn>
                <btn-save :loading="single.loading" />
            </v-card-actions>
        </v-card>
    </v-form>
    <!-- </v-dialog> -->
</template>

<script lang="ts" setup>
import { useSingleAsk } from "../../stores/tutorials/aks";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { onMounted } from "@vue/runtime-core";
import { useRoute, useRouter } from "vue-router";

const single = useSingleAsk();
const model = useSinglePage();
const router = useRouter();
const route = useRoute();

onMounted(
    () => (single.entry.tutorial_id = parseInt(route.params.id.toString()))
);
const rules = {
    required: [
        (val: any) =>
            (val || "").length > 0 || "لا تترك هذا الحقل فارغاً لو سمحت",
    ],
};
const back = () => {
    // console.log("🚀 ~ file: CreateAsk.vue:90 ~ back ~ back:",route.params.id)
    return router.back();
};
const submitForm = () => {
    if (validation()) {
        single.storeData().then(async () => {
            // await router.push("/tutorials/details/" + route.params.id);
            single.$reset()
            single.entry.tutorial_id = parseInt(route.params.id.toString())
        });
    } else {
        useSettingAlert().setAlert("لا تترك حقل فارغ لو سمحت", "warning", true);
    }
};
const validation = () => {
    return single.entry.ask && single.entry.details && single.entry.type;
};

const changeItem = (item: any) => {};
</script>
