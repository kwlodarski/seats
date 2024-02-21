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
                                            <div class="form-check flex justify-center items-center" v-show="employees[currentEmployeeIndex].id === loggedUser || isAdmin">
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
                                    <div class="form-check flex justify-center items-center" v-show="employee.id === loggedUser || isAdmin">
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
                                        <template v-if="vacations[employees[currentEmployeeIndex].id]?.includes(day) > 0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" class="w-6 fill-k4gray inline-block"><path d="M62.6251869,66.1699448c0.3927078-0.6298828,0.6225777-1.3742371,0.6225777-2.1707191  c0-2.2804985-1.8493538-4.1270409-4.12854-4.1270409c-2.2795601,0-4.1256371,1.8465424-4.1256371,4.1270409  c0,0.3240852,0.0384369,0.6400108,0.111187,0.943943c-1.6250191-0.1474609-3.2692528-0.2252731-4.9331741-0.2252731  c-2.5761795,0-5.1112022,0.1858978-7.594101,0.5374527c-2.6796761-15.9664001,0.0536232-26.1339607,4.0584183-32.5378456  c0.7424774,1.0930977,1.996254,1.8117638,3.4189644,1.8117638c1.978447,0,3.6295242-1.3943062,4.0323563-3.2546272  c0.3958969,0.1244965,0.8152275,0.1940556,1.2509651,0.1940556c2.2796555,0,4.1276054-1.8492603,4.1276054-4.1297588  c0-0.0631866-0.0041122-0.1254349-0.009655-0.1886196c0.7658348,0.4769859,1.5412979,1.0043163,2.2942772,1.5856438  c3.3521233,2.5817089,6.2446098,6.13661,6.2418861,10.7004185c0,1.105938-0.1716461,2.2786255-0.5470123,3.5246201  c-0.0801544,0.2654953,0.0617905,0.5457039,0.3199615,0.6390762c0.0590591,0.0209999,0.1199036,0.0301895,0.1776505,0.0301895  c0.2032394,0,0.3945847-0.120842,0.4755783-0.3204308c0.0123749-0.0329971,1.6923294-4.0593567,1.6950455-8.8565979  c0.0014114-3.3543739-0.8345413-7.124424-3.7160492-10.0796242c-0.7286987-0.7480106-1.5837555-1.4355526-2.5821648-2.052599  c0.0773277-0.0017815,0.1542931-0.002718,0.2325706-0.002718c3.2170334,0,6.6900024,0.475111,9.6470795,1.9371948  c2.9575424,1.4666786,5.4087524,3.8817043,6.6886826,7.8834076c0.0713425,0.2197418,0.2732773,0.3615837,0.4933929,0.3615837  c0.0439682,0,0.0892487-0.0045967,0.1332169-0.0173454c0.2683182-0.0723724,0.4330215-0.3388023,0.3739624-0.6097317  c-0.0081482-0.0320625-0.8838577-4.1673527-3.4380951-8.345768c-2.5423355-4.1664143-6.8493729-8.4317341-13.6368713-8.4298592  c-2.9794769,0-6.4094009,0.8257275-10.3498039,2.7903919C47.4058647,10.1540079,41.2422523,7.4139595,35.8586235,7.4139595  c-11.398838,0.0549359-18.7471333,12.0158844-19.2571201,12.8252048l0,0  c-0.0178108,0.0293427-0.026062,0.0430298-0.0274677,0.0439682c-0.1405144,0.2380238-0.0713425,0.5428905,0.1606827,0.6957932  c0.2297745,0.1529007,0.5401726,0.0979652,0.7040424-0.1254349c3.490778-4.7459602,8.0344334-6.3123865,12.6933975-6.3224173  c4.4260006-0.0009375,8.9256878,1.4619904,12.4796505,3.0476332c-0.7355423-0.0851212-1.4409904-0.1272144-2.1161461-0.1272144  c-7.0126915-0.0109692-10.8221169,4.3458481-12.7524567,8.5828552c-1.9536953,4.2469444-2.1642647,8.4353905-2.169796,8.4701691  c-0.0122814,0.2756195,0.1913376,0.5145798,0.4660187,0.5428925c0.0179043,0.001873,0.0361862,0.0028114,0.0526848,0.0028114  c0.254055,0,0.4741745-0.1868401,0.5140171-0.4422073c0.7452106-4.8512383,3.6968346-7.5510693,7.2768612-9.1303387  c3.5759926-1.5664253,7.7552528-1.9170399,10.6976051-1.9151649c0.3424606,0,0.6678581,0.0036564,0.9746132,0.0118122  c-13.6561012,11.643425-11.9651794,39.3162498-11.6076279,43.6355629  C21.959074,70.9946594,11.782794,78.8550949,5.0488386,89.1728363c1.4698524-0.4285202,3.0215597-0.6692581,4.6154528-0.6692581  c2.4842119,0,4.8640823,0.5758896,6.9797745,1.5408249c2.0676918,0.9457245,4.3816586,1.499588,6.777935,1.499588  c2.4087582,0,4.7226181-0.5538635,6.7875919-1.499588c2.101923-0.9668121,4.4900303-1.5408249,6.9797726-1.5408249  c2.4772758,0,4.8668022,0.5758896,6.9802589,1.5408249c2.0580215,0.9457245,4.3568001,1.499588,6.7692032,1.499588  c2.4113693,0,4.7170868-0.5538635,6.7971535-1.499588c2.1065025-0.9668121,4.4955635-1.5408249,6.9596291-1.5408249  c2.4897308,0,4.8750381,0.5758896,6.9880142,1.5408249c2.0511932,0.9457245,4.3870926,1.499588,6.76828,1.499588  c2.4114609,0,4.7102432-0.5538635,6.7971497-1.499588c2.1047287-0.9668121,4.4887238-1.5408249,6.963295-1.5408249  c0.9503021,0,1.8850555,0.0851212,2.7963715,0.2435532C87.56987,77.5816269,76.0720291,69.3577347,62.6251869,66.1699448z"/></svg>
                                        </template>
                                        <template v-else>
                                            <input 
                                                class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-k4green checked:border-k4green focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain cursor-pointer"
                                                v-if="!freeDay"
                                                type="checkbox"
                                                :class="[`frequency-${day}`],{'checked:bg-k4green checked:border-k4green': !isToday(day), 'checked:bg-k4pink checked:border-k4pink': isToday(day)}"
                                                @change="changeFrequency($event, index, day, employees[currentEmployeeIndex].id)"
                                                :checked="currentMonthObject[index].frequency.includes(employees[currentEmployeeIndex].id) ? true : false"
                                                v-show="employees[currentEmployeeIndex].id === loggedUser || isAdmin"
                                            />
                                            <div class="w-4 h-4 mx-auto" :class="currentMonthObject[index].frequency.includes(employees[currentEmployeeIndex].id) ? (!isToday(day) ? 'bg-k4green' : 'bg-k4pink') : 'bg-k4gray'" v-show="employees[currentEmployeeIndex].id !== loggedUser && !isAdmin"></div>
                                        </template>
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
                                        <template v-if="vacations[employee.id]?.includes(day) > 0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" class="w-6 fill-k4gray inline-block"><path d="M62.6251869,66.1699448c0.3927078-0.6298828,0.6225777-1.3742371,0.6225777-2.1707191  c0-2.2804985-1.8493538-4.1270409-4.12854-4.1270409c-2.2795601,0-4.1256371,1.8465424-4.1256371,4.1270409  c0,0.3240852,0.0384369,0.6400108,0.111187,0.943943c-1.6250191-0.1474609-3.2692528-0.2252731-4.9331741-0.2252731  c-2.5761795,0-5.1112022,0.1858978-7.594101,0.5374527c-2.6796761-15.9664001,0.0536232-26.1339607,4.0584183-32.5378456  c0.7424774,1.0930977,1.996254,1.8117638,3.4189644,1.8117638c1.978447,0,3.6295242-1.3943062,4.0323563-3.2546272  c0.3958969,0.1244965,0.8152275,0.1940556,1.2509651,0.1940556c2.2796555,0,4.1276054-1.8492603,4.1276054-4.1297588  c0-0.0631866-0.0041122-0.1254349-0.009655-0.1886196c0.7658348,0.4769859,1.5412979,1.0043163,2.2942772,1.5856438  c3.3521233,2.5817089,6.2446098,6.13661,6.2418861,10.7004185c0,1.105938-0.1716461,2.2786255-0.5470123,3.5246201  c-0.0801544,0.2654953,0.0617905,0.5457039,0.3199615,0.6390762c0.0590591,0.0209999,0.1199036,0.0301895,0.1776505,0.0301895  c0.2032394,0,0.3945847-0.120842,0.4755783-0.3204308c0.0123749-0.0329971,1.6923294-4.0593567,1.6950455-8.8565979  c0.0014114-3.3543739-0.8345413-7.124424-3.7160492-10.0796242c-0.7286987-0.7480106-1.5837555-1.4355526-2.5821648-2.052599  c0.0773277-0.0017815,0.1542931-0.002718,0.2325706-0.002718c3.2170334,0,6.6900024,0.475111,9.6470795,1.9371948  c2.9575424,1.4666786,5.4087524,3.8817043,6.6886826,7.8834076c0.0713425,0.2197418,0.2732773,0.3615837,0.4933929,0.3615837  c0.0439682,0,0.0892487-0.0045967,0.1332169-0.0173454c0.2683182-0.0723724,0.4330215-0.3388023,0.3739624-0.6097317  c-0.0081482-0.0320625-0.8838577-4.1673527-3.4380951-8.345768c-2.5423355-4.1664143-6.8493729-8.4317341-13.6368713-8.4298592  c-2.9794769,0-6.4094009,0.8257275-10.3498039,2.7903919C47.4058647,10.1540079,41.2422523,7.4139595,35.8586235,7.4139595  c-11.398838,0.0549359-18.7471333,12.0158844-19.2571201,12.8252048l0,0  c-0.0178108,0.0293427-0.026062,0.0430298-0.0274677,0.0439682c-0.1405144,0.2380238-0.0713425,0.5428905,0.1606827,0.6957932  c0.2297745,0.1529007,0.5401726,0.0979652,0.7040424-0.1254349c3.490778-4.7459602,8.0344334-6.3123865,12.6933975-6.3224173  c4.4260006-0.0009375,8.9256878,1.4619904,12.4796505,3.0476332c-0.7355423-0.0851212-1.4409904-0.1272144-2.1161461-0.1272144  c-7.0126915-0.0109692-10.8221169,4.3458481-12.7524567,8.5828552c-1.9536953,4.2469444-2.1642647,8.4353905-2.169796,8.4701691  c-0.0122814,0.2756195,0.1913376,0.5145798,0.4660187,0.5428925c0.0179043,0.001873,0.0361862,0.0028114,0.0526848,0.0028114  c0.254055,0,0.4741745-0.1868401,0.5140171-0.4422073c0.7452106-4.8512383,3.6968346-7.5510693,7.2768612-9.1303387  c3.5759926-1.5664253,7.7552528-1.9170399,10.6976051-1.9151649c0.3424606,0,0.6678581,0.0036564,0.9746132,0.0118122  c-13.6561012,11.643425-11.9651794,39.3162498-11.6076279,43.6355629  C21.959074,70.9946594,11.782794,78.8550949,5.0488386,89.1728363c1.4698524-0.4285202,3.0215597-0.6692581,4.6154528-0.6692581  c2.4842119,0,4.8640823,0.5758896,6.9797745,1.5408249c2.0676918,0.9457245,4.3816586,1.499588,6.777935,1.499588  c2.4087582,0,4.7226181-0.5538635,6.7875919-1.499588c2.101923-0.9668121,4.4900303-1.5408249,6.9797726-1.5408249  c2.4772758,0,4.8668022,0.5758896,6.9802589,1.5408249c2.0580215,0.9457245,4.3568001,1.499588,6.7692032,1.499588  c2.4113693,0,4.7170868-0.5538635,6.7971535-1.499588c2.1065025-0.9668121,4.4955635-1.5408249,6.9596291-1.5408249  c2.4897308,0,4.8750381,0.5758896,6.9880142,1.5408249c2.0511932,0.9457245,4.3870926,1.499588,6.76828,1.499588  c2.4114609,0,4.7102432-0.5538635,6.7971497-1.499588c2.1047287-0.9668121,4.4887238-1.5408249,6.963295-1.5408249  c0.9503021,0,1.8850555,0.0851212,2.7963715,0.2435532C87.56987,77.5816269,76.0720291,69.3577347,62.6251869,66.1699448z"/></svg>
                                        </template>
                                        <template v-else>
                                            <input
                                                class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain cursor-pointer"
                                                v-if="!freeDay"
                                                type="checkbox"
                                                :class="[`frequency-${day}`],{'checked:bg-k4green checked:border-k4green': !isToday(day), 'checked:bg-k4pink checked:border-k4pink': isToday(day)}"
                                                @change="changeFrequency($event, index, day, employee.id)"
                                                :checked="currentMonthObject[index].frequency.includes(employee.id) ? true : false"
                                                v-show="employee.id === loggedUser || isAdmin"
                                            />
                                            <div class="w-4 h-4 mx-auto" :class="currentMonthObject[index].frequency.includes(employee.id) ? (!isToday(day) ? 'bg-k4green' : 'bg-k4pink') : 'bg-k4gray'" v-show="employee.id !== loggedUser && !isAdmin"></div>
                                        </template>
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
            loggedUser: null,
            isAdmin: false,
            currentMonth: currentMonth,
            currentYear: currentYear,
            currentMonthObject: currentMonthObject,
            holidays: [],
            vacations: [],
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
            this.getAllUsersVacations();
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
            this.getAllUsersVacations();
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
                userId: employeeId,
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
                userId: employeeId,
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
                userId: employeeId,
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
                userId: employeeId,
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
                self.loggedUser = response.data.loggedUser;
                self.isAdmin = response.data.isAdmin;
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
            fetch('/activeUsers')
                .then(function(response) {
                    return response.json()
                })
                .then(function(data) {
                    self.employees = data.users;
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
        getAllUsersVacations() {
            const self = this;
            const data = {
                month: this.currentMonth,
                year: this.currentYear
            };
            axios.post('/getAllUsersVacations',data)
            .then(function(response){
                self.vacations = response.data.usersVacations;
            }).catch(function (response) {
                console.log(response);
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
        this.getAllUsersVacations();
        this.getData();
    }
};
</script>

<style>

</style>
