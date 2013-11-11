<?php

namespace RedCode\Barcode;
use RedCode\Barcode\Formatter\Png1DFormatter;
use RedCode\Barcode\Formatter\Png2DFormatter;

/**
 * @author maZahaca
 */ 
class Barcode
{
    private $barcode1d;
    private $barcode2d;

    public function __construct()
    {
        $this->barcode1d = new Barcode1D();
        $this->barcode2d = new Barcode2D();
    }

    /**
     * Get png Barcode
     * @param $code
     * @param $type
     * @param $width
     * @param $height
     * @param $color
     * @return bool|string return saved filepath or false if failure
     */
    public function getPng($code, $type, $width, $height, $color)
    {
        $result = $this->barcode1d->getBarcodeData($code, $type, (new Png1DFormatter())->setParams($width, $height, $color));
        if($result !== false)
            return $result;

        $result = $this->barcode2d->getBarcodeData($code, $type, (new Png2DFormatter())->setParams($width, $height, $color));
        return $result;
    }


}
 