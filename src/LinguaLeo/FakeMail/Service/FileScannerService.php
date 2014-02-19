<?php
namespace LinguaLeo\FakeMail\Service;

use LinguaLeo\FakeMail\Model\DirectoryIterator;

class FileScannerService
{
    protected $baseDir;

    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function getDirectoryList()
    {
        return new DirectoryIterator($this->baseDir, 'd', '^\d{4}-\d{2}-\d{2}$', SORT_DESC);
    }

    /**
     * @param string $dir subdirectory name in base directory. Do not use full path!
     * @return DirectoryIterator
     */
    public function getFileList($dir)
    {
        return new DirectoryIterator(
            $this->baseDir . DIRECTORY_SEPARATOR . $dir,
            'f', '^letter-\d{4}-\d{2}-\d{2}-\d{2}-\d{2}-\d{2}-\d+-\d+\.txt$',
            SORT_DESC
        );
    }

    public function getFullFilePath($dirname, $filename)
    {
        return $this->baseDir . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR . $filename . '.txt';
    }
} 