/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;


$('.expButton').on('click', function () {
    jPDFPrint('pdf-person', '_parent');
});

var _fields = ["cid", "pname", "fname", "lname", "bdate", "addr", "tel", "email", "lineid"];
var _dbfields = _fields.join();
var _selects = ['pname'];
var _selects_multi = [];
var _masks = ['cid', 'bdate'];
var _keyid = 'id';
var _disables = [];
function jValidate(objfrm) {
    objfrm.validate({
        rules: {
            //cid: {checkIDCard: true},
            bdate: {checkDate: true},
            email: {checkMail: true}
        },
        messages: {
            /*cid: {required: "<small >รหัสบัตรประชาชนต้องมี 13 หลัก </small>"},*/
            bdate: {required: "<small > วันเกิดให้ถูกต้อง </small>"}
        }
    });
}



