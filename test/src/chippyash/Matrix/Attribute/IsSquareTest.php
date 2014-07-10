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
    public function testEmptyMatrixReturnsFalse()
    {
        $mA = new Matrix(array());
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSquare::is()
     */
    public function testSingleItemMatrixReturnsFalse()
    {
        $mA = new Matrix(array(1));
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSquare::is()
     */
    public function testIncompleteMatrixReturnsFalse()
    {
        $mA = new Matrix(array(array(1, 2), array(1)));
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSquare::is()
     */
    public function testSquareMatrixReturnsTrue()
    {
        $mA = new Matrix(array(array(1, 2), array(2,1)));
        $this->asserttrue($this->object->is($mA));
    }

}
