<div class="col">
    Start
    <input type="text" class="timepickerModal form-control" id="startingTimeModal"
           value="{{ date("g:i A",strtotime($time->starting_time)) }}"/>
</div>
<div class="col">
    End
    <input type="text" class="timepickerModal form-control" id="endingTimeModal"
           value="{{ date("g:i A",strtotime($time->ending_time)) }}"/>
</div>

<script>
    $('.timepickerModal').timepicker({
        timeFormat: 'h:mm p',
        interval: 5,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
</script>
<style>
    .ui-timepicker-container, .ui-timepicker-standard {
        z-index: 99999999 !important
    }
</style>