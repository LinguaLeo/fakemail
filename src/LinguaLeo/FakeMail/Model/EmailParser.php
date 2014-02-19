<?php

namespace LinguaLeo\FakeMail\Model;


class EmailParser extends \PlancakeEmailParser
{
    protected $source;

    public function __construct($source)
    {
        $this->source = $source;
        parent::__construct($source);
    }

    public function getSubject()
    {
        return @parent::getSubject();
    }

    public function getSource()
    {
        return $this->source;
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