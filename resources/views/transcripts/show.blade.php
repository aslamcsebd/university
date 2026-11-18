<x-app-layout>
    <x-slot name="title">{{ ucfirst($document->document_type) }}</x-slot>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('transcripts.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <h1 class="text-2xl font-bold text-gray-900">{{ ucfirst($document->document_type) }}</h1>
        <span class="font-mono text-sm text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $document->certificate_no }}</span>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-8 max-w-4xl">
        <div class="text-center border-b border-gray-200 pb-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900">{{ \App\Models\Setting::get('general.university_name','University') }}</h2>
            <p class="text-gray-500 mt-1">Academic {{ ucfirst($document->document_type) }}</p>
            @if($document->is_duplicate)<p class="text-orange-600 font-semibold mt-1 text-sm">*** DUPLICATE COPY ***</p>@endif
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div><p class="text-gray-500 text-xs">Student Name</p><p class="font-semibold">{{ $document->student?->full_name }}</p></div>
            <div><p class="text-gray-500 text-xs">Student ID</p><p class="font-mono font-semibold text-purple-600">{{ $document->student?->student_id }}</p></div>
            <div><p class="text-gray-500 text-xs">Program</p><p class="font-semibold">{{ $document->student?->program?->name }}</p></div>
            <div><p class="text-gray-500 text-xs">Batch</p><p class="font-semibold">{{ $document->student?->batch?->name }}</p></div>
        </div>
        @if($results->count())
        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden mb-4">
            <thead class="bg-gray-50"><tr><th class="text-left px-4 py-2 font-medium text-gray-600">Course</th><th class="text-center px-4 py-2 font-medium text-gray-600">Credits</th><th class="text-center px-4 py-2 font-medium text-gray-600">Marks</th><th class="text-center px-4 py-2 font-medium text-gray-600">%</th><th class="text-center px-4 py-2 font-medium text-gray-600">Grade</th><th class="text-center px-4 py-2 font-medium text-gray-600">GPA</th><th class="text-center px-4 py-2 font-medium text-gray-600">Pass</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($results as $r)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-gray-700">{{ $r->sessionCourse?->course?->name }}</td>
                    <td class="px-4 py-2 text-center text-gray-600">{{ $r->credit_hours }}</td>
                    <td class="px-4 py-2 text-center text-gray-600">{{ $r->obtained_marks }}/{{ $r->total_marks }}</td>
                    <td class="px-4 py-2 text-center text-gray-700">{{ number_format($r->percentage,1) }}%</td>
                    <td class="px-4 py-2 text-center font-bold text-blue-700">{{ $r->letter_grade ?? '—' }}</td>
                    <td class="px-4 py-2 text-center text-gray-700">{{ $r->gpa_point }}</td>
                    <td class="px-4 py-2 text-center"><span class="px-1.5 py-0.5 rounded-full text-xs {{ $r->is_pass?'bg-green-100 text-green-700':'bg-red-100 text-red-700' }}">{{ $r->is_pass?'Pass':'Fail' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @foreach($summary as $s)
        <div class="p-4 bg-blue-50 rounded-lg flex gap-8 text-sm">
            <div><p class="text-gray-500 text-xs">Semester GPA</p><p class="font-bold text-xl text-blue-700">{{ $s->semester_gpa }}</p></div>
            <div><p class="text-gray-500 text-xs">CGPA</p><p class="font-bold text-xl text-green-700">{{ $s->cgpa }}</p></div>
            <div><p class="text-gray-500 text-xs">Credits Earned</p><p class="font-bold text-xl text-gray-900">{{ $s->total_credits_earned }}</p></div>
        </div>
        @endforeach
        @else
        <div class="text-center py-10 text-gray-400">No published results available for this document.</div>
        @endif
        <div class="mt-8 pt-4 border-t border-gray-200 text-center text-xs text-gray-400">
            Generated on {{ $document->generated_at->format('d M Y H:i') }} · Certificate No: {{ $document->certificate_no }}
        </div>
    </div>
</x-app-layout>
