<?php
use LinguaLeo\FakeMail\Application;

require_once __DIR__.'/../vendor/autoload.php';

$dir = getenv('FAKEMAIL_DIR');

$app = new Application([
    'mail.directory' => $dir ? $dir : __DIR__ . '/../data/mail',
    'debug' => true
]);

$app->get('/', 'controller.inbox:indexAction');
$app->get('/{dirname}', 'controller.inbox:directoryAction');
$app->get('/{dirname}/{filename}', 'controller.inbox:mailAction');

$app->run();