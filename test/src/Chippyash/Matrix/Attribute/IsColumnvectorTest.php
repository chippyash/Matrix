<?php
namespace Chippyash\Test\Matrix\Attribute;
use Chippyash\Matrix\Attribute\IsColumnvector;
use Chippyash\Matrix\Matrix;

/**
 */
class IsColumnvectorTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new IsColumnvector();
    }

    public function testSutHasAttributeInterface()
    {
        $this->assertInstanceOf(
                'Chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    public function testEmptyMatrixIsNotAColumnVector()
    {
        $mA = new Matrix(array());
        $this->assertFalse($this->object->is($mA));
    }

    public function testSingleItemMatrixIsNotAColumnVector()
    {
        $mA = new Matrix(array(1));
        $this->assertFalse($this->object->is($mA));
    }

    public function testRowVectorMatrixIsNotAColumnVector()
    {
        $mA = new Matrix(array(array(1,2,3)));
        $this->assertFalse($this->object->is($mA));
    }

    public function testColumnVectorMatrixIsAColumnVector()
    {
        $mA = new Matrix(array(array(1),array(2),array(3)));
        $this->assertTrue($this->object->is($mA));
    }
}
