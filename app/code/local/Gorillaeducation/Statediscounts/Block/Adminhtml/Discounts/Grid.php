<?php

class Gorillaeducation_Statediscounts_Block_Adminhtml_Discounts_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('gorillaeducation_statediscounts_discounts_grid');
        $this->_controller = 'adminhtml_discounts';
        $this->setUseAjax(true);

        $this->setDefaultSort('id');
        $this->setDefaultDir('asc');
    }

    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'gorillaeducation_statediscounts/discounts_collection';
    }

    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $collection->getSelect()
            ->join('directory_country_region', 'directory_country_region_id=region_id', array('region_name'=>'default_name'), null, 'left');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header'=> Mage::helper('gorillaeducation_statediscounts')->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id'
            )
        );

        $this->addColumn('region_name', array(
            'header'    => Mage::helper('gorillaeducation_statediscounts')->__('State'),
            'index'     => 'region_name',
            'type'      => 'text',
            'options'   => 'region_name',
        ));

        $this->addColumn('discount',
            array(
                'header'=> Mage::helper('gorillaeducation_statediscounts')->__('Discount %'),
                'index' => 'discount',
                'type'  => 'number',
            )
        );

        $this->addExportType('*/*/exportCsv', Mage::helper('gorillaeducation_statediscounts')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('gorillaeducation_statediscounts')->__('XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}