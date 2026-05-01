# 🏛️ EventRoom — Système de Réservation de Salles

**EventRoom** est une application web moderne développée avec **Symfony 7** permettant la gestion et la réservation de salles. Elle offre une interface élégante et intuitive pour les utilisateurs et un panneau d'administration complet.

---

## ✨ Fonctionnalités

- **👥 Gestion des Utilisateurs** : Inscription, connexion et profils sécurisés.
- **🏢 Catalogue de Salles** : Visualisation détaillée des salles disponibles avec images et descriptions.
- **📅 Réservations en temps réel** : Système de réservation fluide avec validation des dates.
- **🛠️ Panel Administration** : Gestion complète des salles, des utilisateurs et des réservations par les administrateurs.
- **📱 Design Responsive** : Interface optimisée pour mobiles et tablettes (Bootstrap 5.3 + Inter Font).

---

## 🚀 Installation & Configuration

### Prérequis
- **PHP 8.2+**
- **Composer**
- **MySQL / MariaDB** (via XAMPP, WAMP ou Docker)

### 🛠️ Étapes d'installation

1. **Cloner le projet**
   ```bash
   git clone <URL_DU_REPO>
   cd eventroom-symfony
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer la base de données**
   - Créez un fichier `.env.local` et adaptez la ligne `DATABASE_URL` :
   ```env
   DATABASE_URL="mysql://root:@127.0.0.1:3306/eventroom?serverVersion=10.4.32-MariaDB&charset=utf8mb4"
   ```

4. **Initialiser la base de données**
   - Créez la base de données via phpMyAdmin (nom : `eventroom`).
   - Importez le fichier `database_eventroom.sql` ou lancez les migrations :
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **Lancer le serveur**
   ```bash
   symfony serve
   ```
   *Ou via Apache (XAMPP).*

---

## 🔑 Accès Test Admin

- **Email** : `admin@example.com`
- **Mot de passe** : `admin123`

---

## 🛠️ Stack Technique

- **Backend** : Symfony 7, Doctrine ORM
- **Frontend** : Twig, Bootstrap 5.3, AssetMapper
- **Base de données** : MySQL

---

## 📄 Licence
Ce projet est sous licence MIT.
