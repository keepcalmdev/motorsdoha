<?php
if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class DUS_Order_List_Table extends WP_List_Table {

    function __construct() {
        
        global $status, $page;

        parent::__construct ( array (
            'singular' => 'urllist', //singular name of the listed records
            'plural' => 'urllist', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ) );
        
    }

    function column_default ( $item, $column_name ) {
        
        date_default_timezone_set ( 'Asia/Calcutta' );
		
		$length = 45;
		$meta_title = strlen($item['meta_title'])<=$length ? $item['meta_title'] : substr($item['meta_title'],0,$length) . '...';
		$meta_keyword = strlen($item['meta_keyword'])<=$length ? $item['meta_keyword'] : substr($item['meta_keyword'],0,$length) . '...';
		$meta_description = strlen($item['meta_description'])<=$length ? $item['meta_description'] : substr($item['meta_description'],0,$length) . '...';
        
		$meta_robots_index = !empty($item['meta_robots_index']) ? $item['meta_robots_index'] : '';
		$meta_robots_follow = !empty($item['meta_robots_follow']) ? $item['meta_robots_follow'] : '';
		$meta_robots_noodp = !empty($item['meta_robots_noodp']) ? $item['meta_robots_noodp'] : '';
		$meta_robots_noydir = !empty($item['meta_robots_noydir']) ? $item['meta_robots_noydir'] : '';
		
		$merge_robots = array($meta_robots_index, $meta_robots_follow, $meta_robots_noodp, $meta_robots_noydir);
		$merge_robots = array_filter($merge_robots);
		$merge_robots = implode(', ', $merge_robots);
		
        switch ( $column_name ) {
            case 'url' :
                //return '<a class="row-title" href="'.site_url('/wp-admin/admin.php?page=dynamic_url_seo_add_new').'&id='.$item['id'].'&action=edit">'.$item['url'].'</a>';
                return $item['url'];
            case 'meta_title' :
                return $meta_title;
            case 'meta_keyword' :
                return $meta_keyword;
            case 'meta_description' :
                return $meta_description;
            case 'canonical_url' :
                return $item['canonical_url'];
            case 'meta_robots_index' :
                return $merge_robots;
            default:
                return print_r ( $item , true );
        }
        
    }



function column_url( $item ) {
        $url = admin_url( 'admin.php?page=dynamic_url_seo_add_new&id=' . absint( $item['id'] ) );
        $edit_link = add_query_arg( array( 'action' => 'edit' ), $url );
		$delet_url = admin_url( 'admin.php?page=dynamic_url_seo_listing_page&&action=dus_delete&id=' . absint( $item['id'] ) );

        $output = sprintf(
            '<a class="row-title" href="%1$s" title="%2$s">%3$s</a>',
            esc_url( $edit_link ),
            esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'dynamic-url-seo' ),
                $item['url'] ) ),
            esc_html( $item['url'] ) );
			
			

        $output = sprintf( '<strong>%s</strong>', $output );

        $actions = array(
            'edit' => sprintf( '<a href="%1$s">%2$s</a>',
                esc_url( $edit_link ),
                esc_html( __( 'Edit', 'dus' ) ) ),
			'view' => sprintf( '<a href="%1$s" target="_blank">%2$s</a>',
                esc_url( $item['url'] ),
                esc_html( __( 'View', 'dus' ) ) ),
			'delete' => sprintf( '<a href="%1$s">%2$s</a>',
                esc_url( $delet_url ),
                esc_html( __( 'Delete', 'dus' ) ) )
				);

        $output .= $this->row_actions( $actions );

        return $output;
    }
    
    function column_cb( $item ){
        
        return sprintf (
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args [ 'singular' ],  //Let's simply repurpose the table's singular label ("movie")
            $item['id']   //The value of the checkbox should be the record's id
        );
        
    }

    function get_columns() {
        
        $columns = array (
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'url' => 'URL',
            'meta_title' => 'Meta Title',
            'meta_keyword' => 'Meta Keyword',
            'meta_description' => 'Meta Description',
            'canonical_url' => 'Canonical URL',
            'meta_robots_index' => 'Robots Meta'
            //'action' => 'Action'
        );
        
        return $columns;
        
    }

    function get_sortable_columns() {
        
        $sortable_columns = array (
            'url' => array ( 'url', false ) //true means it's already sorted
        );
        
        return $sortable_columns;
        
    }

    function get_bulk_actions() {
        
        $actions = array (
            'delete' => 'Delete'
        );
        
        return $actions;
        
    }

    function process_bulk_action() {
        
        global $wpdb;
        $dynamic_custom_url_seo = $wpdb->prefix . 'dynamic_custom_url_seo';
        if ( 'delete' === $this->current_action() ) {
            $ids = isset ( $_REQUEST['urllist'] ) ? $_REQUEST['urllist'] : array();
            $id = implode ( ',', $ids );
            if ( !empty ( $id ) ) {
                $wpdb->query ( "DELETE FROM $dynamic_custom_url_seo WHERE id IN ( $id ) " );
            }
        }
        
    }

    function prepare_items() {
        
        global $wpdb;
        $dynamic_custom_url_seo = $wpdb->prefix . 'dynamic_custom_url_seo'; // do not forget about tables prefix

        $per_page = 10; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = $wpdb->get_var ( "SELECT COUNT(id) FROM $dynamic_custom_url_seo " );

        // prepare query params, as usual current page, order by and order direction
        $do_search = '';
        $url_name = ( isset( $_REQUEST['search_url_name'] ) ) ? sanitize_text_field( $_REQUEST['search_url_name'] ) : false;
        $do_search = ( $url_name ) ? $wpdb->prepare(" AND url LIKE '%s' ", $url_name ) : '';

        $paged = isset ( $_REQUEST['paged']) ? max ( 0, intval ( $_REQUEST['paged'] ) - 1) : 0;
        $offset = $paged * $per_page;
        $orderby = ( isset ( $_REQUEST['orderby'] ) && in_array ( $_REQUEST['orderby'], array_keys ( $this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'url';
        $order = ( isset ( $_REQUEST['order'] ) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        $this->items = $wpdb->get_results ( $wpdb->prepare ( "SELECT * FROM $dynamic_custom_url_seo WHERE 1=1 $do_search ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $offset), ARRAY_A );
        // [REQUIRED] configure pagination
        $this->set_pagination_args ( array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil ( $total_items / $per_page) // calculate pages count
        ) );
    }

}

function dus_admin_menu()
{
    add_menu_page( 'Dynamic URl SEO Settings', 'Dynamic URL SEO', 'manage_options', 'dynamic_url_seo_listing_page', 'dus_list_page' );
}
add_action( 'admin_menu', 'dus_admin_menu' );

function dus_list_page() {
	ob_start();
    //Create an instance of our package class...
    $dusListTable = new DUS_Order_List_Table();
    //Fetch, prepare, sort, and filter our data...
    add_thickbox();
    $dusListTable->prepare_items();
    $url_name = ( isset( $_REQUEST['search_url_name'] ) ) ? $_REQUEST['search_url_name'] : false;
	
	if(isset($_REQUEST['action'])){
		if($_REQUEST['action'] == 'dus_delete' && !empty($_REQUEST['id'])) {
			if(is_user_logged_in())
			{
				if(current_user_can('administrator'))
				{
					global $wpdb;
					$delID = absint($_REQUEST['id']);
					$dynamic_custom_url_seo = $wpdb->prefix . 'dynamic_custom_url_seo';
					if ( !empty ( $delID ) ) {
							$del_query = $wpdb->query ( "DELETE FROM $dynamic_custom_url_seo WHERE id IN ( $delID ) " );
							if(!empty($del_query)) {
								echo dus_single_url_delete_redirect();
							}
					}
				}
			}
		}
	}
    ?>
<div class="wrap">
        <h1 class="wp-heading-inline"> <?php _e ( 'Dynamic Custom URL ' ); ?> </h1>
        <a href="<?php echo site_url('/wp-admin/admin.php?page=dynamic_url_seo_add_new'); ?>" class="page-title-action">Add New</a>
		<?php
			if(isset($_REQUEST['action'])){
				if($_GET["action"] == 'delete_url') {
					echo '<hr class="wp-header-end">';
					echo '<div id="message" class="updated notice is-dismissible"><p>1 Page/Post URL deleted</p></div>';
				}
			}
		?>
        <form id="urllist-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <p class="search-box">
                <label class="screen-reader-text" for="post-search-input">Search URL:</label>
                <input type="text" id="search_url_name" name="search_url_name" value="<?php echo $url_name; ?>" placeholder="URL">
                <input type="submit" id="search-submit" class="button" value="Search">
            </p>
			<?php $dusListTable->display() ?>
        </form>
	</div>
    <?php
}