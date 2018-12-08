PlayStoreApi
====================
Gayri Resmi play store api, isteyen istediği gibi kullanabilir, geliştirebilir ve ya bir sıkıntı yaşadığınızda bana ulaşabilirsiniz.

Unofficial play store api, you can use it as you wish, you can develop and you can reach me when you experience a hardship.

Kullanımı/Use Of
====================
```php
<?php 

//zorunlu alan
require_once "ps_bot.php";
$playstore=new PlayStoreApi;

//Ücretsiz populer uygulamalar
print_r($playstore->free_app());

//Ücretsiz güncel uygulamalar
print_r($playstore->newfree_app());

//Ücretsiz populer oyunlar
print_r($playstore->free_game());

//Ücretsiz en çok ziyaret edilen uygulamalar
print_r($playstore->gross());

//Trend uygulamalar
print_r($playstore->trend());

//Kategorileri Şisteleme
print_r($playstore->listcategory());

//Bir kategorideki en populer uygulamalar
print_r($playstore->category("FAMILY_ACTION"));

//Arama Yapmak İçin
print_r($playstore->search("Pubg Mobile"));

//Uygulama detaylarını çekme
print_r($playstore->detail("com.termux"));
