# 🔧 Corrections ESLint Appliquées

## 📋 Problèmes Résolus

### 1. ✅ Règle `vue/block-lang`

**Problème:** La balise `<script>` doit avoir un attribut `lang`.

**Solution:** Ajout de `lang="js"` dans tous les `<script setup>`.

**Fichiers modifiés:**
- `resources/js/pages/Houses/Index.vue`
- `resources/js/pages/Houses/Create.vue`
- `resources/js/pages/Houses/Edit.vue`
- `resources/js/pages/Houses/Show.vue`

**Avant:**
```vue
<script setup>
import { ref } from 'vue';
</script>
```

**Après:**
```vue
<script setup lang="js">
import { ref } from 'vue';
</script>
```

---

### 2. ✅ Règle `vue/no-v-text-v-html-on-component`

**Problème:** Utilisation de `v-html` sur un composant (`<Button>`) qui peut casser le rendu interne.

**Fichier:** `resources/js/pages/Houses/Index.vue` (ligne 286)

**Solution:** Remplacement du composant `<Button>` par un élément `<button>` HTML natif avec les classes de shadcn-vue.

**Avant:**
```vue
<Button
    v-for="link in houses.links"
    :key="link.label"
    :variant="link.active ? 'default' : 'outline'"
    size="sm"
    :disabled="!link.url"
    @click="link.url && router.visit(link.url)"
    v-html="link.label"
/>
```

**Après:**
```vue
<button
    v-for="link in houses.links"
    :key="link.label"
    type="button"
    :class="[
        'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0',
        'h-9 px-3',
        link.active
            ? 'bg-primary text-primary-foreground hover:bg-primary/90'
            : 'border border-input bg-background hover:bg-accent hover:text-accent-foreground',
    ]"
    :disabled="!link.url"
    @click="link.url && router.visit(link.url)"
    v-html="link.label"
/>
```

**Pourquoi c'est mieux:**
- ✅ Pas de conflit avec le rendu interne des composants
- ✅ Garde le même style grâce aux classes de shadcn-vue
- ✅ Conforme aux règles ESLint
- ✅ Le `v-html` est sûr sur un élément natif (permet de rendre les flèches de pagination)

---

## 📚 Documentation Mise à Jour

### AGENTS.md

**Ajouts:**

1. Section "Points importants" dans Structure des Composants:
```markdown
**Points importants:**
- ✅ **TOUJOURS** ajouter `lang="js"` dans la balise `<script setup>`
- ✅ Utiliser **Composition API** uniquement
- ❌ **JAMAIS** d'Options API dans ce projet
```

2. Point #1 dans "Pour les Étudiants":
```markdown
1. **TOUJOURS `lang="js"` dans `<script setup>`** - requis par ESLint
```

3. Point #7 dans "Pour les Étudiants":
```markdown
7. **Pas de `v-html` sur composants** - utilisez des éléments HTML natifs
```

4. Tous les exemples de code Vue ont été mis à jour avec `lang="js"`.

### FRONTEND_HOUSE_TYPE.md

**Ajouts:**
- Tous les exemples `<script setup>` ont été mis à jour avec `lang="js"`

---

## 🎯 Conventions à Respecter

### Pour tous les nouveaux fichiers Vue:

```vue
<script setup lang="js">
// ✅ Toujours ajouter lang="js"
import { ref } from 'vue';
</script>

<template>
    <!-- Votre template -->
</template>
```

### Pour v-html:

```vue
<!-- ❌ NE PAS FAIRE -->
<Button v-html="content" />

<!-- ✅ À LA PLACE -->
<button class="..." v-html="content" />

<!-- ✅ OU MIEUX -->
<Button>
    <span v-html="content" />
</Button>

<!-- ✅ OU ENCORE MIEUX (si pas de HTML) -->
<Button>{{ content }}</Button>
```

---

## 🔍 Vérification

Pour vérifier qu'il n'y a plus d'erreurs ESLint:

```bash
npm run lint
# ou
npx eslint resources/js/pages/Houses/
```

---

## 📝 Notes pour les Étudiants

### Pourquoi `lang="js"` ?

1. **Clarté:** Indique explicitement que le code est du JavaScript
2. **Extensibilité:** Permet de passer à TypeScript plus tard (`lang="ts"`)
3. **Tooling:** Aide les outils (ESLint, IDE) à mieux comprendre le code
4. **Standard:** Recommandé par la communauté Vue 3

### Pourquoi pas de `v-html` sur composants ?

Les composants Vue ont leur propre rendu interne. Le `v-html` peut:
- Écraser le contenu du slot par défaut
- Casser le rendu des composants enfants
- Causer des problèmes de réactivité

**Solution:** Toujours utiliser `v-html` sur des éléments HTML natifs (`<div>`, `<span>`, `<button>`, etc.).

---

**Date:** Novembre 2025
**ESLint Config:** Vue 3 Recommended
