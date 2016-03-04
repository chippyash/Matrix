<?php
namespace chippyash\Test\Matrix\Attribute;
use chippyash\Matrix\Attribute\IsColumnvector;
use chippyash\Matrix\Matrix;

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
                'chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsColumnvector::is()
     */
    public function testEmptyMatrixIsNotAColumnVector()
    {
        $mA = new Matrix(array());
        $this->assertFalse($this->object->is($mA));
    }
    /**
     * @covers chippyash\Matrix\Attribute\IsColumnvector::is()
     */
    public function testSingleItemMatrixIsNotAColumnVector()
    {
        $mA = new Matrix(array(1));
        $this->assertFalse($this->object->is($mA));
    }
    /**
     * @covers chippyash\Matrix\Attribute\IsColumnvector::is()
     */
    public function testRowVectorMatrixIsNotAColumnVector()
    {
        $mA = new Matrix(array(array(1,2,3)));
        $this->assertFalse($this->object->is($mA));
    }
    /**
     * @covers chippyash\Matrix\Attribute\IsColumnvector::is()
     */
    public function testColumnVectorMatrixIsAColumnVector()
    {
        $mA = new Matrix(array(array(1),array(2),array(3)));
        $this->assertTrue($this->object->is($mA));
    }
}
