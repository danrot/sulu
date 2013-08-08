/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART Webservices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

define(['app', 'router', 'backbone', 'husky'], function (App, Router, Backbone, Husky) {

    'use strict';

    return Backbone.View.extend({
        initialize: function () {
            this.render();
        },

        render: function () {
            this.$el.removeData('Husky.Ui.DataGrid');
            var dataGrid = this.$el.huskyDataGrid({
                url: '/translate/api/packages',
                pagination: false,
                showPages: 6,
                pageSize: 4,
                selectItems: {
                    type: 'checkbox'
                }
            });

            dataGrid.data('Husky.Ui.DataGrid').on('data-grid:item:select', function (item) {
                Router.navigate('settings/translate/edit:' + item);
            });
        }
    });
});
