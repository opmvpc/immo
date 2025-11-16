# 🎨 Frontend - Ajout du Sélecteur de Type de Maison

## 📝 Modifications à Apporter

Les vues `Create.vue` et `Edit.vue` doivent être mises à jour pour inclure un champ de sélection du type de maison.

---

## ✅ Create.vue - Ajouter le Select

### Code à ajouter APRÈS le titre et AVANT le prix

```vue
<!-- Type de maison -->
<div class="space-y-2">
    <Label for="house_type_id">
        Type de bien
        <span class="text-destructive">*</span>
    </Label>
    <select
        id="house_type_id"
        name="house_type_id"
        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
        required
    >
        <option value="">Sélectionnez un type</option>
        <option
            v-for="type in houseTypes"
            :key="type.id"
            :value="type.id"
        >
            {{ type.name }}
        </option>
    </select>
    <p
        v-if="errors.house_type_id"
        class="text-sm text-destructive"
    >
        {{ errors.house_type_id }}
    </p>
</div>
```

### Props à ajouter en haut du fichier

```vue
<script setup lang="js">
// ... autres imports ...

defineProps({
    houseTypes: Array,
});
</script>
```

---

## ✅ Edit.vue - Même Select avec defaultValue

### Code à ajouter APRÈS le titre et AVANT le prix

```vue
<!-- Type de maison -->
<div class="space-y-2">
    <Label for="house_type_id">
        Type de bien
        <span class="text-destructive">*</span>
    </Label>
    <select
        id="house_type_id"
        name="house_type_id"
        :defaultValue="house.house_type_id"
        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
        required
    >
        <option value="">Sélectionnez un type</option>
        <option
            v-for="type in houseTypes"
            :key="type.id"
            :value="type.id"
        >
            {{ type.name }}
        </option>
    </select>
    <p
        v-if="errors.house_type_id"
        class="text-sm text-destructive"
    >
        {{ errors.house_type_id }}
    </p>
</div>
```

### Props à ajouter

```vue
<script setup lang="js">
// ... autres imports ...

defineProps({
    house: Object,
    houseTypes: Array,
});
</script>
```

---

## ✅ Index.vue - Afficher le Type

### Dans la carte de maison, après le titre:

```vue
<CardTitle class="line-clamp-1">
    {{ house.title }}
</CardTitle>
<!-- Ajouter cette ligne -->
<Badge variant="outline" class="mt-1 w-fit">
    {{ house.house_type?.name }}
</Badge>
<CardDescription class="line-clamp-1">
    {{ house.address }}
</CardDescription>
```

Ou après les badges de chambres/taille:

```vue
<div class="flex gap-2">
    <Badge variant="secondary">
        {{ house.bedrooms }} ch.
    </Badge>
    <Badge variant="secondary">
        {{ house.size }} m²
    </Badge>
    <!-- Ajouter cette ligne -->
    <Badge variant="outline">
        {{ house.house_type?.name }}
    </Badge>
</div>
```

---

## ✅ Show.vue - Afficher le Type

### Après le prix, dans la section infos:

```vue
<CardTitle class="text-3xl text-primary">
    {{ formatPrice(house.price) }}
</CardTitle>
<!-- Ajouter cette ligne -->
<Badge variant="outline" class="mt-2 w-fit">
    {{ house.house_type?.name }}
</Badge>
```

Ou dans la section métadonnées:

```vue
<CardContent class="space-y-2 text-sm">
    <div class="flex justify-between">
        <span class="text-muted-foreground">Type</span>
        <span>{{ house.house_type?.name }}</span>
    </div>
    <div class="flex justify-between">
        <span class="text-muted-foreground">Créé le</span>
        <span>{{ formatDate(house.created_at) }}</span>
    </div>
    <!-- ... etc -->
</CardContent>
```

---

## 🎨 Alternative: Composant Select de shadcn-vue

Si vous voulez utiliser un composant plus élégant:

```bash
npx shadcn-vue@latest add select
```

```vue
<script setup lang="js">
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
</script>

<template>
    <!-- Note: Avec shadcn-vue Select, il faut gérer la valeur différemment -->
    <!-- Le composant <Form> d'Inertia préfère le <select> HTML natif -->
    <select name="house_type_id">
        <option
            v-for="type in houseTypes"
            :key="type.id"
            :value="type.id"
        >
            {{ type.name }}
        </option>
    </select>
</template>
```

**⚠️ Important:** Avec le composant `<Form>` d'Inertia, il est recommandé d'utiliser le `<select>` HTML natif car il gère automatiquement la soumission via l'attribut `name`.

---

## 📊 Résumé des Modifications

### Fichiers à modifier
1. `resources/js/pages/Houses/Create.vue` ✏️
2. `resources/js/pages/Houses/Edit.vue` ✏️
3. `resources/js/pages/Houses/Index.vue` ✏️ (optionnel - affichage)
4. `resources/js/pages/Houses/Show.vue` ✏️ (optionnel - affichage)

### Backend déjà mis à jour ✅
- ✅ Controller valide `house_type_id`
- ✅ Controller passe `houseTypes` aux vues Create/Edit
- ✅ Model House a la relation `houseType()`
- ✅ Index/Show chargent la relation avec `with('houseType')`

---

## 🐛 Dépannage

**Erreur "houseTypes is not defined"**
- Le Controller doit passer `houseTypes` via Inertia::render()
- Vérifier que `HouseType::all()` retourne bien des données

**Type non affiché dans Index/Show**
- Vérifier que la relation est chargée avec `->with('houseType')`
- Utiliser `house.house_type?.name` (optionnel chaining) pour éviter les erreurs

**Validation échoue**
- Vérifier que le `<select>` a bien un attribut `name="house_type_id"`
- S'assurer qu'une option est sélectionnée (pas de value vide)

---

**Note:** Ces modifications sont **optionnelles** si vous voulez tester le backend sans toucher au frontend. Les seeders créent déjà les maisons avec `house_type_id`, donc le système fonctionne.
