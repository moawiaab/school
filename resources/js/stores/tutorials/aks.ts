import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { usePageIndex } from "../pages/pageIndex";
import { useSinglePage } from "../pages/pageSingle";
import { nanoid } from 'nanoid'

interface answerData {
    id : string | null;
    answer: string | null,
    status: number | null,
}
interface entryData {
    id: number | null;
    ask: String;
    details: String | null;
    type: string | null;
    tutorial_id: number;
}

const route = "tutorials/add-asks";
export const useSingleAsk = defineStore("single-tutorials-ask", {
    state: () => ({
        entry: <entryData>{},
        answers:<answerData[]>[],
        lists: {
            products: [],
        },
        loading: false,
        dialog: false,
        errors: {
            ask: "",
            details: "",
            address: "",
            email: "",
            phone: "",
            password: "",
        },
    }),
    getters: {
        hasErrors: (state) => state.errors,
    },
    actions: {
        // send data to server in created
        storeData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route, {...this.entry, answers : {...this.answers}})
                    .then((response) => {
                        // usePageIndex().fetchIndexData();
                        // this.entry = response.data.data
                        // useSinglePage().entry = this.entry
                        // console.log(this.entry.id)
                        useSettingAlert().setAlert(
                            "تم إضافة المادة الدراسي بنجاح",
                            "success",
                            true
                        );
                        // useRouter().push('/tutorials/details/' + this.entry.id)
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        useSettingAlert().setAlert(
                            error.response.data.message,
                            "warning",
                            true
                        );
                        reject(error);
                    });
                this.loading = false;
            });
        },
        // send data to server in updated
        updateData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .put(`${route}/${this.entry.id}`, this.entry)
                    .then((response) => {
                        usePageIndex().fetchIndexData();
                        useSettingAlert().setAlert(
                            "تم تعديل المادة الدراسي بنجاح",
                            "success",
                            true
                        );
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        useSettingAlert().setAlert(
                            error.response.data.message,
                            "warning",
                            true
                        );
                        reject(error);
                    });
                this.loading = false;
            });
        },

        setupEntry(entry: any, lists: any): void {
            this.entry = entry;
            this.lists = lists;
        },

        addAnswers() {
            this.answers.push({id : nanoid(),answer : "", status : 0})
            if(!this.entry.type) return this.entry.type = this.answers[0].id

        }
    },
});
