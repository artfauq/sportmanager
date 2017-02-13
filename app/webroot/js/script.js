$(document).ready(function () {
    $('#nav-icon').click(function () {
        $('.navigation li:not(:first-child, .icon), .navigation .pull-right li').toggle();
        return false;
    });

    $(window).resize(function () {
        if ($('#nav-icon').parent().css('display') === 'none') {
            $('.navigation li:not(:first-child, .icon), .navigation .pull-right li').show();
        }
    });

    /// CAROUSEL
    $('.carousel').carousel({
        interval: 4000
    });

    /// NOTIFICATIONS
    $('.isa_info, .isa_success, .isa_warning, .isa_error').mouseleave(function () {
        $(this).animate({opacity: 1.0}).slideUp(500);
    });
    /// STICKERS
    $('.stickerLink').focus(function () {
        $(this).popover('hide');
        $('.collapse').collapse('hide');
        if (!$(this).parent().hasClass("selected")) {
            $('.sticker').removeClass("selected");
            $(this).parent().addClass("selected");
            $($(this).parent().attr('href')).collapse('show');
        } else {
            $('.sticker').removeClass("selected");
            $(this).parent().removeClass("selected");
        }
    });

    // POPOVER
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    /// SUBMIT BUTTON CHANGE
    $('#MemberSignupForm, #MemberSigninForm').submit(function () {
        $('.submitButton').button('loading');
    });

    /// COLLAPSIBLE ELEMENT
    jQuery.fn.rotate = function (degrees) {
        $(this).css({'-webkit-transform': 'rotate(' + degrees + 'deg)',
            '-moz-transform': 'rotate(' + degrees + 'deg)',
            '-ms-transform': 'rotate(' + degrees + 'deg)',
            'transform': 'rotate(' + degrees + 'deg)',
            'transition': 'transform .3s'});
    };
    $('.collapseLink').click(function () {
        $(this).closest('div').next('.row').children('.collapseElement').slideToggle(250);
        rotation = getRotationDegrees($(this).children('i'));
        if (rotation === 90) {
            rotation += -90;
            $(this).children('i').rotate(rotation);
        } else {
            rotation += 90;
            $(this).children('i').rotate(rotation);
        }
    });
    $('.addObject').click(function () {
        $(this).closest('div').next('.row').children('.newObject').slideToggle(250);
        rotation = getRotationDegrees($(this).children('i'));
        if (rotation === 45) {
            rotation += -45;
            $(this).children('i').rotate(rotation);
        } else {
            rotation += 45;
            $(this).children('i').rotate(rotation);
        }
    });
    $(function () {
        if (($('.newObject').hasClass('displayedContent')) && ($('.newObject').css('display') === 'none')) {
            $('.newObject').slideToggle(250);
            rotation = getRotationDegrees($('.addObject').children('i'));
            if (!rotation || (rotation === 45)) {
                rotation += -45;
                $('.addObject').children('i').rotate(rotation);
            } else {
                rotation += 45;
                $('.addObject').children('i').rotate(rotation);
            }
        }
    });
    function getRotationDegrees(obj) {
        var matrix = obj.css("-webkit-transform") ||
                obj.css("-moz-transform") ||
                obj.css("-ms-transform") ||
                obj.css("-o-transform") ||
                obj.css("transform");
        if (matrix !== 'none') {
            var values = matrix.split('(')[1].split(')')[0].split(',');
            var a = values[0];
            var b = values[1];
            var angle = Math.round(Math.atan2(b, a) * (180 / Math.PI));
        } else {
            var angle = 0;
        }
        return (angle < 0) ? angle + 360 : angle;
    }

    /// BACK TO TOP BUTTON
    var offset = 350;
    var offset_opacity = 1200;
    var duration = 700;
    $(window).scroll(function () {
        ($(this).scrollTop() > offset) ? $('.back-to-top').addClass('cd-is-visible') : $('.back-to-top').removeClass('cd-is-visible cd-fade-out');
        if ($(this).scrollTop() > offset_opacity) {
            $('.back-to-top').addClass('cd-fade-out');
        }
    });
    $('.back-to-top').click(function (event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, duration);
        return false;
    });

    /// DATETIMEPICKER
    $append = '';
    for (var xh = 0; xh <= 23; xh++) {
        for (var xm = 0; xm < 60; xm += 15) {
            $append += "'" + ("0" + xh).slice(-2) + ':' + ("0" + xm).slice(-2) + "',";
        }
    }

    $('#date_timepicker_start').datetimepicker({
        onShow: function () {
            this.setOptions({
                minDate: $('#date_timepicker_end').val() ? $('#date_timepicker_end').val() : false,
                maxDate: $('#date_timepicker_end').val() ? $('#date_timepicker_end').val() : false,
                mask: false,
                allowTimes: ['00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45'],
            });
        },
        onClose: function () {
            if (!$('#date_timepicker_end').val()) {
                $('#date_timepicker_end').val($('#date_timepicker_start').val());
            }
        }
    });
    $('#date_timepicker_end').datetimepicker({
        onShow: function () {
            this.setOptions({
                minDate: $('#date_timepicker_start').val() ? $('#date_timepicker_start').val() : false,
                maxDate: $('#date_timepicker_start').val() ? $('#date_timepicker_start').val() : false,
                mask: false,
                allowTimes: ['00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45'],
            });
        },
        onClose: function () {
            if (!$('#date_timepicker_start').val()) {
                $('#date_timepicker_start').val($('#date_timepicker_end').val());
            }
        }
    });
    /// MAPS
    $('.googleMap').each(function () {
        $lat = $(this).attr('id').substring(0, $(this).attr('id').indexOf('_'));
        $long = $(this).attr('id').substring($(this).attr('id').indexOf('_') + 1);
        $center = new google.maps.LatLng($lat, $long);
        $options = {
            center: $center,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        $map = new google.maps.Map($(this)[0], $options);
        $marker = new google.maps.Marker({
            map: $map,
            position: $center
        });
    });
    // GET COORDINATES
    $('#test, #location_latitude').click(function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            $(this).innerHTML = "Geolocation is not supported by this browser.";
        }
    });
    function showPosition(position) {
        $('#location_latitude').val(position.coords.latitude);
        $('#location_logitude').val(position.coords.longitude);
    }
});

