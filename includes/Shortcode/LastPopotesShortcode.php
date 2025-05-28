<?php

namespace Lesptitnours\Popotes\Shortcode;

use Lesptitnours\Popotes\Repository\PopoteRepository;

class LastPopotesShortcode
{
    public function __construct()
    {
        add_shortcode('last-popotes', array($this, 'setupShortcode'));
    }

    public function setupShortcode($atts = [], $content = null, $tag = '')
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        $attributes = shortcode_atts(
            array(
                'category-slug' => null,
            ),
            $atts,
            $tag
        );

        $query = PopoteRepository::getPopotesLoopByCategorySlug($attributes['category-slug']);
        
        $items = '';

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) :
                $query->the_post();
                $items .= '<div class="col-md-6 col-lg-4">';

                    ob_start();
                    get_template_part( 'template-parts/content', get_post_type(), ['isCard' => true] );
                    $items .= ob_get_clean();

                $items .= '</div>';
            endwhile;
            wp_reset_postdata();
            
            return '<div class="row">' . $items . '</div>';
        } else {
            return '<p>No items found for this category</p>';
        }

    }
}
