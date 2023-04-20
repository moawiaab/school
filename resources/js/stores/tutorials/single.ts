import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { usePageIndex } from "../pages/pageIndex";
import { useSinglePage } from "../pages/pageSingle";

interface entryData {
    id: Number | null;
    title: String;
    url: String | null;
    details: String;
    audio: any
}

const route = "tutorials";
export const useSingleTutorials = defineStore("single-tutorials", {
    state: () => ({
        entry: <entryData>{},
        lists: {
            products: [],
        },
        loading: false,
        dialog: false,
        errors: {
            name: "",
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
                    .post(route, this.entry, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        // usePageIndex().fetchIndexData();
                        this.entry = response.data.data
                        useSinglePage().entry = this.entry
                        console.log(this.entry.id)
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
    },
});
