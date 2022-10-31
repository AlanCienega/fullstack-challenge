<template>
    <div class="mt-4 mb-4">
        <div class="row text-center">
            <div class="col-12 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-evenly">
                        Buffer
                        <b class="text-danger">
                            {{ getCardList(1).length }}
                        </b>
                        <button
                            class="btn btn-sm btn-outline-dark"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#formModal"
                            @click="getForm(item, 1)"
                        >
                            +
                        </button>
                    </div>
                    <div
                        class="card-body drop-zone"
                        @drop="onDrop($event, 1)"
                        @dragenter.prevent
                        @dragover.prevent
                    >
                        <div
                            :class="
                                'd-grid gap-2 btn drag-el mb-2 btn-' +
                                (new Date(item.deadline).getTime() <
                                todayDate.getTime()
                                    ? 'danger'
                                    : 'primary')
                            "
                            v-for="(item, index) in getCardList(1)"
                            :key="index"
                            draggable="true"
                            @dragstart="startDrag($event, item)"
                            data-bs-toggle="modal"
                            data-bs-target="#formModal"
                            @click="getForm(item, 2)"
                        >
                            {{ item.name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-evenly">
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
                            :class="
                                'd-grid gap-2 btn drag-el mb-2 btn-' +
                                (new Date(item.deadline).getTime() <
                                todayDate.getTime()
                                    ? 'danger'
                                    : 'primary')
                            "
                            v-for="(item, index) in getCardList(2)"
                            :key="index"
                            draggable="true"
                            @dragstart="startDrag($event, item)"
                            data-bs-toggle="modal"
                            data-bs-target="#formModal"
                            @click="getForm(item, 2)"
                        >
                            {{ item.name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-evenly">
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
                            :class="
                                'd-grid gap-2 btn drag-el mb-2 btn-' +
                                (new Date(item.deadline).getTime() <
                                todayDate.getTime()
                                    ? 'danger'
                                    : 'primary')
                            "
                            v-for="(item, index) in getCardList(3)"
                            :key="index"
                            draggable="true"
                            @dragstart="startDrag($event, item)"
                            data-bs-toggle="modal"
                            data-bs-target="#formModal"
                            @click="getForm(item, 2)"
                        >
                            {{ item.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div
            class="modal fade"
            id="formModal"
            tabindex="-1"
            aria-labelledby="modalForm"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalForm">
                            Modal title
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveCard(item, action)">
                            <label for="name">Nombre de la tarea</label>
                            <input
                                type="text"
                                class="form-control mb-2"
                                v-model="item.name"
                            />
                            <div
                                class="text-danger"
                                v-for="(error, index) in errors.name"
                                :key="index"
                            >
                                {{ error }}
                            </div>
                            <label for="deadline">Fecha limite</label>
                            <input
                                type="date"
                                name="deadline"
                                placeholder="fecha limite"
                                class="form-control"
                                v-model="item.deadline"
                            />
                            <div
                                class="text-danger"
                                v-for="(error, index) in errors.deadline"
                                :key="index"
                            >
                                {{ error }}
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { ref, reactive } from "vue";
import Swal from "sweetalert2";

export default {
    props: ["auth_user"],
    setup(props) {
        const item = reactive({
            id: null,
            name: "",
            status: 1,
            deadline: "",
            user_id: props.auth_user.id,
            action: 1,
        });
        const todayDate = reactive(new Date());
        const errors = ref([]);
        const items = ref([]);
        const is_show = ref(false);
        const loadData = async () => {
            const response = await axios.get("cards");
            items.value = response.data;
        };

        loadData();
        const getCardList = (status) => {
            return items.value.filter((item) => item.status == status);
        };

        const showModal = () => {
            is_show.value = true;
        };
        const getForm = (value, action) => {
            if (action == 2) {
                item.id = value.id;
                item.name = value.name;
                item.deadline = value.deadline;
                item.status = value.status;
            } else {
                item.name = "";
                item.deadline = "";
            }
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
            axios.put(`cards/${item.id}`, item);
        };
        const saveCard = (item, action) => {
            if (action == 1) {
                axios
                    .post("cards", item)
                    .then(() => {
                        item.name = "";
                        item.deadline = "";
                        is_show.value = false;
                        errors.value = [];
                        loadData();
                    })
                    .catch((error) => {
                        errors.value = error.response.data.errors;
                    });
            } else {
                axios.put(`cards/${item.id}`, item).then((response) => {
                    item.status = 1;
                    item.name = "";
                    item.deadline = "";
                    is_show.value = false;
                    errors.value = [];
                    loadData();
                });
            }
        };
        return {
            getCardList,
            startDrag,
            onDrop,
            showModal,
            saveCard,
            is_show,
            item,
            getForm,
            errors,
            todayDate,
        };
    },
};
</script>

<style></style>
