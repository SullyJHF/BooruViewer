<?php

	function loadImages($page, $sfw, $tags, $loaded = 0, $gutter){
		echo $gutter;
		if($tags === ""){
			$tags = " ";
		}
		if($loaded === 1 || checkTags($tags)){
			$content = file_get_contents('http://konachan.com/post.xml?page='.$page.'&tags='.$tags);
			$xml = new SimpleXMLElement($content);
			// $count = $xml->count();
			$count = count($xml->children());
			#echo $xml->count();
			#echo $xml->post[0]['file_url'];
			#echo $xml->post[0]['rating'];
			for($i = 0; $i < $count; $i++){
				$rating = $xml->post[$i]['rating'];
				$prevPath = (string) $xml->post[$i]['preview_url'];
				$id = (string) $xml->post[$i]['id'];

				$currentDiv = 	'<div class="grid-item">'.
									'<a href=http://konachan.com/post/show/'.$id.' target="_blank">'.
										'<img  style="margin-bottom:'.$gutter.'px" src="'.$prevPath.'" />'.
									'</a>'.
								'</div>';

				if($sfw == 1){
					if($rating == 's'){
						echo $currentDiv.'`';
					}
				} else if($sfw == 2){
					if($rating == 'q' || $rating == 'e'){
						echo $currentDiv.'`';
					}
				} else if($sfw == 3){
					if($rating == 'e'){
						
						echo $currentDiv.'`';
					}
				} else {
					echo $currentDiv.'`';
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
			$content = file_get_contents('http://konachan.com/tag.xml?name='.$tag);
			$xml = new SimpleXMLElement($content);
			$count = $xml->count();
			for($i = 0; $i < $count; $i++){
				$currentName = (string) $xml->tag[$i]['name'];
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
			if($count == 0){
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
			(isset($_POST['gutter']) && !empty($_POST['gutter']))) {
		$pageNo = $_POST['pageNo'];
		$sfw = $_POST['sfw'];
		$tags = $_POST['tags'];
		$gutter = $_POST['gutter'];
		loadImages($pageNo, $sfw, $tags, 0, (string)$gutter);
	}
?>