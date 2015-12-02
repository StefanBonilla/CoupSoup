<?php
if ( 'posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
} else {
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package FLATON
 */
		get_header(); 

		if( isset($flaton) ) {
					if( isset($flaton['homepage_blocks']['enabled']['slider']) && isset($flaton['slides']) ) {
						$slides = $flaton['slides'];
						$output = '';
						if( count($slides) > 1) {

							$output .= '<div class="flex-container">';
							$output .= '<div class="flexslider">';
							$output .= '<ul class="slides">';

							foreach($slides as $slide) {
								$output .= '<li>';
								$output .= '<div class="flex-image"><img src="' . esc_url( $slide['image'] ) . '" alt="" ></div>';
								if ( $slide['description'] != '' ) {
									$output .= '<div class="flex-caption">' . $slide['description'] . '</div>';
								}
								$output .= '</li>';
							}

							$output .= '</ul>';
							$output .= '</div><!-- .flexslider -->';
							$output .= '</div><!-- .flex-container -->';

						} else {
							$output = '';
							$output .= '<div class="flex-container">';
							$output .= '<div class="flexslider">';
							$output .= '<ul class="slides">';
								$output .= '<li>';
									$output .= '<div class="flex-image"><img src="' . esc_url( $flaton_home['slide1'] ) . '" alt="" ></div>';
									$output .= '<div class="flex-caption">' . $flaton_home['caption1'] . '</div>';
								$output .= '</li>';
								$output .= '<li>';
									$output .= '<div class="flex-image"><img src="' . esc_url( $flaton_home['slide2'] ) . '" alt="" ></div>';
									$output .= '<div class="flex-caption">' . $flaton_home['caption2'] . '</div>';
								$output .= '</li>';

							$output .= '</ul>';
							$output .= '</div><!-- .flexslider -->';
							$output .= '</div><!-- .flex-container -->';

						}

						echo $output;
						
					}

					if( isset( $flaton['homepage_blocks']['enabled']['services'] ) ) {
						$output = '';
							$output = '<div class="services">';
							$output .= '<div class="container">';
							$output .= '<div class="row">';
								if( isset( $flaton['service-main-title'] ) ) {
									$output .= '<h2 class="service-title">' . $flaton['service-main-title'] . '</h2>';
								}
								if( isset( $flaton['service-sub-title'] ) ) {
									$output .= '<h3 class="service-subtitle">' . $flaton['service-sub-title'] . '</h3>';
								}
								$output .= '<div id="service-tabs">';
								$output .= '<ul>';
								if( isset( $flaton['service-title-1'] ) ) {
									$output .= '<li><a href="#service-tab-1">' . $flaton['service-title-1'] . '</a></li>';
								}
								if( isset( $flaton['service-title-2'] ) ) {
									$output .= '<li><a href="#service-tab-2">' . $flaton['service-title-2'] . '</a></li>';
								}
								if( isset( $flaton['service-title-3'] ) ) {
									$output .= '<li><a href="#service-tab-3">' . $flaton['service-title-3'] . '</a></li>';
								}
								if( isset( $flaton['service-title-4'] ) ) {
									$output .= '<li><a href="#service-tab-4">' . $flaton['service-title-4'] . '</a></li>';
								}
								if( isset( $flaton['service-title-5'] ) ) {
									$output .= '<li><a href="#service-tab-5">' . $flaton['service-title-5'] . '</a></li>';
								}
								$output .= '</ul><br class="clear"/>';
								if( isset( $flaton['service-icon-1'] ) && isset( $flaton['service-description-1'] ) ) {
									$output .= '<div id="service-tab-1">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton['service-icon-1'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton['service-title-1'] ) . '</h3>' . $flaton['service-description-1'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-1 -->';
								}

								if( isset( $flaton['service-icon-2'] ) && isset( $flaton['service-description-2'] ) ) {
									$output .= '<div id="service-tab-2">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton['service-icon-2'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton['service-title-2'] ) . '</h3>' . $flaton['service-description-2'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-2 -->';
								}

								if( isset( $flaton['service-icon-3'] ) && isset( $flaton['service-description-3'] ) ) {
									$output .= '<div id="service-tab-3">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton['service-icon-3'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton['service-title-3'] ) . '</h3>' . $flaton['service-description-3'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-3 -->';
								}

								if( isset( $flaton['service-icon-4'] ) && isset( $flaton['service-description-4'] ) ) {
									$output .= '<div id="service-tab-4">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton['service-icon-4'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton['service-title-4'] ) . '</h3>' . $flaton['service-description-4'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-4 -->';
								}

								if( isset( $flaton['service-icon-5'] ) && isset( $flaton['service-description-5'] ) ) {
									$output .= '<div id="service-tab-5">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton['service-icon-5'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton['service-title-5'] ) .'</h3>' . $flaton['service-description-5'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-5 -->';
								}
							$output .= '</div> <!-- #services-tabs -->';
							$output .= '</div> <!-- .row -->';
							$output .= '</div> <!-- .container -->';
							$output .= '</div> <!-- .services -->';

						echo $output;
					}
		?>
		<div id="content" class="site-content">
				
				<div id="primary" class="content-area">
					<main id="main" class="site-main container" role="main">

					<?php if( isset( $flaton['homepage_blocks']['enabled']['team'] )) : ?>
						<div class="row">
							<h2 class="service-title"><div><?php _e('Meet The Team','flaton'); ?></div></h2><div class="team-content"><div class="innercol"><?php echo $flaton['team']; ?><br class="clear"/></div></div>
						</div>
					<?php endif; ?>

					<?php if( isset( $flaton['homepage_blocks']['enabled']['extra-info'] )) : ?>
						<div class="row">
							<div class="sixteen columns"><div id="add-info"><?php echo $flaton['extra-info']; ?><br class="clear"/></div></div>
						</div>
					<?php endif; ?>

					<?php if( isset( $flaton['homepage_blocks']['enabled']['features'] )) : ?>
						<div class="row">
							<div class="feature-wrap">

							<div class="eight columns" id="whyus">
								<div class="feature2">
									<?php echo isset( $flaton['features'] ) ? $flaton['features'] : '' ?>
								</div>
							</div>

							<div class="eight columns" id="skills">
								<?php
									$output = '';
									if ( isset( $flaton['skill-heading'] ) ) {
										$output .= '<h2>' . esc_html( $flaton['skill-heading'] ) . '</h2>';
									}

									for ($i=1;$i<6;$i++) {
										$skill = "skill-{$i}";
										$percentage = "percentage-{$i}";
										$icon = "skill-icon-{$i}";
										if( isset( $skill ) && isset( $flaton[$icon] ) && isset( $flaton[$percentage] ) && isset( $flaton[$skill] ) ) {
											$output .= '<div class="skill-container"><i class="' . esc_attr( $flaton[$icon] ) . '"></i>';
											$output .= '<div class="skill">';
											$output .= '<div class="skill-percentage percent' . esc_attr( $flaton[$percentage] ) .' start"><span class="circle"></span></div>';
											$output .= '<div class="skill-content">'  . $flaton[$skill] .'<span> ' . $flaton[$percentage] . '%</span></div>';
											$output .= '</div>';
											$output .= '</div>';
										}
									}

									echo $output;
								?>
							</div> <!-- .eight columns skills -->
							<br class="clear"/>
							</div>

						</div> <!-- .row -->
								
					<?php endif; ?>

					<?php if( isset( $flaton['homepage_blocks']['enabled']['recent_posts'] )) : ?>
						<div class="row">
							<div class="sixteen columns">
								<h2><?php _e( 'Recent Posts','flaton'); ?></h2>
								<?php flaton_recent_posts(); ?>
							</div><!-- .sixteen columns -->
						</div><!-- .row -->
					<?php endif;  ?>

					<?php if( isset( $flaton['homepage_blocks']['enabled']['default'] )) : 
							while ( have_posts() ) : the_post();
								the_content();
							endwhile;
						endif; 

				} else {
					if( isset( $flaton_home ) ) {
						$output = '';
							$output .= '<div class="flex-container">';
							$output .= '<div class="flexslider">';
							$output .= '<ul class="slides">';
								$output .= '<li>';
									$output .= '<div class="flex-image"><img src="' . esc_url( $flaton_home['slide1'] ) . '" alt="" ></div>';
									$output .= '<div class="flex-caption">' . $flaton_home['caption1'] . '</div>';
								$output .= '</li>';
								$output .= '<li>';
									$output .= '<div class="flex-image"><img src="' . esc_url( $flaton_home['slide2'] ) . '" alt="" ></div>';
									$output .= '<div class="flex-caption">' . $flaton_home['caption2'] . '</div>';
								$output .= '</li>';

							$output .= '</ul>';
							$output .= '</div><!-- .flexslider -->';
							$output .= '</div><!-- .flex-container -->';

							$output .= '<div class="services">';
							$output .= '<div class="container">';
							$output .= '<div class="row">';
								if( isset( $flaton_home['service-main-title'] ) ) {
									$output .= '<h2 class="service-title">' . esc_html( $flaton_home['service-main-title'] ) . '</h2>';
								}
								if( isset( $flaton_home['service-sub-title'] ) ) {
									$output .= '<h3 class="service-subtitle">' . esc_html( $flaton_home['service-sub-title'] ) . '</h3>';
								}
								$output .= '<div id="service-tabs">';
								$output .= '<ul>';
								if( isset( $flaton_home['service-title-1'] ) ) {
									$output .= '<li><a href="#service-tab-1">' . esc_html( $flaton_home['service-title-1'] ) . '</a></li>';
								}
								if( isset( $flaton_home['service-title-2'] ) ) {
									$output .= '<li><a href="#service-tab-2">' . esc_html( $flaton_home['service-title-2'] ) . '</a></li>';
								}
								if( isset( $flaton_home['service-title-3'] ) ) {
									$output .= '<li><a href="#service-tab-3">' . esc_html( $flaton_home['service-title-3'] ) . '</a></li>';
								}
								if( isset( $flaton_home['service-title-4'] ) ) {
									$output .= '<li><a href="#service-tab-4">' . esc_html( $flaton_home['service-title-4'] ) . '</a></li>';
								}
								if( isset( $flaton_home['service-title-5'] ) ) {
									$output .= '<li><a href="#service-tab-5">' . esc_html( $flaton_home['service-title-5'] ) . '</a></li>';
								}
								$output .= '</ul><br class="clear"/>';
								if( isset( $flaton_home['service-icon-1'] ) && isset( $flaton_home['service-description-1'] ) ) {
									$output .= '<div id="service-tab-1">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton_home['service-icon-1'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton_home['service-title-1'] ) . '</h3>' . $flaton_home['service-description-1'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-1 -->';
								}

								if( isset( $flaton_home['service-icon-2'] ) && isset( $flaton_home['service-description-2'] ) ) {
									$output .= '<div id="service-tab-2">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton_home['service-icon-2'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton_home['service-title-2'] ) . '</h3>' . $flaton_home['service-description-2'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-2 -->';
								}

								if( isset( $flaton_home['service-icon-3'] ) && isset( $flaton_home['service-description-3'] ) ) {
									$output .= '<div id="service-tab-3">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton_home['service-icon-3'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton_home['service-title-3'] ) . '</h3>' . $flaton_home['service-description-3'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-3 -->';
								}

								if( isset( $flaton_home['service-icon-4'] ) && isset( $flaton_home['service-description-4'] ) ) {
									$output .= '<div id="service-tab-4">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton_home['service-icon-4'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton_home['service-title-4'] ) . '</h3>' . $flaton_home['service-description-4'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-4 -->';
								}

								if( isset( $flaton_home['service-icon-5'] ) && isset( $flaton_home['service-description-5'] ) ) {
									$output .= '<div id="service-tab-5">';
									$output .= '<div class="four columns"><div class="tab-icon"><i class="' . esc_attr( $flaton_home['service-icon-5'] ) . '"></i></div></div>';
									$output .= '<div class="service-desc twelve columns">' . '<h3 class="tabs-title">' . esc_html( $flaton_home['service-title-5'] ) .'</h3>' . $flaton_home['service-description-5'] . '</div><br class="clear"/>';
									$output .= '</div><!-- #service-tab-5 -->';
								}
							$output .= '</div> <!-- #services-tabs -->';
							$output .= '</div> <!-- .row -->';
							$output .= '</div> <!-- .container -->';
							$output .= '</div> <!-- .services -->';

						echo $output;
					}
		?>
		<div id="content" class="site-content">
				
				<div id="primary" class="content-area">
					<main id="main" class="site-main container" role="main">
		<?php
					if( isset( $flaton_home )) { ?>
							<hr/>
							<div class="row">
								<h2 class="service-title"><div><?php _e('Meet The Team','flaton'); ?></div></h2><div class="team-content"><div class="innercol"><?php echo $flaton_home['team']; ?><br class="clear"/></div></div>
							</div>
							<hr/>
							<div class="row">
								<div class="sixteen columns"><div id="add-info"><?php echo $flaton_home['extra-info']; ?><br class="clear"/></div></div>
							</div>
							<hr/>
							<div class="row">
								<div class="feature-wrap">

								<div class="eight columns" id="whyus">
									<div class="feature2">
										<?php echo isset( $flaton_home['features'] ) ? $flaton_home['features'] : '' ?>
									</div>
								</div>

								<div class="eight columns" id="skills">
									<?php
										$output = '';
										if ( isset( $flaton_home['skill-heading'] ) ) {
											$output .= '<h2>' . esc_html( $flaton_home['skill-heading'] ) . '</h2>';
										}

										for ($i=1;$i<6;$i++) {
											$skill = "skill-{$i}";
											$percentage = "percentage-{$i}";
											$icon = "skill-icon-{$i}";
											if( isset( $skill ) && isset( $flaton_home[$icon] ) && isset( $flaton_home[$percentage] ) && isset( $flaton_home[$skill] ) ) {
												$output .= '<div class="skill-container"><i class="' . esc_attr( $flaton_home[$icon] ) . '"></i>';
												$output .= '<div class="skill">';
												$output .= '<div class="skill-percentage percent' . esc_attr( $flaton_home[$percentage] ) .' start"><span class="circle"></span></div>';
												$output .= '<div class="skill-content">'  . $flaton_home[$skill] .'<span> ' . $flaton_home[$percentage] . '%</span></div>';
												$output .= '</div>';
												$output .= '</div>';
											}
										}

										echo $output;
									?>
								</div> <!-- .eight columns skills -->
								<br class="clear"/>
								</div>

							</div> <!-- .row -->
							<hr/>
							<div class="row">
								<div class="sixteen columns">
									<h2><?php _e('Recent Posts','flaton'); ?></h2>
									<?php flaton_recent_posts(); ?>
								</div><!-- .sixteen columns -->
							</div><!-- .row -->
							<?php
								while ( have_posts() ) : the_post();
									the_content();
								endwhile;
							}
						}
				?>
			
			</main><!-- #main -->
		</div><!-- #primary -->
<?php 
		get_footer(); 
}
?>