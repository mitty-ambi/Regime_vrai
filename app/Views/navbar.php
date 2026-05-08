<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <a href="/">
                <span class="brand-icon">🏋️</span>
                <span class="brand-text">Fit<span class="brand-highlight">Regime</span></span>
            </a>
        </div>

        <div class="nav-toggle" id="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="nav-menu" id="nav-menu">
            <ul class="nav-links">
                <li><a href="/" class="nav-link"><span class="nav-icon">🏠</span> Accueil</a></li>
                <li><a href="/regime/add" class="nav-link"><span class="nav-icon">➕</span> Ajouter Régime</a></li>
                <li><a href="/regimes/list" class="nav-link"><span class="nav-icon">📋</span> Liste Régimes</a></li>
                <li><a href="/activities" class="nav-link"><span class="nav-icon">🏃</span> Activités</a></li>
                <li><a href="/profile" class="nav-link"><span class="nav-icon">👤</span> Mon Profil</a></li>
                <li><a href="/wallet" class="nav-link"><span class="nav-icon">💰</span> Porte-monnaie</a></li>
                <li><a href="/gold/upgrade" class="nav-link gold-link"><span class="nav-icon">👑</span> Devenir Gold</a>
                </li>
                <li><a href="/login" class="nav-link login-btn"><span class="nav-icon">🔑</span> Connexion</a></li>
                <li><a href="/register" class="nav-link"><span class="nav-icon">📝</span> Inscription</a></li>
            </ul>
        </div>
    </div>
</nav>

<script>
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');

    if (navToggle) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    }

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            navToggle.classList.remove('active');
        });
    });
</script>