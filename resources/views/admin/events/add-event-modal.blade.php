<div id="app">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control"/>
    <b>Date List:</b>
    <div v-if="!dates.length">
        No Dates added
    </div>
    <div v-for="date in dates">
        @{{ date }}
    </div>
    Date:
    <div id="datepicker" style="width:100%"></div>
    <br/>
    <button class="btn btn-primary" v-on:click="addDate()">Add Date</button>
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
            let month = months.indexOf($(".ui-datepicker-month").text()) + 1;
            month--;

            let length = $(".ui-datepicker-calendar tbody tr:first .ui-state-disabled").length;
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
    });
</script>

<script>
    const {createApp, ref} = Vue
    let dates = ref([]);
    createApp({
        setup()
        {
            return {
                dates
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
            }
        }
    }).mount('#app')
</script>

<style>
    .ui-datepicker-year, .ui-state-disabled, .ui-datepicker-calendar thead,.ui-datepicker.ui-datepicker-inline {
        display: none
    }
    .ui-datepicker.ui-datepicker-inline {
        width: 70%
    }
</style>