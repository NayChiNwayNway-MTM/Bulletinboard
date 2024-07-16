<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostsExport implements FromCollection, WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Post::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'description',
            'status',
            'created_user_id',
            'updated_user_id',
            'deleted_user_id',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
    }
    public function map($post): array
    {
        return [
            $post->id,
            $post->title,
            $post->description,
            $post->status == 1 ? 'Active' : 'Inactive',
            $post->created_user_id,
            $post->updated_user_id,
            $post->deleted_user_id,
            $post->created_at,
            $post->updated_at,
            $post->deleted_at,
        ];
    }
}
