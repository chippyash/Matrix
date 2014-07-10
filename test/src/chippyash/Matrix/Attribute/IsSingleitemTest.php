<?php
namespace chippyash\Test\Matrix\Attribute;
use chippyash\Matrix\Attribute\IsSingleitem;
use chippyash\Matrix\Matrix;

/**
 */
class IsSingleitemTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new IsSingleitem();
    }

    public function testSutHasAttributeInterface()
    {
        $this->assertInstanceOf(
                'chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSingleitem::is()
     */
    public function testEmptyMatrixReturnsFalse()
    {
        $mA = new Matrix(array());
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSingleitem::is()
     */
    public function testRowVectorMatrixReturnsFalse()
    {
        $mA = new Matrix(array(array(1,2,3)));
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSingleitem::is()
     */
    public function testColumnVectorMatrixReturnsFalse()
    {
        $mA = new Matrix(array(array(1),array(2),array(3)));
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSingleitem::is()
     */
    public function testSquareMatrixGreaterThanOneVerticeMatrixReturnsFalse()
    {
        $mA = new Matrix(array(1,2),array(1,2));
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsSingleitem::is()
     */
    public function testSingleItemMatrixReturnsTrue()
    {
        $mA = new Matrix(array(1));
        $this->assertTrue($this->object->is($mA));
        $mB = new Matrix(array(array(1)));
        $this->assertTrue($this->object->is($mB));
    }

}
