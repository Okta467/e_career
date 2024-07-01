<?php 
	function base_url($path = 'index.php') {
		echo "/e_career/" . $path;
	}

	function base_url_return($path = 'index.php') {
		return "/e_career/" . $path;
	}

    date_default_timezone_set("Asia/Bangkok");
	
	DEFINE("SITE_NAME", "SI Bursa Kerja Alumni");
	DEFINE("SITE_NAME_SHORT", "E-Career");
?>