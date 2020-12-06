Ext.define('MyExtGenApp.view.users.UsersViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.usersviewcontroller',

    onGridRowEdit: function (grid, location) {
        location.record.set(
            'eduid',
            this.lookup('educationSelect').getEditor().getSelection().data.id
        );
        grid.getStore().sync();
    },

    // onEducationFilterChange: function (field, value) {
    //     var store = this.getView().getStore()
    //     store.clearFilter();
    //     store.filterBy(function (e) {
    //         console.log(e);
    //         return e.data.education == value;
    //     });
    // },

});
