// for click slide to
    $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 50
                        }, 1500);
                    return false;
                }
            }
        });
    });
// for click slide to

// for navbar
    var win = $(window);

    // for dekstop
    if(win.width() > 960){
    var initNavbar = 168;
        win.scroll(function () {
            if (win.scrollTop() >= initNavbar) {
                $( "#navbar" ).addClass( "in-scroll" );
            }
            else if (win.scrollTop() <= initNavbar) {
                $( "#navbar" ).removeClass( "in-scroll" );
            }
        });
    }
    // end for dekstop

    // for mobile
    if(win.width() < 512){
    	$('#navbar #container #logo.bar .valign-midle #burger-icon').click(function(){
    		$('#navbar').toggleClass("active");;
    	});
    }
    // for mobile
// for navbar
