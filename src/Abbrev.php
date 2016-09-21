<?php

namespace KamranAhmed\Abbrev;

use Exception;

/**
 * Class Abbrev
 *
 * @package KamranAhmed\Abbrev
 */
class Abbrev
{
    /**
     * @var array
     */
    private $words = [];

    /**
     * Abbrev constructor.
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
            throw new Exception('Words are required to generate abbreviations');
        }

        // sort them lexicographically, so that they're $next to their nearest kin
        $words = $this->sortWordsLexico($this->words);

        $abbrevs  = [];
        $previous = '';

        foreach ($words as $counter => $current) {

            // Get the next word
            $next = isset($words[$counter + 1]) ? $words[$counter + 1] : "";

            // Two matching words found, we cannot make any
            // unique abbreviations out of this one
            if ($current === $next) {
                continue;
            }

            // Get the index at which current word differs from the next and previous words
            $diffPoint = $this->getDiffPoint($current, $next, $previous);

            $previous = $current;

            // End of the current word has already been reached, just put the whole word
            // in the abbreviations and continue as it means there was no difference
            // between the current word and the next/previous words
            if ($diffPoint === strlen($current)) {
                $abbrevs[$current] = $current;

                continue;
            }

            // Keep generating the abbreviations by creating a substring from the diffing
            // point to the end i.e. if the diff was found at `cr` in the word `crore`, then
            // generate `cro`, `cror` and `crore`
            while ($diffPoint <= strlen($current)) {
                $abbrev           = substr($current, 0, $diffPoint);
                $abbrevs[$abbrev] = $current;

                $diffPoint++;
            }
        }

        return $abbrevs;
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

            $nextCharMatches = $nextCharMatches && $currChar === $next[$diffPoint];
            $prevCharMatches = $prevCharMatches && $currChar === $previous[$diffPoint];

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
