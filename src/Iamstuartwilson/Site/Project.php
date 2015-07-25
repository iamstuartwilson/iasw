<?php

namespace Iamstuartwilson\Site;

class Project
{
    const FILE_DIR = '/../../../projects';

    /**
     * @var class MarkdownParser
     */
    protected $markdownParser;

    public function __construct()
    {
        $this->markdownParser = new MarkdownParser;
    }

    /**
     * Returns a project file by name
     *
     * @param string $name;
     *
     * return array
     */
    public function get($name)
    {
        $file = $this->getFile($name . '.md');

        if ($file) {
            return $this->markdownParser->parse($file, [
                'slug' => $name
            ]);
        }
    }

    /**
     * Returns all project files in the project dir
     *
     * return array
     */
    public function getAll()
    {
        return array_map(function($name) {
            return $this->get($name);
        }, $this->getAllFileNames());
    }

    /**
     * Returns a project file using file_get_contents
     *
     * @param string $name
     *
     * return bool|string
     */
    protected function getFile($name)
    {
        $filePath = $this->getDir() . '/' . $name;

        if (file_exists($filePath)) {
            return @file_get_contents($filePath);
        }

        return false;
    }

    /**
     * Returns all project fileNames in project dir
     *
     * return []string
     */
    protected function getAllFileNames()
    {
        $filteredFileNames = array_filter(scandir($this->getDir()), function($file) {
            return end(explode('.', $file)) === 'md' && strpos($file, 'WIP') === false;
        });

        return array_map(function($fileName) {
            return str_replace('.md', null, $fileName);
        }, $filteredFileNames);
    }

    /**
     * Returns the project file directory
     *
     * return string
     */
    protected function getDir()
    {
        return __DIR__ . self::FILE_DIR;
    }
}
