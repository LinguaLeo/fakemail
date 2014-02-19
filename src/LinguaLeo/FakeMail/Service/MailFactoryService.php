<?php
namespace LinguaLeo\FakeMail\Service;

use PlancakeEmailParser;

class MailFactoryService
{
    public function getParsedMailFromFile($filePath)
    {
        return $this->getParsedMail(file_get_contents($filePath));
    }

    public function getParsedMail($text)
    {
        return  new PlancakeEmailParser($text);
    }
} 