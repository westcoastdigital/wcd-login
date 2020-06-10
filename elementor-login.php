<?php
namespace Elementor; // Custom widgets must be defined in the Elementor namespace
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly (security measure)

/**
 * Widget Name: Login Form
 */
class WCD_Login_Form extends Widget_Base{

 	// The get_name() method is a simple one, you just need to return a widget name that will be used in the code.
	public function get_name() {
		return 'wcdlogin';
	}

	// The get_title() method, which again, is a very simple one, you need to return the widget title that will be displayed as the widget label.
	public function get_title() {
		return __( 'WCD Login Form', 'wcd' );
	}

	// The get_icon() method, is an optional but recommended method, it lets you set the widget icon. you can use any of the eicon or font-awesome icons, simply return the class name as a string.
	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	// The get_categories method, lets you set the category of the widget, return the category name as a string.
	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {

		//Content
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'General', 'wcd' ),
			]
        );
        
        $this->add_control(
			'username_label',
			[
				'label' => __( 'Username Label', 'wcd' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __('Username or Email Address', 'wcd'),
            ]
		);
        
        $this->add_control(
			'password_label',
			[
				'label' => __( 'Password Label', 'wcd' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __('Password', 'wcd'),
            ]
		);
        
        $this->add_control(
			'button_label',
			[
				'label' => __( 'Button Label', 'wcd' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __('Log In', 'wcd'),
            ]
		);
        
        // $this->add_control(
		// 	'lost_label',
		// 	[
		// 		'label' => __( 'Lost Password Label', 'wcd' ),
		// 		'type' => Controls_Manager::TEXT,
		// 		'dynamic' => [
		// 			'active' => true,
		// 		],
		// 		'default' => __('Forgot Your Password?', 'wcd'),
        //     ]
		// );
        
        $this->add_control(
			'remember_label',
			[
				'label' => __( 'Rememeber Me Label', 'wcd' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __('Remember Me', 'wcd'),
            ]
        );
        
        $this->add_control(
			'show_lost',
			[
				'label' => __( 'Lost Password Link', 'wcd' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'wcd' ),
				'label_off' => __( 'No', 'wcd' ),
				'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Customise the lost password text within the plugins <a href="' . admin_url('themes.php?page=custom-login') . '">settings page</a>.', 'wcd'),
            ],
        );
        
        $this->add_control(
			'show_remember',
			[
				'label' => __( 'Remember Me Checkbox', 'wcd' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'wcd' ),
				'label_off' => __( 'No', 'wcd' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ],
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'input_style_section',
			[
				'label' => __( 'Form Style', 'wcd' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __( 'Label Position', 'wcd' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Above', 'wcd' ),
				'label_off' => __( 'Left', 'wcd' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ],
        );
        
        $this->add_responsive_control(
			'form_align',
			[
				'label' => __( 'Alignment', 'wcd' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'wcd' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wcd' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wcd' ),
						'icon' => 'fa fa-align-right',
					],
				],
				// 'prefix_class' => 'wcd%s-align-',
				'selectors' => [
					'{{WRAPPER}} .wcd-login-form' => 'text-align: {{VALUE}};',
				],
				'default' => 'left',
			]
		);

		$this->end_controls_section();		

	}

	protected function render() {
        $settings = $this->get_settings_for_display();
        $layout = $settings['layout'];
        $alignment = $settings['form_align'] ? $settings['form_align'] : 'left';
        $username_label = $settings['username_label'] ? $settings['username_label'] : __('Username or Email Address', 'wcd'); // Username Label
        $password_label = $settings['password_label'] ? $settings['password_label'] : __('Password', 'wcd'); // Password Label
        $remember_me_label = $settings['remember_label'] ? $settings['remember_label'] : __('Remember Me', 'wcd'); // Remember Me Label
        $remember_me_link = $settings['show_remember']; // Remember Me Link
        $lost_pw_link = $settings['show_lost']; // Remember Me Link
        $button_label = $settings['button_label'] ? $settings['button_label'] : __('Log In', 'wcd'); // Button Label
        $class = '';
        $class .= 'align-' . $settings['form_align'] . ' ';

        if($layout) {
            $class .= 'label-top ';
        }
    
        if ($remember_me_link) {
            $remember = true;
        } else {
            $remember = false;
        }
        if ($lost_pw_link) {
            $class .= 'reset-enabled ';
        } else {
            $class .= 'reset-disabled ';
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
        echo '<div class="wcd-login-form ' . $class . '">';
            wp_login_form($args);
        echo '</div>';
	}

	protected function _content_template() {}
    
}
// After the Schedule class is defined, I must register the new widget class with Elementor:
Plugin::instance()->widgets_manager->register_widget_type( new WCD_Login_Form() );