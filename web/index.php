<?php
use LinguaLeo\FakeMail\Application;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application([
    'mail.directory' => '/home/aobukhov/repos/aobukhov-fakemail/data/mail',
    'debug' => true
]);

$app->get('/', 'controller.inbox:indexAction');
$app->get('/{dirname}', 'controller.inbox:directoryAction');
$app->get('/{dirname}/{filename}', 'controller.inbox:mailAction');

$app->run();