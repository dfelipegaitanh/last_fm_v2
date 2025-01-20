<div class="flex flex-col gap-4 justify-start mb-4 w-full max-w-md">

    <x-lastfm.sidebar-svg-button
            text="Get User Info"
            route="last-fm.get-user"
            color="indigo">
        <x-icons.user/>
    </x-lastfm.sidebar-svg-button>

    <div class="w-full border-t border-gray-300"></div>

    <x-lastfm.sidebar-svg-button
            text="Fetch Songs"
            route="last-fm.get-songs"
            color="blue">
        <x-icons.music_note/>
    </x-lastfm.sidebar-svg-button>

</div>
