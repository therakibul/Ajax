; (function ($) {
    $(document).ready(function () {
        $(".action-button").on('click', function () {
            let task = $(this).data("task");
            window[task]();
        });
    });
})(jQuery);

function simple_ajax_call() {
    let $ = jQuery;
    $.post(ajax_url.preview, {
        action: "ajaxTest",
        name: "MD Rakibul Hasan",
        n: ajax_url.nonce
    }, function (data) {
        console.log(data);
    });
}
function unp_ajax_call() {
    let $ = jQuery;
    $.post(ajax_url.preview, {
        action: "ajaxunp",
        info: "I am Rakibul Hasan"
    }, function (data) {
        console.log(data);
    });
}

function ajd_localize_script() {
    let $ = jQuery;
    $.post(ajax_url.preview, {
        action: "ajaxLc",
        message: bucket
    }, function (data) {
        console.log(data);
    });
}