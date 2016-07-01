<?php

namespace OuterEdge\Layout\Block\Adminhtml\Elements\Edit\Tab;

/**
 * Elements edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

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
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
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
        $model = $this->_coreRegistry->registry('layout_elements_form_data');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Element Information')]);

        if ($model->getId()) {
            $fieldset->addField('id_element', 'hidden', ['name' => 'id_element']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'description',
            'textarea',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'fk_type',
            'text',
            [
                'name' => 'fk_type',
                'label' => __('Type'),
                'title' => __('Type'),
                'required' => true
            ]
        );
        $fieldset->addField(
            'link',
            'text',
            [
                'name' => 'link',
                'label' => __('Link'),
                'title' => __('Link'),
                'required' => false
            ]
        );
        $fieldset->addField(
            'link_text',
            'text',
            [
                'name' => 'link_text',
                'label' => __('Link Text'),
                'title' => __('Link Text'),
                'required' => false
            ]
        );
        $fieldset->addField(
            'image',
            'text',
            [
                'name' => 'image',
                'label' => __('Image'),
                'title' => __('Image'),
                'required' => false
            ]
        );

         $fieldset->addField(
            'overlay_style',
            'text',
            [
                'name' => 'overlay_style',
                'label' => __('Overlay Style'),
                'title' => __('Overlay Style'),
                'required' => false
            ]
        );
        $fieldset->addField(
            'overlay_colour',
            'text',
            [
                'name' => 'overlay_colour',
                'label' => __('Overlay Colour'),
                'title' => __('Overlay Colour'),
                'required' => false
            ]
        );
        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort Order'),
                'title' => __('Sort Order'),
                'required' => false
            ]
        );

//        $contentField = $fieldset->addField(
//            'link',
//            'text',
//            [
//                'name' => 'link',
//                'label' => __('Description'),
//                'title' => __('Description'),
//                'required' => true
//            ]
//        );
//
//        // Setting custom renderer for content field to remove label column
//        $renderer = $this->getLayout()->createBlock(
//            'Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element'
//        )->setTemplate(
//            'Magento_Cms::page/edit/form/renderer/content.phtml'
//        );
//        $contentField->setRenderer($renderer);


        $dateFormat = $this->_localeDate->getDateFormat(
            \IntlDateFormatter::SHORT
        );

        $fieldset->addField(
            'created_at',
            'date',
            [
                'name' => 'created_at',
                'label' => __('Created Date'),
                'date_format' => $dateFormat,
                'class' => 'validate-date validate-date-range date-range-custom_theme-from'
            ]
        );

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
        return __('Element Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Element Information');
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
}