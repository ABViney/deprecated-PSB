<?php

/*
    TODO: recieve client viewport dimensions
            calc image resize, margin, and clips
            resize should be in pixels, margin percentage, clips pixels
            post data in json format
*/

if(!isset($_POST['gal_sel'])) {
    echo "E: INVALID REQUEST";
    exit();
}

$collection = array();

$target = "res/img/gallery/".$_POST['gal_sel'];
if(is_dir("../".$target)) {
    $track = scandir("../".$target, SCANDIR_SORT_DESCENDING);
    if(count($track) != 4) {
        echo "E: INVALID CONTENT TOTAL : ".print_r($track);
        exit();
    }
    array_splice($track, 2);
    $size_info = array();
    $issue_encountered = false;
    foreach($track as $img_loc) {
        $filetype = array();
        if(preg_match("/\.[A-z]{3,4}/", $img_loc, $filetype)) {
            $img_dimensions = null;
            if(strtolower($filetype[0]) == ".jpg" || strtolower($filetype[0]) == ".jpeg") {
                $img_dimensions = getjpegsize("../".$target."/".$img_loc);
            }
            elseif(strtolower($filetype[0]) == ".png") {
                $img_dimensions = getpngsize("../".$target."/".$img_loc);
            }

            if(!$img_dimensions) {
                echo "E: FAILED TO RETRIEVE DIMENSIONS OF ${img_loc} IN SUBFOLDER ".$_POST['gal_sel']."\n";
                $issue_encountered = true;
            }
            $size_info[] = $img_dimensions;
        } else {
            echo "E: INVALID FILE READ : ".$img_loc."\n";
            $issue_encountered = true;
        }
    }
    if(!$issue_encountered) {
        $collection["image_1"] = array(
            "path" => $target.$track[0],
            "width" => $size_info[0][0],
            "height" => $size_info[0][1],
            "margin" => "0 0"
        );
        $collection["image_2"] = array(
            "path" => $target.$track[1],
            "width" => $size_info[1][0],
            "height" => $size_info[1][1],
            "margin" => "0 0"
        );
    } else {
        exit();
    }
} else {
    echo "E: ${target} DOES NOT EXIST";
    exit();
}

/*
    Brainstorm time:
        Assuming viewport params are passed, 
*/


/*
    LAST TASK
*/
echo json_encode($collection);

// Credit to https://www.php.net/manual/en/function.getimagesize.php#88793
// Retrieve JPEG width and height without downloading/reading entire image.
function getjpegsize($img_loc) {
    $handle = fopen($img_loc, "rb") or die("Invalid file stream.");
    $new_block = NULL;
    if(!feof($handle)) {
        $new_block = fread($handle, 32);
        $i = 0;
        if($new_block[$i]=="\xFF" 
            && $new_block[$i+1]=="\xD8" 
            && $new_block[$i+2]=="\xFF" 
            && $new_block[$i+3]=="\xE0") {
            $i += 4;
            if($new_block[$i+2]=="\x4A" 
                && $new_block[$i+3]=="\x46" 
                && $new_block[$i+4]=="\x49" 
                && $new_block[$i+5]=="\x46" 
                && $new_block[$i+6]=="\x00") {
                // Read block size and skip ahead to begin cycling through blocks in search of SOF marker
                $block_size = unpack("H*", $new_block[$i] . $new_block[$i+1]);
                $block_size = hexdec($block_size[1]);
                while(!feof($handle)) {
                    $i += $block_size;
                    $new_block .= fread($handle, $block_size);
                    if($new_block[$i]=="\xFF") {
                        // New block detected, check for SOF marker
                        $sof_marker = array("\xC0", "\xC1", "\xC2", "\xC3", 
                                            "\xC5", "\xC6", "\xC7", "\xC8", 
                                            "\xC9", "\xCA", "\xCB", "\xCD", 
                                            "\xCE", "\xCF");
                        if(in_array($new_block[$i+1], $sof_marker)) {
                            // SOF marker detected. Width and height information is contained in bytes 4-7 after this byte.
                            $size_data = $new_block[$i+2] . $new_block[$i+3] . $new_block[$i+4] . $new_block[$i+5] 
                                        . $new_block[$i+6] . $new_block[$i+7] . $new_block[$i+8];
                            $unpacked = unpack("H*", $size_data);
                            $unpacked = $unpacked[1];
                            $height = hexdec($unpacked[6] . $unpacked[7] . $unpacked[8] . $unpacked[9]);
                            $width = hexdec($unpacked[10] . $unpacked[11] . $unpacked[12] . $unpacked[13]);
                            return array($width, $height);
                        } else {
                            // Skip block marker and read block size
                            $i += 2;
                            $block_size = unpack("H*", $new_block[$i] . $new_block[$i+1]);
                            $block_size = hexdec($block_size[1]);
                        }
                    } else {
                        return FALSE;
                    }
                }
            }
        }
    }
    return FALSE;
}

// Credit to https://www.php.net/manual/en/function.getimagesize.php#122015
// Retrieve PNG width and height without downloading/reading entire image.
function getpngsize( $img_loc ) {
    $handle = fopen( $img_loc, "rb" ) or die( "Invalid file stream." );

    if ( ! feof( $handle ) ) {
        $new_block = fread( $handle, 24 );
        if ( $new_block[0] == "\x89" &&
            $new_block[1] == "\x50" &&
            $new_block[2] == "\x4E" &&
            $new_block[3] == "\x47" &&
            $new_block[4] == "\x0D" &&
            $new_block[5] == "\x0A" &&
            $new_block[6] == "\x1A" &&
            $new_block[7] == "\x0A" ) {
                if ( $new_block[12] . $new_block[13] . $new_block[14] . $new_block[15] === "\x49\x48\x44\x52" ) {
                    $width  = unpack( 'H*', $new_block[16] . $new_block[17] . $new_block[18] . $new_block[19] );
                    $width  = hexdec( $width[1] );
                    $height = unpack( 'H*', $new_block[20] . $new_block[21] . $new_block[22] . $new_block[23] );
                    $height  = hexdec( $height[1] );

                    return array( $width, $height );
                }
            }
        }

    return false;
}
?>