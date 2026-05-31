<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;

class UnboxingVideo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'video_path',
    ];

    public function getVideoUrlAttribute(): ?string
    {
        return MediaUrl::resolvePublic($this->video_path);
    }

    public static function legacyDefaults(): array
    {
        return [
            [
                'video_path' => 'video/MassEffect.mp4',
                'title' => 'Ігровий світ трилогії Mass Effect',
                'description' => 'Поглиблений огляд артбуку: концепт-арт, персонажі та локації з культової космічної саги BioWare.',
            ],
            [
                'video_path' => 'video/DeathStranding.mp4',
                'title' => 'Світ гри Death Stranding 2: On the Beach',
                'description' => 'Ексклюзивний огляд артбуку: унікальна візуальна естетика та арт від Kojima Productions.',
            ],
            [
                'video_path' => 'video/arkrein.mp4',
                'title' => 'Мистецтво й створення серіалу «Аркейн»',
                'description' => 'За лаштунками серіалу: від ескізів до фінальної анімації. Огляд артбуку від Fortiche та Riot.',
            ],
        ];
    }

    public static function syncLegacyDefaults(): void
    {
        foreach (self::legacyDefaults() as $video) {
            self::firstOrCreate(
                ['video_path' => $video['video_path']],
                [
                    'title' => $video['title'],
                    'description' => $video['description'],
                ]
            );
        }
    }
}
