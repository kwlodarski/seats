<template>
    <div class="relative p-6">
        <ul v-auto-animate>
            <li class="p-2 flex justify-between items-center even:bg-gray-50 odd:bg-white" v-for="(employee, index) in employees" :key="index">
                <span>{{ index + 1 }}. {{ employee.name }}</span>
                <div>
                    <button type="button" data-mdb-ripple="true" data-mdb-ripple-color="light" @click="openPopup('edit', employee.id)" class="mr-2 inline-block px-3 py-1.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"><svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-3" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"/></svg></button>
                    <button type="button" data-mdb-ripple="true" data-mdb-ripple-color="light" @click="openPopup('delete', employee.id)" class="inline-block px-3 py-1.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"><svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-3" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM472 200H616c13.3 0 24 10.7 24 24s-10.7 24-24 24H472c-13.3 0-24-10.7-24-24s10.7-24 24-24z"/></svg></button>
                </div>
            </li>
        </ul>

        <div class="flex justify-center my-3">
            <button data-mdb-ripple="true" data-mdb-ripple-color="light" class="inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out" @click="openPopup('add')">Dodaj nowego pracownika</button>
        </div>
        
        
        <div tabindex="0" class="z-40 bg-black bg-opacity-50 fixed top-0 bottom-0 left-0 right-0 w-full h-full overflow-auto scrolling-touch" v-if="popup">
            <div class="z-50 max-w-lg px-3 py-12 relative mx-auto">
                <div class="bg-white rounded shadow relative overflow-visible">
                    <button type="button" @click="closePopup()" class="absolute top-0 right-0 z-10 flex items-center justify-center w-8 h-8 -m-3 text-gray-700 transition ease-in-out bg-gray-100 rounded-full shadow duration-400 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 hover:bg-gray-200 disabled:text-opacity-50 disabled:cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>


                    <div class="relative p-3" v-if="action==='delete' && employeeId">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-700"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex flex-col justify-center w-full">
                            <div class="">
                                <h3 class="text-lg font-medium leading-6 text-center text-gray-900">Jesteś pewien?</h3>
                            </div>
                            <div class="w-full text-center">
                                <p class="text-sm text-gray-500">Tej czynności nie można cofnąć</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative p-3" v-if="action==='edit' && employeeId">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" viewBox="0 0 640 512"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"/></svg>
                        </div>
                        <div class="flex flex-col justify-center w-full">
                            <div class="">
                                <h3 class="text-lg font-medium leading-6 text-center text-gray-900">Edycja pracownika</h3>
                            </div>
                            <div class="w-full text-center">
                                <div class="flex justify-center">
                                    <div class="my-3 xl:w-96 text-left">
                                        <label for="name" class="form-label inline-block mb-2 text-gray-700">Imię pracownika:</label>
                                        <input type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none border-gray-300" v-model="name" id="editName" autocomplete="name" />
                                        <template v-for="fieldErrors in errors">
                                            <p v-for="error in fieldErrors" class="text-red-500 my-2 text-sm">{{ error }}</p>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative p-3" v-if="action==='add'">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" viewBox="0 0 640 512"><path d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                        </div>
                        <div class="flex flex-col justify-center w-full">
                            <div class="">
                                <h3 class="text-lg font-medium leading-6 text-center text-gray-900">Dodawanie pracownika</h3>
                            </div>
                            <div class="w-full text-center">
                                <div class="flex justify-center">
                                    <div class="my-3 xl:w-96 text-left">
                                        <label for="name" class="form-label inline-block mb-2 text-gray-700">Imię nowego pracownika:</label>
                                        <input type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none border-gray-300" v-model="name" id="newName" autocomplete="name" />
                                        <template v-for="fieldErrors in errors">
                                            <p v-for="error in fieldErrors" class="text-red-500 my-2 text-sm">{{ error }}</p>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center p-3 space-x-4 bg-gray-100 rounded-b">
                        <button type="button" @click="closePopup()" data-mdb-ripple="true" data-mdb-ripple-color="light" class="block w-full max-w-xs px-4 py-2 transition duration-100 ease-in-out bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-100 focus:border-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Anuluj">Anuluj</button>
                        <button @click="deleteEmployee()" v-if="action==='delete' && employeeId" type="button" data-mdb-ripple="true" data-mdb-ripple-color="light" class="block w-full max-w-xs px-4 py-2 text-white transition duration-100 ease-in-out bg-blue-500 border border-transparent rounded shadow-sm hover:bg-blue-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Potwierdzam">Potwierdzam</button>
                        <button @click="editEmployee()" v-if="action==='edit' && employeeId" type="button" data-mdb-ripple="true" data-mdb-ripple-color="light" class="block w-full max-w-xs px-4 py-2 text-white transition duration-100 ease-in-out bg-blue-500 border border-transparent rounded shadow-sm hover:bg-blue-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Zapisz">Zapisz</button>
                        <button @click="addEmployee()" v-if="action==='add'" type="button" data-mdb-ripple="true" data-mdb-ripple-color="light" class="block w-full max-w-xs px-4 py-2 text-white transition duration-100 ease-in-out bg-blue-500 border border-transparent rounded shadow-sm hover:bg-blue-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Dodaj">Dodaj</button>
                    </div>

                    <div v-if="loading" class="w-full h-full absolute top-0 left-0 bg-gray-200/70 grid content-center justify-center">
                        <div class="spinner-grow inline-block w-12 h-12 bg-current rounded-full opacity-0" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import axios from 'axios';

export default {
    name: "Settings",
    data() {
        return {
            loading: false,
            popup: false,
            employeeId: null,
            action: null,
            employees: [],
            name: null,
            errors: []
        };
    },
    methods: {
        getEmployees() {
            const self = this;
            fetch('/employees')
                .then(function(response) {
                    return response.json()
                })
                .then(function(data) {
                    self.employees = data.employees;
                })
        },
        openPopup(action, employeeId = null) {
            this.popup = true;
            this.employeeId = employeeId;
            this.action = action;
            this.errors = [];
            if (employeeId && action === 'edit') {
                this.name = this.employees.find(({ id }) => id === employeeId).name;
            }
        },
        closePopup() {
            this.popup = false;
            this.employeeId = null;
            this.action = null;
            this.loading = false;
            this.name = null;
        },
        deleteEmployee() {
            if(this.action === 'delete' && this.employeeId) {
                this.loading = true;
                const self = this;
                const data = {
                    employeeId: this.employeeId,
                };
                axios.post(
                    '/deleteEmployee',
                    data
                ).then(function(response){
                    self.employees = self.employees.filter(function (employee) {
                        return employee.id !== response.data.employeeId;
                    });
                    self.closePopup();
                }).catch(function (response) {
                    self.loading = false;
                });
            }
        },
        editEmployee() {
            if(this.action === 'edit' && this.employeeId) {
                this.loading = true;
                const self = this;
                const data = {
                    employeeId: this.employeeId,
                    name: this.name
                };
                axios.post(
                    '/editEmployee',
                    data
                ).then(function(response){
                    self.employees = self.employees.map(employee => {
                        if (employee.id === response.data.employeeId) {
                            return {...employee, name: response.data.name};
                        }
                        return employee;
                    });
                    self.closePopup();
                }).catch(error => {
                    self.errors = error.response.data.errors;
                    self.loading = false;
                });
            }
        },
        addEmployee() {
            this.loading = true;
            const self = this;
            const data = {
                name: this.name,
            };
            axios.post(
                '/addEmployee',
                data
            ).then(function(response){
                self.employees = [...self.employees, response.data.employee];
                self.closePopup();
            }).catch(error => {
                self.errors = error.response.data.errors;
                self.loading = false;
            });
        }
    },
    mounted() {
        this.getEmployees();
    }
}
</script>
<style>
</style>