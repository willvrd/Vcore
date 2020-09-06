# VGreen Application - Vcore Module

## Installation
```bash
composer require willvrd/vcore-module
```

## Steps

    1. Set up laravel localization (Config Files, Register Middleware)
https://github.com/mcamara/laravel-localization#installation

    2. On config/laravellocalization.php, change true 'hideDefaultLocaleInURL' => true

    3. Publish config/translatable.php: 
```bash  
php artisan vendor:publish --tag=translatable
``` 
	4. Run NPM to compile your fresh scaffolding
```bash
npm install && npm run dev
```
       
## Extras

### Debug Bar
```bash
composer require barryvdh/laravel-debugbar --dev
```	
	 
## Assets Module

    - Install and Setup:
https://nwidart.com/laravel-modules/v6/basic-usage/compiling-assets


## Frontend Components

### Loading

    - Add in your component:

```html
<section v-if="loading"><loading></loading></section>
```

### Alert

    - Add in your component:

```html
<alert :alert="{status:true,type:'alert-danger',text: 'Error sorry',dismissible:true}"></alert>
```
