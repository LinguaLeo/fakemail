<?php

namespace LinguaLeo\FakeMail\Traits;

trait FileScannerTrait
{
    /**
     * @return \LinguaLeo\FakeMail\Service\FileScannerService
     */
    public function getFileScannerService()
    {
        return $this['fileScanner'];
    }

} 