<template>
    <div class="card">
        <div class="card-body">
            <div class="row ">
                <select
                    v-model="country"
                    v-on:change="filterByCountryAndState($event)"
                    style="margin-right:5px"
                    class="form-select col"
                    aria-label="Default select example"
                >
                    <!-- "Cameroon", "Ethiopia", "Morocco","Mozambique","Uganda" -->
                    <option value="" selected>Select Country</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Uganda">Uganda</option>
                </select>

                <select
                    v-model="state"
                    v-on:change="filterByCountryAndState($event)"
                    class="form-select col"
                    aria-label="Default select example"
                >
                    <option value="" selected>Validate Phone Number</option>
                    <option value="valid">Valid</option>
                    <option value="invalid">InValid</option>
                </select>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Country</th>
                        <th scope="col">State</th>
                        <th scope="col">Country Code</th>
                        <th scope="col">Phone Num</th>
                    </tr>
                </thead>
                <tbody v-if="list && list.data.length > 0">
                    <tr v-for="(item, index) in list.data" :key="index">
                        <td>{{ item.id }}</td>
                        <td>{{ item.country }}</td>
                        <td>{{ item.state }}</td>
                        <td>{{ item.code }}</td>
                        <td>{{ item.phone }}</td>
                    </tr>
                </tbody>
            </table>

            <pagination
                align="center"
                :data="list"
                @pagination-change-page="listAll"
            ></pagination>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import pagination from "laravel-vue-pagination";
export default {
    data() {
        return {
            list: {},
            country: null,
            state: null
        };
    },
    methods: {
        async listAll(page = 1) {
            let url = `filter?page=${page}`;
            if (this.country !== null && this.country !== "") {
                url = url + `&country=${this.country}`;
            }

            if (this.state !== null && this.state !== "") {
                url = url + `&state=${this.state}`;
            }
            console.log(url,this.country,this.state,"consol log");
            await axios
                .get(`${url}`)
                .then(({ data }) => {
                    this.list = data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        async filterByCountryAndState(event, page = 1) {
            console.log(this.country, this.state);

            let url = `filter?page=${page}`;
            if (this.country !== null && this.country !== "") {
                url = url + `&country=${this.country}`;
            }

            if (this.state !== null && this.state !== "") {
                url = url + `&state=${this.state}`;
            }

            console.log(url);

            await axios
                .get(`${url}`)
                .then(({ data }) => {
                    this.list = data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        }
    },
    mounted() {
        this.listAll();
    },
    components: {
        pagination
    }
};
</script>
