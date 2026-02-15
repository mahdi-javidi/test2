<?php
require_once __DIR__ . '/db.php';
$slider = [];
if (!$mysqli) {
    $slider = [];
} else {
    $sql = "SELECT slider_id, slider_img FROM slider ORDER BY slider_id DESC";
    if ($res = $mysqli->query($sql)) {
        $slider = $res->fetch_all(MYSQLI_ASSOC);
        $res->close();
    } else {
        $slider = [];
    }
}
?>

<main>

    <div id="demo" class="container carousel slide mt-3" data-bs-ride="carousel">

        <div class="carousel-indicators">
            <?php for ($i = 0; $i < count($slider); $i++): ?>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="<?php echo $i; ?>"
                    class="<?php echo $i === 0 ? 'active' : ''; ?>"></button>
            <?php endfor; ?>
        </div>

        <div class="carousel-inner">
            <?php $i = 0; foreach ($slider as $item): ?>
                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                    <img src="panel_admin/uploads/<?php echo htmlspecialchars($item['slider_img']); ?>" class="d-block w-100"
                        alt="slide <?php echo (int)($item['slider_id']); ?>">
                </div>
                <?php $i++; endforeach; ?>
        </div>

        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-background">
            <img src="5.jpg" alt="Gaming Background" class="hero-image">
        </div>
        <div class="hero-content">
            <h1 class="hero-title">Welcome to Arcade's HQ</h1>
            <p class="hero-subtitle">Your ultimate destination for the best gaming experience.</p>
            <div class="download-buttons">
                <button class="download-btn primary" data-platform="PC"><i class="fab fa-windows"></i> Download for PC</button>
                <button class="download-btn xbox" data-platform="Xbox"><i class="fab fa-xbox"></i> Xbox Series X|S</button>
                <button class="download-btn playstation" data-platform="PlayStation"><i class="fab fa-playstation"></i> PlayStation 5</button>
                <button class="download-btn mobile" data-platform="Mobile"><i class="fas fa-mobile-alt"></i> Mobile</button>
            </div>
        </div>
    </section>

    <!-- Getting Started Section -->
    <section class="getting-started-section">
        <div class="section-header">
            <h2 class="section-title">🚀 Getting Started</h2>
            <p class="section-subtitle">Join millions of gamers in just a few simple steps</p>
        </div>
        <div class="steps-container">
            <div class="step-card" data-step="1">
                <div class="step-icon">👤</div>
                <h3>Create Account</h3>
                <p>Sign up for free and unlock exclusive content, achievements, and community features</p>
                <div class="step-features">
                    <span>✓ Free registration</span>
                    <span>✓ Cloud saves</span>
                    <span>✓ Cross-platform sync</span>
                </div>
            </div>
            <div class="step-card" data-step="2">
                <div class="step-icon">🎮</div>
                <h3>Choose Your Game</h3>
                <p>Browse our extensive library of premium games across all genres and platforms</p>
                <div class="step-features">
                    <span>✓ 500+ games</span>
                    <span>✓ All genres</span>
                    <span>✓ Regular updates</span>
                </div>
            </div>
            <div class="step-card" data-step="3">
                <div class="step-icon">⬇️</div>
                <h3>Download & Install</h3>
                <p>Fast, secure downloads with our optimized game launcher and automatic updates</p>
                <div class="step-features">
                    <span>✓ High-speed downloads</span>
                    <span>✓ Auto-updates</span>
                    <span>✓ Virus protection</span>
                </div>
            </div>
            <div class="step-card" data-step="4">
                <div class="step-icon">🌟</div>
                <h3>Play & Connect</h3>
                <p>Jump into the action and connect with a global community of passionate gamers</p>
                <div class="step-features">
                    <span>✓ Global community</span>
                    <span>✓ Voice chat</span>
                    <span>✓ Tournaments</span>
                </div>
            </div>
        </div>
        <div class="stats-container">
            <div class="stat-box">
                <span class="stat-number" data-target="50000000">0</span>
                <span class="stat-label">Total Downloads</span>
            </div>
            <div class="stat-box">
                <span class="stat-number" data-target="99">0</span>
                <span class="stat-label">% Uptime</span>
            </div>
            <div class="stat-box">
                <span class="stat-number" data-target="24">0</span>
                <span class="stat-label">Hour Support</span>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="section-header">
            <h2 class="section-title">💬 What Gamers Say</h2>
            <p class="section-subtitle">Real reviews from our amazing gaming community</p>
        </div>
        <div class="testimonials-container">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="user-avatar">🎮</div>
                    <div class="user-info">
                        <h4>ProGamer123</h4>
                        <div class="user-stats">
                            <span class="level">Level 87</span>
                            <span class="playtime">2,450 hrs</span>
                        </div>
                    </div>
                    <div class="rating">⭐⭐⭐⭐⭐</div>
                </div>
                <p>"Absolutely hooked! The best gaming experience I've had in years. The community is fantastic and the
                    games run flawlessly on my setup."</p>
                <div class="testimonial-footer">
                    <span class="game-played">Playing: Cyber Legends</span>
                    <span class="verified">✓ Verified Player</span>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="user-avatar">🏆</div>
                    <div class="user-info">
                        <h4>PixelMaster</h4>
                        <div class="user-stats">
                            <span class="level">Level 92</span>
                            <span class="playtime">3,120 hrs</span>
                        </div>
                    </div>
                    <div class="rating">⭐⭐⭐⭐⭐</div>
                </div>
                <p>"Smooth downloads and an amazing selection of games. The launcher is intuitive and I love the
                    cross-platform features. Highly recommend!"</p>
                <div class="testimonial-footer">
                    <span class="game-played">Playing: Epic Quest Online</span>
                    <span class="verified">✓ Verified Player</span>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="user-avatar">⚡</div>
                    <div class="user-info">
                        <h4>GameGuruX</h4>
                        <div class="user-stats">
                            <span class="level">Level 95</span>
                            <span class="playtime">4,200 hrs</span>
                        </div>
                    </div>
                    <div class="rating">⭐⭐⭐⭐⭐</div>
                </div>
                <p>"The graphics are insane! I've never seen anything like it. Ray tracing support is phenomenal and the
                    120fps gameplay is butter smooth."</p>
                <div class="testimonial-footer">
                    <span class="game-played">Playing: Shadow Runner</span>
                    <span class="verified">✓ Verified Player</span>
                </div>
            </div>
        </div>
        <div class="community-stats">
            <div class="community-stat">
                <span class="stat-number" data-target="4.9">0</span>
                <span class="stat-label">Average Rating</span>
            </div>
            <div class="community-stat">
                <span class="stat-number" data-target="125000">0</span>
                <span class="stat-label">Reviews</span>
            </div>
            <div class="community-stat">
                <span class="stat-number" data-target="98">0</span>
                <span class="stat-label">% Recommend</span>
            </div>
        </div>
    </section>

</main>

<!-- Subscription Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-light border-0 shadow-lg">
      <div class="modal-header border-secondary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <h5 class="modal-title"><i class="fas fa-crown"></i> Choose Your Subscription Plan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i> Selected Platform: <strong id="selectedPlatform">PC</strong>
        </div>
        <div class="row g-3" id="subscriptionPlans">
          <!-- Plans will be loaded here dynamically -->
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.subscription-card {
  background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
  border: 2px solid #4a5568;
  border-radius: 15px;
  padding: 20px;
  transition: all 0.3s ease;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.subscription-card:hover {
  transform: translateY(-5px);
  border-color: #667eea;
  box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}
.subscription-card.has-discount::before {
  content: 'SALE';
  position: absolute;
  top: 10px;
  right: 10px;
  background: #e53e3e;
  color: white;
  padding: 5px 15px;
  border-radius: 20px;
  font-weight: bold;
  font-size: 12px;
}
.subscription-price {
  font-size: 2rem;
  font-weight: bold;
  color: #667eea;
}
.subscription-price.discounted {
  color: #48bb78;
}
.original-price {
  text-decoration: line-through;
  color: #a0aec0;
  font-size: 1.2rem;
}
</style>

<script>
(function(){
  // Fetch subscriptions from database
  async function loadSubscriptions() {
    try {
      const response = await fetch('php_admin/api/subscriptions.php');
      const data = await response.json();
      return data.subscriptions || [];
    } catch(e) {
      console.error('Failed to load subscriptions:', e);
      return [];
    }
  }
  
  // Display subscriptions in modal
  async function displaySubscriptions(platform) {
    const container = document.getElementById('subscriptionPlans');
    const platformDisplay = document.getElementById('selectedPlatform');
    platformDisplay.textContent = platform;
    
    const subscriptions = await loadSubscriptions();
    
    if (subscriptions.length === 0) {
      container.innerHTML = '<div class="col-12"><div class="alert alert-warning">No subscription plans available at the moment.</div></div>';
      return;
    }
    
    container.innerHTML = subscriptions.map(sub => {
      const hasDiscount = sub.discount_percentage > 0 && (!sub.discount_end_date || new Date(sub.discount_end_date) > new Date());
      const finalPrice = hasDiscount ? (sub.price * (1 - sub.discount_percentage / 100)).toFixed(2) : sub.price;
      
      return `
        <div class="col-md-4">
          <div class="subscription-card ${hasDiscount ? 'has-discount' : ''}" onclick="purchaseSubscription(${sub.id}, '${sub.title}', ${finalPrice}, '${platform}')">
            <h4 class="text-center mb-3">${sub.title}</h4>
            <div class="text-center mb-3">
              ${hasDiscount ? `<div class="original-price">$${sub.price}</div>` : ''}
              <div class="subscription-price ${hasDiscount ? 'discounted' : ''}">$${finalPrice}</div>
              <small class="text-muted">${sub.duration_months} month${sub.duration_months > 1 ? 's' : ''}</small>
            </div>
            ${sub.description ? `<p class="text-center text-muted small">${sub.description}</p>` : ''}
            ${hasDiscount ? `<div class="text-center"><span class="badge bg-danger">${sub.discount_percentage}% OFF</span></div>` : ''}
            <div class="text-center mt-3">
              <button class="btn btn-primary w-100">Select Plan</button>
            </div>
          </div>
        </div>
      `;
    }).join('');
  }
  
  // Handle purchase
  window.purchaseSubscription = function(id, title, price, platform) {
    const modal = bootstrap.Modal.getInstance(document.getElementById('subscriptionModal'));
    if (modal) modal.hide();
    
    setTimeout(() => {
      alert(`✅ Successfully purchased ${title} for ${platform}!\n\nAmount: $${price}\n\nThank you for your subscription!`);
    }, 300);
  };
  
  // Add click handlers to download buttons
  document.addEventListener('DOMContentLoaded', function() {
    const downloadButtons = document.querySelectorAll('.download-btn[data-platform]');
    downloadButtons.forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const platform = this.getAttribute('data-platform');
        displaySubscriptions(platform);
        const modal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
        modal.show();
      });
    });
  });
})();
</script>
