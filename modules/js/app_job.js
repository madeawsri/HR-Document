/**
 * Created by boonyadol on 20/03/2017 09:35.
 */
var jPath = jServerName + "/../modules/db/" + jFileName + ".php?site=" + jSite;
var _fields = [ "datein","ndate", 'ptype',"aptype1",'aptype2',
                'ns','grtype','sutype','note',"sxtype","agtype","etypes","satype","etypes","status"];
var _dbfields = _fields.join();
var _selects = ['aptype1','aptype2','grtype','sutype',"ptype","sxtype","agtype","satype","status"];
var _selects_multi = ["etypes"];

var _masks = ['datein','ndate','ns'];
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
/*
var jPathExport = jServerName + "/../modules/export/pdf/" + jFileName + ".php?site=" + jSite;
function jPDFPrint(ids) {
    jDownload(jPathExport + '&url=' + encodeURI(ids));
}
$('.expButton').on('click', function () {
    jPDFPrint('pdf-person', '_parent');
});*/