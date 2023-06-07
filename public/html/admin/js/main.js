$(document).ready(function () {
    $(".need-confirm").on("click", function (e) {
        e.preventDefault();
        confirmModal($(this));
    });

    let msg = $("input[name=message]");
    if (msg.length != 0 && msg.val() != "") {
        showMessage('',msg.val(),'btn-success','green');
    }

    let errorMsg = $("input[name=error-message]");
    if (errorMsg.length != 0 && errorMsg.val() != "") {
        showMessage('',errorMsg.val(),'btn-danger','red');
    }

    function showMessage(title, message, btn, color){
        $.confirm({
            title: title,
            content: message,
            type: color,
            typeAnimated: true,
            buttons: {
                OK: {
                    text: 'OK',
                    btnClass: btn,
                    action: function(){
                    }
                },
            }
        });
    }

    function confirmModal(_this){
        let type = _this.attr("confirm-type");
        let content = _this.attr("confirm-content");

        let btnClass = _this.attr("confirm-btn-class");
        if (btnClass == undefined || btnClass == "") {
            btnClass = "btn-success";
        }
        let title = _this.attr("confirm-title");
        if (title == undefined || title == "") {
            title = "";
        }
        //default is OK
        let confirmBtnText = _this.attr("confirm-btn-text");
        if (confirmBtnText == undefined || confirmBtnText == "") {
            confirmBtnText = "OK";
        }
        //default is Cancel
        let cancelBtnText = _this.attr("confirm-cancel-btn-text");
        if (cancelBtnText == undefined || cancelBtnText == "") {
            cancelBtnText = "Cancel";
        }
        //hide button cancel
        let cancelBtnClass = _this.attr("confirm-cancel-btn-class");
        if (cancelBtnClass == undefined) {
            cancelBtnClass = "";
        }

        $.confirm({
            title: title,
            boxWidth: "30%",
            content: "<div class='text-center'>" + content + "</div>",
            onOpenBefore: function () {
                $(".jconfirm-buttons").addClass(
                    "d-flex justify-content-center col-12"
                );
                $(".jconfirm-box").addClass(
                    "border border-admin-color rounded"
                );
            },
            buttons: {
                OK: {
                    text: confirmBtnText,
                    btnClass: "btn btn-admin col-4",
                    action: function action() {
                        if (type == "delete") {
                            let route = _this.attr("href");
                            deleteData(route);
                        }
                        else if (type == "change-status") {
                            let acc_id = _this.data('id');
                            let route = _this.attr("href");
                            changeStatus(route, acc_id);
                        }else if(type == "change-status-order"){
                            let o_id = _this.data('id');
                            let route = _this.attr("href");
                            changOderStatus(route, o_id);
                        }
                    },
                },
                Cancel: {
                    text: cancelBtnText,
                    btnClass: "btn btn-outline-admin col-4",
                },
            },
        });
    }

    function changOderStatus(url, pk){
        $.ajax({
            url: url,
            method: "post",
            data: {
                id : pk,
                _token:$("input[name=_token]").val(),
            },
            dataType : 'json',
            success: function (result) {
                // console.log(result);
                if(result==1){
                    $('#btn-'+pk).val(0);
                    $('#btn-'+pk).removeClass('btn-danger');
                    $('#btn-'+pk).addClass('btn-success');
                    $('#btn-'+pk).html('<i class="icon-copy fa fa-check" aria-hidden="true"></i>');
                }else{
                    alert("Sản phẩm trong đơn hàng hiện không đủ, vui lòng kiểm tra lại!");
                }
            },
        });
    }

    function deleteData(url) {
        $.ajax({
            url: url,
            method: "post",
            data: {
                _token:$("input[name=_token]").val(),
            },
            dataType : 'json',
            success: function () {
                location.reload();
            },
        });
    }

    function changeStatus(url, pk){
        $.ajax({
            url: url,
            method: "post",
            data: {
                id : pk,
                _token:$("input[name=_token]").val(),
            },
            dataType : 'json',
            success: function (result) {
                if(result==0){
                    $('#btn-'+pk).val(0);
                    $('#btn-'+pk).removeClass('btn-success');
                    $('#btn-'+pk).addClass('btn-danger');
                    $('#btn-'+pk).html('<i class="icon-copy fa fa-lock" aria-hidden="true"></i>');
                }else{
                    $('#btn-'+pk).val(1);
                    $('#btn-'+pk).removeClass('btn-danger');
                    $('#btn-'+pk).addClass('btn-success');
                    $('#btn-'+pk).html('<i class="icon-copy fa fa-unlock" aria-hidden="true"></i>');
                }
            },
        });
    }


    $("#radio-date").on('change',function(){
        $("#select-month").hide();
        $("#select-date").show();
    });

    $("#radio-month").on('change',function(){
        $("#select-date").hide();
        $("#select-month").show();
    });


    $('.date-picker').datepicker({
        onSelect: function(dateText, inst) {
            console.log(dateText);

        }
    });


    $('.date-picker').datepicker({
		language: 'en',
		autoClose: true,
		dateFormat: 'dd/mm/yyyy',
	});
    $('.month-picker').datepicker({
		language: 'en',
		minView: 'months',
		view: 'months',
		autoClose: true,
		dateFormat: 'mm/yyyy',
	});

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(".check-order-detail").on("click", function (e) {
        e.preventDefault();
        var o_id = $(this).attr("order-id");
        var url = $(this).attr("href");
        console.log(o_id);
        console.log(url);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                o_id: o_id,
                _token: $("input[name=_token]").val(),
            },
            dataType: "json",
            success: function (result) {
                var html = '';
                var html_info = '';
                stt = 0;
                $.each(result, function (key, value){
                    html +=
                        '<tr class="table">' +
                            '<th scope="row">'+ ++stt +'</th>' +
                            '<td>'+ value.pro_name +'</td>' +
                            '<td>'+ numberWithCommas(value.price) +'</td>' +
                            '<td class = "text-center">'+ value.quantity +'</td>' +
                            '<td>'+ numberWithCommas(value.total_price) +'</td>' +
                        '</tr>';
                });
                html_info +=
                        '<p>Mã đơn hàng: '+ result[0]['o_id'] +'</p>' +
                        '<p>Tên người đặt hàng: '+ result[0]['cus_name'] +'</p>' +
                        '<p>Địa chỉ: '+ result[0]['o_add'] +'</p>' +
                        '<p>Số điện thoại: '+ result[0]['cus_phone'] +'</p>' +
                        '<p>Tổng giá: '+ numberWithCommas(result[0]['total'])  +'</p>' ;
                $(".order-detail tbody ").html(html);
                $(".order-info ").html(html_info);
            },
        });
    });


});
