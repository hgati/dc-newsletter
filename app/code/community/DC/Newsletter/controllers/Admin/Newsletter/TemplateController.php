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

include_once "Mage/Adminhtml/controllers/Newsletter/TemplateController.php";

class DC_Newsletter_Admin_Newsletter_TemplateController extends Mage_Adminhtml_Newsletter_TemplateController
{

	//hack the edit action, check if it should send a test
    public function editAction()
    {
        $test = $this->getRequest()->getParam('test');
        $templateId = $this->getRequest()->getParam('id');
		if ($test && $templateId) {

        	$adminUser = Mage::getSingleton('admin/session')->getUser();

	        /* @var $template Mage_Newsletter_Model_Template */
       		$template = Mage::getModel('newsletter/template')->load($templateId);
			if (!$template->getId() || $template->getIsSystem()) {
				Mage::throwException($this->__('Wrong newsletter template.'));
			}
			$template->preprocess();

			$error = false;
			try {
				if (!$template->send($adminUser->getEmail(), array(), $adminUser->getFirstname().' '.$adminUser->getLastname())) {
					$error = $this->__('Could not send email to %s', $adminUser->getEmail());
				}
			} catch (Exception $e) {
				$error = $this->__('Could not send email to %s ('.$e->getMessage().')', $adminUser->getEmail());
			}

			if ($error) {
                $this->_getSession()->addError($error);
			} else {
                $this->_getSession()->addSuccess(
                    $this->__('Successfully sent test email to %s, check your inbox now!', $adminUser->getEmail())
                );
			}

            //exit;
        	$this->_redirect('*/*');
		} else {
			parent::editAction();
		}

    }


}