$(function (){
    let arrows;

    $('.kt-selectpicker').selectpicker();
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }
    // enable clear button
    $('.datepicker').datepicker({
        rtl: KTUtil.isRTL(),
        todayBtn: "linked",
        format:'yyyy-mm-dd',
        orientation: "bottom right",
        clearBtn: true,
        todayHighlight: true,
        templates: arrows,
    });
});