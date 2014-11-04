var newURL = window.location.search;
	if(newURL != ""){
		newURL = newURL.substring(1);
		var params = newURL.split("&");
		for(i = 0; i<params.length;i++){
			console.log(params[i]);
		}
	}
	
	var localTags = localStorage.getItem("tags");
	if(localTags == null){
		localTags = " ";
	}
	if(localTags != " "){
		document.title = localTags;
	}
	
	var localSfw = localStorage.getItem("sfw");
	if(localSfw == null){
		var sfw = 1;
	} else {
		var sfw = localSfw;
	}
	if(sfw == 1){
		document.title = "U - "+document.title;
	} else if(sfw == 2){
		document.title = "R - "+document.title;
	} else if(sfw == 3){
		document.title = "X - "+document.title;
	}
	
	var container = document.querySelector('#content');
	var msnry = new Masonry(container, {
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
		
	var count = 1;
	var nullCount = 0;
	var showed = 0;
		function loadMore(i){
			i = (typeof i === "undefined") ? 5 : i;
			$.ajax({ url: 'loadTaggedImages.php',
				data: {pageNo: count,
						sfw: sfw,
						tags: localTags,
						loaded: 1},
				type: 'POST',
				success: function(output) {
					if(output == " "){
						$("#notFound").show(300).delay(5000).hide(300);
						localTags = " ";
						loadMore();
					} else {
						if(output == ""){
							nullCount++;
							if(nullCount > 10 && showed != 1){
								showed = 1;
								$("#noContent").show(300).delay(5000).hide(300);
								//console.log("No data recieved for more than 10 reqeuests");
								return;
							}
							//console.log("Loaded page: "+count+" But nothing was there.");
							if(i == 0){
								return;
							}
							//console.log(i);
							var b = i-1;
							
							if(output != ""){
								//$(window).bind('scroll', bindScroll);
								return;
							}
							count++;
							loadMore(b);
							return;
						} else {
							nullCount = 0;
							var divs = output.split("`");
							$('#content').append(divs);
							moveMasonry();
							//console.log("Loaded page: "+count);
						}
					}
				}
			});
			count++;
			//console.log("count "+count);
			$(window).bind('scroll', bindScroll);
			moveMasonry();
		}
	
		function bindScroll(){
			if($(window).scrollTop() + $(window).height() > $(document).height()-100) {
				$(window).unbind('scroll');
				loadMore();
			}
		}
		
		function start(i){
		i = (typeof i === "undefined") ? 20 : i;
			$.ajax({ url: 'loadTaggedImages.php',
				data: {pageNo: count,
						sfw: sfw,
						tags: localTags},
				type: 'POST',
				success: function(output) {
					if(output == " "){
						$("#notFound").show(300).delay(5000).hide(300);
						localTags = " ";
						start();
					} else {
						//console.log("checking page: "+count);
						if(checkScroll()){
							//console.log("Loaded page: "+count+" and stopping because there is a scrollbar.");
							var divs = output.split("`");
							$('#content').append(divs);
							moveMasonry();
							count++;
							return;
						} else {//if no scroll bar
							if(output == ""){//checking if content is there
								nullCount++;
								if(nullCount > 10 && showed != 1){
									showed = 1;
									$("#noContent").show(300).delay(5000).hide(300);
									//console.log("No data recieved for more than 10 reqeuests");
									return;
								}
								//console.log("Didn't load page: "+count+" because no content.");
								if(i == 0){
									return;
								}
								count++;
								//console.log(i);
								var b = i-1;
								if(output != ""){
									//$(window).bind('scroll', bindScroll);
									return;
								}
								start(b);
								return;
							}//gets past here if there is content
							nullCount = 0;
							//console.log("Loaded page: "+count);
							var divs = output.split("`");
							$('#content').append(divs);
							moveMasonry();
							//console.log(i)
							count++;
							var b = i-1;
							start(b);
						}
					}
				}
			});
			moveMasonry();
			//$(window).bind('scroll', bindScroll);
			//console.log("count "+count);
		}
		start();
		moveMasonry();
		
	
	
	window.onkeyup = function(e) {
		var key = e.keyCode ? e.keyCode : e.which;
		var helpText = "Enter tags to search for, seperated with spaces:\nYou can use advanced tags like \"width:1024\" and \"order:wide\"";
		
		if(key == 83){
			if(localTags == " "){
				var tags = prompt(helpText, "hatsune_miku");
			} else {
				var tags = prompt(helpText, localTags);
			}
			if(tags == "" || tags == null){
				tags = " ";
				localStorage.setItem("tags", tags);
			} else {
				localStorage.setItem("tags", tags);
				window.location = window.location;
			}
		} else if(key == 76){
			loadMore();
		} else if(key == 49 || key == 85){
			localStorage.setItem("sfw", 1); //sfw
			window.location = window.location;
		} else if(key == 50 || key == 82){
			localStorage.setItem("sfw", 2); //explicit + questionable
			window.location = window.location;
		} else if(key == 51 || key == 88){
			localStorage.setItem("sfw", 3); //explicit only
			window.location = window.location;
		} else if(key == 52 || key == 69){
			localStorage.setItem("sfw", 4); //everything
			window.location = window.location;
		} else if(key == 68 || key == 48 || key == 52){ 
			localStorage.setItem("sfw", 4); //default (all)
			localStorage.setItem("tags", " ");
			window.location = window.location;
		} else if(key == 72){ 
			alert("Help:\n\n"+
					"Scroll to bottom to load more\n\n"+
					"1/U - Show safe for work posts\n"+
					"2/R - Show explicit and questionable posts\n"+
					"3/X - Show only explicit posts\n"+
					"4/E - Show all posts with given tags\n"+
					"0/D - Default, resets all search and rating options\n"+
					"S - Search for tags\n"+
					"L - Load more if stuck\n"+
					"Esc - Logout");
		} else if(key == 27){
			$.post("end.php", function(){
				refresh();
			});
			//setTimeout(function(){refresh();}, 2000);
		}
	}
	
	function refresh(){
		window.location.href = window.location.href;
	}
	
	function checkScroll(){
		return $(document).height() > $(window).height();
	}
	$(window).scroll(bindScroll);