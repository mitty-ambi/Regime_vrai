# 📋 NutriGain - Documentation Complète du Projet

## 🎯 Vue d'ensemble

NutriGain est une application web de gestion de régimes alimentaires personnalisés. Elle permet aux utilisateurs de sélectionner des régimes adaptés à leurs objectifs de santé (prise de poids, perte de poids, IMC idéal) et d'accéder à des activités sportives recommandées.

### Technologies Utilisées
- **Backend**: PHP + Framework CodeIgniter 4
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla + AJAX)
- **Base de données**: MySQL ou PostgreSQL
- **Design**: Responsive, Mobile-First

---

## 📁 Structure des Fichiers Frontend

### 1. **app_layout.html** - Layout Principal
- **Utilité**: Template de base pour toutes les pages
- **Contient**:
  - Header sticky avec navigation
  - Main content area
  - Footer avec liens
  - Variables CSS pour cohérence
  - Système de boutons et cartes

### 2. **auth_login.html** - Page de Connexion
- **Route CodeIgniter**: `/auth/login` (GET)
- **Fonctionnalités**:
  - Formulaire email/mot de passe
  - Option "Se souvenir de moi"
  - Lien "Mot de passe oublié"
  - Design responsive 2 colonnes
  - Support login Google/Apple (optionnel)

### 3. **auth_register_step1.html** - Inscription Étape 1
- **Route CodeIgniter**: `/auth/register` (GET) | `/auth/register/step1` (POST)
- **Informations collectées**:
  - Nom complet
  - Email
  - Genre (Homme/Femme)
  - Téléphone (optionnel)
  - Date de naissance
- **Fonctionnalités**:
  - Barre de progression (Étape 1/2)
  - Validation côté client
  - Redirection vers Étape 2

### 4. **auth_register_step2.html** - Inscription Étape 2
- **Route CodeIgniter**: `/auth/register/step2` (POST)
- **Informations collectées**:
  - Taille (cm)
  - Poids (kg)
  - Calcul automatique de l'IMC
  - Objectif de santé (3 options):
    - Augmenter poids
    - Réduire poids
    - Atteindre IMC idéal
  - Mot de passe
- **Fonctionnalités**:
  - Calcul IMC en temps réel
  - Couleurs de statut IMC
  - Conditions d'utilisation obligatoires
  - Validation mot de passe

### 5. **dashboard_user.html** - Dashboard Utilisateur
- **Route CodeIgniter**: `/dashboard` (GET)
- **Sections**:
  - Profil utilisateur (Âge, Taille, Poids, IMC)
  - Portefeuille (solde et ajout de codes)
  - Offre Premium Gold (15% de remise)
  - Régimes actifs
  - Régimes recommandés
  - Modal d'ajout de code promo

### 6. **admin_dashboard.html** - Dashboard Admin
- **Route CodeIgniter**: `/admin` (GET) - *Protégée par authentification*
- **Fonctionnalités**:
  - Sidebar de navigation
  - Statistiques globales (4 cartes)
  - Graphiques Chart.js:
    - Inscriptions (7 derniers jours) - Line Chart
    - Top Régimes - Doughnut Chart
  - Tableau CRUD des Régimes:
    - Affichage: Nom, Prix, Durée, Composition, Nombre actifs
    - Actions: Éditer, Voir, Supprimer
  - Pagination

---

## 🗄️ Structure Recommandée CodeIgniter

```
ci4_project/
├── app/
│   ├── Config/
│   │   └── Routes.php
│   ├── Controllers/
│   │   ├── Auth.php
│   │   ├── Dashboard.php
│   │   └── Admin.php
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── RegimeModel.php
│   │   ├── ActivityModel.php
│   │   ├── PromoCodeModel.php
│   │   └── ParameterModel.php
│   └── Views/
│       ├── layout/
│       │   ├── header.php
│       │   ├── footer.php
│       │   └── sidebar_admin.php
│       ├── auth/
│       │   ├── login.php
│       │   ├── register_step1.php
│       │   └── register_step2.php
│       ├── user/
│       │   └── dashboard.php
│       └── admin/
│           └── dashboard.php
├── public/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── app.js
│   └── index.php
└── database/
    └── migrations/
```

---

## 📊 Routes CodeIgniter Recommandées

### Authentification
```php
$routes->post('/auth/login', 'Auth::login');
$routes->post('/auth/register/step1', 'Auth::registerStep1');
$routes->post('/auth/register/step2', 'Auth::registerStep2');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/auth/forgot-password', 'Auth::forgotPassword');
```

### User Dashboard
```php
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/profile', 'Dashboard::profile', ['filter' => 'auth']);
$routes->post('/profile/update', 'Dashboard::updateProfile', ['filter' => 'auth']);
$routes->post('/wallet/add-code', 'Dashboard::addCode', ['filter' => 'auth']);
$routes->post('/regime/activate', 'Dashboard::activateRegime', ['filter' => 'auth']);
$routes->get('/regime/:id/export-pdf', 'Dashboard::exportPDF', ['filter' => 'auth']);
```

### Admin Routes
```php
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'Admin::dashboard');
    $routes->get('regimes', 'Admin\Regime::index');
    $routes->post('regimes', 'Admin\Regime::create');
    $routes->put('regimes/:id', 'Admin\Regime::update');
    $routes->delete('regimes/:id', 'Admin\Regime::delete');
    
    $routes->get('activities', 'Admin\Activity::index');
    $routes->resource('promo-codes');
    $routes->resource('parameters');
});
```

---

## 🗄️ Structure Base de Données

### Tableaux Principaux

#### `users`
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    gender ENUM('male', 'female'),
    phone VARCHAR(20),
    birthdate DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### `user_health_info`
```sql
CREATE TABLE user_health_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    height INT,
    weight INT,
    imc FLOAT,
    goal ENUM('increase', 'decrease', 'ideal'),
    has_gold_membership BOOLEAN DEFAULT FALSE,
    wallet_balance DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

#### `regimes`
```sql
CREATE TABLE regimes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT,
    duration_days INT,
    price DECIMAL(10,2),
    meat_percentage INT,
    poultry_percentage INT,
    fish_percentage INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### `activities`
```sql
CREATE TABLE activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT,
    intensity ENUM('low', 'medium', 'high'),
    calories_burned INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### `promo_codes`
```sql
CREATE TABLE promo_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE,
    amount DECIMAL(10,2),
    is_used BOOLEAN DEFAULT FALSE,
    used_by INT,
    used_at TIMESTAMP NULL,
    FOREIGN KEY (used_by) REFERENCES users(id)
);
```

#### `user_regimes`
```sql
CREATE TABLE user_regimes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    regime_id INT,
    start_date DATE,
    end_date DATE,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (regime_id) REFERENCES regimes(id)
);
```

---

## 🎨 Design System

### Couleurs Principales
- **Primary Green**: `#10b981`
- **Primary Dark**: `#059669`
- **Primary Light**: `#d1fae5`
- **Dark**: `#1f2937`
- **Light**: `#f9fafb`
- **Gray**: `#6b7280`

### Typographie
- **Display**: 'Plus Jakarta Sans' (titres)
- **Body**: 'Manrope' (texte courant)

### Spacing
- Base unit: 8px
- Multiples: 8px, 16px, 24px, 32px, 48px, etc.

### Breakpoints Responsifs
- Mobile: < 600px
- Tablet: 600px - 1024px
- Desktop: > 1024px

---

## 📝 Fonctionnalités Minimales à Implémenter

### Front Office
✅ Inscription en 2 étapes
✅ Connexion/Déconnexion
✅ Affichage profil utilisateur
✅ Sélection objectif (3 options)
✅ Calcul IMC automatique
✅ Affichage régimes personnalisés
✅ Activation régime
✅ Portefeuille (consultation solde)
✅ Ajout code promo
✅ Export PDF régime
✅ Option Gold (15% de remise)

### Back Office
✅ Authentification admin
✅ Dashboard avec statistiques
✅ CRUD Régimes (avec % viande/volaille/poisson)
✅ CRUD Activités
✅ Validation codes promo
✅ CRUD Paramètres
✅ Graphiques (Chart.js intégré)
✅ Tableaux de données

---

## 📋 Données Minimales Requises

### Users (5)
- Jean Dupont (jean@example.com)
- Marie Martin (marie@example.com)
- Pierre Lefebvre (pierre@example.com)
- Sophie Bernard (sophie@example.com)
- Luc Dubois (luc@example.com)

### Regimes (5)
1. Régime Équilibré - 30j - 19,99€
2. Régime Protéiné - 60j - 34,99€
3. Régime Léger - 15j - 12,99€
4. Régime Détox - 21j - 24,99€
5. Régime Haute Performance - 90j - 39,99€

### Activities (5)
1. Course à pied - Intensité Haute
2. Yoga - Intensité Basse
3. Musculation - Intensité Haute
4. Marche rapide - Intensité Moyenne
5. Natation - Intensité Moyenne

### Promo Codes (15)
```
NUTRI100
HEALTHY50
FIT25
REGIME10
SPORT20
WELLNESS30
GOLD15
PROMO40
SAISON05
SUMMER60
NEW2024
FIT2024
SPRING25
TRAIN50
HEALTH35
```

---

## 🚀 Instructions d'Intégration

1. **Créer la structure CodeIgniter**
   ```bash
   composer create-project codeigniter4/appstarter project-name
   ```

2. **Copier les fichiers HTML** dans `app/Views/`

3. **Créer les Models** basés sur la structure BD

4. **Implémenter les Controllers** avec la logique métier

5. **Configurer les Routes** selon le guide fourni

6. **Créer la Base de Données** et les migrations

7. **Tester les fonctionnalités** front et back

---

## 📱 Considérations Spéciales

### Sécurité
- Hasher les mots de passe avec `password_hash()`
- Valider tous les inputs côté serveur
- Utiliser les filtres CodeIgniter
- Protection CSRF obligatoire

### Performance
- Utiliser la pagination pour les tableaux
- Cache les données statiques
- Minifier CSS/JS en production
- Optimiser les images

### Accessibilité
- Alt texts sur les images
- Labels sur tous les inputs
- Contraste suffisant (WCAG AA)
- Navigation au clavier

---

## 📞 Support

Pour toute question sur l'intégration, consultez la [documentation CodeIgniter](https://codeigniter.com/user_guide/)

---

**Créé le**: 8 mai 2026
**Version**: 1.0
**Statut**: Prêt pour développement
