<div id="app">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control"/>
    <div class="form-check" style="padding-top:10px;padding-bottom:10px">
        <input class="form-check-input" type="checkbox" v-model="storeOpen">
        <label class="form-check-label" for="flexCheckDefault">
            Open
        </label>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class = "nav-link" :class="{active: navigation.showDateList}"  href="#" v-on:click="changeNavigation('showDateList')">Date List</a>
        </li>
        <li class="nav-item">
            <a class = "nav-link" :class="{active: navigation.showSpecificDateList}"   href="#" v-on:click="changeNavigation('showSpecificDateList')">Specific Date List</a>
        </li>
        <li class="nav-item">
            <a class = "nav-link" :class="{active: navigation.showPatternList}"   href="#" v-on:click="changeNavigation('showPatternList')">Pattern List</a>
        </li>
    </ul>
    <div v-show="navigation.showDateList">
        <br/>
        <div v-if="!dates.length">
            No Dates added
        </div>
        <div v-for="date in dates">
            @{{ date }} <a href ="#" v-on:click="deleteDate(date)">Delete</a>
        </div>
        <br/>
        <div id="datepicker" style="width:100%"></div>
        <br/>
        <button class="btn btn-primary" v-on:click="addDate()">Add Date</button>
    </div>
    <div v-show="navigation.showSpecificDateList">
        <br/>
        <div v-if="!specificDates.length">
            No Dates added
        </div>
        <div v-for="date in specificDates">
            @{{ date }} <a href ="#" v-on:click="deleteSpecificDate(date)">Delete</a>
        </div>
        <br/>
        <div id="datepicker2" style="width:100%"></div>
        <button class="btn btn-primary" v-on:click="addSpecificDate()">Add Date</button>
    </div>
    <div v-show="navigation.showPatternList">
        <br/>
        <div v-if="!Object.keys(patterns).length">
            No Patterns added
        </div>
        <div v-else >
            <table class="table table">
                <thead>
                    <tr>
                        <th>Week Number</th>
                        <th>Day of Week</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(pattern,key) in patterns">
                        <td>
                            @{{ pattern.weekNumber }}
                        </td>
                        <td>
                            @{{ pattern.dayOfWeek }}
                        </td>
                        <td>
                           <a href ="#"  v-on:click="deletePattern(key)">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <label for="dayOfWeek">Day of Week</label>
        <select id="dayOfWeek" class="form-control">
            <option value="Sunday">Sunday</option>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
        </select>
        <label for="weekNumber">Week Number</label>
        <select id="weekNumber" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br/>
        <button class="btn btn-primary" v-on:click="addPattern()">Add Date</button>
    </div>
</div>
<script>
    $(function ()
    {
        var year = 2020;
        $("#datepicker").datepicker(
        {
            defaultDate: '01/01/2020',
            minDate: new Date(year, 0, 1),
            maxDate: new Date(year, 11, 31),
            showWeek: false,
            viewMode: "months",
            maxViewMode: "months",
            firstDay: 0
        }
        );
        let oldLength = 0;
        let formatCalender = function ()
        {
            var months = [
                "January", "February", "March", "April", "May", "June", "July",
                "August", "September", "October", "November", "December"];
            let month = months.indexOf($("#datepicker").find(".ui-datepicker-month").text()) + 1;
            month--;

            let length = $("#datepicker").find(".ui-datepicker-calendar tbody tr:first .ui-state-disabled").length;
            length = (length + oldLength) % 7;
            oldLength = length;
            $("#datepicker").datepicker("option", "firstDay", length);
            $("#datepicker").datepicker("setDate", new Date(2020, month, 1));
        }
        formatCalender();

        $(document).on('click', '.ui-datepicker-next', function ()
        {
            formatCalender();
        })

        $(document).on('click', '.ui-datepicker-prev', function ()
        {
            formatCalender();
        })
        var dateToday = new Date();
        $("#datepicker2").datepicker({minDate: dateToday});
    });
</script>

<script>
    const {createApp, ref,reactive} = Vue
    let dates = ref([]);
    let specificDates = ref([]);
    let navigation = ref({});
    let patterns = ref({});
    navigation.value.showDateList = true;
    navigation.value.showSpecificDateList = false;
    navigation.value.showPatternList = false;
    let storeOpen = open;
    createApp({
        setup()
        {
            return {
                dates,
                specificDates,
                navigation,
                patterns,
                storeOpen
            }
        },
        methods: {
            addDate()
            {
                if ($("#datepicker").val())
                {
                    let dateSplit = $("#datepicker").val().split("/");
                    let date = dateSplit[0] + "/" + dateSplit[1];
                    if (!dates.value.includes(date))
                    {
                        dates.value.push(date);
                        dates.value.sort();
                    }
                }
            },
            deleteDate(date)
            {
                dates.value.splice(date,1);
            },
            addSpecificDate()
            {
                if ($("#datepicker2").val())
                {
                    specificDates.value.push($("#datepicker2").val());
                    specificDates.value.sort();
                }
            },
            deleteSpecificDate(date)
            {
                specificDates.value.splice(date,1);
            },
            changeNavigation(section)
            {
                navigation.value.showDateList = false;
                navigation.value.showSpecificDateList = false;
                navigation.value.showPatternList = false;
                navigation.value[section] = true;
            },
            addPattern()
            {
                let pattern = ref({dayOfWeek: $("#dayOfWeek").val(),weekNumber: $("#weekNumber").val()});
                patterns.value[$("#dayOfWeek").val() + $("#weekNumber").val()] = pattern;
            },
            deletePattern(key)
            {
                delete patterns.value[key];
            }
        }
    }).mount('#app')
</script>

<style>
    #datepicker .ui-datepicker-year, #datepicker .ui-state-disabled, #datepicker .ui-datepicker-calendar thead, #datepicker .ui-datepicker.ui-datepicker-inline {
        display: none
    }
    .ui-datepicker.ui-datepicker-inline {
        width: 100%
    }
</style>