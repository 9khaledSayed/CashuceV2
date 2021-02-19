$(function(){
    var departmentSelect = $('#department');

    sectionAjax(departmentSelect.val());

    departmentSelect.change(function(){
        console.log($(this).val())
        var department_id = $(this).val();
        sectionAjax(department_id);
    });

    function sectionAjax(department_id) {
        if(department_id != ''){
            let sectionSelect = $("#section");
            $.ajax({
                type:"GET",
                url:"/dashboard/departments/getSections/" + department_id,
                success:function(res){
                    if(res){
                        sectionSelect.empty();
                        $.each(res,function(index,section){
                            sectionSelect.append('<option value="'+section.id+'">'+section.name+'</option>');
                        });
                        sectionSelect.selectpicker("refresh");
                    }else{

                        sectionSelect.empty();

                    }
                }
            });
        }else{
            $("#section").empty();
        }
    }
});