<template>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-4 mb-sm-0">
                <span class="text-uppercase page-subtitle">Credit Setup</span>
                <h3 class="page-title">Department</h3>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom">
                        <form class="input-group col-md-6 col-lg-4 ml-auto" @submit.prevent="createDepartment"
                              @keydown="form.onKeydown($event)">
                            <input type="text" v-model="form.name" class="form-control border"
                                   placeholder="Add New Department"
                                   aria-label="Add New Department" name="name">
                            <div class="input-group-append">
                                <button class="btn btn-primary shadow-none px-2" type="submit">
                                    <i class="material-icons">add</i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body p-0 pb-3 text-center">
                        <perfect-scrollbar>
                            <table class="table table-bordered mb-0">
                                <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">#</th>
                                    <th scope="col" class="border-0">Department Name</th>
                                    <th scope="col" class="border-0">How many source</th>
                                    <th scope="col" class="border-0">Modify</th>
                                    <th scope="col" class="border-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <departmentEdit v-for="department in departments.data"
                                                          v-bind:department="department"
                                                          @delete-departments="deleteDepartment"
                                                          v-bind:key="department.id"></departmentEdit>
                                </tbody>
                            </table>
                        </perfect-scrollbar>
                    </div>
                    <div class="card-footer">
                        <pagination :data="departments" @pagination-change-page="getResults">
                            <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
                </div>
            </div>


        </div>
        <!-- End Default Light Table -->
        </div>
</template>

<script>
    import departmentEdit from './DepartmentEdit'
    export default {
        data() {
            return {
                departments: {},
                form: new Form({
                    name: ''
                })
            }
        },
        methods: {
            loadDepartment() {
                axios.get('api/department').then(({data}) => (this.departments = data));
            },
            getResults(page = 1) {
                axios.get('api/department?page=' + page)
                    .then(response => {
                        this.departments = response.data;
                    });
            },
            deleteDepartment(id) {
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
                        this.form.delete('api/department/' + id)
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
            createDepartment() {
                this.$Progress.start()
                this.form.post('api/department')
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Department create successfully'
                        })
                        this.form.reset()
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        let data = error.response;
                        if (data.status === 422) {
                            let allData = '', mainData = '';
                            $.each(data.data.errors, function (key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function (key, value) {
                                        allData += value + "<br/>";
                                    });
                                } else {
                                    mainData += value + "<br/>";
                                }
                            });
                            swal.fire({
                                title: 'Warning',
                                html: mainData,
                                type: 'error'
                            })
                            this.$Progress.fail()
                        }
                    })
            }
        },
        created() {
            this.loadDepartment();
            Fire.$on('AfterCreate', () => {
                this.loadDepartment();
            });
        },
        components:{
            departmentEdit
        }
    }
</script>
