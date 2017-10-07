/**
 * Created by 15185 on 2017/8/9.
 */
function reset() {
    document.getElementById('create_form').reset();
    document.getElementById('container').value = "";
}

function checkForm(){
    var items = document.getElementsByClassName('choose');
    var flag = 1;
    for(var i=0;i<items.length;i++){
        if(items[i].checked){
            flag = 0;
        }
    }
    if(flag == 0){
        return true;
    } else {
        alert('Please Choose At Least One');
        return false;
    }
}

function checkSearch(){
    var search_box = document.getElementById('search_box');
    if(search_box.value == ''){
        alert('请输入搜索文章标题！');
        return false;
    } else {
        return true;
    }

}

$(document).ready(function () {

    $('#check_all').click(function () {

        if ($('#check_all').prop('checked')) {
            $('.choose').prop('checked', true);
        } else {
            $('.choose').removeAttr('checked');
        }

    });

    $('#check_btn').click(function () {
        $('#check_all').click();
    });


    /*$('#list_btn').click(function () {

        var list = new Array();

        $('input[name="item"]:checked').each(function () {

            list.push($(this).parent().next().text());
            // alert($(this).parent().next().text());
        });
        var choose_list = list.join();

        $.ajax({
            url: "http://pro_product.loc/index.php/passage/delete_choose",
            type: "post",
            dataType: "text",
            data: {'list_data': choose_list},
            async: false,
            success: function (correct) {
                alert(choose_list);
                window.location.href = 'http://pro_product.loc/index.php/passage/delete_choose';
            },
            error: function (wrong) {
                alert("FAIL");
            }
        });
    });*/





});

