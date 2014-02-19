<?php
namespace LinguaLeo\FakeMail;

use LinguaLeo\FakeMail\Provider\FileScannerServiceProvider;
use LinguaLeo\FakeMail\Provider\MailFactoryServiceProvider;
use LinguaLeo\FakeMail\Traits\FileScannerTrait;
use LinguaLeo\FakeMail\Traits\MailFactoryTrait;
use Silex\Application\TwigTrait;
use Silex\Provider\TwigServiceProvider;

class Application extends \Silex\Application
{
    use FileScannerTrait;
    use MailFactoryTrait;
    use TwigTrait;

    public function __construct(array $values = [])
    {
        if (
            !isset($values['mail.directory'])
            || !file_exists($values['mail.directory'])
            || !is_dir($values['mail.directory'])
        ) {
            throw new \RuntimeException('mail.directory option requires valid directory path');
        }

        parent::__construct($values);
        $this->initServices();
    }

    protected function initServices()
    {
        $this->register(new FileScannerServiceProvider());
        $this->register(new MailFactoryServiceProvider());
        $this->register(new TwigServiceProvider(), array(
                'twig.path' => __DIR__.'/../../../view'
            )
        );
    }
} 