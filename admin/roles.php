<?php
/*
** Let Editors edit theme options
*/
$role = get_role('editor');
$role->add_cap('edit_theme_options');
