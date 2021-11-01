<template>
    <div
        id="app"
        class="position-absolute top-50 start-50 translate-middle col-6"
    >
        <list></list>
    </div>
</template>

<script>
function Crud({ id, color, name }) {
    this.id = id;
    this.color = color;
    this.name = name;
}

import CrudComponent from "./CrudComponent.vue";
import List from "./List.vue";

export default {
    data() {
        return {
            cruds: []
        };
    },
    methods: {
        async create() {
            // To do
        },
        async read() {
            // To do
        },
        async update(id, color) {
            // To do
        },
        async del(id) {
            // To do
        }
    },
    components: {
        CrudComponent,
        List
    }
};
</script>
