<?php

// get all of the videos for the given user.
function get_videos($username, $path){
	// Make sure cache directory is writable
	if(is_writable($path . "cache/video_cache.txt")){
		// Check if one minute since last cache
		if( time() - filemtime($path . "cache/video_cache.txt") > 60 ){
			$start = 1;
			$videos = array();
			
			do {
				$data = @file_get_contents('http://gdata.youtube.com/feeds/api/users/' . $username . '/uploads?start-index=' . $start . '&max-results=50');
				// Make sure you your username is correct
				if($data == false){
					echo "<strong>Plugin Notice:</strong> Please enter a valid youtube username.";
				} else {
					$xml = simplexml_load_string($data);
					$last = (array)$xml->link[5];

					foreach( $xml->entry as $video ){
						// Cleaning Up Array - Typecasting
						$title = (array)$video->title;
						$desc = (array)$video->content;
						$url = (array)$video->link[0];

						$videos[] = array(
							'title' => $title[0],
							'desc' => $desc[0],
							'url' => $url['@attributes']['href']
						);
					}
					$start +=50;
				}

			} while( empty($last) == false && $last['@attributes']['rel'] == 'next' );

			file_put_contents( $path . "cache/video_cache.txt", serialize($videos) );

		} else {
			$videos = unserialize(file_get_contents($path . "cache/video_cache.txt"));
		}
	} else {
		echo "<strong>Plugin Notice:</strong> Please make sure your cache directory is writable by the server.";
	}
	
	return $videos;
}

?>