#!/bin/bash -x

#echo "--DEBUG--"
#echo "TRAVIS_REPO_SLUG: $TRAVIS_REPO_SLUG"
#echo "TRAVIS_PHP_VERSION: $TRAVIS_PHP_VERSION"
#echo "TRAVIS_PULL_REQUEST: $TRAVIS_PULL_REQUEST"

if [ "$TRAVIS_PULL_REQUEST" == "false" ] && [ "$TRAVIS_PHP_VERSION" == "5.3" ]; then

  echo -e "Publishing PHPDoc...\n"
  ## Copie de la documentation generee dans le $HOME
  cp -R build/docs $HOME/docs-latest

  cd $HOME
  ## Initialisation et recuperation de la branche gh-pages du depot Git
  git config --global user.email "lq@dev-int.net"
  git config --global user.name "Dev-Int"
  git clone --quiet --branch=gh-pages https://${GH_TOKEN}@github.com/GLSR/glsr gh-pages
  
  cd gh-pages
  
  ## Suppression de l'ancienne version
  git rm -rf ./docs/$TRAVIS_BRANCH

  ## Création des dossiers
  mkdir docs
  cd docs
  mkdir $TRAVIS_BRANCH

  ## Copie de la nouvelle version
  cp -Rf $HOME/docs-latest/* ./$TRAVIS_BRANCH/

  ## On ajoute tout
  git add -f .
  ## On commit
  git commit -m "PHPDocumentor \(Travis Build : $TRAVIS_BUILD_NUMBER  - Branch : $TRAVIS_BRANCH\)"
  ## On push
  git push -fq origin gh-pages
  ## Et c est en ligne !
  echo -e "Published PHPDoc to gh-pages.\n"

fi
