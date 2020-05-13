/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "cid","rdate", 'idate',"note2"];
var _dbfields = _fields.join();
var _selects = ['cid'];
var _masks = ['rdate','idate'];
var _disables = ['cid'];
var _keyid = 'id';
var _selects_multi = [];
function jValidate(objfrm) {
    objfrm.validate({
        rules: {
        },
        messages: {
        }
    });
}

