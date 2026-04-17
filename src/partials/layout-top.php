<?php

$cfg = config();
$siteName = isset($cfg['site']['name']) && is_string($cfg['site']['name']) && $cfg['site']['name'] !== ''
    ? $cfg['site']['name']
    : 'yefaclothing';

$defaultTitle = 'LVAzqHsgYnmB.com';
$pageTitleText = isset($pageTitle) && is_string($pageTitle) && $pageTitle !== ''
    ? ($pageTitle . ' | ' . $siteName)
    : $defaultTitle;

$accountHref = is_logged_in() ? '/my-account.php' : '/login.php';

?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitleText) ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script>
    tailwind = window.tailwind || {};
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            jost: ['Jost', 'sans-serif'],
            roboto: ['Roboto', 'sans-serif'],
          },
        },
      },
    };
  </script>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .yefa-mega-title {
      display: flex;
    }

    .yefa-mega-title::before {
      content: "";
      background-color: #FFB25D;
      width: 6px;
      height: 5px;
      margin: 10px 5px 0px 0px;
    }

    .yefa-mega-menu li a{
      color: #4C4C4C
    }

    .yefa-mega-menu li:hover > a {
      color: #FFB25D;
      font-weight: 400;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
</head>
<body class="font-roboto text-black bg-white">

  <!-- Top bar (desktop only) -->
  <div class="hidden lg:flex items-center justify-between bg-black text-white px-[40px] py-[8px]">
    <div class="flex items-center gap-[15px]">
      <a href="#" class="font-jost text-[14px] leading-[27px] hover:text-white/80">English</a>
      <a href="#" class="font-jost text-[14px] leading-[27px] hover:text-white/80">Store Location</a>
      <a href="#" class="font-jost text-[14px] leading-[27px] hover:text-white/80">EUR</a>
    </div>

    <div class="flex-1 text-center px-[15px]">
      <p class="font-jost text-[12px] leading-[27px]">Enjoy complimentary standard shipping and extended returns.</p>
    </div>

    <div class="flex items-center justify-end">
      <a href="#" class="font-jost text-[14px] leading-[27px] hover:text-white/80">Custom Care</a>
    </div>
  </div>

  <!-- Main header (desktop) -->
  <header class="hidden lg:block relative">
    <div class="grid grid-cols-[1fr_auto_1fr] items-center bg-white px-[40px] py-[15px]">
      <!-- left: search + left nav -->
      <div class="flex items-center gap-[70px]">
        <form role="search" method="get" action="/" class="flex items-center">
          <input
            class="font-jost text-[13px] leading-[18px] text-black placeholder:text-black bg-transparent px-[5px] py-[5px] outline-none"
            type="search"
            name="s"
            placeholder="Search..."
            aria-label="Search"
          >
          <button type="submit" class="p-[5px]" aria-label="Search">
            <i class="fa-solid fa-magnifying-glass text-[14px]" aria-hidden="true"></i>
          </button>
        </form>

        <nav aria-label="Primary" class="flex items-center">
          <a href="/" class="font-jost text-[16px] text-black px-[15px] hover:text-[#707070]">Home</a>
          <a href="#" class="font-jost text-[16px] text-black px-[15px] hover:text-[#707070]">About us</a>

          <div class="group">
            <a href="#" class="font-jost text-[16px] text-black px-[15px] hover:text-[#707070] inline-flex items-center gap-1">
              Categories
              <i class="fa-solid fa-chevron-down text-[12px]" aria-hidden="true"></i>
            </a>

            <!-- Mega menu -->
            <div class="yefa-mega-menu hidden group-hover:block z-50 group-focus-within:block absolute mt-[-15px] inset-x-0 bg-white shadow-xl border border-black/10">
              <div class="grid grid-cols-3 gap-[40px] p-[30px]">
                <div>
                  <p class="yefa-mega-title font-jost text-[15px] font-medium uppercase">Men</p>
                  <ul class="mt-[15px] space-y-[10px]">
                    <li><a href="#" class="font-Roboto text-[13px] hover:text-[#707070]">Dining Chairs</a></li>
                    <li><a href="#" class="font-Roboto text-[13px] hover:text-[#707070]">Counter &amp; Bar Stools</a></li>
                    <li><a href="#" class="font-Roboto text-[13px] hover:text-[#707070]">Occasional Chairs</a></li>
                    <li><a href="#" class="font-Roboto text-[13px] hover:text-[#707070]">Daybeds &amp; Chaises</a></li>
                  </ul>

                  <p class="yefa-mega-title mt-[25px] font-Roboto text-[15px] font-medium uppercase">lightings</p>
                  <ul class="mt-[15px] space-y-[10px]">
                    <li><a href="#" class="font-Roboto text-[13px] hover:text-[#707070]">Benches &amp; Ottomans</a></li>
                    <li><a href="#" class="font-Roboto text-[13px] hover:text-[#707070]">Dining Tables</a></li>
                    <li><a href="#" class="font-Roboto text-[13px] hover:text-[#707070]">Coffee &amp; Cocktail Tables</a></li>
                    <li><a href="#" class="font-Roboto text-[13px] hover:text-[#707070]">Consoles &amp; Desks</a></li>
                  </ul>
                </div>

                <div>
                  <p class="yefa-mega-title font-jost text-[15px] font-medium uppercase">accessories</p>
                  <ul class="mt-[15px] space-y-[10px]">
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Cabinets &amp; Bookcases</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Screens</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Outdoor Furniture</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Floor Samples</a></li>
                  </ul>

                  <p class="yefa-mega-title mt-[25px] font-jost text-[15px] font-medium uppercase">Texture lab</p>
                  <ul class="mt-[15px] space-y-[10px]">
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Side Tables</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Beside Tables</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Sideboards &amp; Drawers</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Lounge Chairs</a></li>
                  </ul>
                </div>

                <div>
                  <p class="yefa-mega-title font-jost text-[15px] font-medium uppercase">what’s new</p>
                  <ul class="mt-[15px] space-y-[10px]">
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Benches &amp; Ottomans</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Cocktail Tables</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Dining Tables</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Consoles &amp; Desks</a></li>
                  </ul>

                  <p class="yefa-mega-title mt-[25px] font-jost text-[15px] font-medium uppercase">Flash sales</p>
                  <ul class="mt-[15px] space-y-[10px]">
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Easy to Customise</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Simple and intuitive</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Highly customisable</a></li>
                    <li><a href="#" class="font-jost text-[13px] hover:text-[#707070]">Coding skills</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>

      <!-- center: logo -->
      <div class="flex justify-center">
        <a href="/" class="inline-flex items-center">
          <img src="/assets/images/2025/06/For-Website-YEFA-LOGO.png" alt="" class="h-[42px] w-auto" loading="lazy">
        </a>
      </div>

      <!-- right: right nav + icons -->
      <div class="flex items-center justify-end gap-[170px]">
        <nav aria-label="Secondary" class="flex items-center">
          <a href="#" class="font-jost text-[16px] text-black px-[15px] hover:text-[#707070]">Store</a>
          <a href="#" class="font-jost text-[16px] text-black px-[15px] hover:text-[#707070]">Blog</a>
          <a href="#" class="font-jost text-[16px] text-black px-[15px] hover:text-[#707070]">Contact us</a>
        </nav>

        <div class="flex items-center gap-[14px]">
          <a href="<?= e($accountHref) ?>" class="p-[2px]" aria-label="My Account">
            <i class="fa-regular fa-user text-[18px]" aria-hidden="true"></i>
          </a>
          <button type="button" class="p-[2px]" aria-label="Wishlist">
            <i class="fa-regular fa-heart text-[18px]" aria-hidden="true"></i>
          </button>

          <a href="#" class="flex items-center gap-[8px]" aria-label="Cart">
            <span class="relative inline-flex">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
              </svg>

              <span class="absolute -top-[6px] -right-[6px] min-w-[16px] h-[16px] px-[4px] text-[10px] leading-[16px] rounded-full bg-black text-white text-center">0</span>
            </span>
            <span class="font-jost text-[14px] leading-[18px]">My Bag</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Main header (mobile/tablet) -->
  <header class="lg:hidden">
    <div class="flex items-center justify-between bg-white px-[20px] py-[18px]">
      <a href="/" class="inline-flex items-center">
        <img src="/assets/images/2025/06/For-Website-YEFA-LOGO.png" alt="" class="h-[40px] w-auto" loading="lazy">
      </a>

      <div class="flex items-center gap-[14px]">
        <a href="<?= e($accountHref) ?>" class="p-[2px]" aria-label="My Account">
          <i class="fa-regular fa-user text-[18px]" aria-hidden="true"></i>
        </a>

        <a href="#" class="relative p-[2px]" aria-label="Cart">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
          </svg>

          <span class="absolute -top-[6px] -right-[6px] min-w-[16px] h-[16px] px-[4px] text-[10px] leading-[16px] rounded-full bg-black text-white text-center">0</span>
        </a>

        <button id="mobileMenuOpen" type="button" class="p-[2px]" aria-label="Menu">
          <i class="fa-solid fa-bars text-[22px]" aria-hidden="true"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- Mobile off-canvas menu -->
  <div id="mobileMenuBackdrop" class="fixed inset-0 bg-black/50 hidden z-40" aria-hidden="true"></div>
  <aside id="mobileMenuPanel" class="fixed inset-y-0 right-0 w-[320px] bg-white z-50 translate-x-full transition-transform duration-200" aria-label="Mobile Menu" aria-hidden="true">
    <div class="flex items-center justify-between px-[20px] py-[18px] border-b border-black/10">
      <span class="font-jost text-[16px]">Menu</span>
      <button id="mobileMenuClose" type="button" class="p-[6px]" aria-label="Close Menu"><i class="fa-solid fa-xmark text-[18px]" aria-hidden="true"></i></button>
    </div>

    <nav class="px-[20px] py-[20px]" aria-label="Mobile Primary">
      <ul class="space-y-[12px]">
        <li><a href="/" class="font-jost text-[16px]">Home</a></li>
        <li><a href="#" class="font-jost text-[16px]">Store</a></li>
        <li><a href="#" class="font-jost text-[16px]">About us</a></li>
        <li><a href="#" class="font-jost text-[16px]">Blog</a></li>
        <li><a href="#" class="font-jost text-[16px]">Booking page</a></li>
        <li><a href="#" class="font-jost text-[16px]">Request page</a></li>
        <li><a href="#" class="font-jost text-[16px]">Contact us</a></li>
        <li><a href="<?= e($accountHref) ?>" class="font-jost text-[16px]">My Account</a></li>
      </ul>
    </nav>
  </aside>

  <main id="main" class="site-main">
