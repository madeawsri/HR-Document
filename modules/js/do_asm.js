/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "cid","asdate","note","notype"];
var _radio_fields = ['pm1','pm2','pm3','pm4','pm5','pm6','pm7'];
var _dbradios = _radio_fields.join();
var _dbfields = _fields.join();
var _selects = ['notype'];
var _masks = ['asdate'];
var _disables = ['cid'];
var _keyid = 'id';
var _selects_multi = [];
var _radios = ['pmRadio-ass'];
function jValidate(objfrm) {
    objfrm.validate({
        rules: {
        },
        messages: {
        }
    });
}

function jPmRadio(objPm) {
    var id = objPm.attr('data-id');
    var mode = 'edit-interview';
    var val = Number(objPm.prop("checked"));
    var field = objPm.attr('data-option');

    $.ajax({
        url: jPath + '&mode=' + mode + '&id=' + id + '&val=' + val + '&f=' + field,
        type: 'POST',
        dataType: 'json',
        success: function (obj) {
            jLog(obj);
        }
    });
}

