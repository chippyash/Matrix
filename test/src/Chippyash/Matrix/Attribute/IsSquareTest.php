<?php
namespace Chippyash\Test\Matrix\Attribute;
use Chippyash\Matrix\Attribute\IsSquare;
use Chippyash\Matrix\Matrix;

/**
 * A square matrix is a non empty, complete matrix with m>1, n>1, m==n
 */
class IsSquareTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new IsSquare();
    }

    public function testSutHasAttributeInterface()
    {
        $this->assertInstanceOf(
                'Chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    public function testEmptyMatrixReturnsTrue()
    {
        $mA = new Matrix([]);
        $this->assertTrue($this->object->is($mA));
    }

    public function testSingleItemMatrixReturnsTrue()
    {
        $mA = new Matrix([1]);
        $this->assertTrue($this->object->is($mA));
    }

    public function testIncompleteMatrixReturnsFalse()
    {
        $mA = new Matrix([[1, 2], [1]]);
        $this->assertFalse($this->object->is($mA));
    }

    public function testSquareMatrixReturnsTrue()
    {
        $mA = new Matrix([[1, 2], [2, 1]]);
        $this->asserttrue($this->object->is($mA));
    }

}
