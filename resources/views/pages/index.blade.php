<?php

use App\Livewire\Actions\Logout;
use Flux\Flux;
use Livewire\Volt\Component;
use Livewire\WithPagination;

use function Laravel\Folio\name;

name('dashboard');

new class extends Component
{
    use WithPagination;

    public string $convertedText = '';

    public string $inputText = '';

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function saveText()
    {
        auth()->user()->snippets()->create([
            'content' => $this->pull('convertedText'),
        ]);

        $this->inputText = '';

        Flux::toast('🦍 I SAVE STRONK SNIPPET 🦍', variant: 'success');
    }

    public function with()
    {
        return [
            'snippets' => auth()->check()
                ? auth()->user()->snippets()->latest()->paginate(5)
                : collect(),
        ];
    }
};
?>


<x-layouts.main>
    @volt("pages.dashboard")
        <div class="flex items-center justify-center min-h-screen p-8 text-white bg-black">
            <div class="w-full max-w-2xl">
                <!-- Header -->
                <h1 class="mb-4 text-4xl font-bold text-center">APE TOGETHER STRONK</h1>

                <!-- Emoji Icons -->
                <div
                    x-data="{
                        inputText: $wire.entangle('inputText'),
                        convertedText: $wire.entangle('convertedText'),
                        updateText() {
                            this.convertedText = '🦍 ' + this.inputText.toUpperCase() + ' 🦍'
                        },
                        insertEmoji(emoji) {
                            this.inputText += emoji
                            this.updateText()
                        },
                    }"
                >
                    <div class="flex justify-center gap-4 mb-8">
                        <button
                            @click="insertEmoji('🚬')"
                            class="p-3 transition-colors bg-gray-800 rounded-md hover:bg-gray-700"
                        >
                            🚬
                        </button>
                        <button
                            @click="insertEmoji('🍌')"
                            class="p-3 transition-colors bg-gray-800 rounded-md hover:bg-gray-700"
                        >
                            🍌
                        </button>
                        <button
                            @click="insertEmoji('❄️')"
                            class="p-3 transition-colors bg-gray-800 rounded-md hover:bg-gray-700"
                        >
                            ❄️
                        </button>
                    </div>

                    <!-- Input Area -->
                    <flux:textarea
                        x-model="inputText"
                        @input="updateText"
                        placeholder="MAKE YOUR APE STRONG"
                        clearable
                    />

                    <!-- Output Area -->
                    <flux:input.group class="mt-2">
                        <flux:input wire:model="savedText" x-model="convertedText" readonly copyable />
                        @auth
                            <flux:button wire:click="saveText" icon="bookmark">Save</flux:button>
                        @endauth
                    </flux:input.group>
                </div>
                <div class="flex items-center justify-center w-full mt-4">
                    @auth
                        🦍 WELCOME {{ strtoupper(auth()->user()->name) }} 🦍
                        <flux:button wire:click="logout" class="ml-2 text-center" size="xs">LOG OUT</flux:button>
                    @else
                        <flux:button wire:navigate href="/auth/login" class="text-center">
                            🦍 LOG IN TO SAVE YOUR STRONK APE MEMES 🦍
                        </flux:button>
                    @endauth
                </div>
                @auth
                    <div class="mt-8 space-y-4">
                        <flux:heading>STRONK SNIPPETS</flux:heading>

                        @forelse ($snippets as $snippet)
                            <div class="group/input">
                                <flux:input
                                    value="{{ $snippet->content }}"
                                    readonly
                                    copyable
                                    class="w-full text-center"
                                />
                            </div>
                        @empty
                            <p class="py-4 text-center text-gray-400">🦍 NO STRONK SAVES TO SHARE 🦍</p>
                        @endforelse

                        <div class="mt-6">
                            {{ $snippets->links() }}
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    @endvolt
</x-layouts.main>
