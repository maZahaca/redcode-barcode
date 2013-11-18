<?php

namespace RedCode\Barcode\Formatter;

/**
 * @author maZahaca
 */
interface IBarcodeFormatter
{
    public function format($barcodeArray);

    public function setRenderParams($width, $height, $color = array(0, 0, 0));

    public function setPath($path);
} 