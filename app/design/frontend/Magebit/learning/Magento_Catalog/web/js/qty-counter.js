define(['jquery', 'uiComponent', 'ko'], function ($, Component, ko) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Magento_Catalog/input-counter'
        }, initialize: function (config) {
            this._super();
            const self = this;
            self.quantity = ko.observable(1);
            this.stockQuantityCount = parseInt(config.stockQuantityCount);
            this.quantityMin = 1;
            self.quantity.subscribe(function (value) {
                self.validateCounter(value);
            });
        },

        decrementCounter: function () {
            if (this.quantity() - 1 < this.quantityMin) return;
            this.quantity(this.quantity() - 1);
        },

        incrementCounter: function () {
            let quantity = parseInt(this.quantity());
            if (quantity + 1 > this.stockQuantityCount) return;
            this.quantity(quantity + 1);
        },

        validateCounter: function (value) {
            if (value > this.stockQuantityCount) {
                this.quantity(this.stockQuantityCount);
            }

            if (value < this.quantityMin) {
                this.quantity(this.quantityMin);
            }
        }

    });
});
