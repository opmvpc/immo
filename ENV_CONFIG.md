# ⚙️ Configuration Environnement

## Variables à ajouter dans votre fichier `.env`

```env
# Locale pour Faker (génération de données belges)
APP_FAKER_LOCALE=be_FR

# Clé API OpenRouter pour la génération d'images
OPENROUTER_API_KEY=votre_clé_api_ici
```

## 🔑 Obtenir une clé API OpenRouter

1. Créer un compte sur [OpenRouter.ai](https://openrouter.ai/)
2. Aller dans **Settings** > **API Keys**
3. Créer une nouvelle clé API
4. Copier la clé et l'ajouter dans `.env`

## 💰 Coût Estimé

Le modèle `openai/gpt-5-image-mini` génère des images de haute qualité:
- **~8 maisons** avec **4 images chacune** = **32 images**
- Coût approximatif: **$0.50 - $1.00** selon les dimensions
- Budget recommandé: **$2-3** pour être tranquille

## 🚀 Utilisation

Une fois configuré:

```bash
# 1. Lancer les seeders (crée les maisons avec prompts)
php artisan db:seed

# 2. Générer les images via IA
php artisan houses:generate-images

# 3. Générer une seule maison
php artisan houses:generate-images --house=5

# 4. Forcer la régénération même si images existent
php artisan houses:generate-images --force
```

## ⏱️ Durée de Génération

- **1 image** ≈ 5-10 secondes
- **32 images** ≈ 3-5 minutes
- Pause automatique de 1s entre chaque image pour éviter le rate limiting

## 🎨 Qualité des Images

Les prompts sont optimisés pour:
- ✅ Photos professionnelles d'immobilier
- ✅ Architecture belge authentique
- ✅ Intérieurs modernes et réalistes
- ✅ Éclairage naturel
- ✅ Haute résolution

## 🐛 Dépannage

**Erreur "OPENROUTER_API_KEY non configurée"**
- Vérifiez que vous avez bien ajouté la variable dans `.env`
- Relancez `php artisan config:clear`

**Erreur API 401 Unauthorized**
- Votre clé API est invalide ou expirée
- Vérifiez sur OpenRouter.ai que votre clé est active

**Erreur API 429 Rate Limit**
- Trop de requêtes, attendez quelques minutes
- La commande gère automatiquement les pauses

**Images non affichées**
- Vérifiez que `storage/app/public/houses/` contient les images
- Lancez `php artisan storage:link`
