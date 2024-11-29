<?php

namespace App\Livewire\LastFm;

use App\Models\User;
use Livewire\Component;

class GetUser extends Component
{


    public User $user;
    public $lastfmUser;
    public string $buttonClasses;
    public string $buttonColombiaClass;

    public function mount()
    {

        $this->user = auth()->user();
        $this->lastfmUser = $this->user->lastfmUser;

        $this->buttonColombiaClass = 'px-5 py-3 bg-yellow-500 text-white font-semibold rounded-lg shadow-lg hover:bg-gradient-to-r hover:from-yellow-500 hover:via-blue-500 hover:to-red-500 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-70 transition duration-500 ease-in-out';
        $this->buttonClasses = 'px-5 py-3 bg-gray-500 text-white font-medium rounded-md shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-opacity-50 transition duration-300';

    }

    public function render()
    {

        return view('livewire.last-fm.get-user');
    }

    public function getUser(): void
    {
        dump($this->user);
    }
}
