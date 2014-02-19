<?php

namespace LinguaLeo\FakeMail\Model;


class EmailMessage
{
    protected $originalMailObject;
    protected $sourceCode;
    protected $text;
    protected $html;

    public function __construct(\ezcMail $originalMailObject, $sourceCode = '')
    {
        $this->sourceCode = $sourceCode;
        $this->originalMailObject = $originalMailObject;

        $body = $originalMailObject->body;

        if ($body instanceof \ezcMailMultipartAlternative) {
            /** @var  \ezcMailMultipartAlternative $bodyParts */
            $bodyParts = $body->getParts();
        } elseif($body instanceof \ezcMailText)  {
            $bodyParts = [$originalMailObject->body];
        } else {
            throw new \RuntimeException('Unexpected type of body ' . get_class($originalMailObject->body));
        }

        foreach ($bodyParts as $part) {
            switch($part->subType) {
                case 'html':
                    $this->html = $part->text;
                    break;
                case 'plain':
                    $this->text = $part->text;
                    break;
            }
        };

    }

    public function getSubject()
    {
        return $this->originalMailObject->subject;
    }

    public function getHTMLBody()
    {
        return $this->html;
    }

    public function getPlainBody()
    {
        return $this->text;
    }

    public function getTo()
    {
        return $this->originalMailObject->to;
    }

    public function getSourceCode()
    {
        return $this->sourceCode;
    }

    public function getFrom()
    {
        return $this->originalMailObject->from;
    }

    public function getCc()
    {
        return $this->originalMailObject->cc;
    }

    public function getShortBody($length = 100)
    {

        $body = preg_replace('/[^\w\s:\(\),\.?!]/u', '', $this->getPlainBody());
        $body = preg_replace('/\s+/', ' ', $body);

        if (mb_strlen($body) > $length) {
            $body = mb_substr($body, 0, $length) . '&hellip;';
        }

        return $body;
    }
} 