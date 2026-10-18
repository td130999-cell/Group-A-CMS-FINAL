INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (44, '_coffee_subtitle', 'Our Signature House Blend') ON DUPLICATE KEY UPDATE meta_value='Our Signature House Blend';
UPDATE wp_postmeta SET meta_value='Graham cracker, cooked cherries, vanilla' WHERE post_id=44 AND meta_key='_coffee_tasting_notes';
UPDATE wp_postmeta SET meta_value='Washed & Natural' WHERE post_id=44 AND meta_key='_coffee_process';
UPDATE wp_postmeta SET meta_value='Colombia, Guatemala, Ethiopia' WHERE post_id=44 AND meta_key='_coffee_origins';

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (45, '_coffee_subtitle', 'Our Signature Espresso') ON DUPLICATE KEY UPDATE meta_value='Our Signature Espresso';
UPDATE wp_postmeta SET meta_value='Baker\'s chocolate, blueberries, hazelnut' WHERE post_id=45 AND meta_key='_coffee_tasting_notes';
UPDATE wp_postmeta SET meta_value='Washed & Natural' WHERE post_id=45 AND meta_key='_coffee_process';
UPDATE wp_postmeta SET meta_value='Colombia, Nicaragua, Ethiopia' WHERE post_id=45 AND meta_key='_coffee_origins';

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (46, '_coffee_subtitle', '') ON DUPLICATE KEY UPDATE meta_value='';
UPDATE wp_postmeta SET meta_value='Chocolate, caramel, well-balanced.' WHERE post_id=46 AND meta_key='_coffee_tasting_notes';
UPDATE wp_postmeta SET meta_value='Washed, Natural' WHERE post_id=46 AND meta_key='_coffee_process';
UPDATE wp_postmeta SET meta_value='Brazil & Colombia' WHERE post_id=46 AND meta_key='_coffee_origins';

DELETE FROM wp_options WHERE option_name LIKE '%ccc_coffee_card_%' OR option_name LIKE '%transient_ccc_coffee_%';
