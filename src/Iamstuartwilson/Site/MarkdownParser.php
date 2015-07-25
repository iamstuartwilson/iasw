<?php

namespace Iamstuartwilson\Site;

use Parsedown;

class MarkdownParser
{
    /**
     * @var class Parsedown
     */
    protected $parsedown;

    /**
     * @var string
     */
    protected $commentRegex = '/{{+(.*?)}}/s';

    /**
     * @var string
     */
    protected $lineSeperator = "\n";

    /**
     * @var string
     */
    protected $paramSeperator = ':';

    function __construct()
    {
        $this->parsedown = new Parsedown();
    }

    /**
     * Returns markdown with comment data removed and placed into seperate property
     *
     * @param  string $text
     *
     * @param  array $extraData
     *
     * @return array
     */
    public function parse($text, $extraData = [])
    {
        $data = [];
        $cleanedText = $text;

        preg_match_all($this->commentRegex, $text, $matches);

        if ($matches) {
            // Get lines
            $lines = explode($this->lineSeperator, reset($matches[1]));
            // Clean lines
            $lines = array_filter($lines, function($line) {
                return ! empty($line);
            });

            // Pull out data from each line
            foreach ($lines as $line) {
                $lineData = array_map('trim', explode($this->paramSeperator, $line));

                if (count($lineData) > 1) {
                    $data[$lineData[0]] = implode($this->paramSeperator, array_slice($lineData, 1));
                }
            }

            // Remove data comment from rest fo text
            $cleanedText = preg_replace($this->commentRegex, null, $text);
        }

        return [
            'data' => array_merge($extraData, $data),
            'html' => $this->parsedown->text($cleanedText)
        ];
    }
}
