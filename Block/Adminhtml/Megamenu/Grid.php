<?php
namespace Renouard\Megamenu\Block\Adminhtml\Megamenu;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Renouard\Megamenu\Model\megamenuFactory
     */
    protected $_megamenuFactory;

    /**
     * @var \Renouard\Megamenu\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Renouard\Megamenu\Model\megamenuFactory $megamenuFactory
     * @param \Renouard\Megamenu\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Renouard\Megamenu\Model\MegamenuFactory $MegamenuFactory,
        \Renouard\Megamenu\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_megamenuFactory = $MegamenuFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('id_menu');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_megamenuFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id_menu',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id_menu',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );


		
				$this->addColumn(
					'title',
					[
						'header' => __('Title'),
						'index' => 'title',
					]
				);
				
				$this->addColumn(
					'link',
					[
						'header' => __('Link'),
						'index' => 'link',
					]
				);
				


		
        //$this->addColumn(
            //'edit',
            //[
                //'header' => __('Edit'),
                //'type' => 'action',
                //'getter' => 'getId',
                //'actions' => [
                    //[
                        //'caption' => __('Edit'),
                        //'url' => [
                            //'base' => '*/*/edit'
                        //],
                        //'field' => 'id_menu'
                    //]
                //],
                //'filter' => false,
                //'sortable' => false,
                //'index' => 'stores',
                //'header_css_class' => 'col-action',
                //'column_css_class' => 'col-action'
            //]
        //);
		

		
		   $this->addExportType($this->getUrl('megamenu/*/exportCsv', ['_current' => true]),__('CSV'));
		   $this->addExportType($this->getUrl('megamenu/*/exportExcel', ['_current' => true]),__('Excel XML'));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

	
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('id_menu');
        //$this->getMassactionBlock()->setTemplate('Renouard_Megamenu::megamenu/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('megamenu');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('megamenu/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('megamenu/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );


        return $this;
    }
		

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('megamenu/*/index', ['_current' => true]);
    }

    /**
     * @param \Renouard\Megamenu\Model\megamenu|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		
        return $this->getUrl(
            'megamenu/*/edit',
            ['id_menu' => $row->getId()]
        );
		
    }

	
  	static public function getOptionArray1()
		{
            $data_array=array(); 
                        $data_array['custom']='Custom';
			$data_array['category']='Category';
			$data_array['cms_page']='CMS Page';
             return($data_array);
		}
                
                
        static public function getOptionValueLink()
        {
          return ' <input id="page_link" name="link" data-ui-id="megamenu-megamenu-edit-tab-main-fieldset-element-text-link" value="" title="Link" type="text" class=" input-text admin__control-text required-entry _required">';
        }
        static public function javascriptOptionInteger($cat,$pag,$link)
        {
            return("
                     <script>
                     
                     function changeType(thiss)
                     {
                     
                     var n=null, k=null;
                     if(thiss=='custom')
                     {
                     n=4;
                     k=3;
                      var tt = document.getElementsByClassName('admin__field')[n];
                        var data = tt.getAttribute('data-ui-id');
                        var label = document.getElementsByClassName('admin__field-label')[k];
                        label.innerHTML='<span>Link</span>';
                          var control = document.getElementsByClassName('admin__field-control')[k];
                        control.innerHTML='".$link."';
                     }
                     if(thiss=='category')
                     {
                     n=4;
                     k=3;
                       var tt = document.getElementsByClassName('admin__field')[n];
                        var data = tt.getAttribute('data-ui-id');
                        var label = document.getElementsByClassName('admin__field-label')[k];
                        label.innerHTML='<span>Category</span>';
                         var control = document.getElementsByClassName('admin__field-control')[k];
                        control.innerHTML='".$cat."';
                        
                     }
                     if(thiss=='cms_page')
                     {
                     n=4;
                     k=3;
                       var tt = document.getElementsByClassName('admin__field')[n];
                        var data = tt.getAttribute('data-ui-id');
                         var label = document.getElementsByClassName('admin__field-label')[k];
                        label.innerHTML='<span>CMS page</span>';
                          var control = document.getElementsByClassName('admin__field-control')[k];
                        control.innerHTML='".$pag."';
                     }
                       
                      
                     }
                    </script>
                   " );
        }
	static public function getValueCategory() {
        $selecthtmlcategory = '<select  id="page_link" name="link" data-ui-id="megamenu-megamenu-edit-tab-main-fieldset-element-text-link"  class="input-text admin__control-text required-entry _required">';
        $collectionv = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryFactory = $collectionv->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');

        $categories = $categoryFactory->create()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('is_active', array('in' => array(0, 1)))
                ->addAttributeToFilter('parent_id', 2);
        foreach ($categories as $cmsv) {
            $selecthtmlcategory .= '<option value="' . $cmsv->getId() . '" >' . str_replace("'", " ", $cmsv->getName()) . '</option>';
        }
        $selecthtmlcategory .= "</select>";

        return($selecthtmlcategory);
    }

    static public function getValuePage() {
        $selecthtmlcategory = '<select  id="page_link" name="link" data-ui-id="megamenu-megamenu-edit-tab-main-fieldset-element-text-link"  class="input-text admin__control-text required-entry _required">';
        $collectionPage = \Magento\Framework\App\ObjectManager::getInstance();
        $collection = $collectionPage->get('Magento\Cms\Model\ResourceModel\Page\CollectionFactory')->create();
        $collection->addFieldToFilter('is_active', \Magento\Cms\Model\Page::STATUS_ENABLED);
        foreach ($collection as $cmsv) {
            $selecthtmlcategory .= '<option value="' . $cmsv->getId() . '" >' . str_replace("'", " ", $cmsv->getTitle()) . '</option>';
        }
        $selecthtmlcategory .= "</select>";

        return($selecthtmlcategory);
    }

    static public function getValueArray1() {
        $data_array = array();
        foreach (Mdtgroupe_Megamenu_Block_Adminhtml_Megamenu_Grid::getOptionArray1() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return($data_array);
    }

    /*static public function getOptionArray4()
		{
            $data_array=array(); 
			$data_array[0]='En';
			$data_array[1]='Fr';
            return($data_array);
		}
		static public function getValueArray4()
		{
            $data_array=array();
			foreach(Mdtgroupe_Megamenu_Block_Adminhtml_Megamenu_Grid::getOptionArray4() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}*/

}