/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    'use strict';
    /* delete confirm */
    $('form#delete').submit(function (e) {
        var $form = $(this), $hidden = $form.find('input[name="modal"]');
        if ($hidden.val() === '0') {
            e.preventDefault();
            $('#delete_confirm').modal('show');
            $('#delete_confirm').find('button.btn-danger').click(function () {
                $('#delete_confirm').modal('hide');
                $hidden.val('1');
                $form.submit();
            });
        }
    });

    /* filter icon */
    $('button.filter').click(function () {
        var $icon = $(this).find('i'), target = $(this).attr('data-target');
        if ($icon.length) {
            if ($(target).height() > 0) {
                $icon.attr('class', 'fa fa-angle-down');
            } else {
                $icon.attr('class', 'fa fa-angle-right');
            }
        }
    });
});
