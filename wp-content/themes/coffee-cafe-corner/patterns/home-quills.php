<?php
/**
 * Title: Home Quills
 * Slug: coffee-cafe-corner/home-quills
 * Categories: featured
 * Block Types: core/post-content
 */

$theme_uri = trailingslashit( get_template_directory_uri() );
$img_dir   = $theme_uri . 'assets/images/home/';
?>

<div class="quills-home-wrapper alignfull">

  <!-- ========================================================
       SECTION 1: HERO BANNER (KETTLE POUR REFERENCE)
       ======================================================== -->
  <section class="quills-hero-section">
    <div class="quills-hero-bg">
      <img src="<?php echo esc_url( $img_dir . 'home.webp' ); ?>" alt="Quills Coffee Barista Pour Over" class="quills-hero-img" />
    </div>
    <div class="quills-hero-content-wrapper">
      <div class="quills-hero-content">
        <h1 class="quills-hero-title">
          We find them, we roast them, you<br>just enjoy them.
        </h1>
        <p class="quills-hero-subtitle">
          Get new delicious coffees that you and your guests will love, delivered<br>to your door on your schedule.
        </p>
        <div class="quills-hero-cta">
          <a href="<?php echo esc_url( home_url( '/subscriptions/' ) ); ?>" class="quills-btn quills-btn--hero" aria-label="Start Your Subscription">
            START YOUR SUBSCRIPTION
          </a>
        </div>
        <div class="quills-hero-reviews">
          <div class="quills-rating-stars">★★★★★</div>
          <p class="quills-rating-text">4.62 stars across 13,082 reviews</p>
          <p class="quills-featured-label">Featured in</p>
          <div class="quills-press-logos">
            <div class="quills-press-item quills-press-garden">
              <span class="quills-logo-garden">GARDEN &amp; GUN</span>
            </div>
            <div class="quills-press-item quills-press-cosmo">
              <span class="quills-logo-cosmo">COSMOPOLITAN</span>
              <span class="quills-press-caption">“Forget the PSL and try the EVL here at Quills...”</span>
            </div>
            <div class="quills-press-item quills-press-foodwine">
              <span class="quills-logo-foodwine">FOOD &amp; WINE</span>
              <span class="quills-press-caption">“Look to the single origin offerings.”</span>
            </div>
            <div class="quills-press-item quills-press-courier">
              <span class="quills-logo-courier">courier journal</span>
            </div>
          </div>
        </div>
        <div class="quills-hero-quote">
          <p>“I’ve searched far and wide and this is the place to get your cup or bag of greatness if you happen to be a true coffee aficionado.” — Jacob Y.</p>
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
          <img src="<?php echo esc_url( $img_dir . 'team-nathan.jpg' ); ?>" alt="Quills Coffee Team" class="quills-split-img" loading="lazy" />
        </div>
        <div class="quills-split-content">
          <h2 class="quills-section-title">NO ROBOTS. JUST PEOPLE.</h2>
          <div class="quills-text-body">
            <p>You should know who's choosing and roasting your coffee. No algorithms here.</p>
            <p>It’s a small group of real people in the heart of Louisville, Kentucky who love finding and making great coffee and care about sharing it with you.</p>
            <p>It’s our founder, Nathan, four operations team members, five roasters, four cafe managers, and 42 baristas.</p>
            <p>Some of us have worked in coffee for years. Others discovered their passion more recently. What we all have in common is this belief that coffee should bring people together.</p>
            <p>We’re doing our best to deliver coffee that connects people.</p>
          </div>
          <div class="quills-split-cta">
            <a href="<?php echo esc_url( home_url( '/coffee/' ) ); ?>" class="quills-btn quills-btn--orange" aria-label="Show Me The Coffee">
              SHOW ME THE COFFEE
            </a>
          </div>
          <div class="quills-split-quote">
            <p>“The best tasting pour over coffee on this planet.” — Kelsey B.</p>
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
        <h2 class="quills-features-main-title">Coffee subscriptions. Change, pause, or cancel anytime.</h2>
      </div>
      <div class="quills-features-grid">
        <div class="quills-feature-item">
          <div class="quills-feature-icon-wrap">
            <img src="<?php echo esc_url( $img_dir . 'icon-coffee-bag.png' ); ?>" alt="Pick Your Subscription" class="quills-feature-icon" loading="lazy" />
          </div>
          <h3 class="quills-feature-title">1. PICK YOUR SUBSCRIPTION</h3>
          <p class="quills-feature-desc">Want a favorite on repeat or something new every month? Maybe a mixed bundle? Pick what you like or let us curate your morning for you.</p>
        </div>
        <div class="quills-feature-item">
          <div class="quills-feature-icon-wrap">
            <img src="<?php echo esc_url( $img_dir . 'icon-calendar.png' ); ?>" alt="Pick How Often" class="quills-feature-icon" loading="lazy" />
          </div>
          <h3 class="quills-feature-title">2. PICK HOW OFTEN</h3>
          <p class="quills-feature-desc">Every week? Every 2 weeks? How fast are you downing it? If you're not sure, we'll help you get a close guess. You can always change it later.</p>
        </div>
        <div class="quills-feature-item">
          <div class="quills-feature-icon-wrap">
            <img src="<?php echo esc_url( $img_dir . 'icon-fingerprint-cup.png' ); ?>" alt="Enjoy It From Now On" class="quills-feature-icon" loading="lazy" />
          </div>
          <h3 class="quills-feature-title">3. ENJOY IT FROM NOW ON</h3>
          <p class="quills-feature-desc">Start peeping out the window. We roast 4 days a week. You'll have a fresh new bag of coffee showing up just as you finish the last one.</p>
        </div>
      </div>
      <div class="quills-features-cta-wrap">
        <a href="<?php echo esc_url( home_url( '/subscriptions/' ) ); ?>" class="quills-btn quills-btn--orange" aria-label="Find The Subscription For You">
          FIND THE SUBSCRIPTION FOR YOU
        </a>
        <div class="quills-features-quote">
          <p>“The coffee is absolutely fabulous.”<br>— Athena S.</p>
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
          <img src="<?php echo esc_url( $img_dir . 'roaster-justin.jpg' ); ?>" alt="Justin Roasting Coffee at Quills" class="quills-split-img" loading="lazy" />
        </div>
        <div class="quills-split-content">
          <h2 class="quills-section-title">ROASTED LOCALLY BY US</h2>
          <div class="quills-text-body">
            <p>We roast all of our coffee ourselves, right here on Main Street in Louisville, Kentucky.</p>
            <p>Our roasters arrive before dawn, when it’s still cool and quiet. They know the difference between a good cup of coffee and an exceptional one lives in hundreds of small decisions.</p>
            <p>Roasting in small 45-pound batches by hand means each batch gets the kind of attention that big commercial coffee companies simply can't afford to give.</p>
            <p>Justin, our head roaster, and his team of four are paying attention to the temperature, airflow, and the smell.</p>
            <p>They’re listening for a distinctive “crack” of the beans that tells them right when to stop to lock in the best flavors for your coffee.</p>
          </div>
          <div class="quills-split-cta">
            <a href="<?php echo esc_url( home_url( '/coffee/' ) ); ?>" class="quills-btn quills-btn--orange" aria-label="Search By Roast">
              SEARCH BY ROAST
            </a>
          </div>
          <div class="quills-split-quote">
            <p>“One of the best coffee roasters in the country and beautiful shops. Worth a visit.”— Crema Guru</p>
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
          <img src="<?php echo esc_url( $img_dir . 'sourcing-farm.jpg' ); ?>" alt="Farmers Hand-picking Coffee" class="quills-split-img" loading="lazy" />
        </div>
        <div class="quills-split-content">
          <h2 class="quills-section-title">HAND-PICKED BY FARMERS, HAND SELECTED BY US</h2>
          <div class="quills-text-body">
            <p>Over 11 million tons of coffee is grown every year across the world. Less than 15% of that meets premium specialty grade coffee standards. A fancy way of saying the best of the best. (And the only kind we buy.)</p>
            <p>From that rare tier of 15%, we source and sample over 100 exceptional coffees every year.</p>
            <p>And from those 100, we pick around 20 of the best to serve and ship to our customers.</p>
            <p>It's like having your own personal coffee sommelier.</p>
            <p>We do all this so you can enjoy exceptional coffee every single day.</p>
          </div>
          <div class="quills-split-cta">
            <a href="<?php echo esc_url( home_url( '/coffee/' ) ); ?>" class="quills-btn quills-btn--orange" aria-label="See What We Found For You">
              SEE WHAT WE FOUND FOR YOU
            </a>
          </div>
          <div class="quills-split-quote">
            <p>“Excellent coffee and excellent sourcing. A place that loves wonderful coffees, the best the world has to offer.”<br>— Preston S.</p>
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
        <img src="<?php echo esc_url( $img_dir . 'badge-coffee-connect-people.png' ); ?>" alt="Quills Coffee Connect People Badge" class="quills-badge-img" loading="lazy" />
      </div>
    </div>
  </section>

  <!-- ========================================================
       SECTION 7: OUR BESTSELLERS (3 PRODUCTS)
       ======================================================== -->
  <section class="quills-bestsellers-section">
    <div class="quills-container">
      <div class="quills-bestsellers-header">
        <h2 class="quills-section-title quills-section-title--center">Our Bestsellers</h2>
        <p class="quills-section-subtitle">The ones people keep coming back for.</p>
      </div>

      <div class="quills-products-grid">

        <!-- Product 1: BLACKSMITH -->
        <div class="quills-product-card">
          <div class="quills-product-meta-header">
            <h2 class="quills-product-tag" style="color: #000000;">BLACKSMITH</h2>
            <p class="quills-product-tag-desc">The F1 car of our lineup. Our signature espresso that folks enjoy in every latte, cappuccino, and cortado in our cafés.</p>
          </div>
          <div class="quills-product-image-box">
            <a href="<?php echo esc_url( home_url( '/product/blacksmith-espresso/' ) ); ?>" class="quills-product-link">
              <div class="quills-product-images-wrap">
                <img src="<?php echo esc_url( $img_dir . 'product-blacksmith-front.jpg' ); ?>" alt="Blacksmith Espresso Blend Front" class="quills-img-front" loading="lazy" />
                <img src="<?php echo esc_url( $img_dir . 'product-bag-back.jpg' ); ?>" alt="Blacksmith Espresso Blend Back" class="quills-img-back" loading="lazy" />
              </div>
              <div class="quills-rollover-overlay">
                <div class="quills-rollover-content">
                  <h4 class="quills-rollover-title">Blacksmith | Espresso Blend</h4>
                  <div class="quills-rollover-text">
                    <p class="quills-rollover-tasting"><em><strong>Baker's chocolate, blueberries, hazelnut</strong></em></p>
                    <p><strong>Our Signature Espresso</strong><br><strong>Process: </strong>Washed & Natural<br><strong>Origins: </strong>Colombia, Nicaragua, Ethiopia</p>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="quills-product-info">
            <span class="quills-product-brand">QuillsCoffee</span>
            <h3 class="quills-product-name"><a href="<?php echo esc_url( home_url( '/product/blacksmith-espresso/' ) ); ?>">Blacksmith | Espresso Blend</a></h3>
            <div class="quills-rating-row">
              <span class="quills-stars">★★★★★</span>
              <span class="quills-review-count">(56 reviews)</span>
            </div>
            <div class="quills-product-price">From $20.00</div>
            <a href="<?php echo esc_url( home_url( '/product/blacksmith-espresso/' ) ); ?>" class="quills-btn quills-btn--add-to-cart">
              Add to cart
            </a>
          </div>
        </div>

        <!-- Product 2: INKWELL -->
        <div class="quills-product-card">
          <div class="quills-product-meta-header">
            <h2 class="quills-product-tag" style="color: #f15239;">INKWELL</h2>
            <p class="quills-product-tag-desc">The daily driver. Our classic house blend that's on drip at our cafes from open to close. Loved by regulars for 17 years.</p>
          </div>
          <div class="quills-product-image-box">
            <a href="<?php echo esc_url( home_url( '/product/inkwell-house-blend/' ) ); ?>" class="quills-product-link">
              <div class="quills-product-images-wrap">
                <img src="<?php echo esc_url( $img_dir . 'product-inkwell-front.jpg' ); ?>" alt="Inkwell Signature Blend Front" class="quills-img-front" loading="lazy" />
                <img src="<?php echo esc_url( $img_dir . 'product-bag-back.jpg' ); ?>" alt="Inkwell Signature Blend Back" class="quills-img-back" loading="lazy" />
              </div>
              <div class="quills-rollover-overlay">
                <div class="quills-rollover-content">
                  <h4 class="quills-rollover-title">Inkwell | Signature Blend</h4>
                  <div class="quills-rollover-text">
                    <p class="quills-rollover-tasting"><em><strong>Graham cracker, cooked cherries, vanilla</strong></em></p>
                    <p><strong>Our Signature House Blend</strong><br><strong>Process: </strong>Washed & Natural<br><strong>Origins: </strong>Colombia, Guatemala, Ethiopia</p>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="quills-product-info">
            <span class="quills-product-brand">QuillsCoffee</span>
            <h3 class="quills-product-name"><a href="<?php echo esc_url( home_url( '/product/inkwell-house-blend/' ) ); ?>">Inkwell | Signature Blend</a></h3>
            <div class="quills-rating-row">
              <span class="quills-stars">★★★★★</span>
              <span class="quills-review-count">(80 reviews)</span>
            </div>
            <div class="quills-product-price">From $20.00</div>
            <a href="<?php echo esc_url( home_url( '/product/inkwell-house-blend/' ) ); ?>" class="quills-btn quills-btn--add-to-cart">
              Add to cart
            </a>
          </div>
        </div>

        <!-- Product 3: SOUTHERN GOTHIC -->
        <div class="quills-product-card">
          <div class="quills-product-meta-header">
            <h2 class="quills-product-tag" style="color: #926685;">SOUTHERN GOTHIC</h2>
            <p class="quills-product-tag-desc">Our cold brew blend crafted for our customers who prefer their coffee chilled.</p>
          </div>
          <div class="quills-product-image-box">
            <a href="<?php echo esc_url( home_url( '/product/southern-gothic-12oz/' ) ); ?>" class="quills-product-link">
              <div class="quills-product-images-wrap">
                <img src="<?php echo esc_url( $img_dir . 'product-southern-gothic-front.jpg' ); ?>" alt="Southern Gothic Cold Brew Blend Front" class="quills-img-front" loading="lazy" />
                <img src="<?php echo esc_url( $img_dir . 'product-bag-back.jpg' ); ?>" alt="Southern Gothic Cold Brew Blend Back" class="quills-img-back" loading="lazy" />
              </div>
              <div class="quills-rollover-overlay">
                <div class="quills-rollover-content">
                  <h4 class="quills-rollover-title">Southern Gothic | Cold Brew Blend</h4>
                  <div class="quills-rollover-text">
                    <p class="quills-rollover-tasting"><em><strong>Dark chocolate, sweet orange, subtle sweetness</strong></em></p>
                    <p><strong>Our Signature Cold Brew Blend</strong><br><strong>Process: </strong>Washed & Natural<br><strong>Origins: </strong>Colombia, Honduras</p>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="quills-product-info">
            <span class="quills-product-brand">QuillsCoffee</span>
            <h3 class="quills-product-name"><a href="<?php echo esc_url( home_url( '/product/southern-gothic-12oz/' ) ); ?>">Southern Gothic | Cold Brew Blend</a></h3>
            <div class="quills-rating-row">
              <span class="quills-stars">★★★★★</span>
              <span class="quills-review-count">(42 reviews)</span>
            </div>
            <div class="quills-product-price">From $20.00</div>
            <a href="<?php echo esc_url( home_url( '/product/southern-gothic-12oz/' ) ); ?>" class="quills-btn quills-btn--add-to-cart">
              Add to cart
            </a>
          </div>
        </div>

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
          <img src="<?php echo esc_url( $img_dir . 'cupping-tasting.jpg' ); ?>" alt="Quills Coffee Cupping Session" class="quills-split-img" loading="lazy" />
        </div>
        <div class="quills-split-content">
          <h2 class="quills-section-title">TASTE-TESTED TWICE A WEEK</h2>
          <div class="quills-text-body">
            <p>Every coffee gets tested, tweaked, and perfected every week until we run out of it.</p>
            <p>When we find something wrong — and we do — we dump the whole batch and start over.</p>
            <p>We do this to make sure you get the absolute best flavors and aromas from every coffee you get from us.</p>
          </div>
          <div class="quills-split-cta">
            <a href="<?php echo esc_url( home_url( '/coffee/' ) ); ?>" class="quills-btn quills-btn--orange" aria-label="Show Me The Coffee">
              SHOW ME THE COFFEE
            </a>
          </div>
          <div class="quills-split-quote">
            <p>“If you love regular ol coffee but not the regular ol taste - you will love Quills!”<br>— Amie M</p>
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
        <h2 class="quills-section-title quills-section-title--center">FAQ</h2>
      </div>

      <div class="quills-accordion" id="quillsFaqAccordion">

        <!-- FAQ Item 1 -->
        <div class="quills-accordion-item">
          <button class="quills-accordion-trigger" type="button" aria-expanded="false">
            <span class="quills-accordion-title">How fresh is the coffee I get?</span>
            <span class="quills-accordion-icon">
              <svg class="quills-plus-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="quills-icon-vertical"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="quills-accordion-panel">
            <div class="quills-accordion-content">
              <p>All coffee is roasted to order. Our small roastery team of four guys roasts 4 days a week.</p>
              <p>We ship coffee orders at peak freshness, after an initial resting period to degas. This way you receive your order as it's beginning to approach peak freshness, so you can get the best flavors from every bag of coffee you receive.</p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="quills-accordion-item">
          <button class="quills-accordion-trigger" type="button" aria-expanded="false">
            <span class="quills-accordion-title">When will my coffee ship?</span>
            <span class="quills-accordion-icon">
              <svg class="quills-plus-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="quills-icon-vertical"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="quills-accordion-panel">
            <div class="quills-accordion-content">
              <p>If you order by midnight Sunday, your order will ship on Wednesday.</p>
              <p>If you order by midnight Tuesday, your order will ship on Friday.</p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="quills-accordion-item">
          <button class="quills-accordion-trigger" type="button" aria-expanded="false">
            <span class="quills-accordion-title">I’d like to work at Quills. How do I apply?</span>
            <span class="quills-accordion-icon">
              <svg class="quills-plus-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="quills-icon-vertical"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="quills-accordion-panel">
            <div class="quills-accordion-content">
              <p>We hire baristas often! You can <a href="https://form.jotform.com/quillscoffee/new-customer-registration-form" target="_blank" rel="noopener noreferrer">apply here.</a></p>
            </div>
          </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="quills-accordion-item">
          <button class="quills-accordion-trigger" type="button" aria-expanded="false">
            <span class="quills-accordion-title">My question is about something else</span>
            <span class="quills-accordion-icon">
              <svg class="quills-plus-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="quills-icon-vertical"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="quills-accordion-panel">
            <div class="quills-accordion-content">
              <p>Go ahead and reach out to <a href="mailto:hello@quillscoffee.com">hello@quillscoffee.com</a>. You're gonna talk to one of us, not a bot.</p>
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
    <div class="quills-hoot-card">
      <div class="quills-hoot-tab">
        <h2 class="quills-hoot-heading">THE HOOT</h2>
        <div class="quills-hoot-icon-badge">
          <img src="<?php echo esc_url( $img_dir . 'hoot-icon.png' ); ?>" alt="The Hoot Owl Icon" class="quills-hoot-icon" width="48" height="48" />
        </div>
      </div>
      <div class="quills-hoot-body">
        <div class="quills-hoot-text">
          <p>The Hoot is one short email from us sent every Friday morning. It takes about 5 minutes to read. It’s less of a 'newsletter' and more like an actual letter.</p>
          <p>We sometimes send readers links to secret coffees and exclusive reader-only merch.</p>
          <p><strong class="quills-highlight-orange">8,212 kind folks</strong> currently get it sent to their inbox.</p>
          <p>We share what the people behind your coffee have been up to that week. You may hear about some wild coffee our head roaster Justin has tasted. Or behind-the-scenes on the new seasonal drinks our beverage director Jess is whipping up.</p>
          <p>And we always add a little something fun in the PS.</p>
        </div>
        <form class="quills-hoot-form" method="post" action="<?php echo esc_url( home_url( '/contact#newsletter' ) ); ?>">
          <input type="email" name="hoot_email" class="quills-hoot-input" placeholder="Email" required autocomplete="email" />
          <button type="submit" class="quills-hoot-btn" aria-label="Try It">TRY IT</button>
        </form>
      </div>
    </div>
  </section>

</div>
