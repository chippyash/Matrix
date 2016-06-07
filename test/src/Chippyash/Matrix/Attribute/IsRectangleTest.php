<?php
namespace Chippyash\Test\Matrix\Attribute;
use Chippyash\Matrix\Attribute\IsRectangle;
use Chippyash\Matrix\Matrix;

/**
 */
class IsRectangleTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new IsRectangle();
    }

    public function testSutHasAttributeInterface()
    {
        $this->assertInstanceOf(
                'Chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    public function testEmptyMatrixIsNotARectangle()
    {
        $mA = new Matrix(array());
        $this->assertFalse($this->object->is($mA));
    }

    public function testSingleItemMatrixIsNotARectangle()
    {
        $mA = new Matrix(array(1));
        $this->assertFalse($this->object->is($mA));
    }

    public function testRowVectorMatrixIsNotARectangle()
    {
        $mA = new Matrix(array(array(1,2,3)));
        $this->assertFalse($this->object->is($mA));
    }

    public function testColumnVectorMatrixIsNotARectangle()
    {
        $mA = new Matrix(array(array(1),array(2),array(3)));
        $this->assertFalse($this->object->is($mA));
    }

    public function testSquareMatrixIsNotARectangle()
    {
        $mA = new Matrix(array(array(1,2,3),array(1,2,3),array(1,2,3)));
        $this->assertFalse($this->object->is($mA));
    }

    public function testWideRectangleMatrixIsARectangle()
    {
        $mA = new Matrix(array(array(1,2,3),array(1,2,3)));
        $this->assertTrue($this->object->is($mA));
    }

    public function testLongRectangleMatrixIsARectangle()
    {
        $mA = new Matrix(array(array(1,2,3),array(1,2,3),array(1,2,3),array(1,2,3)));
        $this->assertTrue($this->object->is($mA));
    }
}
