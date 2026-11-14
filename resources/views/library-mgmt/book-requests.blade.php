<x-app-layout>
    <x-slot name="title">Book Requests</x-slot>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Book Requests</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">New Request</h3>
            <form method="POST" action="{{ route('library.book-requests.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Member *</label>
                    <select name="member_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select member</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->member_no }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Book Title *</label>
                    <input type="text" name="book_title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Author</label>
                    <input type="text" name="author" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Reason</label>
                    <textarea name="reason" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Submit Request</button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Book Title</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Member</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Date</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($requests as $req)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $req->book_title }}</div>
                            @if($req->author)<div class="text-xs text-gray-400">{{ $req->author }}</div>@endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $req->member->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $req->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $req->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : ($req->status === 'approved' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700') }}">
                                {{ ucfirst($req->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($req->status === 'pending')
                            <div class="flex justify-end gap-1">
                                <form method="POST" action="{{ route('library.book-requests.status', $req) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('library.book-requests.status', $req) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">Reject</button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t border-gray-100">{{ $requests->links() }}</div>
        </div>
    </div>
</x-app-layout>
