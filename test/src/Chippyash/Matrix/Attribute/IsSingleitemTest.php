<?php
namespace Chippyash\Test\Matrix\Attribute;
use Chippyash\Matrix\Attribute\IsSingleitem;
use Chippyash\Matrix\Matrix;

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
                'Chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    public function testEmptyMatrixReturnsFalse()
    {
        $mA = new Matrix(array());
        $this->assertFalse($this->object->is($mA));
    }

    public function testRowVectorMatrixReturnsFalse()
    {
        $mA = new Matrix(array(array(1,2,3)));
        $this->assertFalse($this->object->is($mA));
    }

    public function testColumnVectorMatrixReturnsFalse()
    {
        $mA = new Matrix(array(array(1),array(2),array(3)));
        $this->assertFalse($this->object->is($mA));
    }

    public function testSquareMatrixGreaterThanOneVerticeMatrixReturnsFalse()
    {
        $mA = new Matrix(array(1,2),array(1,2));
        $this->assertFalse($this->object->is($mA));
    }

    public function testSingleItemMatrixReturnsTrue()
    {
        $mA = new Matrix(array(1));
        $this->assertTrue($this->object->is($mA));
        $mB = new Matrix(array(array(1)));
        $this->assertTrue($this->object->is($mB));
    }

}
