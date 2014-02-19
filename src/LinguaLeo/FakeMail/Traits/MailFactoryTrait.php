<?php

namespace LinguaLeo\FakeMail\Traits;


trait MailFactoryTrait {

    /**
     * @return \LinguaLeo\FakeMail\Service\MailFactoryService
     */
    public function getMailFactoryService()
    {
        return $this['mail.factory'];
    }

} 