<?php 
    $gal_loc_rel = "res/img/gallery/";
    $img_roll = array();
    foreach(scandir($gal_loc_rel, SCANDIR_SORT_ASCENDING) as $dir) {
        if(preg_match("/^\./", $dir)) continue;
        $files = scandir($gal_loc_rel . $dir);
        foreach($files as $file) {
            if(preg_match("/^\./", $file)) continue;
            $img_roll[] = $gal_loc_rel . $dir . "/" . $file;
        }
    }
    if(!$img_roll) return;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSB Gallery</title>

    <link rel="shortcut icon" href="res/logo/PSB_logo_w.png"/>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/gallery.css" type="text/css">

</head>
<body>
    <header>
        <div class="preface">
            <div class="cwrap">
                <a href="index.html"><img src="res/logo/PSB_logo-mod-applied-2.png" alt="Prime Solutions Biomedical" class="unselectable"></a>
                <p>All your Biomedical, Surgical, and Sterlization needs in one place.</p>
            </div>
        </div>
        <nav>
                <div class="cwrap">
                <ul>
                    <li id="home"><a href="index.html" class="a-btn"">Home</a></li>
                    <li><a href="about.html" class="a-btn">About Us</a></li>
                    <li><a href="services.html" class="a-btn">Services</a></li>
                    <li><a href="gallery.php" class="a-btn">Gallery</a></li>
                    <li><a href="contact.html" class="a-btn">Contact Us</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section class="gallery">
        <div class="blowup">
            <img src="<? echo $img_roll[0] ?>" alt="" id="target">
            <div class="left-box" id="l"></div>
            <div class="right-box" id="r"></div>
        </div>
        <div class="scroller">
             <?php
                echo "<div class=\"selector\" id=\"active\">"
                    . "<label>"
                    . "<input name=\"thumbnail\" type=\"radio\" id=0 value=\"" . $img_roll[0] . "\" autofocus/>"
                    . "<img src=\"" . $img_roll[0] . "\" alt=\"\" ondragstart=\"return false;\">"
                    . "</label></div>";
                $r_template = "<div class=\"selector\">"
                            . "<label>"
                            . "<input name=\"thumbnail\" type=\"radio\" id=%d value=\"%s\"/>"
                            . "<img src=\"%s\" alt=\"\" ondragstart=\"return false;\"\>"
                            . "</label></div>";
                for($i = 1; $i < count($img_roll); $i++) {
                    echo vsprintf($r_template, array($i, $img_roll[$i], $img_roll[$i]));
                }
             ?>
        </div>

        </section>
    </main>
    <footer>
        <div class="footer-bump"></div>
        <div class="cwrap">
            <div class="footer-wrap">
                <a href=""><img src="res/logo/PSB_logo_w.png" alt="Prime Solutions Biomedical"></a>
                <ul>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
                <div class="social-panel">
                    <a target="_blank" href="https://www.facebook.com/primesolutionsb/"><img src="res/icons/facebook-512.png" alt=""></a>
                    <a target="_blank" href="https://www.instagram.com/primesolutionsb/"><img src="res/icons/instagram-512.png" alt=""></a>
                    <a target="_blank" href="mailto:jacob.rowan@psbiomedical.com"><img src="res/icons/email-7-512.png" alt=""></a>
                </div>
            </div>
        </div>
        <div class="footer-bump"></div>
        <div class="footnote">
            &copy; Prime Solutions Biomedical
        </div>
    </footer>
    <script src="js/img-swap.js"></script>
</body>
</html>