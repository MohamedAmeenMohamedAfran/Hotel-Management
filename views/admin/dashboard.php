<?php
$title = 'Dashboard - Inshaf Hotel';
$page_title = 'Dashboard';
include __DIR__ . '/../layout/header.php';
?>

<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card pulse">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Rooms</div>
                        <div class="stat-number"><?php echo $roomStats['total_rooms']; ?></div>
                        <div class="text-xs opacity-75">All room types</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bed fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Available Rooms</div>
                        <div class="stat-number"><?php echo $roomStats['available_rooms']; ?></div>
                        <div class="text-xs opacity-75">Ready for guests</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Booked Rooms</div>
                        <div class="stat-number"><?php echo $roomStats['booked_rooms']; ?></div>
                        <div class="text-xs opacity-75">Currently occupied</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Guests</div>
                        <div class="stat-number"><?php echo $totalGuests; ?></div>
                        <div class="text-xs opacity-75">Registered guests</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Active Bookings</div>
                        <div class="stat-number"><?php echo $bookingStats['active_bookings']; ?></div>
                        <div class="text-xs opacity-75">Currently checked in</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Revenue</div>
                        <div class="stat-number">$<?php echo number_format($bookingStats['total_revenue'], 2); ?></div>
                        <div class="text-xs opacity-75">All time earnings</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Completed Bookings</div>
                        <div class="stat-number"><?php echo $bookingStats['completed_bookings']; ?></div>
                        <div class="text-xs opacity-75">Successfully finished</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #6610f2 100%);">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Occupancy Rate</div>
                        <div class="stat-number"><?php 
                            $occupancy_rate = $roomStats['total_rooms'] > 0 ? 
                                round(($roomStats['booked_rooms'] / $roomStats['total_rooms']) * 100, 1) : 0;
                            echo $occupancy_rate . '%';
                        ?></div>
                        <div class="text-xs opacity-75">Current utilization</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percentage fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card fade-in">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-area me-2"></i>
                    Room Occupancy Trend
                </h6>
                <small class="opacity-75">Monthly occupancy rates</small>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <canvas id="occupancyChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card fade-in">
            <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-pie me-2"></i>
                    Room Status Distribution
                </h6>
                <small class="opacity-75">Current room status</small>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <canvas id="statusChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card fade-in">
            <div class="card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #6610f2 100%); color: white;">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Recent Bookings
                </h6>
                <small class="opacity-75">Latest booking activities</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-1"></i>Booking ID</th>
                                <th><i class="fas fa-user me-1"></i>Guest Name</th>
                                <th><i class="fas fa-bed me-1"></i>Room</th>
                                <th><i class="fas fa-calendar-plus me-1"></i>Check-in</th>
                                <th><i class="fas fa-calendar-minus me-1"></i>Check-out</th>
                                <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                <th><i class="fas fa-dollar-sign me-1"></i>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentBookings)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No recent bookings found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recentBookings as $booking): ?>
                                    <tr>
                                        <td>#<?php echo $booking['booking_id']; ?></td>
                                        <td><?php echo htmlspecialchars($booking['guest_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['room_number']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($booking['check_in'])); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($booking['check_out'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $booking['status'] === 'Active' ? 'success' : 
                                                    ($booking['status'] === 'Completed' ? 'info' : 
                                                    ($booking['status'] === 'Cancelled' ? 'danger' : 'warning'));
                                            ?>">
                                                <?php echo $booking['status']; ?>
                                            </span>
                                        </td>
                                        <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Room Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Available', 'Booked', 'Maintenance'],
        datasets: [{
            data: [
                <?php echo $roomStats['available_rooms']; ?>,
                <?php echo $roomStats['booked_rooms']; ?>,
                <?php echo $roomStats['maintenance_rooms']; ?>
            ],
            backgroundColor: [
                '#28a745',
                '#dc3545',
                '#ffc107'
            ],
            borderWidth: 3,
            borderColor: '#fff',
            hoverBorderWidth: 5,
            hoverBorderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#fff',
                borderWidth: 1
            }
        },
        animation: {
            animateRotate: true,
            animateScale: true,
            duration: 2000
        }
    }
});

// Occupancy Chart (Sample data - you can make this dynamic)
const occupancyCtx = document.getElementById('occupancyChart').getContext('2d');
const occupancyChart = new Chart(occupancyCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Occupancy Rate (%)',
            data: [65, 70, 75, 80, 85, 78, 82, 88, 75, 70, 65, 72],
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 4,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#667eea',
            pointBorderColor: '#fff',
            pointBorderWidth: 3,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: '#764ba2',
            pointHoverBorderColor: '#fff',
            pointHoverBorderWidth: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: 'index'
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                },
                ticks: {
                    color: '#666',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#666',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#667eea',
                borderWidth: 2,
                cornerRadius: 8,
                displayColors: false
            }
        },
        animation: {
            duration: 2000,
            easing: 'easeInOutQuart'
        }
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
