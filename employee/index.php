<?php
$page_title = "Dashboard - Trendy Threads";
require_once 'partials/header.php';

// Get today's sales
$todaySales = $db->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE DATE(created_at) = CURDATE()")->fetchArray();
$todaySales = $todaySales ?: ['total' => 0];

// Get total sales this month
$monthlySales = $db->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->fetchArray();
$monthlySales = $monthlySales ?: ['total' => 0];

// Get bails in stock
$bailsInStock = $db->query("SELECT COUNT(*) as count FROM bails WHERE b_status = 'available'")->fetchArray();
$bailsInStock = $bailsInStock ?: ['count' => 0];

// Get total customers (online customers)
$totalCustomers = $db->query("SELECT COUNT(*) as count FROM users WHERE u_type = 3")->fetchArray();
$totalCustomers = $totalCustomers ?: ['count' => 0];

// Get latest 6 notifications
$recentNotifications = $db->query("SELECT * FROM notifications ORDER BY n_created_date DESC LIMIT 6")->fetchAll();

// Get recent bails for the table
$recentBails = $db->query("SELECT * FROM bails ORDER BY b_id DESC LIMIT 6")->fetchAll();

// Weekly sales data (last 7 days)
$weeklySales = $db->query("
    SELECT DATE(created_at) as sale_date, COALESCE(SUM(total_amount), 0) as daily_total
    FROM orders 
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY DATE(created_at)
    ORDER BY sale_date
")->fetchAll();
$weeklySales = $weeklySales ?: [];

// Monthly sales this year
$yearlyMonthlySales = $db->query("
    SELECT MONTH(created_at) as month, COALESCE(SUM(total_amount), 0) as monthly_total
    FROM orders 
    WHERE YEAR(created_at) = YEAR(CURDATE())
    GROUP BY MONTH(created_at)
    ORDER BY month
")->fetchAll();
$yearlyMonthlySales = $yearlyMonthlySales ?: [];

// Online purchases this year (orders with online payment methods)
$onlinePurchases = $db->query("
    SELECT MONTH(created_at) as month, COALESCE(SUM(total_amount), 0) as monthly_total
    FROM orders 
    WHERE YEAR(created_at) = YEAR(CURDATE()) AND payment_method IN ('stripe', 'paypal', 'demo')
    GROUP BY MONTH(created_at)
    ORDER BY month
")->fetchAll();
$onlinePurchases = $onlinePurchases ?: [];

// Format data for JavaScript
$weeklyLabels = [];
$weeklyData = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $weeklyLabels[] = date('M j', strtotime($date));
    $found = false;
    foreach ($weeklySales as $sale) {
        if ($sale['sale_date'] == $date) {
            $weeklyData[] = (float)$sale['daily_total'];
            $found = true;
            break;
        }
    }
    if (!$found) $weeklyData[] = 0;
}

// Format monthly data (12 months)
$monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$monthlyData = array_fill(0, 12, 0);
$onlineData = array_fill(0, 12, 0);

foreach ($yearlyMonthlySales as $sale) {
    $monthlyData[$sale['month'] - 1] = (float)$sale['monthly_total'];
}

foreach ($onlinePurchases as $purchase) {
    $onlineData[$purchase['month'] - 1] = (float)$purchase['monthly_total'];
}
?>
      <div class="container-fluid py-2">
        <div class="row">
          <div class="ms-3">
            <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
            <p class="mb-4">Check the sales, items in stock and many more...</p>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                  <div>
                    <p class="text-sm mb-0 text-capitalize">Today's Sales</p>
                    <h4 class="mb-0">MWK <?php echo number_format($todaySales['total'], 0); ?></h4>
                  </div>
                  <div
                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg"
                  >
                    <i class="material-symbols-rounded opacity-10">weekend</i>
                  </div>
                </div>
              </div>
              <hr class="dark horizontal my-0" />
              <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm">
                  <span class="text-success font-weight-bolder">+55%</span>
                  than last week
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                  <div>
                    <p class="text-sm mb-0 text-capitalize">Total Sales This Month</p>
                    <h4 class="mb-0">MWK <?php echo number_format($monthlySales['total'], 0); ?></h4>
                  </div>
                  <div
                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg"
                  >
                    <i class="material-symbols-rounded opacity-10">person</i>
                  </div>
                </div>
              </div>
              <hr class="dark horizontal my-0" />
              <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm">
                  <span class="text-success font-weight-bolder">+3%</span>
                  than last month
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                  <div>
                    <p class="text-sm mb-0 text-capitalize">Bails In Stock</p>
                    <h4 class="mb-0"><?php echo $bailsInStock['count']; ?></h4>
                  </div>
                  <div
                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg"
                  >
                    <i class="material-symbols-rounded opacity-10">
                      leaderboard
                    </i>
                  </div>
                </div>
              </div>
              <hr class="dark horizontal my-0" />
              <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm">
                  <span class="text-danger font-weight-bolder">-2%</span>
                  than yesterday
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card">
              <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                  <div>
                    <p class="text-sm mb-0 text-capitalize">Online Customers</p>
                    <h4 class="mb-0"><?php echo $totalCustomers['count']; ?></h4>
                  </div>
                  <div
                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg"
                  >
                    <i class="material-symbols-rounded opacity-10">weekend</i>
                  </div>
                </div>
              </div>
              <hr class="dark horizontal my-0" />
              <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm">
                  <span class="text-success font-weight-bolder">+5%</span>
                  than yesterday
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h6 class="mb-0">Sales for the Week</h6>
                <p class="text-sm"><?php echo date('M j', strtotime('-6 days')); ?> - <?php echo date('M j'); ?></p>
                <div class="pe-2">
                  <div class="chart">
                    <canvas
                      id="chart-bars"
                      class="chart-canvas"
                      height="170"
                    ></canvas>
                  </div>
                </div>
                <hr class="dark horizontal" />
                <div class="d-flex">
                  <i class="material-symbols-rounded text-sm my-auto me-1">
                    schedule
                  </i>
                  <p class="mb-0 text-sm">updated <?php echo date('M j, Y'); ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h6 class="mb-0">Sales This Year</h6>
                <p class="text-sm">
                  (
                  <span class="font-weight-bolder">+15%</span>
                  ) increase in today sales.
                </p>
                <div class="pe-2">
                  <div class="chart">
                    <canvas
                      id="chart-line"
                      class="chart-canvas"
                      height="170"
                    ></canvas>
                  </div>
                </div>
                <hr class="dark horizontal" />
                <div class="d-flex">
                  <i class="material-symbols-rounded text-sm my-auto me-1">
                    schedule
                  </i>
                  <p class="mb-0 text-sm">updated <?php echo date('M j, Y'); ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h6 class="mb-0">Online Purchases This Year</h6>
                <p class="text-sm">Last Campaign Performance</p>
                <div class="pe-2">
                  <div class="chart">
                    <canvas
                      id="chart-line-tasks"
                      class="chart-canvas"
                      height="170"
                    ></canvas>
                  </div>
                </div>
                <hr class="dark horizontal" />
                <div class="d-flex">
                  <i class="material-symbols-rounded text-sm my-auto me-1">
                    schedule
                  </i>
                  <p class="mb-0 text-sm">updated <?php echo date('M j, Y'); ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h6>Current Bails In Stock</h6>
                    <p class="text-sm mb-0">
                      <i class="fa fa-check text-info" aria-hidden="true"></i>
                      <span class="font-weight-bold ms-1">
                        <?php echo count($recentBails); ?> as of this month
                      </span>
                    </p>
                  </div>
                  <div class="col-lg-6 col-5 my-auto text-end">
                    <div class="dropdown float-lg-end pe-4">
                      <a
                        class="cursor-pointer"
                        id="dropdownTable"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        <i class="fa fa-ellipsis-v text-secondary"></i>
                      </a>
                      <ul
                        class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5"
                        aria-labelledby="dropdownTable"
                      >
                        <li>
                          <a
                            class="dropdown-item border-radius-md"
                            href="javascript:;"
                          >
                            Action
                          </a>
                        </li>
                        <li>
                          <a
                            class="dropdown-item border-radius-md"
                            href="javascript:;"
                          >
                            Another action
                          </a>
                        </li>
                        <li>
                          <a
                            class="dropdown-item border-radius-md"
                            href="javascript:;"
                          >
                            Something else here
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                        >
                          Bail Name
                        </th>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                        >
                          Items Count
                        </th>
                        <th
                          class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                        >
                          Avg. Price per Item
                        </th>
                        <th
                          class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                        >
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($recentBails as $bail): ?>
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div>
                              <img
                                src="assets/img/small-logos/logo-xd.svg"
                                class="avatar avatar-sm me-3"
                                alt="bail"
                              />
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($bail['b_name']); ?></h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span class="text-xs font-weight-bold"><?php echo $bail['b_items_count']; ?> items</span>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="text-xs font-weight-bold">MWK <?php echo number_format($bail['b_avg_price_per_item'], 0); ?></span>
                        </td>
                        <td class="align-middle">
                          <div class="progress-wrapper w-75 mx-auto">
                            <div class="progress-info">
                              <div class="progress-percentage">
                                <span class="text-xs font-weight-bold">
                                  <?php echo $bail['b_status'] == 'available' ? '100%' : '0%'; ?>
                                </span>
                              </div>
                            </div>
                            <div class="progress">
                              <div
                                class="progress-bar <?php echo $bail['b_status'] == 'available' ? 'bg-gradient-success w-100' : 'bg-gradient-danger w-0'; ?>"
                                role="progressbar"
                                aria-valuenow="<?php echo $bail['b_status'] == 'available' ? '100' : '0'; ?>"
                                aria-valuemin="0"
                                aria-valuemax="100"
                              ></div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card h-100">
              <div class="card-header pb-0">
                <h6>Notifications</h6>
                <p class="text-sm">
                  <i class="fa fa-bell text-info" aria-hidden="true"></i>
                  <span class="font-weight-bold">Latest system activities</span>
                </p>
              </div>
              <div class="card-body p-3">
                <div class="timeline timeline-one-side">
                  <?php if (empty($recentNotifications)): ?>
                    <div class="text-center text-muted py-3">
                      <i class="material-symbols-rounded opacity-5">notifications_off</i>
                      <p class="mb-0">No notifications yet</p>
                    </div>
                  <?php else: ?>
                    <?php foreach ($recentNotifications as $notification): ?>
                      <div class="timeline-block mb-3">
                        <span class="timeline-step">
                          <i class="material-symbols-rounded text-<?php 
                            echo $notification['n_type'] == 'bail_added' ? 'success' : 
                                ($notification['n_type'] == 'sale_completed' ? 'info' : 
                                ($notification['n_type'] == 'user_registered' ? 'primary' : 
                                ($notification['n_type'] == 'image_uploaded' ? 'warning' : 'secondary'))); 
                          ?> text-gradient">
                            <?php 
                            echo $notification['n_type'] == 'bail_added' ? 'inventory_2' : 
                                ($notification['n_type'] == 'sale_completed' ? 'shopping_cart' : 
                                ($notification['n_type'] == 'user_registered' ? 'person_add' : 
                                ($notification['n_type'] == 'image_uploaded' ? 'image' : 'notifications'))); 
                            ?>
                          </i>
                        </span>
                        <div class="timeline-content">
                          <h6 class="text-dark text-sm font-weight-bold mb-0">
                            <?php echo htmlspecialchars($notification['n_title']); ?>
                          </h6>
                          <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                            <?php echo date('M j, g:i A', strtotime($notification['n_created_date'])); ?>
                          </p>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
        // Store chart data for footer script
        window.chartData = {
            weeklyLabels: <?php echo json_encode($weeklyLabels); ?>,
            weeklyData: <?php echo json_encode($weeklyData); ?>,
            monthlyLabels: <?php echo json_encode($monthlyLabels); ?>,
            monthlyData: <?php echo json_encode($monthlyData); ?>,
            onlineData: <?php echo json_encode($onlineData); ?>
        };
        </script>
        <?php
        require_once"partials/footer.php";
        ?>