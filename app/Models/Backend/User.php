<?php

namespace App\Models\Backend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\Backend\AdminResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    
    public static function boot()
    {
        parent::boot();

        // create a event to happen on updating
        static::updating(function($model){
            $user = Auth::guard('admin')->user();
            $model->updated_by = $user ? $user->username : 'master';
        });
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Backend\User\Profile');
    }

    public function hasProfile()
    {
        return $this->profile()->exists();
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Backend\User\Role');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Backend\User\Status');
    }

    public function historyDelete()
    {
        $this->notifications()->forceDelete();
        $this->profile()->forceDelete();
        return $this->forceDelete();
    }

    public function approve()
    {
        return $this->update([
            'status_id' => 4
        ]);
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Product\Review\Reply');
    }

    public function message_replies()
    {
        return $this->hasMany('App\Models\Frontend\Messages\Replies');
    }

    public function name()
    {
        return $this->fname.' '.$this->lname;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'username', 'password', 'role_id', 'status_id', 'verify_token', 'updated_by', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

}
