<?php
namespace LinguaLeo\FakeMail\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

class InboxController
{
    /** @var  \LinguaLeo\FakeMail\Service\FileScannerService */
    protected $fileScannerService;
    /** @var  \LinguaLeo\FakeMail\Service\MailFactoryService */
    protected $mailFactoryService;
    /** @var  \Twig_Environment */
    protected $twig;

    public function __construct($fileScannerService, $mailFactoryService, $twig)
    {
        $this->fileScannerService = $fileScannerService;
        $this->mailFactoryService = $mailFactoryService;
        $this->twig = $twig;
    }


    public function indexAction()
    {
        $dirs = $this->getFormattedDirectoryList();

        if (empty($dirs)) {
            throw new \RuntimeException('Mail directory is empty');
        }

        list($url, $fullPath) = each($dirs);

        return new RedirectResponse($url);
    }

    public function directoryAction($dirname)
    {
        $dirs = $this->getFormattedDirectoryList($dirname);
        $files = $this->getFormattedFileList($dirname);

        return $this->twig->render('layout.twig', ['dirs' => $dirs, 'files' => $files]);
    }


    public function mailAction($dirname, $filename)
    {
        $dirs = $this->getFormattedDirectoryList($dirname);
        $files = $this->getFormattedFileList($dirname, $filename);
        $mail = $this->getFromattedMail($dirname, $filename);

        return $this->twig->render('email.twig', ['dirs' => $dirs, 'files' => $files, 'mail' => $mail]);

    }

    /**
     * @param $dirname
     * @return array
     */
    private function getFormattedDirectoryList($dirname)
    {
        $dirs = [];
        foreach ($this->fileScannerService->getDirectoryList() as $dirName) {
            $dirs[] = [
                'link' => '/' . basename($dirName),
                'text' => basename($dirName),
                'selected' => ($dirname == basename($dirName))
            ];
        }
        return $dirs;
    }

    /**
     * @param $dirname
     * @param string|null $currentFilename
     * @return array
     */
    private function getFormattedFileList($dirname, $currentFilename = null)
    {
        $files = [];
        foreach ($this->fileScannerService->getFileList($dirname) as $fileName) {
            $mail = $this->mailFactoryService->getParsedMailFromFile($fileName);
            $files[] = [
                'link' => '/' . $dirname . '/' . pathinfo($fileName)['filename'],
                'selected' => $currentFilename == pathinfo($fileName)['filename'],
                'avatar' => '/img/common/avatar.png',
                'mail' => [
                    'to' => $mail->getTo(),
                    'subject' => $mail->getSubject(),
                    'body' => $mail->getShortBody()
                ]
            ];
        }
        return $files;
    }

    /**
     * @param $dirname
     * @param $filename
     * @return \PlancakeEmailParser
     */
    private function getFromattedMail($dirname, $filename)
    {
        $mail = $this->mailFactoryService->getParsedMailFromFile(
            $this->fileScannerService->getFullFilePath($dirname, $filename)
        );

        return [
            'to' => $mail->getTo(),
            'subject' => $mail->getSubject(),
            'HTMLBody' => $mail->getHTMLBody(),
            'text' => $mail->getPlainBody(),
            'source' => $mail->getSource()
        ];
    }

}