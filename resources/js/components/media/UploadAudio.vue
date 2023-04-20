<template>
    <div
        @click.stop="selectImage"
    >
        <input
            id="fileInput"
            type="file"
            accept="audio/*"
            @input="updateValue"
        />
    </div>
</template>

<script>
export default {
    data() {
        return {
            input: undefined,
            imageFile: undefined,
            mask: false,
            loading: false,
            alert: false,
        };
    },
    props: ["modelValue", "id", "loading"],
    emits: ["update:modelValue"],

    mounted() {
        this.input = document.getElementById("fileInput");
    },
    methods: {
        selectImage() {
            if (!this.imageFile) {
                this.input.click();
            }
        },
        updateValue(event) {
            this.imageFile = event.target.files[0];
            this.$emit("input", this.imageFile);
            this.$emit("update:modelValue", this.imageFile);
        },
        deleteImage() {
            if (this.imageFile) {
                this.imageFile = undefined;
                this.mask = false;
                this.input.value = ""; // <-- this will fix the issue
                this.$emit("input", undefined);
                this.$emit("update:modelValue", this.imageFile);
            }
        },
    },
};
</script>

<style scoped></style>
