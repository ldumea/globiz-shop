$(document).ready(function() {
	if($('.fancyframe').length){
		$('.fancyframe').fancybox({
			'type':'iframe',
			'width': 600, //or whatever you want
			'height': 300
		});
	}
	
	var bigimage = $("#big");
	var thumbs = $("#thumbs");
	//var totalslides = 10;
	var syncedSecondary = true;

	bigimage.owlCarousel({
		items: 1,
		slideSpeed: 2000,
		nav: true,
		autoplay: false,
		loop: true,
		dots: false,
		responsiveRefreshRate: 200,
		navText: [
		  '<i class="fas fa-chevron-left fa-2x"></i>',
		  '<i class="fas fa-chevron-right fa-2x"></i>'
		]
	}).on("changed.owl.carousel", syncPosition)
	.on("initialized.owl.carousel", intiCarusel);

	thumbs.on("initialized.owl.carousel", function() {
		thumbs.find(".owl-item").eq(0).addClass("current");
	}).owlCarousel({
		items: 4,
		dots: false,
		nav: true,
		navText: [
		  '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
		  '<i class="fa fa-chevron-right" aria-hidden="true"></i>'
		],
		smartSpeed: 200,
		slideSpeed: 500,
		slideBy: 4,
		responsiveRefreshRate: 100
	}).on("changed.owl.carousel", syncPosition2);

	function syncPosition(el) {
		//if loop is set to false, then you have to uncomment the next line
		//var current = el.item.index;
	
		//to disable loop, comment this block
		var count = el.item.count - 1;
		var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
	
		if (current < 0) {
			current = count;
		}
		if (current > count) {
			current = 0;
		}
		//to this
		thumbs.find(".owl-item").removeClass("current").eq(current).addClass("current");
		var onscreen = thumbs.find(".owl-item.active").length - 1;
		var start = thumbs
		.find(".owl-item.active")
		.first()
		.index();
		var end = thumbs
		.find(".owl-item.active")
		.last()
		.index();
  
		if (current > end) {
			thumbs.data("owl.carousel").to(current, 100, true);
		}
		if (current < start) {
			thumbs.data("owl.carousel").to(current - onscreen, 100, true);
		}
	}

	function syncPosition2(el) {
		if (syncedSecondary) {
			var number = el.item.index;
			bigimage.data("owl.carousel").to(number, 100, true);
		}
	}
	function intiCarusel(){
		alert('aaa');
	}
	$(".img").zoom();
	thumbs.on("click", ".owl-item", function(e) {
		e.preventDefault();
		var number = $(this).index();
		bigimage.data("owl.carousel").to(number, 300, true);
	});
	
	//if($(".product_slider").length){
	//	$('.product_slider').lightSlider({
	//		gallery:true,
	//		item:1,
	//		loop:true,
	//		thumbItem:4,
	//		slideEndAnimation: false,
	//		prevHtml: '<i class="fas fa-chevron-left"></i>',
	//		nextHtml: '<i class="fas fa-chevron-right"></i>',
	//		onSliderLoad: function (el) {
	//			el.find('li').zoom();
	//		}
	//	});
	//}
});