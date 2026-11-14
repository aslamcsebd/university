<x-app-layout>
    <x-slot name="title">Complaints</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Complaints</h1></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Complainant</th><th class="text-left px-5 py-3 font-medium text-gray-600">Type</th><th class="text-left px-5 py-3 font-medium text-gray-600">Description</th><th class="text-left px-5 py-3 font-medium text-gray-600">Status</th><th class="text-right px-5 py-3 font-medium text-gray-600">Update</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($complaints as $c)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $c->complainant_name }}</p><p class="text-xs text-gray-400">{{ $c->phone }}</p></td>
                        <td class="px-5 py-3 text-gray-500">{{ $c->type?->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ Str::limit($c->description,60) }}</td>
                        <td class="px-5 py-3">
                            @php $sc=['open'=>'bg-red-100 text-red-700','in_progress'=>'bg-yellow-100 text-yellow-700','resolved'=>'bg-green-100 text-green-700','closed'=>'bg-gray-100 text-gray-600']; @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $sc[$c->status]??'' }}">{{ ucfirst(str_replace('_',' ',$c->status)) }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('complaints.status', $c) }}" class="flex gap-1 justify-end">@csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="border border-gray-200 rounded px-2 py-1 text-xs">
                                    <option value="open" {{ $c->status=='open'?'selected':'' }}>Open</option>
                                    <option value="in_progress" {{ $c->status=='in_progress'?'selected':'' }}>In Progress</option>
                                    <option value="resolved" {{ $c->status=='resolved'?'selected':'' }}>Resolved</option>
                                    <option value="closed" {{ $c->status=='closed'?'selected':'' }}>Closed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">No complaints.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($complaints->hasPages())<div class="px-5 py-4 border-t">{{ $complaints->links() }}</div>@endif
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Log Complaint</h3>
            <form method="POST" action="{{ route('complaints.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Name *</label><input type="text" name="complainant_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                    <select name="type_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Optional —</option>
                        @foreach($types as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Description *</label><textarea name="description" required rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Log Complaint</button>
            </form>
        </div>
    </div>
</x-app-layout>
