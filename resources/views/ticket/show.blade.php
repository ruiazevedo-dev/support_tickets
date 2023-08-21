<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-white text-lg font-bold">{{ $ticket->title }}</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-white flex justify-between py-4">
                <p>{{ $ticket->description }}</p>
                <p>{{ $ticket->created_at->diffForHumans() }}</p>
                @if($ticket->attachment)
                    <a href="{{ "/storage/". $ticket->attachment }}" target="_blank">Attachment</a>
                @endif
            </div>
            <div class="flex">
                <a href="{{ route('ticket.edit',$ticket->id) }}">
                    <x-primary-button>Edit Ticket</x-primary-button>
                </a>
                <form action="{{ route('ticket.destroy',$ticket->id) }}" method="POST" class="ml-2">
                    @method('delete')
                    @csrf
                    <x-primary-button class="bg-red-500">Delete</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>