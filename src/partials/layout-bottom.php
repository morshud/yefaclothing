  </main>

  <footer class="bg-black text-white">
    <!-- Footer top -->
    <div class="flex flex-col md:flex-row md:gap-[40px] gap-[10px] pt-[20px] pb-[20px] px-[20px] md:pt-[120px] md:pb-[20px] md:px-[80px]">
      <!-- Newsletter -->
      <div class="md:w-[30%]">
        <h2 class="font-jost text-[25px] font-normal leading-tight">
          Sign up to get 10% off your first order and stay up to date on the latest product releases, special offers and news
        </h2>

        <form action="#" method="post" class="mt-[18px]">
          <div class="flex gap-[10px]">
            <input
              type="email"
              name="email"
              placeholder="Email Address"
              autocomplete="email"
              class="w-full bg-transparent border border-white/60 text-white placeholder:text-white/70 px-[12px] py-[10px] outline-none"
              required
            >
            <button type="submit" class="border border-white px-[16px] py-[10px] font-roboto text-[14px]">Subscribe</button>
          </div>
        </form>

        <!-- Social (shown on mobile in the export) -->
        <div class="mt-[18px] flex items-center gap-[7px] md:hidden">
          <a href="#" class="inline-flex items-center justify-center w-[28px] h-[28px] border border-white rounded-full" aria-label="Facebook">
            <i class="fa-brands fa-facebook-f text-[12px]" aria-hidden="true"></i>
          </a>
          <a href="#" class="inline-flex items-center justify-center w-[28px] h-[28px] border border-white rounded-full" aria-label="Twitter">
            <i class="fa-brands fa-twitter text-[12px]" aria-hidden="true"></i>
          </a>
          <a href="#" class="inline-flex items-center justify-center w-[28px] h-[28px] border border-white rounded-full" aria-label="Youtube">
            <i class="fa-brands fa-youtube text-[12px]" aria-hidden="true"></i>
          </a>
        </div>
      </div>

      <!-- Menu -->
      <div class="md:w-[20%]">
        <h3 class="font-jost text-[25px] font-medium underline">Menu</h3>
        <ul class="mt-[10px]">
          <li><a href="#" class="block py-[15px] font-roboto text-[14px]">Booking page</a></li>
          <li><a href="#" class="block py-[15px] font-roboto text-[14px]">Request page</a></li>
          <li><a href="#" class="block py-[15px] font-roboto text-[14px]">FAQ</a></li>
          <li><a href="#" class="block py-[15px] font-roboto text-[14px]">About us</a></li>
        </ul>
      </div>

      <!-- Links -->
      <div class="md:w-[20%]">
        <h3 class="font-jost text-[25px] font-medium underline">Links</h3>
        <ul class="mt-[10px]">
          <li><a href="#" class="block py-[15px] font-roboto text-[14px]">Terms and Condition</a></li>
          <li><a href="#" class="block py-[15px] font-roboto text-[14px]">Return Policy</a></li>
          <li><a href="#" class="block py-[15px] font-roboto text-[14px]">Shipping Policy</a></li>
          <li><a href="#" class="block py-[15px] font-roboto text-[14px]">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- Contact (labeled "Links" in the export) -->
      <div class="md:w-[30%]">
        <h3 class="font-jost text-[25px] font-medium underline">Links</h3>
        <div class="mt-[12px] space-y-[12px] font-roboto text-[14px]">
          <p class="flex items-start gap-[10px]"><i class="fa-solid fa-phone text-[14px] mt-[2px]" aria-hidden="true"></i><span><span>Phone: </span><span>+234-8123549266</span></span></p>
          <p class="flex items-start gap-[10px]"><i class="fa-regular fa-clock text-[14px] mt-[2px]" aria-hidden="true"></i><span>Monday – Friday: 10:00-6:00 PM</span></p>
          <p class="flex items-start gap-[10px]"><i class="fa-solid fa-location-dot text-[14px] mt-[2px]" aria-hidden="true"></i><span>Lagos, Nigeria</span></p>
        </div>

        <div class="mt-[18px] flex items-center gap-[7px]">
          <a href="#" class="inline-flex items-center justify-center w-[28px] h-[28px] border border-white rounded-full" aria-label="Facebook">
            <i class="fa-brands fa-facebook-f text-[12px]" aria-hidden="true"></i>
          </a>
          <a href="#" class="inline-flex items-center justify-center w-[28px] h-[28px] border border-white rounded-full" aria-label="Twitter">
            <i class="fa-brands fa-twitter text-[12px]" aria-hidden="true"></i>
          </a>
          <a href="#" class="inline-flex items-center justify-center w-[28px] h-[28px] border border-white rounded-full" aria-label="Youtube">
            <i class="fa-brands fa-youtube text-[12px]" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Footer bottom -->
    <div class="px-[20px] md:px-[30px] pb-[20px] md:pb-[30px]">
      <div class="border-t border-[#747474] pt-[2px] pb-[2px]"></div>
      <div class="mt-[15px] font-jost font-normal text-[14px] text-[#DFDFDF]">© 2026 yefaclothing. All Rights Reserved </div>
    </div>
  </footer>

  <script>
    (function ($) {
      function openMobileMenu() {
        $('#mobileMenuBackdrop').removeClass('hidden');
        $('#mobileMenuPanel').attr('aria-hidden', 'false').removeClass('translate-x-full');
        $('body').addClass('overflow-hidden');
      }

      function closeMobileMenu() {
        $('#mobileMenuBackdrop').addClass('hidden');
        $('#mobileMenuPanel').attr('aria-hidden', 'true').addClass('translate-x-full');
        $('body').removeClass('overflow-hidden');
      }

      $(function () {
        $('#mobileMenuOpen').on('click', openMobileMenu);
        $('#mobileMenuClose').on('click', closeMobileMenu);
        $('#mobileMenuBackdrop').on('click', closeMobileMenu);

        $(document).on('keydown', function (e) {
          if (e.key === 'Escape') {
            closeMobileMenu();
          }
        });
      });
    })(jQuery);
  </script>
</body>
</html>
