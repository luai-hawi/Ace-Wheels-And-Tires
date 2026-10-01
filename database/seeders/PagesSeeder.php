<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedHomePage();
        $this->seedAboutPage();
        $this->seedFaqsPage();
        $this->seedAreasWeServePage();
        $this->seedStaticPages();
        $this->seedFinancingPage();
        $this->seedContactPage();
        $this->seedServices();
        $this->seedTireSalesPage();
        $this->seedTireBalancingRotationsPage();
        $this->seedWheelsRimsPage();
        $this->seedTpmsCentersPage();
        $this->seedBasicDiagnosticsPage();
        $this->seedWheelAlignmentPage();
        $this->seedOilChangePage();
        $this->seedTrailerUtilityTiresPage();
        $this->seedEighteenWheelerTireSalesPage();
        $this->seedGreenwoodServiceAreaPage();
        $this->seedShreveportServiceAreaPage();
        $this->seedMarshallServiceAreaPage();
        $this->seedWaskomServiceAreaPage();
        $this->seedBlanchardServiceAreaPage();
        $this->seedKeithvilleServiceAreaPage();
        $this->seedServiceAreas();
        $this->seedBlog();
    }

    /**
     * Creates a section (and its cards/items) for a page. Centralising the
     * create-section-then-create-items steps here means every seed method
     * below reads as plain content data instead of repeating Eloquent calls.
     */
    private function addSection(Page $page, array $attributes, array $items = []): Section
    {
        $section = $page->sections()->create($attributes + [
            'sort_order' => $page->sections()->count(),
        ]);

        foreach ($items as $index => $item) {
            $section->items()->create($item + ['sort_order' => $index]);
        }

        return $section;
    }

    private function seedHomePage(): void
    {
        $home = Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'type' => Page::TYPE_PAGE,
                'title' => 'Home',
                'excerpt' => 'Fast tire sales, balancing, rotations, and repairs at Ace Wheels and Tires.',
                'meta_title' => 'Best Tire & Automotive Repair Services | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get fast tire sales, balancing, rotations, and repairs at Ace Wheels and Tires. Walk in today for reliable service and military discounts!',
                'is_published' => true,
                'show_in_menu' => false,
            ]
        );

        $home->sections()->delete();

        $this->addSection($home, [
            'type' => 'hero',
            'heading' => 'Get Fast Walk-In Tire Service',
            'body' => '<p>We price match a competitor\'s quote!</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'image',
            'background_image' => 'section-items/home/hero-bg.jpg',
            'background_overlay' => 75,
            'animation' => 'fade-up',
        ]);

        $this->addSection($home, [
            'type' => 'card_grid',
            'background' => 'light',
            'animation' => 'fade-up',
        ], [
            ['heading' => 'Tire Sales', 'placeholder_key' => 'Tire Sales', 'image_path' => 'section-items/home/gallery-tire-sales.jpg', 'button_text' => 'Learn More', 'button_url' => '/tire-sales'],
            ['heading' => 'Tire Balancing & Rotations', 'placeholder_key' => 'Tire Balancing', 'image_path' => 'section-items/home/gallery-tire-balancing.jpeg', 'button_text' => 'Learn More', 'button_url' => '/tire-balancing-rotations'],
            ['heading' => 'Wheels & Rims', 'placeholder_key' => 'Wheels & Rims', 'image_path' => 'section-items/home/gallery-wheels-rims.jpeg', 'button_text' => 'Learn More', 'button_url' => '/wheels-rims'],
            ['heading' => 'TPMS Centers', 'placeholder_key' => 'TPMS Centers', 'image_path' => 'section-items/home/gallery-tpms.jpeg', 'button_text' => 'Learn More', 'button_url' => '/tpms-centers'],
            ['heading' => 'Oil Change', 'placeholder_key' => 'Oil Change', 'image_path' => 'section-items/home/gallery-oil-change.jpeg', 'button_text' => 'Learn More', 'button_url' => '/oil-change'],
            // 18-Wheeler Tire Sales photo on the live site is a licensed Shutterstock image — left as a
            // placeholder since we don't have confirmation that license can be reused on this new domain.
            ['heading' => '18-Wheeler Tire Sales', 'placeholder_key' => '18-Wheeler Tires', 'button_text' => 'Learn More', 'button_url' => '/18-wheeler-tire-sales'],
        ]);

        $this->addSection($home, [
            'type' => 'richtext',
            'heading' => 'Authorized Goodyear & Cooper Tire Dealer',
            'body' => '<p>Ace Wheels & Tires is an authorized dealer for Goodyear and Cooper Tires, providing access '
                . 'to manufacturer-backed tire warranties and support. We carry a wide selection of tire brands to fit '
                . 'different vehicles, driving needs, and budgets, so you\'re never limited to just one manufacturer. Our '
                . 'team can help you compare options and find the right tires for your vehicle. Additional fees for '
                . 'mounting, balancing, disposal, sensors, or other services may apply. Manufacturer warranty coverage '
                . 'varies by tire and brand.</p>',
            'button_text' => 'Learn more',
            'button_url' => '/contact',
            'layout' => 'image-right',
            'background' => 'light',
            'data' => ['video_url' => 'https://vid.cdn-website.com/132c0711/videos/y5rYwQklSuOwTvsTRBg4_9737957-uhd_3840_2160_24fps-v.mp4'],
        ], [
            ['placeholder_key' => 'Authorized Dealer Video'],
        ]);

        $this->addSection($home, [
            'type' => 'brand_logos',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Cooper Tire', 'heading' => 'Cooper Tire', 'image_path' => 'section-items/home/chatgpt-image-1.png', 'link_url' => 'https://www.coopertire.com/'],
            ['placeholder_key' => 'Goodyear', 'heading' => 'Goodyear', 'image_path' => 'section-items/home/chatgpt-image-2.png', 'link_url' => 'https://www.goodyear.com/'],
        ]);

        $this->addSection($home, [
            'type' => 'cta_banner',
            'heading' => 'Oil changes starting at $49.99',
            'body' => '<p>Full synthetic oil changes starting at $69.99 for the first 5 quarts.</p>',
            'button_text' => 'Contact Us Today!',
            'button_url' => '/contact',
            'background' => 'red',
        ]);

        $this->addSection($home, [
            'type' => 'brand_logos',
            'heading' => 'Flexible Financing Options',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Snap Finance', 'heading' => 'Snap Finance', 'image_path' => 'section-items/financing/snap-finance.jpeg', 'link_url' => 'https://www.snapfinance.com/'],
            ['placeholder_key' => 'Acima Lease', 'heading' => 'Acima', 'image_path' => 'section-items/home/acima-tire-image.png', 'link_url' => 'https://www.acima.com/'],
        ]);

        $this->addSection($home, [
            'type' => 'cta_banner',
            'heading' => 'Trusted Local Automotive Experts',
            'subheading' => 'We treat every vehicle like our own with quality service.',
            'background' => 'image',
            'background_image' => 'section-items/home/trusted-local-experts-bg.jpeg',
        ]);

        $this->addSection($home, [
            'type' => 'richtext',
            'heading' => 'Experience Fast Walk-In Automotive Service',
            'subheading' => 'Find Automotive Repair in Greenwood. Also welcoming clients from Shreveport, LA',
            'body' => '<p>When you need reliable automotive service without the wait, Ace Wheels and Tires delivers the '
                . 'fastest service in town. We specialize in walk-in tire sales, repairs, and automotive maintenance for '
                . 'drivers throughout Greenwood, proudly serving clients from Shreveport, LA, and the surrounding areas. '
                . 'Our team has built a reputation for quick turnaround times and competitive pricing that keeps customers '
                . 'coming back.</p><p>You\'ll appreciate our straightforward approach to automotive service — we provide '
                . 'clear estimates, quality work, and honest communication from start to finish. With industry experience '
                . 'dating back to 2014, we\'ve established trusted relationships with customers across Marshall, Keithville, '
                . 'and Blanchard by focusing on reliability and value.</p><p>Stop by today — no appointment needed for most '
                . 'services and experience our friendly, efficient service firsthand.</p>',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Shop Front', 'image_path' => 'section-items/home/shop-front.jpg'],
            ['placeholder_key' => 'Tire Tread Close Up', 'image_path' => 'section-items/home/tire-tread-close-up.jpg'],
        ]);

        $this->addSection($home, [
            'type' => 'richtext',
            'heading' => 'Complete Automotive Services for Your Vehicle',
            'subheading' => 'Whether you need new tires, routine maintenance, or diagnostic work, we provide comprehensive automotive solutions.',
            'body' => '<p>Our walk-in service means you don\'t have to plan ahead for most repairs and maintenance needs. '
                . 'Here\'s what our process includes:</p><ul>'
                . '<li>New and used tire sales with competitive pricing and quality options</li>'
                . '<li>Professional tire repair, balancing, and rotation services</li>'
                . '<li>Complete brake and rotor service plus quick oil changes</li>'
                . '<li>Wheel alignments and diagnostics serving Greenwood area drivers</li>'
                . '</ul><p>Contact us today to experience fast, reliable automotive service in Greenwood.</p>',
            'button_text' => 'Contact Us',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($home, [
            'type' => 'cta_banner',
            'heading' => 'Why Greenwood Drivers Choose Ace Wheels and Tires',
            'body' => '<p>Ace Wheels and Tires has earned recognition as the fastest service provider in town, with our '
                . 'team completing most services while you wait since opening in 2022. You\'ll experience transparent '
                . 'pricing, military discounts, and the confidence that comes from working with technicians who\'ve been '
                . 'perfecting their craft for nearly a decade.</p><p>Stop by today at 9025 Greenwood Rd, in Greenwood — '
                . 'no appointment needed for most services!</p>',
            'button_text' => 'Get a Quote',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);

        $this->addSection($home, [
            'type' => 'map_areas',
            'heading' => 'The Areas We Serve',
            'data' => ['map_embed_url' => 'https://www.google.com/maps/d/u/0/embed?mid=1uctROha2JIJQQC83Dd56yeuDEvXzXBc&ehbc=2E312F&noprof=1'],
            'background' => 'light',
        ], $this->serviceAreaCards());

        $this->addSection($home, [
            'type' => 'testimonial_slider',
            'heading' => 'See what our clients are saying',
            'background' => 'dark',
        ], [
            [
                'heading' => 'Cory P.',
                'subheading' => 'Verified Customer',
                'rating' => 5,
                'body' => 'I got some new tires put on my dually, the tech accidentally gouged my aluminum wheel taking '
                    . 'a tire off. But they didn\'t try to hide it, they were very honest and upfront. Yusuf ordered a '
                    . 'replacement wheel and kept in contact with me through the replacement process. These guys are '
                    . 'awesome. I will definitely be using this tire shop from now on.',
            ],
            [
                'heading' => 'Pamela M.',
                'subheading' => 'Verified Customer',
                'rating' => 5,
                'body' => 'Best tire shop around. Very easy to get in and out. The workers are awesome very intelligent '
                    . 'young men and they know what they\'re doing. Thank you for your help. Also bought a car from the '
                    . 'owner. He\'s a very sweet spiritual man. No complaints!!',
            ],
            [
                'heading' => 'Kaleigh',
                'subheading' => 'Verified Customer',
                'rating' => 5,
                'body' => 'I definitely recommend this place! Always very good prices and very friendly staff. Always '
                    . 'helps me out when I need it! Always in and out super quick!',
            ],
            [
                'heading' => 'Shelby C.',
                'subheading' => 'Verified Customer',
                'rating' => 5,
                'body' => 'Great place to do business. I stopped by for a quick oil change and got a tire sensor replaced '
                    . 'and reprogrammed at the same time. Yusef and his staff were friendly and the facility is spot on '
                    . 'clean. Shop local and give them a try.',
            ],
        ]);
    }

    /** @return array<int, array<string, mixed>> */
    private function serviceAreaCards(): array
    {
        return collect($this->serviceAreas())
            ->map(fn(array $area) => [
                'heading' => $area['title'],
                'button_url' => '/service-area/' . $area['slug'],
            ])
            ->all();
    }

    /** About Us — seeded from the real page HTML the client sent. */
    private function seedAboutPage(): void
    {
        $about = Page::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'type' => Page::TYPE_PAGE,
                'title' => 'About Us',
                'excerpt' => 'Ace Wheels and Tires offers fast tire & automotive services. Visit us for repairs, balancing, and more. Trust our experienced team today!',
                'meta_title' => 'About Us | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Ace Wheels and Tires offers fast tire & automotive services. Visit us for repairs, balancing, and more. Trust our experienced team today!',
                'is_published' => true,
                'show_in_menu' => true,
                'menu_order' => 2,
            ]
        );

        $about->sections()->delete();

        $this->addSection($about, [
            'type' => 'richtext',
            'heading' => 'About Ace Wheels and Tires in Greenwood',
            'subheading' => 'Who We Are',
            'body' => '<p>Since 2014, Ace Wheels and Tires has brought extensive automotive expertise to Greenwood, '
                . 'Louisiana, officially opening our doors in 2022 to serve families and businesses throughout the region. '
                . 'With years of hands-on experience working on both classic vehicles and modern models, we\'ve built our '
                . 'reputation on precision, pride, and attention to detail. At Ace Wheels and Tires, we believe in treating '
                . 'every vehicle like our own—because your ride deserves nothing less than excellence.</p>'
                . '<p>Our commitment to fast turnaround times and competitive pricing has made us a trusted choice for '
                . 'drivers across Louisiana and Texas.</p>'
                . '<p>See why families across Greenwood trust Ace Wheels and Tires for their automotive needs.</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Ace Wheels and Tires Storefront', 'image_path' => 'section-items/about/storefront.jpg'],
        ]);

        $this->addSection($about, [
            'type' => 'richtext',
            'subheading' => 'Our Story',
            'body' => '<p>Our journey began in the automotive industry back in 2014, gaining valuable experience before '
                . 'officially launching Ace Wheels and Tires in 2022. We opened our shop to provide Greenwood with honest, '
                . 'dependable tire and wheel services backed by nearly a decade of hands-on expertise. Over the years, '
                . 'we\'ve grown through word of mouth and the trust of drivers who appreciate quality workmanship and fair '
                . 'pricing.</p>'
                . '<p>As a locally owned and operated business, we\'re proud to support our community with military '
                . 'discounts and genuine care for every customer who walks through our doors. We\'re guided by our motto: '
                . '&ldquo;First you drive it, and then it drives you.&rdquo;</p>'
                . '<p>Get to know our team and values today.</p>',
            'layout' => 'image-left',
            'background' => 'light',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
        ], [
            ['placeholder_key' => 'The Ace Wheels and Tires Team', 'image_path' => 'section-items/home/shop-front.jpg'],
        ]);

        $this->addSection($about, [
            'type' => 'cta_banner',
            'heading' => 'Why Customers Trust Us',
            'body' => '<p>Our experienced team knows the roads from Greenwood to Marshall, and we approach each project '
                . 'with the same dedication we\'d want for our own vehicles. Whether you\'re driving a classic car or the '
                . 'latest model, you can count on our expertise to keep you rolling safely.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($about, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'Experience',
                'placeholder_key' => 'Experience',
                'icon' => 'heroicon-s-academic-cap',
                'body' => 'Nearly a decade in the automotive industry with specialized knowledge of both vintage and contemporary vehicles.',
            ],
            [
                'heading' => 'Our Values',
                'placeholder_key' => 'Our Values',
                'icon' => 'heroicon-s-heart',
                'body' => 'Precision, pride, and attention to detail guide everything we do.',
            ],
            [
                'heading' => 'Local Focus',
                'placeholder_key' => 'Local Focus',
                'icon' => 'heroicon-s-map-pin',
                'body' => 'Serving Greenwood, Keithville, Bethany, Mooringsport, Shreveport, Blanchard, Waskom, and Marshall with understanding of regional driving conditions.',
            ],
            [
                'heading' => 'What Sets Us Apart',
                'placeholder_key' => 'What Sets Us Apart',
                'icon' => 'heroicon-s-star',
                'body' => 'Known for fast turnaround times, competitive pricing, and treating every vehicle like our own.',
            ],
            [
                'heading' => 'Community Role',
                'placeholder_key' => 'Community Role',
                'icon' => 'heroicon-s-user-group',
                'body' => 'Proud to offer military discounts as part of our commitment to those who serve.',
            ],
        ]);

        $this->addSection($about, [
            'type' => 'cta_banner',
            'body' => '<p>Your vehicle deserves the attention of proven experts. With years of automotive experience, Ace '
                . 'Wheels and Tires is ready to help keep you on the road safely. We deliver results designed to last, and '
                . 'you can feel confident choosing us. Learn more about our story—or stop in today and meet the team '
                . 'behind Greenwood\'s fastest tire shop.</p>',
            'background' => 'dark',
        ]);
    }
    /** FAQs — seeded from the real page HTML the client sent (12 real Q&A pairs). */
    private function seedFaqsPage(): void
    {
        $faqs = Page::updateOrCreate(
            ['slug' => 'faqs'],
            [
                'type' => Page::TYPE_PAGE,
                'title' => 'FAQs',
                'excerpt' => 'Get fast tire & automotive repair services at Ace Wheels and Tires. Walk in for quality care and military discounts!',
                'meta_title' => "FAQ's | Ace Wheels and Tires | Greenwood & Shreveport, LA",
                'meta_description' => 'Get fast tire & automotive repair services at Ace Wheels and Tires. Walk in for quality care and military discounts!',
                'is_published' => true,
                'show_in_menu' => true,
                'menu_order' => 4,
            ]
        );

        $faqs->sections()->delete();

        $this->addSection($faqs, [
            'type' => 'hero',
            'heading' => 'Frequently Asked Questions',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($faqs, [
            'type' => 'faq_accordion',
            'background' => 'light',
        ], [
            ['heading' => 'Do you require appointments?', 'body' => 'No appointment needed for most services. We offer fast walk-in service daily. Wheel alignments are by appointment only.'],
            ['heading' => 'How long have you been in business?', 'body' => 'Ace Wheels and Tires opened in 2022 with industry experience dating back to 2014. We bring years of automotive expertise.'],
            ['heading' => 'Do you offer military discounts?', 'body' => 'Yes, we proudly offer a military discount as part of our community commitment. Ask our team for details.'],
            ['heading' => 'What areas do you serve?', 'body' => 'We serve Greenwood, Shreveport, Marshall, Waskom, Blanchard, and Keithville. Located in Greenwood with walk-in service available.'],
            ['heading' => 'Can you fix flat tires?', 'body' => 'Yes, we provide fast flat tire repairs, patching, and resealing. We handle punctures, leaks, and valve issues on-site.'],
            ['heading' => 'Do you sell used tires?', 'body' => 'Yes, we carry quality used tires that meet strict safety and tread standards. Each tire is inspected and pressure-tested.'],
            ['heading' => 'What\'s included with oil changes?', 'body' => 'Oil changes include trusted brands and filters, plus free fluid and tire pressure checks. Same-day, walk-in service available.'],
            ['heading' => 'How often should I rotate tires?', 'body' => 'We recommend tire rotations every 5,000–6,000 miles. This prevents uneven wear and improves ride comfort and tire life.'],
            ['heading' => 'Can you fix TPMS lights?', 'body' => 'Yes, we offer TPMS testing, resets, and sensor replacements. We solve low-pressure light issues quickly and accurately.'],
            ['heading' => 'Do you work on older vehicles?', 'body' => 'Yes, we\'re experienced with both classic vehicles and modern models. Every vehicle is treated with precision and care.'],
            ['heading' => 'How do wheel alignments work?', 'body' => 'We schedule wheel alignments through our trusted third-party partner. Coordination is handled directly by our team for convenience.'],
            ['heading' => 'Can you check engine codes?', 'body' => 'Yes, we provide engine code scanning and basic diagnostic checks. Walk-in testing available daily without unnecessary upsells.'],
        ]);
    }

    /** Areas We Serve overview — seeded from the real page HTML the client sent. */
    private function seedAreasWeServePage(): void
    {
        $areas = Page::updateOrCreate(
            ['slug' => 'areas-we-serve'],
            [
                'type' => Page::TYPE_PAGE,
                'title' => 'Areas We Serve',
                'excerpt' => 'Get reliable tire & automotive repair services, including balancing, rotation, and diagnostics. Visit us for fast service today!',
                'meta_title' => 'Areas We Serve | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get reliable tire & automotive repair services, including balancing, rotation, and diagnostics. Visit us for fast service today!',
                'is_published' => true,
                'show_in_menu' => true,
                'menu_order' => 3,
            ]
        );

        $areas->sections()->delete();

        $this->addSection($areas, [
            'type' => 'hero',
            'heading' => 'Areas We Serve',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($areas, [
            'type' => 'gallery',
            'background' => 'light',
        ], $this->serviceAreaCards());
    }
    private function seedStaticPages(): void
    {
        // "Blog" is its own page (type=page) so it can have an intro section above the post list.
        Page::updateOrCreate(
            ['slug' => 'blog'],
            [
                'type' => Page::TYPE_PAGE,
                'title' => 'Blog',
                'excerpt' => 'Tire and automotive tips from the Ace Wheels and Tires team.',
                'is_published' => true,
                'show_in_menu' => true,
                'menu_order' => 5,
            ]
        )->sections()->delete();

        $blog = Page::where('slug', 'blog')->first();
        $this->addSection($blog, [
            'type' => 'hero',
            'heading' => 'Blog',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);
    }

    /** Financing — seeded from the real page HTML the client sent. */
    private function seedFinancingPage(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'financing'],
            [
                'type' => Page::TYPE_PAGE,
                'title' => 'Financing',
                'excerpt' => 'Flexible financing and leasing options through Snap Finance and Acima.',
                'is_published' => true,
                'show_in_menu' => true,
                'menu_order' => 6,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'Financing Options',
            'button_text' => 'Have Questions? Contact Us!',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'Snap Finance',
                'placeholder_key' => 'Snap Finance',
                'image_path' => 'section-items/financing/snap-finance.jpeg',
                'button_text' => 'Learn More',
                'button_url' => 'https://getsnap.snapfinance.com/lease/en-US/consumer/apply/landing',
            ],
            [
                'heading' => 'Acima',
                'placeholder_key' => 'Acima',
                'image_path' => 'section-items/home/acima-tire-image.png',
                'button_text' => 'Learn More',
                'button_url' => 'https://apply.acima.com/lease?utm_source=web&utm_medium=merchant&merchant_guid=merc-9685f07d-7846-4aa6-94bb-a9030596263e&lang=en',
            ],
        ]);
    }

    /** Contact — seeded from the real page HTML the client sent. */
    private function seedContactPage(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'type' => Page::TYPE_PAGE,
                'title' => 'Contact',
                'excerpt' => 'Get in touch with Ace Wheels and Tires or request service.',
                'is_published' => true,
                'show_in_menu' => true,
                'menu_order' => 7,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'Find Tire Service in Greenwood, LA',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Contact Ace Wheels and Tires Today',
            'body' => '<p>Thank you for visiting the website of Ace Wheels and Tires.</p>'
                . '<p>Please use the form below to email us. You can also call (318) 891-8173 to speak with us '
                . 'immediately.</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Contact Us', 'image_path' => 'section-items/contact/contact-wheel.jpeg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Financing Options',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'Snap Finance',
                'placeholder_key' => 'Snap Finance',
                'image_path' => 'section-items/financing/snap-finance.jpeg',
                'button_text' => 'Learn More',
                'button_url' => 'https://getsnap.snapfinance.com/lease/en-US/consumer/apply/landing',
            ],
            [
                'heading' => 'Acima',
                'placeholder_key' => 'Acima',
                'image_path' => 'section-items/home/acima-tire-image.png',
                'button_text' => 'Learn More',
                'button_url' => 'https://apply.acima.com/lease?utm_source=web&utm_medium=merchant&merchant_guid=merc-9685f07d-7846-4aa6-94bb-a9030596263e&lang=en',
            ],
        ]);
    }

    /** @return array<int, array{title: string, slug: string, excerpt: string, meta_title?: string, meta_description?: string}> */
    private function services(): array
    {
        return [
            ['title' => 'Tire Sales', 'slug' => 'tire-sales', 'excerpt' => 'New and used tires from trusted brands at competitive prices.'],
            [
                'title' => 'Tire Balancing & Rotations',
                'slug' => 'tire-balancing-rotations',
                'excerpt' => 'Get expert tire balancing & rotation services to enhance ride comfort and extend tire life. Visit us for quick, reliable service today!',
                'meta_title' => 'Arrange Tire Balancing & Rotations | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get expert tire balancing & rotation services to enhance ride comfort and extend tire life. Visit us for quick, reliable service today!',
            ],
            ['title' => 'Wheels & Rims', 'slug' => 'wheels-rims', 'excerpt' => 'Get custom wheels & rims with expert installation and tire services. Visit Ace Wheels and Tires for fast, reliable automotive care.', 'meta_title' => 'Acquire Custom Wheels & Rims | Ace Wheels and Tires | Greenwood & Shreveport, LA', 'meta_description' => 'Get custom wheels & rims with expert installation and tire services. Visit Ace Wheels and Tires for fast, reliable automotive care.'],
            ['title' => 'TPMS Centers', 'slug' => 'tpms-centers', 'excerpt' => 'Get quick TPMS testing & tire services at Ace Wheels and Tires. Our experts ensure your safety with reliable diagnostics. Schedule today!', 'meta_title' => 'Visit Us For TPMS Testing | Ace Wheels and Tires | Greenwood & Shreveport, LA', 'meta_description' => 'Get quick TPMS testing & tire services at Ace Wheels and Tires. Our experts ensure your safety with reliable diagnostics. Schedule today!'],
            ['title' => 'Basic Diagnostics', 'slug' => 'basic-diagnostics', 'excerpt' => 'Get fast, honest engine diagnostics & code scanning at Ace Wheels and Tires. Walk in today for clear assessments without upselling.', 'meta_title' => 'Ask For Engine Diagnostics | Ace Wheels and Tires | Greenwood & Shreveport, LA', 'meta_description' => 'Get fast, honest engine diagnostics & code scanning at Ace Wheels and Tires. Walk in today for clear assessments without upselling.'],
            ['title' => 'Wheel Alignment', 'slug' => 'wheel-alignment', 'excerpt' => 'Get expert wheel alignment for optimal vehicle performance. Trust Ace Wheels and Tires for seamless service. Schedule your appointment today!', 'meta_title' => 'Schedule Wheel Alignment Services | Ace Wheels and Tires | Greenwood & Shreveport, LA', 'meta_description' => 'Get expert wheel alignment for optimal vehicle performance. Trust Ace Wheels and Tires for seamless service. Schedule your appointment today!'],
            ['title' => 'Oil Change', 'slug' => 'oil-change', 'excerpt' => 'Get quick oil changes at Ace Wheels & Tires. Starting at $49.99, our experts enhance engine performance. Walk-ins welcome!', 'meta_title' => 'Oil Change | Ace Wheels and Tires | Greenwood & Shreveport, LA', 'meta_description' => 'Get quick oil changes at Ace Wheels & Tires. Starting at $49.99, our experts enhance engine performance. Walk-ins welcome!'],
            ['title' => 'Trailer/Utility Tires', 'slug' => 'trailer-utility-tires', 'excerpt' => 'Get reliable trailer & utility tires at Ace Wheels & Tires. We offer installation, balancing, & expert service. Visit us today!', 'meta_title' => 'Trailer/Utility Tires | Ace Wheels and Tires | Greenwood & Shreveport, LA', 'meta_description' => 'Get reliable trailer & utility tires at Ace Wheels & Tires. We offer installation, balancing, & expert service. Visit us today!'],
            [
                'title' => '18-Wheeler Tire Sales',
                'slug' => '18-wheeler-tire-sales',
                'excerpt' => 'Get quality 18-wheeler tires & services at Ace Wheels and Tires. Enjoy fast service & competitive pricing. Walk-ins welcome!',
                'meta_title' => '18-Wheeler Tire Sales | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get quality 18-wheeler tires & services at Ace Wheels and Tires. Enjoy fast service & competitive pricing. Walk-ins welcome!',
            ],
        ];
    }

    private function seedServices(): void
    {
        $servicesParent = Page::updateOrCreate(
            ['slug' => 'our-services'],
            [
                'type' => Page::TYPE_PAGE,
                'title' => 'Our Services',
                'is_published' => true,
                'show_in_menu' => false,
            ]
        );

        foreach ($this->services() as $order => $data) {
            // Tire Sales, Tire Balancing & Rotations, Wheels & Rims, TPMS Centers, Basic Diagnostics, Wheel Alignment, Oil Change, Trailer/Utility Tires, and 18-Wheeler Tire Sales have their own dedicated methods with real client content.
            if (in_array($data['slug'], ['tire-sales', 'tire-balancing-rotations', 'wheels-rims', 'tpms-centers', 'basic-diagnostics', 'wheel-alignment', 'oil-change', 'trailer-utility-tires', '18-wheeler-tire-sales'], true)) {
                continue;
            }

            $page = Page::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'type' => Page::TYPE_SERVICE,
                    'parent_id' => $servicesParent->id,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'meta_title' => $data['meta_title'] ?? null,
                    'meta_description' => $data['meta_description'] ?? null,
                    'is_published' => true,
                    'show_in_menu' => false,
                    'menu_order' => $order,
                ]
            );

            $page->sections()->delete();

            $this->addSection($page, [
                'type' => 'hero',
                'heading' => $data['title'],
                'body' => '<p>' . $data['excerpt'] . '</p>',
                'button_text' => 'Request Service',
                'button_url' => '/contact',
                'background' => 'dark',
            ]);

            $this->addSection($page, [
                'type' => 'richtext',
                'heading' => 'What\'s Included',
                'body' => '<p>' . $data['excerpt'] . ' Walk in today — no appointment needed for most services, and our '
                    . 'team will walk you through pricing before any work begins.</p>',
                'background' => 'light',
            ], [
                ['placeholder_key' => $data['title']],
            ]);

            $this->addSection($page, [
                'type' => 'cta_banner',
                'heading' => 'Ready to get started?',
                'body' => '<p>Stop by 9025 Greenwood Rd or request service online.</p>',
                'button_text' => 'Contact Us',
                'button_url' => '/contact',
                'background' => 'red',
            ]);
        }
    }

    /** Tire Sales — seeded from the real page HTML the client sent. */
    private function seedTireSalesPage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'tire-sales'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => 'Tire Sales',
                'excerpt' => 'Ace Wheels and Tires offers a wide selection of tires & quick installation. Visit us for expert tire services today!',
                'meta_title' => 'Turn To Us For Tire Sales | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Ace Wheels and Tires offers a wide selection of tires & quick installation. Visit us for expert tire services today!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 0,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Turn to us for Tire Sales in Greenwood, also welcoming Clients from Shreveport, LA',
            'subheading' => 'Request the Right Tires for Your Vehicle',
            'body' => '<p>When your tires are worn or damaged, finding the right replacement quickly becomes a priority '
                . 'that affects your safety and daily routine in Greenwood. You need a wide selection of new tires for '
                . 'all makes and models at competitive prices, backed by technicians who ensure proper fit, pressure, '
                . 'and balance for long tire life and smooth driving.</p>'
                . '<p>Ace Wheels and Tires offers expert help choosing top brands based on your specific vehicle type '
                . 'and budget.</p>'
                . '<p>Local drivers throughout Greenwood, Shreveport, and surrounding areas rely on their speed, '
                . 'honesty, and value, with walk-in availability that fits your busy schedule.</p>'
                . '<p>Stop by today to get new tires in Greenwood with same-day service available.</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Tires in Storage', 'image_path' => 'section-items/tire-sales/tires-in-storage.jpeg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'subheading' => 'How Does Professional Tire Sales Work in Greenwood?',
            'body' => '<p>The tire selection process begins with assessing your vehicle\'s specifications, driving '
                . 'habits, and budget to recommend the best options from top tire brands. You\'ll receive guidance on '
                . 'tread patterns, tire compounds, and sizing that match your specific needs, whether you drive a '
                . 'sedan, truck, or SUV through Greenwood\'s roads.</p>'
                . '<p>During installation, technicians focus on proper mounting, balancing, and pressure settings that '
                . 'maximize tire performance and longevity. They handle the technical details while you wait, ensuring '
                . 'each tire meets safety standards and manufacturer specifications for optimal driving experience.</p>'
                . '<p>The process includes final pressure checks and balance verification, so you leave with tires '
                . 'that deliver smooth, safe performance from day one.</p>'
                . '<p>Visit us now for quick installation and same-day tire service in Greenwood. We also welcome '
                . 'Clients from Shreveport, LA.</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Financing Options',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'light',
        ], [
            [
                'heading' => 'Snap Finance',
                'placeholder_key' => 'Snap Finance',
                'image_path' => 'section-items/financing/snap-finance.jpeg',
                'button_text' => 'Learn More',
                'button_url' => 'https://getsnap.snapfinance.com/lease/en-US/consumer/apply/landing',
            ],
            [
                'heading' => 'Acima',
                'placeholder_key' => 'Acima',
                'image_path' => 'section-items/home/acima-tire-image.png',
                'button_text' => 'Learn More',
                'button_url' => 'https://apply.acima.com/lease?utm_source=web&utm_medium=merchant&merchant_guid=merc-9685f07d-7846-4aa6-94bb-a9030596263e&lang=en',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'What Makes Our Tire Sales Different',
            'body' => '<p>Known for quick installation and same-day service, we prioritize getting you back on the '
                . 'road without lengthy delays or appointments.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'How do we ensure quality?',
                'placeholder_key' => 'Quality',
                'icon' => 'heroicon-s-shield-check',
                'body' => 'Each tire installation includes proper fit verification, precise pressure settings, and professional balancing for maximum tire life.',
            ],
            [
                'heading' => 'Why choose local?',
                'placeholder_key' => 'Local',
                'icon' => 'heroicon-s-map-pin',
                'body' => 'Greenwood drivers benefit from walk-in availability and personalized service that understands local driving conditions.',
            ],
            [
                'heading' => 'What\'s our selection approach?',
                'placeholder_key' => 'Selection',
                'icon' => 'heroicon-s-squares-2x2',
                'body' => 'We stock top tire brands across all price ranges, helping you find the perfect match for your vehicle type and budget.',
            ],
            [
                'heading' => 'How do we serve you faster?',
                'placeholder_key' => 'Speed',
                'icon' => 'heroicon-s-bolt',
                'body' => 'Same-day installation means you don\'t wait days for new tires when you need them most.',
            ],
            [
                'heading' => 'What\'s our commitment?',
                'placeholder_key' => 'Commitment',
                'icon' => 'heroicon-s-hand-thumb-up',
                'body' => 'Honest recommendations and competitive pricing ensure you get the best value for your tire investment.',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'body' => '<p>Experience the difference that speed, honesty, and value make for your tire needs. Need new '
                . 'tires today? Stop by Ace Wheels and Tires in Greenwood—no appointment required.</p>',
            'background' => 'dark',
        ]);
    }

    /** Tire Balancing & Rotations — seeded from the real page HTML the client sent. */
    private function seedTireBalancingRotationsPage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'tire-balancing-rotations'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => 'Tire Balancing & Rotations',
                'excerpt' => 'Get expert tire balancing & rotation services to enhance ride comfort and extend tire life. Visit us for quick, reliable service today!',
                'meta_title' => 'Arrange Tire Balancing & Rotations | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get expert tire balancing & rotation services to enhance ride comfort and extend tire life. Visit us for quick, reliable service today!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 1,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Arrange Tire Balancing & Rotations in Greenwood, proudly serving clients from Shreveport, LA',
            'subheading' => 'Extend Tire Life and Enhance Your Ride Comfort',
            'body' => '<p>Uneven tire wear and bumpy rides often signal your vehicle needs professional balancing and '
                . 'rotation services in Greenwood. You deserve smooth handling and maximum tire performance on '
                . 'Louisiana\'s varied road conditions.</p>'
                . '<p>Ace Wheels and Tires offers precision balancing and regular rotations for longer tire life.</p>'
                . '<p>Our comprehensive service helps prevent uneven wear and improve ride comfort while protecting '
                . 'your tire investment through expert care.</p>'
                . '<p>Call (318) 891-8173 today to schedule tire rotations in Greenwood.</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Tire Balancing', 'image_path' => 'section-items/tire-balancing-rotations/tire-balancing-hero.jpg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'subheading' => 'How Does Tire Balancing & Rotations Work in Greenwood?',
            'body' => '<p>Our precision balancing process identifies weight distribution issues and corrects them using '
                . 'professional equipment, while systematic rotation moves tires to different positions for even wear '
                . 'patterns. We recommend this service every 5,000–6,000 miles to maintain optimal performance.</p>'
                . '<p>You can expect thorough inspection of both new and used tires during your visit, with our '
                . 'trusted technicians explaining findings and providing same-day results. Ace Wheels and Tires '
                . 'combines technical expertise with transparent communication throughout the process.</p>'
                . '<p>Our quick walk-in service operates daily, ensuring you receive accurate diagnostics and '
                . 'professional care without lengthy appointments or unnecessary delays.</p>'
                . '<p>Stop by today for professional tire balancing & rotations in Greenwood, proudly serving clients '
                . 'from Shreveport, LA.</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Financing Options',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'light',
        ], [
            [
                'heading' => 'Snap Finance',
                'placeholder_key' => 'Snap Finance',
                'image_path' => 'section-items/financing/snap-finance.jpeg',
                'button_text' => 'Learn More',
                'button_url' => 'https://getsnap.snapfinance.com/lease/en-US/consumer/apply/landing',
            ],
            [
                'heading' => 'Acima',
                'placeholder_key' => 'Acima',
                'image_path' => 'section-items/home/acima-tire-image.png',
                'button_text' => 'Learn More',
                'button_url' => 'https://apply.acima.com/lease?utm_source=web&utm_medium=merchant&merchant_guid=merc-9685f07d-7846-4aa6-94bb-a9030596263e&lang=en',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'What Makes Us Different',
            'body' => '<p>Our reputation for accurate, same-day results sets us apart in the Greenwood automotive service landscape.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'How do we ensure quality?',
                'placeholder_key' => 'Quality',
                'icon' => 'heroicon-s-shield-check',
                'body' => 'Precision equipment paired with systematic inspection processes guarantee accurate weight distribution and proper rotation patterns.',
            ],
            [
                'heading' => 'What experience do we bring?',
                'placeholder_key' => 'Experience',
                'icon' => 'heroicon-s-academic-cap',
                'body' => 'Trusted technicians with extensive knowledge of both new and used tire maintenance requirements.',
            ],
            [
                'heading' => 'Why choose local?',
                'placeholder_key' => 'Local',
                'icon' => 'heroicon-s-map-pin',
                'body' => 'Greenwood drivers benefit from convenient walk-in service and understanding of local driving conditions affecting tire wear.',
            ],
            [
                'heading' => 'What\'s our approach?',
                'placeholder_key' => 'Approach',
                'icon' => 'heroicon-s-light-bulb',
                'body' => 'Quick turnaround times without compromising thoroughness, ensuring you get back on the road safely.',
            ],
            [
                'heading' => 'How do we protect your investment?',
                'placeholder_key' => 'Investment',
                'icon' => 'heroicon-s-banknotes',
                'body' => 'Regular maintenance schedules designed to maximize tire lifespan and maintain optimal vehicle performance.',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'body' => '<p>Keep your ride smooth and your tires lasting longer with professional service you can trust. '
                . 'Contact us today to schedule tire balancing & rotations in Greenwood. We are also welcoming Clients '
                . 'from Shreveport, LA.</p>',
            'background' => 'dark',
        ]);
    }

    /** Wheels & Rims — seeded from the real page HTML the client sent. */
    private function seedWheelsRimsPage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'wheels-rims'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => 'Wheels & Rims',
                'excerpt' => 'Get custom wheels & rims with expert installation and tire services. Visit Ace Wheels and Tires for fast, reliable automotive care.',
                'meta_title' => 'Acquire Custom Wheels & Rims | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get custom wheels & rims with expert installation and tire services. Visit Ace Wheels and Tires for fast, reliable automotive care.',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 2,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Acquire Custom Wheels & Rims in Greenwood, proudly serving clients from Shreveport, LA',
            'subheading' => 'Transform Your Vehicle\'s Style and Performance',
            'body' => '<p>Finding the perfect wheels and rims in Greenwood means balancing style preferences with '
                . 'performance needs for Louisiana\'s diverse driving conditions. You deserve expert guidance in '
                . 'selecting custom options that enhance both appearance and functionality.</p>'
                . '<p>Ace Wheels and Tires specializes in custom wheel and rim sales, mounting, and fitting.</p>'
                . '<p>Our comprehensive selection includes a variety of styles, finishes, and sizes for any vehicle '
                . 'type, ensuring perfect matches for both aesthetic goals and practical requirements.</p>'
                . '<p>Call (318) 891-8173 now to book wheel installation in Greenwood.</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Wheels and Rims', 'image_path' => 'section-items/wheels-rims/wheels-rims-hero.jpeg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'subheading' => 'Why Choose Professional Wheels & Rims in Greenwood?',
            'body' => '<p>Our step-by-step selection process begins with understanding your vehicle specifications and '
                . 'style preferences, followed by expert consultation on finish options and performance '
                . 'characteristics. We guide you through sizing considerations and compatibility requirements for '
                . 'optimal results.</p>'
                . '<p>You\'ll receive careful installation using professional mounting equipment, with our '
                . 'experienced team ensuring proper fit and balance for safety and performance. Ace Wheels and Tires '
                . 'maintains strict quality standards throughout the fitting process.</p>'
                . '<p>Our experts help customers find the right look and performance balance, whether you\'re '
                . 'seeking enhanced curb appeal or improved handling characteristics for Greenwood\'s roads.</p>'
                . '<p>Browse our selection today for professional wheels & rims in Greenwood. We are also welcoming '
                . 'Clients from Shreveport, LA.</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Financing Options',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'light',
        ], [
            [
                'heading' => 'Snap Finance',
                'placeholder_key' => 'Snap Finance',
                'image_path' => 'section-items/financing/snap-finance.jpeg',
                'button_text' => 'Learn More',
                'button_url' => 'https://getsnap.snapfinance.com/lease/en-US/consumer/apply/landing',
            ],
            [
                'heading' => 'Acima',
                'placeholder_key' => 'Acima',
                'image_path' => 'section-items/home/acima-tire-image.png',
                'button_text' => 'Learn More',
                'button_url' => 'https://apply.acima.com/lease?utm_source=web&utm_medium=merchant&merchant_guid=merc-9685f07d-7846-4aa6-94bb-a9030596263e&lang=en',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'What Should Greenwood Residents Expect',
            'body' => '<p>Our reputation for serving both car enthusiasts and everyday drivers reflects our commitment '
                . 'to meeting diverse customer needs with precision and care.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'What\'s included in the service?',
                'placeholder_key' => 'Included',
                'icon' => 'heroicon-s-clipboard-document-check',
                'body' => 'Complete consultation, professional mounting, precise fitting, and post-installation inspection for safety and performance.',
            ],
            [
                'heading' => 'How do we handle custom requests?',
                'placeholder_key' => 'Custom Requests',
                'icon' => 'heroicon-s-wrench-screwdriver',
                'body' => 'Expert guidance through style and finish options with careful attention to vehicle compatibility and performance requirements.',
            ],
            [
                'heading' => 'What makes our approach different?',
                'placeholder_key' => 'Approach',
                'icon' => 'heroicon-s-light-bulb',
                'body' => 'Fast turnaround times combined with meticulous installation processes ensure quality without unnecessary delays.',
            ],
            [
                'heading' => 'Why is local expertise important?',
                'placeholder_key' => 'Local Expertise',
                'icon' => 'heroicon-s-map-pin',
                'body' => 'Greenwood driving conditions require specific knowledge of wheel performance in Louisiana\'s climate and road surfaces.',
            ],
            [
                'heading' => 'How do we serve vehicle enthusiasts?',
                'placeholder_key' => 'Enthusiasts',
                'icon' => 'heroicon-s-sparkles',
                'body' => 'Specialized attention to both aesthetic goals and performance enhancement for discerning customers.',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'body' => '<p>Upgrade your ride with professional installation and expert guidance. Contact us today to '
                . 'schedule wheels & rims service in Greenwood.</p>',
            'background' => 'dark',
        ]);
    }

    /** TPMS Centers — seeded from the real page HTML the client sent. */
    private function seedTpmsCentersPage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'tpms-centers'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => 'TPMS Centers',
                'excerpt' => 'Get quick TPMS testing & tire services at Ace Wheels and Tires. Our experts ensure your safety with reliable diagnostics. Schedule today!',
                'meta_title' => 'Visit Us For TPMS Testing | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get quick TPMS testing & tire services at Ace Wheels and Tires. Our experts ensure your safety with reliable diagnostics. Schedule today!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 3,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Visit us for TPMS Testing in Greenwood, also welcoming Clients from Shreveport, LA.',
            'subheading' => 'Receive Quick Solutions for Tire Pressure Monitoring Issues',
            'body' => '<p>Persistent tire pressure warning lights and TPMS malfunctions create safety concerns and '
                . 'frustration for Greenwood drivers navigating Texas roads. You need accurate diagnostics and '
                . 'reliable repairs to maintain proper tire monitoring.</p>'
                . '<p>Ace Wheels and Tires offers Tire Pressure Monitoring System (TPMS) testing, resets, and sensor '
                . 'replacements.</p>'
                . '<p>Our comprehensive TPMS service solves low-pressure light issues quickly and accurately while '
                . 'helping extend tire life and improve safety through proper monitoring.</p>'
                . '<p>Come in today to get your tire pressured checked!</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'TPMS Tool', 'image_path' => 'section-items/tpms-centers/tpms-hero.jpg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'subheading' => 'How Does TPMS Service Work in Greenwood?',
            'body' => '<p>Our diagnostic process begins with comprehensive system scanning to identify sensor '
                . 'malfunctions, communication errors, or calibration issues affecting your tire pressure monitoring. '
                . 'We test individual sensors and evaluate system-wide functionality for complete assessment.</p>'
                . '<p>You can expect thorough explanation of findings and transparent recommendations for repairs or '
                . 'replacements based on your specific vehicle needs. Ace Wheels and Tires uses professional '
                . 'diagnostic equipment to ensure accurate results and proper system restoration.</p>'
                . '<p>Our experienced technicians work with all major makes and models, providing same-day service '
                . 'for most TPMS issues without lengthy diagnostic delays or unnecessary complexity.</p>'
                . '<p>Get your TPMS fixed today with professional service in Greenwood. We are also welcoming '
                . 'Clients from Shreveport, LA.</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'What Makes Us Different',
            'body' => '<p>Our reputation for speed and reliability in TPMS diagnostics serves Greenwood, Shreveport, and '
                . 'nearby communities with consistent, professional results.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'How do we ensure quality?',
                'placeholder_key' => 'Quality',
                'icon' => 'heroicon-s-shield-check',
                'body' => 'Professional diagnostic equipment combined with systematic testing procedures guarantee accurate identification of TPMS issues.',
            ],
            [
                'heading' => 'What experience do we bring?',
                'placeholder_key' => 'Experience',
                'icon' => 'heroicon-s-academic-cap',
                'body' => 'Extensive knowledge of major vehicle makes and models ensures proper service regardless of your car\'s specifications.',
            ],
            [
                'heading' => 'Why choose local?',
                'placeholder_key' => 'Local',
                'icon' => 'heroicon-s-map-pin',
                'body' => 'Greenwood drivers benefit from same-day service and understanding of regional driving conditions affecting tire pressure systems.',
            ],
            [
                'heading' => 'What\'s our approach?',
                'placeholder_key' => 'Approach',
                'icon' => 'heroicon-s-light-bulb',
                'body' => 'Quick diagnostics paired with clear explanations help you understand issues and make informed repair decisions.',
            ],
            [
                'heading' => 'How do we protect your safety?',
                'placeholder_key' => 'Safety',
                'icon' => 'heroicon-s-lifebuoy',
                'body' => 'Proper TPMS function ensures early warning of pressure loss, preventing dangerous blowouts on Texas highways.',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'body' => '<p>TPMS light causing concern? Get reliable diagnostics and fast repairs you can count on. Contact '
                . 'us today to schedule TPMS service in Greenwood.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Financing Options',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'light',
        ], [
            [
                'heading' => 'Snap Finance',
                'placeholder_key' => 'Snap Finance',
                'image_path' => 'section-items/financing/snap-finance.jpeg',
                'button_text' => 'Learn More',
                'button_url' => 'https://getsnap.snapfinance.com/lease/en-US/consumer/apply/landing',
            ],
            [
                'heading' => 'Acima',
                'placeholder_key' => 'Acima',
                'image_path' => 'section-items/home/acima-tire-image.png',
                'button_text' => 'Learn More',
                'button_url' => 'https://apply.acima.com/lease?utm_source=web&utm_medium=merchant&merchant_guid=merc-9685f07d-7846-4aa6-94bb-a9030596263e&lang=en',
            ],
        ]);
    }

    /** Basic Diagnostics — seeded from the real page HTML the client sent. */
    private function seedBasicDiagnosticsPage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'basic-diagnostics'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => 'Basic Diagnostics',
                'excerpt' => 'Get fast, honest engine diagnostics & code scanning at Ace Wheels and Tires. Walk in today for clear assessments without upselling.',
                'meta_title' => 'Ask For Engine Diagnostics | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get fast, honest engine diagnostics & code scanning at Ace Wheels and Tires. Walk in today for clear assessments without upselling.',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 4,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Ask for Engine Diagnostics in Greenwood, also welcoming Clients from Shreveport, LA',
            'subheading' => 'Unlock Fast, Honest Vehicle Code Scanning and Testing',
            'body' => '<p>Check engine lights and mysterious vehicle codes create uncertainty about repair needs and '
                . 'costs for Greenwood drivers dealing with automotive issues. You deserve transparent diagnostics '
                . 'that provide clear answers without unnecessary pressure or confusion.</p>'
                . '<p>Ace Wheels and Tires provides engine code scanning and basic diagnostic checks.</p>'
                . '<p>Our straightforward approach identifies issues quickly without unnecessary upsells, helping '
                . 'drivers make informed repair decisions fast through honest assessment and clear communication.</p>'
                . '<p>Call (318) 891-8173 now to book a check engine light service in Greenwood, proudly serving '
                . 'clients from Shreveport, LA.</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Engine Diagnostics', 'image_path' => 'section-items/basic-diagnostics/diagnostics-hero.jpeg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'subheading' => 'Why Choose Professional Basic Diagnostics in Greenwood?',
            'body' => '<p>Our diagnostic process uses professional scanning equipment to read error codes and identify '
                . 'system malfunctions affecting vehicle performance. We interpret results in plain language and '
                . 'explain potential causes without technical jargon or intimidating complexity.</p>'
                . '<p>You\'ll receive honest assessment of findings with transparent recommendations based on '
                . 'actual diagnostic results rather than assumptions or sales pressure. Ace Wheels and Tires '
                . 'prioritizes accuracy and customer education throughout the diagnostic process.</p>'
                . '<p>Our experience with both older and modern vehicle systems ensures reliable code '
                . 'interpretation regardless of your car\'s age or complexity, providing consistent results across '
                . 'diverse automotive technologies.</p>'
                . '<p>Schedule your diagnostic scan today for reliable basic diagnostics in Greenwood. We are also '
                . 'welcoming Clients from Shreveport, LA.</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'What Should Greenwood Residents Expect',
            'body' => '<p>Our commitment to transparency and speed has earned trust among Greenwood drivers seeking '
                . 'honest automotive diagnostics without unnecessary complications.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'What\'s included in the service?',
                'placeholder_key' => 'Included',
                'icon' => 'heroicon-s-clipboard-document-check',
                'body' => 'Comprehensive code scanning, clear interpretation of results, and honest recommendations without pressure or upselling tactics.',
            ],
            [
                'heading' => 'How do we handle different vehicle types?',
                'placeholder_key' => 'Vehicle Types',
                'icon' => 'heroicon-s-truck',
                'body' => 'Experienced diagnostic capabilities covering both older and modern vehicle systems ensure accurate results regardless of age.',
            ],
            [
                'heading' => 'What makes our approach different?',
                'placeholder_key' => 'Approach',
                'icon' => 'heroicon-s-light-bulb',
                'body' => 'Walk-in testing available daily with quick turnaround times and straightforward explanations you can understand.',
            ],
            [
                'heading' => 'Why is local expertise important?',
                'placeholder_key' => 'Local Expertise',
                'icon' => 'heroicon-s-map-pin',
                'body' => 'Greenwood drivers benefit from convenient access to honest diagnostics without traveling to larger cities for basic testing.',
            ],
            [
                'heading' => 'How do we help decision-making?',
                'placeholder_key' => 'Decision-Making',
                'icon' => 'heroicon-s-check-circle',
                'body' => 'Clear explanations of diagnostic findings help you understand repair priorities and make informed choices about vehicle maintenance.',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'body' => '<p>Check engine light causing worry? Get quick, affordable scanning with honest results you '
                . 'can trust. Contact us today to schedule basic diagnostics in Greenwood.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Financing Options',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'light',
        ], [
            [
                'heading' => 'Snap Finance',
                'placeholder_key' => 'Snap Finance',
                'image_path' => 'section-items/financing/snap-finance.jpeg',
                'button_text' => 'Learn More',
                'button_url' => 'https://getsnap.snapfinance.com/lease/en-US/consumer/apply/landing',
            ],
            [
                'heading' => 'Acima',
                'placeholder_key' => 'Acima',
                'image_path' => 'section-items/home/acima-tire-image.png',
                'button_text' => 'Learn More',
                'button_url' => 'https://apply.acima.com/lease?utm_source=web&utm_medium=merchant&merchant_guid=merc-9685f07d-7846-4aa6-94bb-a9030596263e&lang=en',
            ],
        ]);
    }

    /** Wheel Alignment — seeded from the real page HTML the client sent. */
    private function seedWheelAlignmentPage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'wheel-alignment'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => 'Wheel Alignment',
                'excerpt' => 'Get expert wheel alignment for optimal vehicle performance. Trust Ace Wheels and Tires for seamless service. Schedule your appointment today!',
                'meta_title' => 'Schedule Wheel Alignment Services | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get expert wheel alignment for optimal vehicle performance. Trust Ace Wheels and Tires for seamless service. Schedule your appointment today!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 5,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Schedule Wheel Alignment in Greenwood, proudly serving clients from Shreveport, LA',
            'subheading' => 'Ensure Seamless Coordination for Optimal Vehicle Performance',
            'body' => '<p>Poor wheel alignment causes uneven tire wear, steering problems, and safety concerns for '
                . 'Greenwood drivers navigating Louisiana\'s roads and highways. You need professional alignment '
                . 'service that ensures optimal handling and tire longevity through expert coordination.</p>'
                . '<p>Ace Wheels and Tires offers professional wheel alignment scheduling through a trusted '
                . 'third-party partner.</p>'
                . '<p>Our streamlined coordination process ensures optimal handling, tire wear, and safety while '
                . 'eliminating extra steps and simplifying the service experience for customers.</p>'
                . '<p>Call (318) 891-8173 today to schedule wheel alignment and ensure tire safety in Greenwood, '
                . 'proudly serving clients from Shreveport, LA.</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Wheel Alignment', 'image_path' => 'section-items/wheel-alignment/wheel-alignment-hero.jpeg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'subheading' => 'What\'s Included in Our Wheel Alignment Service',
            'body' => '<p>Our comprehensive coordination service handles all scheduling and communication with our '
                . 'trusted alignment partner, ensuring seamless service delivery without additional customer '
                . 'responsibilities. We manage the entire process from initial consultation through service '
                . 'completion.</p>'
                . '<p>You\'ll receive expert guidance on alignment timing and necessity based on your vehicle\'s '
                . 'condition and tire wear patterns. Ace Wheels and Tires coordinates directly with alignment '
                . 'specialists to ensure proper service scheduling and quality results.</p>'
                . '<p>The service works perfectly as an add-on after tire purchase or installation, providing '
                . 'complete wheel and tire care through coordinated professional services that complement our '
                . 'in-house capabilities.</p>'
                . '<p>Book your alignment coordination today for professional wheel alignment in Greenwood. We are '
                . 'also welcoming Clients from Shreveport, LA.</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'Greenwood Wheel Alignment Advantages',
            'body' => '<p>Our coordination service serves Greenwood and surrounding areas with streamlined access '
                . 'to professional alignment without the hassle of managing multiple service providers.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            [
                'heading' => 'Why choose coordinated service?',
                'placeholder_key' => 'Coordinated Service',
                'icon' => 'heroicon-s-arrows-right-left',
                'body' => 'Single point of contact eliminates confusion and ensures seamless communication between tire service and alignment specialists.',
            ],
            [
                'heading' => 'How do we ensure quality?',
                'placeholder_key' => 'Quality',
                'icon' => 'heroicon-s-shield-check',
                'body' => 'Partnerships with trusted alignment professionals guarantee proper service standards and reliable results for your vehicle.',
            ],
            [
                'heading' => 'What sets our coordination apart?',
                'placeholder_key' => 'Coordination',
                'icon' => 'heroicon-s-link',
                'body' => 'Direct handling by our team means no extra steps for customers—we manage scheduling, communication, and service coordination.',
            ],
            [
                'heading' => 'How do we serve Greenwood specifically?',
                'placeholder_key' => 'Local Service',
                'icon' => 'heroicon-s-map-pin',
                'body' => 'Local coordination expertise ensures convenient access to professional alignment services without traveling to distant locations.',
            ],
            [
                'heading' => 'Why combine with tire service?',
                'placeholder_key' => 'Combined Service',
                'icon' => 'heroicon-s-puzzle-piece',
                'body' => 'Perfect timing after tire installation ensures optimal performance and prevents premature wear on new tire investments.',
            ],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'body' => '<p>Experience hassle-free alignment coordination with trusted professionals and seamless '
                . 'service management. Contact us today to schedule wheel alignment in Greenwood.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Financing Options',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'light',
        ], [
            [
                'heading' => 'Snap Finance',
                'placeholder_key' => 'Snap Finance',
                'image_path' => 'section-items/financing/snap-finance.jpeg',
                'button_text' => 'Learn More',
                'button_url' => 'https://getsnap.snapfinance.com/lease/en-US/consumer/apply/landing',
            ],
            [
                'heading' => 'Acima',
                'placeholder_key' => 'Acima',
                'image_path' => 'section-items/home/acima-tire-image.png',
                'button_text' => 'Learn More',
                'button_url' => 'https://apply.acima.com/lease?utm_source=web&utm_medium=merchant&merchant_guid=merc-9685f07d-7846-4aa6-94bb-a9030596263e&lang=en',
            ],
        ]);
    }

    /** Oil Change — seeded from the real page HTML the client sent. */
    private function seedOilChangePage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'oil-change'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => 'Oil Change',
                'excerpt' => 'Get quick oil changes at Ace Wheels & Tires. Starting at $49.99, our experts enhance engine performance. Walk-ins welcome!',
                'meta_title' => 'Oil Change | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get quick oil changes at Ace Wheels & Tires. Starting at $49.99, our experts enhance engine performance. Walk-ins welcome!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 6,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Why Choose Ace Wheels & Tires for Your Oil Change?',
            'body' => '<ul>'
                . '<li><strong>Fast Walk-In Service</strong> — No appointment needed for most vehicles.</li>'
                . '<li><strong>Affordable Pricing</strong> — Oil changes starting at $49.99, or upgrade to full '
                . 'synthetic starting at $69.99 for the first 5 quarts.</li>'
                . '<li><strong>Quality Oils & Filters</strong> — We use trusted brands to protect your engine '
                . 'and extend its life.</li>'
                . '<li><strong>Local & Trusted</strong> — Proudly serving Greenwood, Shreveport, Blanchard, and '
                . 'the surrounding Ark-La-Tex region.</li>'
                . '<li><strong>Friendly Technicians</strong> — Experienced professionals who treat your car '
                . 'like their own.</li>'
                . '</ul>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Oil Change', 'image_path' => 'section-items/oil-change/oil-change-hero.jpg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'subheading' => 'When Should You Change Your Oil?',
            'body' => '<p>Routine oil changes are one of the most important parts of vehicle maintenance. Watch for '
                . 'these signs and intervals to keep your engine in top shape:</p>'
                . '<ul>'
                . '<li><strong>Every 3,000 to 5,000 miles</strong> — for conventional oil (check your owner\'s '
                . 'manual).</li>'
                . '<li><strong>Every 7,500 to 10,000 miles</strong> — for full-synthetic oil.</li>'
                . '<li><strong>Before Long Trips</strong> — Prevent breakdowns by starting your trip with '
                . 'clean oil.</li>'
                . '<li><strong>After Stop-and-Go Driving or Towing</strong> — Heavy use causes oil to break '
                . 'down faster.</li>'
                . '<li><strong>If Oil Looks Dirty or Dark</strong> — Fresh oil should be amber-colored and '
                . 'clear.</li>'
                . '<li><strong>When Your Oil Light Comes On</strong> — Don\'t ignore the warning; it\'s time '
                . 'for a change!</li>'
                . '</ul>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'Benefits of Regular Oil Changes',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            ['placeholder_key' => 'Fuel Efficiency', 'icon' => 'heroicon-s-bolt', 'body' => 'Improves fuel efficiency and engine performance'],
            ['placeholder_key' => 'Engine Wear', 'icon' => 'heroicon-s-cog', 'body' => 'Reduces engine wear and sludge build-up'],
            ['placeholder_key' => 'Vehicle Life', 'icon' => 'heroicon-s-clock', 'body' => 'Extends the life of your vehicle'],
            ['placeholder_key' => 'Repairs', 'icon' => 'heroicon-s-wrench-screwdriver', 'body' => 'Helps prevent costly repairs'],
            ['placeholder_key' => 'Lubrication', 'icon' => 'heroicon-s-beaker', 'body' => 'Keeps your engine cool and lubricated'],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'Visit Ace Wheels & Tires Today',
            'body' => '<p>Stop by our shop at 9025 Greenwood Rd., Greenwood, LA 71033, or call (318) 891-8173 for '
                . 'quick, reliable service. No appointment needed — just drive in for your next oil change and '
                . 'get back on the road fast!</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);
    }

    /** Trailer/Utility Tires — seeded from the real page HTML the client sent. */
    private function seedTrailerUtilityTiresPage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'trailer-utility-tires'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => 'Trailer/Utility Tires',
                'excerpt' => 'Get reliable trailer & utility tires at Ace Wheels & Tires. We offer installation, balancing, & expert service. Visit us today!',
                'meta_title' => 'Trailer/Utility Tires | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get reliable trailer & utility tires at Ace Wheels & Tires. We offer installation, balancing, & expert service. Visit us today!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 7,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Utility & Gooseneck Trailer Tires & Wheels in Greenwood, LA',
            'body' => '<p>Keep your trailer safe, steady, and road-ready with Ace Wheels & Tires — your local '
                . 'experts for utility and gooseneck trailer tires and wheels. Located in Greenwood, we serve '
                . 'customers across Shreveport, Marshall, and the Ark-La-Tex region.</p>',
            'layout' => 'image-right',
            'background' => 'light',
        ], [
            ['placeholder_key' => 'Trailer Tires', 'image_path' => 'section-items/trailer-utility-tires/trailer-hero.jpg'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'subheading' => 'Built for Heavy Loads',
            'body' => '<p>We stock and install ST-rated trailer tires, durable wheels, and accessories designed for '
                . 'the extra weight and stress of hauling equipment, livestock, or materials. Our team helps match '
                . 'the right load range, tire size, and wheel pattern to your trailer for lasting performance and '
                . 'safety.</p>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'Expert Service',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            ['placeholder_key' => 'Replacement', 'icon' => 'heroicon-s-arrow-path', 'body' => 'Trailer tire replacement & installation'],
            ['placeholder_key' => 'Balancing', 'icon' => 'heroicon-s-scale', 'body' => 'Wheel balancing & inspection'],
            ['placeholder_key' => 'Alignment', 'icon' => 'heroicon-s-adjustments-horizontal', 'body' => 'Proper inflation & alignment checks'],
            ['placeholder_key' => 'Goosenecks', 'icon' => 'heroicon-s-truck', 'body' => 'Heavy-duty wheel upgrades for goosenecks'],
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'body' => '<p>Stop by or call (318) 891-8173 for expert trailer service at 9025 Greenwood Rd, '
                . 'Greenwood, LA 71033 — no appointment needed!</p>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);
    }

    /** 18-Wheeler Tire Sales — seeded from the real page HTML the client sent. */
    private function seedEighteenWheelerTireSalesPage(): void
    {
        $servicesParent = Page::where('slug', 'our-services')->first();

        $page = Page::updateOrCreate(
            ['slug' => '18-wheeler-tire-sales'],
            [
                'type' => Page::TYPE_SERVICE,
                'parent_id' => $servicesParent?->id,
                'title' => '18-Wheeler Tire Sales',
                'excerpt' => 'Get quality 18-wheeler tires & services at Ace Wheels and Tires. Enjoy fast service & '
                    . 'competitive pricing. Walk-ins welcome!',
                'meta_title' => '18-Wheeler Tire Sales | Ace Wheels and Tires | Greenwood & Shreveport, LA',
                'meta_description' => 'Get quality 18-wheeler tires & services at Ace Wheels and Tires. Enjoy fast '
                    . 'service & competitive pricing. Walk-ins welcome!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 8,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'New 18-Wheeler Tire Sales in Greenwood & Shreveport, LA',
            'body' => '<p>When your business depends on the road, you need tires you can trust. At Ace Wheels & '
                . 'Tires, we provide new 18-wheeler tire sales designed for durability, performance, and long-haul '
                . 'reliability. Whether you\'re managing a fleet or an independent owner-operator, we carry the '
                . 'heavy-duty tires you need to keep moving safely and efficiently.</p>',
            'background' => 'image',
            'background_image' => 'section-items/18-wheeler-tire-sales/18-wheeler-hero.jpg',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Heavy-Duty Tires Built for Performance',
            'body' => '<p>Commercial trucks demand more from their tires than standard vehicles. That\'s why we '
                . 'offer premium semi-truck and 18-wheeler tires engineered to handle heavy loads, long distances, '
                . 'and changing road conditions. From highway driving to regional routes, our tires are built for '
                . 'strength, traction, and extended tread life.</p>'
                . '<h3>Our 18-Wheeler Tire Options Include:</h3>'
                . '<ul>'
                . '<li>Steer tires for precision handling and stability</li>'
                . '<li>Drive tires for maximum traction and power</li>'
                . '<li>Trailer tires for durability and load support</li>'
                . '<li>All-position tires for versatile performance</li>'
                . '<li>Fuel-efficient tire options to help reduce operating costs</li>'
                . '<li>Multiple sizes and load ratings to fit your rig</li>'
                . '</ul>',
            'button_text' => 'Request Service',
            'button_url' => '/contact',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Why Choose Ace Wheels & Tires for Commercial Tires?',
            'body' => '<p>At Ace Wheels & Tires, we go beyond just selling tires—we help keep your business running '
                . 'smoothly. Our team provides expert recommendations based on your truck type, driving conditions, '
                . 'and performance needs.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'card_grid',
            'background' => 'dark',
        ], [
            ['placeholder_key' => 'Pricing', 'icon' => 'heroicon-s-currency-dollar', 'body' => 'Competitive pricing on new commercial truck tires'],
            ['placeholder_key' => 'Guidance', 'icon' => 'heroicon-s-light-bulb', 'body' => 'Expert guidance on sizing and tire selection'],
            ['placeholder_key' => 'Speed', 'icon' => 'heroicon-s-bolt', 'body' => 'Fast service to minimize downtime'],
            ['placeholder_key' => 'Quality', 'icon' => 'heroicon-s-shield-check', 'body' => 'Quality products built for long-term performance'],
            ['placeholder_key' => 'Local', 'icon' => 'heroicon-s-map-pin', 'body' => 'Trusted local service for Greenwood, Shreveport & surrounding areas'],
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'body' => '<p>Proper tire selection is critical for safety, fuel efficiency, and overall performance. '
                . 'Choosing the right tires can improve handling, extend lifespan, and reduce costly breakdowns on '
                . 'the road.</p>',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Serving Owner-Operators & Fleet Managers',
            'body' => '<p>Whether you need a single replacement tire or a full fleet upgrade, Ace Wheels & Tires is '
                . 'your go-to source for dependable 18-wheeler tire sales. We understand the demands of the trucking '
                . 'industry and are committed to providing solutions that keep your trucks on schedule.</p>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'cta_banner',
            'heading' => 'Get Back on the Road with Confidence',
            'body' => '<p>Don\'t let worn or unreliable tires slow you down. Upgrade to new 18-wheeler tires from '
                . 'Ace Wheels & Tires and experience the difference in performance and reliability.</p>'
                . '<p>Call today or stop by to get a quote and find the right tires for your truck.</p>',
            'background' => 'red',
        ]);
    }

    /** Greenwood, LA service area — seeded from the real page HTML the client sent. */
    private function seedGreenwoodServiceAreaPage(): void
    {
        $areasParent = Page::where('slug', 'areas-we-serve')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'greenwood-la'],
            [
                'type' => Page::TYPE_SERVICE_AREA,
                'parent_id' => $areasParent?->id,
                'title' => 'Greenwood, LA',
                'excerpt' => 'Professional tire sales in Greenwood, LA with same-day installation. Wide selection of '
                    . 'quality tires for all vehicles at competitive prices. Walk-ins welcome!',
                'meta_title' => 'Tire Sales Greenwood LA | Quality Tires & Installation',
                'meta_description' => 'Professional tire sales in Greenwood, LA with same-day installation. Wide '
                    . 'selection of quality tires for all vehicles at competitive prices. Walk-ins welcome!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 0,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'Tire Sales in Greenwood',
            'subheading' => 'Premium Tires for Every Vehicle',
            'body' => '<p>When your vehicle needs reliable tires, you deserve quality products that deliver lasting '
                . 'performance. Greenwood drivers face diverse road conditions from rural highways to urban streets, '
                . 'requiring tires that can handle Louisiana\'s humid climate and seasonal weather changes. Ace Wheels '
                . 'and Tires brings you a comprehensive selection of new tires for all makes and models at '
                . 'competitive prices. Our commitment to your safety and satisfaction means we go beyond just '
                . 'selling tires—we ensure every installation meets the highest standards for your driving '
                . 'needs.</p>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Expert Installation and Fitting',
            'body' => '<p>Your tire investment deserves professional installation that maximizes performance and '
                . 'longevity. Our experienced technicians ensure proper fit, pressure, and balance for long tire '
                . 'life and smooth driving on Greenwood\'s varied terrain. We provide expert help choosing top '
                . 'brands based on your specific vehicle type and budget requirements.</p>'
                . '<p>Call us today at 318-891-8173 for Tire Sales in Greenwood.</p>',
            'button_text' => 'Learn More',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Fast Service You Can Trust',
            'body' => '<ul>'
                . '<li>Quick installation and same-day service for busy Greenwood residents</li>'
                . '<li>Wide selection accommodates sedans, trucks, and SUVs common in Louisiana</li>'
                . '<li>Walk-in availability eliminates scheduling hassles</li>'
                . '<li>Competitive pricing without compromising quality</li>'
                . '<li>Local expertise understanding Greenwood\'s driving conditions</li>'
                . '</ul>'
                . '<p>Local drivers consistently choose us for our speed, honesty, and exceptional value. Research '
                . 'indicates that quality tire installation reduces road noise by up to 15 decibels. Contact us '
                . 'today for Tire Sales in Greenwood.</p>',
            'background' => 'red',
        ]);
    }

    /** Shreveport, LA service area — seeded from the real page HTML the client sent. */
    private function seedShreveportServiceAreaPage(): void
    {
        $areasParent = Page::where('slug', 'areas-we-serve')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'shreveport-la'],
            [
                'type' => Page::TYPE_SERVICE_AREA,
                'parent_id' => $areasParent?->id,
                'title' => 'Shreveport, LA',
                'excerpt' => 'Reliable used tire sales in Shreveport, LA with same-day installation. Quality '
                    . 'inspected tires for all vehicles at budget-friendly prices. Walk-ins welcome!',
                'meta_title' => 'Used Tire Sales Shreveport LA | Quality Pre-Owned Tires',
                'meta_description' => 'Reliable used tire sales in Shreveport, LA with same-day installation. '
                    . 'Quality inspected tires for all vehicles at budget-friendly prices. Walk-ins welcome!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 1,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'Used Tire Sales in Shreveport',
            'subheading' => 'Quality Used Tires That Deliver',
            'body' => '<p>Finding reliable, budget-friendly tires shouldn\'t mean compromising on safety or '
                . 'performance. Shreveport\'s busy streets and surrounding highways demand dependable traction '
                . 'year-round. Ace Wheels and Tires specializes in providing quality used tires that meet strict '
                . 'safety and tread standards, offering an excellent solution for cost-conscious drivers. We '
                . 'understand that unexpected tire replacement can strain your budget, which is why we maintain an '
                . 'extensive inventory of inspected, reliable options for every vehicle type.</p>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Rigorous Quality Standards',
            'body' => '<p>Every used tire in our inventory undergoes comprehensive inspection, balancing, and '
                . 'pressure testing before reaching our sales floor. This meticulous process ensures you receive '
                . 'reliable replacements that perform safely on Shreveport\'s diverse road conditions. We carry '
                . 'options for sedans, trucks, and SUVs, accommodating the varied vehicle preferences throughout '
                . 'the area.</p>'
                . '<p>Call us today at 318-891-8173 for Used Tire Sales in Shreveport.</p>',
            'button_text' => 'Get in Touch',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Affordable Solutions with Professional Service',
            'body' => '<ul>'
                . '<li>Same-day installation gets you back on the road quickly</li>'
                . '<li>Budget-friendly pricing without sacrificing reliability</li>'
                . '<li>Options available for all vehicle types popular in Shreveport</li>'
                . '<li>Honest assessments and transparent pricing</li>'
                . '<li>Quick turnaround times respected throughout the community</li>'
                . '</ul>'
                . '<p>Customers throughout the region appreciate our commitment to honesty and efficient service '
                . 'delivery. Quality used tires can provide 70-80 percent of new tire performance at half the cost. '
                . 'Contact us today for Used Tire Sales in Shreveport.</p>',
            'background' => 'red',
        ]);
    }

    /** Marshall, TX service area — seeded from the real page HTML the client sent. */
    private function seedMarshallServiceAreaPage(): void
    {
        $areasParent = Page::where('slug', 'areas-we-serve')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'marshall-tx'],
            [
                'type' => Page::TYPE_SERVICE_AREA,
                'parent_id' => $areasParent?->id,
                'title' => 'Marshall, TX',
                'excerpt' => 'Professional tire repair in Marshall, TX with fastest turnaround times. Expert '
                    . 'patching and resealing services get you back on the road quickly.',
                'meta_title' => 'Tire Repair Marshall TX | Fast Flat Tire Fixes',
                'meta_description' => 'Professional tire repair in Marshall, TX with fastest turnaround times. '
                    . 'Expert patching and resealing services get you back on the road quickly.',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 2,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'Tire Repair in Marshall',
            'subheading' => 'Fast Flat Tire Solutions',
            'body' => '<p>A flat tire can disrupt your entire day, especially when you\'re navigating Marshall\'s '
                . 'busy commercial districts or rural East Texas roads. Quick, professional repair service gets you '
                . 'moving again without the expense of premature tire replacement. Ace Wheels and Tires delivers '
                . 'fast flat tire repairs, patching, and resealing services that restore your tire\'s integrity and '
                . 'safety. Our experienced team handles punctures, leaks, and valve issues efficiently, ensuring you '
                . 'spend minimal time off the road.</p>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Comprehensive Repair Services',
            'body' => '<p>Our on-site repair capabilities address various tire damage scenarios common to Marshall '
                . 'drivers. From highway debris punctures to slow valve leaks, we provide solutions that extend your '
                . 'tire\'s useful life. When repair isn\'t viable, we offer both new and used tire replacement '
                . 'options to fit any budget.</p>'
                . '<p>Call us today at 318-891-8173 for Tire Repair in Marshall.</p>',
            'button_text' => 'Contact Us',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Speed and Reliability You Need',
            'body' => '<ul>'
                . '<li>Fastest turnaround times in the Marshall area</li>'
                . '<li>On-site repair capabilities for immediate solutions</li>'
                . '<li>Affordable pricing that beats replacement costs</li>'
                . '<li>Reliable results that ensure safe driving</li>'
                . '<li>Trusted service extending throughout East Texas communities</li>'
                . '</ul>'
                . '<p>Drivers from Marshall and surrounding areas depend on our expertise for quick, dependable tire '
                . 'solutions. Studies show that professional tire repairs last as long as the tire\'s remaining '
                . 'tread life in 98 percent of cases. Contact us today for Tire Repair in Marshall.</p>',
            'background' => 'red',
        ]);
    }

    /** Waskom, TX service area — seeded from the real page HTML the client sent. */
    private function seedWaskomServiceAreaPage(): void
    {
        $areasParent = Page::where('slug', 'areas-we-serve')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'waskom-tx'],
            [
                'type' => Page::TYPE_SERVICE_AREA,
                'parent_id' => $areasParent?->id,
                'title' => 'Waskom, TX',
                'excerpt' => 'Professional oil changes in Waskom, TX with free fluid checks. Quick service for all '
                    . 'engines with trusted brands and filters. No appointment needed!',
                'meta_title' => 'Oil Changes Waskom TX | Quick Professional Service',
                'meta_description' => 'Professional oil changes in Waskom, TX with free fluid checks. Quick service '
                    . 'for all engines with trusted brands and filters. No appointment needed!',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 3,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'Oil Changes in Waskom',
            'subheading' => 'Professional Engine Maintenance',
            'body' => '<p>Regular oil changes represent the most critical maintenance investment for your '
                . 'vehicle\'s longevity and performance. Waskom\'s position along major transportation corridors '
                . 'means local vehicles often accumulate miles quickly, making consistent oil service essential. '
                . 'Ace Wheels and Tires provides quick, professional oil changes using trusted brands and filters '
                . 'that protect your engine investment. Our comprehensive approach includes additional fluid checks '
                . 'and tire pressure verification, ensuring your vehicle receives complete attention during every '
                . 'visit.</p>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Complete Service Excellence',
            'body' => '<p>Our experienced technicians work confidently with both older and newer engines, '
                . 'understanding the specific requirements for optimal maintenance across all vehicle types. Every '
                . 'oil change includes complimentary fluid level checks and tire pressure adjustments, maximizing '
                . 'your service value. This thorough approach helps prevent costly engine wear while improving fuel '
                . 'efficiency for Waskom commuters.</p>'
                . '<p>Call us today at 318-891-8173 for Oil Changes in Waskom.</p>',
            'button_text' => 'Learn More',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Convenient Service That Fits Your Schedule',
            'body' => '<ul>'
                . '<li>Same-day, no-appointment service for busy professionals</li>'
                . '<li>Free fluid and tire pressure checks with every service</li>'
                . '<li>Experienced with all engine types common in Waskom</li>'
                . '<li>Fast turnaround times that respect your schedule</li>'
                . '<li>Fair pricing that builds long-term customer relationships</li>'
                . '</ul>'
                . '<p>Local customers consistently choose us for reliable service and transparent pricing that fits '
                . 'their budgets. Proper oil viscosity can improve fuel economy by 1-2 percent in most vehicles. '
                . 'Contact us today for Oil Changes in Waskom.</p>',
            'background' => 'red',
        ]);
    }

    /** Blanchard, LA service area — seeded from the real page HTML the client sent. */
    private function seedBlanchardServiceAreaPage(): void
    {
        $areasParent = Page::where('slug', 'areas-we-serve')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'blanchard-la'],
            [
                'type' => Page::TYPE_SERVICE_AREA,
                'parent_id' => $areasParent?->id,
                'title' => 'Blanchard, LA',
                'excerpt' => 'Expert brake and rotor service in Blanchard, LA. Safety-focused inspections, pad '
                    . 'replacements, and rotor work with quality components and fair pricing.',
                'meta_title' => 'Brakes & Rotors Blanchard LA | Professional Brake Service',
                'meta_description' => 'Expert brake and rotor service in Blanchard, LA. Safety-focused inspections, '
                    . 'pad replacements, and rotor work with quality components and fair pricing.',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 4,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'Brakes & Rotors in Blanchard',
            'subheading' => 'Safety-First Brake Service',
            'body' => '<p>Your braking system represents your vehicle\'s most critical safety feature, especially '
                . 'when navigating Blanchard\'s mix of residential streets and nearby highway access points. '
                . 'Professional brake maintenance ensures reliable stopping power when you need it most. Ace Wheels '
                . 'and Tires specializes in comprehensive brake inspections, pad replacements, and rotor '
                . 'resurfacing or replacement services. Our focus on safety, speed, and accuracy means you receive '
                . 'thorough service that restores your vehicle\'s braking confidence without unnecessary '
                . 'delays.</p>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Expert Brake System Care',
            'body' => '<p>We utilize quality components specifically designed to restore optimal stopping power '
                . 'across all vehicle types. Our technicians expertly handle both modern brake systems and older '
                . 'models, ensuring every repair meets manufacturer specifications. This expertise proves '
                . 'especially valuable for Blanchard residents who rely on their vehicles for daily commuting and '
                . 'family transportation.</p>'
                . '<p>Call us today at 318-891-8173 for Brakes & Rotors in Blanchard.</p>',
            'button_text' => 'Get in Touch',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Trusted Brake Solutions',
            'body' => '<ul>'
                . '<li>Comprehensive inspections identify issues before they become dangerous</li>'
                . '<li>Quality replacement parts ensure long-lasting performance</li>'
                . '<li>Fair pricing with honest recommendations saves you money</li>'
                . '<li>Modern and classic vehicle expertise serves all Blanchard drivers</li>'
                . '<li>Accurate diagnostics prevent unnecessary replacements</li>'
                . '</ul>'
                . '<p>Drivers throughout the region trust our commitment to safety and transparent service '
                . 'recommendations. Properly maintained brake pads can last 25-30 percent longer with regular '
                . 'inspections and adjustments. Contact us today for Brakes & Rotors in Blanchard.</p>',
            'background' => 'red',
        ]);
    }

    /** Keithville, LA service area — seeded from the real page HTML the client sent. */
    private function seedKeithvilleServiceAreaPage(): void
    {
        $areasParent = Page::where('slug', 'areas-we-serve')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'keithville-la'],
            [
                'type' => Page::TYPE_SERVICE_AREA,
                'parent_id' => $areasParent?->id,
                'title' => 'Keithville, LA',
                'excerpt' => 'Professional tire balancing and rotation in Keithville, LA. Extend tire life and '
                    . 'improve ride comfort with precision maintenance from trusted technicians.',
                'meta_title' => 'Tire Balancing & Rotations Keithville LA | Expert Service',
                'meta_description' => 'Professional tire balancing and rotation in Keithville, LA. Extend tire life '
                    . 'and improve ride comfort with precision maintenance from trusted technicians.',
                'is_published' => true,
                'show_in_menu' => false,
                'menu_order' => 5,
            ]
        );

        $page->sections()->delete();

        $this->addSection($page, [
            'type' => 'hero',
            'heading' => 'Tire Balancing & Rotations in Keithville',
            'subheading' => 'Maximize Your Tire Investment',
            'body' => '<p>Proper tire maintenance extends beyond initial installation—regular balancing and '
                . 'rotation services significantly impact your tire\'s lifespan and your vehicle\'s overall '
                . 'performance. Keithville drivers who prioritize preventive maintenance enjoy smoother rides and '
                . 'avoid premature tire replacement costs. Ace Wheels and Tires delivers precision balancing and '
                . 'systematic rotation services that prevent uneven wear patterns while improving ride comfort. Our '
                . 'proactive approach helps you maximize every mile from your tire investment.</p>',
            'background' => 'light',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Precision Maintenance Services',
            'body' => '<p>We recommend professional balancing and rotation services every 5,000-6,000 miles to '
                . 'maintain optimal tire performance. Our precision equipment accurately addresses weight '
                . 'distribution issues that cause vibration and irregular wear on Keithville\'s varied road '
                . 'surfaces. Whether you drive on new or used tires, regular maintenance preserves their integrity '
                . 'and extends their useful life significantly.</p>'
                . '<p>Call us today at 318-891-8173 for Tire Balancing & Rotations in Keithville.</p>',
            'button_text' => 'Contact Us',
            'button_url' => '/contact',
            'background' => 'dark',
        ]);

        $this->addSection($page, [
            'type' => 'richtext',
            'heading' => 'Professional Results You Can Feel',
            'body' => '<ul>'
                . '<li>Quick walk-in service fits your busy schedule</li>'
                . '<li>Precision balancing eliminates vibration and uneven wear</li>'
                . '<li>Regular rotations maximize tire longevity in Louisiana\'s climate</li>'
                . '<li>Same-day results from trusted, experienced technicians</li>'
                . '<li>Accurate service that improves ride quality immediately</li>'
                . '</ul>'
                . '<p>Our commitment to accuracy and customer satisfaction has earned trust throughout the '
                . 'Keithville community. Professional wheel balancing can improve fuel efficiency by 2-3 percent '
                . 'through reduced rolling resistance. Contact us today for Tire Balancing & Rotations in '
                . 'Keithville.</p>',
            'background' => 'red',
        ]);
    }

    /** @return array<int, array{title: string, slug: string, state: string}> */
    private function serviceAreas(): array
    {
        return [
            ['title' => 'Greenwood, LA', 'slug' => 'greenwood-la', 'state' => 'Louisiana'],
            ['title' => 'Shreveport, LA', 'slug' => 'shreveport-la', 'state' => 'Louisiana'],
            ['title' => 'Marshall, TX', 'slug' => 'marshall-tx', 'state' => 'Texas'],
            ['title' => 'Waskom, TX', 'slug' => 'waskom-tx', 'state' => 'Texas'],
            ['title' => 'Blanchard, LA', 'slug' => 'blanchard-la', 'state' => 'Louisiana'],
            ['title' => 'Keithville, LA', 'slug' => 'keithville-la', 'state' => 'Louisiana'],
        ];
    }

    private function seedServiceAreas(): void
    {
        $areasParent = Page::where('slug', 'areas-we-serve')->first();

        foreach ($this->serviceAreas() as $order => $data) {
            // All six service areas have their own dedicated methods with real client content.
            if (in_array($data['slug'], ['greenwood-la', 'shreveport-la', 'marshall-tx', 'waskom-tx', 'blanchard-la', 'keithville-la'], true)) {
                continue;
            }

            $page = Page::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'type' => Page::TYPE_SERVICE_AREA,
                    'parent_id' => $areasParent?->id,
                    'title' => $data['title'],
                    'excerpt' => "Fast, friendly tire and automotive service for drivers in {$data['title']}.",
                    'is_published' => true,
                    'show_in_menu' => false,
                    'menu_order' => $order,
                ]
            );

            $page->sections()->delete();

            $this->addSection($page, [
                'type' => 'hero',
                'heading' => 'Serving ' . $data['title'],
                'body' => '<p>Walk-in tire sales, repairs, and automotive maintenance for ' . $data['title'] . ' and nearby communities.</p>',
                'button_text' => 'Request Service',
                'button_url' => '/contact',
                'background' => 'dark',
            ]);

            $this->addSection($page, [
                'type' => 'cta_banner',
                'heading' => 'Visit us at 9025 Greenwood Rd',
                'body' => '<p>Just a short drive from ' . $data['title'] . '. No appointment needed for most services.</p>',
                'button_text' => 'Get Directions',
                'button_url' => 'https://maps.app.goo.gl/7bmPUjNXiJqBEH1G6',
                'background' => 'dark',
            ]);
        }
    }

    /** @return array<int, array{title: string, slug: string, excerpt: string, published_at: string, body?: string}> */
    private function blogPosts(): array
    {
        return [
            [
                'title' => 'Understanding Tire Balancing and Rotations in Marshall, TX',
                'slug' => 'understanding-tire-balancing-and-rotations-in-marshall-tx',
                'excerpt' => 'Learn how tire balancing and rotations in Marshall, TX prevent uneven wear and improve ride '
                    . 'comfort with precision service every 5,000 to 6,000 miles.',
                'published_at' => '2026-09-10 09:00:00',
                'body' => '<p>Tire balancing and rotations in Marshall, TX use precision equipment to prevent uneven wear '
                    . 'patterns and maximize tire lifespan. Systematic rotation every 5,000 to 6,000 miles improves '
                    . 'ride comfort and ensures all four tires wear evenly across their tread surfaces.</p>'
                    . '<h2>Why does tire balancing matter for vehicle performance?</h2>'
                    . '<p>Proper balancing eliminates vibrations caused by uneven weight distribution around the tire '
                    . 'and wheel assembly during rotation.</p>'
                    . '<p>Even small imbalances create noticeable shaking in the steering wheel or seat at highway '
                    . 'speeds, reducing driver comfort and accelerating wear on suspension components. Balancing '
                    . 'machines detect these weight discrepancies and guide technicians in placing small '
                    . 'counterweights on wheel rims to achieve perfect equilibrium.</p>'
                    . '<p>Unbalanced tires develop cupping patterns where sections of tread wear faster than others, '
                    . 'creating noise and reducing traction in wet conditions. This irregular wear shortens tire '
                    . 'life significantly and can lead to premature replacement costs that exceed the expense of '
                    . 'regular balancing service.</p>'
                    . '<h2>How often should you rotate tires on trucks versus sedans?</h2>'
                    . '<p>Most vehicles benefit from tire rotation every 5,000 to 6,000 miles regardless of whether '
                    . 'they are trucks or sedans.</p>'
                    . '<p>Front-wheel-drive sedans experience faster wear on front tires due to steering forces and '
                    . 'engine weight, making regular rotation essential to equalize tread depth across all '
                    . 'positions. Rotating tires from front to rear and side to side distributes wear patterns '
                    . 'evenly and extends the usable life of the entire set.</p>'
                    . '<p>Trucks and SUVs with rear-wheel or all-wheel drive systems may show different wear '
                    . 'patterns depending on load distribution and driving habits, but the same rotation interval '
                    . 'applies. Drivers who frequently haul heavy loads or tow trailers should inspect tires more '
                    . 'often for signs of uneven wear that indicate the need for earlier rotation.</p>'
                    . '<p>Residents who <a href="/tire-sales">find tire sales help in Marshall</a> can replace worn '
                    . 'sets with quality options and establish a rotation schedule that maximizes their '
                    . 'investment.</p>'
                    . '<h2>What causes tires to wear unevenly between rotations?</h2>'
                    . '<p>Misaligned wheels, improper inflation, and aggressive driving habits all contribute to '
                    . 'uneven tire wear that becomes visible between scheduled rotations.</p>'
                    . '<p>Wheel alignment issues cause tires to scrub sideways as they roll, creating feathering or '
                    . 'scalloping on tread edges that reduces grip and increases road noise. Even slight alignment '
                    . 'deviations accumulate thousands of miles of abnormal contact that cannot be reversed once '
                    . 'the damage occurs.</p>'
                    . '<p>Underinflated tires flex excessively at their sidewalls, causing the outer tread edges '
                    . 'to wear faster than the center section. Overinflation produces the opposite effect, '
                    . 'concentrating wear in the center of the tread and reducing the tire\'s contact patch with '
                    . 'the road surface.</p>'
                    . '<h2>Do rotation patterns differ for all-wheel-drive vehicles?</h2>'
                    . '<p>All-wheel-drive vehicles require specific rotation patterns that account for power '
                    . 'delivery to all four wheels simultaneously.</p>'
                    . '<p>Cross-rotation patterns work well for many AWD systems, moving front tires to opposite '
                    . 'rear positions and rear tires to opposite front positions to equalize wear across all tread '
                    . 'surfaces. Some manufacturers recommend front-to-rear rotations only, keeping tires on the '
                    . 'same side of the vehicle to maintain directional tread patterns.</p>'
                    . '<p>Consulting your vehicle\'s owner manual ensures the rotation pattern matches the '
                    . 'drivetrain design and tire type installed. Incorrect rotation patterns can cause handling '
                    . 'issues or accelerate wear on vehicles with staggered tire sizes or directional treads.</p>'
                    . '<h2>How do Marshall\'s road conditions influence tire maintenance schedules?</h2>'
                    . '<p>Frequent travel on Texas highways and rural roads around Marshall exposes tires to varied '
                    . 'surfaces that affect wear rates and balancing needs.</p>'
                    . '<p>Long highway commutes at sustained speeds generate heat that can shift wheel weights and '
                    . 'create new imbalances over time, making regular checks important for drivers who log '
                    . 'significant mileage. Rough pavement and potholes common on secondary roads jar wheel '
                    . 'assemblies and knock weights loose, requiring rebalancing sooner than expected.</p>'
                    . '<p>Seasonal temperature swings between hot summers and mild winters cause tire pressure '
                    . 'fluctuations that alter contact patches and wear patterns. Motorists who '
                    . '<a href="/oil-change">explore oil change options in Marshall</a> can combine routine '
                    . 'maintenance visits with tire inspections to catch wear issues early and maintain optimal '
                    . 'performance.</p>'
                    . '<p>Ace Wheels and Tires offers precision tire balancing and systematic rotation services '
                    . 'that prevent uneven wear and extend tire life. Plan your next service with us to keep your '
                    . 'vehicle riding smoothly on Marshall roads.</p>',
            ],
            [
                'title' => 'TPMS Testing and Service in Keithville, LA: Solving Pressure Light Issues',
                'slug' => 'tpms-testing-and-service-in-keithville-la-solving-pressure-light-issues',
                'excerpt' => 'Get accurate TPMS testing and service in Keithville, LA with quick diagnostics, sensor resets, '
                    . 'and replacements that ensure proper tire pressure monitoring.',
                'published_at' => '2026-08-10 12:00:00',
                'body' => '<p>TPMS testing and service in Keithville, LA delivers quick diagnostics, sensor resets, and '
                    . 'replacements for tire pressure monitoring systems. Accurate testing solves low-pressure '
                    . 'light issues and ensures drivers maintain proper tire inflation for safety and fuel '
                    . 'efficiency.</p>'
                    . '<h2>How do tire pressure monitoring systems improve safety?</h2>'
                    . '<p>TPMS alerts drivers to significant pressure loss before it becomes visible or affects '
                    . 'vehicle handling, preventing blowouts and loss of control.</p>'
                    . '<p>Sensors mounted inside each wheel continuously measure air pressure and transmit data to '
                    . 'the vehicle\'s computer system, which triggers a dashboard warning light when pressure '
                    . 'drops below safe thresholds. This early warning allows drivers to address slow leaks or '
                    . 'punctures before tire damage becomes severe.</p>'
                    . '<p>Maintaining proper tire pressure improves braking distance, fuel economy, and tire '
                    . 'lifespan by ensuring optimal contact between tread and road surface. Underinflated tires '
                    . 'generate excessive heat that can lead to sudden failure, especially during highway driving '
                    . 'in hot weather.</p>'
                    . '<h2>What causes TPMS warning lights to illuminate?</h2>'
                    . '<p>Low tire pressure, dead sensor batteries, or system malfunctions trigger TPMS warning '
                    . 'lights that require professional diagnosis to resolve correctly.</p>'
                    . '<p>Seasonal temperature changes cause air pressure to fluctuate, with cold weather reducing '
                    . 'pressure and triggering warnings even when tires are properly inflated at warmer '
                    . 'temperatures. A drop of 10 degrees Fahrenheit can reduce tire pressure by one to two PSI, '
                    . 'enough to activate the monitoring system.</p>'
                    . '<p>Sensor batteries typically last five to ten years before requiring replacement, and '
                    . 'dead batteries prevent sensors from transmitting pressure data to the vehicle\'s computer. '
                    . 'Replacing failed sensors restores full system functionality and eliminates persistent '
                    . 'warning lights.</p>'
                    . '<p>Damage during tire mounting or wheel service can break sensors or disrupt their '
                    . 'connection to valve stems, requiring replacement to restore monitoring capability. Drivers '
                    . 'who <a href="/tire-sales">find tire sales help in Keithville</a> should ensure new tire '
                    . 'installations include proper TPMS handling to avoid sensor damage.</p>'
                    . '<h2>Can TPMS sensors be reset after tire rotation or replacement?</h2>'
                    . '<p>Most TPMS systems require relearning or resetting after tire rotation or replacement to '
                    . 'correctly identify sensor positions and display accurate pressure readings.</p>'
                    . '<p>Relearn procedures vary by vehicle manufacturer and may involve driving at specific '
                    . 'speeds, using specialized tools, or following button sequences on the dashboard. '
                    . 'Professional technicians have the equipment and knowledge to perform these procedures '
                    . 'correctly for all vehicle makes and models.</p>'
                    . '<p>Skipping the relearn process can result in incorrect pressure readings displayed for '
                    . 'each tire position, confusing drivers about which tire needs attention. Proper reset '
                    . 'ensures the system accurately monitors all four tires and provides reliable warnings when '
                    . 'pressure issues develop.</p>'
                    . '<h2>Do aftermarket wheels affect TPMS functionality?</h2>'
                    . '<p>Aftermarket wheels require compatible TPMS sensors or adapters to maintain proper '
                    . 'pressure monitoring functionality after installation.</p>'
                    . '<p>Some aftermarket wheels accommodate factory sensors with minor modifications, while '
                    . 'others require purchasing new sensors designed for the wheel\'s valve stem configuration. '
                    . 'Failing to address sensor compatibility during wheel installation leaves vehicles without '
                    . 'functional tire pressure monitoring.</p>'
                    . '<p>Professional installation services verify sensor compatibility and perform necessary '
                    . 'programming to ensure aftermarket wheels integrate seamlessly with existing TPMS systems. '
                    . 'This attention to detail preserves the safety benefits of pressure monitoring while '
                    . 'allowing vehicle customization.</p>'
                    . '<h2>How does Keithville\'s climate affect tire pressure monitoring needs?</h2>'
                    . '<p>Louisiana\'s humid subtropical climate creates significant temperature swings between '
                    . 'seasons that cause tire pressure fluctuations requiring regular monitoring.</p>'
                    . '<p>Summer heat can increase tire pressure above recommended levels, while winter cold '
                    . 'snaps reduce pressure enough to trigger TPMS warnings even when tires are properly '
                    . 'inflated. Regular pressure checks during seasonal transitions help maintain optimal '
                    . 'inflation and prevent unnecessary sensor alerts.</p>'
                    . '<p>High humidity and road salt exposure can corrode sensor components and valve stems over '
                    . 'time, leading to premature failure that requires replacement. Motorists who '
                    . '<a href="/oil-change">explore oil change options in Keithville</a> can combine routine '
                    . 'maintenance with TPMS inspections to catch sensor issues before they result in persistent '
                    . 'warning lights.</p>'
                    . '<p>Ace Wheels and Tires offers quick TPMS testing, sensor resets, and replacements with '
                    . 'accurate diagnostics for all vehicle types. Connect with our team to solve your tire '
                    . 'pressure monitoring issues and maintain safe inflation on Keithville roads.</p>',
            ],
            [
                'title' => 'Brake and Rotor Service in Blanchard, LA: Ensuring Safe Stops',
                'slug' => 'brake-and-rotor-service-in-blanchard-la-ensuring-safe-stops',
                'excerpt' => 'Discover comprehensive brake and rotor service in Blanchard, LA with safety-focused inspections, '
                    . 'pad replacements, and quality components for all vehicles.',
                'published_at' => '2026-08-10 11:00:00',
                'body' => '<p>Brake and rotor service in Blanchard, LA includes comprehensive inspections, pad '
                    . 'replacements, and rotor resurfacing using quality components. Safety-focused service '
                    . 'addresses both modern and classic vehicles, ensuring reliable stopping power for drivers on '
                    . 'Louisiana roads.</p>'
                    . '<h2>What signs indicate your brakes need immediate attention?</h2>'
                    . '<p>Squealing, grinding noises, or a pulsating brake pedal signal worn pads, damaged rotors, '
                    . 'or other issues requiring prompt professional inspection.</p>'
                    . '<p>High-pitched squealing often comes from wear indicators built into brake pads that '
                    . 'contact rotors when pad material reaches minimum thickness. Ignoring this warning leads to '
                    . 'metal-on-metal contact that damages rotors and increases repair costs significantly.</p>'
                    . '<p>Grinding sounds indicate that brake pads have worn completely through, allowing backing '
                    . 'plates to scrape against rotor surfaces and create deep grooves. This condition compromises '
                    . 'braking effectiveness and can lead to rotor failure during emergency stops.</p>'
                    . '<p>A pulsating or vibrating brake pedal suggests warped rotors that no longer provide '
                    . 'smooth, even contact with brake pads. This warping results from excessive heat buildup '
                    . 'during hard braking or uneven torque when wheels are installed.</p>'
                    . '<h2>How does rotor resurfacing extend brake system life?</h2>'
                    . '<p>Resurfacing removes minor imperfections and restores smooth, flat rotor surfaces that '
                    . 'maximize pad contact and braking efficiency.</p>'
                    . '<p>Precision machining eliminates grooves, rust, and glazing that develop over time and '
                    . 'reduce friction between pads and rotors. This process can extend rotor life by thousands of '
                    . 'miles when performed before damage becomes too severe to correct.</p>'
                    . '<p>Resurfaced rotors provide consistent braking feel and eliminate vibrations caused by '
                    . 'uneven surfaces, improving driver confidence and vehicle control. However, rotors can only '
                    . 'be resurfaced a limited number of times before they become too thin to safely dissipate '
                    . 'heat, at which point replacement becomes necessary.</p>'
                    . '<p>Drivers who <a href="/tire-balancing-rotations">find tire balancing help in Blanchard</a> '
                    . 'can address multiple safety systems during a single service visit by combining brake work '
                    . 'with tire maintenance.</p>'
                    . '<h2>Do modern vehicles require different brake service than older models?</h2>'
                    . '<p>Modern vehicles often feature electronic brake systems and sensors that require '
                    . 'specialized diagnostic equipment and procedures during service.</p>'
                    . '<p>Anti-lock braking systems and electronic stability control integrate with brake '
                    . 'components, making proper bleeding and calibration essential after pad or rotor '
                    . 'replacement. Technicians must follow manufacturer-specific procedures to ensure these '
                    . 'safety systems function correctly after service.</p>'
                    . '<p>Classic vehicles with simpler hydraulic brake systems allow for more straightforward '
                    . 'service but may require sourcing quality replacement parts that match original '
                    . 'specifications. Both modern and classic vehicles benefit from using components designed for '
                    . 'their specific braking system architecture.</p>'
                    . '<h2>When should rotors be replaced instead of resurfaced?</h2>'
                    . '<p>Rotors with deep grooves, cracks, or thickness below manufacturer minimum specifications '
                    . 'must be replaced to maintain safe braking performance.</p>'
                    . '<p>Measuring rotor thickness with precision tools determines whether enough material '
                    . 'remains for resurfacing without compromising structural integrity. Rotors worn beyond '
                    . 'minimum thickness cannot dissipate heat effectively and may crack or fail under heavy '
                    . 'braking loads.</p>'
                    . '<p>Visible cracks radiating from bolt holes or across rotor surfaces indicate heat stress '
                    . 'that has weakened the metal beyond safe use. These rotors require immediate replacement '
                    . 'regardless of thickness measurements to prevent catastrophic failure.</p>'
                    . '<h2>How do Blanchard\'s rural roads impact brake wear patterns?</h2>'
                    . '<p>Gravel roads and frequent stops at rural intersections around Blanchard accelerate brake '
                    . 'pad wear compared to steady highway driving.</p>'
                    . '<p>Dust and debris from unpaved surfaces infiltrate brake components, creating abrasive '
                    . 'conditions that erode pad material faster and score rotor surfaces. Regular inspections '
                    . 'help catch this accelerated wear before it leads to reduced braking effectiveness or '
                    . 'component failure.</p>'
                    . '<p>Hilly terrain in some areas requires more frequent braking to control speed on '
                    . 'descents, generating heat that can warp rotors if cooling periods are insufficient. '
                    . 'Motorists who <a href="/tire-sales">explore tire repair options in Blanchard</a> can '
                    . 'maintain overall vehicle safety by addressing both tire and brake issues during routine '
                    . 'service visits.</p>'
                    . '<p>Ace Wheels and Tires provides comprehensive brake inspections and quality pad and rotor '
                    . 'service for all vehicle types. Schedule your safety-focused brake service with us to '
                    . 'ensure reliable stopping power on Blanchard roads.</p>',
            ],
            [
                'title' => 'Oil Changes in Waskom, TX: Keeping Your Engine Running Smoothly',
                'slug' => 'oil-changes-in-waskom-tx-keeping-your-engine-running-smoothly',
                'excerpt' => 'Experience quick oil changes in Waskom, TX with trusted brands, complimentary fluid checks, and '
                    . 'same-day service for all engine types without appointments.',
                'published_at' => '2026-08-10 10:00:00',
                'body' => '<p>Oil changes in Waskom, TX provide quick, professional service using trusted brands and '
                    . 'filters with complimentary fluid level checks. Same-day, no-appointment service accommodates '
                    . 'all engine types and helps drivers maintain reliable performance without scheduling '
                    . 'delays.</p>'
                    . '<h2>How does fresh oil protect engine components?</h2>'
                    . '<p>Clean oil lubricates moving parts, reduces friction, and carries heat away from critical '
                    . 'engine components to prevent premature wear and failure.</p>'
                    . '<p>Engine oil forms a protective film between metal surfaces that slide against each other '
                    . 'thousands of times per minute, preventing direct contact that would generate excessive heat '
                    . 'and cause scoring. This lubrication extends the life of pistons, bearings, and camshafts by '
                    . 'minimizing metal-to-metal abrasion.</p>'
                    . '<p>Oil also suspends contaminants like dirt, metal particles, and combustion byproducts, '
                    . 'carrying them to the filter where they are trapped before they can damage engine internals. '
                    . 'Over time, oil breaks down and loses its ability to perform these functions, making '
                    . 'regular changes essential for long-term engine health.</p>'
                    . '<h2>Which oil type suits different driving conditions in Texas?</h2>'
                    . '<p>Conventional oil works well for older engines and drivers with moderate mileage in '
                    . 'temperate climates like Waskom\'s year-round conditions.</p>'
                    . '<p>Synthetic oil offers superior protection in extreme temperatures and extended drain '
                    . 'intervals, making it ideal for newer vehicles or those subjected to frequent short trips '
                    . 'that prevent oil from reaching optimal operating temperature. This advanced formulation '
                    . 'resists breakdown better than conventional oil and maintains viscosity across a wider '
                    . 'temperature range.</p>'
                    . '<p>High-mileage oil contains additives that condition seals and reduce oil consumption in '
                    . 'engines with over 75,000 miles, helping to prevent leaks and maintain compression. Drivers '
                    . 'who frequently tow trailers or haul heavy loads benefit from synthetic blends that provide '
                    . 'enhanced protection under stress without the full cost of pure synthetic oil.</p>'
                    . '<p>Residents who <a href="/tire-sales">find tire sales help in Waskom</a> can coordinate oil '
                    . 'changes with tire service to address multiple maintenance needs in one convenient visit.</p>'
                    . '<h2>What other fluids should be checked during an oil change?</h2>'
                    . '<p>Coolant, brake fluid, power steering fluid, and windshield washer fluid all require '
                    . 'periodic inspection to ensure proper vehicle operation and safety.</p>'
                    . '<p>Coolant levels affect engine temperature regulation, and low levels can lead to '
                    . 'overheating that warps cylinder heads or cracks engine blocks. Checking coolant during oil '
                    . 'changes catches leaks early before they cause expensive damage.</p>'
                    . '<p>Brake fluid absorbs moisture over time, reducing its boiling point and compromising '
                    . 'braking performance under heavy use. Verifying fluid color and level helps identify '
                    . 'contamination or leaks that require immediate attention to maintain safe stopping power.</p>'
                    . '<h2>Can same-day service accommodate unexpected maintenance needs?</h2>'
                    . '<p>Walk-in oil change service eliminates the need for advance scheduling and allows drivers '
                    . 'to address maintenance during their regular routines.</p>'
                    . '<p>Same-day availability proves especially valuable when dashboard warning lights appear or '
                    . 'when drivers realize they have exceeded their recommended change interval. Quick turnaround '
                    . 'times mean vehicles return to service within an hour, minimizing disruption to work '
                    . 'schedules and daily activities.</p>'
                    . '<p>No-appointment service also benefits travelers passing through Waskom who need '
                    . 'immediate maintenance to continue their journeys safely. This flexibility ensures that oil '
                    . 'changes do not become a source of stress or delay for busy drivers.</p>'
                    . '<h2>How do Waskom\'s small-town roads affect oil change intervals?</h2>'
                    . '<p>Short trips on local roads prevent engines from reaching full operating temperature, '
                    . 'causing moisture and contaminants to accumulate in oil faster than highway driving.</p>'
                    . '<p>Stop-and-go traffic and frequent idling common in small-town driving patterns increase '
                    . 'engine wear and accelerate oil degradation compared to sustained highway speeds. These '
                    . 'conditions often warrant more frequent oil changes than manufacturer recommendations based '
                    . 'on mileage alone.</p>'
                    . '<p>Dusty rural roads around Waskom introduce airborne particles that can bypass air '
                    . 'filters and contaminate engine oil, reducing its effectiveness between changes. Drivers '
                    . 'who <a href="/basic-diagnostics">explore engine diagnostic options in Waskom</a> can '
                    . 'identify oil-related issues early through professional code scanning and assessment.</p>'
                    . '<p>Ace Wheels and Tires delivers quick oil changes with trusted brands and complimentary '
                    . 'fluid checks for all engine types. Start your same-day service with us to keep your '
                    . 'vehicle running smoothly on Waskom roads.</p>',
            ],
        ];
    }

    private function seedBlog(): void
    {
        foreach ($this->blogPosts() as $data) {
            $post = Page::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'type' => Page::TYPE_BLOG_POST,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'is_published' => true,
                    'published_at' => $data['published_at'],
                ]
            );

            $post->sections()->delete();

            $this->addSection($post, [
                'type' => 'richtext',
                'body' => $data['body'] ?? '<p>' . $data['excerpt'] . '</p>',
            ]);
        }
    }
}
