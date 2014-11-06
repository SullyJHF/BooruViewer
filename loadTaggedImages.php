<?php

	function loadImages($page, $sfw, $tags, $loaded = 0, $gutter, $sites, $width, $shuffle, $fixed){
		// print_r($_POST);
		// echo "<br>";
		// echo $gutter;

		$k = "http://konachan.com";
		$y = "http://yande.re";
		$d = "http://danbooru.donmai.us";

		$divs = array();

		if($tags === ""){
			$tags = " ";
		}

		if($loaded === 1 || checkTags($tags)){
			$kContent = file_get_contents($k.'/post.xml?page='.$page.'&tags='.$tags);
			$yContent = file_get_contents($y.'/post.xml?page='.$page.'&tags='.$tags);
			$dContent = file_get_contents($d.'/posts.xml?page='.$page.'&tags='.$tags);
			$kXml = new SimpleXMLElement($kContent);
			$yXml = new SimpleXMLElement($yContent);
			$dXml = new SimpleXMLElement($dContent);
			// $kCount = $kXml->count();
			$kCount = count($kXml->children());
			$yCount = count($yXml->children());
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
						// $fileUrl = (string) $kXml->post[$i]['file_url'];
						$w0 = (int) $kXml->post[$i]['actual_preview_width'];
						
						$w1 = $width;
						if($fixed == 0) $w1 = getWidth($w0, $gutter, $width);

						$currentDiv = 	'<div class="grid-item">'.
											'<a href='.$k.'/post/show/'.$id.' target="_blank">'.
												'<img width="'.$w1.'" style="margin-bottom:'.$gutter.'px" src="'.$prevPath.'" />'.
											'</a>'.
										'</div>';

						/*$currentDiv = 	'<div class="grid-item">'.
							'<a href="'.$fileUrl.'" target="_blank">'.
								'<img width="'.$width.'" style="margin-bottom:'.$gutter.'px" src="'.$fileUrl.'" />'.
							'</a>'.
						'</div>';*/

						if(in_array('x', $sfw)){ // explicit
							if($rating == 'e'){
								array_push($divs, $currentDiv);
								// echo $currentDiv.'`';
							}
						}
						if(in_array('q', $sfw)){ // questionable
							if($rating == 'q'){
								array_push($divs, $currentDiv);
								// echo $currentDiv.'`';
							}
						}
						if(in_array('s', $sfw)){ // safe
							if($rating == 's'){
								array_push($divs, $currentDiv);
								// echo $currentDiv.'`';
							}
						}
					}
				}

				if(in_array("yan", $sites)){
					for($i = 0; $i < $yCount; $i++){
						$rating = $yXml->post[$i]['rating'];
						$prevPath = (string) $yXml->post[$i]['preview_url'];
						$id = (string) $yXml->post[$i]['id'];

						$w0 = (int) $yXml->post[$i]['actual_preview_width'];
						// echo $w0;
						$w1 = $width;
						if($fixed == 0) $w1 = getWidth($w0, $gutter, $width);
						// $fileUrl = (string) $yXml->post[$i]['file_url'];

						$currentDiv = 	'<div class="grid-item">'.
											'<a href='.$y.'/post/show/'.$id.' target="_blank">'.
												'<img width="'.$w1.'" style="margin-bottom:'.$gutter.'px" src="'.$prevPath.'" />'.
											'</a>'.
										'</div>';

						/*$currentDiv = 	'<div class="grid-item">'.
							'<a href="'.$fileUrl.'" target="_blank">'.
								'<img width="'.$width.'" style="margin-bottom:'.$gutter.'px" src="'.$fileUrl.'" />'.
							'</a>'.
						'</div>';*/

						if(in_array('x', $sfw)){ // explicit
							if($rating == 'e'){
								array_push($divs, $currentDiv);
								// echo $currentDiv.'`';
							}
						}
						if(in_array('q', $sfw)){ // questionable
							if($rating == 'q'){
								array_push($divs, $currentDiv);
								// echo $currentDiv.'`';
							}
						}
						if(in_array('s', $sfw)){ // safe
							if($rating == 's'){
								array_push($divs, $currentDiv);
								// echo $currentDiv.'`';
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
							$w0 = 100;

							$w1 = $width;
							if($fixed == 0) $w1 = getWidth($w0, $gutter, $width);

							$currentDiv = 	'<div class="grid-item">'.
												'<a href='.$d.'/posts/'.$id.' target="_blank">'.
													'<img width="'.$w1.'" style="margin-bottom:'.$gutter.'px" src="'.$d.$path.'" />'.
												'</a>'.
											'</div>';

							if(in_array('x', $sfw)){ // explicit
								if($rating == 'e'){
									array_push($divs, $currentDiv);
									// echo $currentDiv.'`';
								}
							}
							if(in_array('q', $sfw)){ // questionable
								if($rating == 'q'){
									array_push($divs, $currentDiv);
									// echo $currentDiv.'`';
								}
							}
							if(in_array('s', $sfw)){ // safe
								if($rating == 's'){
									array_push($divs, $currentDiv);
									// echo $currentDiv.'`';
								}
							}
						}
					}
				}
				if($shuffle == 1) shuffle($divs);
				$divString = implode("`", $divs);
				echo $divString;
			}
		}
	}
	
	function getWidth($width, $gutter, $minWidth){
		$xBlocks = round($width/$minWidth);
		if($xBlocks < 1) $xBlocks = 1;
		$newWidth = ($xBlocks*$minWidth) + ($gutter*($xBlocks-1));
		return $newWidth;
	}

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
			(isset($_POST['sites']) && !empty($_POST['sites']))&&
			(isset($_POST['width']) && !empty($_POST['width']))&&
			(isset($_POST['shuffle']))&&
			(isset($_POST['fixed']))) {
		$pageNo = $_POST['pageNo'];
		$sfw = $_POST['sfw'];
		$tags = $_POST['tags'];
		$loaded = $_POST['loaded'];
		$gutter = $_POST['gutter'];
		$sites = $_POST['sites'];
		$width = $_POST['width'];
		$shuffle = $_POST['shuffle'];
		$fixed = $_POST['fixed'];
		loadImages($pageNo, $sfw, $tags, $loaded, $gutter, $sites, $width, $shuffle, $fixed);
	}
?>