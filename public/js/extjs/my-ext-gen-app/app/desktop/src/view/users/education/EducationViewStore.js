Ext.define('MyExtGenApp.view.users.education.EducationViewStore', {
    extend: 'Ext.data.Store',
    alias: 'store.eduviewstore',

    fields: [ 'id', 'name'],

    pageSize: 100,
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
