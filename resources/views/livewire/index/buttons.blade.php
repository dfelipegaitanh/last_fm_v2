<div class="mb-4 flex w-full max-w-md flex-col justify-start gap-4">
    <x-lastfm.sidebar-svg-button text="Get User Info" route="last-fm.get-user" color="indigo">
        <x-icons.user />
    </x-lastfm.sidebar-svg-button>

    <div class="w-full border-t border-gray-300"></div>

    <x-lastfm.sidebar-svg-button text="Fetch Songs" route="last-fm.get-songs" color="blue">
        <x-icons.music_note />
    </x-lastfm.sidebar-svg-button>
</div>
