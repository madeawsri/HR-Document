/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "cid","regp", "regg", "rdate" ];
var _dbfields = _fields.join();
var _selects = ['cid','regp'];
var _masks = ['rdate'];
var _disables = ['cid'];
var _selects_multi = [];
var _keyid = 'id';
function jValidate(objfrm) {

     objfrm.validate({
     rules: {
     rdate: {checkDate: true},

     },
     messages: {
        rdate: {required: "<small > วันที่ให้ถูกต้อง </small>"}
     }
     });


}

