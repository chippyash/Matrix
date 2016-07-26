# Chippyash Matrix

## Chippyash\Test\Matrix\Attribute\IsColumnvector

*  Sut has attribute interface
*  Empty matrix is not a column vector
*  Single item matrix is not a column vector
*  Row vector matrix is not a column vector
*  Column vector matrix is a column vector

## Chippyash\Test\Matrix\Attribute\IsComplete

*  Sut has attribute interface
*  Complete matrices return true
*  Incomplete matrices return false
*  Matrices with missing rows return false
*  Can get row error number if matrix is in error
*  Get err row returns null if matrix is complete

## Chippyash\Test\Matrix\Attribute\IsDiagonal

*  Sut has attribute interface
*  Non complete diagonal matrix returns false
*  Non square matrix returns false
*  Diagonal matrix returns true
*  Non diagonal matrix returns false

## Chippyash\Test\Matrix\Attribute\IsEmpty

*  Sut has attribute interface
*  Empty matrix returns true
*  Non empty matrix returns false

## Chippyash\Test\Matrix\Attribute\IsRectangle

*  Sut has attribute interface
*  Empty matrix is not a rectangle
*  Single item matrix is not a rectangle
*  Row vector matrix is not a rectangle
*  Column vector matrix is not a rectangle
*  Square matrix is not a rectangle
*  Wide rectangle matrix is a rectangle
*  Long rectangle matrix is a rectangle

## Chippyash\Test\Matrix\Attribute\IsRowvector

*  Sut has attribute interface
*  Empty matrix is not a row vector
*  Single item matrix is not a row vector
*  Column vector matrix is not a row vector
*  Row vector matrix is a row vector

## Chippyash\Test\Matrix\Attribute\IsSingleitem

*  Sut has attribute interface
*  Empty matrix returns false
*  Row vector matrix returns false
*  Column vector matrix returns false
*  Square matrix greater than one vertice matrix returns false
*  Single item matrix returns true

## Chippyash\Test\Matrix\Attribute\IsSquare

*  Sut has attribute interface
*  Empty matrix returns true
*  Single item matrix returns true
*  Incomplete matrix returns false
*  Square matrix returns true

## Chippyash\Test\Matrix\Exceptions\Exceptions

*  Exceptions derived from matrix exception
*  Matrix exception derived from exception

## Chippyash\Test\Matrix\Formatter\Ascii

*  Construct gives formatter interface
*  Format empty matrix returns empty box
*  Format single item matrix returns single item box
*  Format boolean matrix returns matrix box
*  Format single row matrix returns single row box
*  Format single column matrix returns single column box
*  Format multi row matrix returns multi row box
*  Booleans get converted

## Chippyash\Test\Matrix\Matrix

*  Construct empty array gives empty matrix
*  Construct non empty array gives non empty matrix
*  Construct single item array gives single item matrix
*  Construct enforcing completeness with good arrays gives matrix
*  Construct enforcing completeness with non complete arrays raises exception
*  Construct forcing normalization no completeness gives normalized matrix
*  Construct forcing normalization no completeness passes complete test
*  Construct not forcing normalization no completeness fails complete test
*  Construct forcing normalization with user data not complete gives normalized matrix
*  Construct non complete matrix with various arrays gives correct dimensions
*  Construct with matrix param returns matrix data clone
*  Matrix get verifies one based matrix for row
*  Matrix get verifies one based matrix for column
*  Matrix get verifies upper boundary of matrix for row
*  Matrix get verifies upper boundary of matrix for column
*  Matrix get errors if vertice not found
*  Matrix get returns correct value
*  Display throws exception if no formatter set
*  Display returns output if formatter set
*  Display accepts options array
*  Display requires options to be array
*  Is method accepts known attribute name
*  Is method returns false for unknown attribute name
*  Is method accepts attribute interface as parameter
*  Test method throws exception if attribute is not interface
*  Test method throws exception if param as class cannot be found
*  Transform requires transformation interface
*  Transform with transformation interface throws no exception
*  Invoke with bad computation name throws exception
*  Invoke with one param proxies to transform
*  Invoke with two params proxies to transform
*  Invoke with no params throws exception
*  Invoke more than two no params throws exception
*  Equality with strict checking returns true if equality rules are matched
*  Equality with strict checking returns false if equality rules are not matched
*  Equality with loose checking returns true if equality rules are matched
*  Equality with loose checking returns false if equality rules are not matched

## Chippyash\Test\Matrix\Traits\AssertMatrixColumnsAreEqual

*  Equal columns returns class
*  Unequal columns throws exception
*  Unequal columns throws exception with user message

## Chippyash\Test\Matrix\Traits\AssertMatrixIsComplete

*  Complete matrix returns class
*  Incomplete matrix throws exception

## Chippyash\Test\Matrix\Traits\AssertMatrixIsNotEmpty

*  Not empty matrix returns class
*  Empty matrix throws exception
*  Empty matrix throws exception with user message

## Chippyash\Test\Matrix\Traits\AssertMatrixIsSquare

*  Square matrix returns class
*  Non square matrix throws exception
*  Non square matrix throws exception with user message

## Chippyash\Test\Matrix\Traits\AssertMatrixRowsAreEqual

*  Equal rows returns class
*  Unequal rows throws exception
*  Unequal rows throws exception with user message

## Chippyash\Test\Matrix\Traits\AssertParameterIsArray

*  Array param returns class
*  Not array param throws exception
*  Not array param throws exception with user message

## Chippyash\Test\Matrix\Traits\AssertParameterIsMatrix

*  Matrix param returns class
*  Not matrix param throws exception
*  Not matrix param throws exception with user message

## Chippyash\Test\Matrix\Traits\Debug

*  Array param returns string with debug switched on
*  Matrix param returns string with debug switched on
*  Array or matrix returns nothing with debug switch off
*  Set formatter returns object
*  Debug with invalid param throws exception

## Chippyash\Test\Matrix\Computation\AbstractTransformation

*  Invoke expects at least one argument
*  Invoke expects less than three arguments
*  Invoke can accept two arguments
*  Invoke proxies to compute
*  Descendent matrices are returned with correct class

## Chippyash\Test\Matrix\Transformation\Circshift

*  You can shift a single column to the right
*  You can shift a multiple columns to the right
*  You can shift a single column to the left
*  You can shift a multiple columns to the left
*  A null shift parameter will default to single right shift
*  Shifting an empty matrix will return an empty matrix
*  Shifting an single item matrix will return a clone of the matrix
*  A zero shift parameter will return a clone of the shifted matrix
*  Shifting a column vector will return a clone of the original vector

## Chippyash\Test\Matrix\Transformation\Cofactor

*  Empty matrix returns empty matrix
*  Transform throws exception if second operand not an array
*  Transform throws exception if second operand does not contain row and col indicator
*  Transform throws exception if row indicator less than one
*  Transform throws exception if row indicator greater than rows
*  Transform throws exception if col indicator less than one
*  Transform throws exception if col indicator greater than columns
*  Transform returns correct result

## Chippyash\Test\Matrix\Transformation\Colreduce

*  Empty matrix returns empty matrix
*  Transform throws exception if second operand not an array
*  Transform throws exception if second operand does not contain c ol indicator
*  Transform throws exception if col indicator less than one
*  Transform throws exception if col indicator greater than columns
*  Transform reduces by one column if numcols not given
*  Transform throws exception if numcols less than one
*  Transform throws exception if numcols plus col indicator greater than columns
*  Transform throws exception if first operand is incomplete matrix
*  Transform returns correct result

## Chippyash\Test\Matrix\Transformation\Colslice

*  Compute throws exception if second operand not an array
*  Compute throws exception if second operand does not contain c ol indicator
*  Compute throws exception if col indicator less than one
*  Compute throws exception if col indicator greater than columns
*  Compute returns one col if numcols not given
*  Compute throws exception if numcols less than one
*  Compute throws exception if numcols plus col indicator greater than columns
*  Compute throws exception if first operand is incomplete matrix
*  Empty matrix returns empty matrix
*  Compute returns correct result

## Chippyash\Test\Matrix\Transformation\Concatenate

*  Compute throws exception if second operand is not a matrix
*  Compute throws exception if matrices have different row count
*  Compute throws exception if first operand is incomplete matrix
*  Compute throws exception if second operand is incomplete matrix
*  Empty matrix returns empty matrix
*  Compute returns correct result

## Chippyash\Test\Matrix\Transformation\Diagonal

*  Compute throws exception matrix not complete
*  Empty matrix returns empty matrix
*  Compute returns correct result

## Chippyash\Test\Matrix\Transformation\MFunction

*  Compute throws exception if first operand is incomplete matrix
*  Empty matrix returns empty matrix
*  Second parameter to compute is not optional
*  Second parameter to compute must be callable
*  Compute returns correct result

## Chippyash\Test\Matrix\Transformation\Reflect

*  You must specify a reflection plane
*  Transform throws exception if first operand is incomplete matrix
*  Transform throws exception for unrecognized rotation type
*  Empty matrix returns empty matrix
*  Single item matrix returns identical matrix
*  Can reflect on x plane
*  Can reflect on y plane
*  Can reflect through origin
*  Can reflect y equal x plane

## Chippyash\Test\Matrix\Transformation\Rotate

*  Transform throws exception if first operand is incomplete matrix
*  Transform throws exception for unrecognized rotation type
*  Empty matrix returns empty matrix
*  Single item matrix returns identical matrix
*  Rotate square matrix will rotate counter clockwise
*  Rotate row vector returns column vector counter clockwise
*  Rotate square matrix will rotate clockwise
*  Rotate square matrix will rotate one eighty degrees
*  Rotate row matrix will rotate
*  Rotate col matrix will rotate
*  Combined rotations compute correctly

## Chippyash\Test\Matrix\Transformation\Rowreduce

*  Transform throws exception if second operand not an array
*  Transform throws exception if second operand does not contain row indicator
*  Transform throws exception if row indicator less than one
*  Transform throws exception if row indicator greater than rows
*  Transform returns matrix reduced by one row if numrows not given
*  Transform throws exception if numrows less than one
*  Transform throws exception if numrows plus row indicator greater than rows
*  Transform throws exception if first operand is incomplete matrix
*  Empty matrix returns empty matrix
*  Transform returns correct result

## Chippyash\Test\Matrix\Transformation\Rowslice

*  Compute throws exception if second operand not an array
*  Compute throws exception if second operand does not contain row indicator
*  Compute throws exception if row indicator less than one
*  Compute throws exception if row indicator greater than rows
*  Compute returns one row if numrows not given
*  Compute throws exception if numrows less than one
*  Compute throws exception if numrows plus row indicator greater than rows
*  Compute throws exception if first operand is incomplete matrix
*  Empty matrix returns empty matrix
*  Compute returns correct result

## Chippyash\Test\Matrix\Transformation\Shift

*  You can shift a single column to the right
*  You can shift a multiple columns to the right
*  You can shift a single column to the left
*  You can shift a multiple columns to the left
*  A null shift parameter will default to single right shift
*  Shifting an empty matrix will return an empty matrix
*  Shifting an single item matrix will return an empty matrix
*  A zero shift parameter will return a clone of the shifted matrix
*  Shifting a column vector will return a replaced vector
*  You can supply a replacement value

## Chippyash\Test\Matrix\Transformation\Stack

*  Compute throws exception if second operand is not a matrix
*  Compute throws exception if matrices have different col count
*  Compute throws exception if first operand is incomplete matrix
*  Compute throws exception if second operand is incomplete matrix
*  Empty matrix returns empty matrix
*  Compute returns correct result

## Chippyash\Test\Matrix\Transformation\Transpose

*  Second operand ignored
*  Empty matrix returns empty matrix
*  Compute throws exception if first operand is incomplete matrix
*  Compute returns correct result
*  Compute a ttothe t returns correct result

## Chippyash\Test\Matrix\Vector\Vector

*  Construct with no parameters gives zero vector
*  Construct with non numeric x throws exception
*  Construct with non numeric y throws exception
*  Get col vector matrix can return two dimensions
*  Translate will translate
*  Magic to string returns correctly formatted string
*  To y x string returns correctly formatted string

## Chippyash\Test\Matrix\Vector\VectorSet

*  From matrix with non matrix will throw exception
*  From matrix with non matrix will return vector 2d
*  Vector set has as many entries as supplied matrix
*  Append only accepts vector 2d parameters
*  To matrix with rebase returns a matrix
*  To matrix with no rebase returns a matrix
*  Translate will eventually return a matrix


Generated by [chippyash/testdox-converter](https://github.com/chippyash/Testdox-Converter)