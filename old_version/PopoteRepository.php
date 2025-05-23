<?php

namespace Lesptitnours\Popotes;

class PopoteRepository
{
    /**
     * @return array<\WP_Post>
     */
    public static function getPopotesQueryByCategorySlug(string $popoteCategorySlug): array
    {
        $tax_query = array(
            'taxonomy' => 'ptitnours_popote_category',
            'field'    => 'slug',
            'terms'    => $popoteCategorySlug,
        );
        $args = array(
            'post_type'      => 'ptitnours_popote',
            'posts_per_page' => 3,
            'tax_query'      => [$tax_query]
        );

        $loop = new \WP_Query($args);

        return $loop->posts;
    }
}
