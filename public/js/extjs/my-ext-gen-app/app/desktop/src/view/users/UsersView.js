Ext.define('MyExtGenApp.view.users.UsersView', {
    extend: 'Ext.panel.Panel',
    xtype: 'usersview',

    requires: [
        'Ext.layout.HBox',
        'Ext.layout.VBox',
        'Ext.grid.Grid',
        'MyExtGenApp.view.users.education.EducationViewStore',
        'MyExtGenApp.view.users.UsersViewModel',
        'Ext.grid.rowedit.Plugin',
        'Ext.grid.plugin.PagingToolbar'
    ],
    controller: {
        type: 'usersviewcontroller',
    },
    viewModel: {
        type: 'usersviewmodel',
    },

    bodyPadding: 10,
    defaultType: 'panel',

    layout: {
        type: 'vbox'
    },

    items: [
        /*********************************************
         *  Users Main Grid
         *********************************************/
        {
            xtype: 'grid',
            title: 'Список пользователей',
            flex: 2,

            store: {
                type: 'usersviewstore',
                // autoLoad: true
            },
            grouped: true,
            groupFooter: {
                xtype: 'gridsummaryrow'
            },
            plugins: {
                rowedit: {
                    autoConfirm: true
                },
                gridpagingtoolbar: true,
            },
            // referenceHolder: true,
            reference: 'mainUsersGrid',

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
                        type: 'eduviewstore',
                    },
                    viewModel: {
                        type: 'usersviewmodel',
                    },
                    valueField: 'name',
                    displayField:'name',
                },

            }, {
                text: 'Город',
                dataIndex: 'cities',
                width: 300,
                flex: 1
            }],
            listeners: {
                'edit': 'onGridRowEdit'
            }
    },

        /*********************************************
         *  Filters Block
         *********************************************/
        {
            flex: 1,
            layout: {
                type: 'hbox'
            },

            defaults: {
                bodyPadding: 10,
                border: true
            },

            items: [
                /*********************************************
                 *  Education filter
                 *********************************************/
                {
                    title: 'Образование',
                    flex: 1,
                    xtype: 'grid',
                    reference: 'educationFilter',

                    store: {
                        type: 'eduviewstore',
                    },

                    columns: [{
                        text: 'id',
                        width: 50,
                        dataIndex: 'id',
                        hidden: true,
                    }, {
                        text: 'Образование',
                        dataIndex: 'name',
                        flex: 1,
                    }],
                    selectable: {
                        checkbox: true,
                        rows: true
                    },
                    listeners: {
                        'selectionchange': 'updateUserGridFilter'
                    }
                },

                /*********************************************
                 *  Cities filter
                 *********************************************/
                {
                    title: 'Города',
                    flex: 1,
                    xtype: 'grid',
                    reference: 'citiesFilter',

                    store: {type: 'citiesviewstore'},

                    columns: [{
                        text: 'id',
                        width: 50,
                        dataIndex: 'id',
                        hidden: true,
                    }, {
                        text: 'Город',
                        dataIndex: 'name',
                        flex: 1,
                    }],
                    selectable: {
                        checkbox: true,
                        rows: true
                    },
                    listeners: {
                        'selectionchange': 'updateUserGridFilter'
                    }
                }
            ]
        }
    ]
});
