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

<main style="padding-top: 100px;">

    <div id="demo" class="container carousel slide" data-bs-ride="carousel" style="margin-top: 20px !important;">

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
    <div class="modal-content" style="background: rgba(10, 10, 10, 0.95); backdrop-filter: blur(20px); border: 2px solid rgba(255, 255, 255, 0.15); border-radius: 20px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);">
      <div class="modal-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0; padding: 1.5rem;">
        <h5 class="modal-title text-white" style="font-family: 'Orbitron', monospace; font-size: 1.5rem;"><i class="fas fa-crown"></i> Choose Your Subscription Plan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4" style="background: rgba(10, 10, 10, 0.8);">
        <div class="alert" style="background: rgba(120, 219, 255, 0.15); border: 1px solid rgba(120, 219, 255, 0.3); border-radius: 12px; color: #78dbff;">
          <i class="fas fa-info-circle"></i> Selected Platform: <strong id="selectedPlatform">PC</strong>
        </div>
        <div class="row g-3" id="subscriptionPlans">
          <!-- Plans will be loaded here dynamically -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Success Popup Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: rgba(10, 10, 10, 0.95); backdrop-filter: blur(20px); border: 2px solid rgba(74, 222, 128, 0.5); border-radius: 20px; box-shadow: 0 20px 60px rgba(74, 222, 128, 0.3);">
      <div class="modal-body text-center p-5">
        <div style="width: 80px; height: 80px; margin: 0 auto 1.5rem; background: linear-gradient(45deg, #4ade80, #22c55e); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: successPulse 1s ease-out;">
          <i class="fas fa-check" style="font-size: 3rem; color: white;"></i>
        </div>
        <h3 style="color: #4ade80; font-family: 'Orbitron', monospace; margin-bottom: 1rem;">Purchase Successful!</h3>
        <p id="successMessage" style="color: rgba(255, 255, 255, 0.9); font-size: 1.1rem; line-height: 1.6; margin-bottom: 1.5rem;"></p>
        <button class="btn btn-success" data-bs-dismiss="modal" style="background: linear-gradient(45deg, #4ade80, #22c55e); border: none; padding: 0.75rem 2rem; border-radius: 25px; font-weight: 600;">
          <i class="fas fa-gamepad"></i> Start Gaming
        </button>
      </div>
    </div>
  </div>
</div>

<style>
.subscription-card {
  background: linear-gradient(135deg, rgba(45, 55, 72, 0.8) 0%, rgba(26, 32, 44, 0.8) 100%);
  border: 2px solid rgba(120, 119, 198, 0.3);
  border-radius: 15px;
  padding: 1.5rem;
  transition: all 0.3s ease;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  backdrop-filter: blur(10px);
}

.subscription-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(120, 119, 198, 0.1) 0%, rgba(255, 119, 198, 0.1) 100%);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.subscription-card:hover {
  transform: translateY(-8px);
  border-color: #667eea;
  box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
}

.subscription-card:hover::before {
  opacity: 1;
}

.subscription-card.has-discount::after {
  content: 'SALE';
  position: absolute;
  top: 15px;
  right: 15px;
  background: linear-gradient(45deg, #ef4444, #dc2626);
  color: white;
  padding: 5px 15px;
  border-radius: 20px;
  font-weight: bold;
  font-size: 12px;
  box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
  animation: saleBounce 2s ease-in-out infinite;
}

@keyframes saleBounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
}

.subscription-price {
  font-size: 2.5rem;
  font-weight: bold;
  background: linear-gradient(45deg, #7877c6, #ff77c6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-family: 'Orbitron', monospace;
}

.subscription-price.discounted {
  background: linear-gradient(45deg, #4ade80, #22c55e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.original-price {
  text-decoration: line-through;
  color: rgba(255, 255, 255, 0.4);
  font-size: 1.2rem;
}

.subscription-card h4 {
  color: #ffffff;
  font-weight: 600;
  position: relative;
  z-index: 1;
}

.subscription-card p {
  color: rgba(255, 255, 255, 0.7);
  position: relative;
  z-index: 1;
}

.subscription-card .btn {
  position: relative;
  z-index: 1;
  background: linear-gradient(45deg, #7877c6, #ff77c6);
  border: none;
  transition: all 0.3s ease;
}

.subscription-card:hover .btn {
  transform: scale(1.05);
  box-shadow: 0 6px 20px rgba(120, 119, 198, 0.5);
}

@keyframes successPulse {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.modal-backdrop.show {
  opacity: 0.8;
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
      container.innerHTML = '<div class="col-12"><div class="alert alert-warning" style="background: rgba(251, 191, 36, 0.15); border: 1px solid rgba(251, 191, 36, 0.3); color: #fbbf24; border-radius: 12px;">No subscription plans available at the moment.</div></div>';
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
              <small style="color: rgba(255, 255, 255, 0.6);">${sub.duration_months} month${sub.duration_months > 1 ? 's' : ''}</small>
            </div>
            ${sub.description ? `<p class="text-center small" style="min-height: 60px;">${sub.description}</p>` : '<p class="text-center small" style="min-height: 60px;">Full access to all games</p>'}
            ${hasDiscount ? `<div class="text-center mb-3"><span class="badge" style="background: linear-gradient(45deg, #ef4444, #dc2626); padding: 0.5rem 1rem; border-radius: 20px;">${sub.discount_percentage}% OFF</span></div>` : ''}
            <div class="text-center mt-3">
              <button class="btn w-100" style="padding: 0.75rem; font-weight: 600; border-radius: 12px;">
                <i class="fas fa-shopping-cart"></i> Select Plan
              </button>
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
      const successMessage = document.getElementById('successMessage');
      successMessage.innerHTML = `
        You have successfully purchased <strong style="color: #4ade80;">${title}</strong> for <strong style="color: #4ade80;">${platform}</strong>!<br>
        <span style="color: rgba(255, 255, 255, 0.7);">Amount: <strong>$${price}</strong></span><br><br>
        <span style="color: #78dbff;">Thank you for your subscription! 🎮</span>
      `;
      
      const successModal = new bootstrap.Modal(document.getElementById('successModal'));
      successModal.show();
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
