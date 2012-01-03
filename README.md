phaActiveColumn
======================================
Extension a basic set of columns of Yii grid. Allows you to organize interactive editing data inside the grid.
The new values ​​will be sent to the server using Ajax.
At the moment includes:

 * phaSelectColumn - column, which will allow the new data from a predefined list of values.
 * phaCheckColumn - using this column you will be switched the state between two value.
 * phaEditColumn - use this type column if you need edit text data.

## Installation

1. Extract the release file under <tt>protected/extensions/phaActiveColumn</tt>.
2. Add to your config file in import section:

        ...
        'application.extensions.phaActiveColumn.*',
        ...


## Usage

Now in your template you can use the new column.
All new collumns must set property _actionUrl_. It's URL for update action.On this URL will be sent call to update value.
If this value is string - value will be used as is. If it's array - will be called [CHtml::normalizeUrl](http://www.yiiframework.com/doc/api/1.1/CHtml#normalizeUrl-detail).

### phaSelectColumn 

Because the column type phaSelectColumn is inherited from [CDataColumn](http://www.yiiframework.com/doc/api/1.1/CDataColumn) and 
[CGridColumn](http://www.yiiframework.com/doc/api/1.1/CGridColumn), it includes entire set of properties and methods of base classes.
Consider the different properties:

 * data - data to build the drop-down list an array {id => name};
 * modelId - name of models key. By default it's "id";
 * actionUrl - see __"Usage"__ section

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

 * item - unique identifier of model;
 * value - selected value.


### phaCheckColumn

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

 * item - unique identifier of model;
 * checked - 1 (if box is checked) or 0 (in another case).


### phaEditColumn

If you need edit text date without open other page, you can use this type of column. In normal state it's view data as ordinary column.
But click on data cell will open input field for edit data. After press Enter new data will be send to server.

#### phaEditColumn Example

We add column phaEditColumn type for editing attribute _name_ of model.

    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            ...........
            array(
                'class' => 'phaCheckColumn',
                'name' => 'name',
                'actionUrl' => array('setName'),
            ),
            ...........
        ),
    ));

After changing any values ​​will be send a POST request, containing:

 * item - unique identifier of model;
 * value - input data.

#### phaEditColumn usage

If you click on row, view data will change to input field. Enter send data to server, and ESC-key will close input without send data.

## Author

Vadim Kruchkov <long@phargo.net>.

## Licence

Choose your favourite of:

 * [GPL-LICENSE](https://github.com/phargo/phaOpenGraph/blob/master/GPL-LICENSE)
 * [MIT-LICENSE](https://github.com/phargo/phaOpenGraph/blob/master/MIT-LICENSE)

Thanks for sharing!