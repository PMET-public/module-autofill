define([
    'jquery',
    'jquery/ui'
], function($){
    "use strict";

    $.widget('magentoeseAutofill.selector', {
        options: {
        },

        /**
         * Creates widget 'magentoeseAutofill.selector'
         * @private
         */
        _create: function () {
            alert('Selector has been initialized');
        },

        /**
         * Check if module is enabled
         */
        _isEnabled: function() {
            alert('Module is enabled');
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
        _setPersonaSelected: function() {
            alert('Persona Selected');
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