define([
    'jquery',
    'jquery/ui'
], function($){
    "use strict";

    $.widget('magentoeseAutofill.selector', {
        options: {
            autofill: {
                autofillListSelector: '#autofill_list',
                selectedPersona: '',
                personaData: ''
            }
        },

        /**
         * Creates widget 'magentoeseAutofill.selector'
         * @private
         */
        _create: function () {
            if (this._isEnabled()) {
                var events = {};
                events['change ' + this.options.autofill.autofillListSelector] = function(e) {
                    var selectedPersona = e.target.selectedOptions[0];

                    // <option value="9" data-autofill-fields='{"firstname":"Andy","lastname":"Lewis"}'>Andy</option>
                    // selectedPersona.dataset.autofillFields = {"firstname":"Andy","lastname":"Lewis"}

                    var personaData = selectedPersona.attr('data-autofill-fields');
                    this._setPersonaSelected(selectedPersona, personaData);
                };

                this._on(events);
            }
        },

        /**
         * Check if module is enabled
         */
        _isEnabled: function() {
            var autofillDiv = $(this.options.autofill.autofillListSelector).parent();
            if (autofillDiv.attr('data-autofill-enabled') == 'true') {
                console.debug('autofill enabled');
                return true;
            }
            else {
                console.debug('autofill disabled');
                return false;
            }
        },

        /**
         * Check if current page matches enabled pages with form fields to auto fill
         */
        _isAutoFillPage: function() {
            alert('Is an Auto Fill Page');
        },

        /**
         * Set persona selected for auto fill
         */
        _setPersonaSelected: function(option, persona) {
            this.options.autofill.selectedPersona = option;
            console.debug(option);
            this.options.autofill.personaData = persona;
            console.debug(persona);
        },

        /**
         * Fill the form fields with selected data
         */
        _fillFormFields: function() {
            alert('Fill the form fields');
        }
    });

    return {
        'magentoeseAutofillSelector': $.magentoeseAutofill.selector
    };
});