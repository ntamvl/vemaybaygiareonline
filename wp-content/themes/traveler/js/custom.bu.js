$('ul.slimmenu').slimmenu({
    resizeWidth: '800',
    collapserTitle: 'Main Menu',
    animSpeed: 250,
    indentChildren: true,
    childrenIndenter: ''
});

$('.btn').button();

$("[rel='tooltip']").tooltip();

$('.form-group').each(function() {
    var self = $(this),
        input = self.find('input');

    input.focus(function() {
        self.addClass('form-group-focus');
    })

    input.blur(function() {
        if (input.val()) {
            self.addClass('form-group-filled');
        } else {
            self.removeClass('form-group-filled');
        }
        self.removeClass('form-group-focus');
    });
});

$('.typeahead').typeahead({
    hint: true,
    highlight: true,
    minLength: 3,
    limit: 8
}, {
    source: function(q, cb) {
        return $.ajax({
            dataType: 'json',
            type: 'get',
            url: 'http://gd.geobytes.com/AutoCompleteCity?callback=?&q=' + q,
            chache: false,
            success: function(data) {
                result = [];
                $.each(data, function(index, val) {
                    result.push({
                        value: val
                    });
                });
                cb(result);
            }
        });
    }
});

$('.booking-item-price-calc .checkbox label').click(function() {
    var checkboxDiv = $(this).find('.icheck'),
        checked = $(checkboxDiv).hasClass('checked'),
        price = parseInt($(this).find('span.pull-right').html().replace('$', '')),
        eqPrice = $('#car-equipment-total'),
        tPrice = $('#car-total'),
        eqPriceInt = parseInt(eqPrice.attr('data-value')),
        tPriceInt = parseInt(tPrice.attr('data-value')),
        animateInt = function(val, el, plus) {
            value = function() {
                if (plus) {
                    return el.attr('data-value', val + price);
                } else {
                    return el.attr('data-value', val - price);
                }
            };
            return $({
                val: val
            }).animate({
                val: parseInt(value().attr('data-value'))
            }, {
                duration: 500,
                easing: 'swing',
                step: function() {
                    if (plus) {
                        el.text(Math.ceil(this.val));
                    } else {
                        el.text(Math.floor(this.val));
                    }
                }
            });
        };
    if (!checked) {
        animateInt(eqPriceInt, eqPrice, true);
        animateInt(tPriceInt, tPrice, true);
    } else {
        animateInt(eqPriceInt, eqPrice, false);
        animateInt(tPriceInt, tPrice, false);
    }
});

// $('.date-pick-years').datetimepicker({
//     pickTime: false,
//     viewMode: 'years'
// })

// $('.date-pick-range').each(function() {

//     var start = $(this).find('.date-pick-start'),
//         end = $(this).find('.date-pick-end'),
//         setToMax = false;

//     $(start).datetimepicker({
//         pickTime: false,
//         useCurrent: true,
//         minDate: moment().subtract('days', 1),
//         defaultDate: moment()
//     });
//     $(end).datetimepicker({
//         pickTime: false,
//         useCurrent: true,
//         minDate: moment(),
//         defaultDate: moment().add('days', 7)
//     });


//     // var setToMax = false;
//     start.on('dp.change', function(e) {
//         end.data('DateTimePicker').setMinDate(e.date);
//         if (!setToMax) {
//             end.data('DateTimePicker').setDate(e.date.add('days', 7));
//         }
//     });
//     end.on('dp.change', function(e) {
//         start.data('DateTimePicker').setMaxDate(e.date);
//         setToMax = true;
//     });
// });

// $('.date-pick-years-moths').datetimepicker({
//     pickTime: false,
//     viewMode: 'years',
//     // minViewMode: 'months',
//     format: 'MM/YYYY'
// });

// $('input.time-pick').datetimepicker({
//     pickDate: false,
//     icons: {
//         up: "fa fa-chevron-up",
//         down: "fa fa-chevron-down"
//     },
//     minuteStepping: 15
// });

$('#sex-select .fa').click(function() {
    $(this).addClass('selected');
    console.log($(this).siblings());
    $(this).siblings().removeClass('selected');
});

$('div.bg-parallax').each(function() {
    var $obj = $(this);

    $(window).scroll(function() {
        // var yPos = -($(window).scrollTop() / $obj.data('speed'));
        var animSpeed;
        if ($obj.hasClass('bg-blur')) {
            animSpeed = 10;
        } else {
            animSpeed = 15;
        }
        var yPos = -($(window).scrollTop() / animSpeed);
        var bgpos = '50% ' + yPos + 'px';
        $obj.css('background-position', bgpos);

    });
});


$(document).ready(
    function() {
        $('html, .nice-scroll').niceScroll({
            cursorcolor: "#000",
            cursorborder: "0px solid #fff",
            railpadding: {
                top: 0,
                right: 0,
                left: 0,
                bottom: 0
            },
            cursorwidth: "5px",
            cursorborderradius: "0px",
            cursoropacitymin: 0,
            cursoropacitymax: 0.7,
            boxzoom: true,
            horizrailenabled: false,
            zindex: 9999
        });
    }
);

// $('.nav-drop').click(function() {
//     if ($(this).hasClass('active')) {
//         $(this).removeClass('active');
//     } else {
//         $(this).addClass('active');
//     }
// });

// $(document).on('click', function() {
//     $('.nav-drop').removeClass('active');
// });

$('.nav-drop').dropit();


$("#price-slider").ionRangeSlider({
    min: 130,
    max: 575,
    type: 'double',
    prefix: "$",
    // maxPostfix: "+",
    prettify: false,
    hasGrid: true
});

$('.i-check, .i-radio').iCheck({
    checkboxClass: 'i-check',
    radioClass: 'i-radio'
});



$('.booking-item-review-expand').click(function(event) {
    console.log('baz');
    var parent = $(this).parent('.booking-item-review-content');
    if (parent.hasClass('expanded')) {
        parent.removeClass('expanded');
    } else {
        parent.addClass('expanded');
    }
});

// $(window).scroll(function() {
//     var sticky = $('.sticky'),
//         loc = sticky.position().top;
//     if (loc >= $(this).scrollTop()) {
//         if (sticky.hasClass('fixed')) {
//             sticky.removeClass('fixed');
//         }
//     } else {
//         if (!sticky.hasClass('fixed')) {
//             sticky.addClass('fixed');
//         }
//     }
// });

// $(window).load(function() {
//     $(".sticky").sticky();
// });

// $('#booking-filters-scroll').css('height', $(window).height());

// $('#my-affix').affix({
//     offset: {
//         top: 0,
//         bottom: function() {
//             return (this.bottom = $('.footer').outerHeight(true))
//         }
//     }
// })

// $(document).ready(
//     function() {

//     });

// $(document).ready(
//     function() {
//         $('html').perfectScrollbar();
//     }
// );


// var listItemSelected = false;

// $('.stats-list-select > li > .booking-item-rating-stars > li').hover(function() {

//     var list = $(this).parent(),
//         listItems = list.children(),
//         itemIndex = $(this).index(),
//         listItemSelected = false;

//     for (var i = 0; i < listItems.length; i++) {
//         if (i <= itemIndex) {
//             $(listItems[i]).addClass('selected');
//         } else {
//             break;
//         }
//     };
//     $(this).click(function() {
//         listItemSelected = true;
//         console.log('baz');
//     });

//     $(this).data('listItems', listItems);
//     $(this).data('listItemSelected', listItemSelected);
// }, function() {
//     console.log($(this).data('listItemSelected'));

//     if (!$(this).data('listItemSelected')) {
//         $(this).data('listItems').removeClass('selected');
//     }
// });


$('.stats-list-select > li > .booking-item-rating-stars > li').each(function() {
    var list = $(this).parent(),
        listItems = list.children(),
        itemIndex = $(this).index();

    $(this).hover(function() {
        for (var i = 0; i < listItems.length; i++) {
            if (i <= itemIndex) {
                $(listItems[i]).addClass('hovered');
            } else {
                break;
            }
        };
        $(this).click(function() {
            for (var i = 0; i < listItems.length; i++) {
                if (i <= itemIndex) {
                    $(listItems[i]).addClass('selected');
                } else {
                    $(listItems[i]).removeClass('selected');
                }
            };
        });
    }, function() {
        listItems.removeClass('hovered');
    });
});



$('.booking-item-container').children('.booking-item').click(function(event) {
    // event.preventDefault();
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).parent().removeClass('active');
    } else {
        $(this).addClass('active');
        $(this).parent().addClass('active');
        $(this).delay(1500).queue(function() {
            $(this).addClass('viewed')
        });
    }
});
$(function() {
    $('#gmap').gmap3({
        marker: {
            address: "Haltern am See, Weseler Str. 151" // ENTER YOUR ADDRESS HERE!
        },
        map: {
            options: {
                zoom: 14
            }
        }
    });
});