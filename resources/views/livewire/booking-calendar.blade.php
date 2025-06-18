<div class="max-w-5xl mx-auto px-6 py-8">
    <h2 class="text-3xl font-bold text-center mb-8">
        Book with MR. {{ $hr->user->name }}
    </h2>

    @forelse($slots as $slot)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">{{ $slot->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $slot->interview_type }} interview - {{ $slot->location }}</p>
                </div>
                <span class="text-sm px-3 py-1 rounded-full {{ $slot->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $slot->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            @if($slot->description)
                <div class="text-gray-700 mb-2">
                    <strong>Description:</strong>
                    <p class="mt-1 text-sm text-gray-600">{{ $slot->description }}</p>
                </div>
            @endif

            <div class="text-gray-700 mb-2">
                <strong>Time:</strong> {{ $slot->start_datetime->format('Y-m-d H:i') }} → {{ $slot->end_datetime->format('H:i') }}
            </div>

            <div class="text-gray-700 mb-2">
                <strong>Duration:</strong> {{ $slot->duration_minutes }} minutes
            </div>

            @if($slot->is_recurring)
                <div class="text-gray-700 mb-2">
                    <strong>Recurring:</strong> Yes
                </div>
                <div class="text-gray-700 mb-2">
                    <strong>Pattern:</strong> <pre class="bg-gray-100 p-2 rounded text-xs">{{ json_encode($slot->recurring_pattern, JSON_PRETTY_PRINT) }}</pre>
                </div>
            @else
                <div class="text-gray-700 mb-2">
                    <strong>Recurring:</strong> No
                </div>
            @endif

            @if($errors->has('duplicate'))
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    {{ $errors->first('duplicate') }}
                </div>
            @endif

            <button wire:click="selectSlot({{ $slot->id }})"
                    class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                Book
            </button>

            @if($selectedSlotId === $slot->id)
                <div class="mt-6">
                    <livewire:create-booking-form :slotId="$selectedSlotId" />
                </div>
            @endif
        </div>


    @empty
        <div class="text-center text-gray-500">No available slots at the moment.</div>
    @endforelse
</div>
