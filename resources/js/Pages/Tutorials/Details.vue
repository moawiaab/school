<template>
    <div class="" id="col3">
        <v-card
            :loading="single.loading"
            :title="single.entry.title"
            :subtitle="` تاريخ الإضافة ${single.entry.created_at}`"
        >
            <v-card-text>
                <v-row>
                    <v-col :cols="settings.window > 800 ? '3' : '12'">
                        <iframe
                            style="width: 100%; height: 100%"
                            v-if="single.entry.url"
                            :src="`https://www.youtube-nocookie.com/embed/${single.entry.url}`"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    </v-col>
                    <!-- <v-divider v-if="settings.window > 800"/> -->
                    <!-- <v-divider v-else /> -->
                    <v-col>{{ single.entry.details }}</v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <!-- <v-btn>Click me</v-btn> -->
                <v-row>
                    <v-col>
                        <v-chip label class="ma-1"
                            >الفصل الدراسي : {{ single.entry.level }}</v-chip
                        >
                        <v-chip label class="ma-1">
                            اسم المادة : {{ single.entry.material }}</v-chip
                        >
                        <v-chip label class="ma-1">
                            اسم المعلم : {{ single.entry.teacher }}</v-chip
                        >
                        <v-chip label class="ma-1">
                            اسم المستخدم : {{ single.entry.user }}</v-chip
                        >
                    </v-col>
                    <v-col cols="4">
                        <audio
                            style="width: 100%"
                            v-if="single.entry.audio"
                            :src="single.entry.audio"
                            controls
                        />
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
        <br />
        <header-title title="الأسئلة الخاصة بهذا الدرس" :icon="true">
            <v-btn
                variant="text"
                color="primary"
                :to="`/tutorials/add-ask/${route.params.id}`"
            >
                إضافة سؤال جديد لهذا الدرس
            </v-btn>
        </header-title>
        <v-list>
            <v-list-item
                v-for="(item, index) in single.entry.answers"
                :key="item.id"
                :title="`# ${index + 1} - ${item.ask}`"
            >
            <v-radio-group v-model="status">
            <v-list-item-subtitle v-for="a,i in item.answers" :key="i">
                <v-radio :label="`${a.answer}`" :value="a.status" disabled/>
            </v-list-item-subtitle>
            </v-radio-group>
            </v-list-item>
        </v-list>
    </div>
</template>

<script lang="ts" setup>
import { useSingleTutorials } from "../../stores/tutorials/single";
import { useSingleAsk } from "../../stores/tutorials/aks";
import { useSinglePage } from "../../stores/pages/pageSingle";
import { useRoute } from "vue-router";
import { onMounted, ref } from "vue";
import { useSetting } from "../../stores/settings/SettingIndex";
import HeaderTitle from "../../components/HeaderTitle.vue";

const tutorial = useSingleTutorials();
const single = useSinglePage();
const route = useRoute();
const settings = useSetting();
const ask = useSingleAsk();
const status = ref("1")
onMounted(() => {
    single.setRoute("tutorials");
    single.fetchShowData(parseInt(route.params.id.toString()));
});
</script>

<style></style>
