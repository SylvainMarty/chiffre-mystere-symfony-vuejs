How to setup
==========

## Backend

### Requirements

* PHP 7.1 (with libs `curl`, `intl`, `xml`)
* Symfony 3.4

### Setup

```sh
cd ./api
composer install
```

### Run

Le port **8000** de votre machine doit être disponible.

```sh
cd ./api
php bin/console server:run
```

## Frontend

### Requirements

* NodeJS v8

### Setup

#### Avec Yarn
```sh
cd ./front
yarn install
```

#### Avec NPM
```sh
cd ./front
npm install
```

### Run

Le port **8080** de votre machine doit être disponible.

#### Avec Yarn
```sh
cd ./front
yarn dev
```

#### Avec NPM
```sh
cd ./front
npm run dev
```