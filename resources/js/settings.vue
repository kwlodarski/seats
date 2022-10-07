<template>
    <div class="relative p-6">
        <ul>
            <li class="py-2" v-for="(employee, index) in employees" :key="index">{{ index + 1 }}. {{ employee.name }}</li>
        </ul>

        <div class="flex justify-center">
            <div class="mb-3 xl:w-96">
                <label for="name" class="form-label inline-block mb-2 text-gray-700">New employee name:</label>
                <input type="text" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none border-gray-300" id="name" name="name" autocomplete="name" />
                <button class="w-36 select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4" @click="addEmployee()">Add employee</button>
            </div>
        </div>
        <div v-if="loading" class="w-full h-full absolute top-0 left-0 bg-gray-200/70 grid content-center justify-center">
            <div class="spinner-grow inline-block w-12 h-12 bg-current rounded-full opacity-0" role="status">
                <span class="visually-hidden">Loading...</span>
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
            employees: {},
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
        addEmployee() {
            const allCheckboxes = document.querySelectorAll('input');
            this.loading = true;
            // allCheckboxes.forEach(element => {
            //     element.disabled = true;
            // });
            // const self = this;
            // const data = {
            //     employeeId: employeeId,
            //     day: day,
            //     month: this.currentMonth,
            //     year: this.currentYear
            // };
            // axios.post(
            //     '/addPresence',
            //     data
            // ).then(function(response){
            //     allCheckboxes.forEach(element => {
            //         element.disabled = false;
            //     });
            //     self.currentMonthObject = response.data.currentMonthObject;
            //     self.currentMonthObject.map(function(day){
            //         day.freeDay = self.isFreeDay(day.day);
            //         return day;
            //     });
            //     self.loading = false;
            // }).catch(function (response) {
            //     console.log(response);
            // });
        }
    },
    mounted() {
        this.getEmployees();
    }
}
</script>
<style>
</style>