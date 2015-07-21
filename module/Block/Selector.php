<?php

namespace MagentoEse\AutoFill\Block;

/**
 * Auto Fill Selector block
 */
class Selector extends \Magento\Framework\View\Element\Template
{

    /* Persona Enabled */
    protected $_configPathPersonaEnabled = 'magentoese_autofill/persona_%s/enable';

    /* Email and Password Values */
    protected $_configPathEmail = 'magentoese_autofill/persona_%s/email_value';
    protected $_configPathPassword = 'magentoese_autofill/persona_%s/password_value';

    /* General Values */
    protected $_configPathLabel = 'magentoese_autofill/persona_%s/label';
    protected $_configPathFirstname = 'magentoese_autofill/persona_%s/firstname_value';
    protected $_configPathLastname = 'magentoese_autofill/persona_%s/lastname_value';
    protected $_configPathCompany = 'magentoese_autofill/persona_%s/company_value';
    protected $_configPathAddress = 'magentoese_autofill/persona_%s/address_value';
    protected $_configPathCountry = 'magentoese_autofill/persona_%s/country_value';
    protected $_configPathCity = 'magentoese_autofill/persona_%s/city_value';
    protected $_configPathState = 'magentoese_autofill/persona_%s/state_value';
    protected $_configPathZip = 'magentoese_autofill/persona_%s/zip_value';
    protected $_configPathTelephone = 'magentoese_autofill/persona_%s/telephone_value';
    protected $_configPathFax = 'magentoese_autofill/persona_%s/fax_value';

    /* CC Payment Values */
    protected $_configPathCcType = 'magentoese_autofill/persona_%s/cc_type';
    protected $_configPathCcNumber = 'magentoese_autofill/persona_%s/cc_number';
    protected $_configPathCcMonth = 'magentoese_autofill/persona_%s/cc_month';
    protected $_configPathCcYear = 'magentoese_autofill/persona_%s/cc_year';
    protected $_configPathCcVerificationNumber = 'magentoese_autofill/persona_%s/cc_verification_number';

    /**
     * The number of personas defined in the system configuration
     */
    protected $_personaCount = 7;

    /**
     * Persona Data
     *
     * @var
     */
    protected $_personas = array();

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Retrieve loaded category collection
     *
     * @return var
     */
    public function getPersonas()
    {
        if (count($this->_personas) === 0) {

            for ($i = 1; $i <= $this->_personaCount; $i++) {
                if ($this->_scopeConfig->getValue(sprintf($this->_configPathPersonaEnabled, $i))) {

                    // Use label, if set, otherwise use full name
                    $label = $this->_scopeConfig->getValue(sprintf($this->_configPathLabel, $i));
                    if (empty($label)) {
                        $label = $this->_scopeConfig->getValue(sprintf($this->_configPathFirstname, $i))
                            . ' '
                            . $this->_scopeConfig->getValue(sprintf($this->_configPathLastname, $i));
                    }

                    // Build optionData from config values
                    $optionData = array();
                    $optionData['email'] = $this->_scopeConfig->getValue(sprintf($this->_configPathEmail, $i));
                    $optionData['password'] = $this->_scopeConfig->getValue(sprintf($this->_configPathPassword, $i));

                    $optionData['label'] = $this->_scopeConfig->getValue(sprintf($this->_configPathLabel, $i));
                    $optionData['firstname'] = $this->_scopeConfig->getValue(sprintf($this->_configPathFirstname, $i));
                    $optionData['lastname'] = $this->_scopeConfig->getValue(sprintf($this->_configPathLastname, $i));

                    $optionData['company'] = $this->_scopeConfig->getValue(sprintf($this->_configPathCompany, $i));
                    $optionData['address'] = $this->_scopeConfig->getValue(sprintf($this->_configPathAddress, $i));
                    $optionData['country'] = $this->_scopeConfig->getValue(sprintf($this->_configPathCountry, $i));
                    $optionData['city'] = $this->_scopeConfig->getValue(sprintf($this->_configPathCity, $i));
                    $optionData['state'] = $this->_scopeConfig->getValue(sprintf($this->_configPathState, $i));
                    $optionData['zip'] = $this->_scopeConfig->getValue(sprintf($this->_configPathZip, $i));
                    $optionData['telephone'] = $this->_scopeConfig->getValue(sprintf($this->_configPathTelephone, $i));
                    $optionData['fax'] = $this->_scopeConfig->getValue(sprintf($this->_configPathFax, $i));

                    $optionData['cc_type'] = $this->_scopeConfig->getValue(sprintf($this->_configPathCcType, $i));
                    $optionData['cc_number'] = $this->_scopeConfig->getValue(sprintf($this->_configPathCcNumber, $i));
                    $optionData['cc_month'] = $this->_scopeConfig->getValue(sprintf($this->_configPathCcMonth, $i));
                    $optionData['cc_year'] = $this->_scopeConfig->getValue(sprintf($this->_configPathCcYear, $i));
                    $optionData['cc_verification_number'] = $this->_scopeConfig->getValue(sprintf($this->_configPathCcVerificationNumber, $i));

                    // Set the persona data for this persona
                    $this->_personas[$i]['optionLabel'] = $label;
                    $this->_personas[$i]['optionValue'] = $i;
                    $this->_personas[$i]['optionData'] = json_encode($optionData);
                }
            }
        }

        return $this->_personas;
    }
}
