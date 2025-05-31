@php
    use App\Models\ActivityLog;
    $logs = ActivityLog::with('user')->latest()->get();
@endphp

<table class="table-auto w-full border border-gray-300 text-sm text-left">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">User</th>
            <th class="px-4 py-2 border">Action</th>
            <th class="px-4 py-2 border">Method</th>
            <th class="px-4 py-2 border">URL</th>
            <th class="px-4 py-2 border">Referer URL</th>
            <th class="px-4 py-2 border">IP Address</th>
            <th class="px-4 py-2 border">User Agent</th>
            <th class="px-4 py-2 border">Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border">
                    {{ $log->user->name ?? 'Guest' }}
                </td>
                <td class="px-4 py-2 border action-cell" data-tooltip="{{ $log->action }}">
                    {{ \Illuminate\Support\Str::limit($log->action, 35) }}
                </td>
                <td class="px-4 py-2 border">
                    {{ $log->method }}
                </td>
                <td class="px-4 py-2 border text-blue-600">
                    <a href="{{ $log->url }}" target="_blank" title="{{ $log->url }}">{{ $log->url }}</a>
                </td>
                <td class="px-4 py-2 border text-blue-500">
                    @if ($log->referer_url)
                        <a href="{{ $log->referer_url }}" target="_blank" title="{{ $log->referer_url }}">{{ \Illuminate\Support\Str::limit($log->referer_url, 35) }}</a>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-4 py-2 border">
                    {{ $log->ip_address }}
                </td>
                <td class="px-4 py-2 border truncate max-w-xs" data-tooltip="{{ $log->user_agent }}">
                    {{ \Illuminate\Support\Str::limit($log->user_agent, 20) }}
                </td>
                <td class="px-4 py-2 border">
                    {{ $log->created_at->diffForHumans() }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Tooltip Style -->
<style>
    .tooltip {
        position: fixed; /* Use fixed positioning to stay in view even when scrolling */
        background-color: rgba(0, 0, 0, 0.75);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        font-size: 14px;
        display: none;
        white-space: nowrap;
        z-index: 1000;
        transition: opacity 0.3s ease;
        max-width: 80%;
        word-wrap: break-word;
    }
</style>

<!-- Tooltip JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltips = document.querySelectorAll('[data-tooltip]');
        const tooltipElement = document.createElement('div');
        tooltipElement.classList.add('tooltip');
        document.body.appendChild(tooltipElement);

        tooltips.forEach(element => {
            element.addEventListener('mouseover', function () {
                tooltipElement.textContent = element.getAttribute('data-tooltip');

                // Calculate the position relative to the viewport (with scroll offset)
                const rect = element.getBoundingClientRect();
                const tooltipWidth = tooltipElement.offsetWidth;
                const tooltipHeight = tooltipElement.offsetHeight;

                // Center the tooltip relative to the viewport (both vertically and horizontally)
                const leftPosition = (window.innerWidth - tooltipWidth) / 2;
                const topPosition = (window.innerHeight - tooltipHeight) / 2;

                tooltipElement.style.left = `${leftPosition}px`; // Center horizontally
                tooltipElement.style.top = `${topPosition}px`;  // Center vertically

                tooltipElement.style.display = 'block';
                tooltipElement.style.opacity = 1;
            });

            element.addEventListener('mouseout', function () {
                tooltipElement.style.display = 'none';
            });

            // Click to copy text to clipboard
            element.addEventListener('click', function () {
                const fullText = element.getAttribute('data-tooltip');
                copyToClipboard(fullText);
            });
        });

        // Function to copy text to clipboard
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            // Optional: Show an alert or feedback for copy action
            alert('Copied to clipboard!');
        }
    });
</script>
