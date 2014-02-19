<?php
namespace LinguaLeo\FakeMail\Service;

use LinguaLeo\FakeMail\Model\EmailParser;

class MailFactoryService
{
    public function getParsedMailFromFile($filePath)
    {
        return $this->getParsedMail(file_get_contents($filePath));
    }

    public function getParsedMail($text)
    {
        return new EmailParser($text);
    }
} 