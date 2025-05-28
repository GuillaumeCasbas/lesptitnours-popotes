<?php

namespace Lesptitnours\Popotes\Repository;

class PopoteRepository
{
    /**
     * @return WP_Query
     */
    public static function getPopotesLoopByCategorySlug(string $categorySlug, int $limit = 3)
    {
        $args = array(
            'post_type'      => 'ptitnours_popote',
            'posts_per_page' => $limit,
            'category_name'  => $categorySlug
        );

        return new \WP_Query($args);
    }
}
