<?php

namespace RedCode\Barcode;

/**
 * @author maZahaca
 */ 
class Barcode1D extends BarcodeWrapper
{
    public function __construct()
    {
        parent::__construct(new \TCPDFBarcode('', false));
    }
}
 