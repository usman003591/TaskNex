<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\TaskCollection;

new class extends Component {
    public TaskCollection $collection;
    public bool $open = false;

    #[On('open-delete-collection-confirmation')]
    public function openModal()
    {
        return $this->open = true;
    }

    public function deleteCollection()
    {
        $this->collection->tasks()->delete();
        $this->collection->delete();

        $this->redirect(route('dashboard'), navigate: true);
    }

    public function closeModal()
    {
        $this->reset('open');
    }
};
?>

<div>
    <x-modal-frame :open="$open" title="Delete collection" descriptionClasses="text-[13px]"
        iconColor="text-danger bg-danger/10" icon="fa-solid fa-trash-can text-xs">
        <x-slot:description>
            Are you sure you want to delete <strong>{{ $collection->name }}</strong>
            @if($collection->tasks()->count() > 0)
            and its <strong>{{ $collection->tasks()->count() }} tasks</strong>
            @endif?
        </x-slot:description>
        <div class="space-y-1 px-5 pb-2 sm:px-6 sm:pb-6">
            <div class="flex justify-end pt-3">
                <button type="button" wire:click="deleteCollection"
                    class="inline-flex min-h-8 items-center gap-2 py-2 px-4 text-surface-sidebar text-xs font-extrabold bg-danger rounded-xl shadow-[0_8px_22px_rgb(255_137_111/0.15)] transition-[background-color,transform,opacity] duration-180 motion-reduce:transition-none hover:bg-danger-hover hover:-translate-y-px cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </x-modal-frame>
</div>
