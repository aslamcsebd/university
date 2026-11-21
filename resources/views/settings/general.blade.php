<x-app-layout>
    <x-slot name="title">General Settings</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
        <p class="text-sm text-gray-500 mt-1">University profile and application configuration</p>
    </div>

    <div class="max-w-3xl">
        @access('settings.general.update')
        <form method="POST" action="{{ route('settings.general.update') }}" enctype="multipart/form-data"
              class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
            @csrf @method('PUT')

            {{-- Logo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">University Logo</label>
                <div class="flex items-center gap-4">
                    @if($university?->logo)
                        <img src="{{ $university->logo_url }}" class="w-16 h-16 object-contain rounded-lg border border-gray-200" alt="Logo">
                    @else
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <input type="file" name="logo" accept="image/png,image/jpg,image/jpeg"
                               class="text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1">PNG or JPG, max 2MB</p>
                    </div>
                </div>
                @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">University Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $university?->name) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Short Name</label>
                    <input type="text" name="short_name" value="{{ old('short_name', $university?->short_name) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $university?->tagline) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $university?->email) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $university?->phone) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="address" rows="2"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $university?->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <input type="url" name="website" value="{{ old('website', $university?->website) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Established Date</label>
                    <input type="date" name="established_at" value="{{ old('established_at', $university?->established_at?->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Timezone <span class="text-red-500">*</span></label>
                    <select name="timezone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(timezone_identifiers_list() as $tz)
                            <option value="{{ $tz }}" {{ old('timezone', $university?->timezone) === $tz ? 'selected' : '' }}>{{ $tz }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Currency <span class="text-red-500">*</span></label>
                    <input type="text" name="currency" value="{{ old('currency', $university?->currency ?? 'USD') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Currency Symbol <span class="text-red-500">*</span></label>
                    <input type="text" name="currency_symbol" value="{{ old('currency_symbol', $university?->currency_symbol ?? '$') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Save Settings
                </button>
            </div>
        </form>
        @endaccess
    </div>
</x-app-layout>
