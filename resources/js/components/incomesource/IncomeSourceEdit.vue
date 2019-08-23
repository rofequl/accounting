<template>
    <tr>
        <td>{{income.id}}</td>
        <td>
            <input type="text" class="form-control" v-model="form.income_source" v-if="edit">
            <span v-else>{{income.income_source}}</span>
        </td>
        <td>
            <select class="form-control" v-model="form.department_id" name="department"
                    :class="{ 'is-invalid': form.errors.has('department_id') }" v-if="edit">
                <option value="" selected="" disabled>Choose Department</option>
                <option v-for="department in departments.data"
                        v-bind:value="department.id">{{department.name}}</option>
            </select>
            <span v-else>{{income.department.name}}</span>
        </td>
        <td>
            <input type="text" class="form-control" v-model="form.remarks" v-if="edit">
            <span v-else>{{income.remarks}}</span>
        </td>
        <td>{{income.updated_at | myDate}}</td>
        <td>
            <div class="btn-group d-table mx-auto" role="group" aria-label="Basic example">
                <button type="button" @click='editIncome' v-if="!edit" class="btn btn-sm btn-white"><i
                    class="fas fa-edit mr-1"></i>Edit
                </button>
                <button type="button" @click='updateIncome(income.id)' v-if="edit" class="btn btn-sm btn-white">
                    <i class="fas fa-check-square mr-1"></i>Update
                </button>
                <button type="button" @click='editIncomeCancel' v-if="edit" class="btn btn-sm btn-white">
                    <i class="fas fa-window-close mr-1"></i>Cancel
                </button>
                <button type="button" @click="$emit('delete-income',income.id)" v-if="!edit"
                        class="btn btn-sm btn-white"><i
                    class="fas fa-trash mr-1"></i>Delete
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['income','departments'],
        data() {
            return {
                edit: false,
                form: new Form({
                    income_source: '',
                    department_id: '',
                    remarks: ''
                })
            }
        },
        methods: {
            editIncome() {
                this.edit = true;
                this.form.fill (this.income)
            },
            editIncomeCancel() {
                this.edit = false;
                this.form.reset()
            },
            updateIncome(id) {
                this.$Progress.start()
                this.form.put('api/incomesource/'+id)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Income source update successfully'
                        })
                        Fire.$emit('AfterCreate');
                        this.$Progress.finish();
                        this.editIncomeCancel();
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
