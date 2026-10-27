<?php
/**
 * Title: Home Quills
 * Slug: coffee-cafe-corner/home-quills
 * Categories: featured
 * Block Types: core/post-content
 */

$theme_uri = trailingslashit( get_template_directory_uri() );
$img_dir   = $theme_uri . 'assets/images/home/';

// Image resolver helper
$get_home_img = function( $val, $default_file ) use ( $img_dir ) {
	if ( empty( $val ) ) {
		return $img_dir . $default_file;
	}
	if ( strpos( $val, 'http://' ) === 0 || strpos( $val, 'https://' ) === 0 || strpos( $val, '//' ) === 0 ) {
		return $val;
	}
	return $img_dir . ltrim( $val, '/' );
};

// 1. Fetch Home Page Dynamic Settings from Database (wp_options)
// Section 1: Hero Banner
$hero_img          = $get_home_img( get_option( 'quills_home_hero_img' ), 'home.webp' );
$hero_title        = get_option( 'quills_home_hero_title', "We find them, we roast them, you<br>just enjoy them." );
$hero_subtitle     = get_option( 'quills_home_hero_subtitle', "Get new delicious coffees that you and your guests will love, delivered<br>to your door on your schedule." );
$hero_cta_text     = get_option( 'quills_home_hero_cta_text', "START YOUR SUBSCRIPTION" );
$hero_cta_link     = get_option( 'quills_home_hero_cta_link', home_url( '/subscriptions/' ) );
$hero_stars_img    = $get_home_img( get_option( 'quills_home_hero_stars_img' ), 'hero-stars.png' );
$hero_rating       = get_option( 'quills_home_rating_text', "4.62 stars across 13,082 reviews" );
$hero_press_label  = get_option( 'quills_home_press_label', "Featured in" );
$press_logo_1      = $get_home_img( get_option( 'quills_home_press_logo_1' ), 'logo-garden-and-gun.png' );
$press_logo_2      = $get_home_img( get_option( 'quills_home_press_logo_2' ), 'logo-cosmopolitan.png' );
$press_logo_3      = $get_home_img( get_option( 'quills_home_press_logo_3' ), 'logo-food-and-wine.png' );
$press_logo_4      = $get_home_img( get_option( 'quills_home_press_logo_4' ), 'logo-courier-journal.png' );
$hero_quote        = get_option( 'quills_home_hero_quote', "“I’ve searched far and wide and this is the place to get your cup or bag of greatness if you happen to be a true coffee aficionado.” — Jacob Y." );

// Section 2: Team (NO ROBOTS. JUST PEOPLE.)
$team_img      = $get_home_img( get_option( 'quills_home_team_img' ), 'team-nathan.jpg' );
$team_title    = get_option( 'quills_home_team_title', "NO ROBOTS. JUST PEOPLE." );
$team_p1       = get_option( 'quills_home_team_p1', "You should know who's choosing and roasting your coffee. No algorithms here." );
$team_p2       = get_option( 'quills_home_team_p2', "It’s a small group of real people in the heart of Louisville, Kentucky who love finding and making great coffee and care about sharing it with you." );
$team_p3       = get_option( 'quills_home_team_p3', "It’s our founder, Nathan, four operations team members, five roasters, four cafe managers, and 42 baristas." );
$team_p4       = get_option( 'quills_home_team_p4', "Some of us have worked in coffee for years. Others discovered their passion more recently. What we all have in common is this belief that coffee should bring people together." );
$team_p5       = get_option( 'quills_home_team_p5', "We’re doing our best to deliver coffee that connects people." );
$team_cta_text = get_option( 'quills_home_team_cta_text', "SHOW ME THE COFFEE" );
$team_cta_link = get_option( 'quills_home_team_cta_link', home_url( '/coffee/' ) );
$team_quote    = get_option( 'quills_home_team_quote', "“The best tasting pour over coffee on this planet.” — Kelsey B." );

// Section 3: Features Banner (Subscriptions)
$feat_title        = get_option( 'quills_home_feat_title', "Coffee subscriptions. Change, pause, or cancel anytime." );
$feat_icon_1       = $get_home_img( get_option( 'quills_home_feat_icon_1' ), 'icon-coffee-bag.png' );
$feat_step1_title  = get_option( 'quills_home_feat_step1_title', "1. PICK YOUR SUBSCRIPTION" );
$feat_step1_desc   = get_option( 'quills_home_feat_step1_desc', "Want a favorite on repeat or something new every month? Maybe a mixed bundle? Pick what you like or let us curate your morning for you." );
$feat_icon_2       = $get_home_img( get_option( 'quills_home_feat_icon_2' ), 'icon-calendar.png' );
$feat_step2_title  = get_option( 'quills_home_feat_step2_title', "2. PICK HOW OFTEN" );
$feat_step2_desc   = get_option( 'quills_home_feat_step2_desc', "Every week? Every 2 weeks? How fast are you downing it? If you're not sure, we'll help you get a close guess. You can always change it later." );
$feat_icon_3       = $get_home_img( get_option( 'quills_home_feat_icon_3' ), 'icon-fingerprint-cup.png' );
$feat_step3_title  = get_option( 'quills_home_feat_step3_title', "3. ENJOY IT FROM NOW ON" );
$feat_step3_desc   = get_option( 'quills_home_feat_step3_desc', "Start peeping out the window. We roast 4 days a week. You'll have a fresh new bag of coffee showing up just as you finish the last one." );
$feat_cta_text     = get_option( 'quills_home_feat_cta_text', "FIND THE SUBSCRIPTION FOR YOU" );
$feat_cta_link     = get_option( 'quills_home_feat_cta_link', home_url( '/subscriptions/' ) );
$feat_quote        = get_option( 'quills_home_feat_quote', "“The coffee is absolutely fabulous.”<br>— Athena S." );

// Section 4: Roasting
$roast_img      = $get_home_img( get_option( 'quills_home_roast_img' ), 'roaster-justin.jpg' );
$roast_title    = get_option( 'quills_home_roast_title', "ROASTED LOCALLY BY US" );
$roast_p1       = get_option( 'quills_home_roast_p1', "We roast all of our coffee ourselves, right here on Main Street in Louisville, Kentucky." );
$roast_p2       = get_option( 'quills_home_roast_p2', "Our roasters arrive before dawn, when it’s still cool and quiet. They know the difference between a good cup of coffee and an exceptional one lives in hundreds of small decisions." );
$roast_p3       = get_option( 'quills_home_roast_p3', "Roasting in small 45-pound batches by hand means each batch gets the kind of attention that big commercial coffee companies simply can't afford to give." );
$roast_p4       = get_option( 'quills_home_roast_p4', "Justin, our head roaster, and his team of four are paying attention to the temperature, airflow, and the smell." );
$roast_p5       = get_option( 'quills_home_roast_p5', "They’re listening for a distinctive “crack” of the beans that tells them right when to stop to lock in the best flavors for your coffee." );
$roast_cta_text = get_option( 'quills_home_roast_cta_text', "SEARCH BY ROAST" );
$roast_cta_link = get_option( 'quills_home_roast_cta_link', home_url( '/coffee/' ) );
$roast_quote    = get_option( 'quills_home_roast_quote', "“One of the best coffee roasters in the country and beautiful shops. Worth a visit.”— Crema Guru" );

// Section 5: Sourcing
$source_img      = $get_home_img( get_option( 'quills_home_source_img' ), 'sourcing-farm.jpg' );
$source_title    = get_option( 'quills_home_source_title', "HAND-PICKED BY FARMERS, HAND SELECTED BY US" );
$source_p1       = get_option( 'quills_home_source_p1', "Over 11 million tons of coffee is grown every year across the world. Less than 15% of that meets premium specialty grade coffee standards. A fancy way of saying the best of the best. (And the only kind we buy.)" );
$source_p2       = get_option( 'quills_home_source_p2', "From that rare tier of 15%, we source and sample over 100 exceptional coffees every year." );
$source_p3       = get_option( 'quills_home_source_p3', "And from those 100, we pick around 20 of the best to serve and ship to our customers." );
$source_p4       = get_option( 'quills_home_source_p4', "It's like having your own personal coffee sommelier." );
$source_p5       = get_option( 'quills_home_source_p5', "We do all this so you can enjoy exceptional coffee every single day." );
$source_cta_text = get_option( 'quills_home_source_cta_text', "SEE WHAT WE FOUND FOR YOU" );
$source_cta_link = get_option( 'quills_home_source_cta_link', home_url( '/coffee/' ) );
$source_quote    = get_option( 'quills_home_source_quote', "“Excellent coffee and excellent sourcing. A place that loves wonderful coffees, the best the world has to offer.”<br>— Preston S." );

// Section 6: Circular Badge
$badge_img = $get_home_img( get_option( 'quills_home_badge_img' ), 'badge-coffee-connect-people.png' );

// Section 7: Bestsellers Header
$bestsellers_title    = get_option( 'quills_home_bestsellers_title', "Our Bestsellers" );
$bestsellers_subtitle = get_option( 'quills_home_bestsellers_subtitle', "The ones people keep coming back for." );

// Section 8: Cupping
$cupping_img      = $get_home_img( get_option( 'quills_home_cupping_img' ), 'cupping-tasting.jpg' );
$cupping_title    = get_option( 'quills_home_cupping_title', "TASTE-TESTED TWICE A WEEK" );
$cupping_p1       = get_option( 'quills_home_cupping_p1', "Every coffee gets tested, tweaked, and perfected every week until we run out of it." );
$cupping_p2       = get_option( 'quills_home_cupping_p2', "When we find something wrong — and we do — we dump the whole batch and start over." );
$cupping_p3       = get_option( 'quills_home_cupping_p3', "We do this to make sure you get the absolute best flavors and aromas from every coffee you get from us." );
$cupping_cta_text = get_option( 'quills_home_cupping_cta_text', "SHOW ME THE COFFEE" );
$cupping_cta_link = get_option( 'quills_home_cupping_cta_link', home_url( '/coffee/' ) );
$cupping_quote    = get_option( 'quills_home_cupping_quote', "“If you love regular ol coffee but not the regular ol taste - you will love Quills!”<br>— Amie M" );

// Section 9: FAQ Accordion
$faq_title = get_option( 'quills_home_faq_title', "FAQ" );
$faq_q1    = get_option( 'quills_home_faq_q1', "How fresh is the coffee I get?" );
$faq_a1    = get_option( 'quills_home_faq_a1', "All coffee is roasted to order. Our small roastery team of four guys roasts 4 days a week.\n\nWe ship coffee orders at peak freshness, after an initial resting period to degas. This way you receive your order as it's beginning to approach peak freshness, so you can get the best flavors from every bag of coffee you receive." );
$faq_q2    = get_option( 'quills_home_faq_q2', "When will my coffee ship?" );
$faq_a2    = get_option( 'quills_home_faq_a2', "If you order by midnight Sunday, your order will ship on Wednesday.\n\nIf you order by midnight Tuesday, your order will ship on Friday." );
$faq_q3    = get_option( 'quills_home_faq_q3', "I’d like to work at Quills. How do I apply?" );
$faq_a3    = get_option( 'quills_home_faq_a3', "We hire baristas often! You can <a href=\"https://form.jotform.com/quillscoffee/new-customer-registration-form\" target=\"_blank\" rel=\"noopener noreferrer\">apply here.</a>" );
$faq_q4    = get_option( 'quills_home_faq_q4', "My question is about something else" );
$faq_a4    = get_option( 'quills_home_faq_a4', "Go ahead and reach out to <a href=\"mailto:hello@quillscoffee.com\">hello@quillscoffee.com</a>. You're gonna talk to one of us, not a bot." );

// Section 10: The Hoot (Newsletter)
$hoot_heading   = get_option( 'quills_home_hoot_heading', "THE HOOT" );
$hoot_icon      = $get_home_img( get_option( 'quills_home_hoot_icon' ), 'hoot-icon.png' );
$hoot_p1        = get_option( 'quills_home_hoot_p1', "The Hoot is one short email from us sent every Friday morning. It takes about 5 minutes to read. It’s less of a 'newsletter' and more like an actual letter." );
$hoot_p2        = get_option( 'quills_home_hoot_p2', "We sometimes send readers links to secret coffees and exclusive reader-only merch." );
$hoot_highlight = get_option( 'quills_home_hoot_highlight', "8,212 kind folks" );
$hoot_p3        = get_option( 'quills_home_hoot_p3', "currently get it sent to their inbox." );
$hoot_p4        = get_option( 'quills_home_hoot_p4', "We share what the people behind your coffee have been up to that week. You may hear about some wild coffee our head roaster Justin has tasted. Or behind-the-scenes on the new seasonal drinks our beverage director Jess is whipping up." );
$hoot_p5        = get_option( 'quills_home_hoot_p5', "And we always add a little something fun in the PS." );
$hoot_cf7_id    = get_option( 'quills_home_hoot_cf7_id', "141" );
$hoot_btn_text  = get_option( 'quills_home_hoot_btn_text', "TRY IT" );

$allowed_tags = array( 'br' => array(), 'strong' => array(), 'em' => array() );
?>

<div class="quills-home-wrapper alignfull">

  <!-- ========================================================
       SECTION 1: HERO BANNER (KETTLE POUR REFERENCE)
       ======================================================== -->
  <section class="quills-hero-section">
    <div class="quills-hero-bg">
      <img src="<?php echo esc_url( $hero_img ); ?>" alt="Quills Coffee Barista Pour Over" class="quills-hero-img" />
    </div>
    <div class="quills-hero-content-wrapper">
      <div class="quills-hero-content">
        <h1 class="quills-hero-title">
          <?php echo wp_kses( $hero_title, $allowed_tags ); ?>
        </h1>
        <p class="quills-hero-subtitle">
          <?php echo wp_kses( $hero_subtitle, $allowed_tags ); ?>
        </p>
        <div class="quills-hero-cta">
          <a href="<?php echo esc_url( $hero_cta_link ); ?>" class="quills-btn quills-btn--hero" aria-label="<?php echo esc_attr( $hero_cta_text ); ?>">
            <?php echo esc_html( $hero_cta_text ); ?>
          </a>
        </div>
        <div class="quills-hero-reviews">
          <div class="quills-hero-stars-wrap">
            <img src="<?php echo esc_url( $hero_stars_img ); ?>" alt="5 Stars" class="quills-hero-stars-img" width="135" height="25" />
          </div>
          <p class="quills-rating-text"><?php echo esc_html( $hero_rating ); ?></p>
          <p class="quills-featured-label"><strong><?php echo esc_html( $hero_press_label ); ?></strong></p>
          <div class="quills-press-logos">
            <img src="<?php echo esc_url( $press_logo_1 ); ?>" alt="Garden &amp; Gun" class="quills-press-logo quills-press-garden" />
            <img src="<?php echo esc_url( $press_logo_2 ); ?>" alt="Cosmopolitan" class="quills-press-logo quills-press-cosmo" />
            <img src="<?php echo esc_url( $press_logo_3 ); ?>" alt="Food &amp; Wine" class="quills-press-logo quills-press-foodwine" />
            <img src="<?php echo esc_url( $press_logo_4 ); ?>" alt="Courier Journal" class="quills-press-logo quills-press-courier" />
          </div>
        </div>
        <div class="quills-hero-quote">
          <p><em><?php echo wp_kses( $hero_quote, $allowed_tags ); ?></em></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================
       SECTION 2: 50/50 - NO ROBOTS. JUST PEOPLE. (TEAM)
       ======================================================== -->
  <section class="quills-split-section quills-section-team">
    <div class="quills-container">
      <div class="quills-split-row">
        <div class="quills-split-media">
          <img src="<?php echo esc_url( $team_img ); ?>" alt="Quills Coffee Team" class="quills-split-img" loading="lazy" />
        </div>
        <div class="quills-split-content">
          <h2 class="quills-section-title"><?php echo esc_html( $team_title ); ?></h2>
          <div class="quills-text-body">
            <p><?php echo wp_kses( $team_p1, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $team_p2, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $team_p3, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $team_p4, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $team_p5, $allowed_tags ); ?></p>
          </div>
          <div class="quills-split-cta">
            <a href="<?php echo esc_url( $team_cta_link ); ?>" class="quills-btn quills-btn--orange" aria-label="<?php echo esc_attr( $team_cta_text ); ?>">
              <?php echo esc_html( $team_cta_text ); ?>
            </a>
          </div>
          <div class="quills-split-quote">
            <p><?php echo wp_kses( $team_quote, $allowed_tags ); ?></p>
          </div>
        </div>
      </div>
      <hr class="quills-section-divider" />
    </div>
  </section>

  <!-- ========================================================
       SECTION 3: 3-COLUMN FEATURES BANNER (SUBSCRIPTION)
       ======================================================== -->
  <section class="quills-features-section">
    <div class="quills-container">
      <div class="quills-features-headline">
        <h2 class="quills-features-main-title"><?php echo esc_html( $feat_title ); ?></h2>
      </div>
      <div class="quills-features-grid">
        <div class="quills-feature-item">
          <div class="quills-feature-icon-wrap">
            <img src="<?php echo esc_url( $feat_icon_1 ); ?>" alt="<?php echo esc_attr( $feat_step1_title ); ?>" class="quills-feature-icon" loading="lazy" />
          </div>
          <h3 class="quills-feature-title"><?php echo esc_html( $feat_step1_title ); ?></h3>
          <p class="quills-feature-desc"><?php echo wp_kses( $feat_step1_desc, $allowed_tags ); ?></p>
        </div>
        <div class="quills-feature-item">
          <div class="quills-feature-icon-wrap">
            <img src="<?php echo esc_url( $feat_icon_2 ); ?>" alt="<?php echo esc_attr( $feat_step2_title ); ?>" class="quills-feature-icon" loading="lazy" />
          </div>
          <h3 class="quills-feature-title"><?php echo esc_html( $feat_step2_title ); ?></h3>
          <p class="quills-feature-desc"><?php echo wp_kses( $feat_step2_desc, $allowed_tags ); ?></p>
        </div>
        <div class="quills-feature-item">
          <div class="quills-feature-icon-wrap">
            <img src="<?php echo esc_url( $feat_icon_3 ); ?>" alt="<?php echo esc_attr( $feat_step3_title ); ?>" class="quills-feature-icon" loading="lazy" />
          </div>
          <h3 class="quills-feature-title"><?php echo esc_html( $feat_step3_title ); ?></h3>
          <p class="quills-feature-desc"><?php echo wp_kses( $feat_step3_desc, $allowed_tags ); ?></p>
        </div>
      </div>
      <div class="quills-features-cta-wrap">
        <a href="<?php echo esc_url( $feat_cta_link ); ?>" class="quills-btn quills-btn--orange" aria-label="<?php echo esc_attr( $feat_cta_text ); ?>">
          <?php echo esc_html( $feat_cta_text ); ?>
        </a>
        <div class="quills-features-quote">
          <p><?php echo wp_kses( $feat_quote, $allowed_tags ); ?></p>
        </div>
      </div>
      <hr class="quills-section-divider" />
    </div>
  </section>

  <!-- ========================================================
       SECTION 4: 50/50 - ROASTED LOCALLY BY US (IMAGE ON LEFT)
       ======================================================== -->
  <section class="quills-split-section quills-section-roasting">
    <div class="quills-container">
      <div class="quills-split-row">
        <div class="quills-split-media">
          <img src="<?php echo esc_url( $roast_img ); ?>" alt="Justin Roasting Coffee at Quills" class="quills-split-img" loading="lazy" />
        </div>
        <div class="quills-split-content">
          <h2 class="quills-section-title"><?php echo esc_html( $roast_title ); ?></h2>
          <div class="quills-text-body">
            <p><?php echo wp_kses( $roast_p1, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $roast_p2, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $roast_p3, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $roast_p4, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $roast_p5, $allowed_tags ); ?></p>
          </div>
          <div class="quills-split-cta">
            <a href="<?php echo esc_url( $roast_cta_link ); ?>" class="quills-btn quills-btn--orange" aria-label="<?php echo esc_attr( $roast_cta_text ); ?>">
              <?php echo esc_html( $roast_cta_text ); ?>
            </a>
          </div>
          <div class="quills-split-quote">
            <p><?php echo wp_kses( $roast_quote, $allowed_tags ); ?></p>
          </div>
        </div>
      </div>
      <hr class="quills-section-divider" />
    </div>
  </section>

  <!-- ========================================================
       SECTION 5: 50/50 - HAND-PICKED BY FARMERS (SOURCING)
       ======================================================== -->
  <section class="quills-split-section quills-section-sourcing">
    <div class="quills-container">
      <div class="quills-split-row quills-split-row--reverse">
        <div class="quills-split-media">
          <img src="<?php echo esc_url( $source_img ); ?>" alt="Farmers Hand-picking Coffee" class="quills-split-img" loading="lazy" />
        </div>
        <div class="quills-split-content">
          <h2 class="quills-section-title"><?php echo esc_html( $source_title ); ?></h2>
          <div class="quills-text-body">
            <p><?php echo wp_kses( $source_p1, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $source_p2, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $source_p3, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $source_p4, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $source_p5, $allowed_tags ); ?></p>
          </div>
          <div class="quills-split-cta">
            <a href="<?php echo esc_url( $source_cta_link ); ?>" class="quills-btn quills-btn--orange" aria-label="<?php echo esc_attr( $source_cta_text ); ?>">
              <?php echo esc_html( $source_cta_text ); ?>
            </a>
          </div>
          <div class="quills-split-quote">
            <p><?php echo wp_kses( $source_quote, $allowed_tags ); ?></p>
          </div>
        </div>
      </div>
      <hr class="quills-section-divider" />
    </div>
  </section>

  <!-- ========================================================
       SECTION 6: CIRCULAR BADGE - COFFEE CONNECT PEOPLE
       ======================================================== -->
  <section class="quills-badge-section">
    <div class="quills-container quills-container--center">
      <div class="quills-badge-wrap">
        <img src="<?php echo esc_url( $badge_img ); ?>" alt="Quills Coffee Connect People Badge" class="quills-badge-img" loading="lazy" />
      </div>
    </div>
  </section>

  <!-- ========================================================
       SECTION 7: OUR BESTSELLERS (3 PRODUCTS)
       ======================================================== -->
  <section class="quills-bestsellers-section">
    <div class="quills-container">
      <div class="quills-bestsellers-header">
        <h2 class="quills-section-title quills-section-title--center"><?php echo esc_html( $bestsellers_title ); ?></h2>
        <p class="quills-section-subtitle"><?php echo esc_html( $bestsellers_subtitle ); ?></p>
      </div>

      <div class="quills-products-grid">
        <?php
        $bestsellers = class_exists( 'Coffee_Cafe_Corner_Quills_Products_DB' )
          ? Coffee_Cafe_Corner_Quills_Products_DB::get_home_bestsellers()
          : array();

        if ( ! empty( $bestsellers ) ) :
          foreach ( $bestsellers as $bestseller ) :
            $p_id       = $bestseller->get_id();
            $p_name     = $bestseller->get_name();
            $p_link     = get_permalink( $p_id );
            $p_price    = $bestseller->get_price();
            $p_rating   = $bestseller->get_average_rating();
            $p_reviews  = $bestseller->get_review_count();

            $slug = $bestseller->get_slug();

            // 1. Featured image from database (wp-admin edits take priority)
            $image_id      = $bestseller->get_image_id();
            $front_img_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';
            if ( ! $front_img_url ) {
              if ( strpos( $slug, 'blacksmith' ) !== false ) {
                $front_img_url = $img_dir . 'product-blacksmith-front.jpg';
              } elseif ( strpos( $slug, 'inkwell' ) !== false ) {
                $front_img_url = $img_dir . 'product-inkwell-front.jpg';
              } elseif ( strpos( $slug, 'southern' ) !== false ) {
                $front_img_url = $img_dir . 'product-southern-gothic-front.jpg';
              } else {
                $front_img_url = $img_dir . 'product-blacksmith-front.jpg';
              }
            }

            // 2. Tag / Title
            $tag = get_post_meta( $p_id, '_quills_tag', true );
            if ( empty( $tag ) ) {
              if ( strpos( $slug, 'blacksmith' ) !== false ) {
                $tag = 'BLACKSMITH';
              } elseif ( strpos( $slug, 'inkwell' ) !== false ) {
                $tag = 'INKWELL';
              } elseif ( strpos( $slug, 'southern' ) !== false ) {
                $tag = 'SOUTHERN GOTHIC';
              } else {
                $tag = strtoupper( $p_name );
              }
            }

            // 3. Tag Color
            $tag_color = get_post_meta( $p_id, '_quills_tag_color', true );
            if ( empty( $tag_color ) ) {
              if ( strpos( $slug, 'blacksmith' ) !== false ) {
                $tag_color = '#1c1d1d';
              } elseif ( strpos( $slug, 'inkwell' ) !== false ) {
                $tag_color = '#EB5A3C';
              } elseif ( strpos( $slug, 'southern' ) !== false ) {
                $tag_color = '#8C6FA9';
              } else {
                $tag_color = '#1c1d1d';
              }
            }

            // 4. Tag Description (Database first)
            $tag_desc = get_post_meta( $p_id, '_quills_tag_desc', true );
            if ( empty( $tag_desc ) ) {
              if ( strpos( $slug, 'blacksmith' ) !== false ) {
                $tag_desc = 'The F1 car of our lineup. Our signature espresso that folks enjoy in every latte, cappuccino, and cortado in our cafés.';
              } elseif ( strpos( $slug, 'inkwell' ) !== false ) {
                $tag_desc = "The daily driver. Our classic house blend that's on drip at our cafes from open to close. Loved by regulars for 17 years.";
              } elseif ( strpos( $slug, 'southern' ) !== false ) {
                $tag_desc = 'Our cold brew blend crafted for our customers who prefer their coffee chilled.';
              } else {
                $tag_desc = $bestseller->get_short_description();
              }
            }

            // 5. Tasting Notes
            $tasting = get_post_meta( $p_id, '_coffee_tasting_notes', true ) ?: ( get_post_meta( $p_id, '_quills_tasting_notes', true ) ?: get_post_meta( $p_id, '_quills_tasting', true ) );
            if ( empty( $tasting ) ) {
              if ( strpos( $slug, 'blacksmith' ) !== false ) {
                $tasting = "Baker's chocolate, blueberries, hazelnut";
              } elseif ( strpos( $slug, 'inkwell' ) !== false ) {
                $tasting = 'honey, chocolate, clementine';
              } elseif ( strpos( $slug, 'southern' ) !== false ) {
                $tasting = 'Milk chocolate, brown sugar, orange';
              }
            }

            // 6. Details (Process & Origins)
            $db_proc = get_post_meta( $p_id, '_coffee_process', true ) ?: get_post_meta( $p_id, '_quills_process', true );
            $db_orig = get_post_meta( $p_id, '_coffee_origins', true ) ?: get_post_meta( $p_id, '_quills_country', true );
            if ( ! empty( $db_proc ) || ! empty( $db_orig ) ) {
              $details = '';
              if ( $db_proc ) $details .= 'Process: ' . $db_proc;
              if ( $db_orig ) $details .= ($details ? "\n" : '') . 'Origins: ' . $db_orig;
            } else {
              $details = get_post_meta( $p_id, '_quills_details', true );
              if ( empty( $details ) ) {
                if ( strpos( $slug, 'blacksmith' ) !== false ) {
                  $details = "Process: Washed & Natural\nOrigins: Colombia, Nicaragua, Ethiopia";
                } elseif ( strpos( $slug, 'inkwell' ) !== false ) {
                  $details = "Process: Washed & Natural\nOrigins: Colombia, Guatemala, Ethiopia";
                } elseif ( strpos( $slug, 'southern' ) !== false ) {
                  $details = "Process: Washed & Natural\nOrigins: Central & South America";
                }
              }
            }

            // 7. Reviews
            if ( empty( $p_reviews ) ) {
              if ( strpos( $slug, 'blacksmith' ) !== false ) { $p_reviews = 53; }
              elseif ( strpos( $slug, 'inkwell' ) !== false ) { $p_reviews = 80; }
              elseif ( strpos( $slug, 'southern' ) !== false ) { $p_reviews = 21; }
            }

            $back_img_url = $img_dir . 'product-bag-back.jpg';
        ?>
          <div class="quills-product-card" data-product-id="<?php echo esc_attr( $p_id ); ?>">
            <div class="quills-product-meta-header">
              <h2 class="quills-product-tag" style="color: <?php echo esc_attr( $tag_color ); ?>;"><?php echo esc_html( $tag ); ?></h2>
              <p class="quills-product-tag-desc"><?php echo esc_html( $tag_desc ); ?></p>
            </div>
            <div class="quills-product-image-box">
              <a href="<?php echo esc_url( $p_link ); ?>" class="quills-product-link">
                <div class="quills-product-images-wrap">
                  <img src="<?php echo esc_url( $front_img_url ); ?>" alt="<?php echo esc_attr( $p_name ); ?> Front" class="quills-img-front" loading="lazy" />
                  <img src="<?php echo esc_url( $back_img_url ); ?>" alt="<?php echo esc_attr( $p_name ); ?> Back" class="quills-img-back" loading="lazy" />
                </div>
                <div class="quills-rollover-overlay">
                  <div class="quills-rollover-content">
                    <h4 class="quills-rollover-title"><?php echo esc_html( $p_name ); ?></h4>
                    <div class="quills-rollover-text">
                      <?php if ( ! empty( $tasting ) ) : ?>
                        <p class="quills-rollover-tasting"><em><strong><?php echo esc_html( $tasting ); ?></strong></em></p>
                      <?php endif; ?>
                      <?php if ( ! empty( $details ) ) : ?>
                        <p><?php echo nl2br( esc_html( $details ) ); ?></p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </a>
              <div class="quills-product-quick-add">
                <button type="button" class="quills-btn quills-btn--add-to-cart quills-hover-add-cart" data-product-id="<?php echo esc_attr( $p_id ); ?>" data-permalink="<?php echo esc_url( $p_link ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'ADD TO CART %s', 'coffee-cafe-corner' ), $p_name ) ); ?>">
                  <span>ADD TO CART</span>
                </button>
              </div>
            </div>
            <div class="quills-product-info">
              <span class="quills-product-brand">QUILLSCOFFEE</span>
              <h3 class="quills-product-name"><a href="<?php echo esc_url( $p_link ); ?>"><?php echo esc_html( $p_name ); ?></a></h3>
              <div class="quills-rating-row">
                <span class="quills-stars">★★★★★</span>
                <span class="quills-review-count">(<?php echo esc_html( (int) $p_reviews ); ?> reviews)</span>
              </div>
              <div class="quills-product-price">From $<?php echo esc_html( number_format( (float) $p_price, 2 ) ); ?></div>
            </div>
          </div>
        <?php
          endforeach;
        endif;
        ?>
      </div>
      <hr class="quills-section-divider" />
    </div>
  </section>

  <!-- ========================================================
       SECTION 8: 50/50 - TASTE-TESTED TWICE A WEEK (IMAGE ON LEFT)
       ======================================================== -->
  <section class="quills-split-section quills-section-cupping">
    <div class="quills-container">
      <div class="quills-split-row">
        <div class="quills-split-media">
          <img src="<?php echo esc_url( $cupping_img ); ?>" alt="Quills Coffee Cupping Session" class="quills-split-img" loading="lazy" />
        </div>
        <div class="quills-split-content">
          <h2 class="quills-section-title"><?php echo esc_html( $cupping_title ); ?></h2>
          <div class="quills-text-body">
            <p><?php echo wp_kses( $cupping_p1, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $cupping_p2, $allowed_tags ); ?></p>
            <p><?php echo wp_kses( $cupping_p3, $allowed_tags ); ?></p>
          </div>
          <div class="quills-split-cta">
            <a href="<?php echo esc_url( $cupping_cta_link ); ?>" class="quills-btn quills-btn--orange" aria-label="<?php echo esc_attr( $cupping_cta_text ); ?>">
              <?php echo esc_html( $cupping_cta_text ); ?>
            </a>
          </div>
          <div class="quills-split-quote">
            <p><?php echo wp_kses( $cupping_quote, $allowed_tags ); ?></p>
          </div>
        </div>
      </div>
      <hr class="quills-section-divider" />
    </div>
  </section>

  <!-- ========================================================
       SECTION 9: FAQ ACCORDION
       ======================================================== -->
  <section class="quills-faq-section">
    <div class="quills-container quills-container--narrow">
      <div class="quills-faq-header">
        <h2 class="quills-section-title quills-section-title--center"><?php echo esc_html( $faq_title ); ?></h2>
      </div>

      <div class="quills-accordion" id="quillsFaqAccordion">

        <!-- FAQ Item 1 -->
        <div class="quills-accordion-item">
          <button class="quills-accordion-trigger" type="button" aria-expanded="false">
            <span class="quills-accordion-title"><?php echo esc_html( $faq_q1 ); ?></span>
            <span class="quills-accordion-icon">
              <svg class="quills-plus-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="quills-icon-vertical"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="quills-accordion-panel">
            <div class="quills-accordion-content">
              <?php echo wp_kses_post( wpautop( $faq_a1 ) ); ?>
            </div>
          </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="quills-accordion-item">
          <button class="quills-accordion-trigger" type="button" aria-expanded="false">
            <span class="quills-accordion-title"><?php echo esc_html( $faq_q2 ); ?></span>
            <span class="quills-accordion-icon">
              <svg class="quills-plus-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="quills-icon-vertical"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="quills-accordion-panel">
            <div class="quills-accordion-content">
              <?php echo wp_kses_post( wpautop( $faq_a2 ) ); ?>
            </div>
          </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="quills-accordion-item">
          <button class="quills-accordion-trigger" type="button" aria-expanded="false">
            <span class="quills-accordion-title"><?php echo esc_html( $faq_q3 ); ?></span>
            <span class="quills-accordion-icon">
              <svg class="quills-plus-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="quills-icon-vertical"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="quills-accordion-panel">
            <div class="quills-accordion-content">
              <?php echo wp_kses_post( wpautop( $faq_a3 ) ); ?>
            </div>
          </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="quills-accordion-item">
          <button class="quills-accordion-trigger" type="button" aria-expanded="false">
            <span class="quills-accordion-title"><?php echo esc_html( $faq_q4 ); ?></span>
            <span class="quills-accordion-icon">
              <svg class="quills-plus-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="quills-icon-vertical"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="quills-accordion-panel">
            <div class="quills-accordion-content">
              <?php echo wp_kses_post( wpautop( $faq_a4 ) ); ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ========================================================
       SECTION 10: THE HOOT (NEWSLETTER SIGNUP)
       ======================================================== -->
  <section class="quills-hoot-section">
    <div class="quills-hoot-bg-left" style="background-image: url('<?php echo esc_url( $img_dir . 'hoot-bg-left.png' ); ?>');"></div>
    <div class="quills-hoot-bg-right" style="background-image: url('<?php echo esc_url( $img_dir . 'hoot-bg-right.png' ); ?>');"></div>
    <div class="quills-hoot-card newsletter-card">
      <div class="quills-hoot-tab newsletter-card__tab">
        <div class="quills-hoot-tab-head newsletter-card__tab_head">
          <h2 class="quills-hoot-heading newsletter-card__heading"><?php echo esc_html( $hoot_heading ); ?></h2>
          <span class="quills-hoot-icon-badge wrapp-icon">
            <img src="<?php echo esc_url( $hoot_icon ); ?>" alt="<?php echo esc_attr( $hoot_heading ); ?> Owl Icon" class="quills-hoot-icon newsletter-card__icon" width="48" height="48" />
          </span>
        </div>
      </div>
      <div class="quills-hoot-body newsletter-card__body">
        <div class="quills-hoot-text">
          <p><?php echo wp_kses( $hoot_p1, $allowed_tags ); ?></p>
          <p><?php echo wp_kses( $hoot_p2, $allowed_tags ); ?></p>
          <p><strong class="quills-highlight-orange"><?php echo esc_html( $hoot_highlight ); ?></strong> <?php echo esc_html( $hoot_p3 ); ?></p>
          <p><?php echo wp_kses( $hoot_p4, $allowed_tags ); ?></p>
          <p><?php echo wp_kses( $hoot_p5, $allowed_tags ); ?></p>
        </div>
        <div class="quills-hoot-form-container">
        <?php
        if ( shortcode_exists( 'contact-form-7' ) && ! empty( $hoot_cf7_id ) ) {
            echo do_shortcode( '[contact-form-7 id="' . esc_attr( $hoot_cf7_id ) . '" title="The Hoot Newsletter"]' );
        } else {
        ?>
        <form class="quills-hoot-form" method="post" action="<?php echo esc_url( home_url( '/contact#newsletter' ) ); ?>">
          <input type="email" name="hoot_email" class="quills-hoot-input" placeholder="Email" required autocomplete="email" />
          <button type="submit" class="quills-hoot-btn" aria-label="<?php echo esc_attr( $hoot_btn_text ); ?>"><?php echo esc_html( $hoot_btn_text ); ?></button>
        </form>
        <?php } ?>
        </div>
      </div>
    </div>
  </section>

</div>
