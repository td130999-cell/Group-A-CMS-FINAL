<?php
/**
 * Title: About Us
 * Slug: coffee-cafe-corner/about
 * Categories: coffee-cafe-corner, pages
 * Description: Quills Coffee inspired About Us page pattern, dynamically pulling content from WordPress database.
 */

// If a cafe detail view is requested via ?view=..., delegate to the cafe detail subpage
if ( ! empty( $_GET['view'] ) ) {
	$cafe_detail_pattern = get_template_directory() . '/patterns/cafe-detail.php';
	if ( file_exists( $cafe_detail_pattern ) ) {
		include $cafe_detail_pattern;
		return;
	}
}

// 1. Resolve Target Page ID from Database
$page_id = get_the_ID();
if ( ! $page_id || ! in_array( get_post_field( 'post_name', $page_id ), array( 'about-us', 'about' ), true ) ) {
    $about_page = get_page_by_path( 'about-us' );
    if ( ! $about_page ) {
        $about_page = get_page_by_path( 'about' );
    }
    if ( $about_page ) {
        $page_id = $about_page->ID;
    }
}

// 2. Base Assets Path
$theme_url = trailingslashit( get_template_directory_uri() );
$img_dir   = $theme_url . 'assets/images/about/';

// 3. Fetch Data dynamically from Database with defaults
$hero_title = get_post_meta( $page_id, '_quills_hero_title', true );
if ( empty( $hero_title ) ) {
    $hero_title = get_the_title( $page_id ) ?: 'About Us';
}

$hero_img_file = get_post_meta( $page_id, '_quills_hero_image', true ) ?: 'about-hero.jpg';
$hero_img_url  = $img_dir . $hero_img_file;

// Section: Where We Started
$where_started_title = get_post_meta( $page_id, '_quills_where_we_started_title', true ) ?: 'WHERE WE STARTED';
$where_started_paragraphs = get_post_meta( $page_id, '_quills_where_we_started_paragraphs', true );
if ( empty( $where_started_paragraphs ) || ! is_array( $where_started_paragraphs ) ) {
    $where_started_paragraphs = array(
        "In the early 2000s, many people drank coffee without thinking much about it. I couldn't stop thinking about it.",
        "During my time as a social worker, I was meeting with students in local coffeehouses. I found myself constantly talking about what makes exceptional coffee.",
        "How it's sourced, roasted, how it's brewed. And why doing it right matters.",
        "In 2007, we took a pair of hammers to an old rundown building in the Germantown neighborhood of Louisville, Kentucky.",
        "After a lot of love and elbow grease, we opened the first Quills. That first shop taught us everything. We learned that great coffee can create the kind of spaces where people can connect.",
        "We learned that when you blend fine coffee with a touch of southern hospitality, when you prioritize connection over speed, something special happens.",
        "You make places where strangers can become friends. Where a writer finds her words in a warm corner seat. Where a company might be founded on the back of a napkin. Where first dates can turn into something more.",
        "When our first building was about to be sold and we had to move, our regular customer Tommy O'Shea helped us find a new home in the Highlands. That shop on Baxter Avenue runs to this day.",
        "We've grown since then. Today, we roast our coffee in small batches right here in Louisville. Because we wanted better control over the whole experience we were creating. Today we have six cafes here and one in downtown Indianapolis. But at the heart of it all, the vision hasn't changed: Great coffee. Great spaces. Great hospitality.",
        "We work with our producers and sourcing partners around the world who care deeply about quality. The close work we do with them means that every cup you drink is connected to real people, real farms, and a commitment to doing things the right way."
    );
}

// Section: Why We're Here
$why_here_title   = get_post_meta( $page_id, '_quills_why_were_here_title', true ) ?: "WHY WE'RE HERE";
$why_here_img     = $img_dir . ( get_post_meta( $page_id, '_quills_why_were_here_image', true ) ?: 'why-were-here.jpg' );
$why_here_content = get_post_meta( $page_id, '_quills_why_were_here_content', true ) ?: "Quills Coffee is here to deliver a coffee that connects people. Between the barista behind the counter and the customer in front of it. Between strangers at neighboring tables. Between all of us and the farmers who picked the coffee we're enjoying. We believe delivering great coffee is a chance to make memorable human experiences. It's a chance for us to be together, to pause, to talk, to connect.";

// Section: How We Work
$how_work_title   = get_post_meta( $page_id, '_quills_how_we_work_title', true ) ?: 'HOW WE WORK';
$how_work_content = get_post_meta( $page_id, '_quills_how_we_work_content', true ) ?: "The French have a word: terroir. It means \"the taste of the place itself.\" The soil where something grows. The climate that shapes it. The hands that tend it. It's why a coffee cherry from Guatemala tastes different from one grown in Ethiopia. The earth was different, the rain was different, and so the taste is different. At Quills, we celebrate our own kind of \"terroir\" with three core values: Genuine Care, Continuous Craft, and Creative Education.";

// Section: Terroir Definition Card
$terroir_title    = get_post_meta( $page_id, '_quills_terroir_title', true ) ?: 'terroir';
$terroir_phonetic = get_post_meta( $page_id, '_quills_terroir_phonetic', true ) ?: '/tɛrˈwɑːr/ • French';
$terroir_pos      = get_post_meta( $page_id, '_quills_terroir_pos', true ) ?: 'noun';
$terroir_def_1    = get_post_meta( $page_id, '_quills_terroir_def_1', true ) ?: '1. the combination of factors including soil, climate, and sunlight that gives wine grapes and coffee cherries their distinctive character';
$terroir_def_2    = get_post_meta( $page_id, '_quills_terroir_def_2', true ) ?: '2. the combination of people, values, and daily practices that give our spaces their distinctive character';
$terroir_bg_img   = $img_dir . ( get_post_meta( $page_id, '_quills_terroir_image', true ) ?: 'terroir.png' );

// Section: Genuine Care
$genuine_care_title   = get_post_meta( $page_id, '_quills_genuine_care_title', true ) ?: 'GENUINE CARE';
$genuine_care_img     = $img_dir . ( get_post_meta( $page_id, '_quills_genuine_care_image', true ) ?: 'genuine-care.png' );
$genuine_care_content = get_post_meta( $page_id, '_quills_genuine_care_content', true ) ?: "We serve with warmth, hospitality, and attentiveness to the people around us. The barista knows your name. She asks how you are. He's there with you. She polishes tables not because her manager watches, but because she knows someone's going to sit there with their morning coffee. The roastery team works hard to find new and exciting coffees, because they care about curating a delightful solution for every customer. Managers work to make their cafes places where people want to gather and come back to. Whether it's behind the bar, in the roastery, or in the training lab, the team is never here just for people who want to create a place for connection.";

// Section: Continuous Craft
$craft_title   = get_post_meta( $page_id, '_quills_continuous_craft_title', true ) ?: 'CONTINUOUS CRAFT';
$craft_img     = $img_dir . ( get_post_meta( $page_id, '_quills_continuous_craft_image', true ) ?: 'continuous-craft.jpg' );
$craft_content = get_post_meta( $page_id, '_quills_continuous_craft_content', true ) ?: "Excellence is not an accident. It's hundreds of small decisions made correctly every day. Water temperature, grind size, the timing of every shot. It's about constant improvement. We test, we taste, we tweak. Because coffee is a craft worth perfecting. It's the barista who continues to develop his palate, textures his milk to silk, to create a beautiful presentation every time. The manager who continues to hone our hospitality. The roaster improves their skill batch after batch. We're committed to an excellence and beauty in our craft.";

// Section: Creative Education
$edu_title   = get_post_meta( $page_id, '_quills_creative_education_title', true ) ?: 'CREATIVE EDUCATION';
$edu_img     = $img_dir . ( get_post_meta( $page_id, '_quills_creative_education_image', true ) ?: 'creative-education.jpg' );
$edu_content = get_post_meta( $page_id, '_quills_creative_education_content', true ) ?: "Knowledge belongs to anyone who wants it. The customer who asks why this coffee tastes like chocolate gets a real answer from our team—about the processing, the roast, the origin. They adjust their language and make learning feel safe and exciting, never intimidating. A new barista learning to pull shots gets the time to understand, not just run through the motions. We light up when we share knowledge. And we share it freely because we want you to love coffee as much as we do. Because we believe knowledge can deepen every coffee experience.";

// Section: Where We're Going
$where_going_title  = get_post_meta( $page_id, '_quills_where_were_going_title', true ) ?: "Where We're Going";
$where_going_quote  = get_post_meta( $page_id, '_quills_where_were_going_quote', true ) ?: "Like soil worked for years, our roots merely grow richer with time. We're not trying to be the biggest coffee company, or the fastest. We're building a place where quality lives, where every cup honors the taste of each dear sight, and most importantly—where people strive to connect with other people.";
$where_going_author = get_post_meta( $page_id, '_quills_where_were_going_author', true ) ?: '— Nathan Quillo, Founder';
$where_going_img    = $img_dir . ( get_post_meta( $page_id, '_quills_where_were_going_image', true ) ?: 'where-were-going.jpg' );
?>

<div class="quills-about-page-container">

    <!-- Breadcrumb Bar -->
    <div class="quills-breadcrumb-container">
        <nav class="quills-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span class="quills-bc-sep">/</span>
            <span class="quills-bc-current"><?php echo esc_html( $hero_title ); ?></span>
        </nav>
    </div>

    <!-- 1. Hero Banner with Rounded Corners and Title Overlay -->
    <section class="quills-hero-section">
        <div class="quills-hero-banner" style="background-image: url('<?php echo esc_url( $hero_img_url ); ?>');">
            <div class="quills-hero-overlay"></div>
            <h1 class="quills-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
        </div>
    </section>

    <!-- 2. WHERE WE STARTED (Story Narrative) -->
    <section class="quills-section quills-story-section">
        <div class="quills-inner-narrow">
            <h2 class="quills-slab-heading"><?php echo esc_html( $where_started_title ); ?></h2>
            <div class="quills-story-paragraphs">
                <?php foreach ( $where_started_paragraphs as $paragraph ) : ?>
                    <p><?php echo esc_html( $paragraph ); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 3. WHY WE'RE HERE (Image Left, Text Right) -->
    <section class="quills-section quills-split-section quills-why-here">
        <div class="quills-split-grid">
            <div class="quills-split-col quills-split-image-col">
                <div class="quills-image-wrapper">
                    <img src="<?php echo esc_url( $why_here_img ); ?>" alt="<?php echo esc_attr( $why_here_title ); ?>" loading="lazy" />
                </div>
            </div>
            <div class="quills-split-col quills-split-text-col">
                <h2 class="quills-slab-heading"><?php echo esc_html( $why_here_title ); ?></h2>
                <div class="quills-body-text">
                    <p><?php echo esc_html( $why_here_content ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. HOW WE WORK (Centered Intro) -->
    <section class="quills-section quills-how-we-work-section">
        <div class="quills-inner-medium">
            <h2 class="quills-slab-heading text-center"><?php echo esc_html( $how_work_title ); ?></h2>
            <div class="quills-body-text text-center">
                <p><?php echo esc_html( $how_work_content ); ?></p>
            </div>
        </div>
    </section>

    <!-- 5. TERROIR Definition Banner (Rounded Feature Card) -->
    <section class="quills-section quills-terroir-section">
        <div class="quills-terroir-card">
            <img src="<?php echo esc_url( $terroir_bg_img ); ?>" alt="<?php echo esc_attr( $terroir_title . ': ' . $terroir_phonetic . ' ' . $terroir_pos ); ?>" loading="lazy" />
        </div>
    </section>

    <!-- 6. GENUINE CARE (Image Left, Text Right) -->
    <section class="quills-section quills-split-section quills-genuine-care">
        <div class="quills-split-grid">
            <div class="quills-split-col quills-split-image-col">
                <div class="quills-image-wrapper">
                    <img src="<?php echo esc_url( $genuine_care_img ); ?>" alt="<?php echo esc_attr( $genuine_care_title ); ?>" loading="lazy" />
                </div>
            </div>
            <div class="quills-split-col quills-split-text-col">
                <h2 class="quills-slab-heading"><?php echo esc_html( $genuine_care_title ); ?></h2>
                <div class="quills-body-text">
                    <p><?php echo esc_html( $genuine_care_content ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. CONTINUOUS CRAFT (Text Left, Image Right - Zigzag) -->
    <section class="quills-section quills-split-section quills-continuous-craft">
        <div class="quills-split-grid quills-grid-reverse">
            <div class="quills-split-col quills-split-text-col">
                <h2 class="quills-slab-heading"><?php echo esc_html( $craft_title ); ?></h2>
                <div class="quills-body-text">
                    <p><?php echo esc_html( $craft_content ); ?></p>
                </div>
            </div>
            <div class="quills-split-col quills-split-image-col">
                <div class="quills-image-wrapper">
                    <img src="<?php echo esc_url( $craft_img ); ?>" alt="<?php echo esc_attr( $craft_title ); ?>" loading="lazy" />
                </div>
            </div>
        </div>
    </section>

    <!-- 8. CREATIVE EDUCATION (Image Left, Text Right) -->
    <section class="quills-section quills-split-section quills-creative-education">
        <div class="quills-split-grid">
            <div class="quills-split-col quills-split-image-col">
                <div class="quills-image-wrapper">
                    <img src="<?php echo esc_url( $edu_img ); ?>" alt="<?php echo esc_attr( $edu_title ); ?>" loading="lazy" />
                </div>
            </div>
            <div class="quills-split-col quills-split-text-col">
                <h2 class="quills-slab-heading"><?php echo esc_html( $edu_title ); ?></h2>
                <div class="quills-body-text">
                    <p><?php echo esc_html( $edu_content ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. WHERE WE'RE GOING (Founder Quote & Vision) -->
    <section class="quills-section quills-where-going-section">
        <div class="quills-inner-narrow text-center">
            <h2 class="quills-serif-heading"><?php echo esc_html( $where_going_title ); ?></h2>
            <div class="quills-founder-quote">
                <p><?php echo esc_html( $where_going_quote ); ?></p>
                <cite class="quills-quote-author"><?php echo esc_html( $where_going_author ); ?></cite>
            </div>
        </div>
    </section>

    <!-- 10. Bottom Banner (Nathan Quillo & Team Photo) -->
    <section class="quills-section quills-bottom-banner-section">
        <div class="quills-bottom-banner">
            <img src="<?php echo esc_url( $where_going_img ); ?>" alt="Quills Coffee Team at Origin" loading="lazy" />
        </div>
    </section>

</div>
