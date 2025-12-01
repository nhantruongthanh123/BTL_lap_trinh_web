<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Tổng quan</div>
        <h2 class="page-title">Ecommerce Dashboard</h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    
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
                <div class="text-muted"> <?php echo $totalCustomers; ?> </div>
              </div>
              <!-- <div class="col-auto align-self-center">
                 <div class="badge bg-green-lt text-green">+11% <i class="ti ti-arrow-up"></i></div>
              </div> -->
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
                <div class="text-muted"> <?php echo $totalOrders; ?> </div>
              </div>
              <!-- <div class="col-auto align-self-center">
                 <div class="badge bg-red-lt text-red">-9% <i class="ti ti-arrow-down"></i></div>
              </div> -->
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
                  <i class="ti ti-box fs-2"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Sản phẩm</div>
                <div class="text-muted"> <?php echo $totalBooks; ?> </div>
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
                <div class="text-muted"><?php echo number_format($sumRevenue, 0, ',', '.'); ?> VND</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="row row-deck row-cards">
      
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header border-0">
            <div class="card-title">Doanh số hàng tháng</div>
          </div>
          <div class="card-body">
            <div id="chart-sales" style="min-height: 300px;"></div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card">
          <div class="card-header border-0">
            <div class="card-title">Mục tiêu tháng</div>
          </div>
          <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <div id="chart-target" style="min-height: 250px;"></div>
            <div class="text-center mt-3">
                <p class="text-muted mb-1">Doanh thu thực tế</p>
                <h2 class="text-primary fw-bold">$3,287</h2>
                <small class="text-success">Rất tốt, tiếp tục phát huy!</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header border-0 d-flex justify-content-between">
            <h3 class="card-title">Thống kê truy cập</h3>
            <div class="d-flex">
                <select class="form-select form-select-sm me-2">
                    <option>7 ngày qua</option>
                    <option>Tháng này</option>
                </select>
            </div>
          </div>
          <div class="card-body">
            <div id="chart-stats" style="min-height: 300px;"></div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    
    // 1. Cấu hình Biểu đồ Cột (Sales)
    var optionsSales = {
      series: [{
        name: 'Doanh thu',
        data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
      }, {
        name: 'Lợi nhuận',
        data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
      }],
      chart: {
        type: 'bar',
        height: 350,
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded',
          borderRadius: 4
        },
      },
      dataLabels: { enabled: false },
      stroke: { show: true, width: 2, colors: ['transparent'] },
      xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
      },
      colors: ['#4263eb', '#e1e6f9'], // Màu xanh Tabler
      fill: { opacity: 1 },
    };
    var chartSales = new ApexCharts(document.querySelector("#chart-sales"), optionsSales);
    chartSales.render();


    // 2. Cấu hình Biểu đồ Tròn (Target)
    var optionsTarget = {
      series: [75],
      chart: {
        height: 300,
        type: 'radialBar',
      },
      plotOptions: {
        radialBar: {
          hollow: { size: '70%' },
          dataLabels: {
            show: true,
            name: { show: false },
            value: {
              fontSize: '36px',
              fontWeight: 'bold',
              color: '#4263eb',
              offsetY: 10,
              formatter: function (val) {
                return val + "%";
              }
            }
          },
          track: { background: '#f4f6fa' } // Màu nền vòng tròn
        },
      },
      labels: ['Target'],
      colors: ['#4263eb'],
      stroke: { lineCap: 'round' },
    };
    var chartTarget = new ApexCharts(document.querySelector("#chart-target"), optionsTarget);
    chartTarget.render();


    // 3. Cấu hình Biểu đồ Đường (Statistics)
    var optionsStats = {
      series: [{
        name: "Lượt xem",
        data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
      }],
      chart: {
        height: 300,
        type: 'area', // Loại Area để có màu nền ở dưới
        zoom: { enabled: false },
        toolbar: { show: false }
      },
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth', width: 2 },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.4, // Độ mờ bắt đầu
          opacityTo: 0.0,   // Độ mờ kết thúc
          stops: [0, 100]
        }
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
      },
      colors: ['#2fb344'], // Màu xanh lá
    };
    var chartStats = new ApexCharts(document.querySelector("#chart-stats"), optionsStats);
    chartStats.render();

  });
</script>