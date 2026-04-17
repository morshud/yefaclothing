<?php

require __DIR__ . '/../src/bootstrap.php';

if (!is_logged_in()) {
    flash_set('auth_error', 'Please log in to access your account.');
  redirect('login.php');
}

$error = null;
$success = flash_get('auth_success');
$flashError = flash_get('auth_error');
if ($flashError) {
    $error = $flashError;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate()) {
        flash_set('auth_error', 'Security check failed. Please try again.');
  redirect('my-account.php');
    }

    if (isset($_POST['action']) && $_POST['action'] === 'logout') {
    auth_logout();
        flash_set('auth_success', 'Signed out.');
      redirect('login.php');
    }
}

$pageTitle = 'My Account';

require __DIR__ . '/../src/partials/layout-top.php';

$userEmail = (string) current_user_email();
$userName = $userEmail;
$atPos = strpos($userEmail, '@');
if ($atPos !== false) {
    $userName = substr($userEmail, 0, $atPos);
}
?>

<section class="px-[20px] lg:px-[40px] pt-[20px] pb-[60px]">
  <div class="max-w-[1400px] mx-auto">
    <?php if ($error || $success): ?>
      <div class="mb-[14px] space-y-[10px]">
        <?php if ($error): ?>
          <div class="border border-red-500 bg-red-50 text-red-800 px-[14px] py-[12px] font-roboto text-[14px]" role="alert">
            <?= e($error) ?>
          </div>
        <?php endif; ?>

        <?php if ($success): ?>
          <div class="border border-green-600 bg-green-50 text-green-800 px-[14px] py-[12px] font-roboto text-[14px]" role="alert">
            <?= e($success) ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <!-- Hero -->
    <div class="h-[180px] md:h-[210px] w-full rounded-[14px] bg-gradient-to-b from-neutral-500 to-neutral-800 flex items-center justify-center">
      <h1 class="font-jost text-white font-bold text-[38px] sm:text-[65px] md:text-[58px] drop-shadow-sm">Account Overview</h1>
    </div>

    <div class="mt-[18px] grid grid-cols-1 lg:grid-cols-[550px_1fr] gap-[18px]">
      <!-- Left navigation -->
      <aside class="border border-[#334155] rounded-[12px] bg-[#F3F3F3] px-[22px] py-[22px]">
        <nav aria-label="My Account" class="w-full py-10">
          <ul class="space-y-[15px]">
            <li>
              <a href="#" class="mx-auto flex w-full max-w-[280px] items-center justify-center rounded-full border border-black/40 bg-white py-3 font-jost text-[14px] font-semibold uppercase tracking-wide">
                Dashboard
              </a>
            </li>
            <li>
              <a href="#" class="mx-auto flex w-full max-w-[280px] items-center justify-center rounded-full border border-black/40 bg-white py-3 font-jost text-[14px] font-semibold uppercase tracking-wide">
                Orders
              </a>
            </li>
            <li>
              <a href="#" class="mx-auto flex w-full max-w-[280px] items-center justify-center rounded-full border border-black/40 bg-white py-3 font-jost text-[14px] font-semibold uppercase tracking-wide">
                Addresses
              </a>
            </li>
            <li>
              <a href="#" class="mx-auto flex w-full max-w-[280px] items-center justify-center rounded-full border border-black/40 bg-white py-3 font-jost text-[14px] font-semibold uppercase tracking-wide">
                Account Details
              </a>
            </li>
            <li>
              <a href="#" class="mx-auto flex w-full max-w-[280px] items-center justify-center rounded-full border border-black/40 bg-white py-3 font-jost text-[14px] font-semibold uppercase tracking-wide">
                Wishlist
              </a>
            </li>
            <li>
              <a href="#" class="mx-auto flex w-full max-w-[280px] items-center justify-center rounded-full border border-black/40 bg-white py-3 font-jost text-[14px] font-semibold uppercase tracking-wide">
                My Wallet
              </a>
            </li>
            <li class="pt-[4px]">
              <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="logout">
                <button
                  type="submit"
                  class="mx-auto flex w-full max-w-[280px] items-center justify-center rounded-full border border-black bg-black py-3 font-jost text-[14px] font-semibold uppercase tracking-wide text-white"
                >
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </nav>
      </aside>

      <!-- Right content -->
      <div class="border border-[#334155] rounded-[12px] bg-white px-[26px] py-[26px] min-h-[340px] flex items-center justify-center">
        <div class="w-full max-w-[640px] text-center">
          <div class="font-roboto text-[14px] text-black/70">
            Hello <span class="font-semibold text-black/80"><?= e($userName) ?></span>
            <span class="text-black/60">(not <?= e($userName) ?>?</span>
            <form method="post" class="inline">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="logout">
              <button type="submit" class="underline underline-offset-2 hover:text-black">Log out</button>
            </form>
            <span class="text-black/60">)</span>
          </div>

          <p class="mt-[10px] font-roboto text-[14px] text-black/60">
            From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require __DIR__ . '/../src/partials/layout-bottom.php';
