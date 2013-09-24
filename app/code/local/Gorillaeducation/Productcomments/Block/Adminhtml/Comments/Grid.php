<?php

class Gorillaeducation_Productcomments_Block_Adminhtml_Comments_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('gorillaeducation_productcomments_comments_grid');
        $this->_controller = 'adminhtml_comments';
        $this->setUseAjax(true);

        $this->setDefaultSort('id');
        $this->setDefaultDir('asc');
    }

    protected function _getCollectionClass()
    {
        return 'gorillaeducation_productcomments/comments_collection';
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $collection->getSelect()
            ->join('catalog_product_entity', 'product_id=entity_id', array('catalog_product_id'=>'entity_id', 'product_sku'=>'sku'), null, 'left');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header'=> Mage::helper('gorillaeducation_productcomments')->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id'
            )
        );

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('gorillaeducation_productcomments')->__('Product ID'),
            'index'     => 'product_id',
            'type'      => 'id',
        ));

        $this->addColumn('username',
            array(
                'header'=> Mage::helper('gorillaeducation_productcomments')->__('User name'),
                'index' => 'content',
                'type'  => 'text',
            )
        );

        $this->addColumn('content',
            array(
                'header'=> Mage::helper('gorillaeducation_productcomments')->__('Content'),
                'index' => 'content',
                'type'  => 'text',
            )
        );

        $this->addColumn('is_enabled',
            array(
                'header'=> Mage::helper('gorillaeducation_productcomments')->__('Is Enabled'),
                'index' => 'is_enabled',
                'type'  => 'checkbox',
            )
        );

        $this->addColumn('created_at',
            array(
                'header'=> Mage::helper('gorillaeducation_productcomments')->__('Created At'),
                'index' => 'created_at',
                'type'  => 'datetime',
            )
        );

        $this->addExportType('*/*/exportCsv', Mage::helper('gorillaeducation_productcomments')->__('CSV'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}