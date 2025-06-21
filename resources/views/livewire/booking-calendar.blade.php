<div>
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

                <div class="text-gray-700 mb-2">
                    <strong>Recurring:</strong> {{ $slot->is_recurring ? 'Yes' : 'No' }}
                </div>

                @if($slot->is_recurring)
                    <div class="text-gray-700 mb-2">
                        <strong>Pattern:</strong>
                        <pre class="bg-gray-100 p-2 rounded text-xs">{{ json_encode($slot->recurring_pattern, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                @endif

                @if($errors->has('duplicate'))
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                        {{ $errors->first('duplicate') }}
                    </div>
                @endif

                <!-- Book button to open modal -->
                <button type="button"
                        class="btn btn-primary mt-3"
                        data-bs-toggle="modal"
                        data-bs-target="#bookingModal"
                        wire:click="selectSlot({{ $slot->id }})">
                    Book
                </button>
            </div>
        @empty
            <div class="text-center text-gray-500">No available slots at the moment.</div>
        @endforelse
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selectedSlotId)
                        <livewire:create-booking-form :slotId="$selectedSlotId" />
                    @else
                        <p class="text-center text-muted">Please select a slot first.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
