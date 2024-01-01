<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public function delete($noteId){
        $note = Note::where('id',$noteId)->first();
        $this->authorize('delete',$note); //Check if the note is authorized to delete -using policies --------------------------------
        $note->delete();
    }
    public function with(): array
    {
        return [
            'notes' => Auth::user()
            ->notes()
            ->orderBy('send_date')
            ->get()            
        ];
    }
}; ?>
<div>
    <div class="space-y-2">
        @if ($notes->isEmpty())
            <div class="text-center">
                <p class="text-xl font-bold">No notes available</p>
                <p class="text-sm">Click the button below to add your first note</p>
                <x-button class="mt-6" primary icon-right="plus" href="{{ route('notes.create')}}" wire:navigate>Create Note</x-button>       
            </div>
            
        @else
            <x-button class="mb-12" primary icon-right="plus" href="{{ route('notes.create')}}" wire:navigate>Create Note</x-button>       
            <div class="grid grid-cols-3 gap-4">
                @foreach ($notes as $note)
                    <x-card wire:key='{{ $note->id }}' >
                        <div class="flex justify-between">
                            <div>
                                <a href="{{route('notes.edit',$note) }}" wire:navigate class="text-xl font-bold hover:underline hover:text-blue-500">{{$note->title}}</a>
                            <p class="text-xs mt-2">{{Str::limit($note->body, 50)}}</p>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ Carbon\Carbon::parse($note->send_date)->format('M-d-Y')
                            }}
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4 space-x-1">
                            <p class='text-xs'>Recipient: <span class="font-semibold"> {{$note->recipient}} </span></p>
                        </div>
                        <div>
                            <x-button.circle icon="eye"></x-button.circle>
                            <x-button.circle icon="trash" wire:click="delete('{{$note->id}}')"></x-button.circle>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>  
</div>
