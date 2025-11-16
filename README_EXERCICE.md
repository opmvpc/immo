# 🏠 Application de Gestion de Biens Immobiliers

> **Exercice pratique Laravel 12 + Inertia.js v2 + Vue 3**

Une application moderne de gestion de biens immobiliers construite avec le nouveau starter kit Laravel (mars 2025). Cet exercice démontre l'utilisation des meilleures pratiques actuelles du développement web avec Laravel et Vue.

## 🎯 Fonctionnalités

### Gestion Complète des Biens
- ✅ **CRUD complet** : Créer, lire, mettre à jour et supprimer des maisons
- ✅ **Upload d'images** : Gestion multi-images avec preview
- ✅ **Recherche avancée** : Filtres par prix, chambres, taille, mots-clés
- ✅ **Pagination** : Navigation fluide entre les résultats
- ✅ **Validation** : Erreurs de validation en temps réel

### Authentification & Sécurité
- 🔐 **Laravel Fortify** : Authentification complète avec 2FA
- 🔐 **Policies** : Chaque utilisateur ne peut gérer que ses propres biens
- 🔐 **Validation côté serveur** : Sécurité maximale

### Interface Moderne
- 🎨 **shadcn-vue** : Composants UI élégants et accessibles
- 🎨 **Tailwind CSS v4** : Styling moderne et responsive
- 🎨 **Dark mode ready** : Support du mode sombre
- 🎨 **Animations** : Transitions fluides

## 🚀 Stack Technique

### Backend
- **Laravel 12** avec PHP 8.2+
- **Inertia.js v2** - SPA sans API
- **Laravel Fortify** - Authentification avec 2FA
- **Laravel Wayfinder** - Routes typées
- **SQLite** - Base de données légère

### Frontend
- **Vue 3** avec Composition API (`<script setup>`)
- **Inertia.js v2** côté client
- **Tailwind CSS v4**
- **shadcn-vue** - Composants UI
- **Vite** - Build ultra-rapide

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js 18+ & NPM
- SQLite extension PHP activée

## 🔧 Installation

### 1. Cloner le projet

```bash
git clone <votre-repo>
cd immo
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
```

### 4. Configuration de l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Créer la base de données

La configuration par défaut utilise SQLite. Le fichier sera créé automatiquement :

```bash
touch database/database.sqlite
```

### 6. Lancer les migrations

```bash
php artisan migrate
```

### 7. Configuration des variables d'environnement

Ajoutez dans votre `.env` :

```env
APP_FAKER_LOCALE=be_FR
OPENROUTER_API_KEY=votre_clé_api
```

Pour obtenir une clé API OpenRouter, consultez `ENV_CONFIG.md`.

### 8. Lancer les seeders

Cela créera un utilisateur de test, 6 types de maisons et 8 maisons d'exemple :

```bash
php artisan db:seed
```

**Identifiants de test :**
- Email : `test@example.com`
- Mot de passe : `password`

### 9. Générer les images par IA

```bash
php artisan houses:generate-images
```

⏱️ **Durée:** 3-5 minutes pour ~32 images
💰 **Coût:** ~$0.50-1.00

Pour plus d'infos, consultez `ENV_CONFIG.md`.

### 10. Créer le lien symbolique pour les images

```bash
php artisan storage:link
```

### 11. Générer les routes Wayfinder

```bash
php artisan wayfinder:generate
```

### 12. Lancer l'application

Dans deux terminaux séparés :

**Terminal 1 - Serveur Laravel :**
```bash
php artisan serve
```

**Terminal 2 - Vite (HMR) :**
```bash
npm run dev
```

L'application sera accessible sur : **http://localhost:8000**

## 🎓 Pour les Étudiants

### Structure du Projet

```
app/
├── Http/Controllers/
│   └── HouseController.php      # CRUD des maisons
├── Models/
│   ├── House.php                # Model principal
│   └── HouseImage.php           # Model des images
└── Policies/
    └── HousePolicy.php          # Autorisations

database/
├── migrations/
│   ├── *_create_house_types_table.php
│   ├── *_create_houses_table.php
│   └── *_create_house_images_table.php
└── seeders/
    ├── HouseTypeSeeder.php
    └── HouseSeeder.php            # Données en dur avec prompts IA

resources/js/
├── pages/Houses/
│   ├── Index.vue               # Liste avec filtres
│   ├── Create.vue              # Formulaire création
│   ├── Edit.vue                # Formulaire édition
│   └── Show.vue                # Détails
└── components/ui/              # Composants shadcn-vue
```

### Concepts Clés Démontrés

#### 1. Formulaires avec Inertia v2

Le composant `<Form>` d'Inertia gère automatiquement :
- ✅ Conversion en FormData pour les uploads
- ✅ Erreurs de validation
- ✅ État de soumission (`processing`, `progress`)
- ✅ Pas besoin de `v-model` - juste des attributs `name` natifs

```vue
<Form :action="store()">
  <input type="text" name="title" />
  <input type="file" name="images" multiple />
  <button type="submit">Créer</button>
</Form>
```

#### 2. Wayfinder - Routes Typées

Plus besoin de coder les URLs en dur :

```vue
import { index, store, update } from '@/actions/App/Http/Controllers/HouseController';

// Au lieu de :
router.post('/houses', data)

// On fait :
<Form :action="store()">
```

#### 3. Query Scopes pour la Recherche

Méthodes réutilisables dans le Model :

```php
public function scopeSearch(Builder $query, ?string $search): Builder
{
    if (!$search) return $query;

    return $query->where('title', 'like', "%{$search}%");
}
```

#### 4. Policies pour les Autorisations

Chaque utilisateur ne peut gérer que ses biens :

```php
public function update(User $user, House $house): bool
{
    return $user->id === $house->user_id;
}
```

#### 5. Upload d'Images

FormData est automatiquement géré par Inertia :

```vue
<input type="file" name="images" multiple accept="image/*" />
```

Backend :

```php
if ($request->hasFile('images')) {
    foreach ($request->file('images') as $image) {
        $path = $image->store('houses', 'public');
        $house->images()->create(['path' => $path]);
    }
}
```

#### 6. Génération d'Images par IA

Commande Artisan personnalisée pour générer des images réalistes via OpenRouter API :

```php
php artisan houses:generate-images
```

Utilise `Http` facade de Laravel (pas de package externe) :

```php
$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $apiKey,
])->post('https://openrouter.ai/api/v1/chat/completions', [
    'model' => 'openai/gpt-5-image-mini',
    'messages' => [...],
    'modalities' => ['image', 'text'],
]);
```

#### 7. Base de Données Normalisée

Table `house_types` séparée avec relation :

```php
$house->houseType->name // "Appartement", "Maison", "Villa"...
```

#### 8. Données Réalistes avec Faker Belgique

```php
// config/app.php
'faker_locale' => env('APP_FAKER_LOCALE', 'be_FR'),

// Dans les seeders
fake('be_FR')->streetAddress() // "Rue de la Loi 123"
```

## 📝 Exercice Pratique

### Niveau 1 : Modification Simple
1. Ajouter un champ "ville" (city) aux maisons
2. Ajouter un filtre de recherche par ville
3. Afficher la ville dans les cartes de maisons

### Niveau 2 : Fonctionnalités
4. Ajouter un système de favoris
5. Permettre de marquer une maison comme "vendue"
6. Ajouter une page publique de consultation (sans auth)

### Niveau 3 : Avancé
7. Implémenter un système de commentaires
8. Ajouter des statistiques avancées au Dashboard
9. Créer un export PDF des maisons

## 🐛 Dépannage

### Problème avec PHP 8.0
Si vous avez PHP 8.0, Laravel 12 nécessite PHP 8.2+. Mettez à jour votre PHP ou utilisez Laravel Herd/Sail.

### Erreur "storage link"
```bash
php artisan storage:link
```

### Images non affichées
Vérifiez que le lien symbolique existe :
```bash
ls -la public/storage
```

### Erreur Wayfinder
Régénérez les routes :
```bash
php artisan wayfinder:generate
```

### Vite ne se connecte pas
Assurez-vous que `npm run dev` est en cours d'exécution.

## 📚 Ressources

- [Documentation Laravel](https://laravel.com/docs)
- [Documentation Inertia.js](https://inertiajs.com/)
- [Documentation Vue 3](https://vuejs.org/)
- [shadcn-vue](https://www.shadcn-vue.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Laravel Wayfinder](https://github.com/laravel/wayfinder)

## 🎯 Points d'Attention (AGENTS.md)

Ce projet suit les conventions définies dans `AGENTS.md` :

- ✅ Toujours `<script setup>` (pas d'Options API)
- ✅ Pas de TypeScript dans les exemples étudiants
- ✅ Utilisation du composant `<Form>` d'Inertia
- ✅ Routes via Wayfinder
- ✅ shadcn-vue pour les composants UI
- ✅ `declare(strict_types=1)` dans tout le code PHP

## 📄 Licence

Ce projet est un exercice pédagogique libre d'utilisation.

---

**Bon courage et amusez-vous bien! 🚀**

*Pour toute question, consultez le fichier `AGENTS.md` qui contient toutes les bonnes pratiques du projet.*
