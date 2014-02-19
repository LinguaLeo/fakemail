<?php

namespace LinguaLeo\FakeMail\Model;

use Traversable;

class DirectoryIterator implements \IteratorAggregate
{
    protected $path;
    protected $type;
    protected $namePattern;
    protected $sort;

    private $fileList;
    private $fileListIterator;

    /**
     * @param string $path path to scan
     * @param string $type filter by type (can be f - file, d - directory, empty for both)
     * @param string $namePattern preg match patter
     * @param int $sort
     */
    public function __construct($path, $type = '', $namePattern = '.*', $sort = SORT_NATURAL)
    {
        $this->namePattern = $namePattern;
        $this->path = $path;
        $this->sort = $sort;
        $this->type = $type;

        $this->init();
    }

    public function init()
    {
        if (!is_dir($this->path)) {
            throw new \RuntimeException("Path {$this->path} is not a directory");
        }

        if ($this->sort == SORT_NATURAL) {
            $this->fileList = scandir($this->path);
        } else {
            $sort = ($this->sort == SORT_ASC) ? SCANDIR_SORT_ASCENDING : SCANDIR_SORT_DESCENDING;
            $this->fileList = scandir($this->path, $sort);
        }

        $this->fileList = array_filter(
            $this->fileList,
            function($file) {
                return preg_match("/{$this->namePattern}/", $file) && (empty($this->type) || $this->matchType($file));
            }
        );

        $this->fileList = array_map(function($file) { return $this->path . DIRECTORY_SEPARATOR . $file; }, $this->fileList);
    }

    public function matchType($file)
    {
        if ($this->type == 'f') {
            return is_file($this->path . DIRECTORY_SEPARATOR . $file);
        } elseif ($this->type == 'd') {
            return is_dir($this->path . DIRECTORY_SEPARATOR . $file);
        }

        return true;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        if (is_null($this->fileListIterator)) {
            $this->fileListIterator = new \ArrayIterator($this->fileList);;
        }
        return $this->fileListIterator;
    }
}