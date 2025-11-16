# 🚀 Installation Rapide - Projet Immo

## ⚠️ Important : PHP 8.2+ Requis

Votre système a actuellement **PHP 8.0.1**, mais Laravel 12 nécessite **PHP 8.2+**.

### Solutions :

#### Option 1 : Mettre à jour Laragon
1. Télécharger la dernière version de Laragon avec PHP 8.2+
2. Installer et sélectionner PHP 8.2+ dans le menu

#### Option 2 : Ajouter PHP 8.2+ à Laragon
1. Télécharger PHP 8.2+ depuis [windows.php.net](https://windows.php.net/download/)
2. Extraire dans `C:\laragon\bin\php\php-8.2.x`
3. Clic droit sur Laragon → PHP → Sélectionner PHP 8.2

#### Option 3 : Laravel Herd (Recommandé pour Windows)
1. Télécharger [Laravel Herd](https://herd.laravel.com/)
2. Installer (inclut PHP 8.3+, MySQL, Node.js)
3. Naviguer vers le dossier du projet dans Herd

## 📋 Installation (une fois PHP 8.2+ installé)

```bash
# 1. Installer les dépendances
composer install
npm install

# 2. Configuration
cp .env.example .env
php artisan key:generate

# 3. Ajouter dans .env:
# APP_FAKER_LOCALE=be_FR
# OPENROUTER_API_KEY=votre_clé_api

# 4. Base de données
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# 5. Générer les images (optionnel mais recommandé)
php artisan houses:generate-images

# 6. Liens et routes
php artisan storage:link
php artisan wayfinder:generate

# 7. Lancer l'application
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

## 🔑 Identifiants de Test

- **Email** : test@example.com
- **Password** : password

## ✅ Vérification de l'installation

Après l'installation, vous devriez avoir :
- ✅ 1 utilisateur de test
- ✅ 6 types de maisons
- ✅ 8 maisons d'exemple avec descriptions détaillées
- ✅ ~32 images générées par IA (si génération effectuée)
- ✅ Dashboard avec statistiques
- ✅ Page de gestion des maisons fonctionnelle

## 📚 Documentation

- **README_EXERCICE.md** : Documentation complète de l'exercice
- **AGENTS.md** : Guide des bonnes pratiques du projet
- **ENV_CONFIG.md** : Configuration OpenRouter API pour génération d'images

## 🆘 Besoin d'aide ?

Si vous rencontrez des problèmes, consultez la section "Dépannage" dans `README_EXERCICE.md`.
