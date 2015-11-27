<?php
/**
 * Created by PhpStorm.
 * User: Øyvind
 * Date: 23.06.14
 * Time: 15:36
 */
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
	$os = 'Unknown';
    $device = 'Unknown';
    $version = '';
    $u_agent = 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; DEVICE INFO) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Mobile Safari/537.36 Edge/13.10586';

    //First get the platform
	if(preg_match('/Windows Phone/i', $u_agent)){
		$platform = 'Windows Phone';
	}elseif (preg_match('/android/i', $u_agent)) {
        $platform = "Android";
    } elseif (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    } elseif (preg_match('/iphone/i', $u_agent)) {
        $platform = 'iOS';
        $device = 'iPhone';
    } elseif (preg_match('/ipad/i', $u_agent)) {
        $platform = 'iOS';
        $device = 'iPad';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac OS X';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
		$platform = 'Windows';
        if (preg_match('/xbox one/i', $u_agent)) {
            $device = 'Xbox One';
        } elseif (preg_match('/xbox/i', $u_agent)) {
            $device = 'Xbox 360';
        }
    } elseif (preg_match('/playstation/i', $u_agent)) {
        if (preg_match('/playstation 3/i', $u_agent)) {
			$bname = 'Sony PlayStation 3';
			$platform = "PlayStation 3";
            $device = 'PlayStation 3';
			$ub = 'PlayStation 3';
        } elseif (preg_match('/playstation 4/i', $u_agent)) {
			$bname = 'Sony PlayStation 4';
			$platform = "PlayStation 4";
            $device = 'PlayStation 4';
			$ub = 'PlayStation 4';
        }
    } elseif (preg_match('/nintendo wiiu/i', $u_agent)) {
		$platform = 'Wii U';
		$device = 'Wii U';
	}

    // get OS version
    if ($platform == 'Android') {
        $pattern = '/Android (\d+(?:\.\d+)+)[;)]/';
        preg_match($pattern, $u_agent, $matches);
        $os = $platform . " " . $matches[1];
    } elseif ($platform == 'iOS') {
        //Couldn't get any regex to work here, had to cheat
        //Find index of 'iPhone OS'
        $index = strpos($u_agent, 'iPhone OS ');
        //Count number of '_' (this tells us how many numbers there are in the version number
        $count = substr_count($u_agent, '_');
        //if 2 '_' then version number is X_X_X, that's 5 chars
        if ($count == 2) {
            $os = $platform . " " . substr($u_agent, $index + 10, 5);
        } //if 1 '_' then version number is X_X, that's 3 chars
        elseif ($count == 1) {
            $os = $platform . " " . substr($u_agent, $index + 10, 3);
        }
        //if 0 '_' then version number is X, that's 1 char
        //Add a .0 to the end for more "normal" version number
        elseif ($count == 0) {
            $os = $platform . " " . substr($u_agent, $index + 10, 1) . '.0';
        }
        /*$pattern = '/OS (\d+(?:\_\d+)+)[;)]/';
        preg_match($pattern, $u_agent, $matches);
        $platform = $platform." ".$matches[1];*/
        //Replace _ with .
        $os = str_replace('_', '.', $platform);
    } elseif ($platform == 'Mac OS X') {
        $pattern = '/OS X (\d+(?:\_\d+)+)[;)]/';
        preg_match($pattern, $u_agent, $matches);
        //$platform = $platform . " " . $matches[1];
        //Replace _ with .
        //$platform = str_replace('_', '.', $platform);
		$matches[1] = str_replace('_', '.', $matches[1]);
		
		//Get OS name
		if(strpos($matches[1], '10.11') !== false){
			$os = 'OS X '. $matches[1] .' El Capitan';
		} elseif(strpos($matches[1], '10.10') !== false){
			$os = 'OS X '. $matches[1] .' Yosemite';
		} elseif(strpos($matches[1], '10.9') !== false){
			$os = 'OS X '. $matches[1] .' Mavericks';
		} elseif(strpos($matches[1], '10.8') !== false){
			$os = 'OS X '. $matches[1] .' Mountain Lion';
		} elseif(strpos($matches[1], '10.7') !== false){
			$os = 'Mac OS X '. $matches[1] .' Lion';
		} elseif(strpos($matches[1], '10.6') !== false){
			$os = 'Mac OS X '. $matches[1] .' Snow Leopard';
		} elseif(strpos($matches[1], '10.5') !== false){
			$os = 'Mac OS X '. $matches[1] .' Leopard';
		} elseif(strpos($matches[1], '10.4') !== false){
			$os = 'Mac OS X '. $matches[1] .' Tiger';
		} elseif(strpos($matches[1], '10.3') !== false){
			$os = 'Mac OS X '. $matches[1] .' Panther';
		}
		
    } elseif ($platform == 'Windows') {
        //People are more used to reading Windows name rather than the version number, manual conversion is needed
        if (strpos($u_agent, "Windows NT 10.0") !== false) {
            $os = "Windows 10";
        } elseif (strpos($u_agent, "Windows NT 6.4") !== false) {
            $os = "Windows 10 Technical Preview";
        } elseif (strpos($u_agent, "Windows NT 6.3") !== false) {
            $os = "Windows 8.1";
        } elseif (strpos($u_agent, "Windows NT 6.2") !== false) {
            $os = "Windows 8";
        } elseif (strpos($u_agent, "Windows NT 6.1") !== false) {
            $os = "Windows 7";
        } elseif (strpos($u_agent, "Windows NT 6.0") !== false) {
            $os = "Windows Vista";
        } elseif (strpos($u_agent, "Windows NT 5.2") !== false) {
            $os = "Windows XP 64bit";
        } elseif (strpos($u_agent, "Windows NT 5.1") !== false) {
            $os = "Windows XP";
        } elseif (strpos($u_agent, "Windows NT 5.0") !== false) {
            $os = "Windows 2000";
        }
    } elseif ($platform == 'PlayStation 3') {
        $pattern = '/PLAYSTATION 3; (\d+(?:\.\d+)+)[;)]/';
        preg_match($pattern, $u_agent, $matches);
		$os = "PlayStation 3 system software " . $matches[1];
	} elseif ($platform == 'PlayStation 4') {
        $pattern = '/PlayStation 4 (\d+(?:\.\d+)+)[;)]/';
        preg_match($pattern, $u_agent, $matches);
		$os = "PlayStation 4 system software " . $matches[1];
	} elseif ($platform == 'Wii U') {
		$pattern = '/NintendoBrowser\/(\d+(?:\.\d+)+)/';
        preg_match($pattern, $u_agent, $matches);
		$os = "Wii U system software " . $matches[1];
	} elseif ($platform == 'Linux') {
		if(preg_match('/ubuntu/i', $u_agent)){
			$pattern = '/Ubuntu\/(\d+(?:\.\d+)+)/';
			preg_match($pattern, $u_agent, $matches);
			$os = 'Ubuntu '.$matches[1];
		}
	} elseif($platform == 'Windows Phone'){
		if(strpos($u_agent, "Windows Phone 10.0") !== false){
			$os = "Windows 10 Mobile";
		}
	}

    // Next get the name of the useragent, yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Edge/i', $u_agent)) {
        $bname = 'Microsoft Edge';
        $ub = 'Edge';
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/OPR/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "OPR";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    } elseif (preg_match('/Trident/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "rv";
    } elseif (preg_match('/NintendoBrowser/i', $u_agent)) {
		$bname = 'NetFront Browser NX';
		$ub = 'NX';
	}

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // Other regex for IE11 (and possibly future versions of IE)
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[: ]+(?<version>[0-9.|a-zA-Z.]*)#';
        preg_match_all($pattern, $u_agent, $matches);
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
		'os'	=> $os,
        'device' => $device,
        'pattern' => $pattern
    );
}