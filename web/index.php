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
            $dirs['/' . basename($dirName)] = $dirName;
        }

        if (empty($dirs)) {
            throw new Exception('Mail directory is empty');
        }

        list($url, $fullPath) = each($dirs);

        return $app->redirect($url);
    }
);


$app->get('/{dirname}', function ($dirname) use ($app) {
        $dirs = [];
        foreach($app->getFileScannerService()->getDirectoryList() as $dirName) {
            $dirs[] = ['link' => '/' . basename($dirName), 'text' => basename($dirName)];
        }

        $files = [];
        foreach($app->getFileScannerService()->getFileList($dirname) as $fileName) {
            $mail = $app->getMailFactoryService()->getParsedMailFromFile($fileName);
            $files[] = [
                'link' => '/' . $dirname . '/' . pathinfo($fileName)['filename'],
                'mail' => [
                    'to' => $mail->getTo(),
                    'subject' => @$mail->getSubject(),
                    'body' => mb_substr(str_replace('*', '', $mail->getPlainBody()), 0, 100) . '&hellip;'
                ]
            ];
        }

        return $app->render('layout.twig', ['dirs' => $dirs, 'files' => $files]);
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