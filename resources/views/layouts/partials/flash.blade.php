@php
    /**
     * Global flash notifications.
     * Supports common keys: success, error, warning, info, status.
     */
    $flashMap = [
        'success' => 'success',
        'status' => 'success',
        'error' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
    ];

    $flashMessages = [];
    foreach ($flashMap as $key => $bootstrapType) {
        if (session()->has($key) && filled(session($key))) {
            $flashMessages[] = [
                'type' => $bootstrapType,
                'message' => session($key),
            ];
        }
    }

    if ($errors->any()) {
        $flashMessages[] = [
            'type' => 'danger',
            'message' => $errors->first(),
        ];
    }
@endphp

@if(count($flashMessages))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080; max-width: 420px;">
        @foreach($flashMessages as $item)
            <div class="alert alert-{{ $item['type'] }} text-white alert-dismissible fade show mb-2" role="alert" data-flash-autohide>
                <span class="alert-text">{{ $item['message'] }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    </div>
@endif
