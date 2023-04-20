import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { usePageIndex } from "./pageIndex";

interface ListType {
    budgets: Array<[]>;
    teachers: Array<[]>;
    materials: Array<[]>;
}
interface ListData {
    level_id: number;
    material_id: number;
    teacher_id: number;
}
export const useSinglePage = defineStore("single-pages", {
    state: () => ({
        entry: {},
        entryData: <ListData>{},
        lists: <ListType>{},
        showModalCreate: false,
        showModalEdit: false,
        showModalShow: false,
        dialog: false,
        route: "",
        loading: false,
        query: {},
        localId: null,
        localData: {},
        errors: {}
    }),

    actions: {
        //start in create
        fetchCreateData() {
            axios.get(`${this.route}/create`).then((response) => {
                this.lists = response.data.meta;
            });
        },
        //start in edit
        fetchEditData(id: Number) {
            axios.get(`${this.route}/${id}/edit`).then((response) => {
                this.entry = response.data.data ?? [];
                this.lists = response.data.meta ?? [];
            });
        },

        sendData(url: string) {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(url + '/data', this.entryData)
                    .then((response) => {
                        usePageIndex().fetchIndexData();
                        useSettingAlert().setAlert(
                            "تم إضافة السنة المالية بنجاح",
                            "success",
                            true
                        );
                        this.dialog = false
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

        fetchShowData(id: Number) {
            this.loading = true;
            axios
                .get(`${this.route}/${id}`, { params: this.query })
                .then((response) => {
                    this.entry = response.data.data ?? [];
                    this.lists = response.data.meta ?? [];
                });
            this.loading = false
        },

        setRoute(route: string) {
            this.route = route;
        },

        setQuery(q: any) {
            this.query = q;
        },

        setId(id: any) {
            this.localId = id.id;
            this.localData = id;
        },
    },
});
