<template>
    <v-dialog v-model="single.dialog" persistent max-width="800" scrollable>
        <v-form @submit.prevent="submitForm">
            <v-card>
                <v-card-title class="text-h5 text-primary">
                    إضافة درس جديد
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-text-field
                        clearable
                        label="عنوان الدرس"
                        v-model="single.entry.title"
                        :rules="rules.required"
                        :error-messages="single.errors.title"
                        required
                        color="primary"
                    />
                    <v-textarea
                        clearable
                        label="موضوع الدرس"
                        v-model="single.entry.details"
                        :rules="rules.required"
                        :error-messages="single.errors.details"
                        required
                        color="primary"
                    />
                    <v-file-input
                        label="تحميل مقطع الصوت "
                        accept="audio/*"
                        v-model="single.entry.audio"
                        :rules="rules.required"
                        :error-messages="single.errors.audio"
                        required
                    />
                    <!-- <UploadAudio v-model="single.entry.audio" /> -->

                    <v-text-field
                        clearable
                        label="اسم الفيديو من اليوتيوب ان  وجد"
                        v-model="single.entry.url"
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
                        @click="single.dialog = false"
                    >
                        إلغاء الأمر
                    </v-btn>
                    <btn-save :loading="single.loading" />
                </v-card-actions>
            </v-card>
        </v-form>
        <!-- <iframe
            width="560"
            height="315"
            src="https://www.youtube-nocookie.com/embed/ChkHqG3sPds"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
        ></iframe> -->
    </v-dialog>
</template>

<script lang="ts">
import { useSingleTutorials } from "../../stores/tutorials/single";
import { useSettingAlert } from "../../stores/settings/SettingAlert";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { onMounted } from "@vue/runtime-core";
import { useRouter } from "vue-router";

export default {
    name: "CreateTutorial",
    setup() {
        const single = useSingleTutorials();
        const model = useSinglePage();
        const router = useRouter();

        onMounted(() => {
            if (single.dialog) {
                single.$reset();
                single.setupEntry(model.entry, model.lists);
            }
        });
        const rules = {
            required: [
                (val: any) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        };

        const submitForm = () => {
            if (validation()) {
                single.storeData().then(async () => {
                    console.log(single.entry.id);
                    await router.push("/tutorials/details/" + single.entry.id);
                    // model.showModalCreate = false;
                    // single.$reset();
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
                single.entry.title && single.entry.details && single.entry.url
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
