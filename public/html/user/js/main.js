$(document).ready(function () {
    $("input.input-qty").each(function () {
        var $this = $(this),
            btn = $this.parent().find(".is-form"),
            min = Number($this.attr("min")),
            max = Number($this.attr("max")),
            qty = $this.val(),
            route = $this.attr("url");
        $(btn).on("click", function () {
            if (route) {
                let acction;
                if ($(this).hasClass("minus")) {
                    acction = 0;
                } else if ($(this).hasClass("plus")) {
                    acction = 1;
                }
                $.ajax({
                    url: route,
                    method: "post",
                    data: {
                        quantity: qty,
                        act: acction,
                        _token: $("input[name=_token]").val(),
                    },
                    dataType: "json",
                    success: function (result) {
                        $("#sum-" + result.item.id).text(
                            result.item.sum.toLocaleString()
                        );
                        qty = result.item.qty;
                        $this.val(qty);
                        $(".subtotal").text(result.total.toLocaleString());
                    },
                });
            } else {
                if ($(this).hasClass("minus")) {
                    if (qty > min) qty--;
                } else if ($(this).hasClass("plus")) {
                    if (qty < max) qty++;
                }
                $this.val(qty);
            }
        });
    });
    // //----------------------------------------------------
    $(".btn-add-cart").on("click", function () {
        var cart = $(".ti-shopping-cart");
        var qty = $(".input-qty").val();
        if (qty > 1) {
            var citem =
                parseInt($("#count-item").data("count")) + parseInt(qty);
        } else {
            var citem = parseInt($("#count-item").data("count")) + 1;
        }
        $("#count-item").text(citem).data("count", citem);
    });
    // //------------------------------------------------------------------
    $("#city_selected").on("change", function () {
        var city_id = $("#city_selected").val();
        $.ajax({
            type: "POST",
            url: "/district",
            data: {
                city: city_id,
                _token: $("input[name=_token]").val(),
            },
            dataType: "json",
            success: function (result) {
                $("#district_selected").html(
                    "<option selected>Chọn quận huyện</option>"
                );
                $.each(result, function (key, district) {
                    $("#district_selected").append(
                        '<option value="' +
                            district.maqh +
                            '">' +
                            district.name +
                            "</option>"
                    );
                });
            },
        });
    });

    $("#district_selected").on("change", function () {
        var district_id = $("#district_selected").val();
        $.ajax({
            type: "POST",
            url: "/ward",
            data: {
                district: district_id,
                _token: $("input[name=_token]").val(),
            },
            dataType: "json",
            success: function (result) {
                $("#ward_selected").html(
                    "<option selected>Chọn phường xã</option>"
                );
                $.each(result, function (key, ward) {
                    $("#ward_selected").append(
                        '<option value="' +
                            ward.xaid +
                            '">' +
                            ward.name +
                            "</option>"
                    );
                });
            },
        });
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $("#btn-view-order button").on("click", function (e) {
        e.preventDefault();
        var o_id = $(this).attr("order-id");
        var url = $(this).attr("getUrlHistory");
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
    $("#change-address").on("click", function (){
        type = $(".cus-address").attr('type');
        if (type == 'hiden') {
            $("div.cus-address").append("<input type='hidden' name='new_add' value='1'>");
            $(".cus-address").attr('type','show');
            $(".cus-address").removeClass('d-none');
        } else {
            $(".cus-address").attr('type','hiden');
            $(".cus-address").addClass('d-none');
            $("input[name=new_add]").remove();
        }
    });

    $(".need-confirm").on("click", function (e) {
        e.preventDefault();
        confirmModal($(this));
    });

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
                location.reload();
            },
        });
    }
});
