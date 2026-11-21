<x-app-layout>
    <x-slot name="title">Enquiries</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Enquiries</h1></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100">
                <form method="GET" class="flex gap-3">
                    <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="new" {{ request('status')=='new'?'selected':'' }}>New</option>
                        <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>In Progress</option>
                        <option value="converted" {{ request('status')=='converted'?'selected':'' }}>Converted</option>
                        <option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option>
                    </select>
                </form>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Name</th><th class="text-left px-5 py-3 font-medium text-gray-600">Program</th><th class="text-left px-5 py-3 font-medium text-gray-600">Source</th><th class="text-left px-5 py-3 font-medium text-gray-600">Status</th><th class="text-right px-5 py-3 font-medium text-gray-600">Update</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($enquiries as $e)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $e->name }}</p><p class="text-xs text-gray-400">{{ $e->phone }}</p></td>
                        <td class="px-5 py-3 text-gray-500">{{ $e->program?->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $e->source?->name ?? '—' }}</td>
                        <td class="px-5 py-3">
                            @php $sc=['new'=>'bg-blue-100 text-blue-700','in_progress'=>'bg-yellow-100 text-yellow-700','converted'=>'bg-green-100 text-green-700','closed'=>'bg-gray-100 text-gray-600']; @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $sc[$e->status]??'' }}">{{ ucfirst(str_replace('_',' ',$e->status)) }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            @access('enquiries.status')
                            <form method="POST" action="{{ route('enquiries.status', $e) }}" class="flex gap-1 justify-end">@csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="border border-gray-200 rounded px-2 py-1 text-xs">
                                    <option value="new" {{ $e->status=='new'?'selected':'' }}>New</option>
                                    <option value="in_progress" {{ $e->status=='in_progress'?'selected':'' }}>In Progress</option>
                                    <option value="converted" {{ $e->status=='converted'?'selected':'' }}>Converted</option>
                                    <option value="closed" {{ $e->status=='closed'?'selected':'' }}>Closed</option>
                                </select>
                            </form>
                            @endaccess
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">No enquiries.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($enquiries->hasPages())<div class="px-5 py-4 border-t">{{ $enquiries->links() }}</div>@endif
        </div>
        @access('enquiries.store')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Log Enquiry</h3>
            <form method="POST" action="{{ route('enquiries.store') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Name *</label><input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Program Interest</label>
                    <select name="program_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Optional —</option>
                        @foreach($programs as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Source</label>
                    <select name="source_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Optional —</option>
                        @foreach($sources as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Notes</label><textarea name="notes" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea></div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Log Enquiry</button>
            </form>
        </div>
        @endaccess
    </div>
</x-app-layout>
