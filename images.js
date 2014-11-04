var sfw = 1;
	var container = document.querySelector('#content');
	var msnry = new Masonry();
		
	$(window).load(function(){
		moveMasonry();
	});
		
	function moveMasonry(){
		msnry = new Masonry(container, {
			gutter: 5,
			itemSelector : '.grid-item',
			columnWidth : 300,
			isAnimated: true,
			animationOptions: {
				duration: 700,
				easing: 'linear',
				queue: false
			}
		});
	}
		
	var count = 2;
		
	function loadMore(){
		console.log("More loaded");
		$.ajax({ url: 'loadImages.php',
			data: {pageNo: count,
					sfw: sfw},
			type: 'post',
			success: function(output) {
				var divs = output.split("`");
				$('#content').append(divs);
				moveMasonry();
			}
		});
		count++;
		$(window).bind('scroll', bindScroll);
	}

	function bindScroll(){
		if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
			$(window).unbind('scroll');
			loadMore();
		}
	}
	function start(){
		for(count; count<5; count++){
			$.ajax({ url: 'loadImages.php',
				data: {pageNo: count,
						sfw: sfw},
				type: 'post',
				success: function(output) {
					var divs = output.split("`");
					$('#content').append(divs);
					moveMasonry();
				}
			});
			moveMasonry();
		}
	}
	start();
	moveMasonry();
	$(window).scroll(bindScroll);