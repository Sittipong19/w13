// teacher code
<template>

    <div class="flex flex-col">
        <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="add-category-modal" @click="isOpen = true">Add New</button>
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">Name</th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-right text-gray-700 uppercase dark:text-gray-400">Unit Price</th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-right text-gray-700 uppercase dark:text-gray-400">Cost Price</th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-right text-gray-700 uppercase dark:text-gray-400">Stock Quantity</th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">Action</th>
            </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="row in products">
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.name}}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.unit_price}}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.cost_price}}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">{{row.stock_qty}}</td>
                    <td class="relative py-3 px-6">
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
                        <h3 class="text-2xl">{{editMode?'Edit':'New'}} Product</h3>
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
                    <div class="mt-4">
                            <div class="flex flex-col space-x-4">
                                <label for="name" class="mb-4 text-sm">Name</label>
                                <input class="mb-4 text-sm" required id="name" v-model="form.name"/>
                            </div>
                            <div class="flex flex-col space-x-4">
                                <label for="unit_price" class="mb-4 text-sm">Unit Price</label>
                                <input class="mb-4 text-sm"  id="unit_price" v-model="form.unit_price"/>
                            </div>
                            <div class="flex flex-col space-x-4">
                                <label for="cost_price" class="mb-4 text-sm">Cost Price</label>
                                <input class="mb-4 text-sm"  id="cost_price" v-model="form.cost_price"/>
                            </div>
                            <div class="flex flex-col space-x-4">
                                <label for="stock_qty" class="mb-4 text-sm">Stock Quantity</label>
                                <input class="mb-4 text-sm"  id="stock_qty" v-model="form.stock_qty"/>
                            </div>     
                            <div class="flex flex-col space-x-4">
                                <label for="category_id" class="mb-4 text-sm">Categories</label>
                                <select v-model="form.category_id">
                                    <option 
                                        v-for="category in categories" 
                                        v-bind:value="category.id"
                                        :selected="category.id == form.category_id ? selected : null">
                                        {{ category.name}}
                                    </option>
                                </select>
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
    export default {
        props: ['products','categories','errors'],
        data() {
            return {
                editMode: false,
                form: {
                    name: null,
                },
                isOpen : false,
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
                    name: null,
                    unit_price : null,
                    cost_price : null,
                    stock_qty : null,
                    category_id : null,
                }
            },
            save: function (data) {
                this.$inertia.post('/product/', data)
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
                this.$inertia.post('/product/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Sure')) return;
                data._method = 'DELETE';
                this.$inertia.post('/product/' + data.id, data)
                this.reset();
                this.closeModal();
            }
        }
    }
</script>
