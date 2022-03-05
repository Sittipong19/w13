<template>
    <div>
        <ul class="nav">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="/category">Category</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/product">product</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/myorder">MyOrder</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled">Disabled</a>
  </li>
</ul>
    </div>
    <div class="flex flex-col">
    <button @click="isOpen = true" class="text-white bg-green-700 w-32 mx-auto my-5 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Order</button>
        <h1 class="text-center">Your Order Product</h1>
                <table class="max-w-7xl mx-auto">
            <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th scope="col" class="py-1 px-2 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">เวลาสั่ง</th>
                <th scope="col" class="py-1 px-2 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">ใบสั่ง</th>
                <th scope="col" class="py-1 px-2 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">ชื่อสินค้า</th>
                <th scope="col" class="py-1 px-2 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">ราคาต่อหน่วย</th>
                <th scope="col" class="py-1 px-2 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">จำนวนที่สั่ง</th>
                <th scope="col" class="py-1 px-2 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">ราคาสรุป</th>
                <th scope="col" class="py-1 px-2 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">ประเภท</th>
                <th scope="col" class="py-1 px-2 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">Action</th>
            </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="row in myorder">
                    <td class="py-1 px-2 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{moment(row.created_at).format('MMMM Do YYYY, h:mm:ss a')}}</td>
                    <td class="py-1 px-2 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.id}}</td>
                    <td class="py-1 px-2 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.product.name}}</td>
                    <td class="py-1 px-2 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.product.unit_price}}</td>
                    <td class="py-1 px-2 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.amount}}</td>
                    <td class="py-1 px-2 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.total}}</td>
                    <td class="py-1 px-2 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.product.category.name}}</td>
                    <td class="relative py-1 px-2">
                        <button @click="edit(row)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
                        <button @click="deleteRow(row)" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Del</button>

                    </td>
                </tr>
            </tbody>
        </table>     


        <div class="container mx-auto">
            <div class="flex justify-center">
                <div
                    v-show="isOpen"
                    class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50"
                >
                    <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl">{{editMode?'Edit':'New'}} Category</h3>
                            <svg
                                @click="isOpen = false"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8 text-red-900 cursor-pointer"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                    </div>
                    <!-- form -->
                    <div class="mt-4">
                         <div class="flex flex-col space-x-4">
                                <label for="product_id" class="mb-4 text-sm">Product</label>
                                <select v-model="form.product_id" required id="product_id">
                                    <option v-for="i in products" v-bind:value="i.id" >{{i.name}}</option>
                                </select>
                            </div>
                            <div class="flex flex-col space-x-4">
                                <label for="amount" class="mb-4 text-sm">Amount</label>
                                <input class="mb-4 text-sm" required id="amount" v-model="form.amount"/>
                            </div>
    

                        <button type="button" class="px-6 py-2 text-blue-800 border border-blue-600 rounded" @click="isOpen = false">Close</button>
                        <button type="submit" class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded" v-show="!editMode" @click="save(form)">Save
                        </button>
                        <button type="submit" class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded" v-show="editMode" @click="update(form)">Update
                        </button>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

</template>

<script>
import moment from 'moment'
    export default {
        components:{},
        props: ['products','myorder'],
        data() {
            return {
                editMode: false,
                form: {
                 
                    product_id:'',
                    amount:'',

                },
                isOpen : false,
                moment:moment
            }
        },
        methods: {
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {
                this.form = {

                    product_id:'',
                    amount:'',
                }
            },
            save: function (data) {
                this.$inertia.post('/myorder/', data)
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                if (!confirm('Sure')) return;
                data._method = 'PUT';
                this.$inertia.post('/myorder/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Sure')) return;
                data._method = 'DELETE';
                this.$inertia.post('/myorder/' + data.id, data)
                this.reset();
                this.closeModal();
            }
        }
    }
</script>
