<?php

// Start
ob_start();

// Define
define( 'CUZTOM_VERSION', '0.9.3' );
if( ! defined( 'CUZTOM_TEXTDOMAIN' ) ) define( 'CUZTOM_TEXTDOMAIN', 'cuztom' );
if( ! defined( 'CUZTOM_JQUERY_UI_STYLE' ) ) define( 'CUZTOM_JQUERY_UI_STYLE', 'cuztom' );

// Include
function cuztom_field( $field_id_name, $field, $meta )
{
	echo Cuztom_Field::output( $field_id_name, $field, $meta );
}

/**
 * General class with main methods and helper methods
 *
 * @author Gijs Jorissen
 * @since 0.2
 *
 */
class Cuztom
{
	var $dir = array();
	
	/**
	 * Contructs the Cuztom class
	 * Adds actions
	 *
	 * @author Gijs Jorissen
	 * @since 0.3
	 *
	 */
	function __construct()
	{
		// Determine the full path to the this folder
		$this->_determine_cuztom_dir( dirname( __FILE__ ) );
	}
	


	
	
	/**
	 * Beautifies a string. Capitalize words and remove underscores
	 *
	 * @param string $string
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	static function beautify( $string )
	{
		return ucwords( str_replace( '_', ' ', $string ) );
	}
	
	
	/**
	 * Uglifies a string. Remove underscores and lower strings
	 *
	 * @param string $string
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	static function uglify( $string )
	{
		return strtolower( preg_replace( '/[^A-z0-9]/', '_', $string ) );
	}
	
	
	/**
	 * Makes a word plural
	 *
	 * @param string $string
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	static function pluralize( $string )
	{
		$last = $string[strlen( $string ) - 1];
		
		if( $last != 's' )
		{
			if( $last == 'y' )
			{
				$cut = substr( $string, 0, -1 );
				//convert y to ies
				$plural = $cut . 'ies';
			}
			else
			{
				// just attach a s
				$plural = $string . 's';
			}

			return $plural;
		}
		
		return $string;
	}
	
	
	/**
	 * Recursive method to determine the path to the Cuztom folder
	 *
	 * @param string $path
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.4.1
	 *
	 */
	function _determine_cuztom_dir( $path = __FILE__ )
	{
		$path = dirname( $path );
		$path = str_replace( '\\', '/', $path );
		$explode_path = explode( '/', $path );
		
		$current_dir = $explode_path[count( $explode_path ) - 1];
		array_push( $this->dir, $current_dir );
		
		if( $current_dir == 'wp-content' )
		{
			// Build new paths
			$path = '';
			$directories = array_reverse( $this->dir );
			
			foreach( $directories as $dir )
			{
				$path = $path . '/' . $dir;
			}

			$this->dir = $path;
		}
		else
		{
			return $this->_determine_cuztom_dir( $path );
		}
	}		
}


/**
 * Post Type class used to register post types
 * Can call add_taxonomy and add_meta_box to call the associated classes
 * Method chaining is possible
 *
 * @author Gijs jorissen
 * @since 0.1
 *
 */
class Cuztom_Post_Type
{
	var $post_type_name;
	var $post_type_args;
	var $post_type_labels;
	
	
	/**
	 * Construct a new Custom Post Type
	 *
	 * @param string $name
	 * @param array $args
	 * @param array $labels
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function __construct( $name, $args = array(), $labels = array() )
	{
		if( ! empty( $name ) )
		{
			// Set some important variables
			$this->post_type_name		= Cuztom::uglify( $name );
			$this->post_type_args 		= $args;
			$this->post_type_labels 	= $labels;

			// Add action to register the post type, if the post type doesnt exist
			if( ! post_type_exists( $this->post_type_name ) )
			{
				add_action( 'init', array( &$this, 'register_post_type' ) );
			}
		}
	}
	
	
	/**
	 * Register the Post Type
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function register_post_type()
	{		
		// Capitilize the words and make it plural
		$name 		= Cuztom::beautify( $this->post_type_name );
		$plural 	= Cuztom::pluralize( $name );

		// We set the default labels based on the post type name and plural. 
		// We overwrite them with the given labels.
		$labels = array_merge(

			// Default
			array(
				'name' 					=> $plural. 'post type general name',
				'singular_name' 		=> $name. 'post type singular name',
				'add_new' 				=> 'Add New'. strtolower( $name ),
				'add_new_item' 			=> 'Add New ' . $name,
				'edit_item' 			=> 'Edit ' . $name,
				'new_item' 				=> 'New ' . $name,
				'all_items' 			=> 'All ' . $plural,
				'view_item' 			=> 'View ' . $name,
				'search_items' 			=> 'Search ' . $plural,
				'not_found' 			=> 'No ' . strtolower( $plural ) . ' found',
				'not_found_in_trash' 	=> 'No ' . strtolower( $plural ) . ' found in Trash', 
				'parent_item_colon' 	=> '',
				'menu_name' 			=> $plural
			),

			// Given labels
			$this->post_type_labels

		);

		// Same principle as the labels. We set some default and overwite them with the given arguments.
		$args = array_merge(

			// Default
			array(
				'label' 				=> $plural,
				'labels' 				=> $labels,
				'public' 				=> true,
				'supports' 				=> array( 'title', 'editor', 'thumbnail' ),
			),

			// Given args
			$this->post_type_args

		);

		// Register the post type
		register_post_type( $this->post_type_name, $args );
	}
	
	
	/**
	 * Add a taxonomy to the Post Type
	 *
	 * @param string $name
	 * @param array $args
	 * @param array $labels
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function add_taxonomy( $name, $args = array(), $labels = array() )
	{
		// Call Cuztom_Taxonomy with this post type name as second parameter
		$taxonomy = new Cuztom_Taxonomy( $name, $this->post_type_name, $args, $labels );
		
		// For method chaining
		return $this;
	}
	
    
}


/**
 * Creates custom taxonomies
 *
 *
 * @author Gijs Jorissen
 * @since 0.2
 *
 */
class Cuztom_Taxonomy
{
	var $taxonomy_name;
	var $taxonomy_labels;
	var $taxonomy_args;
	var $post_type_name;
	
	
	/**
	 * Constructs the class with important vars and method calls
	 * If the taxonomy exists, it will be attached to the post type
	 *
	 * @param string $name
	 * @param string $post_type_name
	 * @param array $args
	 * @param array $labels
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function __construct( $name, $post_type_name = null, $args = array(), $labels = array() )
	{
		if( ! empty( $name ) )
		{
			$this->post_type_name = $post_type_name;
			
			// Taxonomy properties
			$this->taxonomy_name		= Cuztom::uglify( $name );
			$this->taxonomy_labels		= $labels;
			$this->taxonomy_args		= $args;

			if( ! taxonomy_exists( $this->taxonomy_name ) )
			{
				add_action( 'init', array( &$this, 'register_taxonomy' ) );
			}
			else
			{
				add_action( 'init', array( &$this, 'register_taxonomy_for_object_type' ) );
			}
		}
	}
	
	
	/**
	 * Registers the custom taxonomy with the given arguments
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function register_taxonomy()
	{
		$name 		= Cuztom::beautify( $this->taxonomy_name );
		$plural 	= Cuztom::pluralize( $name );

		// Default labels, overwrite them with the given labels.
		$labels = array_merge(

			// Default
			array(
				'name' 					=> $plural. 'taxonomy general name',
				'singular_name' 		=> $name. 'taxonomy singular name', 
			    'search_items' 			=> 'Search ' . $plural,
			    'all_items' 			=> 'All ' . $plural,
			    'parent_item' 			=> 'Parent ' . $name,
			    'parent_item_colon' 	=> 'Parent ' . $name . ':',
			    'edit_item' 			=> 'Edit ' . $name, 
			    'update_item' 			=> 'Update ' . $name,
			    'add_new_item' 			=> 'Add New ' . $name,
			    'new_item_name' 		=> 'New ' . $name . ' Name',
			    'menu_name' 			=> $name,
			),

			// Given labels
			$this->taxonomy_labels

		);

		// Default arguments, overwitten with the given arguments
		$args = array_merge(

			// Default
			array(
				'label'					=> $plural,
				'labels'				=> $labels,
				"hierarchical" 			=> true,
				'public' 				=> true,
				'show_ui' 				=> true,
				'show_in_nav_menus' 	=> true,
				'_builtin' 				=> false,
			),

			// Given
			$this->taxonomy_args

		);
		
		register_taxonomy( $this->taxonomy_name, $this->post_type_name, $args );
	}
	
	
	/**
	 * Used to attach the existing taxonomy to the post type
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function register_taxonomy_for_object_type()
	{
		register_taxonomy_for_object_type( $this->taxonomy_name, $this->post_type_name );
	}	
}




/**
* Registers a Post Type
*
* @param string|array $name
* @param array $args
* @param array $labels
* @return object Cuztom_Post_Type
*
* @author Gijs Jorissen
* @since 0.8
*
*/
function register_cuztom_post_type( $name, $args = array(), $labels = array() )
{
    $post_type = new Cuztom_Post_Type( $name, $args, $labels );
    
    return $post_type;
}

/**
* Registers a Taxonomy for a Post Type
*
* @param string $name
* @param string $post_type_name
* @param array $args
* @param array $labels
* @return object Cuztom_Taxonomy
*
* @author Gijs Jorissen
* @since 0.8
*
*/

function register_cuztom_taxonomy( $name, $post_type_name, $args = array(), $labels = array() )
{
    $taxonomy = new Cuztom_Taxonomy( $name, $post_type_name, $args, $labels );

    return $taxonomy;
}


