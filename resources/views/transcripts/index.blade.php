<x-app-layout>
    <x-slot name="title">Transcripts & Certificates</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Transcripts & Certificates</h1></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Generated Documents</h2></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr><th class="text-left px-5 py-2 font-medium text-gray-600">Student</th><th class="text-left px-5 py-2 font-medium text-gray-600">Type</th><th class="text-left px-5 py-2 font-medium text-gray-600">Cert No</th><th class="text-left px-5 py-2 font-medium text-gray-600">Generated</th><th class="text-right px-5 py-2 font-medium text-gray-600">View</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($documents as $doc)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-2 font-medium text-gray-900">{{ $doc->student?->full_name }}<p class="text-xs font-mono text-purple-600">{{ $doc->student?->student_id }}</p></td>
                        <td class="px-5 py-2"><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">{{ ucfirst($doc->document_type) }}</span>@if($doc->is_duplicate)<span class="ml-1 px-2 py-0.5 bg-orange-100 text-orange-700 rounded-full text-xs">Duplicate</span>@endif</td>
                        <td class="px-5 py-2 font-mono text-xs text-gray-600">{{ $doc->certificate_no }}</td>
                        <td class="px-5 py-2 text-gray-500">{{ $doc->generated_at->format('d M Y') }}</td>
                        <td class="px-5 py-2 text-right"><a href="{{ route('transcripts.show', $doc) }}" class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">View</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">No documents yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($documents->hasPages())<div class="px-5 py-4 border-t">{{ $documents->links() }}</div>@endif
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Generate Document</h3>
            <form method="POST" action="{{ route('transcripts.generate') }}" class="space-y-3">
                @csrf
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Student *</label>
                    <select name="student_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select —</option>
                        @foreach($students as $s)<option value="{{ $s->id }}">{{ $s->full_name }} ({{ $s->student_id }})</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                    <select name="document_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="transcript">Full Transcript</option>
                        <option value="marksheet">Semester Marksheet</option>
                        <option value="certificate">Degree Certificate</option>
                        <option value="completion">Completion Certificate</option>
                    </select>
                </div>
                <div><label class="block text-xs font-medium text-gray-700 mb-1">Semester (optional)</label>
                    <select name="semester_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
                    </select>
                </div>
                <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Generate</button>
            </form>
        </div>
    </div>
</x-app-layout>
