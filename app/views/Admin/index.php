<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Tổng quan</div>
        <h2 class="page-title">Dashboard Quản Trị</h2>
      </div>
      <div class="col-auto ms-auto">
        <div class="btn-list">
          <a href="<?php echo WEBROOT; ?>/admin/orders" class="btn btn-primary">
            <i class="ti ti-shopping-cart me-2"></i>Xem đơn hàng
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    
    <!-- Thống kê tổng quan -->
    <div class="row row-deck row-cards mb-4">
      
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-primary text-white avatar">
                  <i class="ti ti-users fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Khách hàng</div>
                <div class="text-secondary h2 mb-0"><?php echo number_format($totalCustomers); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-green text-white avatar">
                  <i class="ti ti-shopping-cart fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Đơn hàng</div>
                <div class="text-secondary h2 mb-0"><?php echo number_format($totalOrders); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-yellow text-white avatar">
                  <i class="ti ti-book fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Sản phẩm</div>
                <div class="text-secondary h2 mb-0"><?php echo number_format($totalBooks); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-info text-white avatar">
                  <i class="ti ti-currency-dollar fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Doanh thu</div>
                <div class="text-secondary h3 mb-0"><?php echo number_format($sumRevenue, 0, ',', '.'); ?>đ</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="row row-deck row-cards">
      
      <!-- Biểu đồ doanh thu 7 ngày -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Doanh thu 7 ngày gần nhất</h3>
          </div>
          <div class="card-body">
            <div id="chart-revenue" style="min-height: 300px;"></div>
          </div>
        </div>
      </div>

      <!-- Thống kê trạng thái đơn hàng -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Trạng thái đơn hàng</h3>
          </div>
          <div class="card-body">
            <div id="chart-order-status" style="min-height: 300px;"></div>
          </div>
        </div>
      </div>

      <!-- Đơn hàng gần đây -->
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Đơn hàng gần đây</h3>
          </div>
          <div class="table-responsive">
            <table class="table table-vcenter card-table">
              <thead>
                <tr>
                  <th>Mã đơn</th>
                  <th>Khách hàng</th>
                  <th>Ngày đặt</th>
                  <th>Tổng tiền</th>
                  <th>Trạng thái</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($recentOrders)): ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                    <i class="ti ti-inbox fs-1 mb-2"></i>
                    <p>Chưa có đơn hàng nào</p>
                  </td>
                </tr>
                <?php else: ?>
                  <?php foreach ($recentOrders as $order): ?>
                  <tr>
                    <td class="text-secondary">
                      <?php echo htmlspecialchars($order['order_number']); ?>
                    </td>
                    <td class="text-secondary"><?php echo htmlspecialchars($order['full_name']); ?></td>
                    <td class="text-secondary"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                    <td class="text-secondary fw-bold"><?php echo number_format($order['final_amount'], 0, ',', '.'); ?>đ</td>
                    <td>
                      <?php
                      $badges = [
                          'pending' => 'badge bg-yellow',
                          'confirmed' => 'badge bg-blue',
                          'shipping' => 'badge bg-cyan',
                          'delivered' => 'badge bg-green',
                          'cancelled' => 'badge bg-red'
                      ];
                      $statusText = [
                          'pending' => 'Chờ xác nhận',
                          'confirmed' => 'Đã xác nhận',
                          'shipping' => 'Đang giao',
                          'delivered' => 'Đã giao',
                          'cancelled' => 'Đã hủy'
                      ];
                      ?>
                      <span class="<?php echo $badges[$order['status']]; ?>">
                        <?php echo $statusText[$order['status']]; ?>
                      </span>
                    </td>
                    <td class="text-end">
                      <a href="<?php echo WEBROOT; ?>/admin/orderDetail/<?php echo $order['order_id']; ?>" class="btn btn-sm btn-primary">
                        Chi tiết
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <?php if (!empty($recentOrders)): ?>
          <div class="card-footer text-center">
            <a href="<?php echo WEBROOT; ?>/admin/orders" class="btn btn-link">
              Xem tất cả đơn hàng <i class="ti ti-arrow-right ms-1"></i>
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    
    // 1. Biểu đồ Doanh thu 7 ngày
    <?php
    $dates = [];
    $revenues = [];
    foreach ($weeklyRevenue as $item) {
        $dayName = date('d/m', strtotime($item['date']));
        $dates[] = "'" . $dayName . "'";
        $revenues[] = $item['revenue'];
    }
    ?>
    
    var optionsRevenue = {
      series: [{
        name: 'Doanh thu',
        data: [<?php echo implode(',', $revenues); ?>]
      }],
      chart: {
        type: 'area',
        height: 300,
        toolbar: { show: false },
        zoom: { enabled: false }
      },
      dataLabels: { enabled: false },
      stroke: { 
        curve: 'smooth',
        width: 3
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          opacityTo: 0.1,
          stops: [0, 100]
        }
      },
      xaxis: {
        categories: [<?php echo implode(',', $dates); ?>],
        labels: {
          style: {
            fontSize: '12px'
          }
        }
      },
      yaxis: {
        labels: {
          formatter: function (value) {
            return new Intl.NumberFormat('vi-VN').format(value);
          }
        }
      },
      colors: ['#206bc4'],
      tooltip: {
        y: {
          formatter: function (value) {
            return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
          }
        }
      },
      grid: {
        borderColor: '#e7e7e7',
        strokeDashArray: 5
      }
    };
    var chartRevenue = new ApexCharts(document.querySelector("#chart-revenue"), optionsRevenue);
    chartRevenue.render();

    // 2. Biểu đồ Trạng thái đơn hàng (Donut Chart)
    <?php
    $statusNames = [
        'pending' => 'Chờ xác nhận',
        'confirmed' => 'Đã xác nhận',
        'shipping' => 'Đang giao',
        'delivered' => 'Đã giao',
        'cancelled' => 'Đã hủy'
    ];
    
    $statusLabels = [];
    $statusCounts = [];
    foreach ($orderStats as $stat) {
        $statusLabels[] = "'" . $statusNames[$stat['status']] . "'";
        $statusCounts[] = $stat['count'];
    }
    ?>
    
    var optionsOrderStatus = {
      series: [<?php echo implode(',', $statusCounts); ?>],
      chart: {
        type: 'donut',
        height: 300
      },
      labels: [<?php echo implode(',', $statusLabels); ?>],
      colors: ['#f59f00', '#206bc4', '#4299e1', '#2fb344', '#d63939'],
      legend: {
        position: 'bottom',
        fontSize: '13px'
      },
      plotOptions: {
        pie: {
          donut: {
            size: '70%',
            labels: {
              show: true,
              total: {
                show: true,
                label: 'Tổng đơn',
                fontSize: '14px',
                color: '#666',
                formatter: function (w) {
                  return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                }
              }
            }
          }
        }
      },
      dataLabels: {
        enabled: false
      }
    };
    var chartOrderStatus = new ApexCharts(document.querySelector("#chart-order-status"), optionsOrderStatus);
    chartOrderStatus.render();

  });
</script>