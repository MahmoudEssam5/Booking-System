<div>
    @if($success)
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            Booking submitted successfully! We'll contact you soon.
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-4">

            <div>
                <label for="candidate_name" class="block font-medium">Full Name</label>
                <input wire:model="candidate_name" id="candidate_name" type="text" class="mt-1 w-full border-gray-300 rounded" required>
                @error('candidate_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="candidate_email" class="block font-medium">Email</label>
                <input wire:model="candidate_email" id="candidate_email" type="email" class="mt-1 w-full border-gray-300 rounded" required>
                @error('candidate_email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="candidate_phone" class="block font-medium">Phone</label>
                <input wire:model="candidate_phone" id="candidate_phone" type="text" class="mt-1 w-full border-gray-300 rounded" required>
                @error('candidate_phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="position_applied" class="block font-medium">Position</label>
                <input wire:model="position_applied" id="position_applied" type="text" class="mt-1 w-full border-gray-300 rounded" required>
                @error('position_applied') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="candidate_notes" class="block font-medium">Notes</label>
                <textarea wire:model="candidate_notes" id="candidate_notes" class="mt-1 w-full border-gray-300 rounded"></textarea>
                @error('candidate_notes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded">
                Confirm Booking
            </button>
        </form>
    @endif
    @if($errors->has('duplicate'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            {{ $errors->first('duplicate') }}
        </div>
    @endif
</div>
