<?php
/*
** Register post type
*/
function lp_register_post_type( $args ) {

	$v = wp_parse_args( $args, array(
		'ID'            => ''
	,	'singular_name' => ''
	,	'plural_name'   => ''
	,	'labels'        => array()
	,	'supports'      => array()
	,	'arguments'     => array()
	) );

	// Singular name is essential
	if ( empty($v['singular_name']) )
		return false;

	// ID and plural default to singular
	if ( empty($v['ID']) )
		$v['ID'] = sanitize_title($v['singular_name']);
	if ( empty($v['plural_name']) )
		$v['plural_name'] = $v['singular_name'];

	// Uppercase names
	if ( empty($v['singular_name_uppercase']) )
		$v['singular_name_uppercase'] = ucwords($v['singular_name']);
	if ( empty($v['plural_name_uppercase']) )
		$v['plural_name_uppercase'] = ucwords($v['plural_name']);

	// Labels
	$v['labels'] = wp_parse_args( $v['labels'], array(
		'name'               => $v['plural_name_uppercase']
	,	'singular_name'      => $v['singular_name_uppercase']
	,	'add_new_item'       => 'Add New '.$v['singular_name_uppercase']
	,	'edit_item'          => 'Edit '.$v['singular_name_uppercase']
	,	'new_item'           => 'New '.$v['singular_name_uppercase']
	,	'view_item'          => 'View '.$v['singular_name_uppercase']
	,	'search_items'       => 'Search '.$v['plural_name_uppercase']
	,	'not_found'          => 'No '.$v['plural_name'].' found'
	,	'not_found_in_trash' => 'No '.$v['plural_name'].' found in Trash.'
	,	'parent_item_colon'  => 'Parent '.$v['singular_name_uppercase'].':'
	,	'all_items'          => 'All '.$v['plural_name_uppercase']
	) );

	// Register post type arguments
	$v['arguments'] = wp_parse_args( $v['arguments'], array(
		'labels'          => $v['labels']
	,	'supports'        => $v['supports']
	,	'public'          => true
	,	'menu_position'   => 20
	,	'hierarchical'    => false
	,	'has_archive'     => true
	,	'capability_type' => 'page'
	,	'rewrite'         => array(
			'with_front' => false
		)
	) );

	// Supports
	if ( empty( $v['supports'] ) ) {

		$v['supports'] = array(
			'title'
		,	'editor'
		,	'thumbnail'
		,	'excerpt'
		,	'revisions'
		);

		if ( $v['arguments']['hierarchical'] == false )
			$v['supports'][] = 'author';

		if ( $v['arguments']['hierarchical'] == true )
			$v['supports'][] = 'page-attributes';

	} $v['arguments']['supports'] = $v['supports'];

	// Go go gadget
	add_action( 'init', function() use ($v){
		register_post_type( $v['ID'], $v['arguments'] );
	} );

}


/*
** DO IT WITH AN OBJECT.
** Keeping this around for a while just for reference.
** Would comment the whole thing out, but there's too many other comments.
*/
abstract class bs_post_type {

	/*
	** Variables
	*/
	protected static $ID = null;
	protected static $singular_name = null;
	protected static $singular_name_uppercase = null;
	protected static $plural_name = null;
	protected static $plural_name_uppercase = null;
	protected static $labels = null;
	protected static $supports = null;
	protected static $remove_supports = null;
	protected static $arguments = null;

	/*
	** Registers the post type with WordPress.
	*/
	public static function register() {

		// Singular name is essential
		if ( empty(static::$singular_name) )
			return false;

		// ID can set itself
		if ( empty(static::$ID) )
			static::$ID = static::$singular_name;

		// Uppercase names
		if ( empty(static::$singular_name_uppercase) )
			static::$singular_name_uppercase = ucwords(static::$singular_name);
		if ( empty(static::$plural_name_uppercase) )
			static::$plural_name_uppercase = ucwords(static::$plural_name);

		// Labels
		$labels = wp_parse_args( static::$labels, array(
			'name'               => static::$plural_name_uppercase
		,	'singular_name'      => static::$singular_name_uppercase
		,	'add_new_item'       => 'Add New '.static::$singular_name_uppercase
		,	'edit_item'          => 'Edit '.static::$singular_name_uppercase
		,	'new_item'           => 'New '.static::$singular_name_uppercase
		,	'view_item'          => 'View '.static::$singular_name_uppercase
		,	'search_items'       => 'Search '.static::$plural_name_uppercase
		,	'not_found'          => 'No '.static::$plural_name.' found'
		,	'not_found_in_trash' => 'No '.static::$plural_name.' found in Trash.'
		,	'parent_item_colon'  => 'Parent '.static::$singular_name_uppercase.':'
		,	'all_items'          => 'All '.static::$plural_name_uppercase
		) );

		// Supports
		$supports = wp_parse_args( static::$supports, array(
			'title'
		,	'editor'
		,	'thumbnail'
		,	'excerpt'
		,	'revisions'
		) );

		// Register post type arguments
		$args = wp_parse_args( static::$arguments, array(
			'labels'          => $labels
		,	'supports'        => $supports
		,	'public'          => true
		,	'menu_position'   => 20
		,	'hierarchical'    => false
		,	'has_archive'     => true
		,	'capability_type' => 'page'
		,	'rewrite'         => array(
				'with_front' => false
			)
		) );

		// Conditional arguments
		if ($args['hierarchical'] == false)
			$args['supports'][] = 'author';

		if ($args['hierarchical'] == true)
			$args['supports'][] = 'page-attributes';

		/*
		if (!isset($args['rewrite']['slug']))
			$args['rewrite']['slug'] = strtolower($args['label']);
		*/

		register_post_type( static::$ID, $args );

	}


//-----------------------------------------------------------------------------
// ADD AND REMOVE FEATURES. IDK..
//-----------------------------------------------------------------------------

	/**
	 * Adds features to post type
	 * @access  public
	 */
	public static function add_supports() {
		if (!is_array(static::$supports)) return;
		foreach(static::$supports as $feature)
			add_post_type_support(static::$ID, $feature);
	}

	/**
	 * Removes features from post type
	 * @access public
	 */
	public static function remove_supports() {
		if (!is_array(static::$remove_supports)) return;
		foreach(static::$remove_supports as $feature)
			remove_post_type_support(static::$ID, $feature);
	}


//-----------------------------------------------------------------------------
// ADMIN LIST SCREEN CLEANUP
//-----------------------------------------------------------------------------

	/**
	 * Column IDs to remove from the admin archive page for this post type
	 * @var array
	 */
	protected static $columns_to_remove = array('comments');

	/**
	 * Column IDs => titles to add to the archive page for this post type
	 * @var array
	 */
	protected static $columns_to_add = array();

	/**
	 * Column IDs to move to the end of the table.
	 * @var array
	 */
	protected static $columns_to_end = array('author', 'date');

	/**
	 * Removes, adds and manipulates columns
	 * @access public
	 * @param  array $cols Column ids and titles
	 * @return array       The manipulated input array
	 */
	public static function manage_columns($cols) {

		//remove specified columns
		if (is_array(static::$columns_to_remove))
			foreach(static::$columns_to_remove as $col)
				unset($cols[$col]);

		//add columns
		if (is_array(static::$columns_to_add))
			foreach(static::$columns_to_add as $col => $name)
				$cols[$col] = $name;

		//move columns to end
		if (is_array(static::$columns_to_end))
			foreach (static::$columns_to_end as $col) {
				if (!array_key_exists($col, $cols)) continue;
				$val = $cols[$col];
				unset($cols[$col]);
				$cols[$col] = $val;
			}

		return $cols;
	}

	/**
	 * Set the value of a particular column for a particular post_id
	 * for this post type.
	 *
	 * @access public
	 */
	public static function column_values($col, $post_id) {
		//NOOP
		//Needs to be overridden in child class to manipulate
		//column values for this archive view
	}

//-----------------------------------------------------------------------------
// ADMIN EDIT SCREEN CLEANUP
//-----------------------------------------------------------------------------

	/**
	 * Override the default placeholder for the title on the post edit screen
	 * @var string
	 */
	protected static $title_prompt = false;

	/**
	 * IDs of the meta boxes to remove from the post edit screen
	 * @var array
	 */
	protected static $meta_boxes_to_remove = array(
		'postcustom'
	);

	/**
	 * Whether or not to move the revisions meta box to the sidebar
	 * @var boolean
	 */
	protected static $move_revisions_meta_box = true;


	/**
	 * Whether or not to move the author meta box to the sidebar
	 * @var boolean
	 */
	protected static $move_author_meta_box = true;

	/**
	 * Whether or not to move the slug meta box to the sidebar
	 * @var boolean
	 */
	protected static $move_slug_meta_box = true;

	/**
	 * Changes the title placeholder to the override specified
	 * @access public
	 * @param  string $prompt The current prompt value
	 * @return string         The updated prompt value
	 */
	public final static function enter_title_here($prompt) {
		$new = trim(static::$title_prompt);
		return '' === $new || !static::is_this_cpt()
			? $prompt
			: $new;
	}

	/**
	 * Remove meta boxes from the post edit screen
	 * @access public
	 */
	public final static function remove_meta_boxes() {
		if (!static::is_this_cpt()) return;
		if (is_array(static::$meta_boxes_to_remove))
			foreach(static::$meta_boxes_to_remove as $box) {
				remove_meta_box($box, static::$ID, 'normal');
				remove_meta_box($box, static::$ID, 'side');
			}
	}

	/**
	 * Move meta boxes on the pot edit screen
	 * @access public
	 */
	public final static function move_meta_boxes() {
		if (!static::is_this_cpt()) return;

		$relocations = array(
			'revisions' => array(
				'revisionsdiv',
				'Revisions',
				'post_revisions_meta_box',
				static::$ID,
				'side',
				'low'
			),
			'author' => array(
				'authordiv',
				'Author',
				'post_author_meta_box',
				static::$ID,
				'side',
				'high'
			),
			'slug' => array(
				'slugdiv',
				'Slug',
				'post_slug_meta_box',
				static::$ID,
				'side',
				'high'
			)
		);

		if (!static::$move_revisions_meta_box) unset($relocations['revisions']);
		if (!static::$move_author_meta_box) unset($relocations['author']);
		if (!static::$move_slug_meta_box) unset($relocations['slug']);

		foreach($relocations as $support => $args) {
			if ('slug' !== $support && !post_type_supports(static::$ID, $support)) continue;
			remove_meta_box($args[0], static::$ID, 'normal');
			call_user_func_array('add_meta_box', $args);
		}
	}

//-----------------------------------------------------------------------------
// MAIN QUERY CHANGES
//-----------------------------------------------------------------------------

	/**
	 * Overrides the number of posts displayed on an archive page
	 * @var int
	 */
	protected static $archive_quantity = false;

	/**
	 * Sets the number of posts displayed on an archive page
	 * @access public
	 */
	public final static function change_get_posts($query) {

		// Not admin, post type check
		if (is_admin()) return;
		if ($query->get('post_type') != static::$ID) return;

		if ( is_post_type_hierarchical($query->get('post_type')) ) {
			$query->set('orderby', 'menu_order');
			$query->set('order', 'ASC');
		}

		// Main query, archive
		if (!$query->is_main_query()) return;
		if (!$query->is_archive()) return;

		if ( static::$archive_quantity )
			$query->set('posts_per_page', (int)static::$archive_quantity);

	}

	/*
	** Checks whether or not the current screen is for this post type
	*/
	protected static function is_this_cpt() {
		global $post_type;
		return $post_type == static::$ID;
	}

	/*
	** Initialization
	*/
	public static function initialize() {

		$class = get_called_class();

		add_action( 'init', array($class, 'register') );
		add_action( 'init', array($class, 'add_supports') );
		add_action( 'init', array($class, 'remove_supports') );

		add_filter( 'manage_edit-'.static::$ID.'_columns', array($class, 'manage_columns') );
		add_action( 'manage_'.static::$ID.'_posts_custom_column', array($class, 'column_values'), 10, 2 );

		add_filter( 'enter_title_here', array($class, 'enter_title_here') );

		add_action( 'do_meta_boxes', array($class, 'move_meta_boxes') );
		add_action( 'do_meta_boxes', array($class, 'remove_meta_boxes') );

		add_action( 'pre_get_posts', array($class, 'change_get_posts') );

	}

}
