/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ ];
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
var _radios = [];
