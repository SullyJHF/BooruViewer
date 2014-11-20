var imageWidth = parseInt(localStorage.getItem("width"));
if(isNaN(imageWidth)) imageWidth = 300;
var w = $('body').innerWidth();
if(jQuery.browser.mobile){
	var startW = w;
} else {
	var startW = w-17;
}
var imageCount = parseInt((startW)/imageWidth);
var widthOfImages = (imageCount*imageWidth);
var gutterSize = (startW-widthOfImages)/(imageCount+1);
$('#content').css('margin-left', gutterSize);
$('body').css('margin-top', gutterSize);
$('#formGutter').val(String(gutterSize));
// console.log(startW);
// console.log(parseInt(gutterSize));
// console.log(String(gutterSize));

var newURL = window.location.search;
if(newURL != ""){
	newURL = newURL.substring(1);
	var params = newURL.split("&");
	for(i = 0; i<params.length;i++){
		// console.log(params[i]);
	}
}

if(localStorage.getItem("sites") == null) localStorage.setItem("sites", "kona");
var localSites = localStorage.getItem("sites").split(",");
if(localStorage.getItem("sites") == null) localSites = "kona";
// console.log(localSites);

var localTags = localStorage.getItem("tags");
if(localTags == null || localTags == ""){
	localTags = " ";
}
if(localTags != " "){
	document.title = localTags;
}

if(localStorage.getItem("sfw") == null) {
	var sfw = [];
	sfw.push('s');
	localStorage.setItem("sfw", 's');
} else {
	var sfw = localStorage.getItem("sfw").split(",");
}
// console.log(sfw);
if(sfw[0] != 'x' && sfw[0] != 'q' && sfw[0] != 's') sfw[0] = 's';
if(sfw[0] != "") document.title = "- "+document.title;
for(i = 0; i < sfw.length; i++){
	document.title = sfw[i].toUpperCase() +" "+ document.title;
}

var localShuffle = localStorage.getItem("shuffle");
if(localStorage.getItem("shuffle") == null) localShuffle = 0;

var localFixed = localStorage.getItem("fixedWidth");
if(localStorage.getItem("fixedWidth") == null) localFixed = 1;

var container = document.querySelector('#content');
var msnry = new Masonry(container, {
		gutter: gutterSize,
		itemSelector : '.grid-item',
		columnWidth : imageWidth,
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
		gutter: gutterSize,
		itemSelector : '.grid-item',
		columnWidth : imageWidth,
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
				loaded: 1,
				gutter: gutterSize,
				sites: localSites,
				width: imageWidth,
				shuffle: localShuffle,
				fixed: localFixed},
		type: 'GET',
		success: function(output) {
			// console.log(output);
			if(output == " "){
				$("#notFound").fadeIn(300).delay(5000).fadeOut(300);
				localTags = " ";
				loadMore();
			} else {
				if(output == ""){
					nullCount++;
					if(nullCount > 10 && showed != 1){
						showed = 1;
						$("#noContent").fadeIn(300).delay(5000).fadeOut(300);
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
				tags: localTags,
				gutter: gutterSize,
				sites: localSites,
				width: imageWidth,
				shuffle: localShuffle,
				fixed: localFixed},
		type: 'GET',
		success: function(output) {
			// console.log(output);
			if(output == " "){
				$("#notFound").fadeIn(300).delay(5000).fadeOut(300);
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
							$("#noContent").fadeIn(300).delay(5000).fadeOut(300);
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

var optionsOpen = false;
var helpOpen = false;

window.onkeyup = function(e) {
	var key = e.keyCode ? e.keyCode : e.which;
	var helpText = "Enter tags to search for, seperated with spaces:\nYou can use advanced tags like \"width:1024\" and \"order:wide\"";
	
	if($(e.target).is('input')) return;

	/*if(key == 83){
		if(localTags == " "){
			var tags = prompt(helpText, "hatsune_miku");
		} else {
			var tags = prompt(helpText, localTags);
		}
		if(tags == "" || tags == null){
			tags = " ";
			// localStorage.setItem("tags", tags);
		} else {
			// localStorage.setItem("tags", tags);
			window.location = window.location;
		}
	} else */if(key == 76){ // l
		loadMore();
	} /*else if(key == 49 || key == 85){ // 1 or u
		// localStorage.setItem("sfw", 1); //sfw
		window.location = window.location;
	} else if(key == 50 || key == 82){ // 2 or r
		// localStorage.setItem("sfw", 2); //explicit + questionable
		window.location = window.location;
	} else if(key == 51 || key == 88){ // 3 or x
		// localStorage.setItem("sfw", 3); //explicit only
		window.location = window.location;
	} else if(key == 52 || key == 69){ // 4 or e
		// localStorage.setItem("sfw", 4); //everything
		window.location = window.location;
	} else if(key == 48 || key == 68){ // 0 or d
		// localStorage.setItem("sfw", 4); //default (all)
		// localStorage.setItem("tags", " ");
		window.location = window.location;
	}*/ else if(key == 72 && !helpOpen){ // h
		helpOpen = true;
		optionsOpen = false;
		$('#options').fadeOut(200);
		$('#help').fadeIn(200);
		$('#dark').fadeIn(200);
	} else if(key == 72 && helpOpen){ // h
		helpOpen = false;
		$('#help').fadeOut(200);
		$('#dark').fadeOut(200);
	} else if(key == 27 && !optionsOpen && !helpOpen){ // escape
		$.post("end.php", function(){
			refresh();
		});
		//setTimeout(function(){refresh();}, 2000);
	} else if(key == 27 && (optionsOpen || helpOpen)){ // escape
		optionsOpen = false;
		helpOpen = false;
		$('#help').fadeOut(200);
		$('#options').fadeOut(200);
		$('#dark').fadeOut(200);
	} else if(key == 79 && !optionsOpen){ // o
		optionsOpen = true;
		helpOpen = false;
		$('#help').fadeOut(200);
		$('#options').fadeIn(200);
		$('#dark').fadeIn(200);
	} else if(key == 79 && optionsOpen){ // o
		optionsOpen = false;
		$('#options').fadeOut(200);
		$('#dark').fadeOut(200);
	}
}

function refresh(){
	window.location.href = window.location.href;
}

function checkScroll(){
	return $(document).height() > $(window).height();
}

$('#dark').click(function(){
	optionsOpen = false;
	helpOpen = false;
	$('#help').fadeOut(200);
	$('#options').fadeOut(200);
	$('#dark').fadeOut(200);
});

$('.close').click(function(){
	optionsOpen = false;
	helpOpen = false;
	$('#help').fadeOut(200);
	$('#options').fadeOut(200);
	$('#dark').fadeOut(200);
});

$('#loadMore').click(function(){
	loadMore();
});

$('#logOut').click(function(){
	$.post("end.php", function(){
		refresh();
	});
});

$('#formSubmit').click(function(){
	var tags = $('#inputTags').val().trim();
	localStorage.setItem("tags", tags);
	var sfw = [];
	if($('#x').prop('checked')) sfw.push('x');
	if($('#q').prop('checked')) sfw.push('q');
	if($('#s').prop('checked')) sfw.push('s');
	if(sfw[0] == null || sfw[0] == 'undefined') sfw.push('s');
	localStorage.setItem("sfw", sfw);
	var sites = [];
	if($('#kona').prop('checked')) sites.push('kona');
	if($('#yan').prop('checked')) sites.push('yan');
	if($('#dan').prop('checked')) sites.push('dan');
	if(sites[0] == null || sites[0] == 'undefined') sites.push('kona');
	localStorage.setItem("sites", sites);
	localStorage.setItem("width", $('#inputWidth').val());
	var checked = ($('#shuffle').prop('checked') ? 1 : 0);
	localStorage.setItem("shuffle", checked);
	var checked = ($('#fixedWidth').prop('checked') ? 1 : 0);
	localStorage.setItem("fixedWidth", checked);
	window.location = window.location;
	// console.log(sfw);
	// console.log(tags)
});

// console.log($.inArray('s', sfw));
if($.inArray('x', sfw) >= 0){
	$('#x').prop('checked', true);
}
if($.inArray('q', sfw) >= 0){
	$('#q').prop('checked', true);
}
if($.inArray('s', sfw) >= 0){
	$('#s').prop('checked', true);
}

if($.inArray('kona', localSites) >= 0){
	$('#kona').prop('checked', true);
}
if($.inArray('yan', localSites) >= 0){
	$('#yan').prop('checked', true);
}
if($.inArray('dan', localSites) >= 0){
	$('#dan').prop('checked', true);
}

$('#inputWidth').val(imageWidth);

if(localTags == " "){
	$('#inputTags').val("");
} else {
	$('#inputTags').val(localTags);
}

if(localShuffle == 1){
	$('#shuffle').prop('checked', true);
} else {
	$('#shuffle').prop('checked', false);
}

if(localFixed == 1){
	$('#fixedWidth').prop('checked', true);
} else {
	$('#fixedWidth').prop('checked', false);
}

$(document).ready(function(){
	if(localStorage.getItem("returnUser") != '1'){
		helpOpen = true;
		$('#help').fadeIn(200);
		$('#dark').fadeIn(200);
		localStorage.setItem('returnUser', '1');
	}
});

$(window).scroll(function(){
	moveMasonry();
});

$(window).scroll(bindScroll);