$(function (){
    let violation_select = $("select[name=violation_id]");
    let minutesLate = $("#minutes_late");
    let absenceDays = $("#absence_days");
    let absenceDaysInput = $("input[name='absence_days']");
    let minutesLateInput = $("input[name='minutes_late']");


    getType(violation_select.val());
    violation_select.change(function (){
        let violation_id = violation_select.val();
        getType(violation_id);
    });

    function getType(violation_id) {
        if(violation_select.val() != null && violation_select.val() !== ''){
            $.ajax({
                url: '/dashboard/violations/' + violation_id + '/additions',
                success: function (data){
                    switch (data.additions){
                        case 'minutes_deduc': // lateness
                            minutesLate.fadeIn();
                            minutesLateInput.prop('required', true);
                            absenceDays.fadeOut();
                            break;
                        case 'leave_days': // leave work
                            absenceDays.fadeIn();
                            absenceDaysInput.prop('required', true);
                            minutesLate.fadeOut();
                            break;
                        default :
                            absenceDays.fadeOut();
                            minutesLate.fadeOut();
                            absenceDaysInput.prop('required', false);
                            minutesLateInput.prop('required', false);
                            break;
                    }
                },
            });

        }
    }
});
