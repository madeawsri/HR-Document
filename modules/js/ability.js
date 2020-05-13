/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "cid","abname1", 'abname2',"abname3",'abname4' ];
var _dbfields = _fields.join();
var _selects = ['cid'];
var _masks = [];
var _selects_multi = [];
var _disables = ['cid'];
var _keyid = 'id';
function jValidate(objfrm) {
    objfrm.validate({
        rules: {
        },
        messages: {
        }
    });
}

