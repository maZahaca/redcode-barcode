<?php

namespace RedCode\Barcode;

/**
 * @author maZahaca
 */ 
class Barcode2D extends BarcodeWrapper
{
    public function __construct()
    {
        parent::__construct(new \TCPDF2DBarcode('', false));
    }
}
 