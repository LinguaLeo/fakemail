<?php
namespace LinguaLeo\FakeMail\Provider;


use LinguaLeo\FakeMail\Controller\InboxController;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['controller.inbox'] = $app->share(function() use ($app) {
                /** @var \LinguaLeo\FakeMail\Application $app */
                return new InboxController(
                    $app->getFileScannerService(),
                    $app->getMailFactoryService(),
                    $app['twig']
                );
            }
        );
    }

    public function boot(Application $app)
    {
    }
}