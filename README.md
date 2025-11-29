# Theme WordPress : `_underscores-vite-tailwind-twig`

Un thème WordPress basé sur **_Underscores (_s)** avec **Vite.js**, **TailwindCSS** et **Twig (Timber)**.  

- **Hot Module Reloading** via Vite pour JS et CSS  
- **TailwindCSS** intégré avec purge automatique pour PHP et Twig  
- **Twig (Timber)** pour les templates WordPress modernes  
- Structure prête pour le développement moderne WordPress

---

## 🗂️ Structure du thème
```bash
theme/
│── functions.php
│── style.css
│── vite.config.js
│── tailwind.config.js
│── dist/                # Build Vite (JS + CSS)
│── sources/
│     ├── scripts/
│     │      └── main.js
│     └── styles/
│            └── main.css
│── templates/           # Twig templates
│     ├── base.twig
│     ├── index.twig
│     └── parts/
│           ├── header.twig
│           └── footer.twig
│── package.json
│── package-lock.json
```

---

## ⚡ Prérequis

- Node.js >= 18
- npm ou pnpm
- WordPress 6+
- Timber plugin activé (pour Twig)

---

## 🛠️ Installation

1. Clone le repo dans le dossier `wp-content/themes/` :

```bash
git clone <repo-url> theme-name
```
2.	Installe les dépendances Node :
```bash
cd wp-content/themes/theme-name
npm install
```
3.	Installe le plugin Timber pour Twig si ce n’est pas déjà fait :
```bash
wp plugin install timber-library --activate
```

## 🚀 Développement avec HMR
1.	Lancer le serveur Vite :
```bash
npm run dev
```

2.	Accédez à votre site WordPress.
Le JS et le CSS seront automatiquement chargés via Vite avec Hot Module Reloading.

3.	Le thème est configuré pour détecter si le serveur Vite tourne et charger les fichiers HMR automatiquement.

## 🧹 Build pour production
```bash
npm run build
```
•	Le CSS et JS sont compilés dans dist/

•	Les fichiers sont minifiés et optimisés

•	Le manifest Vite est utilisé pour charger les bons fichiers en production