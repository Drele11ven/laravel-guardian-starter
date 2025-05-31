<div class="mb-8 p-4 border rounded bg-white shadow-sm">
    <h2 class="text-lg font-semibold mb-4">🪵 مدیریت فایل‌های Log</h2>

    {{-- Select log file --}}
    <form method="GET" class="mb-4">
        <label for="log" class="font-medium">انتخاب فایل لاگ:</label>
        <select name="log" onchange="this.form.submit()" class="ml-2 border px-2 py-1 rounded">
            @foreach($logFiles as $log)
                <option value="{{ $log }}" {{ $selectedLog === $log ? 'selected' : '' }}>{{ $log }}</option>
            @endforeach
        </select>
    </form>

    {{-- Clear log --}}
    <form method="POST" action="{{ route('admin.logs.clear') }}" class="mb-4">
        @csrf
        <input type="hidden" name="log" value="{{ $selectedLog }}">
        <button onclick="return confirm('آیا از پاک کردن فایل لاگ اطمینان دارید؟')"
                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
            پاک‌سازی {{ $selectedLog }}
        </button>
    </form>

    {{-- Log content --}}
    <div class="border rounded p-3 bg-gray-100 overflow-auto max-h-[500px] text-sm font-mono whitespace-pre-wrap leading-relaxed">
        {{ $logContent ?: 'فایل خالی است.' }}
    </div>
</div>
