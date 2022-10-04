<template>
    <div class="relative">
        <div class="flex justify-between my-6">
            <button 
                @click="prevMonth" 
                type="button"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                class="inline-block px-6 py-2.5 bg-blue-400 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-500 hover:shadow-lg focus:bg-blue-400 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-600 active:shadow-lg transition duration-150 ease-in-out"
            >poprzedni miesiąc</button>
            <span class="text-lg">{{ zeroPad(currentMonth, 10) }} {{ currentYear }}</span>
            <button
                @click="nextMonth"
                type="button"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                class="inline-block px-6 py-2.5 bg-blue-400 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-500 hover:shadow-lg focus:bg-blue-400 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-600 active:shadow-lg transition duration-150 ease-in-out"
            >następny miesiąc</button>
        </div>
        <table class="w-full mb-6">
            <tr>
            <td></td>
            <td class="px-2 py-1 text-center" v-for="(employee, index) in employees" :key="index">
                <input
                    type="checkbox"
                    :class="[`frequency-${day}`]"
                    @change="changeAllFrequency($event, index, employee.id)"
                />
                {{ employee.name }}</td>
            <td></td>
            </tr>
            <tr
                v-for="{ day, index, freeDay, holiday, weekday} in currentMonthObject"
                :key="index"
                class="even:bg-gray-50 odd:bg-white border border-gray-200"
            >
            <td class="px-2 py-1 text-center" :class="{ 'bg-red-500 text-white': freeDay, 'bg-green-500 text-white': isToday(day) }">{{ weekday }} {{ day }}.{{ zeroPad(currentMonth, 10) }}.{{ currentYear }}</td>
            <template v-if="!freeDay">
                <td v-for="(employee, employeeIndex) in employees" :key="employeeIndex" class="text-center px-2 py-1" :class="{ 'bg-red-500 text-white': freeDay, 'bg-green-500 text-white': isToday(day) }">
                    <input
                    v-if="!freeDay"
                    type="checkbox"
                    :class="[`frequency-${day}`]"
                    @change="changeFrequency($event, index, day, employee.id)"
                    :checked="currentMonthObject[index].frequency.includes(employee.id) ? true : false"
                    />
                </td>
            </template>
            <template v-else>
                <td class="text-center px-2 py-1" :class="{ 'bg-red-500 text-white': freeDay, 'bg-green-500 text-white': isToday(day) }" :colspan="employees.length">
                    {{ holiday }}
                </td>
            </template>
            <td class="px-2 py-1 text-center" :class="{'bg-green-500 text-white': currentMonthObject[index].frequency.length < 7 && !freeDay || freeDay && isToday(day), 'bg-red-500 text-white': currentMonthObject[index].frequency.length > 7, 'bg-yellow-500': currentMonthObject[index].frequency.length === 7, 'bg-red-500': freeDay && !isToday(day)}">
                <span v-if="!freeDay">{{
                currentMonthObject[index].frequency.length
                }}</span>
            </td>
            </tr>
        </table>
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
    name: "App",
    data() {
        const today = new Date();
        const currentMonth = today.getMonth() + 1;
        const currentYear = today.getFullYear();
        let currentMonthObject = [];
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
            loading: true,
            weekday: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'Sb']
        };
    },
    methods: {
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
