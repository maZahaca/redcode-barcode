<?php

namespace RedCode\Barcode;

use RedCode\Barcode\Formatter\IBarcodeFormatter;
use RedCode\Barcode\Formatter\IBarcodeStore;
use RedCode\Barcode\Formatter\Png1DFormatter;
use RedCode\Barcode\Formatter\Png2DFormatter;
use RedCode\Barcode\Text\BarcodeText;

/**
 * @author maZahaca
 */ 
class Barcode
{
    private $barcode1d;
    private $barcode2d;

    private $filePath = null;

    public function __construct($filePath = null)
    {
        $this->barcode1d = new Barcode1D();
        $this->barcode2d = new Barcode2D();
        if(!$filePath) {
            $filePath = \sys_get_temp_dir();
        }
        $this->filePath  = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Get png Barcode
     * @param $code
     * @param $type
     * @param $width
     * @param $height
     * @param array $color
     * @param null|BarcodeText $barcodeText
     * @return bool|string return saved filepath or false if failure
     */
    public function getPng($code, $type, $width, $height, $color = array(0,0,0), $barcodeText = null)
    {
        $result = $this->barcode1d->getBarcodeData($code, $type, (new Png1DFormatter())->setRenderParams($width, $height, $color)->setBarCodeText($barcodeText)->setPath($this->filePath)->setCode($code));
        if($result !== false)
            return $result;

        $result = $this->barcode2d->getBarcodeData($code, $type, (new Png2DFormatter())->setRenderParams($width, $height, $color)->setPath($this->filePath));
        return $result;
    }

    /**
     * Get bar code in custom format
     * @param $code
     * @param $type
     * @param IBarcodeFormatter $formatter
     * @return bool|string
     */
    public function getCode($code, $type, IBarcodeFormatter $formatter)
    {
        $formatter->setPath($this->filePath);
        if($formatter instanceof IBarcodeStore) {
            $formatter->setCode($code);
        }

        $result = $this->barcode1d->getBarcodeData($code, $type, $formatter);
        if($result !== false)
            return $result;

        $result = $this->barcode2d->getBarcodeData($code, $type, $formatter);
        return $result;
    }
}
 