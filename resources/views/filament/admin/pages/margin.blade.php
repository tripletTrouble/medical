<x-filament-panels::page>
    <form wire:submit="saveMargins">
        {{ $this->form }}
        <div class="mt-6">
            <x-filament::button type="submit">
                Simpan
            </x-filament::button>
        </div>
    </form>

    @livewire('notifications')
</x-filament-panels::page>
