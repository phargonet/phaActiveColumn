phaActiveColumn
======================================
Extension a basic set of columns of Yii grid. Allows you to organize interactive editing data inside the grid.
The new values ​​will be sent to the server using Ajax.
At the moment includes:

 * phaSelectColumn - column, which will allow the new data from a predefined list of values.
 * phaCheckColumn - using this column you will be switched the state between two value.

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
 * actionUrl - URL for update action. On this URL will be sent call to update value. If this value is string - 
   value will be used as is. If it's array - will be called [CHtml::normalizeUrl](http://www.yiiframework.com/doc/api/1.1/CHtml#normalizeUrl-detail).

#### phaSelectColumn Example

For example, consider building an interactive grid to edit a list of cities and time zones for this cities:

    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            ...........
            array (
                'class' => 'phaSelectColumn',
                'header' => 'Time Zone',
                'name' => 'time_zone_id',
                'data' => CHtml::listData(TimeZones::model()->findAll(), 'id', 'name'),
                'actionUrl' => array('setTimeZone'),
            ),
            ...........
        ),
    ));

After changing any values ​​will be send a POST request, containing:
<<<<<<< HEAD

=======
>>>>>>> aafaef6f706f8579e01921a3264f95aa87d33812
 * item - unique identifier of model
 * value - selected value


## phaCheckColumn

For data that have two states is convenient use a column of phaCheckColumn type. 
In this column will display the checkbox when the status is change,  the new value will be send to server.

#### phaCheckColumn Example

For example, consider building an interactive grid to activate same item:

    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            ...........
            array(
                'class' => 'phaCheckColumn',
                'name' => 'is_active',
                'actionUrl' => array('setIsActive'),
            ),
            ...........
        ),
    ));

After changing any values ​​will be send a POST request, containing:


 * item - unique identifier of model
 * checked - 1 (if box is checked) or 0 (in another case).

## Author

Vadim Kruchkov <long@phargo.net>.

## Licence

Choose your favourite of:

 * [GPL-LICENSE](https://github.com/phargo/phaOpenGraph/blob/master/GPL-LICENSE)
 * [MIT-LICENSE](https://github.com/phargo/phaOpenGraph/blob/master/MIT-LICENSE)

Thanks for sharing!