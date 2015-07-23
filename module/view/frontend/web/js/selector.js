define([
    'jquery',
    'jquery/ui'
], function($){
    "use strict";

    $.widget('magentoeseAutofill.selector', {
        options: {
            autofill: {
                autofillListSelector: '#autofill_list',
                currentPageUrlPattern: null,
                currentPageMap: {},
                selectedPersona: null,
                personaData: {},
                // Define mapping of pages, forms, and fields as well as what values to the map for each field
                //  {
                //  <url-path-of-page-to-match>: {
                //      <jquery-selector-for-form>: {
                //          <jquery-selector-for-field>: <key-to-personadata-for-value-to-assign-to-field>
                //  }
                map: {
                    'customer/account/create': {
                        '.form-create-account': {
                            ':input[name="firstname"]:visible': 'firstname',
                            ':input[name="lastname"]:visible': 'lastname',
                            ':input[name="email"]:visible': 'email',
                            ':input[name="password"]:visible': 'password',
                            ':input[name="password_confirmation"]:visible': 'password'
                        }
                    },
                    'customer/address/edit': {
                        '.form-address-edit': {
                            ':input[name="firstname"]:visible': 'firstname',
                            ':input[name="lastname"]:visible': 'lastname',
                            ':input[name="company"]:visible': 'company',
                            ':input[name="telephone"]:visible': 'telephone',
                            ':input[name="fax"]:visible': 'fax',
                            ':input[name="street[]"][id="street_1"]:visible': 'address',
                            ':input[name="city"]:visible': 'city',
                            ':input[name="region_id"]:visible': 'state',
                            ':input[name="postcode"]:visible': 'zip',
                            ':input[name="country_id"]:visible': 'country'
                        }
                    },
                    'customer/account/login': {
                        '.form-login': {
                            ':input[name="login[username]"]:visible': 'email',
                            ':input[name="login[password]"]:visible': 'password'
                        }
                    },
                    'checkout/cart': {
                        '#shipping-zip-form': {
                            ':input[name="country_id"]:visible': 'country',
                            ':input[name="region_id"]:visible': 'state',
                            ':input[name="estimate_postcode"]:visible': 'zip'
                        }
                    },
                    'checkout': {
                        '.form-login': {
                            ':input[name="username"]:visible': 'email',
                            ':input[name="password"]': 'password',
                        },
                        '#co-shipping-form': {
                            ':input[name="shippingAddress[firstname]"]:visible': 'firstname',
                            ':input[name="shippingAddress[lastname]"]:visible': 'lastname',
                            ':input[name="shippingAddress[company]"]:visible': 'company',
                            ':input[name="shippingAddress[street][0]"]:visible': 'address',
                            ':input[name="shippingAddress[city]"]:visible': 'city',
                            ':input[name="shippingAddress[region_id]"]:visible': 'state',
                            ':input[name="shippingAddress[postcode]"]:visible': 'zip',
                            ':input[name="shippingAddress[telephone]"]:visible': 'telephone',
                            ':input[name="shippingAddress[fax]"]:visible': 'fax',
                        },
                        '#co-payment-form': {
                            ':input[name^="billingAddress"][name$="[firstname]"]:visible': 'firstname',
                            ':input[name^="billingAddress"][name$="[lastname]"]:visible': 'lastname',
                            ':input[name^="billingAddress"][name$="[company]"]:visible': 'company',
                            ':input[name^="billingAddress"][name$="[street][0]"]:visible': 'address',
                            ':input[name^="billingAddress"][name$="[city]"]:visible': 'city',
                            ':input[name^="billingAddress"][name$="[region_id]"]:visible': 'state',
                            ':input[name^="billingAddress"][name$="[postcode]"]:visible': 'zip',
                            ':input[name^="billingAddress"][name$="[telephone]"]:visible': 'telephone',
                            ':input[name^="billingAddress"][name$="[fax]"]:visible': 'fax',

                            ':input[name="payment[cc_number]"]:visible': 'cc_number',
                            ':input[name="payment[cc_exp_month]"]:visible': 'cc_month',
                            ':input[name="payment[cc_exp_year]"]:visible': 'cc_year',
                            ':input[name="payment[cc_cid]"]:visible': 'cc_verification_number',
                        }
                    },
                }
            }
        },

        /**
         * Creates widget 'magentoeseAutofill.selector'
         * @private
         */
        _create: function () {
            if (this._isEnabled()) {
                var events = {};
                events['change ' + this.options.autofill.autofillListSelector] = function(e) {this._onSelectorChange(e);};
                this._on(events);
            }
        },

        /**
         * Check if module is enabled
         */
        _isEnabled: function() {
            var isAutoFillPage = this._isAutoFillPage();
            var autofillConfigEnabled = $(this.options.autofill.autofillListSelector).parent().attr('data-autofill-enabled');

            if (autofillConfigEnabled === 'true' && isAutoFillPage) {
                //console.debug('autofill enabled');
                $(this.options.autofill.autofillListSelector).parent().show();
                return true;
            }
            else {
                //console.debug('autofill disabled');
                $(this.options.autofill.autofillListSelector).parent().hide();
                return false;
            }
        },

        /**
         * Check if current page matches pages with form fields to auto fill
         */
        _isAutoFillPage: function() {
            var pathname = window.location.pathname;
            var pageMatchFound = null;

            //console.debug(pathname);
            //console.debug(this.options.autofill.map);

            for (var pageUrlPattern in this._getPageMap()) {
                var re = new RegExp('.*/'+pageUrlPattern+'/*.*');
                var found = pathname.match(re);

                //console.debug(pageUrlPattern+' -> '+re+' = '+found);

                if (found != null) {
                    pageMatchFound = pageUrlPattern;
                }
            }

            //console.debug(pageMatchFound);

            if (pageMatchFound != null) {
                this.options.autofill.currentPageUrlPattern = pageMatchFound;
                this.options.autofill.currentPageMap = this._getPageMap(pageMatchFound);
                //console.debug(this.options.autofill.currentPageMap);
                return true;
            } else {
                this.options.autofill.currentPageUrlPattern = null;
                this.options.autofill.currentPageMap = {};
                return false;
            }
        },

        /**
         * Get map of form fields and values
         */
        _getPageMap: function(pageUrlPattern) {

            var map = this.options.autofill.map;

            if (typeof pageUrlPattern !== "undefined") {
                return map[pageUrlPattern];
            } else {
                return map;
            }
        },

        /**
         * Check if current page matches enabled pages with form fields to auto fill
         */
        _onSelectorChange: function(e) {
            var selectedPersona = e.target.selectedOptions[0];
            var personaData = JSON.parse(selectedPersona.getAttribute('data-autofill-fields'));

            if (personaData != null) {
                this.options.autofill.selectedPersona = selectedPersona;
                this.options.autofill.personaData = personaData;

                this._fillFormFields();
                $(this.options.autofill.autofillListSelector).val(e.target[0].value);
            }
        },

        /**
         * Fill the form fields with selected data
         */
        _fillFormFields: function() {

            var personaData = this.options.autofill.personaData;
            var pageMap = this.options.autofill.currentPageMap;

            //console.debug(personaData);
            //console.debug(pageMap);

            // iterate over forms on this page to fill
            for (var formSelector in pageMap) {

                // iterate over fields to fill in the form
                for (var fieldSelector in pageMap[formSelector]) {
                    var field = $(formSelector + ' ' + fieldSelector);
                    var newValue = personaData[pageMap[formSelector][fieldSelector]];

                    //console.debug(field);
                    //console.debug(newValue);

                    // Fill in the field with the value from the persona selected
                    field.val(newValue);
                    //if (field.is("select")) {
                        field.trigger('change');
                    //}
                }
            }
        }
    });

    return {
        'magentoeseAutofillSelector': $.magentoeseAutofill.selector
    };
});