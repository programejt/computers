<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $table = 'computers as c';
    public const PHOTO_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    public static function get(?int $computerId = null) {
      $query = self::select(
        'c.id as id',
        'c.name as name',
        'u.id as user_id',
        'u.name as user_name'
      )->join('users as u', 'u.id', '=', 'user_id');

      if ($computerId) {
        return $query->where('c.id', $computerId)->first();
      }

      return $query->get();
    }

    public static function getPhotoPath(int $computerId): string {
      return 'images/computers/'.$computerId;
    }

    public function getPhoto(): ?string {
      $path = self::getPhotoPath($this->id);
      foreach (self::PHOTO_EXTENSIONS as $ext) {
        $photo = $path.'/photo.'.$ext;
        if (file_exists($photo)) {
          return $photo;
        }
      }

      return null;
    }

    // public static function isOwner(): bool {
    //   return Auth::id() === $this->user_id;
    // }
}
