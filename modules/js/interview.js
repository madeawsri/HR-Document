/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "cid","ddate", 'ssite',"sname",'rtype','note','sotype'];
var _dbfields = _fields.join();
var _selects = ['cid','rtype','sotype'];
var _masks = ['ddate'];
var _disables = ['cid'];
var _keyid = 'id';
var _selects_multi = ['sname'];
function jValidate(objfrm) {
    objfrm.validate({
        rules: {
        },
        messages: {
        }
    });
}

