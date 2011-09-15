<?php
/**
 * phaSelectColumn class file.
 *
 * @author Vadim Kruchkov <long@phargo.net>
 * @link http://www.phargo.net/
 * @copyright Copyright &copy; 2011 phArgo Software
 * @license GPL & MIT
 */

Yii::import('zii.widgets.grid.CDataColumn');

class phaSelectColumn extends CDataColumn {

    /**
     * @var array the HTML options for the checkboxes.
     */
    public $selectBoxHtmlOptions=array();

    /**
     * @var array the data for generate a drop down list
     */
    public $data = array();

    /**
     * @var string name of models key
     */
    public $modelId = 'id';

    /**
     * @var mixed URL for update action. On this URL will be sent call to update value.
     *      If this value is string - value will be used as is.
     *      If it's array - will be called {@link CHtml::normalizeUrl}
     */
    public $actionUrl = array('.');

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     *
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row,$data) {
        $value = CHtml::value($data,$this->modelId);
        $this->selectBoxHtmlOptions['itemId'] = $data->{$this->modelId};

        echo CHtml::dropDownList(
            $this->name.'['.$value.']',
            CHtml::value($data,$this->name),
            $this->data,
            $this->selectBoxHtmlOptions
        );
    }

    /**
     * Initializes the column.
     *
     * @see CDataColumn::init()
     */
    public function init() {
        parent::init();

        if (!isset($this->selectBoxHtmlOptions['class'])) {
            $this->selectBoxHtmlOptions['class'] = 'selectColumn-' . $this->id;
        }

        $cs=Yii::app()->getClientScript();
        $gridId = $this->grid->getId();

        $script = '
        jQuery(".'.$this->selectBoxHtmlOptions['class'].'").live("change", function(e){
          e.preventDefault();
          $.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: "' . (is_array($this->actionUrl) ? CHtml::normalizeUrl( $this->actionUrl ) : $this->actionUrl) . '",
            data: {
                item: $(this).attr("itemId"),
                value:$("option:selected",this).val()
            },
            success: function(data){
              $("#'.$gridId.'").yiiGridView.update("'.$gridId.'");
            }
          });
        });';

        $cs->registerScript(__CLASS__.$gridId.'#active_column-'.$this->id, $script);
    }
}