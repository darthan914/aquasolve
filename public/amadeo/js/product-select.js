// for product select
	$(".product-select.midle").click(function(){
	    var Name = $(this).data('name');
	    var Desc = $(this).data('desc');
	    var Img  = $(this).data('img');
	    var Website  = $(this).data('website');
	    var TitleImg  = $(this).data('titleimg');
	    var Background  = $(this).data('bg');

		if ( !$(this).hasClass("active") ){
			$(".product-select.midle").removeClass("active");
			$(this).addClass("active");

			$('h1#product-name').addClass("load-data");
			$('p#product-desc').addClass("load-data");
			$('img#product-img').addClass("load-data");
			$('div#website-link.product-website-link').addClass("load-data");

			window.setTimeout(function() {
				$('h1#product-name').removeClass("load-data");
				$('p#product-desc').removeClass("load-data");
				$('img#product-img').removeClass("load-data");

				if(Website != ""){
					$('div#website-link.product-website-link').removeClass("load-data");
				}
			}, 1400);

			window.setTimeout(function() {

				$('p#product-desc').text(Desc);
				$('img#product-img').attr('src', Img);
				$('div#discrip-wrapper.product-background-picture').css('background-image', 'url(' + Background + ')');
				if(TitleImg != ""){
					
					$('h1#product-name').html('<img style="position:relative;height: 70px;" src="'+TitleImg+'"/>');
				}
				else{
					$('h1#product-name').text(Name);
				}
				if(Website != ""){
					$('div#website-link.product-website-link').attr('href', Website);
				}
			}, 1000);
	    }

	});
// for product select
