<?php

namespace App\Models;

use Twilio\Rest\Client;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'last_login_at'
    ];

    public function generateCode()
    {
        $code = rand(1000, 9000);

        UserCode::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['code' => $code]
        );

        $receiverNumber = auth()->user()->phone;
        $message = "Your 2FA Login code is ".$code;

        // SMS Verification
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");

        $client = new Client($account_sid, $auth_token);
        $client->messages->create($receiverNumber, [
                            'from' => $twilio_number,
                            'body' => $message
                            ]);

        // Mail Verification
        /* $details = [
            'title' => 'Mail from Public E-Library',
            'code' => $code
        ];

        Mail::to(auth()->user()->email)->send(new SendCodeMail($details)); */

    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
