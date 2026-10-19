<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php include 'config.php'; ?>
<?php
// Public marketplace preview: latest active listings for guests to browse
try {
    $market_stmt = $pdo->query("SELECT p.*, c.name as category_name, u.full_name as farmer_name
                               FROM products p
                               JOIN categories c ON p.category_id = c.id
                               JOIN users u ON p.farmer_id = u.id
                               WHERE p.status = 'active' ORDER BY p.created_at DESC LIMIT 2");
    $market_products = $market_stmt->fetchAll();
} catch (Exception $e) { $market_products = []; }
?>
<?php include 'includes/landing_header.inc.php'; ?>

<!-- Hero Section -->
<section class="landing-hero d-flex align-items-center">
    <div class="container py-3 py-md-5">
        <div class="row align-items-center mt-3 mt-md-5">
            <div class="col-lg-6 animate-slide-up">
                <h1 class="display-3 fw-bold mb-4">Fresh <span id="heroRotator" class="text-ingoude">Maize</span><span class="rotator-caret">|</span><br>From Zambian Farms</h1>
                <!-- EDIT THE ROTATING WORDS in the heroRotator script at the bottom of this file -->
                <p class="fs-5 mb-5 opacity-75">Order direct from farmers. Delivered to your door.</p>
                <div class="d-flex gap-3">
                    <a href="marketplace.php" class="btn btn-ingoude btn-lg">Shop Now</a>
                    <a href="request_access.php" class="btn btn-link text-white text-decoration-none fw-bold"><i class="fas fa-play me-2"></i> Sell With Us</a>
                </div>
            </div>
            <div class="col-lg-6 text-center animate-slide-up" style="animation-delay: 0.2s;">
                <img src="assets/img/hero.png" class="img-fluid rounded-circle shadow-lg border border-5 border-white hero-mobile-img" style="object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Marketplace Preview (public browsing, buy -> login to resume) -->
<section id="marketplace" class="pt-5 pb-4 bg-light">
    <div class="container pt-4 pb-2">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Fresh From The Farm</h2>
            <p class="text-muted">Browse live listings. Sign in to buy — you'll pick up right where you left off.</p>
        </div>
        <?php if (!empty($market_products)): ?>
        <div class="row g-3 g-md-4 justify-content-center">
            <?php foreach ($market_products as $mp): ?>
            <?php $resume = urlencode('product_details.php?id=' . $mp['id']); ?>
            <div class="col-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                    <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-50 rounded-pill" title="Login to buy"><i class="fas fa-lock me-1"></i></span>
                    <a href="product_details.php?id=<?php echo $mp['id']; ?>">
                        <img src="<?php echo $mp['image'] ? 'uploads/products/' . htmlspecialchars($mp['image']) : 'https://images.unsplash.com/photo-1595147389795-37094173bfd8?auto=format&fit=crop&w=500&q=60'; ?>"
                             class="card-img-top" loading="lazy" decoding="async" style="height:170px;object-fit:cover;" alt="<?php echo htmlspecialchars($mp['name']); ?>">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                            <h6 class="fw-bold mb-0 text-truncate"><?php echo htmlspecialchars($mp['name']); ?></h6>
                            <span class="badge bg-success rounded-pill flex-shrink-0">K<?php echo htmlspecialchars($mp['price']); ?></span>
                        </div>
                        <small class="text-muted d-block text-truncate mb-3"><?php echo htmlspecialchars($mp['category_name']); ?> • <?php echo htmlspecialchars($mp['farmer_name']); ?></small>
                        <a href="login.php?redirect=<?php echo $resume; ?>" class="btn btn-ingoude btn-sm rounded-pill w-100 mt-auto">
                            <i class="fas fa-lock me-1"></i> Login to Buy
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="marketplace.php" class="btn btn-ingoude rounded-pill px-5">Browse Full Marketplace</a>
            <a href="register.php" class="btn btn-outline-dark rounded-pill px-5 ms-2">Create free buyer account</a>
        </div>
        <?php else: ?>
        <p class="text-center text-muted">New harvest listings are on the way — check back soon.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container text-center py-4">
        <h2 class="display-5 fw-bold mb-5">The Future of Agriculture</h2>
        <div class="row g-4 mt-4">
            <div class="col-6 col-md-3">
                <div class="feature-card p-4 bg-white shadow-sm border border-light">
                    <div class="feature-icon"><i class="fas fa-seedling"></i></div>
                    <h5 class="fw-bold">Innovation</h5>
                    <p class="text-muted small">Driving agricultural progress and efficiency through digital integration.</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card p-4 bg-white shadow-sm border border-light">
                    <div class="feature-icon bg-ingoude"><i class="fas fa-recycle"></i></div>
                    <h5 class="fw-bold">Sustainability</h5>
                    <p class="text-muted small">Protecting the environment while increasing global food production.</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card p-4 bg-white shadow-sm border border-light">
                    <div class="feature-icon bg-success"><i class="fas fa-handshake"></i></div>
                    <h5 class="fw-bold">Collaboration</h5>
                    <p class="text-muted small">Working together globally to overcome agricultural challenges.</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card p-4 bg-white shadow-sm border border-light">
                    <div class="feature-icon bg-warning text-dark"><i class="fas fa-chart-line"></i></div>
                    <h5 class="fw-bold">Future Prosperity</h5>
                    <p class="text-muted small">Ensuring agriculture meets the demands of a growing population.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Future of Agriculture Section -->
<section id="future" class="py-5">
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1558449028-b53a39d100fc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-5 shadow-lg mb-4 mb-lg-0">
            </div>
            <div class="col-lg-6 ps-lg-5">
                <h2 class="display-5 fw-bold mb-4">The Future of Agriculture</h2>
                <div class="row g-4">
                    <div class="col-6 text-center text-md-start">
                        <div class="bg-light p-3 rounded-circle d-inline-block mb-3"><i class="fas fa-layer-group text-ingoude fa-2x"></i></div>
                        <h6 class="fw-bold">Vertical Farming</h6>
                        <p class="small text-muted">Growing crops in stacked layers to save space and increase production.</p>
                    </div>
                    <div class="col-6 text-center text-md-start">
                        <div class="bg-light p-3 rounded-circle d-inline-block mb-3"><i class="fas fa-microchip text-ingoude fa-2x"></i></div>
                        <h6 class="fw-bold">Smart Machines</h6>
                        <p class="small text-muted">AI-driven tools that assist with planting, monitoring, and harvesting.</p>
                    </div>
                    <div class="col-6 text-center text-md-start">
                        <div class="bg-light p-3 rounded-circle d-inline-block mb-3"><i class="fas fa-spray-can text-ingoude fa-2x"></i></div>
                        <h6 class="fw-bold">Precision Irrigation</h6>
                        <p class="small text-muted">Using AI to optimize water use for better crop growth and conservation.</p>
                    </div>
                    <div class="col-6 text-center text-md-start">
                        <div class="bg-light p-3 rounded-circle d-inline-block mb-3"><i class="fas fa-leaf text-ingoude fa-2x"></i></div>
                        <h6 class="fw-bold">Sustainable Systems</h6>
                        <p class="small text-muted">Innovations that balance production with environmental protection.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Challenges Section (Updated) -->
<section id="challenges" class="py-5 bg-light position-relative">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="rounded-5 overflow-hidden shadow-lg mb-4 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1592982537447-7440770cbfc9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5">
                <h2 class="display-6 fw-bold mb-4">Overcoming Global Challenges</h2>
                <p class="text-muted mb-5">Global agriculture faces challenges such as climate change, water scarcity, and soil depletion, requiring innovative digital solutions like our marketplace.</p>
                
                <div class="row g-4">
                    <div class="col-md-6 d-flex align-items-start">
                        <div class="me-3 p-2 bg-white rounded-circle shadow-sm"><i class="fas fa-cloud-sun text-ingoude fa-lg"></i></div>
                        <div>
                            <h6 class="fw-bold">Climate Change</h6>
                            <p class="small text-muted">Impacting crop yields and weather patterns globally.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-start">
                        <div class="me-3 p-2 bg-white rounded-circle shadow-sm"><i class="fas fa-tint text-ingoude fa-lg"></i></div>
                        <div>
                            <h6 class="fw-bold">Water Scarcity</h6>
                            <p class="small text-muted">Efficient water management systems for sustainable farming.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-start">
                        <div class="me-3 p-2 bg-white rounded-circle shadow-sm"><i class="fas fa-mountain text-ingoude fa-lg"></i></div>
                        <div>
                            <h6 class="fw-bold">Soil Degradation</h6>
                            <p class="small text-muted">Preserving soil health through sustainable techniques.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-start">
                        <div class="me-3 p-2 bg-white rounded-circle shadow-sm"><i class="fas fa-users text-ingoude fa-lg"></i></div>
                        <div>
                            <h6 class="fw-bold">Labor Sustainability</h6>
                            <p class="small text-muted">Addressing the shrinking agricultural workforce.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Policy Section -->
<section class="py-5">
    <div class="container py-5">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1590682680695-43b964a3ae17?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-5 shadow-lg mb-4 mb-lg-0">
            </div>
            <div class="col-lg-6 pe-lg-5">
                <h2 class="display-6 fw-bold mb-4">Supporting Agriculture Through Policy</h2>
                <div class="bg-light p-4 rounded-4 mb-4 border-start border-5 border-ingoude">
                    <h5 class="fw-bold text-ingoude">Policy and Government's Role</h5>
                    <p class="mb-0 text-muted">Governments play a critical role in shaping the future of agriculture. By implementing policies that promote sustainable farming, encourage the adoption of technology, and support farmers with subsidies and education.</p>
                </div>
                <p class="text-muted">Our platform bridges the gap between policy goals and on-the-ground implementation, empowering local farmers to thrive in a global economy.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container py-5 text-center">
        <div class="card bg-ingoude p-5 rounded-5 shadow-lg border-0">
            <h2 class="display-6 fw-bold mb-4">Ready to Transform Your Farm?</h2>
            <p class="mb-5 lead opacity-75">Join thousands of farmers and buyers already benefiting from our digital marketplace.</p>
            <div>
                <a href="request_access.php" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold text-ingoude">Request Access</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="wavy-footer py-5">
    <div class="container mt-5">
        <div class="row pt-5 g-4 text-center text-md-start">
            <div class="col-12 col-md-4">
                <h4 class="fw-bold mb-3"><i class="fas fa-leaf me-2"></i><span class="brand-name">AgriConnect</span> Company</h4>
                <p class="opacity-75 small">Ensuring a sustainable future for agriculture through innovation and collaboration.</p>
            </div>
            <div class="col-6 col-md-4">
                <h5 class="fw-bold mb-3">Contact Info</h5>
                <p class="mb-1 opacity-75 small"><i class="fas fa-globe me-2"></i> AgriConnect.com</p>
                <p class="mb-1 opacity-75 small"><i class="fas fa-phone me-2"></i>+26 0761616201</p>
                <p class="mb-1 opacity-75 small"><i class="fas fa-map-marker-alt me-2"></i> Lusaka,Zambia</p>
            </div>
            <div class="col-6 col-md-4">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled opacity-75 small">
                    <li class="mb-1"><a href="login.php" class="text-white text-decoration-none">Login</a></li>
                    <li class="mb-1"><a href="request_access.php" class="text-white text-decoration-none">Request Access</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <hr class="mt-5 opacity-25">
        <div class="text-center py-3 opacity-50">
            <small>&copy; 2026 AgriConnect Company. All rights reserved.</small>
        </div>
    </div>
</footer>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
// Hero rotating words — EDIT THIS LIST to change the transition words
var heroWords = ['Maize', 'Tomatoes', 'Groundnuts', 'Rape', 'Goats', 'Chickens', 'Onions', 'Sweet Potatoes'];
(function () {
    var el = document.getElementById('heroRotator');
    if (!el || heroWords.length < 2) return;
    var i = 0;
    setInterval(function () {
        el.classList.add('rotating-out');
        setTimeout(function () {
            i = (i + 1) % heroWords.length;
            el.textContent = heroWords[i];
            el.classList.remove('rotating-out');
        }, 350);
    }, 2500);
})();
</script>
<?php include 'includes/guest_widget.inc.php'; ?>
</body>
</html>
