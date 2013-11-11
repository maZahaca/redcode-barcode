<?php

namespace RedCode\Barcode\Formatter;

/**
 * @author maZahaca
 */ 
class Png1DFormatter implements IBarcodeFormatter
{
    private $width = 2;
    private $height = 2;
    private $color = array(0,0,0);
    private $path;

    public function __construct()
    {
        $this->path = sys_get_temp_dir();
    }

    /**
     * @param $width
     * @param $height
     * @param $color
     * @return self
     */
    public function setParams($width = 2, $height = 2, $color = array(0,0,0))
    {
        $this->width    = $width;
        $this->height   = $height;
        $this->color    = $color;
        return $this;
    }

    /**
     * @param $path
     * @return self
     */
    public function setPath($path)
    {
        if($path) {
            $this->path = $path;
        }
        return $this;
    }

    public function format($barcodeArray)
    {
        if (!function_exists('imagecreate') || $barcodeArray === false) {
            return false;
        }

        // calculate image size
        $width = ($barcodeArray['maxw'] * $this->width);
        $height = $this->height;

        // GD library
        $png = imagecreate($width, $height);
        $bgcol = imagecolorallocate($png, 255, 255, 255);
        imagecolortransparent($png, $bgcol);
        $fgcol = imagecolorallocate($png, $this->color[0], $this->color[1], $this->color[2]);

        // print bars
        $x = 0;
        foreach ($barcodeArray['bcode'] as $k => $v) {
            $bw = round(($v['w'] * $this->width), 3);
            $bh = round(($v['h'] * $this->height / $barcodeArray['maxh']), 3);
            if ($v['t']) {
                $y = round(($v['p'] * $this->height / $barcodeArray['maxh']), 3);
                // draw a vertical bar
                imagefilledrectangle($png, $x, $y, ($x + $bw - 1), ($y + $bh - 1), $fgcol);
            }
            $x += $bw;
        }
        $filename = $this->path.'/'.md5(uniqid()).'.png';
        imagepng($png, $filename);
        imagedestroy($png);
        return $filename;
    }
}
 