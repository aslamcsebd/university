<x-app-layout>
    <x-slot name="title">Library Settings</x-slot>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Library Settings</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="max-w-xl bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('library.card-setting.update') }}" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Student Issue Days</label>
                    <input type="number" name="student_issue_days" value="{{ $setting->student_issue_days }}" min="1" max="365" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Staff Issue Days</label>
                    <input type="number" name="staff_issue_days" value="{{ $setting->staff_issue_days }}" min="1" max="365" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Books (Student)</label>
                    <input type="number" name="max_books_student" value="{{ $setting->max_books_student }}" min="1" max="20" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Books (Staff)</label>
                    <input type="number" name="max_books_staff" value="{{ $setting->max_books_staff }}" min="1" max="20" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fine Per Day (৳)</label>
                    <input type="number" name="fine_per_day" value="{{ $setting->fine_per_day }}" min="0" step="0.01" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Fine Per Book (৳)</label>
                    <input type="number" name="max_fine_per_book" value="{{ $setting->max_fine_per_book }}" min="0" step="0.01" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                Save Settings
            </button>
        </form>
    </div>
</x-app-layout>
