<template>
    <v-dialog
        v-model="model.showModalEdit"
        persistent
        max-width="800"
        scrollable
    >
        <v-form @submit.prevent="submitForm" ref="form">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    تعديل بيانات المعلم
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-row>
                        <v-col>
                            <v-text-field
                                clearable
                                label="اسم المعلم"
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
                        </v-col>
                        <v-divider vertical />
                        <v-col>
                            <v-text-field
                                clearable
                                label="العنوان"
                                v-model="single.entry.address"
                                color="primary"
                                :rules="rules.required"
                                :error-messages="single.errors.address"
                            />

                            <v-text-field
                                clearable
                                label="التفاصيل "
                                v-model="single.entry.details"
                                color="primary"
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
                        @click="model.showModalEdit = false"
                    >
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script lang="ts">
import { useSingleTeachers } from "../../stores/teachers/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { watch } from "@vue/runtime-core";

export default {
    name: "EditUser",
    setup() {
        const single = useSingleTeachers();
        const model = useSinglePage();
        watch(model, (e) => {
            if (e.showModalEdit) {
                single.$reset();
                single.setupEntry(model.entry, model.lists);
            }
        });
        const submitForm = () =>
            single.updateData().then(() => {
                if (validation()) {
                    single.updateData().then(() => {
                        model.showModalEdit = false;
                        single.$reset();
                    });
                } else {
                    useSettingAlert().setAlert(
                        "لا تترك حقل فارغ لو سمحت",
                        "warning",
                        true
                    );
                }
            });

        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const validation = () => {
            return single.entry.name && single.entry.phone;
        };

        return {
            single,
            submitForm,
            rules,
            model,
        };
    },
};
</script>
