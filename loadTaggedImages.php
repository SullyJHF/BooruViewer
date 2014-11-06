<?php

	function loadImages($page, $sfw, $tags, $loaded = 0, $gutter, $sites, $width){
		// print_r($_POST);
		// echo "<br>";
		// echo $gutter;

		if($tags === ""){
			$tags = " ";
		}

		if($loaded === 1 || checkTags($tags)){
			$kContent = file_get_contents('http://konachan.com/post.xml?page='.$page.'&tags='.$tags);
			$dContent = file_get_contents('http://danbooru.donmai.us/posts.xml?page='.$page.'&tags='.$tags);
			$kXml = new SimpleXMLElement($kContent);
			$dXml = new SimpleXMLElement($dContent);
			// $kCount = $kXml->count();
			$kCount = count($kXml->children());
			$dCount = count($dXml->children());
			#echo $kXml->count();
			#echo $kXml->post[0]['file_url'];
			#echo $kXml->post[0]['rating'];
			if($loaded === 1 || checkTags($tags)){
				if(in_array("kona", $sites)){
					for($i = 0; $i < $kCount; $i++){
						$rating = $kXml->post[$i]['rating'];
						$prevPath = (string) $kXml->post[$i]['preview_url'];
						$id = (string) $kXml->post[$i]['id'];

						$currentDiv = 	'<div class="grid-item">'.
											'<a href=http://konachan.com/post/show/'.$id.' target="_blank">'.
												'<img width="'.$width.'" style="margin-bottom:'.$gutter.'px" src="'.$prevPath.'" />'.
											'</a>'.
										'</div>';

						if(in_array('x', $sfw)){ // explicit
							if($rating == 'e'){
								echo $currentDiv.'`';
							}
						}
						if(in_array('q', $sfw)){ // questionable
							if($rating == 'q'){
								echo $currentDiv.'`';
							}
						}
						if(in_array('s', $sfw)){ // safe
							if($rating == 's'){
								echo $currentDiv.'`';
							}
						}
					}
				}
				if(in_array("dan", $sites)){
					for($i = 0; $i < $dCount; $i++){
						$rating = $dXml->post[$i]->rating;
						$path = $dXml->post[$i]->{'preview-file-url'};
						if(strlen($path) != 0){
							$id = (string) $dXml->post[$i]->id;

							$currentDiv = 	'<div class="grid-item">'.
												'<a href=http://danbooru.donmai.us/posts/'.$id.' target="_blank">'.
													'<img height="'.$h1.'" width="'.$width.'" style="margin-bottom:'.$gutter.'px" src="http://danbooru.donmai.us'.$path.'" />'.
												'</a>'.
											'</div>';

							if(in_array('x', $sfw)){ // explicit
								if($rating == 'e'){
									echo $currentDiv.'`';
								}
							}
							if(in_array('q', $sfw)){ // questionable
								if($rating == 'q'){
									echo $currentDiv.'`';
								}
							}
							if(in_array('s', $sfw)){ // safe
								if($rating == 's'){
									echo $currentDiv.'`';
								}
							}
						}
					}
				}
			}
		}
	}
		
	/*function makeDiv($prevPath, $id){
		
	}*/
	
	function checkTags($tags){
		if($tags == " "){
			return true;
		}
		$trueCount = 0;
		$found = false;
		$badTag = "";
		$tagArray = explode(" ", $tags);
		foreach($tagArray as $tag){
			if(strrpos($tag, 'width:') !== false || strrpos($tag, 'height:') !== false || strrpos($tag, 'order:') !== false || strrpos($tag, 'rating:') !== false){
				$trueCount++;
				$found = true;
				continue;
			}
			$kContent = file_get_contents('http://konachan.com/tag.xml?name='.$tag);
			$kXml = new SimpleXMLElement($kContent);
			$kCount = $kXml->count();
			for($i = 0; $i < $kCount; $i++){
				$currentName = (string) $kXml->tag[$i]['name'];
				if($currentName === $tag){
					$trueCount++;
					$found = true;
				}
			}
			if(!$found){
					$badTag = $badTag.$tag." ";
					break;
				}
			$found = false;
			if($kCount == 0){
				$badTag = $badTag.$tag." ";
				break;
			}
		}
		if($trueCount != count($tagArray)){
			echo " ";
		} else {
			return true;
		}
	}

	if((isset($_POST['pageNo']) && !empty($_POST['pageNo'])) &&
			(isset($_POST['sfw']) &&!empty($_POST['sfw'])) &&
			(isset($_POST['tags']) && !empty($_POST['tags'])) &&
			(isset($_POST['gutter']) && !empty($_POST['gutter'])) &&
			(isset($_POST['sites']) && !empty($_POST['sites']))) {
		$pageNo = $_POST['pageNo'];
		$sfw = $_POST['sfw'];
		$tags = $_POST['tags'];
		$loaded = $_POST['loaded'];
		$gutter = $_POST['gutter'];
		$sites = $_POST['sites'];
		$width = $_POST['width'];
		loadImages($pageNo, $sfw, $tags, $loaded, $gutter, $sites, $width);
	}
?>