<?php

namespace KamranAhmed\Shorthand;

use Exception;

/**
 * Class Shorthand
 *
 * @package KamranAhmed\Shorthand
 */
class Shorthand
{
    /**
     * @var array
     */
    private $words = [];

    /**
     * Shorthand constructor.
     *
     * @param array $words
     */
    public function __construct($words = [])
    {
        $this->setWords($words);
    }

    /**
     * @param $words
     */
    public function setWords($words)
    {
        $this->words = !is_array($words) ? [$words] : $words;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function generate()
    {
        if (empty($this->words)) {
            throw new Exception('Word(s) are required to generate shorthands');
        }

        // sort them lexicographically, so that they're $next to their nearest kin
        $words = $this->sortWordsLexico($this->words);

        $shorthands = [];
        $previous   = '';

        foreach ($words as $counter => $current) {

            // Get the next word
            $next = isset($words[$counter + 1]) ? $words[$counter + 1] : "";

            // Two matching words found, we cannot make any unique shorthands out of this one
            if ($current === $next) {
                continue;
            }

            // Get the index at which current word differs from the next and previous words
            $diffPoint = $this->getDiffPoint($current, $next, $previous);

            $previous = $current;

            // End of the current word has already been reached, just put the whole word
            // in the shorthands and continue as it means there was no difference
            // between the current word and the next/previous words
            if ($diffPoint === strlen($current)) {
                $shorthands[$current] = $current;

                continue;
            }

            // Generate the shorthands by creating substring from the diff point to the end
            while ($diffPoint <= strlen($current)) {
                $shorthand              = substr($current, 0, $diffPoint);
                $shorthands[$shorthand] = $current;

                $diffPoint++;
            }
        }

        return $shorthands;
    }

    /**
     * Gets the point at which current word differs from the next and previous words
     *
     * @param $current
     * @param $next
     * @param $previous
     *
     * @return int
     */
    protected function getDiffPoint($current, $next, $previous)
    {
        $nextCharMatches = true;
        $prevCharMatches = true;

        $currentLength = strlen($current);

        // Iterate through each character of the current word
        // and find the point where it differs from the previous and next word
        for ($diffPoint = 0; $diffPoint < $currentLength; $diffPoint++) {

            $currChar = $current[$diffPoint];
            $nextChar = !empty($next[$diffPoint]) ? $next[$diffPoint] : '';
            $prevChar = !empty($previous[$diffPoint]) ? $previous[$diffPoint] : '';

            $nextCharMatches = $nextCharMatches && $currChar === $nextChar;
            $prevCharMatches = $prevCharMatches && $currChar === $prevChar;

            // If neither of the next and previous word characters match,
            // we have found ourselves the point at which both the words differ
            if (!$nextCharMatches && !$prevCharMatches) {
                $diffPoint++;

                break;
            }
        }

        return $diffPoint;
    }

    /**
     * Sorts the words lexicographically in order to bring the words closer to their kin
     *
     * @param $words
     *
     * @return array
     */
    protected function sortWordsLexico($words)
    {
        usort($words, function ($a, $b) {
            if ($a === $b) {
                return 0;
            }

            return $a > $b ? 1 : -1;
        });

        return $words;
    }
}
