<?php
if (!defined('ABSPATH') || !is_main_site()) {
    return;
}

/*
Plugin Name: WCD Login
Plugin URI: https://github.com.au/wcd-login
Description: Add custom login page support.
Version: 1.0.0
Author: West Coast Digital
Author URI: https://westcoastdigital.com.au
Contributors: westcoastdigital
Text Domain: wcd
Domain Path: /languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

class WCDCustomLogin
{
    private $custom_login_options;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'custom_login_add_plugin_page'));
        add_action('admin_init', array($this, 'custom_login_page_init'));
    }

    public function custom_login_add_plugin_page()
    {
        add_theme_page(
            __('Custom Login', 'wcd'), // page_title
            __('Custom Login', 'wcd'), // menu_title
            'manage_options', // capability
            'custom-login', // menu_slug
            array($this, 'custom_login_create_admin_page') // function
        );
    }

    public function custom_login_create_admin_page()
    {
        $this->custom_login_options = get_option('custom_login_option_name');?>

		<div class="wrap">
			<h2>Custom Login</h2>
			<p></p>
			<?php settings_errors();?>
            <div id="main" style="width: 70%; min-width: 350px; float: left;">
			<form method="post" action="options.php">
				<?php
settings_fields('custom_login_option_group');
        do_settings_sections('custom-login-admin');
        submit_button();
        ?>
            </form>
            </div>
            <div id="sidebar" style="width: 28%; float: right; min-width: 150px; background: #fff; border: 1px solid #999; padding: 6px">
			<h3><?php _e('Shortcode', 'wcd');?></h3>
            <p><?php _e('You can display the login form on your page using the following shortcode', 'wcd');?></a></p>
            <p><input class="regular-text" type="text" name="form_shortcode" id="form_shortcode" value="[wcd-login-form]" readonly></p>
			<h3><?php _e('Contact', 'wcd');?></h3>
			<p><?php _e('Don\'t hesitate to <a href="mailto:jon@westcoastdigital.com.au" target="_blank">contact me</a> to request new features, ask questions, or just say hi.', 'wcd');?></p>
			<h3><?php _e('Other West Coast Digtal Plugins', 'wcd');?></h3>
			<p><?php _e('Check out some of my other plugins available on the Repository and GitHub', 'wcd');?></p>
            <p><a class="button" href="https://en-au.wordpress.org/plugins/gp-elements-admin-link/" target="_blank"><?php echo __('GP Elements Admin Link', 'wcd'); ?></a></p>
            <p><a class="button" href="https://wordpress.org/plugins/gp-related-posts/" target="_blank"><?php echo __('GP Related Posts', 'wcd'); ?></a></p>
            <p><a class="button" href="https://wordpress.org/plugins/gp-social-share-svg/" target="_blank"><?php echo __('GP Social Share', 'wcd'); ?></a></p>
            <p><a class="button" href="https://github.com/WestCoastDigital/WordPress-Breadcrumbs" target="_blank"><?php echo __('Breadcrumbs', 'wcd'); ?></a></p>
			<h3><?php _e('Donate', 'wcd');?></h3>
			<p><?php _e('If you wish to buy me a cup of coffee to say thanks, use the button below.', 'wcd');?></p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick" />
                <input type="hidden" name="hosted_button_id" value="4EUJJDGZPBB56" />
                <input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1" />
            </form>
		</div>
		</div>
	<?php }

    public function custom_login_page_init()
    {
        register_setting(
            'custom_login_option_group', // option_group
            'custom_login_option_name', // option_name
            array($this, 'custom_login_sanitize') // sanitize_callback
        );

        add_settings_section(
            'custom_login_setting_section', // id
            __('Settings', 'wcd'), // title
            array($this, 'custom_login_section_info'), // callback
            'custom-login-admin' // page
        );

        add_settings_field(
            'username_label', // id
            __('Username Label', 'wcd'), // title
            array($this, 'username_label_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'password_label', // id
            __('Password Label', 'wcd'), // title
            array($this, 'password_label_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'button_label', // id
            __('Button Label', 'wcd'), // title
            array($this, 'button_label_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'custom_login_page', // id
            __('Custom Login Page', 'wcd'), // title
            array($this, 'custom_login_page_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'logout_redirect_page', // id
            __('Logout Redirect Page', 'wcd'), // title
            array($this, 'logout_redirect_page_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'login_failed_page', // id
            __('Login Failed Redirect Page', 'wcd'), // title
            array($this, 'login_failed_page_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'lost_password_link', // id
            __('Lost Password Link', 'wcd'), // title
            array($this, 'lost_password_link_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'lost_password_label', // id
            __('Lost Password Label', 'wcd'), // title
            array($this, 'lost_password_label_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'remember_me_link', // id
            __('Remember Me Checkbox', 'wcd'), // title
            array($this, 'remember_me_link_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

        add_settings_field(
            'remember_me_label', // id
            __('Remember Me Label', 'wcd'), // title
            array($this, 'remember_me_label_callback'), // callback
            'custom-login-admin', // page
            'custom_login_setting_section' // section
        );

    }

    public function custom_login_sanitize($input)
    {
        $sanitary_values = array();
        if (isset($input['username_label'])) {
            $sanitary_values['username_label'] = sanitize_text_field($input['username_label']);
        }

        if (isset($input['password_label'])) {
            $sanitary_values['password_label'] = sanitize_text_field($input['password_label']);
        }

        if (isset($input['remember_me_label'])) {
            $sanitary_values['remember_me_label'] = sanitize_text_field($input['remember_me_label']);
        }

        if (isset($input['button_label'])) {
            $sanitary_values['button_label'] = sanitize_text_field($input['button_label']);
        }

        if (isset($input['custom_login_page'])) {
            $sanitary_values['custom_login_page'] = $input['custom_login_page'];
        }

        if (isset($input['logout_redirect_page'])) {
            $sanitary_values['logout_redirect_page'] = $input['logout_redirect_page'];
        }

        if (isset($input['login_failed_page'])) {
            $sanitary_values['login_failed_page'] = $input['login_failed_page'];
        }

        if (isset($input['lost_password_link'])) {
            $sanitary_values['lost_password_link'] = $input['lost_password_link'];
        }

        if (isset($input['remember_me_link'])) {
            $sanitary_values['remember_me_link'] = $input['remember_me_link'];
        }

        if (isset($input['lost_password_label'])) {
            $sanitary_values['lost_password_label'] = sanitize_text_field($input['lost_password_label']);
        }

        return $sanitary_values;
    }

    public function custom_login_section_info()
    {

    }

    public function username_label_callback()
    {
        printf(
            '<input placeholder="' . __('Username or Email Address', 'wcd') . '" class="regular-text" type="text" name="custom_login_option_name[username_label]" id="username_label" value="%s">',
            isset($this->custom_login_options['username_label']) ? esc_attr($this->custom_login_options['username_label']) : ''
        );
    }

    public function password_label_callback()
    {
        printf(
            '<input placeholder="' . __('Password', 'wcd') . '" class="regular-text" type="text" name="custom_login_option_name[password_label]" id="password_label" value="%s">',
            isset($this->custom_login_options['password_label']) ? esc_attr($this->custom_login_options['password_label']) : ''
        );
    }

    public function remember_me_label_callback()
    {
        printf(
            '<input placeholder="' . __('Remember Me', 'wcd') . '" class="regular-text" type="text" name="custom_login_option_name[remember_me_label]" id="remember_me_label" value="%s">',
            isset($this->custom_login_options['remember_me_label']) ? esc_attr($this->custom_login_options['remember_me_label']) : ''
        );
    }

    public function button_label_callback()
    {
        printf(
            '<input placeholder="' . __('Log In', 'wcd') . '" class="regular-text" type="text" name="custom_login_option_name[button_label]" id="button_label" value="%s">',
            isset($this->custom_login_options['button_label']) ? esc_attr($this->custom_login_options['button_label']) : ''
        );
    }

    public function custom_login_page_callback()
    {
        ?> <select class="wcd-select" style="width: 25em" name="custom_login_option_name[custom_login_page]" id="custom_login_page">
            <?php $pages = get_pages();
        foreach ($pages as $page) {
            $page_id = $page->ID;
            $login_page = $this->custom_login_options['custom_login_page'];
            if ($login_page == $page_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }?>
                <option value="<?php echo $page_id; ?>" <?php echo $selected; ?>><?php echo $page->post_title ?></option>
            <?php }?>
		</select> <?php
}

    public function logout_redirect_page_callback()
    {
        ?> <select class="wcd-select" style="width: 25em" name="custom_login_option_name[logout_redirect_page]" id="logout_redirect_page">
            <?php $pages = get_pages();
        foreach ($pages as $page) {
            $page_id = $page->ID;
            $logout_page = $this->custom_login_options['logout_redirect_page'];
            if ($logout_page == $page_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }?><option value="<?php echo $page->ID; ?>" <?php echo $selected; ?>><?php echo $page->post_title ?></option>
            <?php }?>
		</select> <?php
}

    public function login_failed_page_callback()
    {
        ?> <select class="wcd-select" style="width: 25em" name="custom_login_option_name[login_failed_page]" id="login_failed_page">
            <?php $pages = get_pages();
        foreach ($pages as $page) {
            $page_id = $page->ID;
            $failed_page = $this->custom_login_options['login_failed_page'];
            if ($failed_page == $page_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }?><option value="<?php echo $page->ID; ?>" <?php echo $selected; ?>><?php echo $page->post_title ?></option>
            <?php }?>
		</select> <?php
}

    public function remember_me_link_callback()
    {
        printf(
            '<input type="checkbox" name="custom_login_option_name[remember_me_link]" id="remember_me_link" value="remember_me_link" %s>',
            (isset($this->custom_login_options['remember_me_link']) && $this->custom_login_options['remember_me_link'] === 'remember_me_link') ? 'checked' : ''
        );
    }

    public function lost_password_link_callback()
    {
        printf(
            '<input type="checkbox" name="custom_login_option_name[lost_password_link]" id="lost_password_link" value="lost_password_link" %s>',
            (isset($this->custom_login_options['lost_password_link']) && $this->custom_login_options['lost_password_link'] === 'lost_password_link') ? 'checked' : ''
        );
    }

    public function lost_password_label_callback()
    {
        printf(
            '<input placeholder="' . __('Forgot Your Password?', 'wcd') . '" class="regular-text" type="text" name="custom_login_option_name[lost_password_label]" id="lost_password_label" value="%s">',
            isset($this->custom_login_options['lost_password_label']) ? esc_attr($this->custom_login_options['lost_password_label']) : ''
        );
    }

}
if (is_admin()) {
    $custom_login = new WCDCustomLogin();
}

/* Custom login form shortcode */
function wcd_login_form()
{
    $custom_login_options = get_option('custom_login_option_name'); // Array of All Options
    $username_label = $custom_login_options['username_label'] ? $custom_login_options['username_label'] : __('Username or Email Address', 'wcd'); // Username Label
    $password_label = $custom_login_options['password_label'] ? $custom_login_options['password_label'] : __('Password', 'wcd'); // Password Label
    $remember_me_label = $custom_login_options['remember_me_label'] ? $custom_login_options['remember_me_label'] : __('Remember Me', 'wcd'); // Remember Me Label
    $remember_me_link = $custom_login_options['remember_me_link']; // Remember Me Link
    $button_label = $custom_login_options['button_label'] ? $custom_login_options['button_label'] : __('Log In', 'wcd'); // Button Label

    if ($remember_me_link) {
        $remember = true;
    } else {
        $remember = false;
    }

    $args = array(
        'echo' => true,
        'remember' => $remember,
        'redirect' => (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
        'form_id' => 'loginform',
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'label_username' => $username_label,
        'label_password' => $password_label,
        'label_remember' => $remember_me_label,
        'label_log_in' => $button_label,
        'value_username' => '',
        'value_remember' => false,
    );
    wp_login_form($args);
    wcd_add_lost_password_link();

}
add_shortcode('wcd-login-form', 'wcd_login_form');

/* Custom forgot password reset link */
function wcd_add_lost_password_link()
{
    $custom_login_options = get_option('custom_login_option_name'); // Array of All Options
    $lost_password_label = $custom_login_options['lost_password_label'] ? $custom_login_options['lost_password_label'] : __('Forgot Your Password?', 'wcd'); // Lost Password Label
    $lost_password_link = $custom_login_options['lost_password_link']; // Lost Password Link

    if ($lost_password_link) {
        return '<a href="/wp-login.php?action=lostpassword">' . $lost_password_label . '</a>';
    }

}
add_action('login_form_middle', 'wcd_add_lost_password_link');

/* Main redirection of the default login page */
function wcd_redirect_login_page()
{
    $custom_login_options = get_option('custom_login_option_name'); // Array of All Options
    $custom_login_page = $custom_login_options['custom_login_page']; // Custom Login Page
    $login_page = get_page_link($custom_login_page);
    $page_viewed = basename($_SERVER['REQUEST_URI']);

    if ($custom_login_page && $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
}
add_action('init', 'wcd_redirect_login_page');

/* Where to go if a login failed */
function wcd_custom_login_failed()
{
    $custom_login_options = get_option('custom_login_option_name'); // Array of All Options
    $custom_login_failed = $custom_login_options['login_failed_page']; // Custom Login Failed Page
    if ($custom_login_failed) {
        $login_page = home_url('/' . $custom_login_failed . '/');
        wp_redirect($login_page . '?login=failed');
        exit;
    }
}
add_action('wp_login_failed', 'wcd_custom_login_failed');

/* What to do on logout */
function wcd_logout_redirect()
{
    $custom_login_options = get_option('custom_login_option_name'); // Array of All Options
    $logout_redirect_page = $custom_login_options['logout_redirect_page']; // Logout Redirect Page
    if ($logout_redirect_page) {
        $login_page = home_url('/' . $logout_redirect_page . '/');
        wp_redirect($login_page . "?login=false");
        exit;
    }
}
add_action('wp_logout', 'wcd_logout_redirect');

function wcd_select2_enqueue()
{
    wp_enqueue_style('select2', plugin_dir_url(__FILE__) . '/select/css/select2.min.css');
    wp_enqueue_script('select2', plugin_dir_url(__FILE__) . '/select/js/select2.min.js', array('jquery'));
    wp_enqueue_script('wcd-custom-login', plugin_dir_url(__FILE__) . '/script.js', array('jquery', 'select2'));
}
add_action('admin_enqueue_scripts', 'wcd_select2_enqueue');