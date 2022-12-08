<?php
/**
 * Base module container for extending and testing general functionality across Magento 2.
 *
 * @package   Iods\Base
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2022, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Base\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use Magento\Framework\ObjectManagerInterface;

/**
 * Class File
 * @package Iods\Base\Helper
 */
class File extends AbstractHelper
{
    /** @var DirectoryList */
    protected DirectoryList $_directory_list;

    /** @var FileDriver */
    protected FileDriver $_file;

    /** @var Log */
    protected Log $_log;

    /** @var ObjectManagerInterface */
    protected ObjectManagerInterface $_objectManager;


    public function __construct(
        Context $context,
        DirectoryList $directory_list,
        FileDriver $file,
        Log $log,
        ObjectManagerInterface $object_manager
    ) {
        parent::__construct($context, $object_manager);
        $this->_directory_list = $directory_list;
        $this->_file = $file;
        $this->_log = $log;
    }


    /**
     * Returns an array of file names from a provided directory list, matching a specific file type.
     * @param $path
     * @param $ext
     * @return array
     * @throws FileSystemException
     */
    public function getFiles($path = null, $ext = null): array
    {
        $files = [];
        $dir = $this->getRootPath() . $path;
        $dir_contents = $this->_file->readDirectory($dir);

        array_walk($dir_contents, function ($file) use (&$files, &$ext) {
            $this->_checksFile($files, $file, $ext);
        });

        return $files;
    }


    /**
     * Returns a directory listing, including webroot, formatted as a string.
     * @param $path
     * @return string
     */
    public function getDirectory($path = null): string
    {
        return $this->getRootPath() . "/" . $path;
    }

    public function getContents($path = '', $file = ''): string
    {
        return $this->_file->fileGetContents($this->getFilePath($path, $file));
    }


    /**
     * Returns a path for a provided file and directory listing, as a formatted string.
     * @param $path
     * @param $file
     * @return string
     */
    public function getFilePath($path = null, $file = null): string
    {
        // return $path . "/" . $file;
        return "$path/$file";
    }

    /**
     * Returns a files size (in XX) after checking if it exists or not.
     * @param $file
     * @return int|mixed
     * @throws FileSystemException
     */
    public function getFileSize($file = null): mixed
    {
        return $this->isFileExists($file) ? $this->_file->stat($file)['size'] : 0;
    }


    /**
     * Returns a file's extension type, as a string.
     * @param $file
     * @return string
     */
    public function getFileType($file = null): string
    {
        return substr(strchr($file, '.'), 1);
    }


    /**
     * Returns a path for a provided file and directory listing, adding webroot, as a formatted string.
     * @param $path
     * @param $file
     * @return string
     */
    public function getFilePathWithRoot($path = null, $file = null): string
    {
        return $this->getRootPath() . "/$path/$file";
    }


    /**
     * Returns a directory listing of webroot.
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->_directory_list->getRoot();
    }


    /**
     * Returns true after a file has been removed from a provided path.
     * @param $path
     * @return bool
     * @throws FileSystemException
     */
    public function delete($path = null): bool
    {
        return $this->_file->deleteFile($path);
    }


    /**
     * Returns true or false if a file exists or not, using Magento isExists() and isFile() methods.
     * @param $path
     * @return bool
     * @throws FileSystemException
     */
    public function isFileExists($path = null): bool
    {
        return $this->_file->isExists($path) && $this->_file->isFile($path);
    }


    /**
     * Adds a file to the $files[] array if it's file type matches the extension provided.
     * @param array $files
     * @param null $file
     * @param null $ext
     * @return void
     */
    protected function _checksFile(array &$files = [], $file = null, $ext = null): void
    {
        if ($this->getFileType($file) === $ext) {
            $files[] = $file;
        }
    }
}
