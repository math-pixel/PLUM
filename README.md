# PLUM - Plateforme de Regroupement d'Investissement
## Installation et Configuration

1. **Cloner le dépôt et installer les dépendances :**

   ```bash
   git clone https://github.com/math-pixel/PLUM.git
   cd PLUM
   composer install
   ```

2. Créer la base de données et exécuter les migrations :
    ```bash
     php bin/console doctrine:database:create
     php bin/console doctrine:migrations:migrate
   ```
3. Charger les fixtures pour peupler la base de données
    ```bash
     php bin/console doctrine:fixtures:load
   ```