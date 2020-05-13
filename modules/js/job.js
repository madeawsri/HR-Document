/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "din","dexp", 'jtype',"djob",'nn'];
var _dbfields = _fields.join();
var _selects = ['jtype','djob'];
var _selects_multi = [];

var _masks = ['din','dexp','nn'];
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


var dialogDel = null;
$('.delButton').on('click', function () {
    var id = $(this).attr('data-id');
    var mode = $(this).attr('data-mode');
    var tbname = $(this).attr('data-table');
    var tbtitle = $(this).attr('data-title');

    bootbox.confirm({
        title: "Destroy planet?",
        message: "Do you want to activate the Deathstar now? This cannot be undone.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            jLog('This was logged in the callback: ' + result);
        }
    });

});