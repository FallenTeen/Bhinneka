<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Channel;
use App\Models\ContentVideo;
use Illuminate\Support\Str;

class ChannelVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat beberapa channel
        $channels = [
            ['channel_name' => 'Channel 3', 'user_id' => 3],
            ['channel_name' => 'Channel 4', 'user_id' => 4],
            ['channel_name' => 'Channel 5', 'user_id' => 5],
            ['channel_name' => 'Channel 6', 'user_id' => 6],
        ];

        foreach ($channels as $channelData) {
            $channelData['slug'] = Str::slug($channelData['channel_name']);

            $channel = Channel::create($channelData);
            for ($i = 1; $i <= 3; $i++) {
                $judul = "Video $i dari {$channel->channel_name}";
                $slug = Str::slug($judul);

                ContentVideo::create([
                    'channel_id' => $channel->id,
                    'judul' => $judul,
                    'slug' => $slug,
                    'deskripsi' => "Deskripsi video ke-$i dari {$channel->channel_name}.",
                    'url' => 'https://drive.google.com/file/d/1JRep0NAiqjbj1T2--KwEB5-waO_yLJZN/preview',
                    'thumbnail' => 'https://via.placeholder.com/300',
                    'is_exclusive' => $i % 2 == 0,
                ]);
            }
        }
    }
}
