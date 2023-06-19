<?php

use JustSEO\Model\SEOMetaModel;

$seo_desc = $seo_model->get_desc();
$seo_robots = $seo_model->get_robots();

// Set default meta robots if none is set.
if ( empty( $seo_robots ) ) {
    $seo_robots = SEOMetaModel::DEFAULT_ROBOTS;
}

// Set default meta description if none is set.
if ( empty( $seo_desc ) ) {
    $seo_desc = get_the_excerpt();
}

?>
<meta name="robots" content="<?php echo esc_attr( $seo_robots ); ?>"/>
<meta name="description" content="<?php echo esc_attr( $seo_desc ); ?>"/>
