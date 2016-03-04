<?php

namespace Chippyash\Test\Matrix\Vector;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Vector\Vector2D;
use Chippyash\Matrix\Vector\VectorSet;

/**
 * Unit test for VectorSet Class
 */
class VectorSetTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var vector
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new VectorSet();
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     */
    public function testFromMatrixWithNonMatrixWillThrowException()
    {
        $this->object->fromMatrix('foo');
    }

    public function testFromMatrixWithNonMatrixWillReturnVector2d()
    {
        $this->assertInstanceOf(
                'Chippyash\Matrix\Vector\VectorSet',
                $this->object->fromMatrix(new Matrix([[1,2]])));
    }

    public function testVectorSetHasAsManyEntriesAsSuppliedMatrix()
    {
        $this->object->fromMatrix(new Matrix([[1,2]]));
        $this->assertEquals(2, $this->object->count());
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\VectorException
     * @expectedExceptionMessage Vector exception: Append value is not a vector
     */
    public function testAppendOnlyAcceptsVector2dParameters()
    {
        $this->object->append('foo');
    }

    public function testToMatrixWithRebaseReturnsAMatrix()
    {
        $test = new Matrix([[1,2]]);
        $this->object->fromMatrix($test);
        $this->assertEquals($test, $this->object->toMatrix());
    }

    public function testToMatrixWithNoRebaseReturnsAMatrix()
    {
        $test = new Matrix([[1,2]]);
        $this->object->fromMatrix($test);
        $this->assertEquals($test, $this->object->toMatrix(false));
    }

    public function testTranslateWillEventuallyReturnAMatrix()
    {
        $mA = new Matrix([[1,2],[3,4]]);
        
        $f = function($x, $y, $v){return [$x+1, $y+1, $v+1];};
        $vS = $this->object->fromMatrix($mA)->translate($f);

        $rebasedM = $vS->toMatrix();
        $this->assertEquals([[2,3],[4,5]], $rebasedM->toArray());

        $notRebasedM = $vS->toMatrix(false);
        $this->assertEquals([1=>[1=>2,2=>3],2=>[1=>4,2=>5]], $notRebasedM->toArray());
    }
}
