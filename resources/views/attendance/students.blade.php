<x-app-layout>
    <x-slot name="title">Student Attendance</x-slot>
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Student Attendance</h1><p class="text-sm text-gray-500 mt-1">Mark attendance for class sessions</p></div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Select Class</h3>
            <form id="attendanceForm" class="space-y-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                    <select id="courseSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Course —</option>
                        @foreach($sessionCourses as $sc)<option value="{{ $sc->id }}">{{ $sc->course?->name }} — {{ $sc->section?->name ?? 'No Section' }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Date</label><input type="date" id="dateInput" value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <button type="button" onclick="loadStudents()" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Load Students</button>
            </form>
        </div>
        <div class="lg:col-span-2" id="attendancePanel" style="display:none">
            <form method="POST" action="{{ route('attendance.students.mark') }}" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                @csrf
                <input type="hidden" name="session_course_id" id="hiddenCourse">
                <input type="hidden" name="date" id="hiddenDate">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Mark Attendance</h3>
                    <div class="flex gap-2">
                        <button type="button" onclick="markAll('present')" class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">All Present</button>
                        <button type="button" onclick="markAll('absent')" class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">All Absent</button>
                    </div>
                </div>
                <div id="studentsList" class="divide-y divide-gray-100"></div>
                <div class="px-5 py-4 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Save Attendance</button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
    <script>
    async function loadStudents() {
        const courseId = document.getElementById('courseSelect').value;
        const date = document.getElementById('dateInput').value;
        if (!courseId || !date) { alert('Select course and date'); return; }
        document.getElementById('hiddenCourse').value = courseId;
        document.getElementById('hiddenDate').value = date;
        const res = await fetch(`/attendance/students/list?session_course_id=${courseId}&date=${date}`);
        const students = await res.json();
        const html = students.map(s => `
            <div class="flex items-center justify-between px-5 py-3">
                <div><p class="font-medium text-sm text-gray-900">${s.student_name}</p><p class="text-xs text-gray-400">${s.student_no}</p></div>
                <div class="flex gap-2">
                    ${['present','absent','late','excused'].map(status => `
                        <label class="flex items-center gap-1 cursor-pointer">
                            <input type="radio" name="attendance[${s.student_id}][status]" value="${status}" ${s.status===status?'checked':''} class="student-radio" data-id="${s.student_id}">
                            <span class="text-xs capitalize ${status==='present'?'text-green-600':status==='absent'?'text-red-600':status==='late'?'text-yellow-600':'text-blue-600'}">${status}</span>
                        </label>
                    `).join('')}
                    <input type="hidden" name="attendance[${s.student_id}][student_id]" value="${s.student_id}">
                </div>
            </div>
        `).join('');
        document.getElementById('studentsList').innerHTML = html || '<p class="p-5 text-gray-400 text-sm">No enrolled students found.</p>';
        document.getElementById('attendancePanel').style.display = 'block';
    }
    function markAll(status) {
        document.querySelectorAll(`.student-radio[value="${status}"]`).forEach(r => r.checked = true);
    }
    </script>
    @endpush
</x-app-layout>
