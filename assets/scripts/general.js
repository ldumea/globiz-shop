var product_scroller = new Array();
$(document).ready(function() {
	$("#search-mobile-btn").click(function(){
		$(".search-mobile").slideToggle(100, function() {
			// Animation complete.
		});
	});
	if($("nav .dropdown").length){
		$("nav .dropdown").hover(
			function () {
				$('>.dropdown-menu', this).stop(true, true).fadeIn("fast");
			},
			function () {
				$('>.dropdown-menu', this).stop(true, true).fadeOut("fast");
			}
		);
	}
	
	$('.cos-top').hover(function() {
		$(".shopping-cart-top").stop(true, true).fadeIn("fast");
	}, function() {
		$(".shopping-cart-top").stop(true, true).fadeOut("fast");
	});
	
	$('.shopping-cart-items').slimscroll({
        size: '5px',
		height: '220px'
    });
	if($(".home_slider").length){
		$('.home_slider').lightSlider({
			item: 1,
			loop:true,
			controls: true,
			pager: false,
			mode: 'fade',
			autoWidth: true,
			auto:true,
			pauseOnHover: true,
			pause: 4000
		});
	}
	
	if($(".productSlider").length){
		$('.productSlider').each(function(){
			var id = $(this).data('id');
			product_scroller[id] = $(this).lightSlider({
				item: 5,
				loop:true,
				controls: false,
				prevHtml: '',
				nextHtml: '',
				pager: false,
				adaptiveHeight: true
			});
		});
	}
	if($(".product-content").length){
		$('.product-content').each(function(){
			if($(this).find('.product-image').data('image-second')!==''){
				img1 = new Image();
				var src_second = $(this).find('.product-image').data('image-second');
				var src_first = $(this).find('.product-image').attr("src");
				img1.src = src_second;
				
				$(this).hover(
					function () {
						console.log(src_second);
						$(this).find('.product-image').attr('src', src_second);
					},
					function () {
						$(this).find('.product-image').attr('src', src_first);
					}
				);
			}
		});
	}
	//if(jQuery("img.lazyload").length){
	//	$('img.lazyload').each(function(){
	//		var src_first = $(this).data("src");
	//		$(this).attr('src', src_first);
	//	});
	//}
	if($("img").length){
		$('img').each(function(){
			if($(this).data('image-second')!==''){
				img1 = new Image();
				var src_second = $(this).data('image-second');
				var src_first = $(this).attr("src");
				img1.src = src_second;
				$(this).hover(
					function () {
						$(this).attr('src', src_second);
					},
					function () {
						$(this).attr('src', src_first);
					}
				);
			}
		});
	}
	$('.product_scroller_btn_left').click(function(){
		id = $(this).data('scroller');
		product_scroller[id].pause();
		product_scroller[id].goToPrevSlide();
	});

	$('.product_scroller_btn_right').click(function(){
		id = $(this).data('scroller');
		product_scroller[id].pause();
		product_scroller[id].goToNextSlide();
	});
	if($(".cantitate").length){
		if($(".cos").length){
			$("input[class='cantitate']").TouchSpin({
				max: 100000,
				decimals: 0,
				boostat: 5,
				verticalbuttons: true,
				verticalupclass: 'glyphicon glyphicon-plus',
				verticaldownclass: 'glyphicon glyphicon-minus'
			}).on('touchspin.on.startspin', function () {
				id = $(this).attr('id').replace("qty_", "");
				
			});
		} else {
			$("input[class='cantitate']").TouchSpin({
				max: 100000,
				decimals: 0,
				boostat: 5,
				verticalbuttons: true,
				verticalupclass: 'glyphicon glyphicon-plus',
				verticaldownclass: 'glyphicon glyphicon-minus'
			});
		}
	}
	
	
	$('.shop-categories .arrow').click(
		function () {
	
			$(this).parent().parent().find('ul.children').removeClass('active');
			$(this).parent().parent().find('.fa-angle-up').addClass('fa-angle-down').removeClass('fa-angle-up');
			if ($(this).parent().find('ul.children').is(":visible")) {
				//$(this).find('.fa-angle-up').addClass('fa-angle-down').removeClass('fa-angle-up');
				//$(this).parent().find('ul.children').removeClass('active');
			}
			else {
				$(this).find('.fa-angle-down').addClass('fa-angle-up').removeClass('fa-angle-down');
				$(this).parent().find('ul.children').addClass('active');
			}
			$(this).parent().parent().find('ul.children').each(function () {
				if (!$(this).hasClass('active')) {
					$(this).slideFadeOut();
				}
				else {
					$(this).slideFadeIn();
				}
			});
		}
	);    
	 
	
	 $('.shop-categories .arrow2').click(
		function () {
	
			$(this).parent().parent().find('ul.children2').removeClass('active');
			$(this).parent().parent().find('.fa-minus').addClass('fa-plus').removeClass('fa-minus');
			if ($(this).parent().find('ul.children2').is(":visible")) {
				//$(this).find('.fa-angle-up').addClass('fa-angle-down').removeClass('fa-angle-up');
				//$(this).parent().find('ul.children').removeClass('active');
			}
			else {
				$(this).find('.fa-plus').addClass('fa-minus').removeClass('fa-plus');
				$(this).parent().find('ul.children2').addClass('active');
			}
			$(this).parent().parent().find('ul.children2').each(function () {
				if (!$(this).hasClass('active')) {
					$(this).slideFadeOut();
				}
				else {
					$(this).slideFadeIn();
				}
			});
		}
	);
	 $(".sf-arrow").click(function() {
		if($(this).find('i').hasClass('fa-angle-right')){
			$(this).find('i').removeClass('fa-angle-right');
			$(this).find('i').addClass('fa-angle-down');
			$(this).parent().find('ul').show();
		} else {
			$(this).find('i').removeClass('fa-angle-down');
			$(this).find('i').addClass('fa-angle-right');
			$(this).parent().find('ul').hide();
		}
	});
	
	if($("#to-top").length){
		$(window).scroll(function () {
			if ($(this).scrollTop() > 1) {
				$("#to-top").css({bottom: '20px'});
			} else {
				$("#to-top").css({bottom: '-100px'});
			}
		});
		$("#to-top").click(function () {
			$('html, body').animate({scrollTop: '0px'}, 800);
			return false;
		});
	}
	//if(jQuery("img.lazyload").length){
	//	$("img.lazyload").lazyload();
	//}
});

function add_cart(elem, showWindow){
	//showWindow = typeof  showWindow !== 'undefined' ? showWindow : true;
	if(typeof(showWindow)==='undefined') showWindow = true;
	//console.log($(this).parent().html());
	$.post(site_url+'cos/adauga', $(elem).closest(".cart_form").find('input').serializeArray(), function(data){
		if (data.res == 'error') {
			var alertTxt = '';
			alertTxt+='<div>';
			alertTxt+='<i class="fas fa-exclamation-triangle" style="color: #f00"></i> ';
			alertTxt+=data.msg;
			alertTxt+='</div>';
			$(".dialog .modal-content .modal-body").html(alertTxt);
			$(".dialog").modal();
		}
		else
		{
			
			if($(elem).closest(".product-item").find('.price').length)
			{	
				var priceObj = $(elem).closest(".product-item").find('.price');
				var priceTxt = priceObj.html().replace(/\s/g,'').toString();
				priceObj.html('<div id="msg_product">'+produse_adauga_cos+'</div>');

				setTimeout(function() {
					$( "#msg_product" ).fadeTo( 1000 , 0, function() {
						$("#msg_product").hide();
						//console.log(priceTxt);
						priceObj.html(priceTxt);

						var preturi_noi = data.preturi_noi;
						//console.log(preturi_noi);
						$.each(preturi_noi, function (index, value) {
							value = value+"<del></del>";
							$(".product_id_"+index).find('.price').html(value);
						});

					});
				}, 3000); //3000 - 3 secunde
			}
			
			if (showWindow) {				
				if(data.msg !=='')
				{
					$("#msg").html(data.msg);
					$.fancybox({
						'content'	: $("#msg"),
						'fitToView'	: true,
						'autoSize'	: true,
						'width'		: 920,
						'autoWidth' : true,
						'autoHeight': true,
						'maxHeight'	: 700,
						'afterShow': function(){
							$('.quantity .btn.minus').click(function() {
								var id = this.id.split("_").pop();
								var val = parseInt($('#quantity_'+id).val());
								var step = parseInt($('#quantity_'+id).attr('step'));
								if (val <= step) return false;
								$('#quantity_'+id).val(parseInt(val-step));
							});
							$('.quantity .btn.plus').click(function() {
								var id = this.id.split("_").pop();
								var step = parseInt($('#quantity_'+id).attr('step'));
								var val = parseInt($('#quantity_'+id).val());        
								$('#quantity_'+id).val(parseInt(val+step));
							});
						}
					});
					// $("#msg").fancybox({
					// 	
	   	// 				autoSize : false
	   	// 			});
				}
			}
			$.post(site_url+'cos/cos_top', function(data){
				$('#cos_top_list').html(data.list);
				$('#cos_top_sumar').html(data.sumar);
				$('#no_articole').html(data.no_articole);
				$('.shopping-cart-items').slimscroll({
					size: '5px',
					height: '220px'
				});
			}, 'json');
		}
	}, 'json');
}
function add_precomanda(elem, showWindow){
	
	$.post(site_url+'cos/precomanda', $(elem).closest(".cart_form").find('input').serializeArray(), function(data){
		
		var alertTxt = '';
		alertTxt+='<p style="color: #e47911; font-size: 13px">';
		alertTxt+= data.msg;
		alertTxt+='</p>';
		$(".dialog .modal-header").remove();
		$(".dialog .modal-body").html(alertTxt);
		$(".dialog .modal-footer").html('<button type="button" class="btn btn-globiz" data-dismiss="modal">'+js_inchide+'</button>');
		$(".dialog").modal();
	}, 'json');
}
function stergeProdus(id){
	$.post(site_url+'cos/sterge_produs', {'id':id}, function(data){
		//location.reload();
		$(".cos_continut").html(data.msg);
		$("input[class='cantitate']").TouchSpin({
			max: 100000,
			decimals: 0,
			boostat: 5,
			maxboostedstep: 10,
			verticalbuttons: true,
			verticalupclass: 'glyphicon glyphicon-plus',
			verticaldownclass: 'glyphicon glyphicon-minus'
		}).on('touchspin.on.startspin', function () {
			id = $(this).attr('id').replace("qty_", "");
			actualizeaza_cos(id);
		});
		$.post(site_url+'cos/cos_top', function(data){
			$('#cos_top_list').html(data.list);
			$('#cos_top_sumar').html(data.sumar);
			$('#no_articole').html(data.no_articole);
			$('.shopping-cart-items').slimscroll({
				size: '5px',
				height: '220px'
			});
		}, 'json');
	}, 'json')
}
function actualizeaza_cos(id){
	$.blockUI({
		message: $('.spinner'),
		baseZ: 100000,
		css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: 'transparent', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            color: '#fff' 
        }
	});
	$.post(site_url+'cos/actualizeaza_cos', {'id': id, 'qty': $("#qty_"+id).val()}, function(data){
		if (data.res == 'error') {
			$("#qty_"+id).val(data.qty);
			alert(data.msg);
		} else {
			$(".cos_continut").html(data.msg);
			$.post(site_url+'cos/cos_top', function(data2){
				$('#cos_top_list').html(data2.list);
				$('#cos_top_sumar').html(data2.sumar);
				$('#no_articole').html(data2.no_articole);
				$('.shopping-cart-items').slimscroll({
					size: '5px',
					height: '220px'
				});
			}, 'json');
			$("input[class='cantitate']").TouchSpin({
				max: 100000,
				decimals: 0,
				boostat: 5,
				maxboostedstep: 10,
				verticalbuttons: true,
				verticalupclass: 'glyphicon glyphicon-plus',
				verticaldownclass: 'glyphicon glyphicon-minus'
			}).on('touchspin.on.startspin', function () {
				id = $(this).attr('id').replace("qty_", "");
				actualizeaza_cos(id);
			});
			//if($("#afisare_voucher").length){
			//	$("#afisare_voucher").off("click.fb-start");
			//	$("#afisare_voucher").fancybox({
			//		live: false,
			//		afterClose	:	function() {
			//            window.location.href = $("#afisare_voucher").data('url');
			//		}
			//	});
			//}
			
		}
		$.unblockUI();
	}, 'json');
}
function schimba_limba(lang){
	$.post(site_url+'carguard/schimba_limba', {'lang': lang}, function(){
		location.reload();
	})
}
function continut_cos(){
	$.post(site_url+'cos/continut_cos', function(data){
		//$.post(site_url+'cos/cos_top', function(data2){
		//	$('#cos_top_list').html(data2.list);
		//	$('#cos_top_sumar').html(data2.sumar);
		//}, 'json');
		$(".cos_continut").html(data.cos_continut);
		$('#cos_top_list').html(data.list);
		$('#cos_top_sumar').html(data.sumar);
		$('#no_articole').html(data.no_articole);
		$('.shopping-cart-items').slimscroll({
			size: '5px',
			height: '220px'
		});
		
	}, 'json');
}
function adauga_cupon(){
	$.post(site_url+'cos/adauga_cupon', $("#form-cupon").serializeArray(), function(raspuns){
		if(raspuns.tip == 'eroare'){
			$("#error_cupon").html(raspuns.msg);
		} else {
			continut_cos();
		}
	}, 'json');
}
function schimba_dropshipping(){
	if($("#dropshipping:checked").length>0){
		$("#adresa_livrare_div").hide();
		$("#factura_awb_div").show();
	} else {
		$("#adresa_livrare_div").show();
		$("#factura_awb_div").hide();
	}
}
function finalizare_comanda(){
	$( "body" ).append('<div class="ui-widget-overlay ui-front" style="z-index: 100;"></div>');
	$("#spinner").show();
}