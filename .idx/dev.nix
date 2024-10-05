# To learn more about how to use Nix to configure your environment
# see: https://developers.google.com/idx/guides/customize-idx-env
{ pkgs, ... }: {
  # Choix du canal de nixpkgs
  channel = "stable-24.05"; # ou "unstable"
  
  # Use https://search.nixos.org/packages to find packages
  # Liste des packages à installer
  packages = [
    pkgs.php83         # Utilisation de PHP 8.3
    pkgs.php83Packages.composer # Composer pour la gestion des dépendances PHP
    pkgs.nginx         # Nginx pour servir l'application
    pkgs.nodejs_22     # Node.js si nécessaire pour la gestion des assets
    pkgs.docker        # Docker pour Mercure, MySQL, etc.
  ];
  
  services.docker = {
    enable = true;  # Active le service Docker
  };

  # Variables d'environnement
  env = {
    # Par exemple, tu peux définir des variables d'environnement pour Symfony ici
    APP_ENV = "dev";
  }; 

  idx = {
    # Search for the extensions you want on https://open-vsx.org/ and use "publisher.id"
    # Extensions Visual Studio Code pour faciliter le dev
    extensions = [
      "rangav.vscode-thunder-client"
    ];

    workspace = {
      # Fichiers à ouvrir par défaut
      onCreate = {
        default.openFiles = ["src/Controller/HomeController.php"];
      };

      # Commandes à exécuter au démarrage de l'environnement
      onStart = {
        # Lancer le serveur de développement Symfony via PHP ou Docker Compose
        run-server = "docker compose up -d";
      };
    };
  };
}