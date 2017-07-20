<?php

namespace MagentoEse\AutoFill\Block;

use Magento\Framework\View\Element\Template;

/**
 * Auto Fill Selector block
 */
class Selector extends Template
{
    // Persona Enabled
    const XML_PATH_PERSONA_ENABLED = 'magentoese_autofill/persona_%s/enable';

    // Email and Password Values
    const XML_PATH_EMAIL = 'magentoese_autofill/persona_%s/email_value';
    const XML_PATH_PASSWORD = 'magentoese_autofill/persona_%s/password_value';

    // General Values
    const XML_PATH_LABEL = 'magentoese_autofill/persona_%s/label';
    const XML_PATH_FIRST_NAME = 'magentoese_autofill/persona_%s/firstname_value';
    const XML_PATH_LAST_NAME = 'magentoese_autofill/persona_%s/lastname_value';
    const XML_PATH_COMPANY = 'magentoese_autofill/persona_%s/company_value';
    const XML_PATH_ADDRESS = 'magentoese_autofill/persona_%s/address_value';
    const XML_PATH_COUNTRY = 'magentoese_autofill/persona_%s/country_value';
    const XML_PATH_CITY = 'magentoese_autofill/persona_%s/city_value';
    const XML_PATH_STATE = 'magentoese_autofill/persona_%s/state_value';
    const XML_PATH_ZIP = 'magentoese_autofill/persona_%s/zip_value';
    const XML_PATH_TELEPHONE = 'magentoese_autofill/persona_%s/telephone_value';
    const XML_PATH_FAX = 'magentoese_autofill/persona_%s/fax_value';

    // CC Payment Values
    const XML_PATH_CC_TYPE = 'magentoese_autofill/persona_%s/cc_type';
    const XML_PATH_CC_NUMBER = 'magentoese_autofill/persona_%s/cc_number';
    const XML_PATH_CC_MONTH = 'magentoese_autofill/persona_%s/cc_month';
    const XML_PATH_CC_YEAR = 'magentoese_autofill/persona_%s/cc_year';
    const XML_PATH_CC_VERIFICATION_NUMBER = 'magentoese_autofill/persona_%s/cc_verification_number';

    // The number of personas defined in the system configuration
    const PERSONA_COUNT = 18;

    /**
     * Persona Data
     *
     * @var []
     */
    protected $personas = [];

    /**
     * Retrieve loaded category collection
     *
     * @return array
     */
    public function getPersonas()
    {
        if (count($this->personas) === 0) {

            for ($i = 1; $i <= self::PERSONA_COUNT; $i++) {
                if ($this->_scopeConfig->getValue(sprintf(self::XML_PATH_PERSONA_ENABLED, $i))) {

                    // Use label, if set, otherwise use full name
                    $label = $this->_scopeConfig->getValue(sprintf(self::XML_PATH_LABEL, $i));
                    if (empty($label)) {
                        $label = $this->_scopeConfig->getValue(sprintf(self::XML_PATH_FIRST_NAME, $i))
                            . ' '
                            . $this->_scopeConfig->getValue(sprintf(self::XML_PATH_LAST_NAME, $i));
                    }

                    // Build optionData from config values
                    $optionData = [
                        'email' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_EMAIL, $i)),
                        'password' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_PASSWORD, $i)),

                        'label' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_LABEL, $i)),
                        'firstname' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_FIRST_NAME, $i)),
                        'lastname' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_LAST_NAME, $i)),

                        'company' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_COMPANY, $i)),
                        'address' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_ADDRESS, $i)),
                        'country' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_COUNTRY, $i)),
                        'city' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_CITY, $i)),
                        'state' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_STATE, $i)),
                        'zip' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_ZIP, $i)),
                        'telephone' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_TELEPHONE, $i)),
                        'fax' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_FAX, $i)),

                        'cc_type' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_CC_TYPE, $i)),
                        'cc_number' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_CC_NUMBER, $i)),
                        'cc_month' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_CC_MONTH, $i)),
                        'cc_year' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_CC_YEAR, $i)),
                        'cc_verification_number' => $this->_scopeConfig->getValue(sprintf(self::XML_PATH_CC_VERIFICATION_NUMBER, $i)),
                    ];

                    // Set the persona data for this persona
                    $this->personas[$i]['optionLabel'] = $label;
                    $this->personas[$i]['optionValue'] = $i;
                    $this->personas[$i]['optionData'] = json_encode($optionData);
                }
            }
        }

        return $this->personas;
    }
}
