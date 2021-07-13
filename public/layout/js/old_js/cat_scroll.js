$(document).ready(function() {
    var lastId = null;
    var topMenu = $(".filters");

    topMenuHeight = topMenu.outerHeight() + 55,
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function() {
            var item = $($(this).attr("href"));
            if (item.length) {
                return item;
            }
        });

    $(window).scroll(function() {
        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight;

        // Get id of current scroll item
        // console.log(scrollItems);
        var cur = scrollItems.map(function() {
            if ($(this).offset().top < fromTop)
                return this;
        });
        // console.log(cur);
        // Get the id of the current element
        cur = cur[cur.length - 1];

        var id = cur && cur.length ? cur[0].id : "";
        // console.log("id: "+id);
        lastId = id;
        // Set/remove active class
        //    console.log("lastid: "+lastId);
        if (id != "") {
            menuItems
                .removeClass("active");
            $("[href='#" + id + "']").addClass("active");


            var totalWidth = $(".scrollmenu").outerWidth()

            $('.scrollmenu').css('width', totalWidth);

            var myScrollPos = $('.filter_btn.active').offset().left + $('.filter_btn.active').outerWidth(true) / 2 + $('.scrollmenu').scrollLeft() - $('.scrollmenu').width() / 2;
            //console.log(myScrollPos);

            $('.scrollmenu').scrollLeft(myScrollPos);

        }

    });

    $.fn.scrollCenter = function(elem, speed) {

        // this = #timepicker
        // elem = .active

        var active = $(this).find(elem); // find the active element
        //console.log(active);
        //var activeWidth = active.width(); // get active width
        var activeWidth = active.width() / 2; // get active width center

        //alert(activeWidth)

        var pos = active.position().left + activeWidth;
        console.log("pos: " + pos);
        var elpos = $(this).scrollLeft();
        var elW = $(this).width();

        pos = pos + elpos - elW / 2;

        $(this).animate({
            scrollLeft: pos
        }, speed == undefined ? 100 : speed);
        return this;
    };

    // http://podzic.com/wp-content/plugins/podzic/include/js/podzic.js


    menuItems.click(function(e) {
        var href = $(this).attr("href"),
            offsetTop = href === "#" ? 0 : $(href).offset().top - topMenuHeight + 1;
        $('html, body').stop().animate({
            scrollTop: offsetTop
        }, 300);
        e.preventDefault();
    });

    $('.button-group').each(function(i, buttonGroup) {
        var $buttonGroup = $(buttonGroup);
        $buttonGroup.on('click', 'button', function() {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $(this).addClass('is-checked');
        });
    });

    $('.filters-button-group').on('click', 'button', function() {
        var filterValue = $(this).attr('data-filter');
        // use filterFn if matches value
        filterValue = filterFns[filterValue] || filterValue;
        //istop.isotope({ filter: filterValue });
        updateFilterCount();
    });
}) 