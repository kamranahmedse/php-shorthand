<?php

namespace KamranAhmed\Abbrev;

use PHPUnit_Framework_TestCase;

/**
 * Class AbbrevTest
 *
 * @package KamranAhmed\Abbrev
 */
class AbbrevTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Abbrev
     */
    protected $abbrev;

    public function setUp()
    {
        parent::setUp();

        $this->abbrev = new Abbrev();
    }

    /**
     * @dataProvider abbreviationsProvider
     *
     * @param $words
     * @param $expectedAbbrevs
     */
    public function testCanGenerateAbbreviations($words, $expectedAbbrevs)
    {
        $this->abbrev->setWords($words);
        $abbrevs = $this->abbrev->generate();

        $this->assertTrue(empty(array_diff_assoc($abbrevs, $expectedAbbrevs)));
    }

    /**
     * @expectedException \Exception
     */
    public function testThrowsExceptionForEmptyWords()
    {
        $this->abbrev->setWords([]);
        $abbrevs = $this->abbrev->generate();
    }

    /**
     * @return array
     */
    public function abbreviationsProvider()
    {
        return [
            [
                ['create', 'crore'],
                [
                    'cre'    => 'create',
                    'crea'   => 'create',
                    'creat'  => 'create',
                    'create' => 'create',
                    'cro'    => 'crore',
                    'cror'   => 'crore',
                    'crore'  => 'crore',
                ],
            ],
            [
                ['create', 'crore', 'create', 'crore'],
                [
                    'cre'    => 'create',
                    'crea'   => 'create',
                    'creat'  => 'create',
                    'create' => 'create',
                    'cro'    => 'crore',
                    'cror'   => 'crore',
                    'crore'  => 'crore',
                ],
            ],
            [
                ['ruby', 'rules'],
                [
                    'rub'   => 'ruby',
                    'ruby'  => 'ruby',
                    'rul'   => 'rules',
                    'rule'  => 'rules',
                    'rules' => 'rules',
                ],
            ],
            [
                'ruby',
                [
                    'r'    => 'ruby',
                    'ru'   => 'ruby',
                    'rub'  => 'ruby',
                    'ruby' => 'ruby',
                ],
            ],
        ];
    }
}
