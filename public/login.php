<?php

require __DIR__ . '/../src/bootstrap.php';

$email = '';
$registerEmail = '';
$error = null;
$success = flash_get('auth_success');
$flashError = flash_get('auth_error');
if ($flashError) {
  $error = $flashError;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_logged_in()) {
  redirect('my-account.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate()) {
        $error = 'Security check failed. Please try again.';
  } else {
    $action = isset($_POST['action']) && is_string($_POST['action']) ? $_POST['action'] : 'login';

    if ($action === 'logout') {
      auth_logout();
      flash_set('auth_success', 'Signed out.');
      redirect('login.php');
    }

    if ($action === 'register') {
      $registerEmail = isset($_POST['register_email']) && is_string($_POST['register_email']) ? trim($_POST['register_email']) : '';
      $registerEmail = strtolower($registerEmail);
      $registerPassword = isset($_POST['register_password']) && is_string($_POST['register_password']) ? (string) $_POST['register_password'] : '';

      if ($registerEmail === '' || filter_var($registerEmail, FILTER_VALIDATE_EMAIL) === false) {
        $error = 'Please enter a valid email address.';
      } elseif (strlen($registerEmail) > 190) {
        $error = 'Email address is too long.';
      } elseif ($registerPassword === '') {
        $error = 'Please enter a password.';
      } else {
        try {
          $existing = auth_user_find_by_email($registerEmail);
          if ($existing) {
            $error = 'An account is already registered with that email address.';
          } else {
            $user = auth_user_create($registerEmail, $registerPassword);
            auth_set_logged_in_user($user);
            flash_set('auth_success', 'Account created successfully.');
            redirect('my-account.php');
          }
        } catch (Throwable $e) {
          $msg = $e->getMessage();
          if (stripos($msg, 'users') !== false && (stripos($msg, 'not found') !== false || stripos($msg, 'no such table') !== false)) {
            $error = 'Database schema is missing. Import database/schema.mysql.sql (or database/schema.sqlite.sql) into your database.';
          } elseif (!db_is_configured()) {
            $error = 'Database is not configured. Set YEFA_DB_DSN (and YEFA_DB_USER/YEFA_DB_PASS if needed).';
          } elseif (stripos($msg, 'unable to open database file') !== false || stripos($msg, 'not writable') !== false) {
            $error = 'SQLite path is not writable on this host. Set YEFA_DB_DSN to a writable (and ideally persistent) path.';
          } else {
            $error = 'Database error. Please try again.';
          }
        }
      }
    } else {
      $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';
      $email = strtolower($email);
      $password = isset($_POST['password']) && is_string($_POST['password']) ? (string) $_POST['password'] : '';

      if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $error = 'Please enter a valid email address.';
      } elseif ($password === '') {
        $error = 'Please enter your password.';
      } else {
        try {
          $user = auth_user_find_by_email($email);
          $hash = is_array($user) && isset($user['password_hash']) ? (string) $user['password_hash'] : '';

          if (!$user || $hash === '' || !password_verify($password, $hash)) {
            $error = 'Invalid email or password.';
          } else {
            auth_set_logged_in_user($user);
            redirect('my-account.php');
          }
        } catch (Throwable $e) {
          $msg = $e->getMessage();
          if (stripos($msg, 'users') !== false && (stripos($msg, 'not found') !== false || stripos($msg, 'no such table') !== false)) {
            $error = 'Database schema is missing. Import database/schema.mysql.sql (or database/schema.sqlite.sql) into your database.';
          } elseif (!db_is_configured()) {
            $error = 'Database is not configured. Set YEFA_DB_DSN (and YEFA_DB_USER/YEFA_DB_PASS if needed).';
          } elseif (stripos($msg, 'unable to open database file') !== false || stripos($msg, 'not writable') !== false) {
            $error = 'SQLite path is not writable on this host. Set YEFA_DB_DSN to a writable (and ideally persistent) path.';
          } else {
            $error = 'Database error. Please try again.';
          }
        }
      }
    }
  }
}

$pageTitle = 'My Account';

require __DIR__ . '/../src/partials/layout-top.php';
?>

<section class="px-[20px] lg:px-[10px] pt-[30px] pb-[60px]">
  <div class="max-w-[1200px] mx-auto">
    <?php if ($error || $success): ?>
      <div class="mb-[16px] space-y-[10px]">
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

    <div class="border border-black rounded-[18px] px-[18px] md:px-[30px] lg:px-[40px] py-[26px] md:py-[30px] lg:py-[40px]">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-[30px] lg:gap-[60px]">
        <!-- Login -->
        <div>
          <h2 class="font-jost text-[22px] md:text-[24px] font-medium text-black">Login</h2>

          <div class="mt-[14px] border border-black rounded-[3px] px-[18px] py-[18px]">
            <form method="post" novalidate>
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="login">

              <div class="space-y-[14px]">
                <div>
                  <label for="username" class="block font-roboto text-[13px] font-semibold text-black">
                    Username or email address <span class="text-red-600">*</span>
                  </label>
                  <input
                    type="email"
                    name="email"
                    id="username"
                    autocomplete="email"
                    value="<?= e($email) ?>"
                    required
                    class="mt-[8px] w-full border border-black/30 px-[12px] py-[9px] font-roboto text-[14px] outline-none focus:border-black"
                  >
                </div>

                <div>
                  <label for="login_password" class="block font-roboto text-[13px] font-semibold text-black">
                    Password <span class="text-red-600">*</span>
                  </label>
                  <div class="relative mt-[8px]">
                    <input
                      type="password"
                      name="password"
                      id="login_password"
                      autocomplete="current-password"
                      required
                      class="w-full border border-black/30 px-[12px] py-[9px] pr-[38px] font-roboto text-[14px] outline-none focus:border-black"
                    >
                    <button
                      type="button"
                      id="toggleLoginPassword"
                      class="absolute right-[10px] top-1/2 -translate-y-1/2 text-black/60"
                      aria-label="Toggle password visibility"
                    >
                      <i class="fa-regular fa-eye" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>

                <label class="inline-flex items-center gap-[8px] font-roboto text-[13px] text-black">
                  <input type="checkbox" name="rememberme" value="1" class="border border-black/40">
                  <span>Remember me</span>
                </label>

                <div class="pt-[2px]">
                  <button type="submit" class="inline-flex items-center justify-center bg-black text-white border border-black font-roboto text-[14px] px-[18px] py-[10px]">
                    Log in
                  </button>
                </div>

                <div>
                  <a href="#" class="font-roboto text-[13px] text-black hover:underline">Lost your password?</a>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Register -->
        <div>
          <h2 class="font-jost text-[22px] md:text-[24px] font-medium text-black">Register</h2>

          <div class="mt-[14px] border border-black rounded-[3px] px-[18px] py-[18px]">
            <form method="post" novalidate>
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="register">

              <div class="space-y-[14px]">
                <div>
                  <label for="register_email" class="block font-roboto text-[13px] font-semibold text-black">
                    Email address <span class="text-red-600">*</span>
                  </label>
                  <input
                    type="email"
                    name="register_email"
                    id="register_email"
                    autocomplete="email"
                    value="<?= e($registerEmail) ?>"
                    required
                    class="mt-[8px] w-full border border-black/30 px-[12px] py-[9px] font-roboto text-[14px] outline-none focus:border-black"
                  >
                </div>

                <div>
                  <label for="register_password" class="block font-roboto text-[13px] font-semibold text-black">
                    Password <span class="text-red-600">*</span>
                  </label>
                  <div class="relative mt-[8px]">
                    <input
                      type="password"
                      name="register_password"
                      id="register_password"
                      autocomplete="new-password"
                      required
                      class="w-full border border-black/30 px-[12px] py-[9px] pr-[38px] font-roboto text-[14px] outline-none focus:border-black"
                    >
                    <button
                      type="button"
                      id="toggleRegisterPassword"
                      class="absolute right-[10px] top-1/2 -translate-y-1/2 text-black/60"
                      aria-label="Toggle password visibility"
                    >
                      <i class="fa-regular fa-eye" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>

                <p class="font-roboto text-[12px] leading-[18px] text-black/70">
                  Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.
                </p>

                <div class="pt-[2px]">
                  <button type="submit" class="inline-flex items-center justify-center bg-black text-white border border-black font-roboto text-[14px] px-[18px] py-[10px]">
                    Register
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    function togglePassword(inputId, buttonId) {
      var input = document.getElementById(inputId);
      var btn = document.getElementById(buttonId);
      if (!input || !btn) return;

      btn.addEventListener('click', function () {
        input.type = (input.type === 'password') ? 'text' : 'password';
      });
    }

    togglePassword('login_password', 'toggleLoginPassword');
    togglePassword('register_password', 'toggleRegisterPassword');
  })();
</script>

<?php
require __DIR__ . '/../src/partials/layout-bottom.php';
