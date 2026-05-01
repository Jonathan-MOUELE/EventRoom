# EventRoom

<p align="center">
  <img src="https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=symfony&logoColor=white" alt="Symfony" />
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap" />
</p>

## Description
EventRoom est une solution de gestion de réservation de salles développée avec le framework Symfony. L'application permet une gestion fluide des utilisateurs, des espaces et des réservations via une interface moderne et sécurisée.

## Fonctionnalités principales
*   **Authentification sécurisée** : Système d'inscription et de connexion pour les utilisateurs et administrateurs.
*   **Gestion des salles** : Catalogue complet avec détails, capacités et disponibilités.
*   **Moteur de réservation** : Réservation de créneaux avec vérification de disponibilité.
*   **Dashboard Admin** : Interface dédiée à la gestion du contenu et des utilisateurs.

## Installation

### Prérequis
*   PHP 8.2 ou supérieur
*   Composer
*   MySQL / MariaDB

### Procédure
1.  **Clonage du projet**
    ```bash
    git clone https://github.com/Jonathan-MOUELE/EventRoom.git
    cd EventRoom
    ```

2.  **Installation des dépendances**
    ```bash
    composer install
    ```

3.  **Configuration environnementale**
    Créez un fichier `.env.local` et renseignez votre accès à la base de données :
    ```env
    DATABASE_URL="mysql://root:@127.0.0.1:3306/eventroom?serverVersion=10.4.32-MariaDB&charset=utf8mb4"
    ```

4.  **Base de données**
    Créez la base `eventroom` et importez le schéma :
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

## Stack Technique
*   **Framework** : Symfony 7
*   **ORM** : Doctrine
*   **Moteur de template** : Twig
*   **Frontend** : Bootstrap 5.3

---
*Projet réalisé dans le cadre d'un développement d'application web.*
