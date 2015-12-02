<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */

if (!class_exists("Redux_Framework_sample_config")) {

    class Redux_Framework_sample_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            // This is needed. Bah WordPress bugs.  ;)
            if ( strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( get_template_directory() ) ) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);    
            }
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
            // Function to test the compiler hook and demo CSS output.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo "<h1>The compiler hook has run!";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
              require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
              $wp_filesystem->put_contents(
              $filename,
              $css,
              FS_CHMOD_FILE // predefined mode settings for WP files
              );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'flaton'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'flaton'),
                'icon' => 'fa fa-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
            }

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'flaton'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','flaton'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','flaton'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo $this->theme->display('Name'); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'flaton'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'flaton'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'flaton') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'flaton') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'flaton'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            $featuresHTML = <<< FEATURES
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-cog"></i></div>
                <h3>Page Builder</h3>
                <p>FlatOn Pro supports Page Builder. All our shortcodes can be used as widgets too. You can drag and drop our widgets with page builder visual editor.</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-th-large"></i></div>
                <h3>Page Layout</h3>
                <p>FlatOn Pro offers many different page layouts so you can quickly and easily create your pages with various layout without any hassle!</p>
            </div>            
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-th"></i></div>
                <h3>Unlimited Sidebar</h3>
                <p>Unlimited sidebars allows you to create multiple sidebars. Check out our demo site to see how different pages displays different sidebars!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-code-fork"></i></div>
                <h3>Shortcode Builder</h3>
                <p>With our shortcode builder and lots of shortcodes, you can easily create nested shortcodes and build custom pages!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-camera"></i></div>
                <h3>Multi Portfolio</h3>
                <p>7 portfolio layouts with Isotope filtering, 3 blog layouts and multiple other alternate layouts for interior pages!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-font"></i></div>
                <h3>Typography</h3>
                <p>FlatOn Pro loves typography, you can choose from over 500+ Google Fonts and Standard Fonts to customize your site!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-slideshare"></i></div>
                <h3>Awesome Sliders</h3>
                <p>FlatOn Pro includes two types of slider. You can use both Flex and Elastic sliders anywhere in your site.</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-leaf"></i></div>
                <h3>Woo Commerce</h3>
                <p>FlatOn Pro has full design/code integration for WooCommerce, your shop will look as good as the rest of your site!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-tasks"></i></div>
                <h3>Custom Widget</h3>
                <p>We offer many custom widgets that are stylized and ready for use. Simply drag &amp; drop into place to activate!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-dashboard"></i></div>
                <h3>Advanced Admin</h3>
                <p>Advanced Redux Framework for theme options panel, you can customize any part of your site quickly and easily!</p>
            </div>            
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-magic"></i></div>
                <h3>Font Awesome</h3>
                <p>Font Awesome icons are fully integrated into the theme. Use them anywhere in your site in 6 different sizes!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-arrows"></i></div>
                <h3>Responsive Layout</h3>
                <p>FlatOn Pro is fully responsive and can adapt to any screen size. Resize your browser window to view it!</p>
            </div>  

            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-magic"></i></div>
                <h3>Testimonials</h3>
                <p>With our testimonial post type, shortcode and widget, Displaying testimonials is a breeze.</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-twitter"></i></div>
                <h3>Social Media</h3>
                <p>Want your users to stay in touch? No problem, FlatOn Pro has Social Media icons all throughout the theme!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="fa fa-map-marker"></i></div>
                <h3>Google Map</h3>
                <p>FlatOn Pro includes Goole Map as shortcode and widget. So, you can use it anywhere in your site!</p>
            </div>
        </div>
FEATURES;
/*
<!--
            <div class="one-third column">
                <div class="icon-wrap"><i class="el-icon-opensource"></i></div>
                <h3>Excellent Support</h3>
                <p>We truly care about our customers and theme’s performance. We assure you that you will get the best after sale support like never before!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el-icon-picture"></i></div>
                <h3>Retina Ready</h3>
                <p>FlatOn Pro is Retina Ready. So, Everything looks amazingly sharp and crisp on high resolution retina displays of all sizes!</p>
            </div>
         
            <div class="one-third column">
                <div class="icon-wrap"><i class="el-icon-idea"></i></div>
                <h3>Demo Content</h3>
                <p>FlatOn Pro includes demo content files. You can quickly setup the site like our demo and get started easily!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el-icon-wrench-alt"></i></div>
                <h3>Customization</h3>
                <p>With advanced theme options, page options &amp; extensive docs, its never been easier to customize a theme!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el-icon-cogs"></i></div>
                <h3>Improvement</h3>
                <p>We love our theme and customers. We are committed to improve and add new features to FlatOn Pro!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el-icon-inbox-alt"></i></div>
                <h3>Regular Updates</h3>
                <p>We keep our themes secure and keep adding great new features!</p>
            </div>        
-->
*/

            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(
                'title' => __('General Settings', 'flaton'),
                'desc' => __('General Settings of Theme to change look and feel through out the site', 'flaton'),
                'icon' => 'fa fa fa-cogs',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  
                    array(
                        'id'=>'color',
                        'type' => 'select',
                        'title' => __('Color Scheme', 'flaton'),
                        'subtitle'=> __('Select your color scheme.', 'flaton'),
                        'options' => array( '1' => 'default', '2' => 'green', '3' => 'More color schemes in FlatOn Pro Version.' ),
                        'default' => '1'
                        ),
                    array(
                        'id'=>'breadcrumb',
                        'type' => 'switch', 
                        'title' => __('Enable Breadcrumb Navigation', 'flaton'),
                        'subtitle'=> __('Check to display breadcrumb navigation.', 'flaton'),
                        'default' => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),      

                    array(
                        'id'=>'breadcrumb-char',
                        'type' => 'select',
                        'title' => __('Breadcrumb Character', 'flaton'),
                        'subtitle'=> __('Check to display breadcrumb navigation.', 'flaton'),
                        'options' => array( '1' => ' &raquo; ', '2' => ' / ', '3' => ' > ' ),
                        'default' => '1'
                        ),

                    array(
                        'id'        => 'upgrade-notice-1',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'fa fa-info-circle',
                        'title'     => __('FlatOn Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade Now</a> for just $39.', 'flaton'),
                        'desc'      => __('These options are available only in FlatOn Pro version theme. Upgrade now for just $39.', 'flaton')
                    ),
                    array(
                        'id'=>'pagenavi',
                        'type' => 'switch', 
                        'title' => __('Enable Numeric Page Navigation', 'flaton'),
                        'subtitle'=> __('Check to display numeric page navigation, instead of Previous Posts / Next Posts links.', 'flaton'),
                        'default'       => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),      
                    array(
                        'id'=>'slicknav',
                        'type' => 'switch', 
                        'title' => __('Enable SlickNav', 'flaton'),
                        'subtitle'=> __('Check to display reponsive menu using SlickNav', 'flaton'),
                        'default'       => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ), 
                    array(
                        'id'=>'layout',
                        'type' => 'image_select',
                        'compiler'=>true,
                        'title' => __('Main Layout', 'flaton' ), 
                        'subtitle' => __('Select main content and sidebar alignment.', 'flaton' ),
                        'options' => array(
                                '2' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                                '3' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                            ),
                        'default' => '3'
                        ),

                    array(
                        'id'=>'custom-js',
                        'type' => 'textarea',
                        'title' => __('Custom Javascript', 'flaton'), 
                        'subtitle' => __('Quickly add some Javascript to your theme by adding it to this block.', 'flaton'),
                        //'validate' => 'js',
                        'desc' => 'Validate that it\'s javascript!',
                        ),      
               array(
                        'id'=>'custom-css',
                        'type' => 'ace_editor',
                        'title' => __('Custom CSS', 'flaton'), 
                        'subtitle' => __('Quickly add some CSS to your theme by adding it to this block.', 'flaton'),
                        'mode' => 'css',
                  'theme' => 'monokai',
                        'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                        )
                )
            );


            $this->sections[] = array(
                'title' => __('Header', 'flaton'),
                'desc' => __('Theme options related to header section', 'flaton'),
                'icon' => 'fa fa-arrow-up',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  

                    array(
                        'id'=>'site-title',
                        'type' => 'switch', 
                        'title' => __('Logo as site title', 'flaton'),
                        'subtitle'=> __('Enable to load custom logo as site title in header.', 'flaton'),
                        "default"       => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'custom-logo',
                        'type' => 'media', 
                        'url'=> true,
                        'title' => __('Custom Logo', 'flaton'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'=> __('Upload logo to use as site title', 'flaton'),
                        'subtitle' => __('Upload any media using the WordPress native uploader', 'flaton'),
                        'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
                        ),

                    array(
                        'id'=>'site-description',
                        'type' => 'switch', 
                        'title' => __('Site Description', 'flaton'),
                        'subtitle'=> __('Enable to show site description in header.', 'flaton'),
                        "default"       => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'        => 'upgrade-notice-2',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'fa fa-info-circle',
                        'title'     => __('FlatOn Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade Now</a> for just $39.', 'flaton'),
                        'desc'      => __('These options are available only in FlatOn Pro version theme. Upgrade now for just $39.', 'flaton')
                    ),
                    array(
                        'id'=>'favicon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Custom Favicon (ICO)', 'flaton'),
                        'desc' => __('You can upload an ico image that will represent your website\'s favicon (16px X 16px)', 'flaton'),
                        ),

                    array(
                        'id'=>'ipad-icon-retina',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPad Retina Icon Upload (144px X 144px)', 'flaton'),
                        'desc'=> __('For third-generation iPad with high-resolution Retina display', 'flaton'),
                        ),

                    array(
                        'id'=>'iphone-icon-retina',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPhone Retina Icon Upload (114px X 114px)', 'flaton'),
                        'desc'=> __('For iPhone with high-resolution Retina display', 'flaton'),
                        ),

                    array(
                        'id'=>'ipad-icon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPad Icon Upload (72px X 72px)', 'flaton'),
                        'desc'=> __('For first- and second-generation iPad', 'flaton'),
                        ),

                    array(
                        'id'=>'iphone-icon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPhone Icon Upload (57px X 57px)', 'flaton'),
                        'desc'=> __('For non-Retina iPhone, iPod Touch, and Android 2.1+ devices', 'flaton'),
                        ),          

                    array(
                        'id'=>'google-analytics',
                        'type' => 'textarea',
                        'title' => __('Tracking Code', 'flaton'), 
                        'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'flaton'),
                        //'validate' => 'js',
                        'desc' => 'Validate that it\'s javascript!',
                    ),

                    array(
                        'id'=>'analytics-place',
                        'type' => 'switch', 
                        'title' => __('Load Tracking Code in Footer', 'flaton'),
                        'subtitle'=> __('Check to load analytics in footer. Uncheck to load in header.', 'flaton'),
                        'default' => 0,
                        'on' => 'In Footer',
                        'off' => 'In Header',
                    ),

                )
            );


            $this->sections[] = array(
                'title' => __('Footer', 'flaton'),
                'desc' => __('Theme options related to footer area of theme', 'flaton'),
                'icon' => 'fa fa-arrow-down',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  

                    array(
                        'id'=>'footer-widgets',
                        'type' => 'switch', 
                        'title' => __('Enable Footer Widget Area', 'flaton'),
                        'subtitle'=> __('Check to enable 4 Column Footer widget Area', 'flaton'),
                        "default"       => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'        => 'upgrade-notice-3',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'fa fa-info-circle',
                        'title'     => __('FlatOn Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade Now</a> for just $39.', 'flaton'),
                        'desc'      => __('These options are available only in FlatOn Pro version theme. Upgrade now for just $39.', 'flaton')
                    ),
                    array(
                        'id'=>'footer-text',
                        'type' => 'textarea',
                        'title' => __('Footer Copyright Text', 'flaton'), 
                        'subtitle' => __('Footer copyright text. HTML Allowed', 'flaton'),
                        'desc' => __('This field is even HTML validated!', 'flaton'),
                        'default' => __( 'Powered by <a href="http://wordpress.org/" target="_blank">WordPress</a>. Theme by <a href="http://www.webulousthemes.com/">Webulous Themes</a>.', 'flaton' ),
                        'validate' => 'html',
                        ),

                    array(
                        'id'=>'footer-menu',
                        'type' => 'select',
                        'data' => 'menus',
                        'title' => __('Select Menu', 'flaton'),
                        'subtitle'=> __('Select menu to display in footer.', 'flaton'),
                        ),

                    )
            );

            $this->sections[] = array(
                'title' => __('Home', 'flaton'),
                'desc' => __('Theme options related to home page', 'flaton'),
                'icon' => 'fa fa-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(
                    array(
                        'id'=>'slides',
                        'type' => 'slides',
                        'title' => __('Flex Slider Options', 'flaton' ),
                        'subtitle'=> __('Unlimited slides with drag and drop sortings.', 'flaton' )
                    ),

                    array(
                        'id'=>'service-main-title',
                        'type' => 'text',
                        'title' => __('Services Main Title', 'flaton' ), 
                        'desc' => __('Enter title of this section', 'flaton' ),
                        'default' => __('Our Services', 'flaton'),
                    ),
                    array(
                        'id'=>'service-sub-title',
                        'type' => 'text',
                        'title' => __('Services Section Sub Title', 'flaton' ), 
                        'desc' => __('Enter subtitle of this section', 'flaton' ),
                        'default' => __('Our Professional Solutions', 'flaton'),
                    ),

                    array(
                    'id'=>'service-icon-1',
                    'type' => 'text',
                    'title' => __('1. Service Icon', 'flaton' ), 
                    'subtitle' => __('Enter Font Awesome Icon name. e.g. fa fa-bullhorn', 'flaton' ),
                    'default' => 'fa fa-bullhorn'
                    ),
                    array(
                        'id'=>'service-title-1',
                        'type' => 'text',
                        'title' => __('Service Title', 'flaton' ), 
                        'desc' => __('Enter title of this service', 'flaton' ),
                        'default' => __('Research', 'flaton'),
                    ),
                    array(
                        'id'=>'service-description-1',
                        'type' => 'textarea',
                        'title' => __('1. Service Description', 'flaton' ), 
                        'validate' => 'html',
                        'default' => __('<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>', 'flaton'),
                    ),

                    array(
                        'id'=>'service-icon-2',
                        'type' => 'text',
                        'title' => __('2. Service Icon', 'flaton' ), 
                        'subtitle' => __('Enter Font Awesome Icon name. e.g. fa fa-bullhorn', 'flaton' ),
                        'default' => 'fa fa-cogs',
                    ),
                    array(
                        'id'=>'service-title-2',
                        'type' => 'text',
                        'title' => __('Service Title', 'flaton' ), 
                        'desc' => __('Enter title of this service', 'flaton' ),
                        'default' => __('Usability', 'flaton'),
                    ),
                    array(
                        'id'=>'service-description-2',
                        'type' => 'textarea',
                        'title' => __('2. Service Description', 'flaton' ), 
                        'validate' => 'html',
                        'default' => __('<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p><ul>   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>   <li>Aliquam tincidunt mauris eu risus.</li>   <li>Vestibulum auctor dapibus neque.</li></ul>', 'flaton'),
                    ),

                    array(
                        'id'=>'service-icon-3',
                        'type' => 'text',
                        'title' => __('3. Service Icon', 'flaton' ), 
                        'subtitle' => __('Enter Font Awesome Icon name. e.g. fa fa-bullhorn', 'flaton' ),
                        'default' => 'fa fa-twitter',
                    ),
                    array(
                        'id'=>'service-title-3',
                        'type' => 'text',
                        'title' => __('Service Title', 'flaton' ), 
                        'desc' => __('Enter title of this service', 'flaton' ),
                        'default' => __('Design', 'flaton'),
                    ),
                    array(
                        'id'=>'service-description-3',
                        'type' => 'textarea',
                        'title' => __('3. Service Description', 'flaton' ), 
                        'validate' => 'html',
                        'default' => __('<h2>Header Level 2</h2><ol><li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li><li>Aliquam tincidunt mauris eu risus.</li></ol>', 'flaton'),
                    ),

                    array(
                        'id'=>'service-icon-4',
                        'type' => 'text',
                        'title' => __('4. Service Icon', 'flaton' ), 
                        'subtitle' => __('Enter Font Awesome Icon name. e.g. fa fa-bullhorn', 'flaton' ),
                        'default' => 'fa fa-group',
                    ),
                    array(
                        'id'=>'service-title-4',
                        'type' => 'text',
                        'title' => __('Service Title', 'flaton' ), 
                        'desc' => __('Enter title of this service', 'flaton' ),
                        'default' => __('Design', 'flaton'),
                    ),
                    array(
                        'id'=>'service-description-4',
                        'type' => 'textarea',
                        'title' => __('4. Service Description', 'flaton' ), 
                        'default' => __('<h2>Header Level 2</h2><ol><li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li><li>Aliquam tincidunt mauris eu risus.</li></ol>', 'flaton'),
                        'validate' => 'html',
                    ),

                    array(
                        'id'=>'service-icon-5',
                        'type' => 'text',
                        'title' => __('5. Service Icon', 'flaton' ), 
                        'subtitle' => __('Enter Font Awesome Icon name. e.g. fa fa-bullhorn', 'flaton' ),
                        'default' => 'fa fa-digg',
                    ),
                    array(
                        'id'=>'service-title-5',
                        'type' => 'text',
                        'title' => __('Service Title', 'flaton' ), 
                        'desc' => __('Enter title of this service', 'flaton' ),
                        'default' => __('Design', 'flaton'),
                    ),
                    array(
                        'id'=>'service-description-5',
                        'type' => 'textarea',
                        'title' => __('5. Service Description', 'flaton' ), 
                        'validate' => 'html',
                        'default' => __('<h2>Header Level 2</h2><ol><li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li><li>Aliquam tincidunt mauris eu risus.</li></ol>', 'flaton'),
                    ),

                    array(
                        'id'=>'team',
                        'type' => 'textarea',
                        'title' => __('Our Team', 'flaton' ), 
                        'validate' => 'html',
                        'default' => __('<div class="eight columns team-col"><img src="http://localhost/flaton/wp-content/uploads/2014/04/team-mem1.gif" alt="" /><p>Many desktop publishing packages and we page editors now use Lorem Ipsum as their default model text, and a search for "lorem ipsum" will uncover many websites still in their infancy. Various verions have evolved over the years,sometimes by accident.<h5><strong>Feugiat Cursus</strong>Senior Manager</h5></div><div class="eight columns team-col"><img src="http://localhost/flaton/wp-content/uploads/2014/04/team-mem2.gif" alt="" /><p>Many desktop publishing packages and we page editors now use Lorem Ipsum as their default model text, and a search for "lorem ipsum" will uncover many websites still in their infancy. Various verions have evolved over the years,sometimes by accident.<h5><strong>Kelly Clarkson</strong>Art Director</h5></div><div class="eight columns team-col"><img src="http://localhost/flaton/wp-content/uploads/2014/04/team-mem3.gif" alt="" /><p>Many desktop publishing packages and we page editors now use Lorem Ipsum as their default model text, and a search for "lorem ipsum" will uncover many websites still in their infancy. Various verions have evolved over the years,sometimes by accident.<h5><strong>Chris Pontius</strong>Designer</h5></div><div class="eight columns team-col"><img src="http://localhost/flaton/wp-content/uploads/2014/04/team-mem4.gif" alt="" /><p>Many desktop publishing packages and we page editors now use Lorem Ipsum as their default model text, and a search for "lorem ipsum" will uncover many websites still in their infancy. Various verions have evolved over the years,sometimes by accident.<h5><strong>Bom Margera</strong>Code Ninja</h5></div><br class="clear" />', 'flaton'),
                    ),  

                    array(
                        'id'=>'features',
                        'type' => 'textarea',
                        'title' => __('Why Us? (or) Featrues', 'flaton' ), 
                        'subtitle' => __('A list is best, like "Why Us?", "Features".', 'flaton' ),
                        'validate' => 'html',
                        'default' => __('<h2>Why Choose FlatOn</h2><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced blow for those interested. Sections 1.10.32 and 1.10.33 from "De Finibus Bonorum et Malorum" by Cicero are also reproduced in their Exact original form, accompanied. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipusm has been the industry\'s standard dummy text ever since the...</p><p class="btn-more"><a href="http://www.webulousthemes.com/?add-to-cart=23">Buy Now</a></p>', 'flaton'),
                    ),  

                    array(
                        'id'=>'skill-heading',
                        'type' => 'text',
                        'title' => __('Skills Heading', 'flaton' ), 
                        'subtitle' => __('Enter heading of the skills list', 'flaton' ),
                        'default' => __('Our Skills', 'flaton'),
                    ),  

                    array(
                        'id'=>'skill-1',
                        'type' => 'text',
                        'title' => __('1. Skill Name', 'flaton' ), 
                        'subtitle' => __('Enter name of the skill', 'flaton' ),
                        'default' => __('Web Design','flaton'),
                    ),      
                    array(
                        'id'=>'percentage-1',
                        'type' => 'spinner',
                        'title' => __('1. Skill Percentage', 'flaton' ), 
                        'desc' => __('Enter 0 to 50', 'flaton' ),
                        'min' => '0',
                        'max' => '100',
                        'step' => '5',
                        'default' => '80',
                    ),

                    array(
                        'id'=>'skill-icon-1',
                        'type' => 'text',
                        'title' => __('1. Skill Icon', 'flaton' ), 
                        'subtitle' => __('Select icon that represents this skill', 'flaton' ),
                        'default' => 'fa fa-bell',
                    ),

                    array(
                        'id'=>'skill-2',
                        'type' => 'text',
                        'title' => __('2. Skill Name', 'flaton' ), 
                        'subtitle' => __('Enter name of the skill', 'flaton' ),
                        'default' => __('Management','flaton'),
                    ),      

                    array(
                        'id'=>'percentage-2',
                        'type' => 'spinner',
                        'title' => __('2. Skill Percentage', 'flaton' ), 
                        'desc' => __('Enter 0 to 50', 'flaton' ),
                        'min' => '0',
                        'max' => '100',
                        'step' => '5',
                        'default' => '60',

                    ),

                    array(
                        'id'=>'skill-icon-2',
                        'type' => 'text',
                        'title' => __('2. Skill Icon', 'flaton' ), 
                        'subtitle' => __('Select icon that represents this skill', 'flaton' ),
                        'default' => 'fa fa-camera',
                    ),

                    array(
                        'id'=>'skill-3',
                        'type' => 'text',
                        'title' => __('3. Skill Name', 'flaton' ), 
                        'subtitle' => __('Enter name of the skill', 'flaton' ),
                        'default' => __('Design','flaton'),
                    ),

                    array(
                        'id'=>'percentage-3',
                        'type' => 'spinner',
                        'title' => __('3. Skill Percentage', 'flaton' ), 
                        'desc' => __('Enter 0 to 50', 'flaton' ),
                        'min' => '0',
                        'max' => '100',
                        'step' => '5',
                        'default' => '90',
                    ),

                    array(
                        'id'=>'skill-icon-3',
                        'type' => 'text',
                        'title' => __('3. Skill Icon', 'flaton' ), 
                        'subtitle' => __('Select icon that represents this skill', 'flaton' ),
                        'default' => 'fa fa-recycle',
                    ),

                    array(
                        'id'=>'skill-4',
                        'type' => 'text',
                        'title' => __('4. Skill Name', 'flaton' ), 
                        'subtitle' => __('Enter name of the skill', 'flaton' ),
                        'default' => __('HTML &amp; CSS','flaton'),
                        ),

                    array(
                        'id'=>'percentage-4',
                        'type' => 'spinner',
                        'title' => __('4. Skill Percentage', 'flaton' ), 
                        'desc' => __('Enter 0 to 50', 'flaton' ),
                        'min' => '0',
                        'max' => '100',
                        'step' => '5',
                        'default' => '50',
                    ),

                    array(
                        'id'=>'skill-icon-4',
                        'type' => 'text',
                        'title' => __('4. Skill Icon', 'flaton' ), 
                        'subtitle' => __('Select icon that represents this skill', 'flaton' ),
                        'default' => 'fa fa-user',
                    ),

                    array(
                        'id'=>'skill-5',
                        'type' => 'text',
                        'title' => __('5. Skill Name', 'flaton' ), 
                        'subtitle' => __('Enter name of the skill', 'flaton' ),
                        'default' => __('WordPress','flaton'),
                    ),

                    array(
                        'id'=>'percentage-5',
                        'type' => 'spinner',
                        'title' => __('5. Skill Percentage', 'flaton' ), 
                        'desc' => __('Enter 0 to 50', 'flaton' ),
                        'min' => '0',
                        'max' => '100',
                        'step' => '5',
                        'default' => '80',
                    ),

                    array(
                        'id'=>'skill-icon-5',
                        'type' => 'text',
                        'title' => __('5. Skill Icon', 'flaton' ), 
                        'subtitle' => __('Select icon that represents this skill', 'flaton' ),
                        'default' => 'fa fa-video-camera',
                    ),

                    array(
                        'id'=>'extra-info',
                        'type' => 'textarea',
                        'title' => __('Additional Info', 'flaton' ), 
                        'validate' => 'html',
                        'default' => __('<h2>Top Features</h2><img src="http://localhost/flaton/wp-content/uploads/2013/03/soworthloving-wallpaper-300x187.jpg" alt="" class="alignleft" /><h5><strong>Lorem ipsum dolor sit amet</strong></h5><p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p class="btn-more"><a href="http://www.webulousthemes.com/?add-to-cart=23">Buy Now</a></p>', 'flaton'),
                    ), 

                    array(
                        'id'        => 'upgrade-notice-4',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'fa fa-info-circle',
                        'title'     => __('FlatOn Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade Now</a> for just $39.', 'flaton'),
                        'desc'      => __('These options are available only in FlatOn Pro version theme. Upgrade now for just $39.', 'flaton')
                    ),
                    array(
                        "id" => "homepage_blocks",
                        "type" => "sorter",
                        "title" => "Homepage Layout Manager",
                        "desc" => "Organize how you want the layout to appear on the homepage",
                        "compiler"=>'true',
                        'options' => array(
                            "enabled" => array(
                                "placebo" => "placebo", //REQUIRED!
                                "slider" => "Slider",
                                "services" => "Services",
                                "team" => "Team Members",
                                "features" => "Why Us and Skills",
                                "extra-info" => "Additioanl Section for Extra information",
                                'recent_posts' => 'Recent Posts',
                            ),
                            "disabled" => array(
                                "placebo" => "placebo", //REQUIRED!
                                'default' => "Default content"
                            ),
                        ),
                    ),  
                    array(
                        'id'=>'home-pagebuilder',
                        'type' => 'switch', 
                        'title' => __('Disable Home Options.', 'flaton'),
                        'subtitle'=> __('Check this to disable options for home page content and use page builder to enter content', 'flaton'),
                        "default" => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id' => 'home-flexslider',
                        'type' => 'text',
                        'title' => __( 'Enter FlexSlider shortcode', 'flaton' ),
                        'subtitle' => __( 'FlexSlider for Home Page', 'flaton' ),
                        'desc' => __( 'Enter a FlexSlider shortcode to be displayed on Home Page', 'flaton' ),

                    ), 
                )
            );


            $this->sections[] = array(
                'title' => __('Blog', 'flaton'),
                'desc' => __('Blog options for site', 'flaton'),
                'icon' => 'fa fa-file',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  

                    array(
                        'id'=>'featured-image',
                        'type' => 'switch', 
                        'title' => __('Featured Image', 'flaton'),
                        'subtitle'=> __('Check to show featured image', 'flaton'),
                        "default"       => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'single-featured-image',
                        'type' => 'switch', 
                        'title' => __('Single Post Featured Image', 'flaton'),
                        'subtitle'=> __('Check to show featured image on single post', 'flaton'),
                        "default"       => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'        => 'upgrade-notice-5',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'fa fa-info-circle',
                        'title'     => __('FlatOn Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade Now</a> for just $39.', 'flaton'),
                        'desc'      => __('These options are available only in FlatOn Pro version theme. Upgrade now for just $39.', 'flaton')
                    ),
                    
                    array(
                        'id'=>'show-author-bio',
                        'type' => 'switch', 
                        'title' => __('Author Bio Box', 'flaton'),
                        'subtitle'=> __('Show Author information box below single post.', 'flaton'),
                        "default"       => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'show-social-sharing',
                        'type' => 'switch', 
                        'title' => __('Social Sharing Box', 'flaton'),
                        'subtitle'=> __('Show social sharing options box below single post.', 'flaton'),
                        "default"       => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'show-related-posts',
                        'type' => 'switch', 
                        'title' => __('Related Posts', 'flaton'),
                        'subtitle'=> __('Show related posts.', 'flaton'),
                        "default"       => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'show-comments',
                        'type' => 'switch', 
                        'title' => __('Comments', 'flaton'),
                        'subtitle'=> __('Show comments.', 'flaton'),
                        "default"       => 1,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'show-post-meta',
                        'type' => 'switch', 
                        'title' => __('Post Meta', 'flaton'),
                        'subtitle'=> __('Show post meta.', 'flaton'),
                        "default"       => 1,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),
                    /*
                     array(
                        'id'=>'post-content',
                        'type' => 'select',
                        'title' => __('Post Content', 'flaton'),
                        'subtitle'=> __('Select Excerpt or Full Content  to show on blog / archive pages.', 'flaton'),
                        'options' => array( '1' => ' Excerpt ', '2' => ' Full Content ' ),
                        'default' => '1'
                    ),
                    */


                    array(
                        'id'=>'excerpt-length',
                        'type' => 'text',
                        'title' => __('Excerpt Length', 'flaton' ), 
                        'subtitle' => __('Input the number of words you want to cut from the content to be the excerpt of search and archive page.', 'flaton' ),
                        'default' => 100,
                        ),
                )
            );

            $this->sections[] = array(
                'title' => __('Support', 'flaton'),
                'desc' => __('Documentation', 'flaton'),
                'icon' => 'fa fa-user',
                'fields' => array(

                    array(
                        'id'        => 'support-notice',
                        'type'      => 'info',
                        'style'     => 'critical',
                        'title'     => __('Support and Documentation.', 'flaton'),
                        'desc'      => __('Please refer to documentation page of this site\'s demo to know how to use theme options specific to this theme. For professional support about customization and other advices from theme author, Please <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade</a> to FlatOn Pro Version', 'flaton')
                    ),
                )
            );

            $this->sections[] = array(
                'title' => __('Why Upgrade?', 'flaton'),
                'desc' => __('Features you\'ll get in Pro Version', 'flaton'),
                'icon' => 'fa fa-magic',
                'fields' => array(
                    
                    array(
                        'id'        => 'pro-features',
                        'type'      => 'raw',
                        'content'   => $featuresHTML,
                    ),
                    

                )
            );

            $this->sections[] = array(
                'title' => __('Social Sharing Box', 'flaton'),
                'desc' => __('Social Sharing Icons Setup', 'flaton'),
                'icon' => 'fa fa-share',
                'fields' => array(  
                    array( 
                        'id' => 'ss_box_facebook',
                        'type' => 'switch',
                        'title' => 'Facebook',
                        'subtitle' => 'Show facebook sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ), 

                    array( 
                        'id' => 'ss_box_twitter',
                        'type' => 'switch',
                        'title' => 'Twitter',
                        'subtitle' => 'Show twitter sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),

                    array( 
                        'id' => 'ss_box_linkedin',
                        'type' => 'switch',
                        'title' => 'LinkedIn',
                        'subtitle' => 'Show linkedin sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),

                    array( 
                        'id' => 'ss_box_googleplus',
                        'type' => 'switch',
                        'title' => 'Google Plus',
                        'subtitle' => 'Show googleplus sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),

                    array( 
                        'id' => 'ss_box_email',
                        'type' => 'switch',
                        'title' => 'Email',
                        'subtitle' => 'Show email sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),
                )
            );

            $this->sections[] = array(
                'title' => __('Social Network', 'flaton'),
                'desc' => __('Social Network Links', 'flaton'),
                'icon' => 'fa fa-share',
                'fields' => array(

                    array( 
                        'id' => 'social-digg',
                        'type' => 'text',
                        'title' => 'Digg',
                        'subtitle' => 'Your Digg link',
                    ),

                    array( 
                        'id' => 'social-dribble',
                        'type' => 'text',
                        'title' => 'Dribble',
                        'subtitle' => 'Your Dribble link',
                    ),

                    array( 
                        'id' => 'social-facebook',
                        'type' => 'text',
                        'title' => 'Facebook',
                        'subtitle' => 'Your Facebook link',
                    ),

                    array( 
                        'id' => 'social-flickr',
                        'type' => 'text',
                        'title' => 'Flickr',
                        'subtitle' => 'Your Flickr link',
                    ),

                    array( 
                        'id' => 'social-google',
                        'type' => 'text',
                        'title' => 'Google',
                        'subtitle' => 'Your Google link',
                    ),

                    array( 
                        'id' => 'social-linkedin',
                        'type' => 'text',
                        'title' => 'LinkedIn',
                        'subtitle' => 'Your LinkedIn link',
                    ),

                    array( 
                        'id' => 'social-pinterest',
                        'type' => 'text',
                        'title' => 'Pinterest',
                        'subtitle' => 'Your Pinterest link',
                    ),

                    array( 
                        'id' => 'social-rss',
                        'type' => 'text',
                        'title' => 'RSS',
                        'subtitle' => 'Your RSS link',
                    ),

                    array( 
                        'id' => 'social-skype',
                        'type' => 'text',
                        'title' => 'Skype',
                        'subtitle' => 'Your Skype link',
                    ),

                    array( 
                        'id' => 'social-tumblr',
                        'type' => 'text',
                        'title' => 'Tumblr',
                        'subtitle' => 'Your Tumblr link',
                    ),

                    array( 
                        'id' => 'social-twitter',
                        'type' => 'text',
                        'title' => 'Twitter',
                        'subtitle' => 'Your Twitter link',
                    ),

                    array( 
                        'id' => 'social-vimeo',
                        'type' => 'text',
                        'title' => 'Vimeo',
                        'subtitle' => 'Your Vimeo link',
                    ),

                    array( 
                        'id' => 'social-youtube',
                        'type' => 'text',
                        'title' => 'YouTube',
                        'subtitle' => 'Your YouTube link',
                    ),

                )
            );

            $this->sections[] = array(
                'title' => __('Flex Slider', 'flaton'),
                'desc' => __('Flex Slider Settings', 'flaton'),
                'icon' => 'fa fa-photo',
                'fields' => array(

                    array(
                        'id'        => 'upgrade-notice-6',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'fa fa-info-circle',
                        'title'     => __('FlatOn Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade Now</a> for just $39.', 'flaton'),
                        'desc'      => __('These options are available only in FlatOn Pro version theme. Upgrade now for just $39.', 'flaton')
                    ),
                    
                    array(
                        'id' => 'flexslider_animation',
                        'type' => 'select',
                        'title' => 'Animation',
                        'subtitle' => 'Select slider animation effect.',
                        'default' => '1',
                        'options' => array( 1 => 'fade', 2 => 'slide'),
                    ),

                    array(
                        'id' => 'flexslider_slide_direction',
                        'type' => 'select',
                        'title' => 'Slide Direction',
                        'subtitle' => 'Select direction to slide (if you are using the "Slide" animation)',
                        'default' => '1',
                        'options' => array( '1' => 'horizontal', '2' => 'vertical' ),
                    ),

                    array(
                        'id'        => 'flexslider_slideshow_speed',
                        'type'      => 'spinner',
                        'title'     => 'Slideshow Speed',
                        'subtitle'      => 'Set the delay between each slide animation (in milliseconds)',
                        'default'       => '7000',
                      'min' => '0',
                      'max' => '10000',
                      'step' => '100',
                    ),

                    array(
                        'id'        => 'flexslider_animation_speed',
                        'type'      => 'spinner',
                        'title'     => 'Animation Speed',
                        'subtitle'      => 'Set the duration of each slide animation (in milliseconds)',
                        'default'       => '600',
                      'min' => '0',
                      'max' => '10000',
                      'step' => '100',
                    ),

                    array(
                        'id' => 'flexslider_slideshow',
                        'type'      => 'switch',
                        'title' => 'Slideshow',
                        'subtitle' => 'Animate the slideshows automatically',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_smooth_height',
                        'type'      => 'switch',
                        'title' => 'Auto Height',
                        'subtitle' => 'Adjust the height of the slideshow to the height of the current slide',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_direction_nav',
                        'type'      => 'switch',
                        'title' => 'Previous / Next Buttons',
                        'subtitle' => 'Display the "Previous/Next" Buttons',
                        'default' => 0,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ), 

                    array(
                        'id' => 'flexslider_control_nav',
                        'type'      => 'switch',
                        'title' => 'Pagination',
                        'subtitle' => 'Display the slideshow pagination',
                        'default' => 0,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ), 

                    array(
                        'id' => 'flexslider_keyboard_nav',
                        'type'      => 'switch',
                        'title' => 'Keyboard Navigation',
                        'subtitle' => 'Enable keyboard navigation',
                        'default' => 0,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ), 

                    array(
                        'id' => 'flexslider_mousewheel_nav',
                        'type'      => 'switch',
                        'title' => 'Mouse Wheel Navigation',
                        'subtitle' => 'Enable the mousewheel navigation',
                        'default' => 0,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ), 


                    array(
                        'id' => 'flexslider_pauseplay',
                        'type'      => 'switch',
                        'title' => 'Pause / Play',
                        'subtitle' => 'Enable the "Pause/Play" event',
                        'default' => 0,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ), 

                    array(
                        'id' => 'flexslider_randomize',
                        'type'      => 'switch',
                        'title' => 'Random Slides',
                        'subtitle' => 'Randomize the order of slides in slideshows',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_animation_loop',
                        'type'      => 'switch',
                        'title' => 'Loop Slideshow',
                        'subtitle' => 'Loop the slideshow animations',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_pause_on_action',
                        'type'      => 'switch',
                        'title' => 'Pause On Action',
                        'subtitle' => 'Pause the slideshow autoplay when using the pagination or "Previous/Next" navigation',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_pause_on_hover',
                        'type'      => 'switch',
                        'title' => 'Pause On Hover',
                        'subtitle' => 'Pause the slideshow autoplay when hovering over a slide',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id'        => 'flexslider_prev_text',
                        'type'      => 'text',
                        'title'     => '"Previous" Button',
                        'subtitle'      => 'The text to display on the "Previous" button.',
                        'default'       => 'Previous',
                    ),

                    array(
                        'id'        => 'flexslider_next_text',
                        'type'      => 'text',
                        'title'     => '"Next" Button',
                        'subtitle'      => 'The text to display on the "Next" button.',
                        'default'       => 'Next',
                    ),

                    array(
                        'id'        => 'flexslider_play_text',
                        'type'      => 'text',
                        'title'     => '"Play" Button',
                        'subtitle'      => 'The text to display on the "Play" button.',
                        'default'       => 'Play',
                    ),

                    array(
                        'id'        => 'flexslider_pause_text',
                        'type'      => 'text',
                        'title'     => '"Pause" Button',
                        'subtitle'      => 'The text to display on the "Pause" button.',
                        'default'       => 'Pause',
                    ),
                )
            );

            $this->sections[] = array(
                'title' => __('Light Box', 'flaton'),
                'desc' => __('Light Box Settings', 'flaton'),
                'icon' => 'fa fa-lightbulb-o',
                'fields' => array(

                    array(
                        'id'        => 'upgrade-notice-7',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'fa fa-info-circle',
                        'title'     => __('FlatOn Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade Now</a> for just $39.', 'flaton'),
                        'desc'      => __('These options are available only in FlatOn Pro version theme. Upgrade now for just $39.', 'flaton')
                    ),
                    
                    array( 
                        'id' => 'lightbox_theme',
                        'type' => 'select',
                        'title' => 'Lightbox Theme',
                        'subtitle' => '',
                        'default' => '1',
                        'options' => array(
                            '1' => 'pp_default',
                            '2' => 'light_rounded',
                            '3' => 'dark_rounded',
                            '4' => 'light_square',
                            '5' => 'dark_square',
                            '6' => 'facebook'
                        ),
                    ),
                                        
                    array( 
                        'id' => 'lightbox_animation_speed',
                        'type' => 'select',
                        'title' => 'Animation Speed',
                        'subtitle' => '',
                        'default' => '1',
                        'options' => array( '1' => 'Fast', '2' => 'Slow', '3' => 'Normal' ),
                    ),

                    array( 
                        'id' => 'lightbox_slideshow',
                        'type' => 'spinner',
                        'title' => 'Autoplay Gallery Speed',
                        'subtitle' => 'If autoplay is set to true, select the slideshow speed in ms. (Default: 5000, 500 ms = 1 second)',
                        'default' => '5000',
                        'min' => '1000',
                        'max' => '10000',
                        'step' => '100',
                    ),

                    array( 
                        'id' => 'lightbox_autoplay_slideshow',
                        'type'      => 'switch',
                        'title' => 'Autoplay Gallery',
                        'subtitle' => 'Check to autoplay the lightbox gallery',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ),

                    array( 
                        'id' => 'lightbox_opacity',
                        'type' => 'text',
                        'title' => 'Background Opacity',
                        'subtitle' => 'Enter 0.1 to 1.0',
                        'default' => '0.7',
                    ),

                    array( 
                        'id' => 'lightbox_show_title',
                        'type'      => 'switch',
                        'title' => 'Title',
                        'subtitle' => 'Select visibility of the title',
                        'default' => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),


                    array( 
                        'id' => 'lightbox_overlay_gallery',
                        'type'      => 'switch',
                        'title' => 'Show Gallery Thumbnails',
                        'subtitle' => 'Check to show gallery thumbnails',
                        'default' => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),


                    array( 
                        'id' => 'lightbox_social_tools',
                        'type'      => 'switch',
                        'title' => 'Social Icons',
                        'subtitle' => 'Check to show social sharing icons',
                        'default' => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),

                )
            );

            $this->sections[] = array(
                'title' => __('Typography', 'flaton'),
                'desc' => __('Typography and Link Color Settings', 'flaton'),
                'icon' => 'fa fa-font',
                'fields' => array(

                    array(
                        'id'        => 'upgrade-notice-8',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'fa fa-info-circle',
                        'title'     => __('FlatOn Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=23">Upgrade Now</a> for just $39.', 'flaton'),
                        'desc'      => __('These options are available only in FlatOn Pro version theme. Upgrade now for just $39.', 'flaton')
                    ),
                    
                    array(
                        'id'=>'custom-typography',
                        'type' => 'switch', 
                        'title' => __('Enable Custom Typography', 'flaton'),
                        'subtitle'=> __('Turn on to customize typography and turn off for default typography.', 'flaton'),
                        'default'       => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),    

                    array(
                        'id'       => 'opt-link-color',
                        'type'     => 'link_color',
                        'title'    => __('Links Color Option', 'flaton'),
                        'subtitle' => __('Only color validation can be done on this field type', 'flaton'),
                        'desc'     => __('This is the description field, again good for additional info.', 'flaton'),
                        'default'  => array(
                            'regular'  => '#ff4200', // blue
                            'hover'    => '#ff4200', // red
                            'active'   => '#ff4200',  // purple
                            'visited'  => '#ff4200'  // purple
                        )
                    ),

                    array(
                        'id'        => 'dummy-typography',
                        'type'      => 'typography',
                        'title'     => __('Font Preview', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'color' => false,
                        'subtitle'  => __('Preview Google fonts using this field. Sets nothing, just preview.', 'flaton'),
                        'default'   => array( 'font-family' => 'Abel', 'font-size' => '24px' )
                    ),

                    array(
                        'id'        => 'bd-typography',
                        'type'      => 'typography',
                        'title'     => __('Body Font', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the body font properties.', 'flaton'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Roboto',
                            'google'        => true,
                            'font-size'     => '14px',
                            'line-height'   => '1.4',
                        )
                    ),

                    array(
                        'id'        => 'nav-typography',
                        'type'      => 'typography',
                        'title'     => __('Navigation Font', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the navigation font properties.', 'flaton'),
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-style'    => '400',
                            'font-family'   => 'Roboto',
                            'google'        => true,
                            'font-size'     => '14px'
                        )
                    ),

                    array(
                        'id'        => 'h1-typography',
                        'type'      => 'typography',
                        'title'     => __('H1 Font Properties', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h1 font properties.', 'flaton'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '47.6px'
                        )
                    ),

                    array(
                        'id'        => 'h2-typography',
                        'type'      => 'typography',
                        'title'     => __('H2 Font Properties', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h2 font properties.', 'flaton'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '30.8px'
                        )
                    ),

                    array(
                        'id'        => 'h3-typography',
                        'type'      => 'typography',
                        'title'     => __('H3 Font Properties', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h3 font properties.', 'flaton'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '23.8px'
                        )
                    ),

                    array(
                        'id'        => 'h4-typography',
                        'type'      => 'typography',
                        'title'     => __('H4 Font Properties', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h4 font properties.', 'flaton'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '21px'
                        )
                    ),

                    array(
                        'id'        => 'h5-typography',
                        'type'      => 'typography',
                        'title'     => __('H5 Font Properties', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h5 font properties.', 'flaton'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '18.2px'
                        )
                    ),

                    array(
                        'id'        => 'h6-typography',
                        'type'      => 'typography',
                        'title'     => __('H6 Font Properties', 'flaton'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h6 font properties.', 'flaton'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '16.1px'
                        )
                    ),
                )
            );

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1',
                'title' => __('Theme Information 1', 'flaton'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'flaton')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2',
                'title' => __('Theme Information 2', 'flaton'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'flaton')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'flaton');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'flaton', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('Theme Options', 'flaton'),
                'page' => __('Theme Options', 'flaton'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyDKSdJkWKtewIhdI_Y0FRk01qREugZEpeQ', // Must be defined to add google fonts to the typography module
                //'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => '', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => '', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array('docs'),
                'help_sidebar' => '', // __( '', $this->args['domain'] );            
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
            $this->args['share_icons'][] = array(
                'url' => 'https://github.com/venkatraj',
                'title' => 'Visit me on GitHub',
                'icon' => 'fa fa-github'
                    // 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/pages/webulous/170827696548',
                'title' => 'Like us on Facebook',
                'icon' => 'fa fa-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://twitter.com/webulous',
                'title' => 'Follow us on Twitter',
                'icon' => 'fa fa-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.linkedin.com/company/coding-geek',
                'title' => 'Find us on LinkedIn',
                'icon' => 'fa fa-linkedin'
            );



            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                //$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'flaton'), $v);
                $this->args['intro_text'] = sprintf(__('<p class="btn-upgrade"><a href="http://www.webulousthemes.com/?add-to-cart=23"><i class="fa fa-upload"></i> Upgrade for just $39</a> <a href="http://demo.webulous.in/flaton" class="vide-demo"><i class="fa fa-eye"></i>View Demo</a><a href="http://www.webulousthemes.com/forums/forum/free-support/" target="_blank" class="btn-help">Ask A Question</a><a href="http://docs.webulous.in/flaton-free/" target="_blank" class="btn-help">Documentation</a></p>', 'flaton'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'flaton');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'flaton');
        }

    }

    new Redux_Framework_sample_config();
}


/**

  Custom function for the callback referenced above

 */
if (!function_exists('redux_my_custom_field')):

    function redux_my_custom_field($field, $value) {
        print_r($field);
        print_r($value);
    }

endif;

/**

  Custom function for the callback validation referenced above

 * */
if (!function_exists('redux_validate_callback_function')):

    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation

          if(something) {
          $value = $value;
          } elseif(something else) {
          $error = true;
          $value = $existing_value;
          $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }


endif;
