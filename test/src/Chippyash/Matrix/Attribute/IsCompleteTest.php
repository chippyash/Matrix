<?php
namespace Chippyash\Test\Matrix\Attribute;
use Chippyash\Matrix\Attribute\IsComplete;
use Chippyash\Matrix\Matrix;

/**
 */
class IsCompleteTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new IsComplete();
    }

    public function testSutHasAttributeInterface()
    {
        $this->assertInstanceOf(
                'Chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    /**
     * @dataProvider completeArrays
     */
    public function testCompleteMatricesReturnTrue($arr)
    {
        $mA = new Matrix($arr);
        $this->assertTrue($this->object->is($mA));
    }

    /**
     *
     * @return array [[testArray], ...]
     */
    public function completeArrays()
    {
        return [
            [[]],        //shorthand empty array
            [[[]]],      //longhand empty array
            [[1]],       //shorthand single vertice array
            [[[1]]],     //longhand single vertice array
            [[[1, 2], [2, 1]]], //even number array
            [[[1, 2, 3], [3, 2, 1], [2, 1, 3]]], //odd number array
        ];
    }

    /**
     * @dataProvider nonCompleteArrays
     */
    public function testIncompleteMatricesReturnFalse($arr)
    {
        $mA = new Matrix($arr);
        $this->assertFalse($this->object->is($mA));
    }

    /**
     *
     * @return array [[testArray], ...]
     */
    public function nonCompleteArrays()
    {
        return [
            [[[1], [2, 1]]], //2nd row invalid
            [[[1, 2], [2]]], //2nd row invalid
            [[[1, 2, 3], [], [3, 2, 1]]], //2nd row invalid - is empty
            [[[1, 2, 3], [3, 2, 1], [2, 1]]], //3rd row invalid
        ];
    }

    public function testMatricesWithMissingRowsReturnFalse()
    {
        $arr = [[1],[2],[3]];
        unset($arr[1]); //remove second row
        $mA = new Matrix($arr);
        $this->assertFalse($this->object->is($mA));
    }

    public function testCanGetRowErrorNumberIfMatrixIsInError()
    {
        $arr = [[1],[2],[3]];
        unset($arr[1]); //remove second row
        $mA = new Matrix($arr);
        $this->assertFalse($this->object->is($mA));
        $this->assertEquals(2, $this->object->getErrRow());
    }

    public function testGetErrRowReturnsNullIfMatrixIsComplete()
    {
        $mA = new Matrix([]);
        $this->object->is($mA);
        $this->assertNull($this->object->getErrRow());
    }
}
