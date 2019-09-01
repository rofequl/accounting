<template>
    <tr>
        <td>{{payment.id}}</td>
        <td>
            <input type="text" class="form-control" v-model="form.name" v-if="edit">
            <span v-else>{{payment.name}}</span>
        </td>
        <td>
            <input type="number" class="form-control" v-model="form.amount" v-if="edit">
            <span v-else>{{payment.amount}}</span>
        </td>
        <td>{{payment.updated_at | myDate}}</td>
        <td>
            <div class="btn-group d-table mx-auto" role="group" aria-label="Basic example">
                <button type="button" @click='editPayment' v-if="!edit" class="btn btn-sm btn-white"><i
                    class="fas fa-edit mr-1"></i>Edit
                </button>
                <button type="button" @click='updatePayment(payment.id)' v-if="edit" class="btn btn-sm btn-white">
                    <i class="fas fa-check-square mr-1"></i>Update
                </button>
                <button type="button" @click='editPaymentCancel' v-if="edit" class="btn btn-sm btn-white">
                    <i class="fas fa-window-close mr-1"></i>Cancel
                </button>
                <button type="button" @click="$emit('delete-payment',payment.id)" v-if="!edit"
                        class="btn btn-sm btn-white"><i
                    class="fas fa-trash mr-1"></i>Delete
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['payment'],
        data() {
            return {
                edit: false,
                form: new Form({
                    name: '',
                    amount: ''
                })
            }
        },
        methods: {
            editPayment() {
                this.edit = true;
                this.form.fill (this.payment)
            },
            editPaymentCancel() {
                this.edit = false;
                this.form.reset()
            },
            updatePayment(id) {
                this.$Progress.start()
                this.form.put('api/payment/'+id)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Payment System update successfully'
                        })
                        Fire.$emit('AfterCreate');
                        this.$Progress.finish();
                        this.editPaymentCancel();
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

<style scoped>

</style>
