<template>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-4 mb-sm-0">
                <span class="text-uppercase page-subtitle">Payment Manage</span>
                <h3 class="page-title">Payment System</h3>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom">
                        <div class="input-group col-md-6 col-lg-4 ml-auto">
                            <button class="btn btn-primary ml-auto" @click="NewModal"><i class="fas fa-plus mr-2"></i>
                                Create Payment System
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3 text-center">
                        <perfect-scrollbar>
                            <table class="table table-bordered mb-0">
                                <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">#</th>
                                    <th scope="col" class="border-0">Payment System Name</th>
                                    <th scope="col" class="border-0">Amount</th>
                                    <th scope="col" class="border-0">Last Modify</th>
                                    <th scope="col" class="border-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <paymentedit v-for="payment in payments.data"
                                              v-bind:payment="payment"
                                              @delete-payment="deletePayment"
                                              v-bind:key="payment.id"></paymentedit>
                                </tbody>
                            </table>
                        </perfect-scrollbar>
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
                        <h5 class="modal-title" id="addNewLabel">Create a new payment system</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createPayment" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" v-model="form.name" name="name" class="form-control" id="validationServer01"
                                       placeholder="Payment System Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-seamless">
                                    <input type="number" v-model="form.amount" name="amount" class="form-control"
                                           id="amount"
                                           placeholder="Amount"
                                           :class="{ 'is-invalid': form.errors.has('amount') }">
                                    <span class="input-group-append">
                                          <span class="input-group-text">&#2547;</span>
                                        </span>
                                    <has-error :form="form" class="d-block" field="amount"></has-error>
                                </div>
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
    import paymentedit from './PaymentEdit';
    export default {
        data() {
            return {
                payments: {},
                form: new Form({
                    name: '',
                    amount: ''
                })
            }
        },
        methods: {
            NewModal() {
                this.form.reset();
                this.form.clear();
                $('#addNew').modal('show');
            },
            createPayment() {
                this.$Progress.start()
                this.form.post('api/payment')
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Payment System create successfully'
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
            },
            loadPayment() {
                axios.get('api/payment').then(({data}) => (this.payments = data));
            },
            deletePayment(id) {
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
                        this.form.delete('api/payment/' + id)
                            .then((data) => {
                                if(data.data.error){
                                    swal.fire(
                                        'Can\'t Deleted!',
                                        data.data.error,
                                        'warning'
                                    )
                                }else{
                                    Fire.$emit('AfterCreate');
                                    swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    this.$Progress.finish()
                                }
                            })
                            .catch(() => {
                                this.$Progress.fail()
                                swal("Failed!", 'There was something wrong.', 'warning')
                            });
                    }
                })
            },
        },
        created() {
            this.loadPayment();
            Fire.$on('AfterCreate', () => {
                this.loadPayment();
            });
        },
        components:{
            paymentedit
        }
    }
</script>
