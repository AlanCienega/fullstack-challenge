<template>
    <div class="mt-4 mb-4">
        <div class="row text-center">
            <div class="col-12 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        Buffer
                        <b class="text-danger">
                            {{ getCardList(1).length }}
                        </b>
                    </div>
                    <div
                        class="card-body drop-zone"
                        @drop="onDrop($event, 1)"
                        @dragenter.prevent
                        @dragover.prevent
                    >
                        <div
                            class="d-grid gap-2 btn btn-primary drag-el mb-2"
                            v-for="(item, index) in getCardList(1)"
                            :key="index"
                            draggable="true"
                            @dragstart="startDrag($event, item)"
                        >
                            {{ item.name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        Working
                        <b class="text-warning">
                            {{ getCardList(2).length }}
                        </b>
                    </div>
                    <div
                        class="card-body drop-zone"
                        @drop="onDrop($event, 2)"
                        @dragenter.prevent
                        @dragover.prevent
                    >
                        <div
                            class="d-grid gap-2 btn btn-primary drag-el mb-2"
                            v-for="(item, index) in getCardList(2)"
                            :key="index"
                            draggable="true"
                            @dragstart="startDrag($event, item)"
                        >
                            {{ item.name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Done
                        <b class="text-success">{{ getCardList(3).length }}</b>
                    </div>
                    <div
                        class="card-body drop-zone"
                        @drop="onDrop($event, 3)"
                        @dragenter.prevent
                        @dragover.prevent
                    >
                        <div
                            v-for="(item, index) in getCardList(3)"
                            :key="index"
                            class="d-grid gap-2 btn btn-primary drag-el mb-2"
                            draggable="true"
                            @dragstart="startDrag($event, item)"
                        >
                            {{ item.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
    setup() {
        const items = ref([]);
        const loadData = async () => {
            const response = await axios.get("cards");
            items.value = response.data;
        };

        loadData();
        const getCardList = (status) => {
            return items.value.filter((item) => item.status == status);
        };

        const startDrag = (event, item) => {
            event.dataTransfer.dropEffect = "move";
            event.dataTransfer.effectAllowed = "move";
            event.dataTransfer.setData("itemID", item.id);
        };
        const onDrop = (event, status) => {
            const itemID = event.dataTransfer.getData("itemID");
            const item = items.value.find((item) => item.id == itemID);
            item.status = status;
            if (status == 3) {
                Swal.fire("¡Felicitaciones por lograrlo!", "", "success");
            }
            axios.put(`cards/${item.id}`, item).then((response) => {});
        };

        return { getCardList, startDrag, onDrop };
    },
};
</script>

<style></style>
