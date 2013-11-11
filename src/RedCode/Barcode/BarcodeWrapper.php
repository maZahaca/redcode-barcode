<?php

namespace RedCode\Barcode;
use RedCode\Barcode\Formatter\IBarcodeFormatter;

/**
 * @author maZahaca
 */ 
abstract class BarcodeWrapper
{
    private static $instance;

    public function __construct($instance)
    {
        if(!($instance instanceof \TCPDF2DBarcode) || !($instance instanceof \TCPDFBarcode)) {
            throw new \LogicException('');
        }
        self::$instance = $instance;
    }

    /**
     * Set the barcode.
     * @param $code (string) code to print
     * @param $type (string) type of barcode: <ul><li>DATAMATRIX : Datamatrix (ISO/IEC 16022)</li><li>PDF417 : PDF417 (ISO/IEC 15438:2006)</li><li>PDF417,a,e,t,s,f,o0,o1,o2,o3,o4,o5,o6 : PDF417 with parameters: a = aspect ratio (width/height); e = error correction level (0-8); t = total number of macro segments; s = macro segment index (0-99998); f = file ID; o0 = File Name (text); o1 = Segment Count (numeric); o2 = Time Stamp (numeric); o3 = Sender (text); o4 = Addressee (text); o5 = File Size (numeric); o6 = Checksum (numeric). NOTES: Parameters t, s and f are required for a Macro Control Block, all other parametrs are optional. To use a comma character ',' on text options, replace it with the character 255: "\xff".</li><li>QRCODE : QRcode Low error correction</li><li>QRCODE,L : QRcode Low error correction</li><li>QRCODE,M : QRcode Medium error correction</li><li>QRCODE,Q : QRcode Better error correction</li><li>QRCODE,H : QR-CODE Best error correction</li><li>RAW: raw mode - comma-separad list of array rows</li><li>RAW2: raw mode - array rows are surrounded by square parenthesis.</li><li>TEST : Test matrix</li></ul>
     * @throws \LogicException
     */
    protected function setBarcode($code, $type)
    {
        self::$instance->setBarcode($code, $type);
    }

    /**
     * @param $code
     * @param $type
     * @param IBarcodeFormatter $formatter
     * @return bool|string formatted data
     */
    public function getBarcodeData($code, $type, IBarcodeFormatter $formatter)
    {
        $this->setBarcode($code, $type);
        $data = self::$instance->getBarcodeArray();
        if($data === false) {
            return false;
        }
        return $formatter->format(self::$instance->getBarcodeArray());
    }
}
 