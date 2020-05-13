// JavaScript Document
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "pmid", "mid" ];
var _dbfields = _fields.join();
var _selects = ['pmid','mid'];
var _masks = [];
var _disables = ['pmid'];
var _keyid = 'id';
var _selects_multi = [];
function jValidate(objfrm) {
    objfrm.validate({

    });
}



