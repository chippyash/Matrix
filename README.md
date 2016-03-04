# chippyash/Matrix

## Quality Assurance

Certified for PHP 5.4 - 5.6

[![Build Status](https://travis-ci.org/chippyash/Matrix.svg?branch=master)](https://travis-ci.org/chippyash/Matrix)
[![Coverage Status](https://coveralls.io/repos/chippyash/Matrix/badge.png)](https://coveralls.io/r/chippyash/Matrix)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b8a7e3f8-d33a-435f-a0e7-a4fdfb2e8318/mini.png)](https://insight.sensiolabs.com/projects/b8a7e3f8-d33a-435f-a0e7-a4fdfb2e8318)

[Test Contract](https://github.com/chippyash/matrix/blob/master/docs/Test-Contract.md) in the docs directory.

## What?

This library aims to provide matrix transformation functionality given that:

*  Everything has a test case
*  It's PHP 5.4+

The matrix  supplied in this library is a generic one. It treats a matrix as a
data structure giving the ability to create matrices and carry out transformations.

The library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

## Why?

I finally got round, after too may years, to investigate
[TDD](http://en.wikipedia.org/wiki/Test-driven_development) as a serious methodology.
Always interested in something a bit maths related, I thought that having a go at
matrices would brush up on old forgotten things and provide a bit of entertainment.
So this library is as much about using TDD as it is about matrices.  The bonus for
taking the TDD approach is that as I've (re)learnt something about matrices,
I've been able to refactor in safety.

## When

The current library covers basic matrix manipulation.  The library will cover most
well known generic matrix transformations and derivatives.

If you want more, either suggest it, or better still, fork it and provide a pull request.

Check out [chippyash/Logical-Matrix](https://github.com/chippyash/Logical-matrix) for logical matrix operations

Check out [chippyash/Math-Matrix](https://github.com/chippyash/Math-Matrix) for mathematical matrix operations

Check out [chippyash/Strong-Type](https://github.com/chippyashl/Strong-Type) for strong type including numeric,
rational and complex type support

Check out [chippyash/Math-Type-Calculator](https://github.com/chippyash/Math-Type-Calculator) for arithmetic operations on aforementioned strong types

## How

### Coding Basics

In PHP terms a matrix is an array of arrays, 2 dimensional i.e

-  [[]]


A shortcut for a single item matrix is to supply a single array

<pre>
    use Chippyash/Matrix/Matrix;

    $mA = new Matrix([]);  //empty matrix
    $mA = new Matrix([[]]);  //empty matrix
    $mA = new Matrix([1]);  //single item matrix
</pre>

As with any TDD application, the tests tell you everything you need to know about
the SUT.  Read them!  However for the short of temper amongst us, the salient
points are:

A basic Matrix type is supplied

*  Matrix(array $source, bool $complete = false, bool $normalize= false, bool $normalizeDefault = null)

Matrices are 1 based, not 0 (zero) based

The following methods on a matrix are supported:

*  toArray() : array - return matrix data as an array
*  rows(): int - number of rows (n) in the matrix
*  columns(): int - number of columns (m) in the matrix
*  vertices(): int - number of entries in matrix (== n * m)
*  get(int $row > 0, int $col > 0): mixed - return single entry from matrix.
*  is(string $attribute): boolean - see attributes below
*  test(string $attribute): boolean - Raw form of is() method. You can use this to test for attributes
   not supplied with the library by passing in $attribute conforming to AttributeInterface
*  transform(TransformationInterface $transformation, $extra = null): Matrix - see transformations below
*  setFormatter(FormatterInterface $formatter): fluent - set a display formatter
*  display(): mixed -  Return the matrix in some displayable format
*  equality(Matrix $mB, boolean $strict = true): boolean - Is the matrix equal to matrix mB?
     * mA->rows() == mB->rows()
     * mA->columns() == mB->columns()
     * mA->get(i,j) ==\[=\] mB->get(i,j)
     If strict then type and value checked else only equivalence of value

#### Matrices are immutable

No operation on a matrix will change the internal structure of the matrix.  Any
transformation or similar will return another matrix, leaving the original alone.
This allows for arithmetic stability.

#### Matrices have attributes

*  Attributes always return a boolean.
*  Attributes implement the Chippyash\Matrix\Interfaces\AttributeInterface
*  You can use the is() method of a Matrix to test for an attribute
<pre>
    if ($mA->is('square')) {}
    //is the same as
    $attr = new Matrix/Attribute/IsSquare();
    if ($attr($mA) {}
</pre>

Attributes supported:

*  IsColumnvector() - Is the matrix a column vector?
*  IsComplete() - Does the matrix have all its entries present?
*  IsDiagonal() - Are only entries on the main diagonal non-zero?
*  IsEmpty() - Is the matrix an empty one?
*  IsRectangle() - Is matrix non-empty and non-square?
*  IsRowVector() - Is the matrix a row vector?
*  IsSquare() - Is the matrix square? i.e. n == m & n >= 0


#### Matrices can be transformed

*  Transformation always returns a Matrix
*  The original matrix is untouched
*  You can use the magic __invoke functionality
*  Transformations implement the Chippyash\Matrix\Interfaces\TransformationInterface

<pre>
    $mB = $mA("Transpose");
    //same as :
    $comp = new Matrix\Transformation\Transpose;
    $mB = $comp($mA);
    //or
    $mB = $mA->transform($comp);
</pre>

Transformations supported:

*  Cofactor - return the cofactor matrix of a vertice
*  Colreduce - return matrix reduced by 1+ columns
*  Colslice - return a slice (1+) of the matrix columns
*  Concatenate - return matrix with extra matrix appended to the right
*  Diagonal - reduce a matrix to its diagonal elements substituting non diagonal entries with zero
*  MFunction - apply a function to every entry in the matrix
*  Reflect - reflect matrix on X plane, Y plane, y=x plane and through origin
*  Rotate - rotate matrix through 90, 180 or 270 degrees
*  Rowreduce - return matrix reduced by 1+ rows
*  Rowslice - return a slice (1+) of matrix rows
*  Stack - return matrix stacked on top of extra matrix
*  Transpose - return matrix with rows and columns swapped around the diagonal


#### The magic invoke methods allow you to write in a functional way

For example (taken from Transformation\Cofactor):

<pre>
        $fC = new Colreduce();
        $fR = new Rowreduce();
        //R(C(mA))
        return $fR($fC($mA,[$col]),[$row]);
</pre>

or this (from Transformation\Colreduce):

<pre>

        $fT = new Transpose();
        $fR = new Rowreduce();

        return $fT($fR($fT($mA), [$col, $numCols]));
</pre>

#### Matrices can be output for display

You can supply a formatter to create output via the display() method. The library
currently has an Ascii formatter.  To use it

<pre>
    use Chippyash\Matrix\Formatter\Ascii;
    use Chippyash\Matrix\Matrix;

    $mA = new Matrix([[1,2,3],['a','b','c'],[true, false, 'foo']]);
    echo $mA->setFormatter(new Asciii())->display();
</pre>

*  Formatters implement the Chippyash\Matrix\Interfaces\FormatterInterface
*  The Matrix::display() method accepts an optional array of options that are passed to the formatter
*  Formatters are not limited to string output. You could for instance, write a formatter to output an SVG file

#### You can debug a Matrix

If you find something weird happening, utilise the Debug trait to dump out the
matrix to screen using the Ascii formatter.

### Changing the library

1.  fork it
2.  write the test
3.  amend it
4.  do a pull request

Found a bug you can't figure out?

1.  fork it
2.  write the test
3.  do a pull request

NB. Make sure you rebase to HEAD before your pull request

## Where?

The library is hosted at [Github](https://github.com/chippyash/Matrix). It is
available at [Packagist.org](https://packagist.org/packages/chippyash/matrix)

### Installation

Install [Composer](https://getcomposer.org/)

#### For production

add

<pre>
    "chippyash/matrix": "~2"
</pre>

to your composer.json "requires" section

#### For development

Clone this repo, and then run Composer in local repo root to pull in dependencies

<pre>
    git clone git@github.com:chippyash/Matrix.git Matrix
    cd Matrix
    composer update
</pre>

To run the tests:

<pre>
    cd Matrix
    vendor/bin/phpunit -c test/phpunit.xml test/
</pre>

## History

V1.0.0 Original release

V1.0.1 Minor bug fixes

V1.1.0 New transformations

*  Concatenate
*  Stack
*  Rotate

V1.1.1 Code analysis conformance

V1.1.2 Update readme

V1.2.0 New transformation

* Reflect

V1.2.1 Code analysis conformance

V1.2.2 Fix Ascii formatter to work with descendent matrices

V1.2.3 Fix transformations to work with descendent matrices

V1.2.4 Amend IsSquare attribute test to accept empty matrix as square

    Update documentation

V1.2.5 Add equality() method

V1.2.6 Add ability to set the formatter on Debug trait

V1.2.7 Add ability to set the formatter options for debug

V1.2.8 update phpunit to ~V4.3.0

V2.0.0 BC Break: change chippyash\Matrix namespace to Chippyash\Matrix
