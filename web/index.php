<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LinguaLeo\FakeMail\Application;

$dir = getenv('FAKEMAIL_DIR');

$app = new Application([
    'mail.directory' => $dir ?: __DIR__ . '/../data/mail',
    'debug' => true
]);

$app->get('/', 'controller.inbox:indexAction');
$app->get('/{dirname}', 'controller.inbox:directoryAction');
$app->get('/{dirname}/{filename}', 'controller.inbox:mailAction');

$app->run();