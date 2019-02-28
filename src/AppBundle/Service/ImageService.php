<?php

namespace AppBundle\Service;


class ImageService
{

    public function generateImf(string $browser) {
        $im = imagecreate(1600, 500);
        $background_color = imagecolorallocate($im, 100,100,40 );
        $text_color = imagecolorallocate($im, 233, 220, 222);
        imagestring($im, 200, 200, 100, date("Y-m-d H:i:s")." ".$browser, $text_color);
        imagepng($im,'date.png');
        return readfile('date.png');
    }
}