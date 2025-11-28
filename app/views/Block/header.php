<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : 'Bookstore - Nhà sách Online'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo WEBROOT; ?>/public/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?php echo WEBROOT; ?>">
        <i class="fas fa-book-reader me-2"></i>BOOKSTORE
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="mainMenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link active" href="<?php echo WEBROOT; ?>">Trang chủ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo WEBROOT; ?>/product">Sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Giới thiệu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Liên hệ</a>
        </li>
      </ul>
      
      <div class="d-flex align-items-center gap-3">
        <form class="d-flex" role="search">
            <div class="input-group input-group-sm">
                <input class="form-control" type="search" placeholder="Tìm sách..." aria-label="Search">
                <button class="btn btn-light" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <a href="<?php echo WEBROOT; ?>/cart" class="btn btn-outline-light position-relative border-0">
            <i class="fas fa-shopping-cart fa-lg"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                0
            </span>
        </a>
        
        <a href="<?php echo WEBROOT; ?>/user/login" class="btn btn-light btn-sm fw-bold text-primary">
            Đăng nhập
        </a>
      </div>
    </div>
  </div>
</nav>

<div class="container my-4 flex-grow-1">