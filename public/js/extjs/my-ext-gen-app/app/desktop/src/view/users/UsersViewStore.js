Ext.define('MyExtGenApp.view.users.UsersViewStore', {
    extend: 'Ext.data.Store',
    alias: 'store.usersviewstore',

    autoLoad: true,
    autoSync: false,
    pageSize: 5,

    proxy: {
        type: 'ajax',
        api: {
            read: '/xhr?action=allusers',
            create: '',
            update: '/xhr?action=userupdate',
            destroy: ''
        },
        reader: {
            type: 'json',
            successProperty: 'success',
            rootProperty: 'data',
            totalProperty: 'totalCount',
        },
        writer: {
            type: 'json',
            writeAllFields: false,
            rootProperty: 'data'
        },
        listeners: {
            exception: function (proxy, response, operation) {
                Ext.Msg.show({
                    title: 'REMOTE EXCEPTION',
                    msg: operation.getError(),
                    icon: Ext.Msg.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        }
    }
});


