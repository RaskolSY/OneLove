$('#openclose').click(function () {
    $('#downlist').slideToggle(500)
})
$(document).ready(function () {
    $('.toggle').click(function () {
        $('.divv').toggle();
    })
    $('.slide-toggle').click(function () {
        $('.divv').slideToggle();
    })
})
$('a[name=qdown]').click(function () {
    if ($('#qdown').css('display') == 'none') {
        $(this).html('-закрыть');
    }
    else {
        $(this).html('+открыть');
    }
    $('#qdown').slideToggle(500);
});
$('input[type=checkbox]').change(function () {
    if ($(this).prop('checked')) {
        $('.checkbox' + $(this).attr('class')).show(1000);
    }
    else {
        $('.checkbox' + $(this).attr('class')).hide(1000);
    }
});
$(document).ready(function () {
    $('.hide').click(function () {
        $('.phide:nth-of-type(1)').hide("slow")
        $('.phide:nth-of-type(2)').hide(2000)
        $('.phide:last').hide("fast")
    })
    $('.show').click(function () {
        $('.phide:nth-of-type(1)').show("slow")
        $('.phide:nth-of-type(2)').show(2000)
        $('.phide:last').show("fast")
    })
})
$('#all').click(function () {
    $('.all input:checkbox').click();
});
$('#all2').click(function () {
    var kol = $('.all2 input:checked').length;
    if (kol >= 0 && kol !== 5) {
        $('.all2 input:checked').click();
        $('.all2 input:checkbox').click();
    }
    if (kol == 5) {
        $('.all2 input:checkbox').click();
    }
});
