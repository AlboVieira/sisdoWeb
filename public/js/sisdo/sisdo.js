/**
 * Created by albov on 10/09/2015.
 */

function sisdoAjax(url, type, data, callbackSuccess, targetId, extraParam) {

    extraParam = extraParam || {};

    return $.ajax($.extend(extraParam, {
        type: type,
        url: url,
        data: data,
        success: function (dataRet) {
            if (typeof callbackSuccess == 'function') {
                callbackSuccess(dataRet);
            }
            if (targetId != undefined) {
                jQuery(targetId).html(dataRet);
            }
        },

        error: function (jqXHR, timeout, message) {
            var contentType = jqXHR.getResponseHeader("Content-Type");
            if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                window.location.reload();
            } else {
                //var msg = Mensagens.MERRO + '<br>' + Mensagens.MERROINSTRUCAO;
                var msg = 'Ocorreu um erro ao tentar realizar a operaçao <br> <pre>' + jqXHR.responseText + '</pre>';
                showMessages(msg, 'danger');
            }
        }
    }));
}

$(document).ajaxStart(function () {
    $('#preloading').show();
});
//
$(document).ajaxStop(function () {
    $('#preloading').hide();
});

$(document).ready(function(){/* off-canvas sidebar toggle */

});

$(window).on("resize", function () {
    var newWidth = $("#jqGrid").closest(".ui-jqgrid").parent().width();
    $("#jqGrid").jqGrid("setGridWidth", newWidth, true);

});