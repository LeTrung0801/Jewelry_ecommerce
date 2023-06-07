/**
 * WEBSITE: https://themefisher.com
 * TWITTER: https://twitter.com/themefisher
 * FACEBOOK: https://www.facebook.com/themefisher
 * GITHUB: https://github.com/themefisher/
 */

// const { find } = require("lodash");

// Preloader js
$(window).on('load', function () {
	'use strict';
	$('.preloader').fadeOut(100);
});

(function ($) {
	'use strict';

	$(window).on('scroll', function () {
		var scrolling = $(this).scrollTop();
		if (scrolling > 10) {
			$('.navigation').addClass('nav-bg');
		} else {
			$('.navigation').removeClass('nav-bg');
		}
	});

	// tab
	$('.tab-content').find('.tab-pane').each(function (idx, item) {
		var navTabs = $(this).closest('.code-tabs').find('.nav-tabs'),
			title = $(this).attr('title');
		navTabs.append('<li class="nav-item"><a class="nav-link" href="#">' + title + '</a></li>');
	});

	$('.code-tabs ul.nav-tabs').each(function () {
		$(this).find('li:first').addClass('active');
	});

	$('.code-tabs .tab-content').each(function () {
		$(this).find('div:first').addClass('active');
	});

	$('.nav-tabs a').click(function (e) {
		e.preventDefault();
		var tab = $(this).parent(),
			tabIndex = tab.index(),
			tabPanel = $(this).closest('.code-tabs'),
			tabPane = tabPanel.find('.tab-pane').eq(tabIndex);
		tabPanel.find('.active').removeClass('active');
		tab.addClass('active');
		tabPane.addClass('active');
	});

	// Accordions
	$('.collapse').on('shown.bs.collapse', function () {
		$(this).parent().find('.ti-plus').removeClass('ti-plus').addClass('ti-minus');
	}).on('hidden.bs.collapse', function () {
		$(this).parent().find('.ti-minus').removeClass('ti-minus').addClass('ti-plus');
	});

	//post slider
	$('.post-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		dots: false,
		arrows: true,
		prevArrow: '<button type=\'button\' class=\'prevArrow\'><i class=\'ti-angle-left\'></i></button>',
		nextArrow: '<button type=\'button\' class=\'nextArrow\'><i class=\'ti-angle-right\'></i></button>'
	});

	// copy to clipboard
	$('.copy').click(function () {
		$(this).siblings('.inputlink').select();
		document.execCommand('copy');
	});


	// instafeed
	if (($('#instafeed').length) !== 0) {
		var accessToken = $('#instafeed').attr('data-accessToken');
		var userFeed = new Instafeed({
			get: 'user',
			resolution: 'low_resolution',
			accessToken: accessToken,
			template: '<div class="instagram-post"><a href="{{link}}" target="_blank"><img src="{{image}}"></a></div>'
		});
		userFeed.run();
	}

	setTimeout(function () {
		$('.instagram-slider').slick({
			dots: false,
			speed: 300,
			autoplay: true,
			arrows: false,
			slidesToShow: 8,
			slidesToScroll: 1,
			responsive: [{
					breakpoint: 1024,
					settings: {
						slidesToShow: 6
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 4
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 2
					}
				}
			]
		});
	}, 1500);


	// popup video
	var $videoSrc;
	$('.video-btn').click(function () {
		$videoSrc = $(this).data('src');
	});
	console.log($videoSrc);
	$('#myModal').on('shown.bs.modal', function (e) {
		$('#video').attr('src', $videoSrc + '?autoplay=1&amp;modestbranding=1&amp;showinfo=0');
	});
	$('#myModal').on('hide.bs.modal', function (e) {
		$('#video').attr('src', $videoSrc);
	});

	$("#scrollUp").click(function(){
		console.log('abc');
		$("html, body").animate({
		scrollTop: 0
	}, 500);
	});

	var mybutton = document.getElementById("scrollUp");
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
		mybutton.style.display = "block";
	} else {
		mybutton.style.display = "none";
	}
	}

	$('.multiple-category').slick({
		infinite: true,
		slidesToShow: 6,
		slidesToScroll: 1,
		responsive: [
			{
			  breakpoint: 1024,
			  settings: {
				slidesToShow: 5,
				slidesToScroll: 1,
			  }
			},
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 4,
				slidesToScroll: 1,
			  }
			},
			{
				breakpoint: 768,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 1,
				}
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
		]
	  });

	$('.multiple-items').slick({
		infinite: true,
		slidesToShow: 4,
		slidesToScroll: 1,
		autoplay: true,
		responsive: [
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
			  }
			},
			{
				breakpoint: 768,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 1,
				}
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
		]
	  });

	$('.multiple-product').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: true,
		responsive: [
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
			  }
			},
			{
				breakpoint: 768,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 1,
				}
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
		]
	});

	$('.multiple-relative').slick({
		infinite: true,
		slidesToShow: 4,
		slidesToScroll: 1,
		autoplay: true,
		responsive: [
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
			  }
			},
			{
				breakpoint: 768,
				settings: {
				  slidesToShow: 2,
				  slidesToScroll: 1,
				}
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
		]
	});

	function showMessage(title, message){
        $.confirm({
            boxWidth: '30%',
            useBootstrap: false,
            title: title  ,
            content:  message,
            buttons: {
                OK: {
                    text: 'OK',
                    btnClass: "btn btn-pink btn-lg btn-block",
                },
                // cancel: {
                //     text : '戻る',
                // },
            }
        });
    }

    let msg = $("input[name=message]");
    if (msg.length != 0 && msg.val() != "") {
        showMessage('',msg.val());
    }

    let errorMsg = $("input[name=error-message]");
    if (errorMsg.length != 0 && errorMsg.val() != "") {
        showMessage('',errorMsg.val());
    }

    $('#cart-abc').on('click','.is-form', function() {
        var input = $(this).siblings('.input-qty');
        // min = Number($this.attr('min')),
        //     max = Number($this.attr('max')),
        //     qty = $this.val(),
        //     route = $this.attr('url')
        console.log(input.val());
        console.log(1);
        if(route){
            let acction
            if ($(this).hasClass('minus')) {
                acction = 0;
              } else if ($(this).hasClass('plus')) {
                acction = 1;
              }
            $.ajax({
                url: route,
                method: "post",
                data: {
                    quantity: qty,
                    act: acction,
                    _token:$("input[name=_token]").val(),
                },
                dataType : 'json',
                success: function (result) {
                    $('#sum-'+result.id).val(result.sum);
                    qty = result.qty
                    $this.val(qty);
                    let a = result.total;
                    // $('.add-total').val(a);
                    t = Number(t) + a;
                    $('.cart-total').val(t);
                    console.log(a);
                    console.log(t);

                },
            });
        }else{
            if ($(this).hasClass('minus')) {
                if (qty > min) qty--
              } else if ($(this).hasClass('plus')) {
                if (qty < max) qty++
              }
                $this.val(qty);
        }
    });


    //----------------------------------------------------

})(jQuery);

