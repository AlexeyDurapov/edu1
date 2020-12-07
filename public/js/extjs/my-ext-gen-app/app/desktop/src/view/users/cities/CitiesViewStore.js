Ext.define('MyExtGenApp.view.users.cities.CitiesViewStore', {
    extend: 'Ext.data.Store',
    alias: 'store.citiesviewstore',

    fields: [ 'id', 'name'],

    pageSize: 500,
    autoLoad: true,

    proxy: {
        type: 'ajax',
        api: {
            read: '/xhr?action=cities'
        },
        reader: {
            type: 'json',
            successProperty: 'success',
            rootProperty: 'items',
        },
    },

});
