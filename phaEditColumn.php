<?php
/**
 * phaEditColumn class file.
 *
 * @author Vadim Kruchkov <long@phargo.net>
 * @link http://www.phargo.net/
 * @copyright Copyright &copy; 2011 phArgo Software
 * @license GPL & MIT
 */
class phaEditColumn extends phaAbsActiveColumn {

    /**
     * @var array Additional HTML attributes. See details {@link CHtml::inputField}
     */
    public $htmlEditFieldOptions = array();

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     *
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row,$data) {
        $value = CHtml::value($data, $this->name);
        $valueId = $data->{$this->modelId};

        $this->htmlEditFieldOptions['itemId'] = $valueId;
        $fieldUID = $this->getViewDivClass();

        echo CHtml::tag('div', array(
            'valueid' => $valueId,
            'id' => $fieldUID.'-'.$valueId,
            'class' => $fieldUID
        ), $value);

        echo CHtml::openTag('div', array(
            'style' => 'display: none;',
            'id' => $this->getFieldDivClass() . $data->{$this->modelId},
        ));
        echo CHtml::textField($this->name.'[' . $valueId . ']', $value, $this->htmlEditFieldOptions);
        echo CHtml::closeTag('div');
    }

    /**
     * @return string Name of div's class for view value
     */
    protected function getViewDivClass( ) {
        return 'viewValue-' . $this->id;
    }

    /**
     * @return string Name of div's class for edit field
     */
    protected function getFieldDivClass( ) {
        return 'field-' . $this->id . '-';
    }

    /**
     * Initializes the column.
     *
     * @see CDataColumn::init()
     */
    public function init() {
        parent::init();

        $cs=Yii::app()->getClientScript();
        $gridId = $this->grid->getId();

        $script ='
        jQuery(".'.$this->getViewDivClass().'").live("click", function(e){
            phaACOpenEditField(this);
            return false;
        });
        var phaACOpenEditItem=0;
        function phaACOpenEditField(itemValue) {
            phaACHideEditField( phaACOpenEditItem );
            var id=$(itemValue).attr("valueid");

            $("#'.$this->getViewDivClass().'-"+id).hide();
            $("#' .$this->getFieldDivClass(). '"+id).show();
            $("#' .$this->getFieldDivClass(). '"+id+" input")
                .focus()
                .keydown(function(event) {
                    switch (event.keyCode) {
                       case 27:
                          phaACHideEditField(phaACOpenEditItem);
                       break;
                       case 13:
                          phaACEditFieldSend();
                       break;
                       default: break;
                    }
                });

            phaACOpenEditItem = id;
        }
        function phaACHideEditField(itemId) {
            var clearVal = $("#'.$this->getViewDivClass().'-"+itemId).text();
            $("#' .$this->getFieldDivClass(). '"+itemId+" input").val( clearVal );
            $("#' .$this->getFieldDivClass(). '"+itemId).hide();
            $("#' .$this->getFieldDivClass(). '"+itemId+" input").unbind("keydown");
            $("#'.$this->getViewDivClass().'-"+itemId).show();
            phaACOpenEditItem=0;
        }
        function phaACEditFieldSend() {
            $.ajax({
                type: "POST",
                dataType: "json",
                cache: false,
                url: "' . $this->buildActionUrl() . '",
                data: {
                    item: phaACOpenEditItem,
                    value: $("#' .$this->name. '_"+phaACOpenEditItem).val()
                },
                success: function(data){
                  $("#'.$gridId.'").yiiGridView.update("'.$gridId.'");
                }
            });
        }
        ';

        $cs->registerScript(__CLASS__.$gridId.'#active_column-'.$this->id, $script);
    }
}