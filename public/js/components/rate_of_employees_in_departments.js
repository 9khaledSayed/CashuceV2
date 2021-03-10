$(function () {
    var supportCases = function(data, colors) {
        if ($('#kt_chart_support_tickets').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'kt_chart_support_tickets',
            data: data,
            labelColor: '#a7a7c2',
            colors: colors,
            formatter: function (x) { return x + "%"}
        });
    }
    $.ajax({
        method:'get',
        url:'/dashboard/departments_statistics',
        success:function (res) {
            if(res.length > 0){
                var data = [];
                var colors = [];
                $.each(res, function (key, department) {
                    data.push({
                        label: department.name,
                        value: department.percentage
                    });
                    colors.push(
                        department.color
                    );

                    $("#legends").append('\
                            <div class="kt-widget16__legend">\
                                <span class="kt-widget16__bullet" style="background: ' + department.color + '"></span>\
                                <span class="kt-widget16__stat">' + department.name + ' ' + department.percentage + ' %</span>\
                            </div>\
                        ');
                })
                supportCases(data, colors)


            }

        }
    })

})