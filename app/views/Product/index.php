<div class="container">
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo WEBROOT; ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-primary border-bottom pb-2">
                <?php echo isset($data['title']) ? $data['title'] : 'Danh sách sản phẩm'; ?>
            </h2>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $book): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        
                        <div class="position-relative overflow-hidden" style="height: 320px;">
                             <?php 
                                $imgName = !empty($book['cover_image']) ? $book['cover_image'] : 'default-book.jpg';
                                $imgPath = WEBROOT . '/public/images/' . $imgName;
                            ?>
                            <img src="<?php echo $imgPath; ?>" class="card-img-top w-100 h-100 object-fit-cover" alt="<?php echo $book['title']; ?>">
                            
                            <?php if(isset($book['discount_price']) && $book['discount_price'] > 0): ?>
                                <span class="position-absolute top-0 start-0 badge bg-danger m-2">Giảm giá</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-truncate" title="<?php echo $book['title']; ?>">
                                <a href="#" class="text-decoration-none text-dark fw-bold stretched-link">
                                    <?php echo $book['title']; ?>
                                </a>
                            </h6>
                            
                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-5 fw-bold text-primary"><?php echo number_format($book['price'], 0, ',', '.'); ?> đ</span>
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="Thêm vào giỏ">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-box-open fa-3x mb-3"></i><br>
                    Hiện tại chưa có sản phẩm nào trong danh mục này.
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Sau</a></li>
        </ul>
    </nav>
</div>