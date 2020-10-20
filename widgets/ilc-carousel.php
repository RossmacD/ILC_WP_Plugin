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
            'posts_per_page' => '5',
                'orderby' => 'name',
                // 'order'   => 'ASC'
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

        // }else{
		// echo '<p>NOOO</p>';<div class="title">
            // <?php echo $settings['title'];
            // </div>

        // }
        ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css">
            <script src="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js"></script>
            <div class="glider-contain"  >
                <div class="glider" >
                    <div>1</div>
                    <div>2</div>
                    <div>3</div>
                    <div>4</div>
                </div>


                <div data-glide-el="controls">
                    <button data-glide-dir="<<"  class="glider-prev"><<</button>
                    <button data-glide-dir=">>"  class="glider-next">>></button>
                </div>
                <div role="tablist" class="dots"></div>
            </div>
            <script>
            window.addEventListener('load', function(){
                new Glider(document.querySelector('.glider'), {
                    slidesToShow: 1,
                    dots: '.dots',
                    draggable: true,
                    arrows: {
                        prev: '.glider-prev',
                        next: '.glider-next'
                    }
                });
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


