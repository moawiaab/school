import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { usePageIndex } from "../pages/pageIndex";

interface entryData {
    id: Number | null;
    name: String;
    details: String;
    max_degree : number;
    min_degree : number;
}

const route = "materials";
export const useSingleMaterials = defineStore("single-materials", {
    state: () => ({
        entry: <entryData>{},
        lists: {
            products: [],
        },
        loading: false,
        errors: {
            name: "",
            details: "",
            max_degree: "",
            min_degree: "",
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
                    .post(route, this.entry)
                    .then((response) => {
                        usePageIndex().fetchIndexData();
                        useSettingAlert().setAlert(
                            "تم إضافة المادة الدراسي بنجاح",
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
