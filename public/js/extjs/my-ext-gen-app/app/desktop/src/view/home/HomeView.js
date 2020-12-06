Ext.define('MyExtGenApp.view.home.HomeView',{
    xtype: 'homeview',
    cls: 'homeview',
    controller: {type: 'homeviewcontroller'},
    viewModel: {type: 'homeviewmodel'},
    requires: [],
    extend: 'Ext.Container',
    scrollable: true,
    html: `<p>Ext JS 7.2 Modern Desktop.</p>
    <p>BackEnd: zendframework/zend-expressive</p>
    `
});