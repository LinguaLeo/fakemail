<?php
namespace LinguaLeo\FakeMail\Service;

use LinguaLeo\FakeMail\Model\EmailMessage;

class MailFactoryService
{
    protected $parser;

    public function __construct()
    {
        $this->parser = new \ezcMailParser();
    }

    public function getParsedMailFromFile($filePath)
    {
        return $this->getParsedMail(file_get_contents($filePath));
    }

    public function getParsedMail($text)
    {
        $mailSource = new \ezcMailVariableSet($text);
        $mailList = $this->parser->parseMail($mailSource);

        if (empty($mailList)) {
            throw new \RuntimeException('parse error');
        }

        $mail = reset($mailList);
        return new EmailMessage($mail, $text);
    }
} 