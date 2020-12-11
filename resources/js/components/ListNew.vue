<template>
    <div class="users-style">
        <div style="margin-bottom: 20px;">
            <h2>Daily Currency Rates</h2>
        </div>
        <div class="table-style">
            <input class="input" type="text" v-model="search" placeholder="Search..."
                   @input="resetPagination()" style="width: 250px;">
            <div class="control">
                <div class="select">
                    <select v-model="length" @change="resetPagination()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th v-for="column in columns" :key="column.name" @click="sortBy(column.name)"
                    :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                    style="width: 40%; cursor:pointer;">
                    {{column.label}}
                </th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="curr in paginatedcurrency" :key="curr.id">
                <td>{{curr.currency_id}}</td>
                <td>{{curr.name}}</td>
                <td>{{curr.rate}}</td>
                <td>{{curr.nominal}}</td>
                <td>{{curr.numcode}}</td>
                <td>{{curr.charcode}}</td>
                <td>{{curr.date}}</td>
                <td>
                    <button v-if="showAction" class="btn btn-grey btn-primary"
                            @click="currencyHistory(curr.currency_id)">History
                    </button>
                    <button v-else class="btn btn-grey btn-primary" @click="getcurrency()">Back</button>

                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <nav class="pagination" v-if="!tableShow.showdata">
                <span class="page-stats">{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</span>
                <a v-if="pagination.prevPageUrl" class="btn btn-sm btn-primary pagination-previous"
                   @click="--pagination.currentPage"> Prev </a>
                <a class="btn btn-sm btn-primary pagination-previous" v-else disabled> Prev </a>
                <a v-if="pagination.nextPageUrl" class="btn btn-sm pagination-next" @click="++pagination.currentPage">
                    Next </a>
                <a class="btn btn-sm btn-primary pagination-next" v-else disabled> Next </a>
            </nav>
            <nav class="pagination" v-else>
<span class="page-stats">
{{pagination.from}} - {{pagination.to}} of {{filteredcurrency.length}}
<span v-if="`filteredcurrency.length < pagination.total`"></span>
</span>
                <a v-if="pagination.prevPage" class="btn btn-sm btn-primary pagination-previous"
                   @click="--pagination.currentPage"> Prev </a>
                <a class="btn btn-sm pagination-previous btn-primary" v-else disabled> Prev </a>
                <a v-if="pagination.nextPage" class="btn btn-sm btn-primary pagination-next"
                   @click="++pagination.currentPage"> Next </a>
                <a class="btn btn-sm pagination-next btn-primary" v-else disabled> Next </a>
            </nav>
        </div>

    </div>
</template>
<script>
    // import apexchart from 'apexcharts';
    import chart from "apexcharts";


    export default {
        components: {apexchart: chart },
        created() {
            this.getcurrency();

        },

        data() {

            let sortOrders = {};
            let columns = [
                {label: 'Currency ID', name: 'currency_id'},
                {label: 'Name', name: 'currency_name'},
                {label: 'Rate', name: 'rate'},
                {label: 'Nominal', name: 'nominal'},
                {label: 'NumCode', name: 'numcode'},
                {label: 'CharCode', name: 'charcode'},
                {label: 'Date Added', name: 'date'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                currency: [],
                columns: columns,
                sortKey: 'created_at',
                sortOrders: sortOrders,
                length: 10,
                search: '',
                tableShow: {
                    showdata: true,
                },
                pagination: {
                    currentPage: 1,
                    total: '',
                    nextPage: '',
                    prevPage: '',
                    from: '',
                    to: ''
                },
                showAction: true,

            }
        },
        methods: {
            currencyHistory(id) {

                this.showAction = false;
                axios.get('/api/history', {params: {id: id}})
                    .then(response => {
                        // console.log('The data: ', response.data.data)
                        this.currency = response.data.data;
                        this.pagination.total = this.currency.length;

                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },

            getcurrency() {
                this.showAction = true;
                axios.get('/api/currency')
                    .then(response => {
                        // console.log('The data: ', response.data.data)
                        this.currency = response.data.data;
                        this.pagination.total = this.currency.length;

                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            paginate(array, length, pageNumber) {
                this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
                this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
                this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
                this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
                return array.slice((pageNumber - 1) * length, pageNumber * length);
            },
            resetPagination() {
                this.pagination.currentPage = 1;
                this.pagination.prevPage = '';
                this.pagination.nextPage = '';
            },
            sortBy(key) {
                this.resetPagination();
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
        },
        computed: {
            filteredcurrency() {
                let currency = this.currency;
                if (this.search) {
                    currency = currency.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                        })
                    });
                }

                return currency;
            },
            paginatedcurrency() {
                // console.log(this.filteredcurrency,this.pagination.currentPage, 'lklk');
                return this.paginate(this.filteredcurrency, this.length, this.pagination.currentPage);
            }
        }
    };
</script>

<style>
    .users-style {
        width: 100%;
        margin: auto;
        margin-top: 20px;
    }

    .users-style .table-style {
        margin-bottom: 10px;
    }

    .users-style .table-style input {
        width: 175px;
    }

    .users-style .table-style .control {
        float: right;
    }

    .users-style .table {
        width: 100%;
    }

    .users-style nav a {
        color: white !important;
        margin-right: 10px;
    }

    h1 {
        text-align: center;
        font-size: 30px;
    }

    .pagination {
        justify-content: flex-end !important;
    }

    .pagination .page-stats {
        align-items: center;
        margin-right: 5px;
    }

    .pagination i {
        color: #3273dc !important;
    }

</style>
