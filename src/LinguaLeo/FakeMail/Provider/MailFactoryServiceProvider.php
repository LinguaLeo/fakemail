<?php
namespace LinguaLeo\FakeMail\Provider;


use LinguaLeo\FakeMail\Service\MailFactoryService;
use Silex\Application;

class MailFactoryServiceProvider implements \Silex\ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app['mail.factory'] = $app->share(function() {
               return new MailFactoryService();
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
    }
}