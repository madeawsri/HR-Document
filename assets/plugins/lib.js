// JavaScript Document
JLoadMain('index');
function JLoadMain(page_id) {
    $('#main-loading').show();
    $('.content').hide();
    $.get(jServerName + "/../modules/index/" + page_id + ".php",
        {'m': page_id, 'site': jSite, 'mfname': page_id}, function (data) {
            $('.content').html(data.trim());
            $('#main-loading').hide();
            $('.content').show();
        });
}
function JLoadMainParam(page_id, id) {
    $('#main-loading').show();
    $('.content').hide();
    $.get(jServerName + "/../modules/index/" + page_id + ".php",
        {'m': page_id, 'site': jSite, 'id': id, 'mfname': page_id}, function (data) {
            $('.content').html(data.trim());
            $('#main-loading').hide();
            $('.content').show();
        });
}
function jStrPadding(n, p, c) {
    var pad_char = typeof c !== 'undefined' ? c : '0';
    var pad = new Array(1 + p).join(pad_char);
    return (pad + n).slice(-pad.length);
}

function jToday() {
    var d = new Date();
    var yyyy = d.getFullYear();
    var mm = d.getMonth() < 9 ? "0" + (d.getMonth() + 1) : (d.getMonth() + 1); // getMonth() is zero-based
    var dd = d.getDate() < 10 ? "0" + d.getDate() : d.getDate();
    var today = yyyy + '/' + mm + '/' + dd;

    return today;
}
function jTodayTh() {
    var d = new Date();
    var yyyy = d.getFullYear();
    var mm = d.getMonth() < 9 ? "0" + (d.getMonth() + 1) : (d.getMonth() + 1); // getMonth() is zero-based
    var dd = d.getDate() < 10 ? "0" + d.getDate() : d.getDate();
    var today =  dd + '/' + mm + '/' +  (parseInt(yyyy)+543);

    return today;
}

function jAutoFocus(id) {
    setTimeout(function () {
        $('#' + id).focus();
    }, 300);
}

function jAutoHide(id) {
    /// console.log('jAutoHide');
    setTimeout(function () {
        $('#' + id).addClass('hide').show();
    }, 300);
}
function jAutoShow(id) {
    setTimeout(function () {
        $('#' + id).removeClass('hide').show();
    }, 300);
}
function jLog(data) {
    console.log(data);
}

/* check card id  */
jQuery.validator.addMethod(
    "checkIDCard",
    function (value, element) {
        var pid = value;
        if (pid.trim() == "") return true;
        pid = pid.toString().replace(/\D/g, '');
        if (pid.length == 13) {
            var sum = 0;
            for (var i = 0; i < pid.length - 1; i++) {
                sum += Number(pid.charAt(i)) * (pid.length - i);
            }
            var last_digit = (11 - sum % 11) % 10;
            $(element).val(pid);
            return pid.charAt(12) == last_digit;
        } else {
            return false;
        }
    },
    "<small class='text-red bb'>รหัสบัตรประชาชนไม่ถูกต้อง </small>"
);

/* check date  */
jQuery.validator.addMethod("checkDate", function (value, element) {
    return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
}, "รูปแบบวันที่ต้องเป็น DD/MM/YYYY");
$.validator.addMethod("checkMail", function (value, element) {
    if (value != "-")
        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    else return true;
}, "รูปแบบอีเมล์ไม่ถูกต้อง.");

function jNavigate(href, target) {
    if (!target) target = '_blank';
    var a = document.createElement('a');
    a.href = href;
    a.setAttribute('target', target);
    a.click();
    return false;
}
function jDownload(link) {
    //window.location = link;
    jLog('jDownload');
    jLog(link);
    var strWindowFeatures = "directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no,width=800,height=450";
    window.open(link, "CNN_WindowName", strWindowFeatures);
    return false;
}

function jFileExist(url) {
    try {
        var xhr = new XMLHttpRequest();
        xhr.open('HEAD', url, false);
        try {
            xhr.send();
        } catch (er) {
            return false;
        }

        if (xhr.responseURL != "") {

            if (xhr.status == "404") {
                console.log("File doesn't exist");
                return false;
            } else {
                console.log("File exists");
                return true;
            }
        } else {
            jLog("error + " + url);
        }
    } catch (err) {
        jLog("--file not exist!!!--");
        return false;
    }

}

var dialogSettingEdit = null;
function jPageSettingEdit(objSet) {
    // Get the record's ID via attribute
    //jLog(objSet);
    var id = objSet.attr('data-id');
    var mode = objSet.attr('data-mode');
    var tbname = objSet.attr('data-table');
    var tbtitle = objSet.attr('data-title');

    var objfrm = null;
    dialogSettingEdit = bootbox.dialog({
        message: $(".form-edit-content_" + tbname).html(),
        title: "แก้ไข : " + tbtitle,
        buttons: [
            {
                label: "แก้ไข",
                className: "btn btn-primary pull-right",
                callback: function () {
                    var ret = objfrm.submit();
                    return false;
                }
            },
            {
                label: "ยกเลิก",
                className: "btn btn-default pull-left",
                callback: function () {
                    // console.log("just do something on close");
                }
            }
        ],
        show: true,
        onEscape: function () {
            dialogSettingEdit.modal("hide");
        }
    }).on('shown.bs.modal', function () {
        objfrm = $('.bootbox-body #frmEdit' + tbname);
        $.ajax({
            url: jPath + '&xsite=' + id + '&mode=' + mode + '&tbname=' + tbname,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
        }).success(function (response) {
            console.log(response);
            // Populate the form fields with the data returned from server
            setTimeout(function () {
                objfrm.find('#tid').val(response.DATA.id).end()
                    .find('#tname').val(response.DATA.name).end()
                    .find('#tbname').val(response.DATA.tbname).end();
                actFormSettingEdit(objfrm, tbname);
                objfrm.find('#tname').focus();
            }, 100);
        });
    });
    dialogSettingEdit.modal("show");
};
function actFormSettingEdit(objfrm, tb_name) {
    var isCheckValid = false;
    objfrm.find('input, select, textarea').on('change', function () {
        $(this).valid();
        isCheckValid = $(this).valid();
    });
    objfrm.validate({
        messages: {
            tname: {
                required: ' <span class="bb text-red"> ** กรุณากรอกข้อมูลให้ครับ!!!  </span> '
            }
        }
    });
    objfrm.submit(function (event) {

        var frmTbName = $(this).find('[name="tbname"]').val();
        var frmID = $(this).find('[name="tid"]').val();
        var frmName = $(this).find('[name="tname"]').val();

        var formData = {
            'mode': 'edit' + frmTbName,
            'tname': frmName,
            'tid': frmID,
            'tbname': frmTbName,
        };
        if (isCheckValid) {
            $.ajax({
                    // The link we are accessing.
                    url: jPath,
                    // The type of request.
                    type: "post",
                    data: formData,
                    // The type of data that is getting returned.
                    dataType: "json",
                    error: function () {
                    },
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (obj) {
                        if (obj.DATA == "OK") {
                            // console.log(obj);
                            var act_tb = "tb" + frmTbName + 'name' + frmID;
                            $('#' + act_tb).html(frmName);
                            dialogSettingEdit.modal('hide');
                        }
                    }
                }
            );
        }

        event.preventDefault();
    });

    return false;
}

var jPathDbLib = jServerName + "/../modules/db/initLib.php?site=" + jSite;
function jUploadPdf(p_obj) {

    var id = p_obj.attr('data-id');
    var cid = p_obj.attr('data-cid');
    var mode = p_obj.attr('data-mode');
    var tbname = p_obj.attr('data-table');
    var tbtitle = p_obj.attr('data-title');

    var param = new FormData();
    param.append('id', id);
    param.append('cid', cid);
    param.append('mode', 'pdfUpload');
    param.append('tbname', tbname);
    param.append('tbtitle', tbtitle);

    if (cid.trim().length != 13) {
        bootbox.alert("กรุณากรอกข้อมูล  <span class='text-color-red'> 'รหัสบัตรประจำตัวประชาชน' </span> นะครับ.  ");
        // jLog(cid.trim().length);
        return false;
    } else {
        //jLog(cid.trim().length);
    }

    $(function () { // multiple='true'

        var uploadHtml = "<div>" +

            '<div class="form-group">' +
            '<label for="">รายละเอียดสำหรับค้นหาเอกสารนี้</label>' +
            '<textarea class="form-control" id="detail" placeholder="เนื้อหาสำหรับค้นหาไฟล์นี้"></textarea>' +
            '</div>' +
            "<label class='upload-area' style='width:100%;' for='fupload'>" +
            '<div class="form-group">' +
            '<label for="">เอกสารแนบบไฟล์</label>' +
            "<input id='fupload' name='fupload' type='file' style=''  accept='application/pdf'></label></div>" +
            "</label>" +
                //"<br />" +
            "<span style='margin-left:5px;text-align: center; !important;' id='fileList'>" +
            '<img class="upLoading" style="display:none;" src=' + jServerName + '/../assets/images/ajax-loader.gif />' +
            "<div class='col-xs-12 file-list text-left'>" +
            "<ul class='lstFile products-list product-list-in-box'></ul>" +
            "</div></span>" +
            "</div><div class='clearfix'></div>";

        bootbox.dialog({
            message: uploadHtml,
            title: tbtitle,
            buttons: {
                success: {
                    label: "แนบบไฟล์",
                    className: "btn-default",
                    callback: function () {
                        jLog('Uploading Click')
                        var fileList = document.getElementById("fupload");
                        var files = fileList.files;
                        if ($('#detail').val()) {
                            if (files.length != 0) {
                                $('.upLoading').show();
                                //var data = new FormData();
                                var param = new FormData();
                                param.append('id', id);
                                param.append('cid', cid);
                                param.append('mode', 'pdfUpload');
                                param.append('tbname', tbname);
                                param.append('tbtitle', tbtitle);
                                for (var i = 0; i < files.length; i++) {
                                    param.append(files[i].name, files[i]);
                                }
                                param.append('detail', $('#detail').val());
                                $.ajax({
                                    url: jPathDbLib + '&mode=pdfUpload',
                                    type: 'POST',
                                    data: param,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                }).success(function (res) {
                                    jLog('+++ OK Upload PDF +++');
                                    jLog(res);

                                    var controlInput = $("#fupload");
                                    controlInput.replaceWith(controlInput = controlInput.val('').clone(true));
                                    var controlInput = $("#detail");
                                    controlInput.replaceWith(controlInput = controlInput.val('').clone(true));
                                    if (res.DATA.length > 0) {
                                        var i = res.DATA.length - 1;
                                        var item = '<li class="item">' +
                                            '<div>' +
                                            '<a href="' + jServerName + '/../uploads/' + jSite + '/' + res.DATA[i].cid + '/' + res.DATA[i].filename +
                                            '" class="product-title "  download="' + res.DATA[i].cid + '-' + i + '" > ' +
                                            'ฉบับที่ ' + (i + 1) + ') ' + tbtitle + ' ' + res.DATA[i].cid + '.pdf' +
                                            '<span class="label label-warning pull-right">ดาว์นโหลด</span> </a>' +
                                            '<span class="content-block" > คำสำคัญค้นหา : ' +
                                            '<small>' + res.DATA[i].detail + '</small>' +
                                            '</span>' +
                                            '</div>' +
                                            '</li>';

                                        $(".bootbox-body .lstFile").append(item);
                                    }
                                    $('.upLoading').hide();
                                });

                            } else {
                                bootbox.alert("กรุณาเลือกเอกสารไฟล์แนบบ PDF ไฟล์ !!! ");
                            }
                        } else {
                            bootbox.alert(" กรุณากรอกรายละเอียดเพื่อใช้ในการค้นหาไฟล์เอกสารนี้!! ");
                        }


                        return false;
                    }
                }
            }
        }).on('shown.bs.modal', function () {
            jLog("--shown.bs.modal--");

        });
    });
}
function jListPdf(p_obj) {
    $(".bootbox-body .lstFile").html('');
    var cid = p_obj.attr('data-cid');
    var tbname = p_obj.attr('data-table');
    var tbtitle = p_obj.attr('data-title');
    $.ajax({
        url: jPathDbLib + '&mode=getPdf&tbname=' + tbname + '&cid=' + cid,
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
    }).success(function (res) {
        jLog('load list pdf');
        jLog(res);
        if (res.DATA.length) {
            for (var i = 0; i < res.DATA.length; i++) {
                var item = '<li class="item">' +
                    '<div>' +
                    '<a href="' + jServerName + '/../uploads/' + jSite + '/' + res.DATA[i].cid + '/' + res.DATA[i].filename +
                    '" class="product-title "  download="' + res.DATA[i].cid + '-' + i + '" > ' +
                    'ฉบับที่ ' + (i + 1) + ') ' + tbtitle + ' ' + res.DATA[i].cid + '.pdf' +
                    '<span class="label label-warning pull-right">ดาว์นโหลด</span> </a>' +
                    '<span class="content-block" > คำสำคัญค้นหา : ' +
                    '<small>' + res.DATA[i].detail + '</small>' +
                    '</span>' +
                    '</div>' +
                    '</li>';

                $(".bootbox-body .lstFile").append(item);
            }
        }
    });

}

function jUploadSend(p_obj) {

    var id = p_obj.attr('data-id');
    var cid = p_obj.attr('data-cid');
    var mode = p_obj.attr('data-mode');
    var tbname = p_obj.attr('data-table');
    var tbtitle = p_obj.attr('data-title');

    var param = new FormData();
    param.append('id', id);
    param.append('cid', cid);
    param.append('mode', 'pdfUpload2');
    param.append('tbname', tbname);
    param.append('tbtitle', tbtitle);

    /*
    if (cid.trim().length != 13) {
        bootbox.alert("กรุณากรอกข้อมูล  <span class='text-color-red'> 'รหัสบัตรประจำตัวประชาชน' </span> นะครับ.  ");
        // jLog(cid.trim().length);
        return false;
    } else {
        //jLog(cid.trim().length);
    }*/

    $(function () { // multiple='true'

        var uploadHtml = "<div>" +

            '<div class="form-group">' +
            '<label for="">รายละเอียดสำหรับค้นหาเอกสารนี้</label>' +
            '<textarea class="form-control" id="detail" placeholder="เนื้อหาสำหรับค้นหาไฟล์นี้"></textarea>' +
            '</div>' +
            "<label class='upload-area' style='width:100%;' for='fupload'>" +
            '<div class="form-group">' +
            '<label for="">เอกสารแนบบไฟล์</label>' +
            "<input id='fupload' name='fupload' type='file' style=''  accept='application/pdf'></label></div>" +
            "</label>" +
                //"<br />" +
            "<span style='margin-left:5px;text-align: center; !important;' id='fileList'>" +
            '<img class="upLoading" style="display:none;" src=' + jServerName + '/../assets/images/ajax-loader.gif />' +
            "<div class='col-xs-12 file-list text-left'>" +
            "<ul class='lstFile products-list product-list-in-box'></ul>" +
            "</div></span>" +
            "</div><div class='clearfix'></div>";

        bootbox.dialog({
            message: uploadHtml,
            title: tbtitle,
            buttons: {
                success: {
                    label: "แนบบไฟล์",
                    className: "btn-default",
                    callback: function () {
                        jLog('Uploading Click')
                        var fileList = document.getElementById("fupload");
                        var files = fileList.files;
                        if ($('#detail').val()) {
                            if (files.length != 0) {
                                $('.upLoading').show();
                                //var data = new FormData();
                                var param = new FormData();
                                param.append('id', id);
                                param.append('cid', cid);
                                param.append('mode', 'pdfUpload2');
                                param.append('tbname', tbname);
                                param.append('tbtitle', tbtitle);
                                for (var i = 0; i < files.length; i++) {
                                    param.append(files[i].name, files[i]);
                                }
                                param.append('detail', $('#detail').val());
                                $.ajax({
                                    url: jPathDbLib + '&mode=pdfUpload2',
                                    type: 'POST',
                                    data: param,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                }).success(function (res) {
                                    jLog('+++ OK Upload PDF +++');
                                    jLog(res);

                                    var controlInput = $("#fupload");
                                    controlInput.replaceWith(controlInput = controlInput.val('').clone(true));
                                    var controlInput = $("#detail");
                                    controlInput.replaceWith(controlInput = controlInput.val('').clone(true));
                                    if (res.DATA.length > 0) {
                                        var i = res.DATA.length - 1;
                                        var item = '<li class="item">' +
                                            '<div>' +
                                            '<a href="' + jServerName + '/../uploads/' + jSite + '/' + res.DATA[i].cid + '/' + res.DATA[i].filename +
                                            '" class="product-title "  download="' + res.DATA[i].cid + '-' + i + '" > ' +
                                            'ฉบับที่ ' + (i + 1) + ') ' + tbtitle + ' ' + res.DATA[i].cid + '.pdf' +
                                            '<span class="label label-warning pull-right">ดาว์นโหลด</span> </a>' +
                                            '<span class="content-block" > คำสำคัญค้นหา : ' +
                                            '<small>' + res.DATA[i].detail + '</small>' +
                                            '</span>' +
                                            '</div>' +
                                            '</li>';

                                        $(".bootbox-body .lstFile").append(item);
                                    }
                                    $('.upLoading').hide();
                                });

                            } else {
                                bootbox.alert("กรุณาเลือกเอกสารไฟล์แนบบ PDF ไฟล์ !!! ");
                            }
                        } else {
                            bootbox.alert(" กรุณากรอกรายละเอียดเพื่อใช้ในการค้นหาไฟล์เอกสารนี้!! ");
                        }


                        return false;
                    }
                }
            }
        }).on('shown.bs.modal', function () {
            jLog("--shown.bs.modal--");

        });
    });
}
function jListSend(p_obj) {
    $(".bootbox-body .lstFile").html('');
    var cid = p_obj.attr('data-cid');
    var tbname = p_obj.attr('data-table');
    var tbtitle = p_obj.attr('data-title');
    $.ajax({
        url: jPathDbLib + '&mode=getPdf&tbname=' + tbname + '&cid=' + cid,
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
    }).success(function (res) {
        jLog('load list pdf');
        jLog(res);
        if (res.DATA.length) {
            for (var i = 0; i < res.DATA.length; i++) {
                var item = '<li class="item">' +
                    '<div>' +
                    '<a href="' + jServerName + '/../uploads/' + jSite + '/AppJob/' + res.DATA[i].filename +
                    '" class="product-title "  download="' + res.DATA[i].cid + '-' + i + '" > ' +
                    'ฉบับที่ ' + (i + 1) + ') ' + tbtitle + ' ' + res.DATA[i].cid + '.pdf' +
                    '<span class="label label-warning pull-right">ดาว์นโหลด</span> </a>' +
                    '<span class="content-block" > คำสำคัญค้นหา : ' +
                    '<small>' + res.DATA[i].detail + '</small>' +
                    '</span>' +
                    '</div>' +
                    '</li>';

                $(".bootbox-body .lstFile").append(item);
            }
        }
    });

}



var dialogEdit = null;
function jPageEditAss(objEdit) {
    // Get the record's ID via attribute
    var id = objEdit.attr('data-id');
    var cid = objEdit.attr('data-cid');
    var mode = objEdit.attr('data-mode');
    var tbname = objEdit.attr('data-table');
    var tbtitle = objEdit.attr('data-title');
    var objfrm = null;
    dialogEdit = bootbox.dialog({
        message: $(".form-edit-content_" + tbname).html(),
        title: "กรอก" + tbtitle,
        buttons: [
            {
                label: "ประเมิน",
                className: "btn btn-primary pull-right",
                callback: function () {
                    var ret = objfrm.submit();
                    return false;
                }
            },
            {
                label: "ยกเลิก",
                className: "btn btn-default pull-left",
                callback: function () {
                }
            }
        ],
        show: true,
        onEscape: function () {
            dialogEdit.modal("hide");
        }
    }).on('shown.bs.modal', function () {
        objfrm = $('.bootbox-body #frmEdit' + tbname);

        $.ajax({
            url: jPath + '&' + _keyid + '=' + id + '&mode=' + mode + '&tbname=' + tbname + '&keyid=' + _keyid,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
        }).success(function (response) {
            jLog('-- mode edit before dialog -- ');
            jLog(response);
            setTimeout(function () {

                var fkey = _fields[0];
                $.each(_fields, function (k, v) {
                    //jLog(jTodayTh());
                    if(v == 'asdate'){
                        if(response.DATA[v])
                            objfrm.find('#' + v).val(response.DATA[v]);
                        else
                            objfrm.find('#' + v).val(jTodayTh());
                    }else
                       objfrm.find('#' + v).val(response.DATA[v]);
                });
                objfrm.find('#tbname').val(response.DATA.tbname);
                objfrm.find('#id').val(response.DATA.id);
                actFormEditAss(objfrm, tbname);
                $.each(_selects, function (k, v) {
                    objfrm.find('#' + v).select2({dropdownParent: dialogEdit, allowClear: true,width: '100%'});
                });
                $.each(_selects_multi, function (k, v) {
                    var s2 = objfrm.find('#' + v).select2({dropdownParent: dialogEdit, allowClear: true,width: '100%' });
                    var vals = response.DATA_MULTI[v];
                    vals.forEach(function (e) {
                        if (!s2.find('option:contains(' + e + ')').length)
                            s2.append($('<option>').text(e));
                    });
                    s2.val(vals).trigger("change");
                });
                $.each(_masks, function (k, v) {
                    objfrm.find('#' + v).inputmask();
                });
                $.each(_disables, function (k, v) {
                    objfrm.find('#' + v).attr('disabled', true);
                });
                if(_radios)
                    $.each(_radios, function (k, v) {
                        objfrm.find('.' + v).iCheck({
                            radioClass: 'iradio_square-red',
                            increaseArea: '90%' // optional
                        }).on('ifChecked',function(){

                        });
                    });

                if(_radio_fields)
                    $.each(_radio_fields , function(k,v){
                        objfrm.find('[name='+v+'][value='+response.DATA.scores[k]+']').iCheck('check');
                    });

                objfrm.find('#' + fkey).focus();
            }, 100);
        });
    });
    dialogEdit.modal("show");
};
function actFormEditAss(objfrm, tb_name) {
    objfrm.find('input, select, textarea').on('blur', function () {
        $(this).valid();
    });
    jValidate(objfrm);
    objfrm.submit(function (event) {
        var actTab = '';
        var frmTbName = $(this).find('[name="tbname"]').val();
        var data = $(this).serializeArray();
       // jLog(data);
        var formData = {
            'mode': 'edit' + frmTbName,
            'dbfields': _dbfields,
            'dbradios': _dbradios,
            'keyid': _keyid, // not use yet.
            'id': objfrm.find('[name="id"]').val(),
            'asid' : objfrm.find('[name="pm1"]').attr('data-cate'),
            'wval' : objfrm.find('[name="pm1"]').attr('data-wval'),
        };
        $.each(data, function (k, v) {
          formData[v['name']] = v['value'];
        });
        jLog(formData);
        //fromData =  formData.push(data);
        if ($(this).valid()) {
            $.ajax({
                    // The link we are accessing.
                    url: jPath,
                    // The type of request.
                    type: "post",
                    data: formData,
                    // The type of data that is getting returned.
                    dataType: "json",
                    error: function () {
                    },
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (obj) {
                        jLog(obj);
                        JLoadMain(jFileName);
                        dialogEdit.modal('hide');
                        actTab = "tab" + frmTbName;
                        setTimeout(function () {
                            $('#tabid a[href="#' + actTab + '"]').trigger('click');
                        }, 100);
                        return false;
                    }
                }
            );
        } else {
            return false;
        }
        event.preventDefault();
    });
    return false;
}

function jPageEdit(objEdit) {
    // Get the record's ID via attribute
    var id = objEdit.attr('data-id');
    var cid = objEdit.attr('data-cid');
    var mode = objEdit.attr('data-mode');
    var tbname = objEdit.attr('data-table');
    var tbtitle = objEdit.attr('data-title');
    var objfrm = null;
    dialogEdit = bootbox.dialog({
        message: $(".form-edit-content_" + tbname).html(),
        title: "แก้ไข" + tbtitle,
        buttons: [
            {
                label: "แก้ไข",
                className: "btn btn-primary pull-right",
                callback: function () {
                    var ret = objfrm.submit();
                    return false;
                }
            },
            {
                label: "ยกเลิก",
                className: "btn btn-default pull-left",
                callback: function () {
                }
            }
        ],
        show: true,
        onEscape: function () {
            dialogEdit.modal("hide");
        }
    }).on('shown.bs.modal', function () {
        objfrm = $('.bootbox-body #frmEdit' + tbname);
        $.ajax({
            url: jPath + '&' + _keyid + '=' + id + '&mode=' + mode + '&tbname=' + tbname + '&keyid=' + _keyid,
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
        }).success(function (response) {
            jLog('-- mode edit before dialog -- ');
            jLog(response);
            setTimeout(function () {

                var fkey = _fields[0];
                $.each(_fields, function (k, v) {
                    objfrm.find('#' + v).val(response.DATA[v]);
                });
                objfrm.find('#tbname').val(response.DATA.tbname);
                objfrm.find('#id').val(response.DATA.id);
                actFormEdit(objfrm, tbname);
                $.each(_selects, function (k, v) {
                    objfrm.find('#' + v).select2({dropdownParent: dialogEdit, allowClear: true});
                });
                $.each(_selects_multi, function (k, v) {
                    var s2 = objfrm.find('#' + v).select2({dropdownParent: dialogEdit, allowClear: true});
                    var vals = response.DATA_MULTI[v];
                    vals.forEach(function (e) {
                        if (!s2.find('option:contains(' + e + ')').length)
                            s2.append($('<option>').text(e));
                    });
                    s2.val(vals).trigger("change");
                });
                $.each(_masks, function (k, v) {
                    objfrm.find('#' + v).inputmask();
                });
                $.each(_disables, function (k, v) {
                    //jLog(v + ' = ' + response.DATA[v]);
                    objfrm.find('#' + v).attr('disabled', true);
                });
                if(_radios)
                    $.each(_radios, function (k, v) {
                        objfrm.find('.' + v).iCheck({
                            radioClass: 'iradio_square-red',
                            increaseArea: '90%' // optional
                        });
                    });
                objfrm.find('#' + fkey).focus();
            }, 100);
        });
    });
    dialogEdit.modal("show");
};
function actFormEdit(objfrm, tb_name) {
    objfrm.find('input, select, textarea').on('blur', function () {
        $(this).valid();
    });
    jValidate(objfrm);
    objfrm.submit(function (event) {
        var actTab = '';
        var frmTbName = $(this).find('[name="tbname"]').val();
        var data = $(this).serializeArray();
        jLog(data);
        var formData = {
            'mode': 'edit' + frmTbName,
            'tbname': frmTbName,
            'dbfields': _dbfields,
            'keyid': _keyid, // not use yet.
            'id': objfrm.find('[name="id"]').val(),
        };
        $.each(_fields, function (k, v) {
            formData[v] = objfrm.find('[name="' + v + '"]').val();
        });
        //jLog(formData);
       //fromData =  formData.push(data);
        if ($(this).valid()) {
            $.ajax({
                    // The link we are accessing.
                    url: jPath,
                    // The type of request.
                    type: "post",
                    data: formData,
                    // The type of data that is getting returned.
                    dataType: "json",
                    error: function () {
                    },
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (obj) {
                        jLog(obj);
                        JLoadMain(jFileName);
                        dialogEdit.modal('hide');
                        actTab = "tab" + frmTbName;
                        setTimeout(function () {
                            $('#tabid a[href="#' + actTab + '"]').trigger('click');
                        }, 100);
                        return false;
                    }
                }
            );
        } else {
            return false;
        }
        event.preventDefault();
    });
    return false;
}

/// ------ ADDING DATA FORM
var dialogAdd = null;
function jPageAdd(objAdd) {
    // Get the record's ID via attribute
    var mode = objAdd.attr('data-mode');
    var tbname = objAdd.attr('data-table');
    var tbtitle = objAdd.attr('data-title');
    var objfrm = null;
    dialogAdd = bootbox.dialog({
        message: $(".form-add-content_" + tbname).html(),
        title: "เพิ่ม : " + tbtitle,
        buttons: [
            {
                label: "บันทึก",
                className: "btn btn-primary pull-right",
                callback: function () {
                    objfrm.submit();
                    return false;
                }
            },
            {
                label: "ยกเลิก",
                className: "btn btn-default pull-left",
                callback: function () {
                    jLog("just do something on close");
                }
            }
        ],
        show: true,
        onEscape: function () {
            dialogAdd.modal("hide");
        }
    }).on('shown.bs.modal', function () {
        objfrm = $('.bootbox-body #frmAdd' + tbname);
        actFormAdd(objfrm, tbname);
        var fkey = _fields[0];
        if (_selects)
            $.each(_selects, function (k, v) {
                objfrm.find('#' + v).select2({dropdownParent: dialogAdd, allowClear: true});
            });
        if (_selects_multi)
            $.each(_selects_multi, function (k, v) {
                var s2 = objfrm.find('#' + v).select2({placeholder: " เลือกได้มากว่าหนึ่งรายการ "});
            });
        if (_masks)
            $.each(_masks, function (k, v) {
                objfrm.find('#' + v).inputmask();
            });
        objfrm.find('#' + fkey).focus();

    });
    dialogAdd.modal("show");

};
function actFormAdd(objfrm, tb_name) {
    objfrm.find('input, select, textarea').on('blur', function () {
        $(this).valid();
    });
    jValidate(objfrm);
    objfrm.submit(function (event) {
        jLog('+++ Action Form : Add +++ ');
        var actTab = '';
        var frmTbName = $(this).find('[name="tbname"]').val();
        var formData = {
            'mode': 'add' + frmTbName,
            'tbname': frmTbName,
            'dbfields': _dbfields,
            'keyid': _keyid,
        };
        $.each(_fields, function (k, v) {
            formData[v] = objfrm.find('[name="' + v + '"]').val();
        });
        if ($(this).valid()) {
            $.ajax({
                    // The link we are accessing.
                    url: jPath,
                    // The type of request.
                    type: "post",
                    data: formData,
                    // The type of data that is getting returned.
                    dataType: "json",
                    error: function (obj) {
                        jLog(obj);
                    },
                    beforeSend: function (obj) {
                    },
                    complete: function (obj) {
                    },
                    success: function (obj) {
                        jLog(obj);
                        JLoadMain(jFileName);
                        dialogAdd.modal('hide');
                        actTab = "tab" + frmTbName;
                        setTimeout(function () {
                            $('#tabid a[href="#' + actTab + '"]').trigger('click');
                        }, 100);
                        return false;
                    }
                }
            );
        } else {
            return false;
        }
        event.preventDefault();
    });

    return false;
}
/// ------ END ADD


var dialogPic = null;
function jPagePic(objPic) {

    var id = objPic.attr('data-id');
    var cid = objPic.attr('data-cid');
    var mode = objPic.attr('data-mode');
    var tbname = objPic.attr('data-table');
    var tbtitle = objPic.attr('data-title');
    var checkSrc = false;
    var isSelectImage = false;


    if (cid.trim().length != 13) {
        bootbox.alert("กรุณากรอกข้อมูล  <span class='text-color-red'> 'รหัสบัตรประจำตัวประชาชน' </span> นะครับ.  ");
        return false;
    }

    $(function () { // multiple='true'
        var uploadHtml = "<div>" +
            "<label class='upload-area' style='width:100%;text-align:center;' for='fupload'>" +
            "<form  enctype='multipart/form-data' name='frmImgUpload' id='frmImgUpload' >" +
            "<input id='fupload' name='fupload' type='file' style='display:none;'  accept='image/jpeg'></form>" +
            "<i class='fa fa-cloud-upload fa-3x'></i>" +
            "<br />" +
            "คลิกเลือกรูปภาพ" +
            "</label>" +
            "<br />" +
            "<span style='margin-left:5px;text-align: center; !important;' id='fileList'>" +
            "<div class='upLoading' style='display: none;'><img src='" + jServerName + "/../assets/images/ajax-loader.gif' /> </div>" +
            "<div class='col-xs-12 file-list text-center'></div></span>" +
            "</div><div class='clearfix'></div>";

        bootbox.dialog({
            message: uploadHtml,
            title: tbtitle,
            buttons: {
                success: {
                    label: "อัพโหลด",
                    className: "btn-default",
                    callback: function (data) {

                        // what you wanna do here ...
                        if (isSelectImage) {
                            $('.upLoading').show();
                            var fileList = document.getElementById("fupload");
                            var files = fileList.files;
                            if (files.length != 0) {
                                //var data = new FormData();
                                var param = new FormData();
                                param.append('id', id);
                                param.append('cid', cid);
                                param.append('mode', mode + tbname);
                                param.append('tbname', tbname);
                                param.append('tbtitle', tbtitle);
                                param.append('keyid', _keyid);
                                for (var i = 0; i < files.length; i++) {
                                    param.append(files[i].name, files[i]);
                                }
                            }
                            $.ajax({
                                url: jPath + '&mode=imgUpload',
                                type: 'POST',
                                data: param,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                            }).success(function (res) {
                                jLog('+++ Image Upload +++');
                                jLog(res);
                                $('.upLoading').hide();
                            });
                        }
                        return false;
                    }
                }
            }
        }).on('shown.bs.modal', function () {
            jLog("--shown.bs.modal--");
            var gSrc = jServerName + "/../uploads/" + jSite + "/" + cid + "/" + cid + ".jpg";
            jLog(gSrc);
            $.ajax({
                async: false,
                url: jPath + '&mode=imgExist&cid=' + cid,
                type: 'POST',
                dataType: 'json',
                success: function (obj) {
                    jLog(obj);
                    checkSrc = obj.DATA;
                }
            });
            jLog(checkSrc);
            if (checkSrc)
                $(".bootbox-body .file-list")
                    .html("<img src='" + gSrc + "' title='" + cid +
                    "' class='img-thumbnail' width='200' height='200' />");

        });
        var fileList = document.getElementById("fupload");
        fileList.addEventListener("change", function (e) {
            isSelectImage = false;
            $(".bootbox-body .file-list").html('');
            $.each(this.files, function (k, v) {
                isSelectImage = true;
                $(".bootbox-body .file-list")
                    .append("<img id='image" + k +
                    "' class='img-thumbnail' width='200' height='200' />");
            });
            $.each(this.files, function (i, file) {
                var img = $(".bootbox-body #image" + i);
                img.attr('class', 'img-thumbnail');
                var reader = new FileReader();
                reader.onloadend = function () {
                    img.prop('src', reader.result);
                }
                reader.readAsDataURL(file);
            });
        }, false);
    });
};

function jPagePicOnly(objPic) {

    var id = objPic.attr('data-id');
    var cid = objPic.attr('data-cid');
    var mode = objPic.attr('data-mode');
    var tbname = objPic.attr('data-table');
    var tbtitle = objPic.attr('data-title');
    var checkSrc = false;
    var isSelectImage = false;


    if (cid.trim().length != 13) {
        bootbox.alert("กรุณากรอกข้อมูล  <span class='text-color-red'> 'รหัสบัตรประจำตัวประชาชน' </span> นะครับ.  ");
        return false;
    }

    $(function () { // multiple='true'
        var uploadHtml = "<div>" +

            "<span style='margin-left:5px;text-align: center; !important;' id='fileList'>" +
            "<div class='upLoading' style='display: none;'><img src='" + jServerName + "/../assets/images/ajax-loader.gif' /> </div>" +
            "<div class='col-xs-12 file-list text-center'></div></span>" +
            "</div><div class='clearfix'></div>";

        bootbox.dialog({
            message: uploadHtml,
            title: tbtitle,
        }).on('shown.bs.modal', function () {
            jLog("--shown.bs.modal--");
            var gSrc = jServerName + "/../uploads/" + jSite + "/" + cid + "/" + cid + ".jpg";
            jLog(gSrc);
            $.ajax({
                async: false,
                url: jPath + '&mode=imgExist&cid=' + cid,
                type: 'POST',
                dataType: 'json',
                success: function (obj) {
                    jLog(obj);
                    checkSrc = obj.DATA;
                }
            });
            jLog(checkSrc);
            if (checkSrc)
                $(".bootbox-body .file-list")
                    .html("<img src='" + gSrc + "' title='" + cid +
                    "' class='img-thumbnail' width='200' height='200' />");

        });

    });
};

var dialogDel = null;
function jPageDel(objDel) {
    var id = objDel.attr('data-id');
    var mode = objDel.attr('data-mode');
    var tbname = objDel.attr('data-table');
    var tbtitle = objDel.attr('data-title');
    var param = new FormData();
    param.append('id', id);
    param.append('mode', mode + tbname);
    param.append('tbname', tbname);
    param.append('tbtitle', tbtitle);
    param.append('keyid', _keyid);
    var info = null;
    $.ajax({
        async: false,
        url: jPath + '&mode=get&keyid=' + _keyid
        + '&tbname=' + tbname
        + '&id=' + id,
        dataType: 'json',
        success: function (obj) {
            info = obj;
        }
    });
    jLog(info);
    dialogDel = bootbox.confirm({
        title: " " + tbtitle,
        message: " คุณต้องการลบข้อมูลนี้" + " หรือไม่ ?",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    url: jPath + '&mode=del',
                    type: 'POST',
                    data: param,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).success(function (res) {
                    jLog(res);
                    JLoadMain(jFileName);
                    dialogDel.modal('hide');
                    actTab = "tab" + tbname;
                    setTimeout(function () {
                        $('#tabid a[href="#' + actTab + '"]').trigger('click');
                    }, 100);
                    return false;
                });
            }

        }
    });
}


function jPmRadio(objPm) {
    var id = objPm.attr('data-id');
    var mode = 'edit-pmtype';
    var val = objPm.val();
    $.ajax({
        url: jPath + '&mode=' + mode + '&id=' + id + '&val=' + val,
        type: 'POST',
        dataType: 'json',
        success: function (obj) {
            jLog(obj);
        }
    });
}

function jPmRadioApp(objPm) {
    var id = objPm.attr('data-id');
    var mode = 'edit-app';
    var val = objPm.val();
    $.ajax({
        url: jPath + '&mode=' + mode + '&id=' + id + '&val=' + val,
        type: 'POST',
        dataType: 'json',
        success: function (obj) {
            jLog(obj);
        }
    });
}


function jPmCheckbox(objPm) {
    var id = objPm.attr('data-id');
    var mode = 'edit-pmtype';
    var val = Number(objPm.prop("checked"));
    var field = objPm.attr('data-option');

    //jLog(val+' change PM '+ id);
    $.ajax({
        url: jPath + '&mode=' + mode + '&id=' + id + '&val=' + val + '&f=' + field,
        type: 'POST',
        dataType: 'json',
        success: function (obj) {
            jLog(obj);
        }
    });
}

function jPageInfo(objInfo) {
    jLog("++ lib info ++");
    var cardid = objInfo.attr('data-cid');
    $.ajax({
        url: jServerName + '/../modules/db/profile.php?cid=' + cardid + '&site=' + jSite,
        type: 'POST',
        dataType: 'json',
        success: function (obj) {
            jLog(obj);
            if (obj.DATA == 1)
                JLoadMainParam('profile', cardid);
            else {
                bootbox.alert(" ไม่พบข้อมูล!! ", function (ret) {
                    setTimeout(function () {
                        objFrm.val('').focus();
                    }, 300);
                });
            }
        }
    });
}

function jPersonInfo(gtitle, jobid) {

    $.get(jServerName + "/../modules/index/profile.php",
        {'m': 'profile', 'site': jSite, 'id': jobid, 'mfname': 'profile'}, function (data) {
            var data = data.trim();
            bootbox.dialog({title: 'แผนก' + decodeURI(gtitle), message: data})
                .find("div.modal-dialog").css({"width": "100%", "height": "100%"});

        });
}
function jMenuPermis() {
    $('input[type=\"checkbox\"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    }).on('ifChanged', function (e) {
        jPmCheckbox($(this));
    });
}

function jInfoAsm(obj) {
    bootbox.alert(obj.attr('data-id'));
}

function jPDFPrint(ids) {
    var jPathExport = jServerName + "/../modules/export/pdf/" + jFileName + ".php?site=" + jSite;
    jDownload(jPathExport + '&url=' + encodeURI(ids));
}

/***************************************************************/
// scroll lock needed? Set it in your method
var scrollLock = false;
window.onresize = function() {
    if (scrollLock) {
        scrollMethod();
    }
}

// Set here your fix scroll position
var fixYScrollPosition = 0;
// this method makes that you only can scroll horizontal
function scrollMethod(){
    // scrolls to position
    window.scrollTo(window.scrollX, fixYScrollPosition); // window.scrollX gives actual position
}

// when you zoom in or you have a div which is scrollable, you can watch only the height of the div
function scrollMethod2() {
    var windowHeight = window.innerHeight;
    // the actual y scroll position
    var scrollHeight = window.scrollY;
    // the height of the div under the window
    var restHeight = scrollableDivHeight - (scrollHeight + windowHeight);
    // the height of the div over the window
    var topDivHeight = scrollHeight - 600 /* the height of the content over the div */;
    // Set the scroll position if needed
    if (restHeight <= 0) {
        // don't let the user go under the div
        window.scrollTo(window.scrollX, scrollHeight + restHeight);
    }
    else if (scrollHeight - 600 /* the height of the content over the div */ < 0) {
        // don't let the user go over the div
        window.scrollTo(window.scrollX, scrollHeight - topDivHeight);
    }
}
