<?php namespace Ovalsoft\Courses\Updates;

use Seeder;
use Ovalsoft\Courses\Models\Video;

class SeedVideosTable extends Seeder
{
    public function run()
    {

        Video::create([
            'title'            => 'Own Your Life',
            'slug'             => 'own-your-life',
            'source'           => 'youtube',
            'youtube_video_id' => 'https://www.youtube.com/watch?v=rgec8JWTpOo&feature=youtu.be',
            'order'            => '40',
            'is_published'     => true,
            'description'      => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);

        Video::create([
            'title'            => 'Do You Like Your Life?',
            'slug'             => 'do-you-like-your-life',
            'source'           => 'youtube',
            'youtube_video_id' => 'https://www.youtube.com/watch?v=wWJzIFYtaw4',
            'order'            => '40',
            'is_published'     => true,
            'description'      => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);

        Video::create([
            'title'            => 'Telling Your Story',
            'slug'             => 't0elling-your-story',
            'source'           => 'youtube',
            'youtube_video_id' => 'https://www.youtube.com/watch?v=vnj2i6RNo3g',
            'order'            => '40',
            'is_published'     => true,
            'description'  => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);

        Video::create([
            'title'            => 'Time and Task',
            'slug'             => 'time-and-task',
            'source'           => 'youtube',
            'youtube_video_id' => 'https://www.youtube.com/watch?v=vnj2i6RNo3g',
            'order'            => '40',
            'is_published'     => true,
            'description'      => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);

        Video::create([
            'title'            => 'Rise of the Entrepreneur',
            'slug'             => 'rise-of-the-entrepreneur',
            'source'           => 'youtube',
            'youtube_video_id' => 'https://www.youtube.com/watch?v=vnj2i6RNo3g',
            'order'            => '40',
            'is_published'     => true,
            'description'      => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);

        Video::create([
            'title'            => 'You Made the Right Choice',
            'slug'             => 'you-made-the-right-choice',
            'source'           => 'youtube',
            'youtube_video_id' => 'https://www.youtube.com/watch?v=vnj2i6RNo3g',
            'order'            => '40',
            'is_published'     => true,
            'description'      => '
            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.',
        ]);
    }
}