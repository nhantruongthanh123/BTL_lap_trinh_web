<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Đăng nhập hệ thống quản trị - Bookstore Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>

    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
        --tblr-font-sans-serif: 'Inter var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body { font-family: var(--tblr-font-sans-serif); }
      
      .page-center {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      }
      .card {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        border: none;
      }
    </style>
  </head>

  <body class="d-flex flex-column">
    <div class="page page-center">
      <div class="container container-tight py-4">
        
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark">
            <h1 class="m-0 text-white" style="font-weight: 800;">
              <i class="ti ti-book me-2"></i>BOOKSTORE <span class="text-primary-light">ADMIN</span>
            </h1>
          </a>
        </div>

        <div class="card card-md">
          <div class="card-body p-5">
            <h2 class="h2 text-center mb-4">Đăng nhập để tiếp tục</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="ti ti-alert-circle me-2 fs-3"></i>
                    <div><?php echo $error; ?></div>
                </div>
            <?php endif; ?>

            <form action="<?php echo WEBROOT; ?>/admin/loginProcess" method="POST" autocomplete="off">
              
              <div class="mb-3">
                <label class="form-label">Tên đăng nhập hoặc Email</label>
                <div class="input-icon">
                  <span class="input-icon-addon"><i class="ti ti-user"></i></span>
                  <input type="text" class="form-control" name="username" placeholder="Nhập tài khoản admin" required autofocus>
                </div>
              </div>
              
              <div class="mb-3">
                <label class="form-label">
                  Mật khẩu
                </label>
                <div class="input-group input-group-flat">
                  <span class="input-group-text"><i class="ti ti-lock"></i></span>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" required>
                  <span class="input-group-text cursor-pointer" onclick="togglePass(this)">
                    <a href="#" class="link-secondary text-decoration-none" title="Hiện/ẩn mật khẩu" data-bs-toggle="tooltip">
                      <i class="ti ti-eye"></i>
                    </a>
                  </span>
                </div>
              </div>
              
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100 py-2 fs-3 fw-bold">
                  <i class="ti ti-login me-2"></i> Đăng nhập hệ thống
                </button>
              </div>

            </form>
          </div>
        </div>
        
        <div class="text-center text-white mt-3">
          Quay lại <a href="<?php echo WEBROOT; ?>" class="text-white fw-bold" tabindex="-1">Trang chủ bán hàng</a>
        </div>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js" defer></script>
    
    <script>
      function togglePass(span) {
        const input = document.getElementById('password');
        const icon = span.querySelector('i');
        if (input.type === "password") {
          input.type = "text";
          icon.classList.remove('ti-eye');
          icon.classList.add('ti-eye-off');
        } else {
          input.type = "password";
          icon.classList.remove('ti-eye-off');
          icon.classList.add('ti-eye');
        }
      }
    </script>
  </body>
</html>