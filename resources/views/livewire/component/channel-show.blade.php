<div class="channel-page">
    <!-- Display Channel Info -->
    <div class="channel-header">
        <div class="avatar">
            <img src="{{ $channel->avatar }}" alt="{{ $channel->channel_name }} Avatar" class="rounded-full">
        </div>
        <div class="channel-info">
            <h1 class="channel-name">{{ $channel->channel_name }}</h1>
            <p class="channel-description">{{ $channel->deskripsi }}</p>
            <p class="verified-status">
                @if($channel->verified)
                    <span class="text-green-500">Verified</span>
                @else
                    <span class="text-red-500">Not Verified</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Display Videos -->
    <div class="videos-list flex">
        @foreach ($contentVideos as $video)
            <div class="video-card">
                <div class="video-info">
                    <h3 class="video-title line-clamp-1">{{ $video->judul }}</h3>
                    <p class="video-description">{{ $video->deskripsi }}</p>
                    <p class="video-channel">
                        Channel: {{ $video->channel->channel_name }} - {{ $video->channel->user->name }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
