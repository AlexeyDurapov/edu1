Ext.define('MyExtGenApp.view.users.UsersView',{
    extend: 'Ext.grid.Grid',
    xtype: 'usersview',

    requires: [
        'MyExtGenApp.view.users.UsersViewModel',
        // 'Ext.grid.plugin.Summary',
        'Ext.grid.rowedit.Plugin',
        'Ext.grid.plugin.PagingToolbar'
    ],
    controller: {
        type: 'usersviewcontroller',
    },
    viewModel: {
        type: 'usersviewmodel',
    },
    store: {
        type: 'usersviewstore',
        // autoLoad: true
    },
    grouped: true,
    groupFooter: {
        xtype: 'gridsummaryrow'
    },
    // items: [{
    //     xtype: 'toolbar',
    //     // title: 'Фильтр:',
    //     docked: 'top',
    //     items: [{
    //         xtype: 'selectfield',
    //         store: {
    //             type: 'educationviewstore',
    //             // autoLoad: true
    //         },
    //         viewModel: {
    //             type: 'usersviewmodel',
    //         },
    //         valueField: 'name',
    //         displayField:'name',
    //         label: 'Образование...',
    //         listeners: {
    //             change: 'onEducationFilterChange'
    //         }
    //     }]
    // }],
    plugins: {
        rowedit: {
            autoConfirm: true
        },
        gridpagingtoolbar: true,
        // gridsummaryrow: true
    },

    columns: [{
        text: '',
        width: 50,
        dataIndex: 'id'
    }, {
        text: 'ФИО',
        dataIndex: 'name',
        width: 200,
    }, {
        text: 'Образование',
        dataIndex: 'education',
        width: 300,
        editable: true,
        reference: 'educationSelect',

        editor: {
            xtype: 'selectfield',
            store: {
                type: 'educationviewstore',
            },
            viewModel: {
                type: 'usersviewmodel',
            },
            valueField: 'name',
            displayField:'name',
        },

    }, {
        text: 'Город',
        dataIndex: 'sities',
        width: 300,
        flex: 1
    }],
    listeners: {
        'edit': 'onGridRowEdit'
    }
});

