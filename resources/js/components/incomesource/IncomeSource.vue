<template>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-4 mb-sm-0">
                <span class="text-uppercase page-subtitle">Credit Setup</span>
                <h3 class="page-title">Source of income</h3>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom">
                        <div class="input-group col-md-6 col-lg-4 ml-auto">
                            <button class="btn btn-primary ml-auto" @click="NewModal"><i class="fas fa-plus mr-2"></i>Add
                                new income source
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3 text-center">
                        <perfect-scrollbar>
                            <table class="table table-bordered mb-0">
                                <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">#</th>
                                    <th scope="col" class="border-0">Income Source Name</th>
                                    <th scope="col" class="border-0">Department</th>
                                    <th scope="col" class="border-0">Remarks</th>
                                    <th scope="col" class="border-0">Modify</th>
                                    <th scope="col" class="border-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <incomesource v-for="income in incomes.data" :departments="departments"
                                                          v-bind:income="income"
                                                          @delete-income="deleteIncome"
                                                          v-bind:key="income.id"></incomesource>
                                </tbody>
                            </table>
                        </perfect-scrollbar>
                    </div>
                    <div class="card-footer">
                        <pagination :data="incomes" @pagination-change-page="getResults">
                            <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewLabel">Add New Income Source</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createIncome" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" v-model="form.income_source" name="income_source" class="form-control" id="validationServer01"
                                       placeholder="Income Source Name" :class="{ 'is-invalid': form.errors.has('income_source') }">
                                <has-error :form="form" field="income_source"></has-error>
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model="form.department_id" name="department_id"
                                        :class="{ 'is-invalid': form.errors.has('department_id') }">
                                    <option value="" selected="" disabled>Choose Department</option>
                                    <option v-for="department in departments.data"
                                            v-bind:value="department.id">{{department.name}}</option>
                                </select>
                                <has-error :form="form" field="department_id"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" v-model="form.remarks" name="remarks" class="form-control" id="validationServer01"
                                       placeholder="Remarks" :class="{ 'is-invalid': form.errors.has('remarks') }">
                                <has-error :form="form" field="remarks"></has-error>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import incomesource from './incomeSourceEdit';
    export default {
        data() {
            return {
                departments: {},
                incomes: {},
                form: new Form({
                    income_source: '',
                    department_id: '',
                    remarks: ''
                })
            }
        },
        methods: {
            NewModal() {
                this.form.reset();
                $('#addNew').modal('show');
            },
            loadDepartment() {
                axios.get('api/department').then(({data}) => (this.departments = data));
            },
            loadIncome() {
                axios.get('api/incomesource').then(({data}) => (this.incomes = data));
            },
            getResults(page = 1) {
                axios.get('api/incomesource?page=' + page)
                    .then(response => {
                        this.incomes = response.data;
                    });
            },
            deleteIncome(id) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start()
                        this.form.delete('api/incomesource/' + id)
                            .then((data) => {
                                Fire.$emit('AfterCreate');
                                swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                this.$Progress.finish()
                            })
                            .catch(() => {
                                this.$Progress.fail()
                                swal("Failed!", 'There was something wrong.', 'warning')
                            });
                    }
                })
            },
            createIncome() {
                this.$Progress.start()
                this.form.post('api/incomesource')
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Income source name create successfully'
                        })
                        this.form.reset()
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                        $('#addNew').modal('hide');
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                        swal("Failed!", 'There was something wrong.', 'warning')
                    })
            }
        },
        created() {
            this.loadDepartment();
            this.loadIncome();
            Fire.$on('AfterCreate', () => {
                this.loadIncome();
            });
        },
        components:{
            incomesource
        }
    }
</script>
