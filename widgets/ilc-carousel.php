<?php
namespace ILC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class ILC_Carousel extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ilc-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'ILC Carousel', 'ilc-elementor-widgets' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-media-carousel';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'ilc-elementor-widgets' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ilc-elementor-widgets' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'ilc-elementor-widgets' ),
				'type' => Controls_Manager::TEXT,
			]
        );
        
        // Custom Controls
        $this->add_control(
			'limit',
			[
				'label' => __( 'Limit', 'ilc-elementor-widgets' ),
				'type' => Controls_Manager::NUMBER,
			]
        );

        $this->add_control(
			'selected_posts',
			[
				'label' => __( 'Select Posts', 'ilc-elementor-widgets' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'options' => [
					'' => __( 'None', 'ilc-elementor-widgets' ),
					'uppercase' => __( 'UPPERCASE', 'ilc-elementor-widgets' ),
					'lowercase' => __( 'lowercase', 'ilc-elementor-widgets' ),
					'capitalize' => __( 'Capitalize', 'ilc-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'ilc-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_transform',
			[
				'label' => __( 'Text Transform', 'ilc-elementor-widgets' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'options' => [
					'' => __( 'None', 'ilc-elementor-widgets' ),
					'uppercase' => __( 'UPPERCASE', 'ilc-elementor-widgets' ),
					'lowercase' => __( 'lowercase', 'ilc-elementor-widgets' ),
					'capitalize' => __( 'Capitalize', 'ilc-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();
        $args = array(
            'post_type' => 'recipe',
            'posts_per_page' => (!$settings['limit']) ? 5 : $settings['limit'],
            'orderby' => 'name',
        );
        $query = new \WP_Query($args);
        $vote_count = woo_fnc_get_cont_rating(get_the_id());

        ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
        <script  src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
        <div class="splide-contain">
            <div class="splide" >
                <div class="splide__track">
                    <ul class="splide__list">
                
                    <?php 
                    if ( $query->have_posts() ) {
                        
                        while ( $query->have_posts() ) { 
                            $query->the_post();
			                $skill_level = get_the_terms(get_the_id(), 'skill_level');

                        ?>
                        <section class="item elementor-section elementor-section-boxed splide__slide" style=<?php echo '"background-image: url(\''. wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'small' )[0] .'\');"'?>>
                            <div class="elementor-container cardPos">
                            <div class="ilc-catLabel">salads</div>
                                <div class="ilc-card">
                                    <div class="ilc-cardBody">
                                        <div class="ilc-cardtext">
                                            <h3><?php echo get_the_title() ?></h3>
                                            <p><?php 
                                            echo the_excerpt()
                                            // echo get_the_rating()
                                            ?></p>
                                        </div>
                                        <div class="ilc-cardinfo">
                                            <p>👨‍🍳</p>
                                            <p><?php echo $skill_level[0]->name?></p>
                                            <p>
                                                <?php for ($x = 1; $x <= woo_fnc_get_avg_rating(get_the_id()); $x++) {
                                                    echo "⭐";
                                                } ?>
                                            </p>
                                            <!-- <p>⭐⭐⭐⭐⭐</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> 
                        <?php 
                        }
                    }
                ?>

                        <!-- <section class="item elementor-section elementor-section-boxed splide__slide">
                            <div class="elementor-container cardPos">
                            <div class="ilc-catLabel">salads</div>

                                <div class="ilc-card">
                                    <div class="ilc-cardBody">
                                        <h3>Grilled Peach Salad</h3>
                                        <p>This salad may only have a few ingredients but its not short on a mix of flavours and texture</p>
                                    </div>
                                </div>
                            </div>
                        </section>  -->
                        
                    </ul>
                </div>

                <div class="splide__arrows">
                <button class="splide__arrow splide__arrow--prev glider-btn">
                    <i class="eicon-chevron-left" aria-hidden="true"></i>
                </button>
                <button class="splide__arrow splide__arrow--next glider-btn">
                    <i class="eicon-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
            </div>
        </div>


        <style>
            .splide-contain{
                height:60vh;
                margin-bottom: 30px;
            }
            .splide__track, .splide, .splide__list, .splide__slide{
                height:100%!important;
            }
            .glider{
                height:100%;
            }

            .item{
                /* background: url("https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSNvatMGcVgTOvZFkIXH-t9PpU7zlZ1jXM1Hg&usqp=CAU"); */
                background-repeat: no-repeat; /* Do not repeat the image */
                background-size: cover;
                background-position: center;
                height:100%;
            }
            .cardPos{
                flex-direction: column;
                justify-content: flex-end;
                align-items: flex-start;
                height:100%;
            }
            

            .ilc-card{
                max-width:480px;
            }

            .ilc-catLabel{
                text-transform: uppercase;
                background-color:#95CCA7;
                padding:1rem 2rem;
                margin-bottom:1.5rem;
                color: white;
            }

            .ilc-cardtext{
                flex:1;
            }
            .ilc-cardinfo{
                flex:0.3;
                display:flex;
                flex-direction:column;
                justify-content:flex-end;
                align-items:flex-end;
            }

            .ilc-cardBody{
                background-color: rgba(255, 255, 255,0.75);
                /* mix-blend-mode: lighten; */
                padding:1rem 1.5rem;
                display:flex;
            }

            .glider-btn{
                opacity:1;
                background-color: rgba(142, 204, 167,0.7) !important;
                /* padding:1.5rem 3rem; */
                padding:0.5rem 1rem 0.5rem 1rem;
                /* border-radius:4rem;*/
                border-radius: 26px; 
                /* padding: 1rem 4rem 0 0; */
                height:auto;
                font-size:2rem;
                width:auto;
            }
            .glider-btn:hover{
                background-color: rgba(255, 255, 255,0.5)!important;
            }

            .glider-btn i{
                color: white;
            }

            .splide__arrow--prev{
                left:0;
                border-radius:0 26px 26px 0rem;
            }
            .splide__arrow--next{
                border-radius:26px 0 0 26px;
                padding:0.5rem 1rem 0.5rem 1rem;
                right:0;
            }


            .splide__pagination__page.is-active {
                background: rgb(227,0,98,1)!important;
            }
            .splide__pagination__page {
                background: rgb(142,204,167)!important;
            }
            .splide__pagination{
                bottom: -1.5em;
            }

            @media all and (max-width: 750px) {
                .cardPos{
                    justify-content: space-between;
                }

                .glider-btn{
                    /* background-color: #ccc; */
                background-color: rgba(255, 255, 255,0.5)!important;
                }
                .glider-btn:hover{
                    background-color: #ccc!important;
                }
            }
        </style>

        <script>
        window.addEventListener('load', function(){
            new Splide('.splide', {
                type   : 'loop',
	            perPage: 1,
                rewind:true,
                // autoplay: true,
	            pauseOnHover: true,
            }).mount();
        })
        </script>
		<?php
        
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<div class="title">
			{{{ settings.title }}}
		</div>
		<?php
	}
}


