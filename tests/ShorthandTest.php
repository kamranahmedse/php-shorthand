<?php

namespace KamranAhmed\Shorthand;

use PHPUnit_Framework_TestCase;

/**
 * Class ShorthandTest
 *
 * @package KamranAhmed\Shorthand
 */
class ShorthandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shorthand
     */
    protected $shorthand;

    public function setUp()
    {
        parent::setUp();

        $this->shorthand = new Shorthand();
    }

    /**
     * @dataProvider shorthandsProvider
     *
     * @param $words
     * @param $expectedShorthands
     */
    public function testCanGenerateShorthands($words, $expectedShorthands)
    {
        $this->shorthand->setWords($words);
        $shorthands = $this->shorthand->generate();

        $this->assertTrue(empty(array_diff_assoc($shorthands, $expectedShorthands)));
    }

    /**
     * @expectedException \Exception
     */
    public function testThrowsExceptionForEmptyWords()
    {
        $this->shorthand->setWords([]);
        $this->shorthand->generate();
    }

    /**
     * @return array
     */
    public function shorthandsProvider()
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
                ['crore', 'create', 'crop'],
                [
                    'cror'   => 'crore',
                    'crore'  => 'crore',
                    'cre'    => 'create',
                    'crea'   => 'create',
                    'creat'  => 'create',
                    'create' => 'create',
                    'crop'   => 'crop',
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
