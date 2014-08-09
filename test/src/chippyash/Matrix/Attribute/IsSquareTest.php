<?php
namespace chippyash\Test\Matrix\Attribute;
use chippyash\Matrix\Attribute\IsSquare;
use chippyash\Matrix\Matrix;

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
                'chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSquare::is()
     */
    public function testEmptyMatrixReturnsTrue()
    {
        $mA = new Matrix([]);
        $this->assertTrue($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSquare::is()
     */
    public function testSingleItemMatrixReturnsTrue()
    {
        $mA = new Matrix([1]);
        $this->assertTrue($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSquare::is()
     */
    public function testIncompleteMatrixReturnsFalse()
    {
        $mA = new Matrix([[1, 2], [1]]);
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSquare::is()
     */
    public function testSquareMatrixReturnsTrue()
    {
        $mA = new Matrix([[1, 2], [2, 1]]);
        $this->asserttrue($this->object->is($mA));
    }

}
