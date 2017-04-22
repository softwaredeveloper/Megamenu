<?php
namespace Renouard\Megamenu\Model;

class Megamenu extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Renouard\Megamenu\Model\ResourceModel\Megamenu');
    }
}
?>