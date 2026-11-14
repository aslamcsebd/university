<x-app-layout>
    <x-slot name="title">Transport Staff</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Transport Staff</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $allocations->total() }} allocations</p>
        </div>
        <button onclick="document.getElementById('add-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Allocate
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Staff</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Route</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Boarding Stop</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Start Date</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($allocations as $alloc)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">
                        {{ $alloc->person ? $alloc->person->first_name . ' ' . $alloc->person->last_name : 'ID: ' . $alloc->person_id }}
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $alloc->route->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $alloc->stop?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $alloc->start_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $alloc->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $alloc->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        @if($alloc->is_active)
                        <form method="POST" action="{{ route('transport.allocations.deactivate', $alloc) }}" onsubmit="return confirm('Deactivate?')">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-3 py-1 bg-orange-500 text-white rounded text-xs hover:bg-orange-600">Deactivate</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No staff transport allocations yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $allocations->links() }}</div>
    </div>

    <div id="add-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-bold text-gray-900 mb-4">Allocate Staff Transport</h3>
            <form method="POST" action="{{ route('transport.allocations.store') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="person_type" value="staff">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Staff *</label>
                    <select name="person_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select staff</option>
                        @foreach($staffList as $s)
                            <option value="{{ $s->id }}">{{ $s->first_name }} {{ $s->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Route *</label>
                    <select name="route_id" id="route-select-s" required onchange="loadStopsS(this.value)"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select route</option>
                        @foreach($routes as $r)
                            <option value="{{ $r->id }}" data-stops="{{ json_encode($r->stops) }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Boarding Stop</label>
                    <select name="stop_id" id="stop-select-s" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select stop</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Start Date *</label>
                    <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Allocate</button>
                    <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function loadStopsS(routeId) {
            const sel = document.getElementById('route-select-s');
            const opt = sel.options[sel.selectedIndex];
            const stops = opt ? JSON.parse(opt.dataset.stops || '[]') : [];
            const stopSel = document.getElementById('stop-select-s');
            stopSel.innerHTML = '<option value="">Select stop</option>';
            stops.forEach(s => {
                stopSel.innerHTML += `<option value="${s.id}">${s.name}</option>`;
            });
        }
    </script>
    @endpush
</x-app-layout>
