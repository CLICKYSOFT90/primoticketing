<?php

return array(
    array("module" => "Dashboard", "key" => "read", "name" => "View Dashboard","show"=>1,"organization"=>1,"other"=>1),

    array("module" => "Organizations", "key" => "create", "name" => "Add Organization","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "Organizations", "key" => "read", "name" => "View Organization","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "Organizations", "key" => "update", "name" => "Edit Organization","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "Organizations", "key" => "delete", "name" => "Delete Organization","show"=>1,"organization"=>0,"other"=>1),

    array("module" => "GlobalSettings", "key" => "create", "name" => "Add Global Settings","show"=>1,"organization"=>1,"other"=>0),
    array("module" => "GlobalSettings", "key" => "read", "name" => "View Global Settings","show"=>1,"organization"=>1,"other"=>0),
    array("module" => "GlobalSettings", "key" => "update", "name" => "Edit Global Settings","show"=>1,"organization"=>1,"other"=>0),
    array("module" => "GlobalSettings", "key" => "delete", "name" => "Delete Global Settings","show"=>1,"organization"=>1,"other"=>0),

    array("module" => "User", "key" => "create", "name" => "Add Users","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "User", "key" => "read", "name" => "View Users","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "User", "key" => "update", "name" => "Edit Users","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "User", "key" => "delete", "name" => "Delete Users","show"=>1,"organization"=>0,"other"=>1),

    array("module" => "Role", "key" => "create", "name" => "Add Roles","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "Role", "key" => "read", "name" => "View Roles","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "Role", "key" => "update", "name" => "Edit Roles","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "Role", "key" => "delete", "name" => "Delete Roles","show"=>1,"organization"=>0,"other"=>1),

    array("module" => "Flag", "key" => "create", "name" => "Add Flag","show"=>0,"organization"=>1,"other"=>1),
    array("module" => "Flag", "key" => "read", "name" => "View Flag","show"=>0,"organization"=>1,"other"=>1),
    array("module" => "Flag", "key" => "update", "name" => "Edit Flag","show"=>0,"organization"=>1,"other"=>1),
    array("module" => "Flag", "key" => "delete", "name" => "Delete Flag","show"=>0,"organization"=>1,"other"=>1),

    array("module" => "FlagType", "key" => "read", "name" => "View Flag Type","show"=>0,"organization"=>1,"other"=>1),
    array("module" => "FlagType", "key" => "update", "name" => "Edit Flag Type","show"=>0,"organization"=>1,"other"=>1),

    array("module" => "Menu", "key" => "read", "name" => "View Menus","show"=>0,"organization"=>1,"other"=>1),
    array("module" => "Menu", "key" => "update", "name" => "Edit Menus","show"=>0,"organization"=>1,"other"=>1),



    array("module" => "Configuration", "key" => "read", "name" => "View Configuration","show"=>0,"organization"=>1,"other"=>1),
    array("module" => "Configuration", "key" => "update", "name" => "Edit Configuration","show"=>0,"organization"=>1,"other"=>1),



    /*MASTER MENUS*/
    array("module" => "Menu", "key" => "admin/dashboard", "name" => "Show Dashboard Menu","show"=>1,"organization"=>1,"other"=>1),
    array("module" => "Menu", "key" => "admin/organization", "name" => "Show Organization Menu","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "Menu", "key" => "admin/globalSetting", "name" => "Show Global Setting Menu","show"=>1,"organization"=>1,"other"=>0),
    array("module" => "Menu", "key" => "admin/users", "name" => "Show Users Menu","show"=>1,"organization"=>0,"other"=>1),
    array("module" => "Menu", "key" => "admin/roles", "name" => "Show Roles Menu","show"=>1,"organization"=>0,"other"=>1),
    /*MASTER MENUS*/

    /*APPLICATION WIDE PERMISSIONS*/
    //array("module" => "System", "key" => "notification", "name" => "Show Notifications","show"=>1,"organization"=>1,"other"=>1),
);
