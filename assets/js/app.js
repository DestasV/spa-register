require('../css/global.scss');

let $ = require('jquery');
require('bulma');

$(document).ready(function() {
    if (location.pathname.split('/')[1] === '') {
        callPage($('.navigation:first').attr('href'));
    }

    $('a.navigation').click(function (e) {
        e.preventDefault();
        let pageRef = $(this).attr('href');
        callPage(pageRef);
    });

    $('.content').on('click', '#login, #register, #update', function (e) {
        e.preventDefault();
        let $form = $(this).closest('form');
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize()
        })
            .done(function (data) {
                if (data.status === 'ok') {
                    $('.success').show().delay(3000).fadeOut();
                    $('.is-danger').hide();
                }
            })
            .fail(function (jqXHR) {
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')) {
                        $('.content').html(jqXHR.responseJSON.form);
                    }
                }
            });
    });
});


function callPage(pageRef) {
    $.ajax({
        url: pageRef,
        type: 'GET',
        dataType: 'json',

        success: function (response) {
            let $content = $('.content');
            $content.empty();
            $content.html(response);
        },

        error: function (error) {
            console.log(error);
        }
    })
}
