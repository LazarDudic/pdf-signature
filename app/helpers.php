<?php
declare(strict_types=1);


if(!function_exists(('setAlert')))
{
    function setAlert(string $message, string $status = 'success', string $title = ''): object
    {
        return (object) [
            'status' => $status,
            'message' => $message,
            'title' => $title
        ];
    }
}
