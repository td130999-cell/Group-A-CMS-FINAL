<?php
/**
 * Title: Cafe Detail Subpage
 * Slug: coffee-cafe-corner/cafe-detail
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee authentic Cafe Detail subpage (e.g. ?view=nulu), dynamically pulling from Database.
 */

// 1. Resolve Target Page ID from Database
$page_id = get_the_ID();
if ( ! $page_id ) {
    $visit_page = get_page_by_path( 'visit', OBJECT, 'page' );
    if ( $visit_page ) {
        $page_id = $visit_page->ID;
    }
}

// 2. Resolve requested cafe view
$view = isset( $_GET['view'] ) ? sanitize_key( $_GET['view'] ) : '';

// Normalise aliases
$aliases = array(
    'j-town'        => 'jtown',
    'the-firehouse' => 'nulu',
    'firehouse'     => 'nulu',
    'frankfort'     => 'frankfort-avenue',
);
if ( isset( $aliases[ $view ] ) ) {
    $view = $aliases[ $view ];
}

// 3. Base Assets Path
$theme_url = trailingslashit( get_template_directory_uri() );
$img_dir   = $theme_url . 'assets/images/visit/';

// 4. Fetch Cafe Details from Database (wp_postmeta or wp_options)
$all_cafe_details = get_post_meta( $page_id, '_quills_cafe_details', true );
if ( empty( $all_cafe_details ) || ! is_array( $all_cafe_details ) ) {
    $all_cafe_details = get_option( 'quills_cafe_details', array() );
}

// Fallback data if database not yet initialized
if ( empty( $all_cafe_details ) || ! isset( $all_cafe_details[ $view ] ) ) {
    $defaults = array(
        'nulu' => array(
            'id'           => 'nulu',
            'title'        => 'NULU OR "THE FIREHOUSE"',
            'desc'         => "Our flagship cafe and headquarters. This is where our office is and where you'll find the Roastery barn. Our cafe resides in the historic firehouse station built in 1890. The lively din of downtown business folks fill the space in the mornings. Stroll through the open garage door at the back to enjoy the open air of our courtyard. A collection of picnic tables make it perfect for sitting outside enjoying coffees and treats with a group of friends. On any day of the week you'll likely smell the roasting of coffee in the air. Our Roastery barn sports a large window where you can watch our roasters work. Come on over and take a gander. They don't mind.",
            'image_main'   => 'nulu-main.jpg',
            'address'      => '802 E. Main St.',
            'map_url'      => 'https://www.google.com/maps/place/802+E+Main+St,+Louisville,+KY+40206',
            'hours'        => 'Mon-Fri: 6AM-7PM · Sat-Sun: 7AM-7PM',
            'phone'        => '(502) 861-5844',
            'gallery_1'    => 'nulu-gallery-1.jpg',
            'gallery_2'    => 'nulu-gallery-2.jpg',
            'gallery_3'    => 'nulu-gallery-3.jpg',
            'quote'        => 'One of my favorite coffee shops on planet earth (mind you, I\'ve been to many)! The Quills signature roast coffee, "Inkwell," is a personal favorite and is always available (though there\'s usually a second option as well). Quills Nulu is a great spot in which to read, study, or chat. Be sure to check out the back courtyard!',
            'quote_author' => '— Matthew B',
        ),
        'highlands' => array(
            'id'           => 'highlands',
            'title'        => 'HIGHLANDS',
            'desc'         => "Our second location located in the iconic Highlands neighborhood of Louisville. It's often considered the OG location by many customers. Nestled among a collection of eclectic shops, restaurants and bars, it may be the homiest of our cafes. Original hardwood floors, a wooden pew that lines the wall, and a side alley loved for years. The front window is a perfect place to sit and do some coding by the window.",
            'image_main'   => 'highlands-main.jpg',
            'address'      => '930 Baxter Avenue',
            'map_url'      => 'https://www.google.com/maps/place/930+Baxter+Ave,+Louisville,+KY+40204',
            'hours'        => 'Mon-Fri: 7AM-6PM · Sat-Sun: 7AM-7PM',
            'phone'        => '(502) 861-5844',
            'gallery_1'    => 'highlands-gallery-1.jpg',
            'gallery_2'    => 'highlands-gallery-2.jpg',
            'gallery_3'    => 'highlands-gallery-3.jpg',
            'quote'        => 'I love Quills on Baxter! They make my latte with perfect froth every time. We get our coffee beans from here too and they are always fresh and delicious. Atmosphere is comfortable with plenty of space to hang out. One of the best cafes in town!',
            'quote_author' => '— ES',
        ),
        'indianapolis' => array(
            'id'           => 'indianapolis',
            'title'        => 'INDIANAPOLIS',
            'desc'         => "Our only cafe outside of Kentucky. This satellite location is just steps from the heartbeat of downtown, our cafe on Meridian Street sits where commuters, creatives, and neighbors all cross paths. Equal parts historic charm and city grit, it's a place that's equally great for studying, reading, hanging out, or having your business meeting. We're happy to serve great coffee with our friends up in Indy.",
            'image_main'   => 'indianapolis-main.jpg',
            'address'      => '941 N. Meridian Street',
            'map_url'      => 'https://www.google.com/maps/place/941+N+Meridian+St,+Indianapolis,+IN+46204',
            'hours'        => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
            'phone'        => '(502) 861-5844',
            'gallery_1'    => 'indianapolis-gallery-1.jpg',
            'gallery_2'    => 'indianapolis-gallery-2.jpg',
            'gallery_3'    => 'indianapolis-gallery-3.jpg',
            'quote'        => 'One thing that\'s really important to me when it comes to coffee shops is consistency, and Quills hits the mark every time. Trust me when I say this is the BEST COFFEE IN INDY! My drink is always spot on, which is what keeps me a returning customer.',
            'quote_author' => '— Lauryn S.',
        ),
        'st-matthews' => array(
            'id'           => 'st-matthews',
            'title'        => 'ST. MATTHEWS',
            'desc'         => "Tucked away just off a busy intersection of Shelbyville Road, you might miss it when you're driving by. You'll find our St. Matthews cafe located on the first floor between Drakes and Green District Salads in a multi-use three story building. A soft cushion seat lines the wall for when you need to sit and focus for awhile. A garage door allows for a lovely breeze for three seasons. And bar seating where you can sit and work and chat with our baristas. A neighborhood place tucked into the everyday bustle.",
            'image_main'   => 'st-matthews-main.jpg',
            'address'      => '3939 Shelbyville Rd., Suite 105',
            'map_url'      => 'https://www.google.com/maps/place/3939+Shelbyville+Rd+Suite+105,+Louisville,+KY+40207',
            'hours'        => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
            'phone'        => '(502) 861-5844',
            'gallery_1'    => 'st-matthews-gallery-1.jpg',
            'gallery_2'    => 'st-matthews-gallery-2.jpg',
            'gallery_3'    => 'st-matthews-gallery-3.jpg',
            'quote'        => 'Third-wave coffee instead of the common dark and burnt flavors of diners or starbucks. The barista poured a nice rosetta, good foam quality on the cappuccino, and got the milk temperature just right so it was warm as can be without breaking down the milk\'s sweetness.',
            'quote_author' => '— Jake T.',
        ),
        'jtown' => array(
            'id'           => 'jtown',
            'title'        => 'J-TOWN',
            'desc'         => "We took over a bank. Well, at least the space. Our cafe in the Gaslight Square District of Louisville has huge ceilings and tons of natural light from the abundance of windows. The huge and hefty vault door (that still works) remains behind the bar and is a favorite sight among visitors. Sneak away to the upper loft to work or study for awhile. It's also a great place to perch and watch the baristas work below.",
            'image_main'   => 'jtown-main.jpg',
            'address'      => '10501 Watterson Trail',
            'map_url'      => 'https://www.google.com/maps/place/10501+Watterson+Trail,+Louisville,+KY+40299',
            'hours'        => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
            'phone'        => '(502) 861-5844',
            'gallery_1'    => 'jtown-gallery-1.jpg',
            'gallery_2'    => 'jtown-gallery-2.jpg',
            'gallery_3'    => 'jtown-gallery-3.jpg',
            'quote'        => 'Visited Quills Coffee in J-town with my coffee connoisseur father-in-law, and we both loved it! The vibe was relaxed and inviting, totally our style. I asked the barista for a recommendation and boy did she deliver! The drink was rich, smooth, and absolutely perfect. "Woodsman." You can tell they really care about their craft. Definitely a must-visit for coffee lovers!',
            'quote_author' => '— Laura W.',
        ),
        'norton-commons' => array(
            'id'           => 'norton-commons',
            'title'        => 'NORTON COMMONS',
            'desc'         => "Our newest cafe rests in the middle of an ever-growing walkable community in the Prospect area. A neighborhood defined by new urbanism and village-style, front-porch living. We're proud to be a part of over 70 independently-owned businesses here. Enjoy a coffee by the fountain just outside, or sit with us inside. This cafe is a gathering spot for neighbors and friends alike.",
            'image_main'   => 'norton-commons-main.jpg',
            'address'      => '11213 River Beauty Loop',
            'map_url'      => 'https://www.google.com/maps/place/11213+River+Beauty+Loop,+Prospect,+KY+40059',
            'hours'        => 'Mon-Fri: 6AM-6PM · Sat-Sun: 7AM-7PM',
            'phone'        => '(502) 861-5844',
            'gallery_1'    => 'norton-commons-gallery-1.jpg',
            'gallery_2'    => 'norton-commons-gallery-2.jpg',
            'gallery_3'    => 'norton-commons-gallery-3.jpg',
            'quote'        => 'I love Quills for the drinks but the barista\'s kindness is truly next level. My children ask them five hundred questions and every single barista at the Norton Commons location has answered every single one of them and gone as far as to walk them through step-by-step how they make the coffee and I\'m just so impressed.',
            'quote_author' => '— Whitley G.',
        ),
        'frankfort-avenue' => array(
            'id'           => 'frankfort-avenue',
            'title'        => 'FRANKFORT AVENUE',
            'desc'         => "Bookstores, galleries, tree-lined sidewalks. We're happy to be a part of a neighborhood with such old charm. The Frankfort Avenue we share sports hole-in-the-wall gems and fine dining staples. You'll hear the espresso machine running just as often as you hear the train going by. Plop down on the couch or head out back to our patio. Any spot is a good spot here.",
            'image_main'   => 'frankfort-avenue-main.jpg',
            'address'      => '2001 Frankfort Avenue',
            'map_url'      => 'https://www.google.com/maps/place/2001+Frankfort+Ave,+Louisville,+KY+40206',
            'hours'        => 'Mon-Fri: 7AM-7PM · Sat-Sun: 7AM-7PM',
            'phone'        => '(502) 861-5844',
            'gallery_1'    => 'frankfort-avenue-gallery-1.jpg',
            'gallery_2'    => 'frankfort-avenue-gallery-2.jpg',
            'gallery_3'    => 'frankfort-avenue-gallery-3.jpg',
            'quote'        => 'This cafe has been open less than a week and has already easily become my favorite in the \'Ville. It has the same unsurpassed exceptional coffee and friendly service we\'ve come to expect from every Quills, while being situated in a beautiful, recently-renovated older building. A bonus feature of this location is a large back patio area. This will be the perfect "third place" for many to hang out, have a coffee, chat, or finish up a little work. It will be my go-to for sure.',
            'quote_author' => '— Jacob D.',
        ),
    );
    $cafe = isset( $defaults[ $view ] ) ? $defaults[ $view ] : reset( $defaults );
} else {
    $cafe = $all_cafe_details[ $view ];
}

// Image URLs
$main_img_url = filter_var( $cafe['image_main'], FILTER_VALIDATE_URL ) ? $cafe['image_main'] : $img_dir . $cafe['image_main'];
$g1_url       = filter_var( $cafe['gallery_1'], FILTER_VALIDATE_URL ) ? $cafe['gallery_1'] : $img_dir . $cafe['gallery_1'];
$g2_url       = filter_var( $cafe['gallery_2'], FILTER_VALIDATE_URL ) ? $cafe['gallery_2'] : $img_dir . $cafe['gallery_2'];
$g3_url       = filter_var( $cafe['gallery_3'], FILTER_VALIDATE_URL ) ? $cafe['gallery_3'] : $img_dir . $cafe['gallery_3'];
?>

<div class="quills-cafe-subpage-container">

    <!-- Cafe Title & Narrative Intro -->
    <header class="quills-subpage-header">
        <h1 class="quills-subpage-title"><?php echo esc_html( $cafe['title'] ); ?></h1>
        <div class="quills-subpage-desc">
            <p><?php echo esc_html( $cafe['desc'] ); ?></p>
        </div>
    </header>

    <!-- Main Location Section: Left Building Photo, Right Address Details -->
    <section class="quills-subpage-main-section">
        <div class="quills-subpage-main-grid">
            <div class="quills-subpage-main-image-wrap">
                <img src="<?php echo esc_url( $main_img_url ); ?>" alt="<?php echo esc_attr( $cafe['title'] ); ?>" class="quills-subpage-main-img" loading="lazy" />
            </div>
            <div class="quills-subpage-details-col">
                <div class="quills-subpage-info-item">
                    <span class="quills-subpage-label">Address:</span>
                    <a href="<?php echo esc_url( $cafe['map_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="quills-subpage-link">
                        <?php echo esc_html( $cafe['address'] ); ?>
                    </a>
                </div>
                <div class="quills-subpage-info-item">
                    <span class="quills-subpage-label">Hours:</span>
                    <span class="quills-subpage-val"><?php echo esc_html( $cafe['hours'] ); ?></span>
                </div>
                <div class="quills-subpage-info-item">
                    <span class="quills-subpage-label">Phone:</span>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $cafe['phone'] ) ); ?>" class="quills-subpage-link">
                        <?php echo esc_html( $cafe['phone'] ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Cafe Gallery: Left Large Photo, Right Stacked Photos -->
    <section class="quills-subpage-gallery-section">
        <div class="quills-subpage-gallery-grid">
            <div class="quills-subpage-gallery-left">
                <img src="<?php echo esc_url( $g1_url ); ?>" alt="<?php echo esc_attr( $cafe['title'] . ' Interior' ); ?>" class="quills-subpage-gallery-img" loading="lazy" />
            </div>
            <div class="quills-subpage-gallery-right">
                <div class="quills-subpage-gallery-right-item">
                    <img src="<?php echo esc_url( $g2_url ); ?>" alt="<?php echo esc_attr( $cafe['title'] . ' Photo 2' ); ?>" class="quills-subpage-gallery-img" loading="lazy" />
                </div>
                <div class="quills-subpage-gallery-right-item">
                    <img src="<?php echo esc_url( $g3_url ); ?>" alt="<?php echo esc_attr( $cafe['title'] . ' Photo 3' ); ?>" class="quills-subpage-gallery-img" loading="lazy" />
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="quills-subpage-testimonial-section">
        <h2 class="quills-subpage-testimonial-heading">Testimonial</h2>
        <div class="quills-subpage-stars" aria-label="5 stars rating">
            <span class="quills-star">★</span>
            <span class="quills-star">★</span>
            <span class="quills-star">★</span>
            <span class="quills-star">★</span>
            <span class="quills-star">★</span>
        </div>
        <blockquote class="quills-subpage-quote">
            <p>“<?php echo esc_html( $cafe['quote'] ); ?>”</p>
        </blockquote>
        <div class="quills-subpage-author">
            <?php echo esc_html( $cafe['quote_author'] ); ?>
        </div>
    </section>

</div>
