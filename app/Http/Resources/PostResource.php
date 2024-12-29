<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    // Membuat properti baru untuk variable status dan message
    public $status;
    public $message;
    /**
     * @param mixed $status
     * @param mixed $message
     * @param mixed $resource
     * @return void
     */

    //  membuat methode baru dengan jenis _construct
    // fungsi ini akan dipanggil pertama kali dijalankan ketika class PostResource dipanggil
    // didalam terdapat 3 variable status, message, dan resource

    public function __construct($status, $message, $resource)
    {
        // Variable 
        parent::__construct($resource);

        $this->status = $status;

        $this->message = $message;
    }

    /**
     * Trans
     * 
     * @param \
     * @return array
     */

    public function toArray($request)
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource
        ];
    }
}
