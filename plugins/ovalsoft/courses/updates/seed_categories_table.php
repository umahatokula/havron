<?php namespace Ovalsoft\Courses\Updates;

use Seeder;
use Ovalsoft\Courses\Models\Category;

class SeedCategoriesTable extends Seeder
{
    public function run()
    {
        Category::create([
            'name'  => 'Beginers',
            'slug'  => 'beginners',
            'description'  => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);

        Category::create([
            'name'  => 'Intermediate',
            'slug'  => 'intermediate',
            'description'  => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);

        Category::create([
            'name'  => 'Advanced',
            'slug'  => 'advanced',
            'description'  => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);
    }
}