<x-app-layout>
    <x-slot name="title">Hostel List</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hostel List</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $hostels->count() }} hostels</p>
        </div>
        <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Hostel
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($hostels as $hostel)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $hostel->name }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        <span class="capitalize">{{ $hostel->type }}</span>
                        @if($hostel->campus) · {{ $hostel->campus->name }}@endif
                    </p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $hostel->is_active ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                    {{ $hostel->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-3">
                <div class="bg-gray-50 rounded-lg p-2 text-center">
                    <div class="text-lg font-bold text-gray-900">{{ $hostel->rooms_count }}</div>
                    <div class="text-xs text-gray-500">Rooms</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-2 text-center">
                    <div class="text-lg font-bold text-gray-900">{{ $hostel->warden?->first_name ?? '—' }}</div>
                    <div class="text-xs text-gray-500">Warden</div>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick='openEditHostel({{ json_encode($hostel) }})'
                        class="flex-1 px-3 py-1.5 border border-gray-300 rounded-lg text-xs text-gray-600 hover:bg-gray-50">Edit</button>
                <form method="POST" action="{{ route('hostels.destroy', $hostel) }}" onsubmit="return confirm('Delete hostel?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 border border-red-200 text-red-500 rounded-lg text-xs hover:bg-red-50">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">
            No hostels yet. Add your first hostel.
        </div>
        @endforelse
    </div>

    {{-- Add Modal --}}
    <div id="add-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Add Hostel</h3>
            <form method="POST" action="{{ route('hostels.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                        <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="mixed">Mixed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Campus</label>
                        <select name="campus_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">None</option>
                            @foreach($campuses as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Warden</label>
                    <select name="warden_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">None</option>
                        @foreach($wardens as $w)
                            <option value="{{ $w->id }}">{{ $w->first_name }} {{ $w->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Add Hostel</button>
                    <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Edit Hostel</h3>
            <form method="POST" id="edit-form" class="space-y-3">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" id="edit-name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                        <select name="type" id="edit-type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="mixed">Mixed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Campus</label>
                        <select name="campus_id" id="edit-campus" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">None</option>
                            @foreach($campuses as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Update</button>
                    <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditHostel(h) {
            document.getElementById('edit-form').action = '/hostels/' + h.id;
            document.getElementById('edit-name').value = h.name;
            document.getElementById('edit-type').value = h.type;
            document.getElementById('edit-campus').value = h.campus_id || '';
            document.getElementById('edit-modal').classList.remove('hidden');
        }
    </script>
    @endpush
</x-app-layout>
