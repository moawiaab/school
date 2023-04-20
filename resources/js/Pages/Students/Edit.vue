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
                    تعديل بيانات الطالب
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
                        </v-col>
                    </v-row>
                    <v-text-field
                        clearable
                        label="تفاصيل إضافية"
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
import { useSingleStudents } from "../../stores/students/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { watch } from "@vue/runtime-core";

export default {
    name: "EditUser",
    setup() {
        const single = useSingleStudents();
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
