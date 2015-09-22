<?
class Validator {
    //new isUrl validation
    //better use filter_var than preg_match
    
	function isUrl($str = '') {
        if (filter_var($str, FILTER_VALIDATE_URL) === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	

    //You can change the error message here. 
    //This for your your admin_notices hook
    function show_error() {
        echo '<div class="error">
       <p>Error Found!!</p>
       </div>';
    }

    //update option when admin_notices is needed or not
    function update_option($val) {
        update_option('display_my_admin_message', $val);
    }

    //function to use for your admin notice
    function add_plugin_notice() {
        if (get_option('display_my_admin_message') == 1) { 
            // check whether to display the message
            add_action('admin_notices', array(&$this, 'show_error'));
            // turn off the message
            update_option('display_my_admin_message', 0); 
        }
    }
}

?>