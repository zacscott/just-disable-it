<?php echo "<?xml version='1.0' encoding='UTF-8'?>"; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php

while ( $query->have_posts() ) : $query->the_post();
    ?>

    <url>
        <loc><?php echo esc_html( get_permalink() ); ?></loc>
        <lastmod><?php echo esc_html( get_the_date( 'Y-m-d\\Th:m:s\\Z' ) ); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <?php
endwhile;

?>

</urlset>