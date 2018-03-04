<?php
/**
 * Dot Collective - Magento Output 2009
 * Find more about the Newsletter module:
 * http://dot.collective.ro/magento-output/
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   DC
 * @package    DC_Newsletter
 * @copyright  Copyright (c) 2009 Dot Collective SRL http://dot.collective.ro
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Add a new action Send test newsletter
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class DC_Newsletter_Adminhtml_Block_Template_Grid_Renderer_Action extends Mage_Adminhtml_Block_Newsletter_Template_Grid_Renderer_Action
{
    public function render(Varien_Object $row)
    {
		$ret = parent::render($row);
    	$actions= $this->getColumn()->getActions();

    	if($row->isValidForSend()) {
            $actions[] = array(
                'url' => $this->getUrl('*/*/edit', array('id' => $row->getId(), 'test' => 1)),
                'caption' => Mage::helper('dc_newsletter')->__('Send Test Newsletter')
            );
        }

        $this->getColumn()->setActions($actions);

        //skip the direct parent class
        return Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action::render($row);
    }
}
