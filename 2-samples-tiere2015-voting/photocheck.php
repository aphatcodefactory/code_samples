<?php

$photo = getimagesize($uploaddir.$newPicName);

// check if landscape or upright
if ($photo[0] / $photo[1] > 1) {
	$orgPhotoWidth = $photo[0];
	$orgPhotoHeight = $photo[1];
	$factor = round($orgPhotoWidth / $orgPhotoHeight, 4, PHP_ROUND_HALF_EVEN);
	$format = 'landscape';
}

if ($photo[0] / $photo[1] < 1) {
	$orgPhotoWidth = $photo[1];
	$orgPhotoHeight = $photo[0];
	$factor = round($orgPhotoWidth / $orgPhotoHeight, 4, PHP_ROUND_HALF_EVEN);
	$format = 'upright';
}

// check if orig. width/height more or equal 720px
if ($photo[0] >= 720 || $photo[1] >= 720) {

	// check width-to-height ratio
	switch ($factor) {
		case round(16 / 9, 4, PHP_ROUND_HALF_EVEN):
			if ($format == 'landscape') {
				$photoDispWidth = 720;
				$photoDispHeight = 405;
			}

			if ($format == 'upright') {
				$photoDispWidth = 405;
				$photoDispHeight = 720;
			}
			break;
		case 1.6:
			if ($format == 'landscape') {
				$photoDispWidth = 720;
				$photoDispHeight = 450;
			}

			if ($format == 'upright') {
				$photoDispWidth = 450;
				$photoDispHeight = 720;
			}
			break;
		case round(4288/2848, 4, PHP_ROUND_HALF_EVEN):
			if ($format == 'landscape') {
				$photoDispWidth = 720;
				$photoDispHeight = 478;
			}

			if ($format == 'upright') {
				$photoDispWidth = 478;
				$photoDispHeight = 720;
			}
			break;
		case round(4 / 3, 4, PHP_ROUND_HALF_EVEN):
			if ($format == 'landscape') {
				$photoDispWidth = 720;
				$photoDispHeight = 540;
			}

			if ($format == 'upright') {
				$photoDispWidth = 540;
				$photoDispHeight = 720;
			}
			break;
		case round(720 / 562, 4, PHP_ROUND_HALF_EVEN):
			if ($format == 'landscape') {
				$photoDispWidth = 720;
				$photoDispHeight = 562;
			}

			if ($format == 'upright') {
				$photoDispWidth = 562;
				$photoDispHeight = 720;
			}
			break;
		case 1.5:
			if ($format == 'landscape') {
				$photoDispWidth = 720;
				$photoDispHeight = 480;
			}

			if ($format == 'upright') {
				$photoDispWidth = 480;
				$photoDispHeight = 720;
			}
			break;
		case round(360 / 216, 4, PHP_ROUND_HALF_EVEN):
				if ($format == 'landscape') {
					$photoDispWidth = 720;
					$photoDispHeight = 432;
				}

				if ($format == 'upright') {
					$photoDispWidth = 432;
					$photoDispHeight = 720;
				}
			break;
		default:
			if ($format == 'landscape') {
				$photoDispWidth = 720;
				$photoDispHeight = round(720 / $factor, 0, PHP_ROUND_HALF_EVEN);
			}

			if ($format == 'upright') {
				$photoDispWidth = round(720 / $factor, 0, PHP_ROUND_HALF_EVEN);
				$photoDispHeight = 720;
			}
		}

} else {
	if ($format == 'landscape') {
		$photoDispWidth = $photo[0];
		$photoDispHeight = $photo[1];
	}

	if ($format == 'upright') {
		$photoDispWidth = $photo[1];
		$photoDispHeight = $photo[0];
	}
}
