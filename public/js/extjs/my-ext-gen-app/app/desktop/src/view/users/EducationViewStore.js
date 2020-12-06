Ext.define('MyExtGenApp.view.users.EducationViewStore', {
    extend: 'Ext.data.Store',
    alias: 'store.educationviewstore',

    fields: [ 'id', 'name'],

    pageSize: 500,
    autoLoad: true,

    proxy: {
        type: 'ajax',
        api: {
            read: '/xhr?action=education'
        },
        reader: {
            type: 'json',
            successProperty: 'success',
            rootProperty: 'items',
        },
    },

});
