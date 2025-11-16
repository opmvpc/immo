# 🔄 Changelog - Normalisation DB & Génération IA

## 📋 Modifications Effectuées

### 1. ✅ Normalisation de la Base de Données

#### Nouvelle Table: `house_types`
```sql
- id
- name (Appartement, Maison, Villa, Studio, Loft, Duplex)
- slug (appartement, maison, villa, etc.)
- description
- timestamps
```

#### Table `houses` Modifiée
```sql
+ house_type_id (FK vers house_types)
```

#### Nouveaux Models
- `app/Models/HouseType.php` avec relation `hasMany(House::class)`
- `app/Models/House.php` mis à jour avec relation `belongsTo(HouseType::class)`

---

### 2. 🎨 Génération d'Images par IA

#### Nouvelle Commande Artisan
```php
app/Console/Commands/GenerateHouseImages.php
```

**Fonctionnalités:**
- ✅ Génère des images via OpenRouter API (`openai/gpt-5-image-mini`)
- ✅ Utilise `Http` facade de Laravel (pas de package externe)
- ✅ Prompts optimisés pour chaque maison
- ✅ Sauvegarde automatique dans `storage/app/public/houses/`
- ✅ Barre de progression avec feedback
- ✅ Gestion des erreurs et rate limiting (pause 1s entre images)

**Usage:**
```bash
# Générer toutes les images manquantes
php artisan houses:generate-images

# Générer pour une maison spécifique
php artisan houses:generate-images --house=5

# Forcer la régénération
php artisan houses:generate-images --force
```

---

### 3. 📝 Seeders avec Données Réalistes

#### `database/seeders/HouseTypeSeeder.php`
Crée 6 types de maisons avec descriptions.

#### `database/seeders/HouseSeeder.php`
**Changement majeur:** Plus de factories, données **en dur** avec:
- ✅ 8 maisons détaillées (Bruxelles, Liège, Namur, Anvers, Gand, etc.)
- ✅ Descriptions complètes (220+ caractères par maison)
- ✅ 4 prompts d'images par maison (salon, cuisine, chambre, extérieur)
- ✅ Faker Belgique pour les adresses (`be_FR`)

**Exemples de maisons:**
- Appartement moderne Parc Royal (Bruxelles)
- Maison de maître 1920 (Ixelles)
- Studio étudiant UCLouvain
- Villa architecte avec piscine (Waterloo)
- Loft industriel ancienne filature (Gand)
- Penthouse terrasse panoramique (Anvers Zuid)

---

### 4. ⚙️ Configuration

#### `config/services.php`
```php
'openrouter' => [
    'api_key' => env('OPENROUTER_API_KEY'),
],
```

#### Variables `.env` requises
```env
APP_FAKER_LOCALE=be_FR
OPENROUTER_API_KEY=votre_clé_api
```

---

### 5. 📚 Documentation

#### Nouveaux fichiers
- `ENV_CONFIG.md` - Guide complet pour OpenRouter API
- `CHANGELOG_NORMALISATION.md` - Ce fichier

#### Fichiers mis à jour
- `README_EXERCICE.md` - Ajout génération IA + normalisation DB
- `INSTALLATION.md` - Nouvelles étapes d'installation
- `AGENTS.md` - (Déjà complet)

---

## 🎯 Objectifs Pédagogiques

### Pour les Étudiants

1. **Normalisation DB** ✅
   - Comprendre les relations one-to-many
   - Foreign keys et migrations
   - Modèles avec relations Eloquent

2. **Seeders Professionnels** ✅
   - Données en dur vs factories
   - Faker avec locale spécifique (Belgique)
   - Descriptions détaillées et réalistes

3. **API Integration** ✅
   - Utiliser `Http` facade Laravel
   - Gérer des requêtes POST avec headers
   - Parser des réponses JSON
   - Traiter du base64

4. **Commandes Artisan Personnalisées** ✅
   - `php artisan make:command`
   - Options et arguments
   - Progress bars
   - Feedback utilisateur

5. **Storage Laravel** ✅
   - `Storage::disk('public')->put()`
   - Organisation des fichiers
   - Lien symbolique (`php artisan storage:link`)

---

## 🚀 Workflow Complet

```bash
# 1. Migrations (ordre important!)
php artisan migrate
# Crée: house_types, houses (avec FK), house_images

# 2. Seeders
php artisan db:seed
# Crée: 1 user, 6 types, 8 maisons (avec prompts)

# 3. Génération IA (optionnel)
php artisan houses:generate-images
# Génère: ~32 images (4 par maison)
# Durée: 3-5 minutes
# Coût: ~$0.50-1.00

# 4. Liens & routes
php artisan storage:link
php artisan wayfinder:generate

# 5. Lancer l'app
php artisan serve  # Terminal 1
npm run dev        # Terminal 2
```

---

## 💡 Points Techniques Intéressants

### 1. Prompts d'Images Contextualisés

Chaque maison a 4 prompts détaillés:
```php
'image_prompts' => [
    "Modern Belgian apartment living room with Art Deco touches, floor-to-ceiling windows overlooking Brussels Royal Park...",
    "Luxury apartment kitchen with white quartz island, Siemens appliances...",
    // etc.
],
```

### 2. Gestion du Base64

```php
// L'API retourne: data:image/png;base64,iVBORw0KG...
preg_match('/^data:image\/(\w+);base64,(.+)$/', $imageUrl, $matches);
$base64Data = $matches[2];
$imageData = base64_decode($base64Data);
Storage::disk('public')->put($filename, $imageData);
```

### 3. Rate Limiting Intelligent

```php
foreach ($prompts as $prompt) {
    $this->generateImage($prompt, $apiKey);
    sleep(1); // Pause 1 seconde entre chaque image
}
```

### 4. Validation avec Exists

```php
'house_type_id' => ['required', 'exists:house_types,id'],
```

---

## 📊 Statistiques du Projet

- **Migrations:** 3 (house_types, houses, house_images)
- **Models:** 4 (User, HouseType, House, HouseImage)
- **Seeders:** 3 (DatabaseSeeder, HouseTypeSeeder, HouseSeeder)
- **Commands:** 1 (GenerateHouseImages)
- **Maisons créées:** 8 avec descriptions détaillées
- **Types de maisons:** 6
- **Images potentielles:** ~32 (4 par maison)
- **Prompts totaux:** 32 prompts optimisés
- **Lignes de code seeders:** ~250 (données en dur)

---

## 🎓 Différence avec l'Ancien Système

### Avant (Factories)
```php
House::factory()->count(15)->create(); // Données aléatoires
```

### Maintenant (Seeders avec données en dur)
```php
$houses = [
    [
        'title' => 'Appartement moderne avec vue sur le Parc Royal',
        'description' => 'Magnifique appartement de 85m²...',
        'image_prompts' => [/* 4 prompts détaillés */],
    ],
    // ... 7 autres maisons
];
```

**Avantages:**
- ✅ Données prévisibles et cohérentes
- ✅ Descriptions professionnelles
- ✅ Prompts IA optimisés
- ✅ Parfait pour démonstrations
- ✅ Plus pédagogique pour les étudiants

---

## 🔄 Prochaines Améliorations Possibles

1. Ajouter un champ `city` pour filtrer par ville
2. Système de tags (proche transports, jardin, etc.)
3. Historique des prix
4. Comparateur de biens
5. Export PDF avec images
6. Galerie d'images avec lightbox
7. Système de favoris
8. Page publique de consultation

---

**Auteur:** Claude-Sama 🏴‍☠️
**Date:** Novembre 2025
**Stack:** Laravel 12 + Inertia v2 + Vue 3 + OpenRouter AI
