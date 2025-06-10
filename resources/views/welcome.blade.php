@php
    header('Content-Type: application/json');
    echo json_encode([
        'message' => 'Route is not found or you are not authorized to access this resource.',
    ]);
    exit;
@endphp
