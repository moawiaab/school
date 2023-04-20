<template>
    <v-dialog
        v-model="model.showModalCreate"
        persistent
        max-width="800"
        scrollable
    >
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    إضافة طالب جديد
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-row>
                        <v-col>
                            <v-text-field
                                clearable
                                label="اسم الطالب"
                                v-model="single.entry.name"
                                :rules="rules.required"
                                :error-messages="single.errors.name"
                                required
                                color="primary"
                            />
                            <v-text-field
                                clearable
                                label="رقم الهاتف"
                                v-model="single.entry.phone"
                                :rules="rules.required"
                                :error-messages="single.errors.phone"
                                required
                                color="primary"
                                type="phone"
                            />
                            <v-text-field
                                clearable
                                label="تفاصيل إضافية"
                                v-model="single.entry.details"
                                color="primary"
                            />
                        </v-col>
                        <v-divider vertical />
                        <v-col>
                            <v-text-field
                                clearable
                                label="تاريخ الميلاد"
                                v-model="single.entry.age"
                                color="primary"
                                type="date"
                                :rules="rules.required"
                                :error-messages="single.errors.age"
                            />

                            <v-select
                                v-model="single.entry.level_id"
                                clearable
                                label="Select"
                                :rules="rules.required"
                                :items="single.lists.levels"
                                variant="solo"
                                item-title="name"
                                item-value="id"
                            />

                            <v-file-input
                                label="تحميل مقطع الصوت "
                                accept="image/*"
                                v-model="single.entry.photo"
                                :rules="rules.required"
                                :error-messages="single.errors.photo"
                                required
                            />
                        </v-col>
                    </v-row>
                </v-card-text>

                <v-divider />
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red-darken-1"
                        prepend-icon="mdi-close"
                        variant="tonal"
                        @click="model.showModalCreate = false"
                    >
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script lang="ts" setup>
import { useSingleStudents } from "../../stores/students/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { onMounted } from "vue";

const single = useSingleStudents();
const model = useSinglePage();
const rules = {
    required: [
        (val: any) =>
            (val || "").length > 0 || "لا تترك هذا الحقل فارغاً لو سمحت",
    ],
};

onMounted(() => {
    if (model.showModalCreate) {
        single.$reset();
        single.setupEntry(model.entry, model.lists);
    }
});

const submitForm = () => {
    if (validation()) {
        single.storeData().then(() => {
            model.showModalCreate = false;
            single.$reset();
        });
    } else {
        useSettingAlert().setAlert("لا تترك حقل فارغ لو سمحت", "warning", true);
    }
};
const validation = () => {
    return (
        single.entry.name &&
        single.entry.phone &&
        single.entry.age &&
        single.entry.level_id
    );
};
</script>
