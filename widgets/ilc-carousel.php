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
        
        $this->add_control(
			'limit',
			[
				'label' => __( 'Limit', 'ilc-elementor-widgets' ),
				'type' => Controls_Manager::NUMBER,
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
            // 'post_type' => 'recipe',
            'posts_per_page' => (!$settings['limit']) ? 5 : $settings['limit'],
            'orderby' => 'name',
        );
        $query = new \WP_Query($args);

           
        // if ( $query->have_posts() ) {
        // echo '<p>';
        // while ( $query->have_posts() ) { 
        //     $query->the_post();
        //     echo get_the_title();
        //     echo get_the_content();
        // }
        // echo '</p>';
        // <svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg">
        // <path d="M19.3063 20.6643H5.91404C5.69791 20.6643 5.5281 20.4945 5.5281 20.2784V14.6745C2.99631 14.4815 0.997131 12.3666 0.997131 9.78846C0.997131 7.07914 3.197 4.87927 5.90632 4.87927C6.52383 4.87927 7.14134 4.99505 7.72025 5.22662C7.91322 2.70255 10.0282 0.703369 12.6063 0.703369C15.1844 0.703369 17.3071 2.70255 17.5 5.23434C18.079 5.00277 18.6887 4.88699 19.314 4.88699C22.0233 4.88699 24.2232 7.08686 24.2232 9.79618C24.2232 12.3743 22.224 14.497 19.6922 14.6899V20.2861C19.6922 20.4945 19.5147 20.6643 19.3063 20.6643ZM6.29998 19.8924H18.9203V14.304C18.9203 14.0879 19.0901 13.918 19.3063 13.918C21.591 13.918 23.4513 12.0655 23.4513 9.78074C23.4513 7.49596 21.5988 5.64344 19.314 5.64344C18.6116 5.64344 17.9169 5.82097 17.3071 6.16832C17.1836 6.23779 17.0369 6.23007 16.9134 6.1606C16.7976 6.08341 16.7282 5.95219 16.7282 5.81325L16.7359 5.72834C16.7359 5.68975 16.7436 5.64344 16.7436 5.60484C16.7436 3.32778 14.8911 1.47525 12.6063 1.47525C10.3215 1.47525 8.4767 3.32778 8.4767 5.61256C8.4767 5.65887 8.4767 5.69747 8.48442 5.73606C8.48442 5.73606 8.49214 5.81325 8.49214 5.82097C8.49986 5.95991 8.43039 6.09113 8.30689 6.16832C8.1911 6.24551 8.03673 6.24551 7.91322 6.17604C7.30343 5.83641 6.60874 5.65115 5.90632 5.65115C3.62154 5.65115 1.76902 7.5114 1.76902 9.78846C1.76902 12.0655 3.62154 13.9258 5.90632 13.9258C6.12245 13.9258 6.29998 14.0956 6.29998 14.3117V19.8924Z" fill="#E30062"/>
        // </svg>
        
        // }else{
		// echo '<p>NOOO</p>';<div class="title">
            // <?php echo $settings['title'];
            // </div>

        // }
        ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
        <div class="splide-contain">
            <div class="splide" >
                <div class="splide__track">
                    <ul class="splide__list">
                
                    <?php 
                    if ( $query->have_posts() ) {
                        
                        while ( $query->have_posts() ) { 
                            $query->the_post();
                        ?>
                        <section class="item elementor-section elementor-section-boxed splide__slide">
                            <div class="elementor-container cardPos">
                            <div class="ilc-catLabel">salads</div>
                                <div class="ilc-card">
                                    <div class="ilc-cardBody">
                                        <h3><?php echo get_the_title() ?></h3>
                                        <p><?php echo get_the_content() ?></p>
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

            
            <!-- <button data-glide-dir="<"  class="splide__arrow splide__arrow--prev glider-btn">
                <i class="eicon-chevron-left" aria-hidden="true"></i>
            </button> -->
                    
            <!-- <button data-glide-dir=">"  class="splide__arrow splide__arrow--next glider-btn">
                <i class="eicon-chevron-right" aria-hidden="true"></i>
            </button> -->
            <!-- <div role="tablist" class="dots"></div> -->
        </div>


        <style>
            .splide-contain{
                height:50vh;
                margin-bottom: 30px;
            }
            .splide__track, .splide, .splide__list, .splide__slide{
                height:100%!important;
            }
            .glider{
                height:100%;
            }

            .item{
                background: url("https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSNvatMGcVgTOvZFkIXH-t9PpU7zlZ1jXM1Hg&usqp=CAU");
                background-repeat: no-repeat; /* Do not repeat the image */
                background-size: cover; /* Resize the background image to cover the entire container */
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

            .ilc-cardBody{
                background-color: rgba(255, 255, 255,0.75);
                /* mix-blend-mode: lighten; */
                padding:1rem 1.5rem
            }

            .glider-btn{
                opacity:1;
                background-color: rgba(142, 204, 167,0.7);
                /* padding:1.5rem 3rem; */
                padding:0.5rem 1rem 0.5rem 3rem;
                /* border-radius:4rem;*/
                border-radius: 26px; 
                /* padding: 1rem 4rem 0 0; */
                height:auto;
                font-size:4rem;
            }
            .glider-btn:hover{
                background-color: rgba(255, 255, 255,0.5);
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
                padding:0.5rem 3rem 0.5rem 1rem;
                right:0;
            }


            .splide__pagination__page.is-active {
                background: rgb(227,0,98,1);
            }
            .splide__pagination__page {
                background: rgb(142,204,167);
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
                background-color: rgba(255, 255, 255,0.5);
                }
                .glider-btn:hover{
                    background-color: #ccc;
                }
            }
        </style>

        <script>
        window.addEventListener('load', function(){
            new Splide('.splide', {
                type   : 'loop',
	            perPage: 1,
                // slidesToShow: 1,
                // dots: '.dots',
                // draggable: true,
                // scrollLock: true,
                rewind:true,
                height:50,
                // // dragVelocity:20,
                // scrollLockDelay:50,
                // arrows: {
                //     prev: '.glider-prev',
                //     next: '.glider-next'
                // }
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


