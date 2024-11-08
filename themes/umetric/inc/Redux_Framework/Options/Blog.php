<?php
/**
 * Umetric\Utility\Redux_Framework\Options\Blog class
 *
 * @package umetric
 */

namespace Umetric\Utility\Redux_Framework\Options;

use Redux;
use Umetric\Utility\Redux_Framework\Component;

class Blog extends Component {

	public function __construct() {
		$this->set_widget_option();
	}

	protected function set_widget_option() {
		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__( 'Blog', 'umetric' ),
			'id'    => 'blog',
			'icon'  => 'el el-quotes',
			'customizer_width' => '500px',
		) );

		Redux::set_section( $this->opt_name, array(
			'title' => esc_html__('General Blogs','umetric'),
			'id'    => 'blog-section',
			'subsection' => true,
			'desc'  => esc_html__('This section contains options for blog.','umetric'),
			'fields'=> array(

				array(
					'id'       => 'blog_default_banner_image',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__( 'Blog Page Default Banner Image','umetric'),
					'read-only'=> false,
					'default'  => array( 'url' => get_template_directory_uri() .'/assets/images/redux/banner.png' ),
					'subtitle' => esc_html__( 'Upload banner image for your Website. Otherwise blank field will be displayed in place of this section.','umetric').'<b>'.esc_html__("(Note:Only Display Banner Style Second & Third in Page Banner Setting)","umetric").'</b>',
				),

				array(
					'id'        => 'blog_setting',
					'type'      => 'image_select',
					'title'     => esc_html__( 'Blog page Setting','umetric' ),
					'subtitle'  => wp_kses( __( 'Choose among these structures (Right Sidebar, Left Sidebar, 1column, 2column and 3column) for your blog section.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.','umetric' ), array( 'br' => array() ) ),
					'options'   => array(
						'1' => array( 'title' => esc_html__( 'One Columns','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux//single-column.jpg' ),
						'2' => array( 'title' => esc_html__( 'Two Columns','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux//two-column.jpg' ),
						'3' => array( 'title' => esc_html__( 'Three Columns','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux//three-column.jpg' ),
						'4' => array( 'title' => esc_html__( 'Right Sidebar','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux//right-side.jpg' ),
						'5' => array( 'title' => esc_html__( 'Left Sidebar','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux//left-side.jpg' ),
					),
					'default'   => '1',
				),

				array(
					'id'        => 'display_pagination',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Pagination','umetric'),
					'subtitle' => esc_html__( 'Turn on to display the post pagination for blog page.','umetric'),
					'options'   => array(
						'yes' => esc_html__('On','umetric'),
						'no' => esc_html__('Off','umetric')
					),
					'default'   => esc_html__('yes','umetric')
				),

				array(
					'id'        => 'display_featured_image',
					'type'      => 'button_set',
					'title'     => esc_html__( 'Featured Image on Blog Archive Page','umetric'),
					'subtitle' => esc_html__( 'Turn on to display featured images on the blog or archive pages.','umetric'),
					'options'   => array(
						'yes' => esc_html__('On','umetric'),
						'no' => esc_html__('Off','umetric')
					),
					'default'   => esc_html__('yes','umetric')
				),
			)
		));

		Redux::set_section( $this->opt_name, array(
				'title'      => esc_html__( 'Blog Single Post', 'umetric' ),
				'id'         => 'basic',
				'subsection' => true,
				'fields'     => array(

					array(
						'id'        => 'blog_single_page_setting',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Blog Single page Setting','umetric' ),
						'subtitle'  => wp_kses( __( 'Choose among these structures (Right Sidebar, Left Sidebar and 1column) for your blog section.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.','umetric' ), array( 'br' => array() ) ),
						'options'   => array(
							'1' => array( 'title' => esc_html__( 'Full Width','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux/single-column.jpg' ),
							'4' => array( 'title' => esc_html__( 'Right Sidebar','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux/right-side.jpg' ),
							'5' => array( 'title' => esc_html__( 'Left Sidebar','umetric' ), 'img' => get_template_directory_uri() . '/assets/images/redux/left-side.jpg' ),
						),
						'default'   => '1',
					),

					array(
						'id'        => 'display_comment',
						'type'      => 'button_set',
						'title'     => esc_html__( 'Comments','umetric'),
						'subtitle' => esc_html__( 'Turn on to display comments','umetric'),
						'options'   => array(
							'yes' => esc_html__('On','umetric'),
							'no' => esc_html__('Off','umetric')
						),
						'default'   => esc_html__('yes','umetric')
					),

					/* featured Image hide option */
					array(
						'id'       => 'posts_select',
						'type'     => 'select',
						'multi'    => true,
						'title'    => esc_html__( 'Select Posts for hide Featues Images', 'umetric' ),
						'options'  => [
							"video"   => "Video Format",
							"quote"   => "Quote Format",
							"link"    => "Link Format",
							"audio"   => "Audio Format",
							"gallery" => "Gallery Format",
							"image"   => "Image Format"
						],
					),

				))
		);

	}
}
