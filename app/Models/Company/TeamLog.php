<?php

namespace App\Models\Company;

use App\Helpers\LogHelper;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamLog extends Model
{
    protected $table = 'team_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'action',
        'objects',
        'author_id',
        'author_name',
        'audited_at',
        'ip_address',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'audited_at',
    ];

    /**
     * Get the team record associated with the team log.
     *
     * @return BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the author record associated with the employee log.
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Transform the object to an array representing this object.
     *
     * @return array
     */
    public function toObject(): array
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'objects' => json_decode($this->objects),
            'localized_content' => $this->content,
            'author' => [
                'id' => is_null($this->author) ? null : $this->author->id,
                'name' => is_null($this->author) ? $this->author_name : $this->author->name,
            ],
            'localized_audited_at' => $this->date,
            'audited_at' => $this->audited_at,
        ];
    }

    /**
     * Get the JSON object.
     *
     * @param mixed $value
     *
     * @return array
     */
    public function getObjectAttribute($value)
    {
        return json_decode($this->objects);
    }

    /**
     * Get the date of the team log.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function getDateAttribute($value): string
    {
        return DateHelper::formatShortDateWithTime($this->audited_at);
    }

    /**
     * Get the content of the team log, if defined.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function getContentAttribute($value): string
    {
        return LogHelper::processTeamLog($this);
    }
}
