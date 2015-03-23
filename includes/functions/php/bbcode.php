<?php

	function replaceBBcode($content) {
		youtubeFind($content);
	}

	function youtubeFind($content) {
	    $html = $content->content();
		$pattern = '/\[youtube=(https?:\/\/)?www\.youtube\.com\/watch\?v=([a-zA-Z0-9]+)(&amp;w=([0-9]+))?(&amp;h=([0-9]+))?\]/';
		//$success = ;
		if (preg_match_all($pattern, $html, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
			    $extraParams = "?version=3&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1&wmode=transparent";
			    $frameSrc = "http://www.youtube.com/embed/".$match[2].$extraParams;
			    $iframeCode = "<iframe width=".$match[4]." height=".$match[6]." src=".$frameSrc." frameborder=0 allowfullscreen></iframe>";
			    $content->SetContent(str_replace($match[0], $iframeCode, $html));
			}
		}
	}

?>
