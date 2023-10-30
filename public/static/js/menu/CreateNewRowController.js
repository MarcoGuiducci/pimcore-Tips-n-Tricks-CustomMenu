pimcore.registerNS("pimcore.plugin.CustomMenu.createNewRowController");

Ext.define('pimcore.plugin.CustomMenu.createNewRowController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.createnewrow-controller',

    onConfirm: function (object) {
        var form = object.up('form').getForm();
        var awg = form.findField('awg').getValue();
        var mm2 = form.findField('mm2').getValue();
        Ext.Ajax.request({
            url: "/admin/custom-menu/create-awgMm2-row",
            params: {
                awg: awg,
                mm2: mm2
            },
            success: function (data) {
                var result = JSON.parse(data.responseText);
                var data = result.data;

                Ext.getCmp('create-new-row').close();
                var store = Ext.getStore('storeId');
                var grid = Ext.getStore('grid2');
                store.loadData(data, false);
                grid.reconfigure(store);
                store.reload();

                pimcore.layout.refresh();
            }
        });
    }
});