<?php
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

echo "--- Seeding Quills Coffee Products into WooCommerce ---\n";

// Function to import image to media library if not already imported
function import_quills_image($rel_path, $title) {
    global $wpdb;
    $full_path = ABSPATH . $rel_path;
    if (!file_exists($full_path)) {
        return 0;
    }
    
    $existing = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = 'attachment'", $title));
    if ($existing) {
        return (int)$existing;
    }
    
    $wp_upload_dir = wp_upload_dir();
    $filename = basename($full_path);
    $dest = $wp_upload_dir['path'] . '/' . $filename;
    copy($full_path, $dest);
    
    $filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'guid'           => $wp_upload_dir['url'] . '/' . $filename, 
        'post_mime_type' => $filetype['type'],
        'post_title'     => $title,
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    
    $attach_id = wp_insert_attachment($attachment, $dest);
    $attach_data = wp_generate_attachment_metadata($attach_id, $dest);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
}

$products_data = [
    [
        'title' => 'Guatemala | Alma',
        'slug'  => 'guatemala-alma',
        'price' => '23.00',
        'roast' => 'Light',
        'process' => 'Washed',
        'type' => 'Single Origin',
        'tasting_notes' => 'malt chocolate, date, pecan',
        'country' => 'Guatemala',
        'region' => 'Huehuetenango',
        'producer' => 'Partner Smallholders',
        'varieties' => 'Bourbon, Caturra, Pache',
        'elevation' => '1,400 - 1,600 MASL',
        'main_img' => 'wp-content/uploads/quills/guatemala_alma_main.jpg',
        'sec_img'  => 'wp-content/uploads/quills/guatemala_alma_label.png',
        'desc' => "For three generations, the producers behind Alma have grown coffee in the highlands of Huehuetenango. Over the past twenty years, they have expanded to partner with other producing families, cooperatives, and associations across Guatemala. Their mission is to connect these families and their coffees with roasters around the world.\n\n'La Alma' means 'the soul', and this blend is intended to bring vitality and warmth to an espresso or filter cup.",
        'reviews' => [
            ['author' => 'Marcus Vance', 'rating' => 5, 'title' => 'Stunning sweetness on V60', 'content' => 'One of the cleanest Guatemalans I have brewed this year. Dates and smooth malt chocolate come through right at 92C. Super consistent roast.'],
            ['author' => 'Sarah Jenkins', 'rating' => 5, 'title' => 'My daily morning ritual', 'content' => 'Ordered whole bean and ground on my Ode. Absolutely delicious with delicate acidity and nice pecan finish. Definitely subscribing!'],
            ['author' => 'David Nguyen', 'rating' => 4, 'title' => 'Very solid single origin', 'content' => 'Great as drip and Aeropress. Clean cup, sweet chocolate aroma filling the kitchen every morning.']
        ]
    ],
    [
        'title' => 'Colombia | El Paraiso',
        'slug'  => 'colombia-el-paraiso',
        'price' => '24.00',
        'roast' => 'Light',
        'process' => 'Washed',
        'type' => 'Single Origin',
        'tasting_notes' => 'white peach, jasmine, meyer lemon, honey',
        'country' => 'Colombia',
        'region' => 'Cauca',
        'producer' => 'Diego Samuel Bermudez',
        'varieties' => 'Castillo',
        'elevation' => '1,930 MASL',
        'main_img' => 'wp-content/uploads/quills/colombia_paraiso_main.jpg',
        'sec_img'  => 'wp-content/uploads/quills/colombia_paraiso_feat.jpg',
        'desc' => "Finca El Paraiso is a world-renowned benchmark for innovative processing in Colombia. Diego Samuel Bermudez has pioneered thermal shock and controlled anaerobic fermentation to enhance aromatic clarity and silky mouthfeel.",
        'reviews' => [
            ['author' => 'Elena Rostova', 'rating' => 5, 'title' => 'Floral explosion!', 'content' => 'The jasmine and peach notes are unmistakable. Easily competition quality coffee at home.'],
            ['author' => 'James Wilson', 'rating' => 5, 'title' => 'Incredible anaerobic profile', 'content' => 'So fragrant and tea-like. Quills did an exceptional job keeping the roast light and expressive.']
        ]
    ],
    [
        'title' => 'Blacksmith | Espresso Blend',
        'slug'  => 'blacksmith-espresso-blend',
        'price' => '20.00',
        'roast' => 'Medium',
        'process' => 'Washed & Natural',
        'type' => 'Blend',
        'tasting_notes' => 'dark chocolate, caramelized sugar, candied orange',
        'country' => 'Guatemala & Colombia',
        'region' => 'Huehuetenango & Huila',
        'producer' => 'Regional Smallholders',
        'varieties' => 'Caturra, Castillo, Typica',
        'elevation' => '1,500 - 1,800 MASL',
        'main_img' => 'wp-content/uploads/quills/blacksmith_main.jpg',
        'sec_img'  => 'wp-content/uploads/quills/blacksmith_back.jpg',
        'desc' => "Blacksmith is our signature espresso blend. Designed to cut smoothly through steamed milk for lattes and flat whites while delivering a syrupy, heavy-bodied straight shot of espresso with lingering cacao sweetness.",
        'reviews' => [
            ['author' => 'Tyler Bennett', 'rating' => 5, 'title' => 'The best espresso blend period', 'content' => 'Pulls thick, golden crema on my La Marzocco Micra. Tastes like dessert in a cup with oat milk.'],
            ['author' => 'Chloe Bennett', 'rating' => 5, 'title' => 'Unbeatable crema and sweetness', 'content' => 'Sweet, zero bitter astringency. We go through a 2lb bag every two weeks at our office.']
        ]
    ],
    [
        'title' => 'Inkwell | Signature Blend',
        'slug'  => 'inkwell-signature-blend',
        'price' => '20.00',
        'roast' => 'Medium',
        'process' => 'Washed',
        'type' => 'Blend',
        'tasting_notes' => 'milk chocolate, sweet praline, fuji apple',
        'country' => 'Colombia & Ethiopia',
        'region' => 'Nariño & Sidama',
        'producer' => 'Smallholder Cooperatives',
        'varieties' => 'Heirloom, Caturra',
        'elevation' => '1,700 - 2,000 MASL',
        'main_img' => 'wp-content/uploads/quills/inkwell_main.jpg',
        'sec_img'  => 'wp-content/uploads/quills/blacksmith_back.jpg',
        'desc' => "Inkwell is our flagship house blend that celebrates balance, everyday approachability, and comforting warmth. Smooth milk chocolate notes married to crisp apple sweetness.",
        'reviews' => [
            ['author' => 'Rachel Adams', 'rating' => 5, 'title' => 'Classic and perfectly balanced', 'content' => 'Our entire household loves this. Crowd-pleaser for both casual drinkers and specialty coffee geeks.']
        ]
    ],
    [
        'title' => 'Night Owl | Dark Blend',
        'slug'  => 'night-owl-dark-blend',
        'price' => '20.00',
        'roast' => 'Dark',
        'process' => 'Washed',
        'type' => 'Blend',
        'tasting_notes' => 'smoky baker\'s chocolate, toasted marshmallow, molasses',
        'country' => 'Honduras & Brazil',
        'region' => 'Marcala & Minas Gerais',
        'producer' => 'Fair Trade Co-ops',
        'varieties' => 'Catimor, Mundo Novo',
        'elevation' => '1,200 - 1,400 MASL',
        'main_img' => 'wp-content/uploads/quills/night_owl_main.jpg',
        'sec_img'  => 'wp-content/uploads/quills/blacksmith_back.jpg',
        'desc' => "For those who love deep, roasty, rich flavors without bitterness. Night Owl brings cozy fireside warmth with thick crema, rich baker's chocolate, and sweet molasses.",
        'reviews' => [
            ['author' => 'Gregory House', 'rating' => 5, 'title' => 'A dark roast done right', 'content' => 'Most specialty roasters burn dark roasts or refuse to make them. Quills nailed this—rich, roasty, but still full of sweet molasses flavor.']
        ]
    ],
    [
        'title' => 'Ethiopia | Bombe',
        'slug'  => 'ethiopia-bombe',
        'price' => '24.00',
        'roast' => 'Light',
        'process' => 'Natural',
        'type' => 'Single Origin',
        'tasting_notes' => 'blueberry jam, lavender, wild strawberry, bergamot',
        'country' => 'Ethiopia',
        'region' => 'Sidama / Bensa',
        'producer' => 'Bombe Washing Station',
        'varieties' => '74112 & 74110',
        'elevation' => '2,050 MASL',
        'main_img' => 'wp-content/uploads/quills/ethiopia_bombe_main.jpg',
        'sec_img'  => 'wp-content/uploads/quills/ethiopia_bombe_label.png',
        'desc' => "Naturally processed heirloom cherries from the Bombe washing station nestled in the lush Bensa district. Incredibly vibrant tropical fruits, lush wild strawberry, and aromatic floral lavender notes.",
        'reviews' => [
            ['author' => 'Liam Chen', 'rating' => 5, 'title' => 'Blueberry bomb in a cup!', 'content' => 'Classic natural Ethiopian profile. Huge aroma the moment you grind the beans. Top tier pour over coffee.']
        ]
    ],
    [
        'title' => 'Southern Gothic | Cold Brew Blend',
        'slug'  => 'southern-gothic-cold-brew',
        'price' => '21.00',
        'roast' => 'Medium',
        'process' => 'Honey',
        'type' => 'Blend',
        'tasting_notes' => 'toffee, bourbon vanilla, blackberry, cocoa',
        'country' => 'Costa Rica & Guatemala',
        'region' => 'Tarrazu & Fraijanes',
        'producer' => 'Micromills',
        'varieties' => 'Catuai, Bourbon',
        'elevation' => '1,600 MASL',
        'main_img' => 'wp-content/uploads/quills/southern_gothic_main.jpg',
        'sec_img'  => 'wp-content/uploads/quills/blacksmith_back.jpg',
        'desc' => "Engineered specifically for full-immersion cold brewing. Extracts a sweet, syrupy body with no astringency and notes of chilled bourbon vanilla and dark berry.",
        'reviews' => [
            ['author' => 'Austin Cooper', 'rating' => 5, 'title' => 'Crisp and refreshing cold brew', 'content' => '16 hour brew in my Toddy system gave the smoothest cold brew I have ever had.']
        ]
    ],
    [
        'title' => 'Kenya | Embu AA',
        'slug'  => 'kenya-embu-aa',
        'price' => '25.00',
        'roast' => 'Light',
        'process' => 'Washed',
        'type' => 'Single Origin',
        'tasting_notes' => 'blackcurrant, grapefruit, brown sugar, tomato leaf',
        'country' => 'Kenya',
        'region' => 'Embu County, Mount Kenya',
        'producer' => 'Kibugu FCS',
        'varieties' => 'SL28, SL34, Ruiru 11',
        'elevation' => '1,800 MASL',
        'main_img' => 'wp-content/uploads/quills/kenya_embu_main.jpg',
        'sec_img'  => 'wp-content/uploads/quills/ethiopia_bombe_label.png',
        'desc' => "Grown on the rich red volcanic soils around Mount Kenya. High acidity, sparkling currant notes, and a complex savory sweetness.",
        'reviews' => [
            ['author' => 'Hannah Baker', 'rating' => 5, 'title' => 'Juicy and sparkling acidity', 'content' => 'Kenyan coffee lovers will adore this. Blackcurrant syrup sweetness with vibrant brightness.']
        ]
    ]
];

foreach ($products_data as $data) {
    // Check if product exists by slug
    $existing_id = wc_get_product_id_by_sku('QUILLS-' . strtoupper(str_replace('-', '', $data['slug'])));
    if (!$existing_id) {
        $p = get_page_by_path($data['slug'], OBJECT, 'product');
        if ($p) $existing_id = $p->ID;
    }
    
    $product = $existing_id ? wc_get_product($existing_id) : new WC_Product_Simple();
    $product->set_name($data['title']);
    $product->set_slug($data['slug']);
    $product->set_regular_price($data['price']);
    $product->set_sku('QUILLS-' . strtoupper(str_replace('-', '', $data['slug'])));
    $product->set_description($data['desc']);
    $product->set_short_description(ucwords($data['tasting_notes']) . ' • ' . $data['roast'] . ' Roast • ' . $data['process'] . ' Process');
    $product->set_status('publish');
    $product->set_manage_stock(false);
    $product->set_stock_status('instock');
    $product->set_reviews_allowed(true);
    
    // Images
    $main_img_id = import_quills_image($data['main_img'], $data['title'] . ' Front Bag');
    if ($main_img_id) {
        $product->set_image_id($main_img_id);
    }
    
    if (!empty($data['sec_img'])) {
        $sec_img_id = import_quills_image($data['sec_img'], $data['title'] . ' Details');
        if ($sec_img_id) {
            $product->set_gallery_image_ids([$sec_img_id]);
            update_post_meta($product->get_id() ?: 0, '_quills_secondary_image_id', $sec_img_id);
        }
    }
    
    $product_id = $product->save();
    
    // Store Quills Coffee custom metadata
    update_post_meta($product_id, '_quills_roast_profile', $data['roast']);
    update_post_meta($product_id, '_quills_process', $data['process']);
    update_post_meta($product_id, '_quills_coffee_type', $data['type']);
    update_post_meta($product_id, '_quills_tasting_notes', $data['tasting_notes']);
    update_post_meta($product_id, '_quills_country', $data['country']);
    update_post_meta($product_id, '_quills_region', $data['region']);
    update_post_meta($product_id, '_quills_producer', $data['producer']);
    update_post_meta($product_id, '_quills_varieties', $data['varieties']);
    update_post_meta($product_id, '_quills_elevation', $data['elevation']);
    
    echo "Created/Updated Product: {$data['title']} (ID: $product_id, Price: \${$data['price']})\n";
    
    // Seed reviews
    foreach ($data['reviews'] as $rev) {
        $existing_comment = get_comments([
            'post_id' => $product_id,
            'author_email' => sanitize_title($rev['author']) . '@example.com',
            'count' => true
        ]);
        if (!$existing_comment) {
            $commentdata = [
                'comment_post_ID'      => $product_id,
                'comment_author'       => $rev['author'],
                'comment_author_email' => sanitize_title($rev['author']) . '@example.com',
                'comment_author_url'   => '',
                'comment_content'      => "<strong>" . esc_html($rev['title']) . "</strong>\n\n" . esc_html($rev['content']),
                'comment_type'         => 'review',
                'comment_parent'       => 0,
                'user_id'              => 0,
                'comment_approved'     => 1,
            ];
            $comment_id = wp_insert_comment($commentdata);
            if ($comment_id) {
                update_comment_meta($comment_id, 'rating', $rev['rating']);
                update_comment_meta($comment_id, 'verified', 1);
                update_comment_meta($comment_id, '_quills_review_title', $rev['title']);
            }
        }
    }
}

echo "All Quills Coffee products and reviews seeded successfully!\n";
