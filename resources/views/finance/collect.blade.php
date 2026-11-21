<x-app-layout>
    <x-slot name="title">Collect Payment</x-slot>
    <div class="flex items-center gap-3 mb-6">
        @access('payments.index')
        <a href="{{ route('payments.index') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        @endaccess
        <h1 class="text-2xl font-bold text-gray-900">Collect Payment</h1>
    </div>
    <div class="max-w-2xl">
        @access('payments.store')
        <form method="POST" action="{{ route('payments.store') }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Fee Assignment <span class="text-red-500">*</span></label>
                <select name="fee_assignment_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Select Fee Assignment —</option>
                    @foreach($assignments as $a)
                    <option value="{{ $a->id }}" {{ request('assignment')==$a->id?'selected':'' }}>
                        {{ $a->student?->full_name }} ({{ $a->student?->student_id }}) — {{ $a->feeType?->name }} — Outstanding: {{ number_format($a->outstanding,2) }}
                    </option>
                    @endforeach
                </select>
                @error('fee_assignment_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Amount <span class="text-red-500">*</span></label><input type="number" name="amount" required min="0.01" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">@error('amount')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Payment Method <span class="text-red-500">*</span></label>
                <select name="payment_method" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="online">Online</option>
                    <option value="cheque">Cheque</option>
                </select>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Transaction Reference</label><input type="text" name="transaction_ref" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><p class="text-xs text-gray-400 mt-1">Required for bank transfer and cheque</p></div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Collect & Generate Receipt</button>
                @access('payments.index')
                <a href="{{ route('payments.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
                @endaccess
            </div>
        </form>
                @endaccess
    </div>
</x-app-layout>
