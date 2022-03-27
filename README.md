### 1 new laravel 9
### 2 create Module Article
#### 2.1
    php artisan make:model Article -mc
    php artisan make:factory ArticleFactory
    php artisan make:seeder ArticleSeeder
    php artisan make:seeder UserSeeder
    php artisan migrate --seed

#### 2.2 add Route resource

#### 2.3 
    php artisan make:request StoreArticleRequest
    php artisan make:request UpdateArticleRequest

#### 2.4 build Controller resource

### 3 replace StoreArticleRequest & UpdateArticleRequest with ArticleRequest

### 4 add data to JsonResponse in ArticleController

### 5 Generating Resources and Conditional Relationships
    php artisan make:resource ArticleResource
    php artisan make:resource ArticleCollection
    php artisan make:resource UserResource
