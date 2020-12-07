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

    updateUserGridFilter: function () {
        const store = this.lookup('mainUsersGrid').getStore();
        let educationArray = Array(),
            citiesArray = Array();

        store.clearFilter();

        this.lookup('educationFilter').getSelections().forEach(e => {
            educationArray.push(e.getData().id);
        });

        this.lookup('citiesFilter').getSelections().forEach(e => {
            citiesArray.push(e.getData().name);
        });

        store.filterBy(function (item) {
            let isEducationFound = educationArray.includes(item.getData().eduid) | educationArray.length === 0,
                isCityFound = citiesArray.some(function (city) {
                    return item.getData().cities.indexOf(city) !== -1;
                }) | citiesArray.length === 0;
            return !!(isEducationFound & isCityFound);
        });
    }

});
