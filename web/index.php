<?php
use LinguaLeo\FakeMail\Application;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application([
    'mail.directory' => '/home/aobukhov/repos/aobukhov-fakemail/data/mail',
    'debug' => true
]);

$app->get('/', function () use ($app) {
        $dirs = [];
        foreach($app->getFileScannerService()->getDirectoryList() as $dirName) {
            $dirs[basename($dirName)] = $dirName;
        }

        return '<pre>' . print_r($dirs, true) . '</pre>';
    }
);


$app->get('/{dirname}', function ($dirname) use ($app) {
        $dirs = [];
        foreach($app->getFileScannerService()->getFileList($dirname) as $fileName) {
            $dirs[pathinfo($fileName)['filename']] = $fileName;
        }

        return '<pre>' . print_r($dirs, true) . '</pre>';
    }
);


$app->get('/{dirname}/{filename}', function ($dirname, $filename) use ($app) {

        $mail = $app->getMailFactoryService()->getParsedMailFromFile(
            $app->getFileScannerService()->getFullFilePath($dirname, $filename . '.txt')
        );
        return $mail->getHTMLBody();
    }
);




$app->run();