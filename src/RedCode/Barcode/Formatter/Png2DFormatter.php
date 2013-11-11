<?php

namespace RedCode\Barcode\Formatter;

/**
 * @author maZahaca
 */ 
class Png2DFormatter implements IBarcodeFormatter
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
    public function setParams($width, $height, $color)
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
        $this->path = $path;
        return $this;
    }

    public function format($barcodeArray)
    {
        if (!function_exists('imagecreate')) {
            return false;
        }

        // calculate image size
        $width = ($this->barcode_array['num_cols'] * $this->width);
        $height = ($this->barcode_array['num_rows'] * $this->height);

        // GD library
        $imagick = false;
        $png = imagecreate($width, $height);
        $bgcol = imagecolorallocate($png, 255, 255, 255);
        imagecolortransparent($png, $bgcol);
        $fgcol = imagecolorallocate($png, $this->color[0], $this->color[1], $this->color[2]);

        // print barcode elements
        $y = 0;
        // for each row
        for ($r = 0; $r < $barcodeArray['num_rows']; ++$r) {
            $x = 0;
            // for each column
            for ($c = 0; $c < $barcodeArray['num_cols']; ++$c) {
                if ($barcodeArray['bcode'][$r][$c] == 1) {
                    // draw a single barcode cell
                    imagefilledrectangle($png, $x, $y, ($x + $this->width - 1), ($y + $this->height - 1), $fgcol);
                }
                $x += $this->width;
            }
            $y += $this->height;
        }
        $filename = $this->path.'/'.md5(uniqid()).'png';
        imagepng($png, $filename);
        imagedestroy($png);
        return $filename;
    }
}
 