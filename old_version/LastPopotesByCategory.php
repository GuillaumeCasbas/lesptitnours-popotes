<?php
namespace Lesptitnours\Popotes\Shortcodes;

use Lesptitnours\Popotes\PopoteRepository;

/**
 * [last-popotes-by-category popote-category-slug=""]
 */
class LastPopotesByCategory
{
  public function __construct()
  {
    add_shortcode('last-popotes-by-category', array($this, 'lastPopoteByCategory'));
  }

  public function lastPopoteByCategory($atts = [], $content = null, $tag = '') {
    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );

    // override default attributes with user attributes
    $attributes = shortcode_atts(
      array(
        'popote-category-slug' => null,
      ), $atts, $tag
    );

    $o = '';
    $popotes = PopoteRepository::getPopotesQueryByCategorySlug($attributes['popote-category-slug']);
    
    $o .= '<div>';
    foreach ($popotes as $p) {
      $o .= '<div>';
      if ( has_post_thumbnail($p) ) {
        $thumbnail_id = get_post_thumbnail_id($p);
        $o .= wp_get_attachment_image( $thumbnail_id, 'large' ); // 
      }
      $o .= '<h2>' . get_the_title($p) . '<h2>';
      $o .= '</div>';
    }
    $o .= '</div>';

    return $o;
  }
}