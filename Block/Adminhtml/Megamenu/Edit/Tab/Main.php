<?php

namespace Renouard\Megamenu\Block\Adminhtml\Megamenu\Edit\Tab;

/**
 * Megamenu edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Renouard\Megamenu\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Renouard\Megamenu\Model\Status $status,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Renouard\Megamenu\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('megamenu');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);

        if ($model->getId()) {
            $fieldset->addField('id_menu', 'hidden', ['name' => 'id_menu']);
        }

	 $fieldset->addField(
       'store',
       'multiselect',
       [
         'name'     => 'store_ids[]',
         'label'    => __('Store Views'),
         'title'    => __('Store Views'),
         'required' => true,
         'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
       ]
    );						
      
						
         $selectField = $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
		'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
          $selectField->setAfterElementHtml('
                   <p><span> <input type="checkbox" name="toogle_title" value="yes" checked >Use by default</span></p>
                    ');
            $isElementDisabled33 = false;
        if ($model->getId()) {
            $isElementDisabled33 = true;
        }
        $fieldset->addField(
            'type',
            'select',
            [
                'label' => __('Type'),
                'title' => __('Type'),
                'name' => 'type',
		'onchange'=>'changeType(this.value)',		
                'options' => \Renouard\Megamenu\Block\Adminhtml\Megamenu\Grid::getOptionArray1(),
                'disabled' => $isElementDisabled33
            ]
        );
       
        $fieldset->addField(
            'link',
            'text',
            [
                'name' => 'link',
                'label' => __('Link'),
                'title' => __('Link'), 
                'id' => __('4070_link'), 
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
	 				
       $selectField2 =  $fieldset->addField(
            'option',
            'textarea',
            [
                'name' => 'option',
                'label' => __('HTML'),
                'title' => __('Option'),
		 'id' => __('4070_html'),
                'disabled' => $isElementDisabled
            ]
        );
      $cat = \Renouard\Megamenu\Block\Adminhtml\Megamenu\Grid::getValueCategory();
      $pag = \Renouard\Megamenu\Block\Adminhtml\Megamenu\Grid::getValuePage();
      $link = \Renouard\Megamenu\Block\Adminhtml\Megamenu\Grid::getOptionValueLink();
	   $selectField2->setAfterElementHtml(
                   \Renouard\Megamenu\Block\Adminhtml\Megamenu\Grid::javascriptOptionInteger($cat,$pag,$link)
                   );				

        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);
		
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Item Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Item Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    
    public function getTargetOptionArray(){
    	return array(
    				'_self' => "Self",
					'_blank' => "New Page",
    				);
    }
}
