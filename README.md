# PLUM - Plateforme de Regroupement d'Investissement
## Installation et Configuration

1. **Cloner le dépôt et installer les dépendances :**

   ```bash
   git clone https://github.com/math-pixel/PLUM.git
   cd PLUM
   composer install
   ```
## Configuration
### .env
Les assets dotés d’un symbole (AAPL, TSLA, etc.) peuvent être mis à jour automatiquement via une API.
Ajouter la clé API Alphavantage dans le fichier .env :
ALPHAVANTAGE_API_KEY=your_api_key_here

### Database
1. Créer la base de données et exécuter les migrations :
    ```bash
     php bin/console doctrine:database:create
     php bin/console doctrine:migrations:migrate
   ```
2. Charger les fixtures pour peupler la base de données
    ```bash
     php bin/console doctrine:fixtures:load
   ```

Mettre à jour les prix des assets (via AlphaVantage)

   ```bash
   php bin/console app:update-asset-prices
   ```