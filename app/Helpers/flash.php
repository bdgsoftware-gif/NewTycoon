<?php

if (!function_exists('flash')) {
    function flash($message, $type = 'success', $duration = 5000, $description = null)
    {
        session()->flash('flash_message', [
            'message' => $message,
            'type' => $type,
            'duration' => $duration,
            'description' => $description,
        ]);
    }
}

if (!function_exists('flash_to_session')) {
    function flash_to_session($message, $type = 'success', $duration = 5000, $description = null)
    {
        session()->flash('flash_message', [
            'message' => $message,
            'type' => $type,
            'duration' => $duration,
            'description' => $description,
        ]);
    }
}
