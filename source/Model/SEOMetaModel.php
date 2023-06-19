<?php

namespace JustSEO\Model;

/** 
 * Handles all interactions with the SEO meta data in the database.
 * 
 * @package JustSEO\Library
 */
class SEOMetaModel {

    const META_KEY_ROBOTS    = 'just_seo_robots';
    const META_KEY_DESC      = 'just_seo_desc';
    const META_KEY_CANONICAL = 'just_seo_canonical';

    const DEFAULT_ROBOTS = 'index, follow';

    /** 
     * Get the robots meta for a post.
     * 
     * @param int $post_id The ID of the post.
     * @return int|null The robots meta.
     */
    public function get_robots( $post_id = 0 ) {

        // By default, get for current post.
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $value = get_post_meta(
            $post_id,
            self::META_KEY_ROBOTS,
            true
        );

        return $value;

    }

    /** 
     * Set the robots meta for a post.
     * 
     * @param int $post_id The ID of the post.
     * @param int $robots The robots meta.
     */
    public function set_robots( $value, $post_id = 0 ) {

        // By default, set for current post.
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        update_post_meta(
            $post_id,
            self::META_KEY_ROBOTS,
            $value
        );

    }

    /** 
     * Get the canonical URL for a post.
     * 
     * @param int $post_id The ID of the post.
     * @return int|null The canonical URL.
     */
    public function get_canonical( $post_id = 0 ) {

        // By default, get for current post.
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $value = get_post_meta(
            $post_id,
            self::META_KEY_CANONICAL,
            true
        );

        return $value;

    }

    /** 
     * Set the canonical URL for a post.
     * 
     * @param int $post_id The ID of the post.
     * @param int $canonical The canonical URL.
     */
    public function set_canonical( $value, $post_id = 0 ) {

        // By default, set for current post.
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        update_post_meta(
            $post_id,
            self::META_KEY_CANONICAL,
            $value
        );

    }

    /** 
     * Get the SEO meta description for a post.
     * 
     * @param int $post_id The ID of the post.
     * @return int|null The description.
     */
    public function get_desc( $post_id = 0 ) {

        // By default, get for current post.
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $value = get_post_meta(
            $post_id,
            self::META_KEY_DESC,
            true
        );

        return $value;

    }

    /** 
     * Set the SEO meta description for a post.
     * 
     * @param int $post_id The ID of the post.
     * @param int $desc The description.
     */
    public function set_desc( $value, $post_id = 0 ) {

        // By default, set for current post.
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        update_post_meta(
            $post_id,
            self::META_KEY_DESC,
            $value
        );

    }

    /** 
     * Get all robots meta options.
     * 
     * @return array The robots meta options.
     */
    public function get_robots_options() {

        $options = [
            'index, follow',
            'noindex, follow',
            'index, nofollow',
            'noindex, nofollow',
        ];

        return $options;

    }

}
