<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;

class BlogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        PostCategory::factory(6)->create();
        Post::factory(50)->create();
    }
}
