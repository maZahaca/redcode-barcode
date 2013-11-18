<?php

namespace RedCode\Barcode\Text;

/**
 * @author maZahaca
 */ 
class BarcodeText
{
    private $ttfFontFile;
    private $textFormat;
    private $color = array(0, 0, 0);

    public function __construct($ttfFontFile, $textFormat = null, $color = array(0, 0, 0))
    {
        $this->ttfFontFile  = $ttfFontFile;
        $this->textFormat   = $textFormat;
        $this->color        = $color;
    }

    /**
     * @return mixed
     */
    public function getTextFormat()
    {
        return $this->textFormat;
    }

    /**
     * @return mixed
     */
    public function getTtfFontFile()
    {
        return $this->ttfFontFile;
    }

    /**
     * @return array
     */
    public function getColor()
    {
        return $this->color;
    }
}
 