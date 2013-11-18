<?php

namespace RedCode\Barcode\Formatter;
use RedCode\Barcode\Text\BarcodeText;

/**
 * @author maZahaca
 */ 
class Png1DFormatter implements IBarcodeFormatter, IBarcodeStore
{
    protected $width = 2;
    protected $height = 2;
    protected $color = array(0,0,0);
    protected $barcodeText = null;
    protected $code = null;

    protected $path;

    public function __construct()
    {
        $this->path = sys_get_temp_dir();
    }

    /**
     * @param int $width
     * @param int $height
     * @param array $color
     * @return self
     */
    public function setRenderParams($width = 2, $height = 2, $color = array(0,0,0))
    {
        $this->width        = $width;
        $this->height       = $height;
        if($color){
            $this->color    = $color;
        }
        return $this;
    }

    /**
     * @param BarcodeText $barcodeText
     * @return self
     */
    public function setBarCodeText($barcodeText)
    {
        $this->barcodeText = $barcodeText;
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

    /**
     * @param null|string $code
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function format($barcodeArray)
    {
        if (!function_exists('imagecreate') || $barcodeArray === false) {
            return false;
        }

        // calculate image size
        $width = ($barcodeArray['maxw'] * $this->width);
        $codePartHeight = 12;
        $height = $this->height + ($this->barcodeText instanceof BarcodeText ? $codePartHeight : 0);

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

        if($this->barcodeText instanceof BarcodeText) {
            $code = $this->code ? $this->code : $barcodeArray['code'];
            if($this->barcodeText->getTextFormat() !== null) {
                $regex = $this->barcodeText->getTextFormat();
                $code = preg_replace($regex[0], $regex[1], $code);
            }

            imagettftext(
                $png,
                10,
                0,
                0,
                $height,
                imagecolorallocate($png, $this->barcodeText->getColor()[0], $this->barcodeText->getColor()[0], $this->barcodeText->getColor()[0]),
                $this->barcodeText->getTtfFontFile(),
                $code
            );
        }

        $filename = $this->path.'/'.md5($code).'.png';
        imagepng($png, $filename);
        imagedestroy($png);
        return $filename;
    }
}
 