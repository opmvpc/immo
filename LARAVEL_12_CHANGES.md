# 🔄 Changements Laravel 12

## ⚠️ Breaking Changes - Autorisations dans les Controllers

### Problème

En **Laravel 12**, la méthode `$this->authorize()` n'est plus disponible directement dans les controllers.

### Avant (Laravel 11 et antérieurs)

```php
class HouseController extends Controller
{
    public function show(House $house)
    {
        $this->authorize('view', $house); // ❌ Ne fonctionne plus!

        return view('houses.show', compact('house'));
    }
}
```

### Après (Laravel 12)

**Option 1: Utiliser la facade `Gate` (RECOMMANDÉ)**

```php
use Illuminate\Support\Facades\Gate;

class HouseController extends Controller
{
    public function show(House $house)
    {
        Gate::authorize('view', $house); // ✅ Nouvelle méthode

        return view('houses.show', compact('house'));
    }
}
```

**Option 2: Utiliser la fonction helper `authorize()`**

```php
class HouseController extends Controller
{
    public function show(House $house)
    {
        authorize('view', $house); // ✅ Alternative

        return view('houses.show', compact('house'));
    }
}
```

**Option 3: Ajouter le trait `AuthorizesRequests` (si migration depuis Laravel 11)**

```php
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HouseController extends Controller
{
    use AuthorizesRequests;

    public function show(House $house)
    {
        $this->authorize('view', $house); // ✅ Fonctionne avec le trait

        return view('houses.show', compact('house'));
    }
}
```

---

## 🎯 Solution Appliquée dans le Projet

Nous utilisons **la facade `Gate`** car c'est:
- ✅ La méthode recommandée en Laravel 12
- ✅ Explicite et claire
- ✅ Pas besoin de traits supplémentaires
- ✅ Cohérent avec les autres facades Laravel

### Import Requis

```php
use Illuminate\Support\Facades\Gate;
```

### Fichiers Modifiés

**`app/Http/Controllers/HouseController.php`**

Tous les appels `$this->authorize()` ont été remplacés par `Gate::authorize()`:

1. `show()` - ligne 85
2. `edit()` - ligne 96
3. `update()` - ligne 111
4. `destroy()` - ligne 143
5. `deleteImage()` - ligne 163

---

## 📚 Documentation Mise à Jour

### AGENTS.md

Les exemples de code ont été mis à jour pour refléter la nouvelle syntaxe Laravel 12:

```php
use Illuminate\Support\Facades\Gate;

class HouseController extends Controller
{
    public function update(Request $request, House $house)
    {
        Gate::authorize('update', $house); // ✅ Nouvelle syntaxe

        $validated = $request->validate([...]);
        $house->update($validated);

        return back()->with('success', 'Maison mise à jour!');
    }
}
```

---

## 🎓 Pour les Étudiants

### Pourquoi ce changement ?

Laravel 12 vise à rendre le framework plus **explicite** et **modulaire**:

1. **Clarté**: `Gate::authorize()` indique clairement qu'on utilise le système d'autorisation
2. **Modularité**: Pas besoin d'hériter de fonctionnalités via des controllers de base
3. **Flexibilité**: Plus facile de personnaliser le comportement des autorisations
4. **Performance**: Moins de surcharge héritée des controllers parents

### Comparaison

```php
// ❌ Laravel 11 - Méthode implicite via héritage
$this->authorize('view', $house);

// ✅ Laravel 12 - Méthode explicite via facade
Gate::authorize('view', $house);

// ✅ Laravel 12 - Alternative avec helper global
authorize('view', $house);
```

### Quand utiliser quoi ?

| Méthode | Usage | Avantage |
|---------|-------|----------|
| `Gate::authorize()` | Controllers, services, jobs | Explicite, IDE-friendly |
| `authorize()` helper | Closures, views, helpers | Concis, global |
| Trait `AuthorizesRequests` | Migration Laravel 11→12 | Compatible ancien code |

---

## 🔍 Autres Breaking Changes Laravel 12

### 1. Validation - Rule Objects

```php
// ❌ Laravel 11
'email' => 'required|email|unique:users'

// ✅ Laravel 12 - Préféré
'email' => ['required', 'email', Rule::unique('users')]
```

### 2. Model Casts - Plus de $casts array

```php
// ❌ Laravel 11
protected $casts = [
    'created_at' => 'datetime',
];

// ✅ Laravel 12 - Méthode
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
    ];
}
```

**Note:** Le projet utilise déjà cette syntaxe! ✅

### 3. Controllers - Pas de classe de base enrichie

Laravel 12 encourage l'injection de dépendances plutôt que l'héritage:

```php
// ❌ Ancien style
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

// ✅ Laravel 12 - Controller minimal
class Controller
{
    // Inject ce dont vous avez besoin
}
```

---

## 📝 Checklist de Migration

Si vous migrez un projet Laravel 11 vers Laravel 12:

- [ ] Remplacer tous les `$this->authorize()` par `Gate::authorize()`
- [ ] Vérifier les `$casts` → méthode `casts()`
- [ ] Mettre à jour les règles de validation (arrays vs pipes)
- [ ] Tester toutes les autorisations
- [ ] Vérifier les policies sont bien enregistrées
- [ ] Lire le [UPGRADE GUIDE](https://laravel.com/docs/12.x/upgrade) officiel

---

## 🐛 Erreurs Courantes

### 1. "Call to undefined method authorize()"

**Erreur:**
```
Call to undefined method App\Http\Controllers\HouseController::authorize()
```

**Solution:**
```php
// Ajouter l'import
use Illuminate\Support\Facades\Gate;

// Changer
$this->authorize('view', $house);

// En
Gate::authorize('view', $house);
```

### 2. "Gate not found"

**Erreur:**
```
Class 'Gate' not found
```

**Solution:**
```php
// Vérifier l'import en haut du fichier
use Illuminate\Support\Facades\Gate;
```

### 3. Policy non trouvée

**Erreur:**
```
Unable to determine policy for [App\Models\House]
```

**Solution:**
```php
// Enregistrer la policy dans AppServiceProvider ou AuthServiceProvider
Gate::policy(House::class, HousePolicy::class);
```

**Note:** Laravel 12 détecte automatiquement les policies si elles suivent la convention de nommage!

---

## 🚀 Migration Automatique

Pour migrer automatiquement un projet Laravel 11 → 12:

```bash
# Remplacer tous les $this->authorize
find app -type f -name "*.php" -exec sed -i 's/$this->authorize(/Gate::authorize(/g' {} +

# Ajouter l'import Gate (à faire manuellement)
# use Illuminate\Support\Facades\Gate;
```

⚠️ **Attention:** Toujours vérifier manuellement après une migration automatique!

---

**Auteur:** Claude-Sama 🏴‍☠️
**Date:** Novembre 2025
**Laravel Version:** 12.38.1
**PHP Version:** 8.2+
