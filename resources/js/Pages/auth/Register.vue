<template>
    <v-card-title
        class="text-center mb-3 text-xs-h6 text-md-h5 text-lg-h4 font-weight-black text-deep-purple-accent-2"
        color="red"
    >
        إنشاء حساب جديد</v-card-title
    >
    <v-form @submit.prevent="submitForm">
        <v-text-field
            clearable
            label="اسم المستخدم"
            variant="solo"
            v-model="single.entry.name"
            color="primary"
            :rules="rules.required"
            :error-messages="single.errors.name"
        />

        <v-text-field
            clearable
            label="تاريخ الميلاد"
            v-model="single.entry.age"
            color="primary"
            type="date"
            :rules="rules.required"
            :error-messages="single.errors.age"
        />
        <v-text-field
            clearable
            label="رقم الهاتف "
            v-model="single.entry.phone"
            color="primary"
            type="phone"
            :rules="rules.required"
            :error-messages="single.errors.phone"
        />

        <v-text-field
            clearable
            label=" البريد الالكتروني"
            v-model="single.entry.email"
            color="primary"
            type="email"
            :rules="rules.required"
            :error-messages="single.errors.email"
        />
        <v-text-field
            clearable
            label="كلمة السر "
            v-model="single.entry.password"
            :rules="rules.required"
            :error-messages="single.errors.password"
            required
            color="primary"
            type="password"
        />

        <v-text-field
            clearable
            label="تأكيد كلمة السر "
            v-model="single.entry.password_confirmation"
            :rules="rules.required"
            :error-messages="single.errors.password_confirmation"
            required
            color="primary"
            type="password"
        />

        <v-text-field
            clearable
            label="تفاصيل إضافية"
            v-model="single.entry.details"
            color="primary"
        />
        <btn-save
            :loading="single.loading"
            text="إنشاء الحساب"
            class="mx-2"
        />
    </v-form>
    <router-link to="/login">
        <v-list-item> لدي حساب بالفعل</v-list-item></router-link
    >
</template>

<script lang="ts">
import { useSingleRegister } from "../../stores/auth/Register";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useRouter } from "vue-router";

export default {
    name: "Login Page",
    props: ["icon"],
    setup() {
        const router = useRouter();
        const single = useSingleRegister();
        single.entry.type = 1;

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
                    router.push("/dashboard");
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
            return single.entry.email && single.entry.password;
        };

        const nextValidation = () => {
            return (
                single.entry.email &&
                single.entry.password &&
                single.entry.password_confirmation &&
                single.entry.age
            );
        };

        return {
            single,
            submitForm,
            rules
        };
    },
};
</script>
