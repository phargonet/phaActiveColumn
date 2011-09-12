phaActiveColumn
======================================
Extending a basic set of columns of grid. Allows you to organize interactive editing data inside the grid.
The new values ​​will be sent to the server using Ajax.
At the moment includes:
 * phaSelectColumn - column, which will allow the new data from a predefined list of values.
 * phaСheckColumn - using this column you will be switched the state between two value.

## Installation

1. Extract the release file under <tt>protected/extensions/phaActiveColumn</tt>.
2. Add to your config file:
 * in import section:
	...
	'application.extensions.phaActiveColumn.*',
	...

## Usage

Now in your template you can use the new column.

### phaSelectColumn 

Because the column type phaSelectColumn is inherited from [CDataColumn](http://www.yiiframework.com/doc/api/1.1/CDataColumn) and 
[CGridColumn](http://www.yiiframework.com/doc/api/1.1/CGridColumn), it includes entire set of of properties and methods of base classes.
Consider the different properties:
 * data - data to build the drop-down list an array {id => name};
 * modelId - name of models key. By default it's "id";
 * itemName - The name of the attribute that contains the value to uniquely identify which element has been changed. By default it's "name";
 * actionUrl - URL for update action. On this URL will be sent call to update value. If this value is string - 
   value will be used as is. If it's array - will be called [CHtml::normalizeUrl](http://www.yiiframework.com/doc/api/1.1/CHtml#normalizeUrl-detail).

## Author

Vadim Kruchkov <long@phargo.net>.

## Licence

Choose your favourite of:

 * [GPL-LICENSE](https://github.com/phargo/phaOpenGraph/blob/master/GPL-LICENSE)
 * [MIT-LICENSE](https://github.com/phargo/phaOpenGraph/blob/master/MIT-LICENSE)

Thanks for sharing!