<?php
session_start();
require_once 'db_connect.php';
require_once 'helpers.php';

$model = trim($_GET['model'] ?? '');
$year = trim($_GET['year'] ?? '');
$min_price = trim($_GET['min_price'] ?? '');
$max_price = trim($_GET['max_price'] ?? '');
$color = trim($_GET['color'] ?? '');
$location = trim($_GET['location'] ?? '');

$sql = 'SELECT c.car_id, c.color, c.model, c.year, c.location, c.price, c.image, c.description, s.username
        FROM cars c
        JOIN sellers s ON c.seller_id = s.seller_id
        WHERE 1=1';
$params = [];
$types = '';

if ($model !== '') {
    $sql .= ' AND c.model LIKE ?';
    $params[] = '%' . $model . '%';
    $types .= 's';
}

if ($year !== '') {
    $sql .= ' AND c.year = ?';
    $params[] = (int)$year;
    $types .= 'i';
}

if ($min_price !== '') {
    $sql .= ' AND c.price >= ?';
    $params[] = (float)$min_price;
    $types .= 'd';
}

if ($max_price !== '') {
    $sql .= ' AND c.price <= ?';
    $params[] = (float)$max_price;
    $types .= 'd';
}

if ($color !== '') {
    $sql .= ' AND c.color LIKE ?';
    $params[] = '%' . $color . '%';
    $types .= 's';
}

if ($location !== '') {
    $sql .= ' AND c.location LIKE ?';
    $params[] = '%' . $location . '%';
    $types .= 's';
}

$sql .= ' ORDER BY c.created_at DESC';

$stmt = $conn->prepare($sql);
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$cars = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Cars - Online Car Sales Platform</title>
    <link rel="stylesheet" href="style.css">

    <!-- Keep the popup centered even if the browser is still using an older cached CSS file. -->
    <style>
        #carDetailModal {
            display: none;
            position: fixed !important;
            inset: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
            z-index: 9999 !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 2rem !important;
        }

        #carDetailModal.show {
            display: flex !important;
        }

        #modalContent {
            background-color: white !important;
            border-radius: 12px !important;
            width: min(800px, calc(100vw - 4rem)) !important;
            max-height: calc(100vh - 4rem) !important;
            overflow-y: auto !important;
            padding: 2.5rem !important;
            position: relative !important;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3) !important;
        }

        #modalContent img {
            width: 100% !important;
            height: 350px !important;
            object-fit: cover !important;
            border-radius: 8px !important;
            margin-bottom: 1.5rem !important;
        }

        .close-modal {
            position: absolute !important;
            top: 1rem !important;
            right: 1.25rem !important;
            border: none !important;
            background: transparent !important;
            color: slategray !important;
            font-size: 2rem !important;
            line-height: 1 !important;
            cursor: pointer !important;
            z-index: 10000 !important;
        }

        .detail-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }

        .detail-item strong {
            color: mediumblue;
        }

        .car-description {
            color: slategray;
            font-size: 0.9rem;
            line-height: 1.45;
            margin-top: 0.75rem;
        }

        .modal-description {
            margin-top: 1.5rem;
            color: slategray;
            line-height: 1.6;
            background-color: #f7f8ff;
            border-radius: 8px;
            padding: 1rem;
        }

        .modal-description strong {
            color: mediumblue;
        }

        body.modal-open {
            overflow: hidden !important;
        }

        @media screen and (max-width: 768px) {
            #carDetailModal {
                padding: 1rem !important;
            }

            #modalContent {
                width: calc(100vw - 2rem) !important;
                padding: 1.5rem !important;
            }

            #modalContent img {
                height: 220px !important;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">
                <img src="Logo.png" alt="SpeedCar Logo" class="logo-img">
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="search.php" class="active">Find Cars</a></li>
                <li><a href="Register.php">Seller Register</a></li>
                <?php if (isset($_SESSION['seller_id'])): ?>
                    <li><a href="add-car.php">Add Car</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="Login.php">Seller Login</a></li>
                    <li><a href="add-car.php">Add Car</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2 class="page-title">Search for Your Ideal Vehicle</h2>

        <div class="card">
            <form id="searchForm" class="search-form" method="GET" action="search.php">
                <div class="form-group">
                    <input type="text" name="model" id="searchModel" value="<?php echo h($model); ?>" placeholder="Enter car model">
                </div>

                <div class="form-group">
                    <input type="number" name="year" id="searchYear" min="1990" max="2026" value="<?php echo h($year); ?>" placeholder="Enter registration year">
                </div>

                <div class="form-group">
                    <input type="number" name="min_price" id="minPrice" min="0" step="1000" value="<?php echo h($min_price); ?>" placeholder="Min Price (CNY)">
                </div>

                <div class="form-group">
                    <input type="number" name="max_price" id="maxPrice" min="0" step="1000" value="<?php echo h($max_price); ?>" placeholder="Max Price (CNY)">
                </div>

                <div class="form-group">
                    <input type="text" name="color" id="searchColor" value="<?php echo h($color); ?>" placeholder="Color">
                </div>

                <div class="form-group">
                    <input type="text" name="location" id="searchLocation" value="<?php echo h($location); ?>" placeholder="Location">
                </div>

                <button type="submit" class="btn">Search</button>
            </form>
        </div>

        <h3 class="list-title">Vehicle List</h3>
        <div class="car-list" id="carList">
            <?php if (count($cars) === 0): ?>
                <div class="empty-result">No matching vehicle information available.</div>
            <?php else: ?>
                <?php foreach ($cars as $car): ?>
                    <div class="car-item" data-car-id="<?php echo (int)$car['car_id']; ?>">
                        <img src="<?php echo h($car['image']); ?>" alt="<?php echo h($car['model']); ?>">
                        <div class="car-info">
                            <h4><?php echo h($car['model']); ?> <?php echo h($car['year']); ?></h4>
                            <p class="car-price">¥<?php echo number_format((float)$car['price']); ?></p>
                            <p class="car-meta">Color: <?php echo h($car['color']); ?> | Location: <?php echo h($car['location']); ?></p>
                            <?php if (!empty($car['description'])): ?>
                                <?php $shortDescription = strlen($car['description']) > 120 ? substr($car['description'], 0, 120) . '...' : $car['description']; ?>
                                <p class="car-description"><?php echo h($shortDescription); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Fixed overlay. It stays outside <main> so it can cover the whole browser window. -->
    <div id="carDetailModal" aria-hidden="true">
        <div id="modalContent" role="dialog" aria-modal="true"></div>
    </div>

    <footer>
        <p>&copy; 2026 Online Car Sales Platform. All rights reserved.</p>
    </footer>

    <script>
        const carListFromDatabase = <?php echo json_encode($cars, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatPrice(price) {
            return '¥' + Number(price || 0).toLocaleString();
        }

        function openCarDetail(carId) {
            const car = carListFromDatabase.find(item => String(item.car_id) === String(carId));
            const modal = document.getElementById('carDetailModal');
            const modalContent = document.getElementById('modalContent');

            if (!car || !modal || !modalContent) {
                return;
            }

            modalContent.innerHTML = `
                <button type="button" class="close-modal" id="closeModal" aria-label="Close">&times;</button>
                <img src="${escapeHtml(car.image)}" alt="${escapeHtml(car.model)}">
                <h2>${escapeHtml(car.model)} ${escapeHtml(car.year)}</h2>
                <p class="car-price" style="margin: 1rem 0;">${formatPrice(car.price)}</p>
                <div class="detail-row">
                    <div class="detail-item"><strong>Body Color:</strong> ${escapeHtml(car.color)}</div>
                    <div class="detail-item"><strong>Year of Registration:</strong> ${escapeHtml(car.year)}</div>
                    <div class="detail-item"><strong>Vehicle Location:</strong> ${escapeHtml(car.location)}</div>
                    <div class="detail-item"><strong>Seller:</strong> ${escapeHtml(car.username)}</div>
                </div>
                ${car.description ? `<p class="modal-description"><strong>Vehicle Introduction:</strong><br>${escapeHtml(car.description)}</p>` : ''}
            `;

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');

            document.getElementById('closeModal').addEventListener('click', closeCarDetail);
        }

        function closeCarDetail() {
            const modal = document.getElementById('carDetailModal');
            if (!modal) {
                return;
            }

            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
        }

        document.querySelectorAll('.car-item').forEach(item => {
            item.addEventListener('click', () => openCarDetail(item.getAttribute('data-car-id')));
        });

        document.getElementById('carDetailModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeCarDetail();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCarDetail();
            }
        });
    </script>
</body>
</html>
