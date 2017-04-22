<?php

namespace Renouard\Megamenu\Model\ResourceModel\Megamenu;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Renouard\Megamenu\Model\Megamenu', 'Renouard\Megamenu\Model\ResourceModel\Megamenu');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>