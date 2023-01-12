<template>
    <div class="relative pb-8">
        <div class="flex justify-between my-6 items-center" v-touch:swipe.left="nextMonth" v-touch:swipe.right="prevMonth">
            <button 
                @click="prevMonth" 
                type="button"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                class="inline-block px-3 py-1.5 bg-k4pink text-white font-medium text-xs leading-tight uppercase rounded-3xl border-4 border-k4pink hover:bg-white hover:text-k4pink focus:outline-none focus:ring-0 transition duration-300 ease-in-out"
            >
                <svg class="w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
            </button>
            <span class="text-lg font-bold">{{ zeroPad(currentMonth, 10) }} {{ currentYear }}</span>
            <button
                @click="nextMonth"
                type="button"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                class="inline-block px-3 py-1.5 bg-k4pink text-white font-medium text-xs leading-tight uppercase rounded-3xl border-4 border-k4pink hover:bg-white hover:text-k4pink focus:outline-none focus:ring-0 transition duration-300 ease-in-out"
            >
                <svg class="w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
            </button>
        </div>
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="w-full table-auto">
                        <tr class="row">
                            <template v-if="isMobile() && currentEmployeeIndex !== null">
                                <td colspan="3" v-touch:swipe.left="nextEmployee" v-touch:swipe.right="prevEmployee">
                                    <div class="flex w-full justify-between items-center">
                                        <div class="flex-1">
                                            <button v-if="currentEmployeeIndex !== 0" class="inline-block px-2 py-1.5 bg-k4pink text-white font-medium text-xs leading-tight uppercase rounded-3xl border-4 border-k4pink hover:bg-white hover:text-k4pink focus:outline-none focus:ring-0 transition duration-300 ease-in-out" @click="prevEmployee" >
                                                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                                            </button>
                                        </div>
                                        <div class="flex-2 text-center">
                                            <p class="font-bold mb-0">{{ employees[currentEmployeeIndex].name }}</p>
                                            <div class="form-check flex justify-center items-center">
                                                <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-k4green checked:border-k4green focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" @change="changeAllFrequency($event, index, employees[currentEmployeeIndex].id)" :id="[`employee-${currentEmployeeIndex}`]" :checked="isFullFrequency(employees[currentEmployeeIndex].id) ? true : false">
                                                <label class="form-check-label inline-block text-sm font-light" :for="[`employee-${currentEmployeeIndex}`]">
                                                    wszystkie dni
                                                </label>
                                            </div>                                            
                                        </div>
                                        <div class="flex-1 text-right">
                                            <button v-if="currentEmployeeIndex < employees.length - 1" class="inline-block px-2 py-1.5 bg-k4pink text-white font-medium text-xs leading-tight uppercase rounded-3xl border-4 border-k4pink hover:bg-white hover:text-k4pink focus:outline-none focus:ring-0 transition duration-300 ease-in-out" @click="nextEmployee">
                                                <svg class="w-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </template>
                            <template v-else>
                                <td></td>
                                <td class="px-2 py-1 text-center cell-for-slider" v-for="(employee, index) in employees" :key="index">
                                    <p class="font-bold mb-0">{{ employees[index].name }}</p>
                                    <div class="form-check flex justify-center items-center">
                                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-k4green checked:border-k4green focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" @change="changeAllFrequency($event, index, employee.id)" :id="[`employee-${index}`]" :checked="isFullFrequency(employees[index].id) ? true : false">
                                        <label class="form-check-label inline-block text-sm font-light" :for="[`employee-${index}`]">
                                            wszystkie dni
                                        </label>
                                    </div>
                                </td>
                                <td></td>
                            </template>
                        </tr>
                        <tr
                            v-for="{ day, index, freeDay, holiday, weekday} in currentMonthObject"
                            :key="index"
                            class="even:bg-gray-50 odd:bg-white border border-gray-200 row"
                        >
                            <template v-if="isMobile() && currentEmployeeIndex !== null">
                                <td class="px-2 py-2 text-center w-28" :class="{ 'bg-k4gray text-white': freeDay, 'bg-k4green text-white': isToday(day) }">{{ weekday }} {{ day }}.{{ zeroPad(currentMonth, 10) }}</td>
                                <template v-if="!freeDay">
                                    <td class="text-center px-2 py-1" :class="{ 'bg-k4gray text-white': freeDay, 'bg-k4green text-white': isToday(day) }" v-touch:swipe.left="nextEmployee" v-touch:swipe.right="prevEmployee">
                                        <input 
                                            class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-k4green checked:border-k4green focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer"
                                            v-if="!freeDay"
                                            type="checkbox"
                                            :class="[`frequency-${day}`],{'checked:bg-k4green checked:border-k4green': !isToday(day), 'checked:bg-k4pink checked:border-k4pink': isToday(day)}"
                                            @change="changeFrequency($event, index, day, employees[currentEmployeeIndex].id)"
                                            :checked="currentMonthObject[index].frequency.includes(employees[currentEmployeeIndex].id) ? true : false"
                                        />
                                    </td>
                                </template>
                                <template v-else>
                                    <td class="text-center px-2 py-1" :class="{ 'bg-k4gray text-white': freeDay, 'bg-k4green text-white': isToday(day) }" v-touch:swipe.left="nextEmployee" v-touch:swipe.right="prevEmployee">
                                        {{ holiday }}
                                    </td>
                                </template>
                            </template>
                            <template v-else>
                                <td class="px-2 py-2 text-center" :class="{ 'bg-k4gray text-white': freeDay, 'bg-k4green text-white': isToday(day) }">{{ weekday }} {{ day }}.{{ zeroPad(currentMonth, 10) }}.{{ currentYear }}</td>
                                <template v-if="!freeDay">
                                    <td v-for="(employee, employeeIndex) in employees" :key="employeeIndex" class="text-center px-2 py-1" :class="{ 'bg-k4gray text-white': freeDay, 'bg-k4green text-white': isToday(day) }">
                                        <input
                                            class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer"
                                            v-if="!freeDay"
                                            type="checkbox"
                                            :class="[`frequency-${day}`],{'checked:bg-k4green checked:border-k4green': !isToday(day), 'checked:bg-k4pink checked:border-k4pink': isToday(day)}"
                                            @change="changeFrequency($event, index, day, employee.id)"
                                            :checked="currentMonthObject[index].frequency.includes(employee.id) ? true : false"
                                        />
                                    </td>
                                </template>
                                <template v-else>
                                    <td class="text-center px-2 py-1" :class="{ 'bg-k4gray text-white': freeDay, 'bg-k4green text-white': isToday(day) }" :colspan="employees.length">
                                        {{ holiday }}
                                    </td>
                                </template>
                            </template>
                            <td class="px-2 py-1 text-center w-8" :class="{'bg-k4green text-white': currentMonthObject[index].frequency.length < 7 && !freeDay || freeDay && isToday(day), 'bg-k4gray text-white': currentMonthObject[index].frequency.length > 7, 'bg-k4yellow': currentMonthObject[index].frequency.length === 7, 'bg-k4gray': freeDay && !isToday(day)}">
                                <span v-if="!freeDay">{{
                                currentMonthObject[index].frequency.length
                                }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div v-if="loading" class="w-full h-full absolute top-0 left-0 bg-gray-100/70 grid content-center justify-center">
            <div class="spinner-grow inline-block w-12 h-12 bg-current rounded-full opacity-0" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Calendar",
    data() {
        const today = new Date();
        const currentMonth = today.getMonth() + 1;
        const currentYear = today.getFullYear();
        let currentMonthObject = [];
        let currentEmployeeIndex = null;
        const monthDayAmount = new Date(currentYear, currentMonth, 0).getDate();
        for (let i = 0; i < monthDayAmount; i++) {
            currentMonthObject = [
                ...currentMonthObject,
                {
                    index: i,
                    day: i + 1,
                    frequency: [],
                    freeDay: false,
                    holiday: null,
                    weekday: null
                },
            ];
        }
        return {
            today: today,
            employees: {},
            currentMonth: currentMonth,
            currentYear: currentYear,
            currentMonthObject: currentMonthObject,
            holidays: [],
            currentEmployeeIndex: currentEmployeeIndex,
            loading: true,
            weekday: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'Sb']
        };
    },
    methods: {
        isFullFrequency(employeeId) {
            let employeeFrequency = [];
            const onlyWorkDays = this.currentMonthObject.filter(function (day) {
                return day.freeDay === false;
            });
            onlyWorkDays.every(day => { 
                if (day.frequency.includes(employeeId)) {
                    employeeFrequency = [...employeeFrequency, employeeId];
                    return true;
                } else {
                    return false;
                }
            });
            if (onlyWorkDays.length === employeeFrequency.length) {
                return true;  
            } else {
                return false;
            }
        },
        prevEmployee() {
            if (this.currentEmployeeIndex > 0) {
                this.currentEmployeeIndex--;
            }
            return true;
        },
        nextEmployee() {
            if (this.currentEmployeeIndex < this.employees.length - 1) {
                this.currentEmployeeIndex++;
            }
            return true;
        },
        zeroPad(nr, base){
            const len = (String(base).length - String(nr).length)+1;
            return len > 0? new Array(len).join('0')+nr : nr;
        },
        nextMonth() {
            if(this.currentMonth === 12) {
                this.currentYear++;
                this.currentMonth = 1;
            } else {
                this.currentMonth++;
            }
            this.getHolidays();
            this.getEmployees();
            this.getData();
        },
        prevMonth() {
            if(this.currentMonth === 1) {
                this.currentYear--;
                this.currentMonth = 12;
            } else {
                this.currentMonth--;
            }
            this.getHolidays();
            this.getEmployees();
            this.getData();
        },
        isFreeDay(day) {
            const date = new Date(`${this.currentYear}-${this.zeroPad(this.currentMonth, 10)}-${day}`);
            this.currentMonthObject[day-1].weekday = this.weekday[date.getDay()];
            const self = this;
            let temp = this.holidays.filter(function (holiday) {
                let holidayDate = new Date(holiday.date);
                holidayDate.setHours(0,0,0,0);
                date.setHours(0,0,0,0);
                return holidayDate.getTime() === date.getTime();
            });
            if (date.getDay() === 6 || date.getDay() === 0 || temp.length > 0) {
                this.currentMonthObject[day-1].holiday = temp[0]?.name;
                return true;
            } else {
                return false;
            }
        },
        isToday(day) {
            if (day === this.today.getDate() && this.currentMonth === this.today.getMonth() + 1) {
                return true;
            } else {
                return false;
            }
        },
        changeFrequency(event, index, day, employeeId) {
            if (event.target.checked) {
                this.addPresence(day, employeeId);
            } else {
                this.removePresence(day, employeeId);
            }
        },
        changeAllFrequency(event, index, employeeId) {
            if (event.target.checked) {
                this.addPresences(employeeId);
            } else {
                this.removePresences(employeeId);
            }
        },
        addPresence(day, employeeId) {
            const allCheckboxes = document.querySelectorAll('input');
            this.loading = true;
            allCheckboxes.forEach(element => {
                element.disabled = true;
            });
            const self = this;
            const data = {
                employeeId: employeeId,
                day: day,
                month: this.currentMonth,
                year: this.currentYear
            };
            axios.post(
                '/addPresence',
                data
            ).then(function(response){
                allCheckboxes.forEach(element => {
                    element.disabled = false;
                });
                self.currentMonthObject = response.data.currentMonthObject;
                self.currentMonthObject.map(function(day){
                    day.freeDay = self.isFreeDay(day.day);
                    return day;
                });
                self.loading = false;
            }).catch(function (response) {
                console.log(response);
            });
        },
        addPresences(employeeId) {
            const allCheckboxes = document.querySelectorAll('input');
            this.loading = true;
            allCheckboxes.forEach(element => {
                element.disabled = true;
            });
            const self = this;
            const onlyWorkDays = this.currentMonthObject.filter(function (day) {
                return day.freeDay === false;
            });
            let days = [];
            onlyWorkDays.forEach(day => {
                days = [...days, day.day];
            });
            const data = {
                employeeId: employeeId,
                days: days,
                month: this.currentMonth,
                year: this.currentYear
            };
            axios.post(
                '/addPresences',
                data
            ).then(function(response){
                allCheckboxes.forEach(element => {
                    element.disabled = false;
                });
                self.currentMonthObject = response.data.currentMonthObject;
                self.currentMonthObject.map(function(day){
                    day.freeDay = self.isFreeDay(day.day);
                    return day;
                });
                self.loading = false;
            }).catch(function (response) {
                console.log(response);
            });
        },
        removePresence(day, employeeId) {
            const allCheckboxes = document.querySelectorAll('input');
            this.loading = true;
            allCheckboxes.forEach(element => {
                element.disabled = true;
            });
            const self = this;
            const data = {
                employeeId: employeeId,
                day: day,
                month: this.currentMonth,
                year: this.currentYear
            };
            axios.post(
                '/removePresence',
                data
            ).then(function(response){
                allCheckboxes.forEach(element => {
                    element.disabled = false;
                });
                self.currentMonthObject = response.data.currentMonthObject;
                self.currentMonthObject.map(function(day){
                    day.freeDay = self.isFreeDay(day.day);
                    return day;
                });
                self.loading = false;
            }).catch(function (response) {
                console.log(response);
            });
        },
        removePresences(employeeId) {
            const allCheckboxes = document.querySelectorAll('input');
            this.loading = true;
            allCheckboxes.forEach(element => {
                element.disabled = true;
            });
            const self = this;
            const onlyWorkDays = this.currentMonthObject.filter(function (day) {
                return day.freeDay === false;
            });
            let days = [];
            onlyWorkDays.forEach(day => {
                days = [...days, day.day];
            });
            const data = {
                employeeId: employeeId,
                days: days,
                month: this.currentMonth,
                year: this.currentYear
            };
            axios.post(
                '/removePresences',
                data
            ).then(function(response){
                allCheckboxes.forEach(element => {
                    element.disabled = false;
                });
                self.currentMonthObject = response.data.currentMonthObject;
                self.currentMonthObject.map(function(day){
                    day.freeDay = self.isFreeDay(day.day);
                    return day;
                });
                self.loading = false;
            }).catch(function (response) {
                console.log(response);
            });
        },
        getData() {
            const self = this;
            self.loading = true;
            const data = {
                month: this.currentMonth,
                year: this.currentYear
            };
            axios.post(
                '/getPresences',
                data
            ).then(function(response){
                self.currentMonthObject = response.data.currentMonthObject;
                self.currentMonthObject.map(function(day){
                    day.freeDay = self.isFreeDay(day.day);
                    return day;
                });
                self.loading = false;
            }).catch(function (response) {
                console.log(response);
            });
        },
        getEmployees() {
            const self = this;
            fetch('/employees')
                .then(function(response) {
                    return response.json()
                })
                .then(function(data) {
                    self.employees = data.employees;
                    if(self.employees.length > 0 && self.currentEmployeeIndex === null) {
                        self.currentEmployeeIndex = 0;
                    }
                })
        },
        getHolidays() {
            const options = {
                method: 'GET',
                url: `https://date.nager.at/api/v3/PublicHolidays/${this.currentYear}/PL`,
            };
            const self = this;
            axios.request(options).then(function (response) {
                self.holidays = response.data.map(function(element) {
                    let holiday = {};
                    holiday.date = element.date;
                    holiday.name = element.localName;
                    return holiday;
                });
            }).catch(function (error) {
                console.error(error);
            });
        },
        isMobile() {
            if (this.$vssWidth > 1024) {
                return false;
            }
            return true;
        }
    },
    mounted() {
        this.getHolidays();
        this.getEmployees();
        this.getData();
    }
};
</script>

<style>

</style>
