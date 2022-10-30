<template>
    <div class="mt-4 mb-4">
        <div class="row text-center">
            <div class="col-12 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">Buffer</div>
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
                    <div class="card-header">Working</div>
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
                    <div class="card-header">Done</div>
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
import { ref } from "vue";
export default {
    mounted() {
        console.log("Component mounted.");
    },
    setup() {
        const items = ref([
            {
                id: 1,
                name: "Agregar subtareas al kanban",
                deadline: "2022-10-30",
                status: 1,
            },
            {
                id: 2,
                name: "Testing kanban",
                deadline: "2022-10-30",
                status: 2,
            },
            {
                id: 3,
                name: "Agregar Vuex",
                deadline: "2022-10-30",
                status: 1,
            },
            {
                id: 4,
                name: "Convertir app a SPA",
                deadline: "2022-10-30",
                status: 1,
            },
        ]);
        const getCardList = (status) => {
            return items.value.filter((item) => item.status == status);
        };

        const startDrag = (event, item) => {
            console.log(item);
            event.dataTransfer.dropEffect = "move";
            event.dataTransfer.effectAllowed = "move";
            event.dataTransfer.setData("itemID", item.id);
        };
        const onDrop = (event, status) => {
            const itemID = event.dataTransfer.getData("itemID");
            const item = items.value.find((item) => item.id == itemID);
            item.status = status;
        };

        return { getCardList, startDrag, onDrop };
    },
};
</script>

<style></style>
