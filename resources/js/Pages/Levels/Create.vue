<template>
    <v-dialog
        v-model="model.showModalCreate"
        persistent
        max-width="500"
        scrollable
    >
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    إضافة فصل جديد
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field
                        clearable
                        label="اسم الفصل"
                        v-model="single.entry.name"
                        :rules="rules.required"
                        :error-messages="single.errors.name"
                        required
                        color="primary"
                    />

                    <v-text-field
                        clearable
                        label="تفاصيل الفصل"
                        v-model="single.entry.details"
                        color="primary"
                    />
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
import { useSingleLevels } from "../../stores/levels/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";

const single = useSingleLevels();
const model = useSinglePage();
const rules = {
    required: [
        (val: any) =>
            (val || "").length > 0 || "لا تترك هذا الحقل فارغاً لو سمحت",
    ],
};

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
    return single.entry.name && single.entry.details;
};
</script>
