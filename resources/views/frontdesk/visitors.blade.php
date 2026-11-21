<x-app-layout>
    <x-slot name="title">Visitor Log</x-slot>
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-gray-900">Visitor Log</h1></div>
        <div class="flex gap-2">
            @access('enquiries.index')
            <a href="{{ route('enquiries.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Enquiries</a>
            @endaccess
            @access('complaints.index')
            <a href="{{ route('complaints.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Complaints</a>
            @endaccess
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200"><tr><th class="text-left px-5 py-3 font-medium text-gray-600">Visitor</th><th class="text-left px-5 py-3 font-medium text-gray-600">Purpose</th><th class="text-left px-5 py-3 font-medium text-gray-600">Check In</th><th class="text-left px-5 py-3 font-medium text-gray-600">Check Out</th><th class="text-right px-5 py-3 font-medium text-gray-600">Action</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($visitors as $v)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3"><p class="font-medium text-gray-900">{{ $v->name }}</p><p class="text-xs text-gray-400">{{ $v->phone }}</p></td>
                        <td class="px-5 py-3 text-gray-500">{{ $v->purpose?->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $v->check_in->format('d M H:i') }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $v->check_out?->format('d M H:i') ?? '<span class="text-green-600 text-xs">Still Inside</span>' }}</td>
                        <td class="px-5 py-3 text-right">
                            @if(!$v->check_out)
                            @access('visitors.checkout')
                            <form method="POST" action="{{ route('visitors.checkout', $v) }}">@csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">Check Out</button>
                            </form>
                            @endaccess
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">No visitors today.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($visitors->hasPages())<div class="px-5 py-4 border-t">{{ $visitors->links() }}</div>@endif
        </div>
        <div class="space-y-5">
            @access('visitors.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-4">Log Visitor</h3>
                <form method="POST" action="{{ route('visitors.store') }}" class="space-y-3">
                    @csrf
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Name *</label><input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                    <div><label class="block text-xs font-medium text-gray-700 mb-1">Purpose</label>
                        <select name="purpose_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Select —</option>
                            @foreach($purposes as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Log Visitor</button>
                </form>
            </div>
            @endaccess
            @access('visitors.purposes.store')
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Add Purpose</h3>
                <form method="POST" action="{{ route('visitors.purposes.store') }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="e.g. Meeting, Interview" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Add</button>
                </form>
            </div>
            @endaccess
        </div>
    </div>
</x-app-layout>
