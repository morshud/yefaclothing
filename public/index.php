<?php

require __DIR__ . '/../src/bootstrap.php';

$pageTitle = 'Home';

$productsNewIn = [
    [
        'title' => 'regular shirt in light pink',
        'price' => '₦55,000.00',
    'img' => '/assets/images/2025/07/cool-handsome-caucasian-man-wearing-elegant-light-pink-shirt-sunglasses-posing-outdoor-300x300.jpg',
        'alt' => 'regular shirt in light pink',
    ],
    [
        'title' => 'Brown faux leather',
        'price' => '₦45,000.00',
    'img' => '/assets/images/2025/07/97144-300x300.jpg',
        'alt' => 'Brown faux leather',
    ],
    [
        'title' => 'ENTRADA 22 SHORTS',
        'price' => '₦15,000.00',
    'img' => '/assets/images/2025/07/H57506_3_APPAREL_ZIP_-_Turntable_3d-1_grey_ucg4gk-300x300.jpg',
        'alt' => 'ENTRADA 22 SHORTS',
    ],
    [
        'title' => 'ADIDAS ADILETTE AQUA',
        'price' => '₦20,000.00',
    'img' => '/assets/images/2025/07/F35542_1_FOOTWEAR_Photography_Side_Lateral_Center_View_grey_f7yf20-300x300.jpg',
        'alt' => 'ADIDAS ADILETTE AQUA',
    ],
    [
        'title' => 'TREFOIL BUCKET HAT',
        'price' => '₦7,500.00',
    'img' => '/assets/images/2025/07/AJ8995_1_HARDWARE_Photography_Front_Center_View_grey_kumvek-300x300.jpg',
        'alt' => 'TREFOIL BUCKET HAT',
    ],
    [
        'title' => 'Men’s Oversized Woven Track Jacket',
        'price' => '₦65,000.00',
    'img' => '/assets/images/2025/07/MNKCLUBWVNTRKJKTOS-300x300.avif',
        'alt' => 'Men’s Oversized Woven Track Jacket',
    ],
    [
        'title' => 'Nike Sportswear Club',
        'price' => '₦45,000.00',
    'img' => '/assets/images/2025/07/MNKCLUBWVNCARGOPANTCLCTN-300x300.avif',
        'alt' => 'Nike Sportswear Club',
    ],
    [
        'title' => 'SAMBA DECON SHOES',
        'price' => '₦268,000.00',
    'img' => '/assets/images/2025/07/Samba_Decon_Shoes_White_IF0642_01_standard_eeqyey-300x300.avif',
        'alt' => 'SAMBA DECON SHOES',
    ],
];

$productsNewInShort = array_slice($productsNewIn, 0, 4);
$productsCarousel = $productsNewIn;

$clientLogos = [
  '/assets/images/2025/06/client1-150x150.png',
  '/assets/images/2025/06/client2-150x150.png',
  '/assets/images/2025/06/client3-150x150.png',
  '/assets/images/2025/06/client4-150x150.png',
  '/assets/images/2025/06/client5-150x150.png',
  '/assets/images/2025/06/client7-150x150.png',
  '/assets/images/2025/06/client8-150x150.png',
  '/assets/images/2025/06/h8-client-150x150.png',
  '/assets/images/2025/06/client1-1-150x150.png',
  '/assets/images/2025/06/client2-1-150x150.png',
  '/assets/images/2025/06/client3-1-150x150.png',
  '/assets/images/2025/06/client4-1-150x150.png',
  '/assets/images/2025/06/client5-1-150x150.png',
  '/assets/images/2025/06/client7-1-150x150.png',
  '/assets/images/2025/06/client8-1-150x150.png',
  '/assets/images/2025/06/h8-client-1-150x150.png',
];

$testimonials = [
    [
        'name' => 'John Doe',
        'job' => 'Sony CEO',
        'rating' => 4,
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet cursus volutpat. Aliquam sit amet ligula et justo tincidunt laoreet non vitae lorem. Aliquam porttitor tellus enim, eget commodo augue porta ut. Maecenas lobortis ligula vel tellus sagittis ullamcorperv vestibulum pellentesque cursutu.',
    ],
    [
        'name' => 'Tom Jones',
        'job' => 'Tesla CMO',
        'rating' => 5,
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet cursus volutpat. Aliquam sit amet ligula et justo tincidunt laoreet non vitae lorem. Aliquam porttitor tellus enim, eget commodo augue porta ut. Maecenas lobortis ligula vel tellus sagittis ullamcorperv vestibulum pellentesque cursutu.',
    ],
    [
        'name' => 'Mark Wilson',
        'job' => 'Apple Manager',
        'rating' => 4,
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur laoreet cursus volutpat. Aliquam sit amet ligula et justo tincidunt laoreet non vitae lorem. Aliquam porttitor tellus enim, eget commodo augue porta ut. Maecenas lobortis ligula vel tellus sagittis ullamcorperv vestibulum pellentesque cursutu.',
    ],
];

require __DIR__ . '/../src/partials/layout-top.php';
?>

<!-- HERO -->
<section class="relative bg-[url('/assets/images/2025/06/photo-1594534475808-b18fc33b045e.avif')] bg-cover bg-center pt-[380px] pb-[80px] px-[20px] md:pt-[360px] lg:pt-[430px] lg:pb-[130px] lg:px-[80px]">
  <div class="absolute inset-0 bg-black/[0.53]"></div>
  <div class="relative z-10 flex flex-col gap-[5px]">
    <h2 class="font-jost text-[14px] md:text-[25px] font-medium text-white">Minimal. Effortless. Intentional.</h2>

    <h2 class="font-jost text-[27px] md:text-[50px] lg:text-[60px] font-bold uppercase text-white leading-[1.1] max-w-full lg:max-w-[70%]">
      Premium menswear designed for real-life movement.
    </h2>

    <div class="pt-[10px]">
      <a href="#" class="inline-flex items-center justify-center font-roboto font-medium text-white border border-white rounded-[5px] px-[30px] py-[15px] md:px-[50px] md:py-[15px] lg:px-[50px] lg:py-[20px] hover:bg-white hover:text-black transition-colors">
        Shop the Collection
      </a>
    </div>
  </div>
</section>

<!-- NEW IN (GRID) -->
<section class="pt-[30px] pb-[20px] px-[20px] md:pt-[50px] lg:pt-[80px] lg:pb-[50px] lg:px-[80px]">
  <div class="flex flex-col gap-[20px] md:gap-[30px]">
    <h2 class="font-jost text-[20px] md:text-[32px] font-normal uppercase leading-[1em] md:leading-[32px] text-black max-w-full lg:max-w-[90%]">
      New in: hand-picked daily from the world’s best brands and boutiques
    </h2>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-[10px] gap-y-[20px]">
      <?php foreach ($productsNewIn as $p): ?>
        <a href="#" class="block group">
          <div class="relative">
            <div class="overflow-hidden">
              <img src="<?= e($p['img']) ?>" alt="<?= e($p['alt']) ?>" class="w-full aspect-square object-cover">
            </div>

            <div class="absolute inset-x-0 bottom-[-15px] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
              <div class="flex w-full items-center justify-center gap-[6px] bg-black/70 text-white text-[12px] font-roboto py-[10px]">
                <span>Quick View</span>
                <svg class="w-[12px] h-[12px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2"/>
                  <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/>
                </svg>
              </div>
            </div>
          </div>

          <div class="pt-[30px] text-left">
            <div class="font-jost text-[16px] text-black font-semibold leading-tight"><?= e($p['title']) ?></div>
            <div class="font-roboto text-[14px] text-[#77a464] font-[600] mt-[2px]"><?= e($p['price']) ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="py-[15px]">
      <div class="border-t border-[#00000054]"></div>
    </div>
  </div>
</section>

<!-- MOSAIC PROMOS -->
<section class="flex flex-col lg:flex-row gap-[6px] md:gap-[5px]">
  <!-- Left column (2-up) -->
  <div class="lg:w-[40%] grid grid-cols-1 gap-[6px] md:gap-[5px] bg-[linear-gradient(90deg,#FFFFFF_58%,#000000_0%)] md:bg-[linear-gradient(295deg,#FFFFFF_100%,#000000_100%)]">
    <div class="relative w-full bg-[url('/assets/images/2025/06/premium_photo-1664869376082-3c53c6ce88f9.avif')] bg-cover bg-center pt-[250px] pb-[50px] px-[10px] md:px-0">
      <div class="absolute inset-0 bg-black/[0.6]"></div>
      <div class="relative z-10 flex flex-col items-center text-center">
        <h2 class="font-jost text-[30px] md:text-[62px] font-normal uppercase leading-[1em] md:leading-[52px] text-white">lorex</h2>
        <p class="mt-[10px] font-jost text-[15px] font-normal leading-[18px] text-white max-w-[70%]">Refreshing your wardrobe with elegance and style.</p>
      </div>
    </div>

    <div class="relative w-full bg-[url('/assets/images/2025/06/photo-1620625515032-6ed0c1790c75.avif')] bg-cover bg-center pt-[300px] pb-[50px] px-[10px] md:pt-[250px] md:px-0">
      <div class="absolute inset-0 bg-black/[0.34]"></div>
      <div class="relative z-10 flex items-end justify-center">
        <a href="#" class="inline-flex items-center justify-center border border-white text-white font-roboto font-medium rounded-[5px] text-[13px] px-[20px] py-[10px] md:text-[15px] md:px-[50px] md:py-[20px] hover:bg-white hover:text-black transition-colors">
          Watch Collection
        </a>
      </div>
    </div>
  </div>

  <!-- Middle column -->
  <div class="relative lg:w-[20%] bg-[url('/assets/images/2025/06/photo-1631613682811-3c0010ed17a7.avif')] bg-cover bg-center pt-[250px] pb-[50px] px-[10px] md:pt-[200px] md:pb-[100px] md:px-0 lg:pt-[350px] lg:pb-0">
    <div class="absolute inset-0 bg-black/[0.58]"></div>
    <div class="relative z-10 flex justify-center text-center">
      <p class="font-jost text-[15px] font-normal leading-[18px] text-white max-w-[70%]">
        Refreshing your wardrobe with elegance and style.
      </p>
    </div>
  </div>

  <!-- Right column -->
  <div class="relative lg:w-[40%] bg-[url('/assets/images/2025/06/photo-1629581678313-36cf745a9af9.avif')] bg-cover bg-center pt-[250px] pb-[50px] px-[10px] md:pb-[150px] md:px-[20px]">
    <div class="absolute inset-0 bg-black/[0.38]"></div>
    <div class="relative z-10 flex flex-col items-center text-center gap-[10px]">
      <h2 class="hidden md:block font-jost text-[62px] font-normal uppercase leading-[52px] text-white">FALL 23 <br>CAMPAIGN</h2>
      <h2 class="md:hidden font-jost text-[40px] font-normal uppercase leading-[1em] text-white">FALL 23 CAMPAIGN</h2>

      <p class="hidden md:block font-jost text-[15px] font-normal leading-[18px] text-white max-w-[70%]">Refreshing your wardrobe with elegance and style.</p>
      <p class="md:hidden font-jost text-[15px] font-normal leading-[18px] text-white max-w-[70%]">Refreshing your wardrobe with <br>elegance and style.</p>

      <a href="#" class="inline-flex items-center justify-center bg-white text-black border border-white font-roboto font-medium rounded-[5px] text-[13px] px-[20px] py-[10px] md:text-[15px] md:px-[50px] md:py-[20px] hover:bg-white/20 hover:text-white transition-colors">
        Shop the Collection
      </a>
    </div>
  </div>
</section>

<style>
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- INSPIRE TEXT + PRODUCT CAROUSEL -->
<section class="pt-[50px] pb-[10px]">
  <div class="mx-2 flex flex-col gap-[20px] md:gap-[50px]">
    <p class="font-jost text-[17px] md:text-[22px] font-light leading-[1em] md:leading-[32px] text-black text-center max-w-full md:max-w-[75%] mx-auto">
      Be inspired by the spirit of the season. Discover the new arrivals from shoes, bags, small leather goods and accessories collections for Men.
    </p>

    <div class="relative">
      <div id="inspireCarousel" class="flex gap-8 overflow-x-auto scroll-smooth no-scrollbar">
        <?php foreach ($productsCarousel as $p): ?>
          <div class="min-w-[220px] w-[220px] md:min-w-[240px] md:w-[240px] lg:min-w-[260px] lg:w-[260px] border border-[#eee] bg-[#F7F7F7] group">
            <div class="p-[0px]">
              <div class="relative overflow-hidden">
                <img src="<?= e($p['img']) ?>" alt="<?= e($p['alt']) ?>" class="w-full aspect-square object-cover">
                <div class="absolute w-full bottom-0 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-opacity duration-200 flex items-center justify-center gap-[1px]">
                  <button type="button" class="w-full bg-black/85 py-[10px] text-[#fff] flex items-center justify-center" aria-label="Add to cart">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M6 7h15l-1.5 9h-12L6 7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                      <path d="M6 7 5 3H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                      <path d="M9 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM18 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" fill="currentColor"/>
                    </svg>
                  </button>

                  <a href="#" class="w-full bg-black/85 text-[#fff] py-[10px] flex items-center justify-center" aria-label="View product">
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M10 13a5 5 0 0 1 0-7l1-1a5 5 0 0 1 7 7l-1 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M14 11a5 5 0 0 1 0 7l-1 1a5 5 0 0 1-7-7l1-1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </a>
                </div>
              </div>
              <div class="text-center p-[10px]">
                <div class="font-jost text-[16px] text-black leading-tight"><?= e($p['title']) ?></div>
                <div class="font-roboto text-[14px] text-black mt-[4px]"><?= e($p['price']) ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div id="inspireCarouselDots" class="mt-[18px] flex items-center justify-center gap-[6px]">
        <?php foreach ($productsCarousel as $i => $_): ?>
          <button type="button" class="inspire-dot h-[4px] rounded-full <?= $i === 0 ? 'bg-[#222222] w-[20px]' : 'bg-[#d1d1d1] w-[12px]' ?>" data-index="<?= (int) $i ?>" aria-label="Go to product <?= (int) ($i + 1) ?>"></button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="py-[15px]">
      <div class="w-[85%] mx-auto border-t border-[#00000054]"></div>
    </div>
  </div>
</section>

<script>
  (function ($) {
    $(function () {
      var $track = $('#inspireCarousel');
      var $dots = $('#inspireCarouselDots .inspire-dot');

      if ($track.length === 0 || $dots.length === 0) return;

      var el = $track.get(0);
      var intervalMs = 5000;
      var timer = null;
      var rafId = null;

      function stepSize() {
        var children = el.children;
        if (!children || children.length === 0) return 0;
        if (children.length === 1) return children[0].offsetWidth;
        return children[1].offsetLeft - children[0].offsetLeft;
      }

      function clampIndex(i) {
        return Math.max(0, Math.min($dots.length - 1, i));
      }

      function setActive(i) {
        i = clampIndex(i);
        $dots.removeClass('bg-[#222222] w-[20px]').addClass('bg-[#d1d1d1] w-[12px]');
        $dots.eq(i).removeClass('bg-[#d1d1d1] w-[12px]').addClass('bg-[#222222] w-[20px]');
      }

      function currentIndex() {
        var step = stepSize();
        if (step <= 0) return 0;
        return Math.round(el.scrollLeft / step);
      }

      function scrollToIndex(i, animate) {
        i = clampIndex(i);

        var children = el.children;
        if (!children || !children[i]) return;

        var left = children[i].offsetLeft;

        if (animate) {
          $track.stop(true).animate({ scrollLeft: left }, 450);
        } else {
          $track.stop(true);
          el.scrollLeft = left;
        }

        setActive(i);
      }

      function tick() {
        var maxScroll = el.scrollWidth - el.clientWidth;
        if (maxScroll <= 0) return;

        var idx = clampIndex(currentIndex());
        var nextIdx = idx + 1;

        var step = stepSize();
        if (step <= 0) return;

        if (nextIdx >= $dots.length || (el.scrollLeft + step) >= maxScroll - 2) {
          scrollToIndex(0, false);
          return;
        }

        scrollToIndex(nextIdx, true);
      }

      function start() {
        if (timer !== null) return;
        timer = window.setInterval(tick, intervalMs);
      }

      function stop() {
        if (timer === null) return;
        window.clearInterval(timer);
        timer = null;
      }

      $dots.on('click', function () {
        var idx = parseInt($(this).attr('data-index'), 10);
        if (Number.isNaN(idx)) return;

        stop();
        scrollToIndex(idx, true);
        start();
      });

      $track.on('scroll', function () {
        if (rafId !== null) return;

        rafId = window.requestAnimationFrame(function () {
          rafId = null;
          setActive(currentIndex());
        });
      });

      setActive(0);
      start();

      $track.on('mouseenter focusin touchstart', stop);
      $track.on('mouseleave focusout touchend touchcancel', start);
    });
  })(jQuery);
</script>

<!-- CLIENT LOGOS -->
<section class="py-[0px]">
  <div id="clientLogos" class="flex items-center gap-[60px] overflow-x-auto px-[20px] py-[10px] no-scrollbar">
    <?php foreach ($clientLogos as $logo): ?>
      <div class="flex-none">
        <img src="<?= e($logo) ?>" alt="" class="h-[150px] w-[150px]" loading="lazy">
      </div>
    <?php endforeach; ?>
  </div>
</section>

<script>
  (function ($) {
    $(function () {
      var $track = $('#clientLogos');
      if ($track.length === 0) return;

      var el = $track.get(0);
      var intervalMs = 7000;
      var timer = null;

      function stepSize() {
        var children = el.children;
        if (!children || children.length === 0) return 0;
        if (children.length === 1) return children[0].offsetWidth;
        return children[1].offsetLeft - children[0].offsetLeft;
      }

      function tick() {
        var maxScroll = el.scrollWidth - el.clientWidth;
        if (maxScroll <= 0) return;

        var step = stepSize();
        if (step <= 0) return;

        var next = el.scrollLeft + step;

        if (next >= maxScroll - 2) {
          $track.stop(true).animate({ scrollLeft: 0 }, 450);
        } else {
          $track.stop(true).animate({ scrollLeft: next }, 450);
        }
      }

      function start() {
        if (timer !== null) return;
        timer = window.setInterval(tick, intervalMs);
      }

      start();
    });
  })(jQuery);
</script>

<!-- 2-UP CAMPAIGN BANNERS -->
<section class="flex flex-col md:flex-row gap-[15px] md:gap-[5px] pb-[5px]">
  <div class="relative md:w-1/2 bg-[url('/assets/images/2025/06/photo-1530432999454-016a47c78af3.avif')] bg-cover bg-center pt-[150px] pb-[150px] md:pt-[200px] md:pb-[200px] lg:pt-[300px] lg:pb-[300px]">
    <div class="absolute inset-0 bg-black/[0.26]"></div>
    <div class="relative z-10 flex flex-col items-center text-center gap-[15px] px-[10px]">
      <h2 class="font-jost text-[45px] md:text-[40px] lg:text-[62px] font-normal uppercase leading-[1em] lg:leading-[52px] text-white">FALL 23 <br>CAMPAIGN</h2>
      <p class="hidden md:block font-jost text-[15px] font-normal leading-[18px] text-white max-w-[70%]">Refreshing your wardrobe with elegance and style.</p>

      <a href="#" class="md:hidden inline-flex items-center justify-center border border-white text-white font-roboto font-medium rounded-[5px] text-[13px] px-[40px] py-[15px] hover:bg-white hover:text-black transition-colors">
        Learn More
      </a>
    </div>
  </div>

  <div class="relative md:w-1/2 bg-[url('/assets/images/2025/06/photo-1579718080147-0fef34dc9529.avif')] bg-cover bg-center pt-[150px] pb-[150px] md:pt-[200px] md:pb-[200px] lg:pt-[300px] lg:pb-[300px]">
    <div class="absolute inset-0 bg-black/[0.26]"></div>
    <div class="relative z-10 flex flex-col items-center text-center gap-[15px] px-[10px]">
      <h2 class="font-jost text-[45px] md:text-[40px] lg:text-[62px] font-normal uppercase leading-[1em] lg:leading-[52px] text-white">FALL 23 <br>CAMPAIGN</h2>
      <p class="hidden md:block font-jost text-[15px] font-normal leading-[18px] text-white max-w-[70%]">Refreshing your wardrobe with elegance and style.</p>

      <a href="#" class="md:hidden inline-flex items-center justify-center border border-white text-white font-roboto font-medium rounded-[5px] text-[13px] px-[40px] py-[15px] hover:bg-white hover:text-black transition-colors">
        Know More
      </a>
    </div>
  </div>
</section>

<!-- NEW IN (GRID - SHORT) -->
<section class="pt-[30px] pb-[20px] px-[20px] md:pt-[50px] lg:pt-[80px] lg:pb-[50px] lg:px-[80px]">
  <div class="flex flex-col gap-[20px] md:gap-[30px]">
    <h2 class="font-jost text-[20px] md:text-[32px] font-normal uppercase leading-[1em] md:leading-[32px] text-black max-w-full lg:max-w-[90%]">
      New in: hand-picked daily from the world’s best brands and boutiques
    </h2>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-[10px] gap-y-[20px]">
      <?php foreach ($productsNewInShort as $p): ?>
        <a href="#" class="block group">
          <div class="relative">
            <div class="overflow-hidden">
              <img src="<?= e($p['img']) ?>" alt="<?= e($p['alt']) ?>" class="w-full aspect-square object-cover">
            </div>

            <div class="absolute inset-x-0 bottom-[-15px] opacity-0 group-hover:opacity-100 transition-opacity duration-200">
              <div class="flex w-full items-center justify-center gap-[6px] bg-black/70 text-white text-[12px] font-roboto py-[10px]">
                <span>Quick View</span>
                <svg class="w-[12px] h-[12px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2"/>
                  <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/>
                </svg>
              </div>
            </div>
          </div>

          <div class="p-[30px] text-left">
            <div class="font-jost text-[16px] text-black font-semibold leading-tight"><?= e($p['title']) ?></div>
            <div class="font-roboto text-[14px] text-[#77a464] font-[600] mt-[2px]"><?= e($p['price']) ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- MEMBERSHIP BANNER -->
<section class="relative bg-[url('/assets/images/2025/06/photo-1513188732907-5f732b831ca8.avif')] bg-cover bg-center py-[120px] md:py-[150px]">
  <div class="absolute inset-0 bg-black/50"></div>
  <div class="relative z-10 flex flex-col items-center text-center gap-[10px]">
    <h2 class="font-jost text-[20px] md:text-[32px] font-normal uppercase leading-[20px] md:leading-[52px] text-white max-w-[90%] md:max-w-[70%]">
      Members get 10% off the first purchase, free delivery and returns! Not a member yet?
    </h2>

    <div class="flex flex-col md:flex-row items-center justify-center gap-[10px] pt-[15px]">
      <a href="#" class="inline-flex items-center justify-center bg-white text-black border border-white font-roboto font-medium text-[13px] md:text-[15px] px-[40px] py-[15px] md:px-[50px] md:py-[20px] hover:bg-black/20 hover:text-white transition-colors">
        Join Now, It's Free
      </a>
      <a href="#" class="inline-flex items-center justify-center bg-white text-black border border-white font-roboto font-medium text-[13px] md:text-[15px] px-[40px] py-[15px] md:px-[50px] md:py-[20px] hover:bg-black/20 hover:text-white transition-colors">
        Read more info
      </a>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="pt-[30px] pb-[20px] px-[10px] md:px-[20px] md:pt-[50px] lg:px-[80px] lg:pt-[80px] lg:pb-[50px]">
  <div class="flex flex-col items-center gap-[20px] md:gap-[30px]">
    <h2 class="font-jost text-[15px] font-normal uppercase leading-[1em] md:leading-[32px] text-black text-center">
      HERE'S WHAT PEOPLE ARE SAYING:
    </h2>

    <div class="w-full max-w-[900px]">
      <div id="testimonialSlides" class="relative">
        <?php foreach ($testimonials as $i => $t): ?>
          <div class="testimonial-slide <?= $i === 0 ? '' : 'hidden' ?>">
            <div class="bg-white rounded-[5px] px-[25px] pt-[25px] pb-[27px]">
              <div class="text-center text-[#c1c1c1]">
                <svg class="mx-auto w-[49px] h-[49px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M7.17 6C5.42 6 4 7.42 4 9.17V18h8V9.17C12 7.42 10.58 6 8.83 6H7.17zm8 0C13.42 6 12 7.42 12 9.17V18h8V9.17C20 7.42 18.58 6 16.83 6h-1.66z"/>
                </svg>
              </div>

              <div class="mt-[10px] text-center">
                <div class="inline-flex items-center justify-center gap-[2px]" aria-label="Rating">
                  <?php for ($s = 0; $s < 5; $s++): ?>
                    <svg class="w-[22px] h-[22px] <?= $s < (int) $t['rating'] ? 'fill-black' : 'fill-[#d8d8d8]' ?>" viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                  <?php endfor; ?>
                </div>
              </div>

              <p class="mt-[10px] font-roboto text-[17px] md:text-[28px] leading-snug text-black text-center">
                <?= e($t['text']) ?>
              </p>

              <div class="mt-[18px] text-center">
                <div class="font-roboto text-[#222222]"><?= e($t['name']) ?></div>
                <div class="font-roboto text-[#b7b7b7] mt-[5px]"><?= e($t['job']) ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-[18px] flex items-center justify-center gap-[6px]">
        <?php foreach ($testimonials as $i => $_): ?>
          <button type="button" class="testimonial-dot w-[7px] h-[7px] rounded-full <?= $i === 0 ? 'bg-[#222222]' : 'bg-[#d1d1d1]' ?>" data-index="<?= (int) $i ?>" aria-label="Go to testimonial <?= (int) ($i + 1) ?>"></button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<script>
  (function ($) {
    $(function () {
      var $slides = $('#testimonialSlides .testimonial-slide');
      var $dots = $('.testimonial-dot');

      function showSlide(i) {
        $slides.addClass('hidden');
        $slides.eq(i).removeClass('hidden');

        $dots.removeClass('bg-[#222222]').addClass('bg-[#d1d1d1]');
        $dots.eq(i).removeClass('bg-[#d1d1d1]').addClass('bg-[#222222]');
      }

      $dots.on('click', function () {
        var idx = parseInt($(this).attr('data-index'), 10);
        if (!Number.isNaN(idx)) {
          showSlide(idx);
        }
      });
    });
  })(jQuery);
</script>

<?php
require __DIR__ . '/../src/partials/layout-bottom.php';
