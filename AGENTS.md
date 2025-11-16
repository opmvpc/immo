# 📚 AGENTS.md - Guide de Développement du Projet Immo

> **Documentation destinée aux développeurs et aux AI agents** pour maintenir la cohérence et la qualité du code dans ce projet Laravel + Inertia.js + Vue 3.

---

## 🎯 Stack Technique

Ce projet utilise le **nouveau starter kit Laravel** (introduit en mars 2025) qui remplace Jetstream. Fini les anciennes pratiques! 🚀

### Backend

- **Laravel 12+** avec PHP 8.2+
- **Laravel Fortify** pour l'authentification (avec 2FA intégré)
- **Inertia.js v2** pour le pont backend/frontend
- **Laravel Wayfinder** pour la génération de routes typées

### Frontend

- **Vue 3** avec Composition API (`<script setup>` uniquement)
- **PAS de TypeScript** - on utilise du JavaScript pur pour cet exercice pédagogique
- **Inertia.js v2** côté client
- **Tailwind CSS v4** pour le styling
- **shadcn-vue** pour les composants UI

### Base de données

- **SQLite** (ou MySQL selon environnement)
- Migrations Laravel avec types stricts

---

## 📐 Conventions de Code

### 1. Structure des Composants Vue

**✅ TOUJOURS utiliser `<script setup lang="js">`** - C'est la syntaxe moderne de Vue 3

```vue
<!-- ✅ CORRECT -->
<script setup lang="js">
import { ref } from 'vue';
import { Form } from '@inertiajs/vue3';

const title = ref('');
const price = ref(0);
</script>

<template>
    <div>
        <!-- votre contenu -->
    </div>
</template>
```

**Points importants:**

- ✅ **TOUJOURS** ajouter `lang="js"` dans la balise `<script setup>`
- ✅ Utiliser **Composition API** uniquement
- ❌ **JAMAIS** d'Options API dans ce projet

```vue
<!-- ❌ INTERDIT - Options API est deprecated pour ce projet -->
<script>
export default {
    data() {
        return {
            title: '',
        };
    },
};
</script>
```

### 2. Formulaires avec Inertia

**✅ TOUJOURS utiliser le composant `<Form>` d'Inertia**

Le composant `<Form>` gère automatiquement:

- La conversion en FormData pour les uploads
- Les erreurs de validation
- L'état de soumission (processing, progress, etc.)
- Les redirections après soumission

```vue
<script setup lang="js">
import { Form } from '@inertiajs/vue3';
</script>

<template>
    <Form action="/houses" method="post" #default="{ errors, processing }">
        <input type="text" name="title" placeholder="Titre du bien" />
        <div v-if="errors.title" class="text-red-500">
            {{ errors.title }}
        </div>

        <input type="number" name="price" placeholder="Prix" />
        <div v-if="errors.price" class="text-red-500">
            {{ errors.price }}
        </div>

        <button type="submit" :disabled="processing">
            {{ processing ? 'Enregistrement...' : 'Créer la maison' }}
        </button>
    </Form>
</template>
```

**Points clés:**

- Pas besoin de `v-model` - utilisez les attributs `name` natifs
- Les erreurs sont automatiquement disponibles via `errors`
- `processing` indique si le formulaire est en cours de soumission
- Les fichiers sont automatiquement gérés avec `<input type="file" name="images" multiple />`

### 3. Utilisation de Wayfinder

**Wayfinder génère des fonctions typées pour vos routes Laravel**

```vue
<script setup>
import { Form } from '@inertiajs/vue3';
import { store } from '@/actions/App/Http/Controllers/HouseController';

// Utilisation avec Form component
</script>

<template>
    <Form :action="store()">
        <!-- La méthode HTTP et l'URL sont automatiquement inférées -->
        <input type="text" name="title" />
        <button type="submit">Créer</button>
    </Form>
</template>
```

Pour un formulaire d'édition:

```vue
<script setup lang="js">
import { Form } from '@inertiajs/vue3';
import { update } from '@/actions/App/Http/Controllers/HouseController';

defineProps({
    house: Object,
});
</script>

<template>
    <Form :action="update(house.id)">
        <!-- Method PUT sera automatiquement utilisée -->
        <input type="text" name="title" :defaultValue="house.title" />
        <button type="submit">Mettre à jour</button>
    </Form>
</template>
```

**Pour les liens:**

```vue
<script setup lang="js">
import { Link } from '@inertiajs/vue3';
import { show } from '@/actions/App/Http/Controllers/HouseController';
</script>

<template>
    <Link :href="show(house.id)"> Voir le bien </Link>
</template>
```

### 4. Valeurs par Défaut des Formulaires

Utilisez les attributs HTML natifs:

```vue
<template>
    <Form action="/houses" method="post">
        <!-- Pour les inputs text -->
        <input type="text" name="title" defaultValue="Maison par défaut" />

        <!-- Pour les textareas -->
        <textarea name="description" defaultValue="Description..." />

        <!-- Pour les selects -->
        <select name="bedrooms">
            <option value="1">1 chambre</option>
            <option value="2" selected>2 chambres</option>
            <option value="3">3 chambres</option>
        </select>

        <!-- Pour les checkboxes -->
        <input type="checkbox" name="featured" value="1" defaultChecked />
    </Form>
</template>
```

### 5. Upload de Fichiers

```vue
<template>
    <Form action="/houses" method="post" #default="{ progress }">
        <input type="text" name="title" />

        <!-- Upload multiple d'images -->
        <input type="file" name="images" multiple accept="image/*" />

        <!-- Affichage de la progression -->
        <div v-if="progress">
            <progress :value="progress.percentage" max="100" />
            {{ progress.percentage }}%
        </div>

        <button type="submit">Créer</button>
    </Form>
</template>
```

### 6. Slot Props du Composant Form

Le composant `<Form>` expose plusieurs propriétés utiles:

```vue
<template>
    <Form
        action="/houses"
        method="post"
        #default="{
            errors, // Objet des erreurs de validation
            hasErrors, // Boolean: y a-t-il des erreurs?
            processing, // Boolean: soumission en cours?
            progress, // Objet: progression upload (percentage, etc.)
            wasSuccessful, // Boolean: soumission réussie?
            recentlySuccessful, // Boolean: succès récent (2 secondes)
            setError, // Function: définir une erreur manuellement
            clearErrors, // Function: effacer les erreurs
            reset, // Function: réinitialiser le formulaire
            isDirty, // Boolean: formulaire modifié?
            submit, // Function: soumettre programmatiquement
        }"
    >
        <!-- Vos champs -->
    </Form>
</template>
```

### 7. shadcn-vue Components

**Installation de nouveaux composants:**

```bash
npx shadcn-vue@latest add button
npx shadcn-vue@latest add input
npx shadcn-vue@latest add card
npx shadcn-vue@latest add dialog
npx shadcn-vue@latest add toast
```

Les composants sont publiés dans `resources/js/components/ui/` et sont entièrement personnalisables.

**Utilisation:**

```vue
<script setup lang="js">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Ajouter une maison</CardTitle>
        </CardHeader>
        <CardContent>
            <Input placeholder="Titre" />
            <Button>Enregistrer</Button>
        </CardContent>
    </Card>
</template>
```

---

## 🏗️ Structure du Projet

```
resources/js/
├── actions/              # Routes Wayfinder générées
├── components/           # Composants réutilisables
│   └── ui/              # Composants shadcn-vue
├── composables/          # Composables Vue (hooks)
├── layouts/             # Layouts de l'application
│   ├── app/            # Layouts authentifiés
│   └── auth/           # Layouts d'authentification
├── lib/                 # Utilitaires et configuration
├── pages/               # Pages Inertia
├── routes/              # Routes Wayfinder nommées
└── types/               # Définitions de types (si TS)

app/Http/Controllers/    # Contrôleurs Laravel
database/
├── migrations/          # Migrations de base de données
├── factories/           # Factories pour les tests
└── seeders/            # Seeders
```

---

## 🎨 Layouts Disponibles

Le starter kit inclut plusieurs layouts:

### Layouts principaux

- **AppSidebarLayout.vue** - Layout avec sidebar (défaut)
- **AppHeaderLayout.vue** - Layout avec header horizontal

Pour changer de layout, modifier `resources/js/layouts/AppLayout.vue`:

```vue
<!-- Sidebar layout (défaut) -->
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'

<!-- Header layout -->
import AppLayout from '@/layouts/app/AppHeaderLayout.vue'
```

### Variantes de sidebar

Dans `resources/js/components/AppSidebar.vue`:

```vue
<!-- Sidebar normale -->
<Sidebar collapsible="icon" variant="sidebar"></Sidebar>
```

### Layouts d'authentification

Trois variantes disponibles (login, register, etc.):

- **AuthSimpleLayout.vue** - Simple et centré
- **AuthCardLayout.vue** - Avec une carte
- **AuthSplitLayout.vue** - Split screen avec image

Modifier `resources/js/layouts/AuthLayout.vue` pour changer.

---

## ✅ Bonnes Pratiques Backend

### Controllers

```php
<?php
// app/Http/Controllers/HouseController.php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HouseController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Houses/Index', [
            'houses' => House::query()
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(12),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'size' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        $house = auth()->user()->houses()->create($validated);

        // Gestion des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('houses', 'public');
                $house->images()->create(['path' => $path]);
            }
        }

        return to_route('houses.index')
            ->with('success', 'Maison créée avec succès!');
    }

    public function update(Request $request, House $house)
    {
        // Vérifier que l'utilisateur possède cette maison
        $this->authorize('update', $house);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            // ... autres champs
        ]);

        $house->update($validated);

        return back()->with('success', 'Maison mise à jour!');
    }

    public function destroy(House $house)
    {
        $this->authorize('delete', $house);

        // Supprimer les images du storage
        foreach ($house->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $house->delete();

        return to_route('houses.index')
            ->with('success', 'Maison supprimée!');
    }
}
```

### Models

```php
<?php
// app/Models/House.php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'address',
        'bedrooms',
        'size',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'size' => 'decimal:2',
        'bedrooms' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(HouseImage::class);
    }
}
```

---

## 🔐 Authentification & Autorisations

### Fortify est pré-configuré avec:

- Login / Register
- Mot de passe oublié
- Vérification email
- **Two-Factor Authentication (2FA)** activé par défaut

### Policies pour les autorisations

```php
<?php
// app/Policies/HousePolicy.php

namespace App\Policies;

use App\Models\House;
use App\Models\User;

class HousePolicy
{
    public function update(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }

    public function delete(User $user, House $house): bool
    {
        return $user->id === $house->user_id;
    }
}
```

---

## 🎨 Styling avec Tailwind v4

**Classes utiles courantes:**

```vue
<template>
    <!-- Container responsive -->
    <div class="container mx-auto px-4">
        <!-- Grid responsive -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Card avec hover -->
            <div
                class="rounded-lg bg-white p-6 shadow transition-shadow hover:shadow-lg"
            >
                <!-- Flexbox centré -->
                <div class="flex items-center justify-between">
                    <!-- Texte tronqué -->
                    <p class="truncate text-sm text-gray-600">Long texte...</p>
                </div>
            </div>
        </div>
    </div>
</template>
```

---

## 🚀 Commandes Utiles

### Backend

```bash
# Créer une migration
php artisan make:migration create_houses_table

# Créer un model avec migration, factory, seeder, policy
php artisan make:model House -mfsp

# Créer un contrôleur resource
php artisan make:controller HouseController --resource

# Lancer les migrations
php artisan migrate

# Générer les routes Wayfinder
php artisan wayfinder:generate

# Lancer le serveur de dev
php artisan serve
# ou
composer run dev
```

### Frontend

```bash
# Installer les dépendances
npm install

# Dev avec hot reload
npm run dev

# Build production
npm run build

# Ajouter un composant shadcn-vue
npx shadcn-vue@latest add button
```

---

## 📝 Exemple Complet: Formulaire de Création de Maison

```vue
<!-- resources/js/pages/Houses/Create.vue -->
<script setup lang="js">
import { Form } from '@inertiajs/vue3';
import { store } from '@/actions/App/Http/Controllers/HouseController';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
</script>

<template>
    <AppLayout>
        <div class="container mx-auto py-8">
            <Card>
                <CardHeader>
                    <CardTitle>Ajouter une maison</CardTitle>
                </CardHeader>
                <CardContent>
                    <Form
                        :action="store()"
                        #default="{ errors, processing, progress }"
                        class="space-y-6"
                    >
                        <!-- Titre -->
                        <div>
                            <label
                                for="title"
                                class="mb-2 block text-sm font-medium"
                            >
                                Titre
                            </label>
                            <Input
                                id="title"
                                type="text"
                                name="title"
                                placeholder="Ex: Belle maison à Paris"
                            />
                            <p
                                v-if="errors.title"
                                class="mt-1 text-sm text-red-500"
                            >
                                {{ errors.title }}
                            </p>
                        </div>

                        <!-- Prix -->
                        <div>
                            <label
                                for="price"
                                class="mb-2 block text-sm font-medium"
                            >
                                Prix (€)
                            </label>
                            <Input
                                id="price"
                                type="number"
                                name="price"
                                step="0.01"
                                placeholder="250000"
                            />
                            <p
                                v-if="errors.price"
                                class="mt-1 text-sm text-red-500"
                            >
                                {{ errors.price }}
                            </p>
                        </div>

                        <!-- Adresse -->
                        <div>
                            <label
                                for="address"
                                class="mb-2 block text-sm font-medium"
                            >
                                Adresse
                            </label>
                            <Input
                                id="address"
                                type="text"
                                name="address"
                                placeholder="123 rue de la Paix, 75001 Paris"
                            />
                            <p
                                v-if="errors.address"
                                class="mt-1 text-sm text-red-500"
                            >
                                {{ errors.address }}
                            </p>
                        </div>

                        <!-- Chambres -->
                        <div>
                            <label
                                for="bedrooms"
                                class="mb-2 block text-sm font-medium"
                            >
                                Nombre de chambres
                            </label>
                            <Input
                                id="bedrooms"
                                type="number"
                                name="bedrooms"
                                placeholder="3"
                            />
                            <p
                                v-if="errors.bedrooms"
                                class="mt-1 text-sm text-red-500"
                            >
                                {{ errors.bedrooms }}
                            </p>
                        </div>

                        <!-- Taille -->
                        <div>
                            <label
                                for="size"
                                class="mb-2 block text-sm font-medium"
                            >
                                Taille (m²)
                            </label>
                            <Input
                                id="size"
                                type="number"
                                name="size"
                                step="0.01"
                                placeholder="120.50"
                            />
                            <p
                                v-if="errors.size"
                                class="mt-1 text-sm text-red-500"
                            >
                                {{ errors.size }}
                            </p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label
                                for="description"
                                class="mb-2 block text-sm font-medium"
                            >
                                Description
                            </label>
                            <Textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Décrivez le bien..."
                            />
                            <p
                                v-if="errors.description"
                                class="mt-1 text-sm text-red-500"
                            >
                                {{ errors.description }}
                            </p>
                        </div>

                        <!-- Images -->
                        <div>
                            <label
                                for="images"
                                class="mb-2 block text-sm font-medium"
                            >
                                Images
                            </label>
                            <input
                                id="images"
                                type="file"
                                name="images"
                                multiple
                                accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <p
                                v-if="errors['images.0']"
                                class="mt-1 text-sm text-red-500"
                            >
                                {{ errors['images.0'] }}
                            </p>
                        </div>

                        <!-- Progression upload -->
                        <div v-if="progress" class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Upload en cours...</span>
                                <span>{{ progress.percentage }}%</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-gray-200">
                                <div
                                    class="h-2 rounded-full bg-blue-600 transition-all"
                                    :style="{
                                        width: `${progress.percentage}%`,
                                    }"
                                />
                            </div>
                        </div>

                        <!-- Bouton submit -->
                        <div class="flex gap-4">
                            <Button type="submit" :disabled="processing">
                                {{
                                    processing
                                        ? 'Enregistrement...'
                                        : 'Créer la maison'
                                }}
                            </Button>

                            <Button
                                type="button"
                                variant="outline"
                                @click="$inertia.visit('/houses')"
                            >
                                Annuler
                            </Button>
                        </div>
                    </Form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
```

---

## 🎓 Pour les Étudiants

### Points importants à retenir:

1. **TOUJOURS `lang="js"` dans `<script setup>`** - requis par ESLint
2. **Pas de `v-model` avec `<Form>`** - utilisez les attributs `name` natifs
3. **Wayfinder** génère vos routes - ne codez plus les URLs en dur
4. **shadcn-vue** est votre ami - tous les composants sont customisables
5. **Inertia** gère les SPA sans API REST - c'est magique ✨
6. **Laravel Fortify** inclut 2FA gratuitement - sécurité par défaut
7. **Pas de `v-html` sur composants** - utilisez des éléments HTML natifs

### Ressources

- [Documentation Inertia.js](https://inertiajs.com/)
- [Documentation Vue 3](https://vuejs.org/)
- [Documentation Laravel](https://laravel.com/docs)
- [shadcn-vue Components](https://www.shadcn-vue.com/)
- [Tailwind CSS](https://tailwindcss.com/)

---

**Dernière mise à jour:** Novembre 2025
**Version du starter kit:** Laravel 12 avec Inertia v2
