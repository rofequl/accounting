<template>
    <tr>
        <td>{{department.id}}</td>
        <td>
            <input type="text" class="form-control" v-model="form.name" v-if="edit">
            <span v-else>{{department.name}}</span>
        </td>
        <td>0</td>
        <td>{{department.updated_at | myDate}}</td>
        <td>
            <div class="btn-group d-table mx-auto" role="group" aria-label="Basic example">
                <button type="button" @click='editDepartments' v-if="!edit" class="btn btn-sm btn-white"><i
                    class="fas fa-edit mr-1"></i>Edit
                </button>
                <button type="button" @click='updateDepartment(department.id)' v-if="edit" class="btn btn-sm btn-white">
                    <i class="fas fa-check-square mr-1"></i>Update
                </button>
                <button type="button" @click='editDepartmentsCancel' v-if="edit" class="btn btn-sm btn-white">
                    <i class="fas fa-window-close mr-1"></i>Cancel
                </button>
                <button type="button" @click="$emit('delete-departments',department.id)" v-if="!edit"
                        class="btn btn-sm btn-white"><i
                    class="fas fa-trash mr-1"></i>Delete
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['department'],
        data() {
            return {
                edit: false,
                form: new Form({
                    name: ''
                })
            }
        },
        methods: {
            editDepartments() {
                this.edit = true;
                this.form.name = this.department.name;
            },
            editDepartmentsCancel() {
                this.edit = false;
                this.editForm.name = '';
            },
            updateDepartment(id) {
                this.$Progress.start()
                this.form.put('api/department/'+id)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Department create successfully'
                        })
                        Fire.$emit('AfterCreate');
                        this.$Progress.finish();
                        this.editDepartmentsCancel();
                    })
                    .catch (error => {
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
        }
    }
</script>
