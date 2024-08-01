# TODO:this shell allows access to standard php utils
{ pkgs ? import <nixpkgs> { config.allowUnfree = true; }, }:
with pkgs;
mkShell rec {
  nativeBuildInputs = [ pkg-config ];
  buildInputs = [
    php
    phpactor
    php83Packages.composer
    nodePackages.intelephense
    php83Packages.php-cs-fixer
    php83Packages.php-codesniffer
  ];
}
