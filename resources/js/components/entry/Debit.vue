<template>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-4 mb-sm-0">
                <span class="text-uppercase page-subtitle">Debit Setup</span>
                <h3 class="page-title">Debit Entry</h3>
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
                                Debit Entry
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3 text-center">
                        <perfect-scrollbar>
                            <table class="table table-bordered mb-0">
                                <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">Sr</th>
                                    <th scope="col" class="border-0">Voucher No</th>
                                    <th scope="col" class="border-0">Image</th>
                                    <th scope="col" class="border-0">Department</th>
                                    <th scope="col" class="border-0">Expenditure Head</th>
                                    <th scope="col" class="border-0">Amount</th>
                                    <th scope="col" class="border-0">Payment Method</th>
                                    <th scope="col" class="border-0">Previous Balance</th>
                                    <th scope="col" class="border-0">Total Amount</th>
                                    <th scope="col" class="border-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="dedit in dedits.data" v-bind:key="dedit.id">
                                    <td>{{dedit.id}}</td>
                                    <td>{{dedit.voucher_no}}</td>
                                    <td>
                                        <img :src="getProfilePhoto(dedit.image)" style="cursor:pointer;" class="img-thumbnail" :class="randomClass(dedit.image)" @click="randomUrl(dedit.image)" width="80px">
                                    </td>
                                    <td>{{dedit.department.name}}</td>
                                    <td>{{dedit.expenditure.name}}</td>
                                    <td>{{dedit.amount}}</td>
                                    <td>{{dedit.payment.name}}</td>
                                    <td>{{dedit.previous_amount}}</td>
                                    <td>{{dedit.total_amount}}</td>
                                    <td>
                                        <div class="btn-group d-inline-flex mx-auto" role="group"
                                             aria-label="Basic example">
                                            <!--                                            <button type="button" @click="NewModalUpdate(dedit)"-->
                                            <!--                                                    class="btn btn-sm btn-white"><i-->
                                            <!--                                                class="fas fa-edit mr-1"></i>-->
                                            <!--                                            </button>-->
                                            <button type="button" @click="deleteDedit(dedit.id)"
                                                    class="btn btn-sm btn-white"><i
                                                class="fas fa-trash mr-1"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </perfect-scrollbar>
                    </div>
                    <div class="card-footer">
                        <pagination :data="dedits" @pagination-change-page="getResults">
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
                        <h5 class="modal-title" id="addNewLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateDebit() : createDebit()"
                          @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <date-picker v-model="form.date" :config="options"></date-picker>
                                    <has-error :form="form" field="date"></has-error>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" v-model="form.voucher_no" name="voucher_no" class="form-control"
                                           id="voucher_no" value="ok"
                                           placeholder="Voucher No"
                                           :class="{ 'is-invalid': form.errors.has('voucher_no') }" readonly>
                                    <has-error :form="form" field="voucher_no"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <select class="form-control"
                                            v-model="form.department_id" name="department_id"
                                            :class="{ 'is-invalid': form.errors.has('department_id') }">
                                        <option value="" selected="" disabled>Choose Department</option>
                                        <option v-for="department in departments"
                                                v-bind:value="department.id">{{department.name}}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="department_id"></has-error>
                                </div>
                                <div class="form-group col-md-6">
                                    <select class="form-control" v-model="form.expenditure_id" name="expenditure_id"
                                            :class="{ 'is-invalid': form.errors.has('expenditure_id') }">
                                        <option value="" selected="" disabled>Choose Ependiture Head</option>
                                        <option v-for="expenditure in expenditures"
                                                v-bind:value="expenditure.id">{{expenditure.name}}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="expenditure_id"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-seamless">
                                        <input type="text" v-model="form.amount" name="amount" class="form-control"
                                               id="amount" v-on:keyup="keytotal"
                                               placeholder="Amount"
                                               :class="{ 'is-invalid': form.errors.has('amount') }">
                                        <span class="input-group-append">
                                          <span class="input-group-text">&#2547;</span>
                                        </span>
                                    </div>
                                    <has-error :form="form" field="amount"></has-error>
                                </div>
                                <div class="form-group col-md-6">
                                    <select class="form-control" @change="changePayment($event)"
                                            v-model="form.payment_id" name="payment_id"
                                            :class="{ 'is-invalid': form.errors.has('payment_id') }">
                                        <option value="" selected="" disabled>Choose Payment Method</option>
                                        <option v-for="payment in payments"
                                                v-bind:value="payment.id">{{payment.name}}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="payment_id"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-seamless">
                                        <input type="number" v-model.number="form.previous_amount"
                                               name="previous_amount"
                                               class="form-control" id="previous_amount"
                                               placeholder="Previous Balance"
                                               :class="{ 'is-invalid': form.errors.has('previous_amount') }" readonly>
                                        <span class="input-group-append">
                                          <span class="input-group-text">&#2547;</span>
                                        </span>
                                    </div>
                                    <has-error :form="form" field="previous_amount"></has-error>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-seamless">
                                        <input type="text" v-model="form.total_amount"
                                               name="total_amount"
                                               class="form-control" id="total_amount"
                                               placeholder="Total Amount"
                                               :class="{ 'is-invalid': form.errors.has('total_amount') }" readonly>
                                        <span class="input-group-append">
                                          <span class="input-group-text">&#2547;</span>
                                        </span>
                                    </div>
                                    <has-error :form="form" field="total_amount"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" v-model="form.remarks" name="remarks" class="form-control"
                                           id="validationServer01"
                                           placeholder="Remarks" :class="{ 'is-invalid': form.errors.has('remarks') }">
                                    <has-error :form="form" field="remarks"></has-error>
                                </div>
                                <div class="input-group col-md-6 mb-3">
                                    <div class="custom-file">
                                        <input @change="imageUpload" name="image" type="file" class="custom-file-input"
                                               id="customFile2">
                                        <label class="custom-file-label" for="customFile2">Choose image...</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" v-if="editMode" class="btn btn-primary">Update</button>
                            <button type="submit" v-if="!editMode" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                departments: {},
                expenditures: {},
                payments: {},
                dedits: {},
                editMode: false,
                form: new Form({
                    id: '',
                    date: '',
                    voucher_no: '',
                    department_id: '',
                    expenditure_id: '',
                    payment_id: '',
                    previous_amount: '',
                    total_amount: '',
                    amount: '',
                    remarks: '',
                    image: ''
                }),
                date: new Date(),
                options: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                }
            }
        },
        methods: {
            randomClass (e) {
                return e==null?'d-none':'';
            },
            randomUrl (e) {
                    window.open('image/credit/'+e, '_blank');

            },
            getProfilePhoto(e) {
                return "image/credit/" + e;
            },
            imageUpload(e) {
                let file = e.target.files[0];
                if (!file.type.match('image.*')) {
                    swal.fire(
                        'Oops...!',
                        `${file.name} is not an image..`,
                        'error'
                    );
                    return;
                }
                if (file['size'] > 2111775) {
                    swal.fire(
                        'Oops...!',
                        'You are uploading a learge file.',
                        'error'
                    );
                    return;
                }
                let reader = new FileReader();
                let vm = this;
                reader.onloadend = (file) => {
                    vm.form.image = reader.result;
                    //console.log(reader.result);
                };
                reader.readAsDataURL(file);
            },
            NewModal() {
                this.form.reset();
                this.form.clear();
                this.editMode = false;
                this.form.date = this.date;
                this.form.voucher_no = Math.floor(Math.random() * 899) + 100 + '' + this.dedits.total;
                $('#addNew').modal('show');
                $('#addNewLabel').html('Insert debit entry');
            },
            NewModalUpdate(data) {
                this.form.reset();
                this.form.clear();
                this.form.fill(data);
                this.editMode = true;
                $('#addNew').modal('show');
                $('#addNewLabel').html('Update debit entry');
            },
            loadExpenditure() {
                axios.get('api/expenditure-all').then(({data}) => (this.expenditures = data));
            },
            loadDepartment() {
                axios.get('api/department-all').then(({data}) => (this.departments = data));
            },
            loadDedit() {
                axios.get('api/debit').then(({data}) => (this.dedits = data));
            },
            loadPayment() {
                axios.get('api/payment-all').then(({data}) => (this.payments = data));
            },
            changePayment(event) {
                axios.get('api/payment/' + event.target.value).then(data => {
                    this.form.previous_amount = data.data.amount == null ? 0 : data.data.amount;
                    let number = isNaN(parseFloat(this.form.amount)) ? 0 : parseFloat(this.form.amount);
                    let number2 = isNaN(parseFloat(data.data.amount)) ? 0 : parseFloat(data.data.amount);
                    this.form.total_amount = number2 - number;
                });
            },
            getResults(page = 1) {
                axios.get('api/debit?page=' + page)
                    .then(response => {
                        this.dedits = response.data;
                    });
            },
            keytotal: function () {
                let number = isNaN(parseFloat(this.form.amount)) ? 0 : parseFloat(this.form.amount);
                let number2 = isNaN(parseFloat(this.form.previous_amount)) ? 0 : parseFloat(this.form.previous_amount);
                this.form.total_amount = number2 - number;
            },
            createDebit() {
                this.$Progress.start()
                this.form.post('api/debit')
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Debit entry successfully'
                        })
                        this.form.reset()
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                        $('#addNew').modal('hide');
                    })
                    .catch(() => {
                        this.$Progress.fail()
                        swal("Failed!", 'There was something wrong.', 'warning')
                    })
            },
            deleteDedit(id) {
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
                        this.form.delete('api/debit/' + id)
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
            updateDebit() {
                this.$Progress.start()
                this.form.put('api/debit/' + this.form.id)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Debit entry successfully'
                        })
                        this.form.reset()
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                        $('#addNew').modal('hide');
                    })
                    .catch(() => {
                        this.$Progress.fail()
                        swal("Failed!", 'There was something wrong.', 'warning')
                    })
            },
        },
        created() {
            this.loadDedit();
            this.loadDepartment();
            this.loadExpenditure();
            this.loadPayment();
            Fire.$on('AfterCreate', () => {
                this.loadDedit();
            });
        },
    }
</script>

<style scoped>

</style>
