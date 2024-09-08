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
            firstDay: 0,
            monthNames: ["1","2","3","4","5","6","7","8","9","10","11","12"],
            monthNamesShort: ["1","2","3","4","5","6","7","8","9","10","11","12"]
            /*
            onChangeMonthYear: function (year, month, inst) {
               // $("#datepicker").datepicker("setDate" , "04/02/2020" );
                //$('#datepicker').datepicker("option", "defaultDate",'03/01/2020');

                //alert(month);
                //$("#datepicker").datepicker( "option", "firstDay", $(".ui-datepicker-calendar tbody tr:first .ui-state-disabled" ).length  );
                //setTimeout();
                //$("#datepicker").datepicker(Date(month +  '/01/2020'));
                //$('#datepicker').datepicker("option", "defaultDate",'03/01/2020');
                //$("#datepicker").datepicker('setDate', '10/03/2020');

                //inst.datepicker("option",'defaultDate', month +  '/01/2020');
            }
             */

        }
        );
        //$("#datepicker").datepicker( "setDate" , "02/02/2020" ).datepicker("fill");
        /*
        var inst = $.datepicker._getInst($('#datepicker').get(0));
        inst.settings.onChangeMonthYear = function (year, month, inst){
            alert(month);
            $("#datepicker").datepicker( "option", "firstDay", $(".ui-datepicker-calendar tbody tr:first .ui-state-disabled" ).length  );
             $("#datepicker").datepicker("setDate" , new Date(2020,month,1) );

            // your code here
        }
         */
        let oldLength = 0;

        $(document).on('click', '.ui-datepicker-next', function () {
            let month  = $(".ui-datepicker-month").text();
            month--;
                setTimeout(() =>
                {
                    let length = $(".ui-datepicker-calendar tbody tr:first .ui-state-disabled").length;
                    length = (length + oldLength) % 7;
                    oldLength = length;
                    $("#datepicker").datepicker("option", "firstDay", length);
                    $("#datepicker").datepicker("setDate", new Date(2020, month, 1));
                },1000);
        })

        $(document).on('click', '.ui-datepicker-prev', function () {
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
    .ui-datepicker-year {
        display: none
    }

    /* This is

   .ui-state-disabled {
       display:none
   }
    .ui-datepicker-calendar thead {
        display:none
    }
    */
    .ui-datepicker.ui-datepicker-inline {
        width: 70%
    }
</style>