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
                    إضافة معلم جديد
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-row>
                        <v-col>
                            <v-text-field
                                clearable
                                label="اسم المستخدم"
                                v-model="single.entry.name"
                                :rules="rules.required"
                                :error-messages="single.errors.name"
                                required
                                color="primary"
                            />
                            <v-text-field
                                clearable
                                label=" البريد الالكتروني"
                                v-model="single.entry.email"
                                :rules="rules.required"
                                :error-messages="single.errors.email"
                                required
                                color="primary"
                                type="email"
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
                        <v-divider vertical inset />
                        <v-col>
                            <v-text-field
                                clearable
                                label="كلمة السر"
                                v-model="single.entry.password"
                                :rules="rules.required"
                                :error-messages="single.errors.password"
                                required
                                color="primary"
                                type="password"
                            />
                            <v-text-field
                                clearable
                                label=" تأكيد كلمة السر"
                                v-model="single.entry.password_confirmation"
                                :rules="rules.required"
                                required
                                color="primary"
                                type="password"
                            />

                            <v-text-field
                                clearable
                                label="العنوان"
                                v-model="single.entry.address"
                                :rules="rules.required"
                                :error-messages="single.errors.address"
                                required
                                color="primary"
                            />
                        </v-col>
                    </v-row>
                    <v-text-field
                        clearable
                        label="التفاصيل"
                        v-model="single.entry.details"
                        :rules="rules.required"
                        :error-messages="single.errors.details"
                        required
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

<script lang="ts">
import { useSingleTeachers } from "../../stores/teachers/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";

export default {
    name: "CreateTeacher",
    setup() {
        const single = useSingleTeachers();
        const model = useSinglePage();

        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const submitForm = () => {
            if (validation()) {
                single.storeData().then(() => {
                    model.showModalCreate = false;
                    single.$reset();
                });
            } else {
                useSettingAlert().setAlert(
                    "لا تترك حقل فارغ لو سمحت",
                    "warning",
                    true
                );
            }
        };
        const validation = () => {
            return (
                single.entry.name &&
                single.entry.email &&
                single.entry.address &&
                single.entry.password
            );
        };
        return {
            model,
            single,
            rules,
            submitForm,
        };
    },
};
</script>
