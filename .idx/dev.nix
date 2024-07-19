{pkgs}: {
  channel = "stable-23.11";
  packages = [
    pkgs.php82
    pkgs.php82Packages.composer
    pkgs.nodejs_20
  ];
  services.mysql = {
    enable = true;
    package = pkgs.mariadb;
  };
  idx.extensions = ["cweijan.dbclient-jdbc" "cweijan.vscode-mysql-client2" "MehediDracula.php-namespace-resolver" "amiralizadeh9480.laravel-extra-intellisense" "esbenp.prettier-vscode" "formulahendry.auto-close-tag" "formulahendry.auto-rename-tag" "mohamedbenhida.laravel-intellisense" "onecentlin.laravel5-snippets" "shufo.vscode-blade-formatter" "sleistner.vscode-fileutils" "onecentlin.laravel-blade"];
  idx.previews = {
    enable = true;
    previews = {
      web = {
          command = ["php" "artisan" "serve" "--port" "$PORT" "--host" "0.0.0.0"];
          manager = "web";
      };
    };
  };
}