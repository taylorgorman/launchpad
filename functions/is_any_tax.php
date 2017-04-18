<?php
/*
** Is taxonomy, including categories and tags
*/
function is_any_tax() {

	return ( is_category() || is_tag() || is_tax() );

}
