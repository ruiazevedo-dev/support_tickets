<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('User Avatar') }}
        </h2>
        
        @if($user->avatar == null) 
            <p>no avatar</p>
        @else
            <img width="50" height="50" class="rounded-full" src="{{ "/storage/$user->avatar" }}" alt="user avatar">

        @endif

        <form action="{{ route('profile.avatar.ai') }}" method="POST" class="mt-4">
            @csrf
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Generate avatar from ai
            </p>
            <x-primary-button>Generate avatar</x-primary-button>
        </form>

        
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
        Or
    </p>


    @if (session('message'))
        <div class="text-red-500">
            {{ session('message') }}
        </div>
        
    @endif

    <form class="mt-2" method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="avatar" value="Upload Avatar from computer" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)" autocomplete="avatar" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

</section>
