<?php
/**
 * Matrix
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @license BSD 3 Clause See LICENSE.md
 */

namespace Chippyash\Test\Matrix\Attribute;

use Chippyash\Matrix\Attribute\IsVector;
use Chippyash\Matrix\Matrix;

class IsVectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System Under Test
     * @var IsVector
     */
    protected $sut;

    protected function setUp()
    {
        $this->sut = new IsVector();
    }

    public function testIsVectorIsARowVectorOrAColumnVector()
    {
        $rVector = new Matrix(['a', 'b', 'c']);
        $cVector = new Matrix([
            ['a'],
            ['b'],
            ['c']
        ]);

        $this->assertTrue($this->sut->is($rVector));
        $this->assertTrue($this->sut->is($cVector));
    }

    public function testIsVectorIsFalseIfParameterIsNotAVector()
    {
        $rMatrix = new Matrix([
            ['a', 'b', 'c'],
            ['d', 'e', 'f']
        ]);
        $this->assertFalse($this->sut->is($rMatrix));
        $this->assertFalse($this->sut->is($rMatrix('Transpose')));
    }
}
