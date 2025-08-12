<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Notifications\VerifyEmails;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotifcation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles' => 'array',
        'hire_date' => 'date',
        'birth_date' => 'date',
        'last_login_at' => 'datetime',
        'preferences' => 'array',
        'commission_percentage' => 'decimal:2',
    ];

    /**
     * Get the transactions for the user
     *
     *
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * set the user's name
     *
     * @param  string $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }

    /**
     * set the user's username
     *
     * @param  string $value
     * @return void
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    /**
     * get the user's complete profile with custom property
     *
     * @return bool
     */
    public function getIsCompleteProfileAttribute()
    {
        return $this->phone && $this->address;
    }

    /**
     * Get the user's roles as array (handles string to array conversion)
     *
     * @return array
     */
    public function getRolesArrayAttribute()
    {
        return is_array($this->roles) ? $this->roles : json_decode($this->roles, true) ?? [];
    }

    /**
     * get the user's avatar with custom directory path
     *
     * @return mixed
     */
    public function getAvatar()
    {
        return ($this->avatar) ? asset("/storage/$this->avatar") : 'https://ui-avatars.com/api/?name=' . Str::of($this->name)->replace(' ', '+') . '&rounded=true' . '&bold=true';
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmails);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotifcation($token));
    }

    /**
     * Get the user's avatar only for admin panel (user who has admin or staff role).
     *
     * @return string
     */
    public function getFilamentAvatarUrl(): ?string
    {
        // return $this->avatar;
        return $this->avatar ? asset("/storage/$this->avatar") : null;
    }

    /**
     * Authenticate user to admin panel - Filament v3.
     *
     * @return bool
     */
    public function canAccessPanel($panel): bool
    {
        return checkRoles(["ADMIN", "VENDEDOR", 1], $this->roles_array) && $this->status === 'ACTIVE';
    }

    /**
     * Authenticate user to admin panel - Legacy compatibility.
     *
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        return $this->canAccessPanel(null);
    }

    /**
     * Check if user has admin role
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array('ADMIN', $this->roles_array);
    }

    /**
     * Check if user has seller role
     *
     * @return bool
     */
    public function isVendedor(): bool
    {
        return in_array('VENDEDOR', $this->roles_array);
    }

    /**
     * Check if user has client role
     *
     * @return bool
     */
    public function isCliente(): bool
    {
        return in_array('CLIENTE', $this->roles_array);
    }

    /**
     * Get the admin assigned to this seller
     */
    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }

    /**
     * Get sellers assigned to this admin
     */
    public function assignedSellers()
    {
        return $this->hasMany(User::class, 'assigned_admin_id');
    }

    /**
     * Get user's preferences as array
     *
     * @return array
     */
    public function getPreferencesArrayAttribute()
    {
        return is_array($this->preferences) ? $this->preferences : json_decode($this->preferences, true) ?? [];
    }

    /**
     * Get formatted commission percentage
     *
     * @return string
     */
    public function getFormattedCommissionAttribute()
    {
        return $this->commission_percentage ? $this->commission_percentage . '%' : 'N/A';
    }

    /**
     * Get display role name in Spanish
     *
     * @return string
     */
    public function getDisplayRoleAttribute()
    {
        $primaryRole = $this->roles_array[0] ?? 'CLIENTE';
        
        $roleNames = [
            'ADMIN' => 'Administrador',
            'VENDEDOR' => 'Vendedor',
            'CLIENTE' => 'Cliente',
            'MEMBER' => 'Cliente', // Legacy compatibility
        ];
        
        return $roleNames[$primaryRole] ?? 'Cliente';
    }
}
