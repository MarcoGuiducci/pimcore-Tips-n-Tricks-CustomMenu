pimcore.registerNS("pimcore.plugin.CustomMenu");

pimcore.plugin.CustomMenu = Class.create({
    initialize: function () {
        document.addEventListener(pimcore.events.preMenuBuild, this.preMenuBuild.bind(this));    
    },

    preMenuBuild: function (e) {
        // the event contains the existing menu
        let menu = e.detail.menu;

        // the property name is used as id with the prefix pimcore_menu_ in the html markup e.g. pimcore_menu_mybundle
        menu.custommenu = {
            label: t('Custom Settings'), // set your label here, will be shown as tooltip
            iconCls: 'pimcore_nav_icon_properties', // set full icon name here
            priority: 42, // define the position where you menu should be shown. Core menu items will leave a gap of 10 custom main menu items
            items: [], //if your main menu has subitems please see Adding Custom Submenus To ExistingNavigation Items 
            shadow: false,
            handler: this.openCustomMenu, // defining a handler will override the standard "showSubMenu" functionality, use in combination with "noSubmenus"
            noSubmenus: true, // if there are no submenus set to true otherwise menu won't show up
            cls: "pimcore_navigation_flyout", // use pimcore_navigation_flyout if you have subitems
        };
    },

    openCustomMenu: function(element) {
        try {
            pimcore.globalmanager.get("plugin_pimcore_custommenu").activate();
        } catch (e) {
            pimcore.globalmanager.add("plugin_pimcore_custommenu", new pimcore.plugin.CustomMenu.settings());
        }
    }
});

var CustomMenuPlugin = new pimcore.plugin.CustomMenu();