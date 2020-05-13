/**
 * Created by boonyadol on 27/02/2017.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "id",'name'];
var _dbfields = _fields.join();
var _selects = [];
var _selects_multi = [];
var _masks = [];
var _disables = [];
var _keyid = 'id';
function jValidate(objfrm) {
    objfrm.validate({
        rules: {
        },
        messages: {
        }
    });
}


///************ ADD DATA
var dialogAdd = null;
$('.addButton').on('click', function () {
    // Get the record's ID via attribute
    var mode = $(this).attr('data-mode');
    var tbname = $(this).attr('data-table');
    var tbtitle = $(this).attr('data-title');
    var objfrm = null;
    dialogAdd = bootbox.dialog({
        message: $(".form-add-content_" + tbname).html(),
        title: "เพิ่ม : " + tbtitle,
        buttons: [
            {
                label: "บันทึก",
                className: "btn btn-primary pull-right",
                callback: function () {
                    var ret= objfrm.submit();
                    return false;
                }
            },
            {
                label: "ยกเลิก",
                className: "btn btn-default pull-left",
                callback: function () {
                    console.log("just do something on close");
                }
            }
        ],
        show: true,
        onEscape: function () {
            dialogAdd.modal("hide");
        }
    }).on('shown.bs.modal', function () {
        objfrm = $('.bootbox-body #frmAdd' + tbname);
        actFormAdd(objfrm,tbname);
        objfrm.find('#tname').focus();
    });
    dialogAdd.modal("show");

});
function actFormAdd(objfrm,tb_name){
    var isCheckValid = false;
    objfrm.find('input, select, textarea').on('change', function() {
        $(this).valid();
        isCheckValid = $(this).valid();
        console.log($(this).valid());
    });
    objfrm.validate({
        messages: {
            tname: {
                required: ' <span class="bb text-red"> ** กรุณากรอกข้อมูลให้ครับ!!!  </span> '
            }
        }
    });
    objfrm.submit(function(event){
        var actTab = '';
        var frmTbName = $(this).find('[name="tbname"]').val();
        var frmName = $(this).find('[name="tname"]').val();

        var formData = {
            'mode'   : 'add'+frmTbName,
            'tname'  : frmName,
            'tbname' : frmTbName,
        };

        if(isCheckValid) {
            $.ajax({
                    // The link we are accessing.
                    url: jPath,
                    // The type of request.
                    type: "post",
                    data: formData,
                    // The type of data that is getting returned.
                    dataType: "json",
                    error: function () {},
                    beforeSend: function () {},
                    complete: function () {},
                    success: function (obj) {
                        console.log(obj);
                        JLoadMain(jFileName);
                        dialogAdd.modal('hide');
                        actTab = "tab"+frmTbName;
                        setTimeout(function(){
                            $('#tabid a[href="#'+actTab+'"]').trigger('click');
                        },100);
                        return false;

                    }
                }
            );
        }else{
            return false;
        }
        event.preventDefault();
    });

    return false;
}