<?php
namespace Renouard\Megamenu\Model\ResourceModel;

class Megamenu extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('megamenu', 'id_menu');
    }
}
?>