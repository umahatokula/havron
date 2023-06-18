<?php namespace Ovalsoft\Courses\Updates;

use Seeder;
use Ovalsoft\Courses\Models\Playlist;

class SeedPlaylistsTable extends Seeder
{
    public function run()
    {
        Playlist::create([
            'name'  => 'Go Pro Academy Weekly Training Replays',
            'slug'  => 'go-pro-academy-weekly-training-replays',
            'description'  => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);

        Playlist::create([
            'name'  => 'Launching your Network Marketing Business',
            'slug'  => 'launching-your-network-marketing-business',
            'description'  => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);
    }
}