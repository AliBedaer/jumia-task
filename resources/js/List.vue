<template>
    <div class="card">
        <div class="card-body">
            <div class="row ">
                <select
                    class="form-select col"
                    aria-label="Default select example"
                >
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>

                <select
                    class="form-select col"
                    aria-label="Default select example"
                >
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <button class="btn btn-primary" type="button">Button</button>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fields: [
                // A column that needs custom formatting
                { key: "name", label: "Full Name" },
                // A regular column
                "age",
                // A regular column
                "sex"
            ],
            items: [
                { name: { first: "John", last: "Doe" }, sex: "Male", age: 42 },
                {
                    name: { first: "Jane", last: "Doe" },
                    sex: "Female",
                    age: 36
                },
                {
                    name: { first: "Rubin", last: "Kincade" },
                    sex: "Male",
                    age: 73
                },
                {
                    name: { first: "Shirley", last: "Partridge" },
                    sex: "Female",
                    age: 62
                }
            ]
        };
    }
};
</script>
