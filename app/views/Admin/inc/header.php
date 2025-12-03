<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?php echo $data['title']; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
    
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root { font-family: 'Inter var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; }
    </style>
  </head>
  <body class="layout-fluid">
    <div class="page">
      
      <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <h1 class="navbar-brand navbar-brand-autodark">
            <a href="<?php echo WEBROOT; ?>/admin" class="text-decoration-none text-white">
               BOOKSTORE ADMIN
            </a>
          </h1>
          
          <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
              
              <li class="nav-item <?php echo ($data['page'] == 'dashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo WEBROOT; ?>/admin">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-dashboard"></i>
                  </span>
                  <span class="nav-link-title">Dashboard</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo WEBROOT; ?>" target="_blank">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-world"></i>
                  </span>
                  <span class="nav-link-title">Xem trang web</span>
                </a>
              </li>

              <hr class="my-2 border-secondary">

              <li class="nav-item">
                <a class="nav-link" href="<?php echo WEBROOT; ?>/admin/books">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-book"></i>
                  </span>
                  <span class="nav-link-title">Quản lý Sách</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo WEBROOT; ?>/admin/categories">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-category"></i>
                  </span>
                  <span class="nav-link-title"> Danh mục </span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href=" <?php echo WEBROOT; ?>/admin/authors">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-user-edit"></i>
                  </span>
                  <span class="nav-link-title"> Tác giả </span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href=" <?php echo WEBROOT; ?>/admin/publishers">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-writing"></i>
                  </span>
                  <span class="nav-link-title"> Nhà xuất bản </span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo WEBROOT; ?>/admin/orders">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-shopping-cart"></i>
                  </span>
                  <span class="nav-link-title">Đơn hàng</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-users"></i>
                  </span>
                  <span class="nav-link-title">Khách hàng</span>
                </a>
              </li>

            </ul>
          </div>
        </div>
      </aside>

      <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                <span class="avatar avatar-sm" style="background-image: url('<?php echo WEBROOT; ?>/public/assets/Admin/<?php echo $_SESSION['avatar'] ?? 'default-avatar.png'; ?>')"></span>
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo $_SESSION['full_name']; ?></div>
                  <div class="mt-1 small text-muted">Administrator</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="<?php echo WEBROOT; ?>/user/logout" class="dropdown-item">Đăng xuất</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu">
          </div>
        </div>
      </header>

      <div class="page-wrapper">