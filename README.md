Examples
===========================

``` php
$barcode = new \RedCode\Barcode\Barcode();
$result = $barcode->getPng('10203971045828', 'I25', 2, 50);

$result = $barcode->getPng('10203971045828', 'DATAMATRIX', 3, 3);
```