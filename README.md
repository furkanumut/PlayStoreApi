PlayStoreApi
====================
Gayri Resmi play store api, isteyen istediği gibi kullanabilir, geliştirebilir ve ya bir sıkıntı yaşadığınızda bana ulaşabilirsiniz.

Unofficial play store api, you can use it as you wish, you can develop and you can reach me if you face any problem.

Kullanımı/Use Of
====================
```php
<?php 

//zorunlu alan | required field
require_once "ps_bot.php";
$playstore=new PlayStoreApi;

//Ücretsiz populer uygulamalar | Free populer apps
print_r($playstore->free_app());

//Ücretsiz güncel uygulamalar | New updated apps
print_r($playstore->newfree_app());

//Ücretsiz populer oyunlar | Free populer games
print_r($playstore->free_game());

//Ücretsiz en çok ziyaret edilen uygulamalar | Free most visited apps
print_r($playstore->gross());

//Trend uygulamalar | Trend applications
print_r($playstore->trend());

//Kategorileri listeleme | Category List
print_r($playstore->listcategory());

//Bir kategorideki en populer uygulamalar | Most popular applications in category
print_r($playstore->category("FAMILY_ACTION"));

//Arama Yapmak İçin | For Search
print_r($playstore->search("Pubg Mobile"));

//Uygulama detaylarını çekme | Application details
print_r($playstore->detail("com.termux"));
