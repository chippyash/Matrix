<?php

namespace Chippyash\Test\Matrix;

use Chippyash\Matrix\Matrix;

/**
 * Unit test for Matrix Class
 */
class MatrixTest extends \PHPUnit_Framework_TestCase
{

    const NSUT = 'Chippyash\Matrix\Matrix';

    /**
     * @var Matrix
     */
    protected $object;

    public function testConstructEmptyArrayGivesEmptyMatrix()
    {
        $this->object = new Matrix(array());
        $this->assertInstanceOf(self::NSUT, $this->object);
        $this->assertTrue($this->object->is('empty'));
    }

    public function testConstructNonEmptyArrayGivesNonEmptyMatrix()
    {
        $this->object = new Matrix(array(2));
        $this->assertInstanceOf(self::NSUT, $this->object);
        $this->assertFalse($this->object->is('empty'));
    }

    public function testConstructSingleItemArrayGivesSingleItemMatrix()
    {
        $test = array(1);
        $expected = array($test);

        $this->object = new Matrix($test);
        $this->assertEquals($expected, $this->object->toArray());
    }

    /**
     * @dataProvider completeArrays
     */
    public function testConstructEnforcingCompletenessWithGoodArraysGivesMatrix($testArray)
    {
        $mA = new Matrix($testArray, true);
        $this->assertInstanceOf(self::NSUT, $mA);
    }

    /**
     *
     * @return array [[testArray], ...]
     */
    public function completeArrays()
    {
        return array(
            array(array()), //shorthand empty array
            array(array(array())), //longhand empty array
            array(array(1)), //shorthand single vertice array
            array(array(array(1))), //longhand single vertice array
            array(array(array(1, 2), array(2, 1))), //even number array
            array(array(array(1.12, 2, 3), array(3, 2, 1), array(2, 1, 3))), //odd number array
        );
    }

    /**
     * @dataProvider nonCompleteArrays
     */
    public function testConstructEnforcingCompletenessWithNonCompleteArraysRaisesException($testArray, $invalidRow)
    {
        $this->setExpectedException(
                'Chippyash\Matrix\Exceptions\NotCompleteMatrixException', sprintf('Matrix is not complete in row %d', $invalidRow));
        $this->object = new Matrix($testArray, true);
    }

    /**
     *
     * @return array [[testArray], ...]
     */
    public function nonCompleteArrays()
    {
        return array(
            array(array(array(1), array(2, 1)), 1), //2nd row invalid
            array(array(array(1, 2), array(2)), 1), //2nd row invalid
            array(array(array(1, 2, 3), array(), array(3, 2, 1)), 1), //2nd row invalid
            array(array(array(1, 2, 3), array(3, 2, 1), array(2, 1)), 2), //3rd row invalid
        );
    }

    /**
     * @dataProvider nonCompleteArraysForNormalization
     */
    public function testConstructForcingNormalizationNoCompletenessGivesNormalizedMatrix($testArray, $expectedArray)
    {
        $this->object = new Matrix($testArray, false, true, false);
        $this->assertEquals($expectedArray, $this->object->toArray());
    }

    /**
     * @dataProvider nonCompleteArraysForNormalization
     */
    public function testConstructForcingNormalizationNoCompletenessPassesCompleteTest($testArray, $expectedArray)
    {
        $this->object = new Matrix($testArray, false, true);
        $this->assertTrue($this->object->is('complete'));
    }

    /**
     *
     * @return array [[$testArray, $expectedArray],...]
     */
    public function nonCompleteArraysForNormalization()
    {
        return array(
            array(array(), array(array())), //empty array
            array(array(2), array(array(2))), //single vertice
            array(array(array(2, 1), array(2)), array(array(2, 1), array(2, null))), //missing X2.Y2
            array(array(array(2), array(2, 1)), array(array(2, null), array(2, 1))), //missing X1.Y2
            array(array(array(), array(2, 1)), array(array(null, null), array(2, 1))), //missing X1.Y1, X1.Y2
            array(array(array(2, 1), array()), array(array(2, 1), array(null, null))), //missing X2.Y1, X2.Y2
        );
    }

    /**
     * @dataProvider incompleteArrays
     */
    public function testConstructNotForcingNormalizationNoCompletenessFailsCompleteTest($testArray)
    {
        $this->object = new Matrix($testArray, false, false, null, false);
        $this->assertFalse($this->object->is('complete'));
    }

    /**
     *
     * @return array [[$testArray],...]
     */
    public function incompleteArrays()
    {
        return array(
            array(array(array(2, 1), array(2))), //missing X2.Y2
            array(array(array(2), array(2, 1))), //missing X1.Y2
            array(array(array(), array(2, 1))), //missing X1.Y1, X1.Y2
            array(array(array(2, 1), array())), //missing X2.Y1, X2.Y2
        );
    }

    /**
     * @dataProvider nonCompleteArraysForNormalizationWithUserData
     */
    public function testConstructForcingNormalizationWithUserDataNotCompleteGivesNormalizedMatrix($testArray, $expectedArray)
    {
        $this->object = new Matrix($testArray, false, true, 'foo', false);
        $this->assertEquals($expectedArray, $this->object->toArray());
    }

    /**
     * @return array [[$testArray, $expectedArray],...]
     */
    public function nonCompleteArraysForNormalizationWithUserData()
    {
        return array(
            array(array(), array(array())), //empty array
            array(array(2), array(array(2))), //single vertice
            array(array(array(2, 1), array(2)), array(array(2, 1), array(2, 'foo'))), //missing X2.Y2
            array(array(array(2), array(2, 1)), array(array(2, 'foo'), array(2, 1))), //missing X1.Y2
            array(array(array(), array(2, 1)), array(array('foo', 'foo'), array(2, 1))), //missing X1.Y1, X1.Y2
            array(array(array(2, 1), array()), array(array(2, 1), array('foo', 'foo'))), //missing X2.Y1, X2.Y2
        );
    }

    /**
     * @dataProvider matrixDimensions
     */
    public function testConstructNonCompleteMatrixWithVariousArraysGivesCorrectDimensions($array, $columns, $rows, $vertices)
    {
        $this->object = new Matrix($array);
        $this->assertEquals($rows, $this->object->rows());
        $this->assertEquals($columns, $this->object->columns());
        $this->assertEquals($vertices, $this->object->vertices());
    }

    /**
     * Test Data
     * @return array [[testArray, numColumns, numRows, numVertices], ...]
     */
    public function matrixDimensions()
    {
        return array(
            array(array(), 0, 0, 0), //empty matrix has no rows or columns
            array(array(1), 1, 1, 1), //shorthand single vertice construction
            array(array(array(1)), 1, 1, 1), //longhand  single vertice construction
            array(array(array(1, 2)), 2, 1, 2), //2 col, 1 row
            array(array(array(1, 2), array(2, 1)), 2, 2, 4), //2 col, 2 row
            array(array(array(1, 2), array()), 2, 2, 4), //2 col, 2 row - but missing second row data
            array(array(array(), array(2, 1)), 0, 2, 0), //2 col, 2 row - but missing first row data
        );
    }

    public function testConstructWithMatrixParamReturnsMatrixDataClone()
    {
        $testData = [['foo',false],[1,15.2]];
        $mA = new Matrix($testData);
        $mB = new Matrix($mA);
        $this->assertEquals($mA, $mB);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'row' is out of bounds with value: 0
     */
    public function testMatrixGetVerifiesOneBasedMatrixForRow()
    {
        $this->object = new Matrix(array(array(1, 2, 3), array(3, 2, 1), array(2, 1, 3)));
        $this->object->get(0, 1);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'col' is out of bounds with value: 0
     */
    public function testMatrixGetVerifiesOneBasedMatrixForColumn()
    {
        $this->object = new Matrix(array(array(1, 2, 3), array(3, 2, 1), array(2, 1, 3)));
        $this->object->get(1, 0);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'row' is out of bounds with value: 4
     */
    public function testMatrixGetVerifiesUpperBoundaryOfMatrixForRow()
    {
        $this->object = new Matrix(array(array(1, 2, 3), array(3, 2, 1), array(2, 1, 3)));
        $this->object->get(4, 1);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'col' is out of bounds with value: 4
     */
    public function testMatrixGetVerifiesUpperBoundaryOfMatrixForColumn()
    {
        $this->object = new Matrix(array(array(1, 2, 3), array(3, 2, 1), array(2, 1, 3)));
        $this->object->get(1, 4);
    }

    public function testMatrixGetErrorsIfVerticeNotFound()
    {
        $this->object = new Matrix(array(array(1, 2, 3), array(), array()));
        for ($c = 1; $c < 4; $c++) {
            for ($r = 2; $r < 4; $r++) {
                $this->setExpectedException(
                        'Chippyash\Matrix\Exceptions\VerticeNotFoundException', "Vertice R({$r}),C({$c}) is not found in the matrix");
                $this->object->get($r, $c);
            }
        }
    }

    public function testMatrixGetReturnsCorrectValue()
    {
        $testArray = array(array(1, 2, 3), array(0, 2, 1), array(2.5, 1, 3));
        $this->object = new Matrix($testArray);
        for ($r = 1; $r < 4; $r++) {
            for ($c = 1; $c < 4; $c++) {
                $this->assertEquals($testArray[$r - 1][$c - 1], $this->object->get($r, $c));
            }
        }
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\FormatterNotSetException
     * @expectedExceptionMessage Formatter not set
     */
    public function testDisplayThrowsExceptionIfNoFormatterSet()
    {
        $mA = new Matrix(array());
        $mA->display();
    }

    public function testDisplayReturnsOutputIfFormatterSet()
    {
        $mA = new Matrix(array());
        $formatter = $this->getMock("\Chippyash\Matrix\Interfaces\FormatterInterface");
        $formatter->expects($this->once())
                ->method('format')
                ->will($this->returnValue('foo'));
        $mA->setFormatter($formatter);
        $this->assertEquals('foo', $mA->display());
    }

    public function testDisplayAcceptsOptionsArray()
    {
        $mA = new Matrix(array());
        $formatter = $this->getMock("\Chippyash\Matrix\Interfaces\FormatterInterface");
        $formatter->expects($this->once())
                ->method('format')
                ->will($this->returnValue('foo'));
        $mA->setFormatter($formatter);
        $this->assertEquals('foo', $mA->display(array()));
    }

    public function testDisplayRequiresOptionsToBeArray()
    {
        if (PHP_MAJOR_VERSION < 7) {
            $this->setExpectedException('PHPUnit_Framework_Error');
            $mA = new Matrix(array());
            $formatter = $this->getMock("\Chippyash\Matrix\Interfaces\FormatterInterface");
            $mA->setFormatter($formatter);
            $this->assertEquals('foo', $mA->display('foo'));
        } else {
            $this->markTestSkipped('Test incompatible with PHP 7');
        }
        
    }

    public function testIsMethodAcceptsKnownAttributeName()
    {
        $mA = new Matrix(array());
        $this->assertInternalType('boolean', $mA->is('empty'));
    }

    public function testIsMethodReturnsFalseForUnknownAttributeName()
    {
        $mA = new Matrix(array());
        $this->assertFalse($mA->is('foobar'));
    }

    public function testIsMethodAcceptsAttributeInterfaceAsParameter()
    {
        $mA = new Matrix(array());
        $attr = $this->getMock('\Chippyash\Matrix\Interfaces\AttributeInterface');
        $attr->expects($this->once())
                ->method('is')
                ->will($this->returnValue(true));
        $this->assertTrue($mA->is($attr));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\NotAnAttributeInterfaceException
     */
    public function testTestMethodThrowsExceptionIfAttributeIsNotInterface()
    {
        $mA = new Matrix(array());
        $mA->test(new \stdClass());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testTestMethodThrowsExceptionIfParamAsClassCannotBeFound()
    {
        $mA = new Matrix(array());
        $mA->test('foobar');
    }

    public function testTransformRequiresTransformationInterface()
    {
        if (PHP_MAJOR_VERSION < 7) {
            $this->setExpectedException('PHPUnit_Framework_Error');
            $mA = new Matrix([]);
            $mA->transform();    
        }  else {
            $this->markTestSkipped('Test incompatible with PHP 7');
        }
    }

    public function testTransformWithTransformationInterfaceThrowsNoException()
    {
        $mA = new Matrix([]);
        $t = $this->getMock('Chippyash\Matrix\Interfaces\TransformationInterface');
        $t->expects($this->once())
                ->method('transform')
                ->will($this->returnValue($mA));

        $this->assertEquals($mA, $mA->transform($t));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvokeWithBadComputationNameThrowsException()
    {
        $mA = new Matrix(array());
        $mA('foobar');
    }

    public function testInvokeWithOneParamProxiesToTransform()
    {
        $testArray = array(array(1, 2), array(3, 4));
        $expectedArray = array(array(1, 3), array(2, 4));
        $object = new Matrix($testArray);
        $this->assertEquals($expectedArray, $object("Transpose")->toArray());
    }

    public function testInvokeWithTwoParamsProxiesToTransform()
    {
        $testArray = array(array(1, 2), array(3, 4));
        $expectedArray = array(array(1, 3), array(2, 4));
        $object = new Matrix($testArray);
        //Transpose will ignore the second argument
        $this->assertEquals($expectedArray, $object("Transpose", 'foo')->toArray());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid number of arguments to invoke method
     */
    public function testInvokeWithNoParamsThrowsException()
    {
        $mA = new Matrix([]);
        $mA();
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid number of arguments to invoke method
     */
    public function testInvokeMoreThanTwoNoParamsThrowsException()
    {
        $mA = new Matrix([]);
        $mA('foo','bar','baz');
    }

    /**
     * mA == mB iff
     * - mA->rows() == mB->rows()
     * - mA->columns() == mB->columns()
     * - mA->get(i,j) === mB->get(i,j)
     */
    public function testEqualityWithStrictCheckingReturnsTrueIfEqualityRulesAreMatched()
    {
        $mA = new Matrix([2]);
        $mB = new Matrix([2]);
        $this->assertTrue($mA->equality($mB));

        $mC = new Matrix([['foo'],['bar'],['baz']]);
        $mD = new Matrix([['foo'],['bar'],['baz']]);
        $this->assertTrue($mC->equality($mD));

        $mE = new Matrix([['foo','bar','baz']]);
        $mF = new Matrix([['foo','bar','baz']]);
        $this->assertTrue($mE->equality($mF));
    }

    public function testEqualityWithStrictCheckingReturnsFalseIfEqualityRulesAreNotMatched()
    {
        $mA = new Matrix([2]);
        $mB = new Matrix(['foo']);
        $this->assertFalse($mA->equality($mB));

        $mC = new Matrix([['foo'],['bar'],['baz']]);
        $mD = new Matrix([['foo','bar','baz']]);
        $this->assertFalse($mC->equality($mD));

        $mE = new Matrix([['foo','bar','baz']]);
        $mF = new Matrix([['foo'],['bar'],['baz']]);
        $this->assertFalse($mE->equality($mF));

        $mG = new Matrix([2]);
        $mH = new Matrix([2.6]);
        $this->assertFalse($mG->equality($mH));

        $mI = new Matrix([['foo','bar','baz']]);
        $mJ = new Matrix([['foo','bar']]);
        $this->assertFalse($mI->equality($mJ));
    }

    /**
     * mA == mB iff
     * - mA->rows() == mB->rows()
     * - mA->columns() == mB->columns()
     * - mA->get(i,j) == mB->get(i,j)
     */
    public function testEqualityWithLooseCheckingReturnsTrueIfEqualityRulesAreMatched()
    {
        $mA = new Matrix([2]);
        $mB = new Matrix([2.0]);
        $this->assertTrue($mA->equality($mB, false));

        $mC = new Matrix([[123],[456],[789]]);
        $mD = new Matrix([['123'],['456'],['789']]);
        $this->assertTrue($mC->equality($mD, false));
    }

    public function testEqualityWithLooseCheckingReturnsFalseIfEqualityRulesAreNotMatched()
    {
        $mA = new Matrix([2]);
        $mB = new Matrix([3.6]);
        $this->assertFalse($mA->equality($mB, false));

        $mC = new Matrix([[1234],[456],[789]]);
        $mD = new Matrix([['123'],['456'],['789']]);
        $this->assertFalse($mC->equality($mD), false);
    }


}
