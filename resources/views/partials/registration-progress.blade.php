<ol class="space-y-4" data-testid="registration-progress-timeline">
  @foreach ($steps as $step)
    <li class="flex gap-4 items-start">
      <span
        class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full border text-xs font-bold
          @if ($step['done']) border-neon bg-neon/15 text-neon
          @elseif ($step['current']) border-neon text-neon
          @else border-white/20 text-dim @endif"
        aria-hidden="true"
      >@if ($step['done']) ✓ @else {{ $loop->iteration }} @endif</span>
      <div class="min-w-0 flex-1">
        <p class="text-sm font-medium @if ($step['done'] || $step['current']) text-gray-100 @else text-dim @endif">
          {{ $step['label'] }}
        </p>
        @if ($step['hint'])
          <p class="text-xs text-dim mt-1">{{ $step['hint'] }}</p>
        @endif
      </div>
    </li>
  @endforeach
</ol>
